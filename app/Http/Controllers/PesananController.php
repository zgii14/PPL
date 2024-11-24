<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketLaundry;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    // Menampilkan daftar pesanan
    public function index()
    {
        $pesanan = Pesanan::with(['paket', 'user'])->paginate(10);
        return view('pesanan.index', compact('pesanan'));
    }

    // Menampilkan form pembuatan pesanan
    public function create()
    {
        $paket = PaketLaundry::all();
        $users = User::all();
        return view('pesanan.create', compact('paket', 'users'));
    }

    // Menyimpan pesanan ke database
    public function store(Request $request)
    {
        // Validate the order form
        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'jumlah' => 'required|integer|min:1',
            'tipe' => 'required|in:select,create', // Validate tipe (either select or create)
            'user_id' => 'required_if:tipe,select|exists:users,id', // Only required if tipe is 'select'
            'new_user_name' => 'required_if:tipe,create|alpha_num|unique:users,name', // Only required if tipe is 'create'
        ], [
            'paket_id.required' => 'Silakan pilih paket laundry.',
            'jumlah.required' => 'Silakan masukkan jumlah.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',
            'tipe.required' => 'Silakan pilih tipe pelanggan.',
            'tipe.in' => 'Tipe pelanggan yang dipilih tidak valid.',
            'user_id.required_if' => 'Silakan pilih pelanggan yang sudah ada.',
            'user_id.exists' => 'Pelanggan yang dipilih tidak valid.',
            'new_user_name.required_if' => 'Silakan masukkan nama pelanggan baru.',
            'new_user_name.alpha_num' => 'Nama pelanggan baru hanya boleh mengandung huruf dan angka.',
            'new_user_name.unique' => 'Nama pelanggan baru sudah terdaftar.',
        ]);
    
        // Handle creation of user or use selected user based on tipe
        if ($request->tipe == 'create') {
            // Create a new user
            $sanitized_user_name = preg_replace('/[^a-zA-Z0-9_]/', '', $request->new_user_name); // Sanitize name
    
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
    
        // Find the selected laundry package
        $paket = PaketLaundry::findOrFail($request->paket_id);
    
        // Create the order (Pesanan)
        Pesanan::create([
            'paket_id' => $request->paket_id,
            'user_id' => $user->id, // Use the user ID (either existing or newly created)
            'jumlah' => $request->jumlah,
            'total_harga' => $paket->harga * $request->jumlah, // Calculate total price
            'status' => 0, // Initial status: Pending
        ]);
    
        // Redirect back to the order list with a success message
        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat.');
    }
    
    
    

    // Menampilkan detail pesanan
    public function show($id)
    {
        $pesanan = Pesanan::with(['paket', 'user'])->findOrFail($id);
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
        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'jumlah' => 'required|integer|min:1', // Validasi status harus antara 0 - 5
            'user_id' => 'required|exists:users,id',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $paket = PaketLaundry::findOrFail($request->paket_id);

        $pesanan->update([
            'paket_id' => $request->paket_id,
            'user_id' => $request->user_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $paket->harga * $request->jumlah,
        ]);

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
        // Validate status field
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6',
        ]);
    
        // Find the Pesanan by ID
        $pesanan = Pesanan::findOrFail($id);
    
        // Update the pesanan status
        $pesanan->status = $request->status;
        $pesanan->save();
    
        // If status is 6 (Pengantaran), create a Pembayaran record
        if ($request->status == 6) {
            // Use firstOrCreate to check if Pembayaran already exists for this Pesanan
            Pembayaran::firstOrCreate([
                'pesanan_id' => $pesanan->id,
                'status' => 'proses', // Assuming the default payment status is 'proses'
            ], [
                'nominal' => $pesanan->total_harga,  // Set nominal as total price from Pesanan
                'metode_pembayaran' => 'transfer', // Assuming 'transfer' as default method, you can customize
                'bukti_bayar' => null, // Initially no proof of payment, can be updated later
            ]);
        }
    
        return redirect()->route('pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
    
    public function showAccPaymentForm($id)
{
    // Find the pesanan by ID
    $pesanan = Pesanan::findOrFail($id);

    if ($pesanan->status !== 6) {
        return redirect()->route('pesanan.index')->with('error', 'Status pembayaran sudah berhasil');
    }

    // Show the payment confirmation form
    return view('pesanan.acc_payment', compact('pesanan'));
}

    
public function accPayment(Request $request, $id)
{
    // Validate the input data
    $request->validate([
        'metode_pembayaran' => 'required|in:transfer,cash',
        'bukti_bayar' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
    ]);

    // Find the Pesanan by ID
    $pesanan = Pesanan::findOrFail($id);

    // Create or update Pembayaran record
    $pembayaran = Pembayaran::firstOrCreate([
        'pesanan_id' => $pesanan->id,
        'status' => 'proses', // Initially, set status to 'proses'
    ], [
        'nominal' => $pesanan->total_harga,
        'metode_pembayaran' => $request->metode_pembayaran,
        'bukti_bayar' => $request->file('bukti_bayar')->store('bukti_bayar'), // Store proof of payment
    ]);

    // Update the status of the Pesanan to 'Selesai' (Completed) after payment is confirmed
    // $pesanan->status = 6; // 'Selesai' status
    $pesanan->save();

    // Update the Pembayaran status to 'berhasil' (successful)
    $pembayaran->status = 'berhasil';
    $pembayaran->save();

    // Redirect to pesanan index with a success message
    return redirect()->route('pesanan.index')->with('success', 'Pembayaran berhasil diterima dan pesanan selesai.');
}



    // Mengembalikan ke status sebelumnya (opsional)
    public function downgradeStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Jika status belum pada tahap awal, mundur satu tahap
        if ($pesanan->status > 0) { // 0: Status Pending
            $pesanan->status -= 1;
            $pesanan->save();

            return redirect()->back()->with('success', 'Status pesanan dikembalikan ke tahap sebelumnya.');
        }

        return redirect()->back()->with('error', 'Status pesanan sudah pada tahap awal, tidak dapat dikurangi.');
    }
}
