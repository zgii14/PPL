<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketLaundry;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        // Check if the user is an admin
        $userRole = auth()->user()->role;
    
        if ($userRole === 'admin') {
            // Get only completed orders (status 6) with successful payments (status 'berhasil')
            $pesanan = Pesanan::with(['paket', 'user'])
                ->where('status', 6)  // Only completed orders
                ->whereHas('pembayaran', function ($query) {
                    $query->where('status', 'berhasil');  // Only successful payments
                })
                ->paginate(10);
        } else {
            // If the user is not an admin, we can either throw an exception or show a different set of orders
            $pesanan = Pesanan::with(['paket', 'user'])->paginate(10);  // Modify this line as per your needs
        }
    
        return view('pesanan.index', compact('pesanan'));
    }
    

    // Menampilkan form pembuatan pesanan
    public function create()
    {
        
        $paket = PaketLaundry::all();
        $users = User::all();
        return view('pesanan.create', compact('paket', 'users'));

        if (auth()->user()->role === 'kurir') {
            abort(403, 'Kurir tidak diizinkan untuk membuat pesanan.');
        }
    
        // Render create view for allowed roles
        return view('pesanan.create');
    }

    // Menyimpan pesanan ke database
    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:select,create', // Validate tipe (either select or create)
        ]);

        if ($request->tipe == 'select') {
            // Validate the user selection
            $request->validate([
                'user_id' => 'required|exists:users,id',
            ]);
        } elseif ($request->tipe == 'create') {
            // Validate the new user form
            $request->validate([
                'new_user_name' => 'required|alpha_num|unique:users,name',
              'latitude' => 'required|numeric|between:-90,90',
    'longitude' => 'required|numeric|between:-180,180',
            ]);
        }

        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Handle creation of user or use selected user based on tipe
        if ($request->tipe == 'create') {
            // Sanitize the new user name
            $sanitized_user_name = preg_replace('/[^a-zA-Z0-9_]/', '', $request->new_user_name);

            // Create new user
            $user = User::create([
                'name' => $sanitized_user_name,
                'email' => strtolower($sanitized_user_name) . '@lubis.com', // Generate email from name
                'password' => bcrypt($sanitized_user_name), // Set a default password
            ]);
        } else {
            // Use the selected existing user
            $user = User::findOrFail($request->user_id);
        }
        if (auth()->user()->role === 'kurir') {
            abort(403, 'Kurir tidak diizinkan untuk membuat pesanan.');
        }
    
        // Find the selected laundry package
        $paket = PaketLaundry::findOrFail($request->paket_id);

        // Create the order (Pesanan)
        $pesanan = Pesanan::create([
            'paket_id' => $request->paket_id,
            'user_id' => $user->id, // Use the user ID (either existing or newly created)
            'jumlah' => $request->jumlah,
            'total_harga' => $paket->harga * $request->jumlah, // Calculate total price
            'status' => 0, // Initial status: Pending
            'latitude' => $request->latitude * 1000000, // Store as microdegrees
            'longitude' => $request->longitude * 1000000, // Store as microdegrees
        ]);

        // Create payment record
        Pembayaran::firstOrCreate([
            'pesanan_id' => $pesanan->id,
            'status' => 'proses', // Assuming the default payment status is 'proses'
        ], [
            'nominal' => $pesanan->total_harga,  // Set nominal as total price from Pesanan
            'metode_pembayaran' => null, // Assuming 'transfer' as default method, you can customize
            'bukti_bayar' => null, // Initially no proof of payment, can be updated later
        ]);

        // Redirect back to the order list with a success message
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
        $pesanan = Pesanan::findOrFail($id);
        $paket = PaketLaundry::all();
        $users = User::all();
        return view('pesanan.edit', compact('pesanan', 'paket', 'users'));
    }

    // Memperbarui pesanan
    public function update(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'jumlah' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id',
            'latitude' => 'required|numeric|between:-90,90', // Ensure latitude is within valid range
            'longitude' => 'required|numeric|between:-180,180', // Ensure longitude is within valid range
        ]);
    
        // Find the existing order (Pesanan) and related laundry package (Paket)
        $pesanan = Pesanan::findOrFail($id);
        $paket = PaketLaundry::findOrFail($request->paket_id);
    
        // Update the order (Pesanan) with new data
        $pesanan->update([
            'paket_id' => $request->paket_id,
            'user_id' => $request->user_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $paket->harga * $request->jumlah, // Recalculate total price
            'latitude' => round($request->latitude * 1000000), // Convert to microdegrees
            'longitude' => round($request->longitude * 1000000), // Convert to microdegrees
        ]);
    
        // Redirect back to the list with a success message
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui.');
    }
    

    // Menghapus pesanan
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    // Update Status Pesanan (Berpindah ke Status Berikutnya)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6',
        ]);
    
        $pesanan = Pesanan::findOrFail($id);
    
        // Periksa role pengguna yang sedang login
        $userRole = auth()->user()->role;
    
        if ($userRole === 'kurir') {
            // Kurir hanya dapat mengubah status ke 1 atau 5
            if (!in_array($request->status, [1, 5])) {
                return redirect()->back()->with(
                    'error',
                    'Anda adalah kurir. Anda hanya dapat mengubah status ke Penjemputan  atau Pengantaran.'
                );
            }
        } elseif ($userRole !== 'staff') {
            // Role lain selain 'staff' tidak diizinkan mengubah status
            return redirect()->back()->with(
                'error',
                'Akses ditolak. Hanya staf yang diizinkan untuk mengubah ke status selain Penjemputan dan Pengantaran.'
            );
        }
    
        // Staf dapat mengubah ke semua status, sehingga tidak ada pembatasan di sini
    
        // Jika validasi lolos, simpan perubahan
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
            1 => 'Penjemputan',
            2 => 'Cuci',
            3 => 'Kering',
            4 => 'Lipat',
            5 => 'Pengantaran',
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
    
}
