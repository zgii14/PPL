<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketLaundry;
use App\Models\Pembayaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\models\Riwayat;

class PesananController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        $userRole = auth()->user()->role;
    
        // Jika yang mengakses adalah admin
        if ($userRole === 'admin') {
            // Admin bisa melihat semua pesanan yang sudah selesai (status 6) dan pembayaran berhasil
            $pesanan = Pesanan::with(['paket', 'user'])
                ->where('status', 6) // Hanya pesanan yang sudah selesai
                ->whereHas('pembayaran', function ($query) {
                    $query->where('status', 'berhasil'); // Hanya pembayaran yang berhasil
                })
                ->paginate(10);
        } elseif ($userRole === 'staff') {
            // Jika yang mengakses adalah staff, bisa melihat semua pesanan dengan keterangan apapun
            $pesanan = Pesanan::with(['paket', 'user'])
                ->paginate(10); // Staff dapat melihat semua pesanan tanpa batasan keterangan
        } elseif ($userRole === 'kurir') {
            // Jika yang mengakses adalah kurir, hanya bisa melihat pesanan yang tidak memiliki keterangan "Diambil Sendiri"
            $pesanan = Pesanan::with(['paket', 'user'])
                ->where('keterangan', '!=', 'Diambil Sendiri') // Exclude pesanan dengan keterangan "Diambil Sendiri"
                ->paginate(10); // Pesanan selain "Diambil Sendiri"
        } else {
            // Untuk selain admin, staff, atau kurir, hanya bisa melihat pesanan mereka sendiri
            $pesanan = Pesanan::with(['paket', 'user'])
                ->where('user_id', auth()->id()) // Pesanan milik pengguna yang login
                ->paginate(10); // Pesanan milik user yang login
        }
    
        // Mengirimkan data pesanan ke tampilan (view)
        return view('pesanan.index', compact('pesanan'));
    }
    




    // Menampilkan form pembuatan pesanan
    public function create()
{
    // Fetch all available packages
    $paket = PaketLaundry::all();

    // Fetch users excluding admin, staff, and kurir roles
    $users = User::whereNotIn('role', ['admin', 'staff', 'kurir'])->get();

    // If the logged-in user is a kurir, deny access to the create page
    if (auth()->user()->role === 'kurir') {
        abort(403, 'Kurir tidak diizinkan untuk membuat pesanan.');
    }

    // Render the create view with the available packages and users
    return view('pesanan.create', compact('paket', 'users'));
}


    // Menyimpan pesanan ke database
    public function store(Request $request)
    {
        // Validasi awal untuk tipe form
        $request->validate([
            'tipe' => 'required|in:select,create', // Validate tipe (either select or create)
        ]);
    
        // Validasi berdasarkan tipe (select atau create)
        if ($request->tipe == 'select') {
            // Validasi untuk pemilihan user yang sudah ada
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
        } elseif ($request->tipe == 'create') {
            // Validasi untuk form pembuatan user baru
            $request->validate([
                'new_user_name' => 'required|alpha_num|unique:users,name',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);
        }
    
        // Validasi untuk data pesanan
        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'jumlah' => 'nullable|numeric|min:0.1',
            'keterangan' => 'required|in:Diantar,Diambil,Diambil Sendiri', // Validasi untuk keterangan (Dijemput/Diambil)
        ]);
    
        // Handle pembuatan user baru atau penggunaan user yang dipilih
        if ($request->tipe == 'create') {
            // Menyaring nama user yang baru
            $sanitized_user_name = preg_replace('/[^a-zA-Z0-9_]/', '', $request->new_user_name);
    
            // Membuat user baru
            $user = User::create([
                'name' => $sanitized_user_name,
                'email' => strtolower($sanitized_user_name) . '@lubis.com', // Email dihasilkan dari nama
                'password' => bcrypt($sanitized_user_name), // Password default
            ]);
        } else {
            // Menggunakan user yang sudah ada
            $user = User::findOrFail($request->user_id);
        }
    
        // Cek apakah role user adalah kurir, jika ya, batalkan dan kirimkan error
        if (auth()->user()->role === 'kurir') {
            abort(403, 'Kurir tidak diizinkan untuk membuat pesanan.');
        }
    
        // Menemukan paket laundry yang dipilih
        $paket = PaketLaundry::findOrFail($request->paket_id);
    
        // Membuat pesanan
        $pesanan = Pesanan::create([
            'paket_id' => $request->paket_id,
            'user_id' => $user->id, // Menggunakan ID user (yang sudah ada atau baru)
            'jumlah' => $request->jumlah,
            'total_harga' => $paket->harga * $request->jumlah, // Menghitung harga total
            'status' => 0, // Status awal: Pending
            'latitude' => $request->latitude * 1000000, // Menyimpan dalam mikro-derajat
            'longitude' => $request->longitude * 1000000, // Menyimpan dalam mikro-derajat
            'keterangan' => $request->keterangan, // Menyimpan keterangan yang dipilih (Dijemput atau Diambil)
        ]);
    
        // Membuat record pembayaran
        Pembayaran::firstOrCreate([
            'pesanan_id' => $pesanan->id,
            'status' => 'proses', // Status pembayaran default
        ], [
            'nominal' => $pesanan->total_harga,  // Menetapkan nominal pembayaran berdasarkan harga pesanan
            'metode_pembayaran' => null, // Metode pembayaran (bisa disesuaikan nanti)
            'bukti_bayar' => null, // Bukti bayar (kosongkan pada awalnya)
        ]);
    
        // Redirect ke halaman daftar pesanan dengan pesan sukses
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }

        public function show($id)
    {
        // Mengambil data pesanan beserta paket dan user terkait
        $pesanan = Pesanan::with(['paket', 'user'])->findOrFail($id);
    
        // Mengirim data pesanan dan waktu gabungan ke view
        return view('pesanan.show', compact('pesanan'));
    }
    
    
    


    // Menampilkan form edit pesanan
    public function edit($id)
    {
        // Ambil pesanan yang sesuai dengan ID
        $pesanan = Pesanan::findOrFail($id);
        
        // Mengonversi latitude dan longitude kembali ke format desimal
        $latitude = $pesanan->latitude / 1000000;  // Mengembalikan nilai latitude ke format desimal
        $longitude = $pesanan->longitude / 1000000; // Mengembalikan nilai longitude ke format desimal
        
        // Ambil data paket laundry dan pengguna
        $paket = PaketLaundry::all();
        $users = User::all();
        
        // Kirim data ke view, termasuk nilai latitude dan longitude yang sudah dikonversi
        return view('pesanan.edit', compact('pesanan', 'paket', 'users', 'latitude', 'longitude'));
    }
    
    // Memperbarui pesanan
    public function update(Request $request, $id)
{
    $request->validate([
        'paket_id' => 'required|exists:paket_laundry,id',
        'jumlah' => 'nullable|numeric|min:0.1',
        'user_id' => 'required|exists:users,id',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'keterangan' => 'required|in:Diantar,Diambil,Diambil Sendiri', // Validasi untuk keterangan
    ]);

    $pesanan = Pesanan::findOrFail($id);
    $paket = PaketLaundry::findOrFail($request->paket_id);

    // Update pesanan with new data including 'keterangan'
    $pesanan->update([
        'paket_id' => $request->paket_id,
        'user_id' => $request->user_id,
        'jumlah' => $request->jumlah,
        'total_harga' => $paket->harga * $request->jumlah,
        'latitude' => round($request->latitude * 1000000),
        'longitude' => round($request->longitude * 1000000),
        'keterangan' => $request->keterangan, // Update keterangan
    ]);

    return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
}

public function updateJumlah(Request $request, $id)
{
    $pesanan = Pesanan::findOrFail($id);

    // Validasi input jumlah
    $request->validate([
        'jumlah' => 'required|numeric|min:1',
    ]);

    // Hitung total harga baru
    $jumlah = $request->input('jumlah');
    $totalHarga = $jumlah * $pesanan->paket->harga;

    // Update jumlah dan total harga
    $pesanan->update([
        'jumlah' => $jumlah,
        'total_harga' => $totalHarga,
    ]);

    return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui');
}


    // Menghapus pesanan
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    // Update Status Pesanan (Berpindah ke Status Berikutnya)
   // Update Status Pesanan (Berpindah ke Status Berikutnya)
   public function updateStatus(Request $request, $id)
{
    // Validasi status yang diminta
    $request->validate([
        'status' => 'required|in:1,2,3,4,5,6', // All possible statuses
    ]);

    // Temukan pesanan berdasarkan ID
    $pesanan = Pesanan::findOrFail($id);

    // Mendapatkan role dari pengguna yang sedang login
    $userRole = auth()->user()->role;

    if ($userRole === 'kurir') {
        // Rules for Kurir
        if ($pesanan->status == 6) {
            return redirect()->back()->with(
                'error',
                'Pesanan sudah selesai. Status tidak dapat diubah oleh kurir.'
            );
        }

        if (($pesanan->status == 2 && $request->status != 5) ||
            ($pesanan->status == 5 && $request->status != 2)) {
            return redirect()->back()->with(
                'error',
                'Kurir hanya dapat mengubah status antara Penjemputan dan Pengantaran.'
            );
        }
    } elseif ($userRole === 'staff') {
        // Rules for Staff: Allow staff to change status to any status
        // No additional validation is needed for staff.
    } elseif ($userRole === 'admin') {
        // Admin rules can stay the same (or implement specific admin logic if needed)
        if ($pesanan->status == 6 && $request->status == 6) {
            return redirect()->back()->with(
                'error',
                'Status pesanan sudah selesai. Admin tidak dapat mengubah status ke Selesai lagi.'
            );
        }
    }

    // Update status pesanan dengan status baru
    $pesanan->status = $request->status;
    $pesanan->save();

    return redirect()->route('pesanan.index')->with(
        'success',
        'Status pesanan berhasil diperbarui menjadi ' . $this->getStatusName($pesanan->status) . '.'
    );
}

   

    
    /**
     * Helper untuk mendapatkan nama status berdasarkan kode status
     */
    protected function getStatusName($status)
    {
        $statusNames = [
            1 => 'Proses',
            2 => 'Dijemput',
            3 => 'Cuci',
            4 => 'Lipat',
            5 => 'Diantar',
            6 => 'Selesai',
        ];
    
        return $statusNames[$status] ?? 'Tidak Diketahui';
    }
    

    // Konfirmasi Pembayaran
    public function showAccPaymentForm($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status == 6) {
            return redirect()->route('pesanan.index')->with('error', 'Status pembayaran sudah berhasil');
        }

        return view('pesanan.acc_payment', compact('pesanan'));
    }

    public function accPayment(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:transfer,cash',
            'bukti_bayar' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',  // File validation rules
        ]);
    
        $pesanan = Pesanan::findOrFail($id);  // Find the order by its ID
    
        // Handle the file upload and store the file path
        $filePath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');  // Save the file in 'storage/app/public/bukti_bayar' directory

        // Create or update the payment record
        $pembayaran = Pembayaran::where('pesanan_id', $pesanan->id)
        ->where('status', 'proses') // Ensure we're updating a "proses" payment status
        ->first();  // Find the existing record

    if ($pembayaran) {
        // If Pembayaran exists, update it
        $pembayaran->update([
            'nominal' => $pesanan->total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_bayar' => $filePath,  // Save the file path in the database
            'status' => 'berhasil',  // Set payment status to 'berhasil'
        ]);
    } else {
        // If Pembayaran doesn't exist, create a new one
        $pembayaran = Pembayaran::create([
            'pesanan_id' => $pesanan->id,
            'nominal' => $pesanan->total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_bayar' => $filePath,  // Save the file path in the database
            'status' => 'berhasil',  // Set payment status to 'berhasil'
        ]);
    }
    
        // Optionally, update the order status (if needed)
        // $pesanan->status = 6;  // Set status to "Selesai" (complete)
        $pesanan->save();  // Save the updated order
    
        return redirect()->route('pesanan.index')->with('success', 'Pembayaran berhasil diterima dan pesanan selesai.');
    }
    

    // Mengembalikan ke status sebelumnya (opsional)
    public function downgradeStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($pesanan->status > 0) {
            $pesanan->status -= 1;
            $pesanan->save();

            return redirect()->back()->with('success', 'Status pesanan dikembalikan ke tahap sebelumnya.');
        }

        return redirect()->back()->with('error', 'Status pesanan sudah pada tahap awal, tidak dapat dikurangi.');
    }
    public function cetakPdf($id)
    {
    // Ambil data pesanan berdasarkan ID
    $pesanan = Pesanan::with('paket')->findOrFail($id);

    // Buat PDF dari view 'pesanan.cetak_pdf'
    $pdf = PDF::loadView('pesanan.cetak_pdf', compact('pesanan'));

    // Unduh PDF dengan nama file sesuai ID pesanan
   return $pdf->stream("struk-pesanan-{$pesanan->id}.pdf");
}
public function laporanBulanan(Request $request)
{
    // Validasi input bulan dan tahun dari user
    $request->validate([
        'bulan' => 'required|integer|min:1|max:12',
        'tahun' => 'required|integer|min:2000|max:' . now()->year,
    ]);

    $bulan = $request->bulan;
    $tahun = $request->tahun;

    // Ambil data transaksi berdasarkan bulan dan tahun dengan relasi
    $transaksi = Riwayat::with(['user', 'paket']) 
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun)
        ->get();

    if ($transaksi->isEmpty()) {
        return redirect()->back()->with('error', 'Belum ada transaksi pada bulan ' . Carbon::create($tahun, $bulan)->format('F Y') . '.');
    }

    // Kelompokkan data berdasarkan pengguna
    $laporan = $transaksi->groupBy(function ($item) {
        return $item->user->name ?? 'Unknown';
    })->map(function ($items) {
        return [
            'user' => $items->first()->user->name ?? 'Unknown',
            'pesanan_count' => $items->count(), // Hitung jumlah pesanan
            'subtotal' => $items->sum('total_harga'), // Hitung subtotal
            'pesanan' => $items->map(function ($item) {
                return [
                    'paket' => $item->paket->nama_paket ?? 'Tanpa Paket',
                    'jumlah' => $item->jumlah,
                    'total_harga' => $item->total_harga,
                    'tanggal' => $item->created_at,
                ];
            }),
        ];
    });

    // Hitung total keseluruhan dari semua transaksi
    $totalKeseluruhan = $transaksi->sum('total_harga');

    // Debug: Periksa data sebelum dibuat menjadi laporan
    // dd($laporan, $totalKeseluruhan);

    // Kirim data ke view
    $pdf = PDF::loadView('laporan.bulanan', compact('laporan', 'totalKeseluruhan', 'bulan', 'tahun'))
    ->setPaper('A4', 'portrait');

return $pdf->stream('laporan-bulanan.pdf');
}


 

// In PesananController.php
// In PesananController.php

public function dashboard()
{
    $user = auth()->user();

    // Query Pesanan Hari Ini
    if ($user->role == 'pelanggan') {
        $pesananHariIni = Pesanan::where('user_id', $user->id)
                                ->whereDate('created_at', today())
                                ->count();
    } else {
        $pesananHariIni = Pesanan::whereDate('created_at', today())->count();
    }

    // Query Pesanan Selesai
    if ($user->role == 'pelanggan') {
        $pesananSelesai = Pesanan::where('user_id', $user->id)
                                ->where('status', 6) // Status selesai
                                ->count();
    } else {
        $pesananSelesai = Pesanan::where('status', 6)->count();
    }

    // Query Pesanan Terbaru
    if ($user->role == 'pelanggan') {
        $latestPesanan = Pesanan::where('user_id', $user->id)
                                ->latest()
                                ->paginate(10);
    } else {
        $latestPesanan = Pesanan::latest()->paginate(10);
    }

    // **Pendapatan Harian** (Dari Tabel Pesanan)
    $pendapatanHarian = Pesanan::whereDate('created_at', today())
                            ->sum('total_harga');

    // **Pendapatan Bulanan** (Dari Tabel Riwayat)
    $pendapatanBulanan = Riwayat::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                                ->sum('total_harga');

    // Data untuk chart (admin only)
    $ordersPerHour = $user->role == 'admin'
        ? Pesanan::selectRaw("HOUR(created_at) as hour, COUNT(*) as count")
                ->whereDate('created_at', today())
                ->groupBy('hour')
                ->get()
        : collect();

    $ordersPerDay = $user->role == 'admin'
        ? Pesanan::selectRaw("DATE(created_at) as date, COUNT(*) as count")
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->groupBy('date')
                ->get()
        : collect();

    $monthlyIncome = $user->role == 'admin'
        ? Riwayat::selectRaw("DATE(created_at) as date, SUM(total_harga) as income")
                ->whereBetween('created_at', [now()->subDays(30), now()])
                ->groupBy('date')
                ->get()
        : collect();

    // Return data ke view
    return view('dashboard', compact(
        'pesananHariIni',
        'pesananSelesai',
        'latestPesanan',
        'pendapatanHarian',
        'pendapatanBulanan',
        'ordersPerHour',
        'ordersPerDay',
        'monthlyIncome'
    ));
}




}
