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
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
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
            'bukti_bayar' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pembayaran = Pembayaran::firstOrCreate([
            'pesanan_id' => $pesanan->id,
            'status' => 'proses',
        ], [
            'nominal' => $pesanan->total_harga,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_bayar' => $request->file('bukti_bayar')->store('bukti_bayar'),
        ]);

        // $pesanan->status = 6; // Set status to "Selesai"
        $pesanan->save();

        $pembayaran->status = 'berhasil';
        $pembayaran->save();

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
}
