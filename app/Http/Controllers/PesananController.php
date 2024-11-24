<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketLaundry;
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
        // Validasi untuk input pesanan
        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'jumlah' => 'required|integer|min:1',
            'user_id' => 'required|exists:users,id', // Pastikan user_id diperlukan, meski bisa dibuat user baru
        ], [
            'paket_id.required' => 'Silakan pilih paket laundry.',
            'jumlah.required' => 'Silakan masukkan jumlah.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal adalah 1.',
            'user_id.required' => 'Silakan pilih pengguna.',
        ]);
    
        // Jika ada input pengguna baru, lakukan validasi tambahan
        if ($request->new_user_name) {
            $request->validate([
                'new_user_name' => 'required|alpha_num|unique:users,name', // Validasi untuk nama pengguna baru
            ], [
                'new_user_name.required' => 'Silakan masukkan nama pelanggan baru.',
                'new_user_name.alpha_num' => 'Nama pengguna hanya boleh mengandung huruf dan angka.',
                'new_user_name.unique' => 'Nama pengguna sudah terdaftar.',
            ]);
    
            // Sanitasi nama pengguna (hanya huruf dan angka)
            $sanitized_user_name = preg_replace('/[^a-zA-Z0-9_]/', '', $request->new_user_name);
    
            // Buat pengguna baru jika nama pengguna baru diberikan
            $user = User::create([
                'name' => $sanitized_user_name,
                'email' => strtolower($sanitized_user_name) . '@lubis.com', // Email berdasarkan nama
                'password' => bcrypt($sanitized_user_name), // Set password default yang aman
            ]);
        } else {
            // Jika tidak ada nama pengguna baru, gunakan pengguna yang dipilih
            $user = User::findOrFail($request->user_id);
        }
    
        // Cari paket laundry berdasarkan paket_id yang dipilih
        $paket = PaketLaundry::findOrFail($request->paket_id);
    
        // Simpan pesanan baru
        Pesanan::create([
            'paket_id' => $request->paket_id,
            'user_id' => $user->id, // Gunakan ID pengguna yang dipilih atau dibuat
            'jumlah' => $request->jumlah,
            'total_harga' => $paket->harga * $request->jumlah, // Hitung total harga
            'status' => 0, // Status awal: Pending
        ]);
    
        // Redirect ke halaman daftar pesanan dengan pesan sukses
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
        $request->validate([
            'status' => 'required|in:1,2,3,4,5,6',
        ]);
    
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = $request->status;
        $pesanan->save();
    
        return redirect()->route('pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
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
