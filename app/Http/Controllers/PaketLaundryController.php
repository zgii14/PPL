<?php

namespace App\Http\Controllers;

use App\Models\PaketLaundry;
use Illuminate\Http\Request;

class PaketLaundryController extends Controller
{
    // Menampilkan daftar paket laundry
    public function index(Request $request)
    {
        $query = PaketLaundry::query(); // Membuat query builder
    
        // Cek jika ada parameter pencarian dan tidak kosong
        if ($request->has('search') && !empty($request->search)) {
            // Jika ada pencarian, filter berdasarkan 'nama_paket'
            $query->where('nama_paket', 'like', '%' . $request->search . '%');
        }
    
        // Paginasikan hasil pencarian atau semua data
        $paket = $query->paginate(10); // Menampilkan 10 data per halaman
    
        return view('paket-laundry.index', compact('paket')); // Kembalikan ke view dengan data paket
    }
    

    // Menampilkan form untuk membuat paket baru
    public function create()
    {
        return view('paket-laundry.create'); // Mengembalikan view form untuk tambah paket
    }

    // Menyimpan paket laundry baru ke dalam database
    public function store(Request $request)
    {
        // Validasi input data
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jenis' => 'required|string',
            'waktu' => 'required|integer|min:1', // Menambahkan validasi untuk waktu
            'deskripsi' => 'nullable|string', // Validasi deskripsi yang bisa kosong
        ]);

        // Menyimpan data ke dalam database
        PaketLaundry::create([
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
            'jenis' => $request->jenis,
            'waktu' => $request->waktu, // Menyimpan waktu
            'deskripsi' => $request->deskripsi, // Menyimpan deskripsi
        ]);

        // Redirect ke halaman daftar paket dengan pesan sukses
        return redirect()->route('paket-laundry.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    // Menampilkan detail paket tertentu
    public function show(PaketLaundry $paketLaundry)
    {
        return view('paket-laundry.show', compact('paketLaundry')); // Mengirim data paket untuk ditampilkan
    }

    // Menampilkan form untuk mengedit paket
    public function edit(PaketLaundry $paketLaundry)
    {
        return view('paket-laundry.edit', compact('paketLaundry')); // Mengembalikan form edit untuk paket
    }

    // Mengupdate data paket di database
    public function update(Request $request, PaketLaundry $paketLaundry)
    {
        // Validasi input data
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jenis' => 'required|string',
            'waktu' => 'required|integer|min:1', // Menambahkan validasi untuk waktu
            'deskripsi' => 'nullable|string', // Validasi deskripsi yang bisa kosong
        ]);

        // Mengupdate data paket
        $paketLaundry->update([
            'nama_paket' => $request->nama_paket,
            'harga' => $request->harga,
            'jenis' => $request->jenis,
            'waktu' => $request->waktu, // Menyimpan waktu
            'deskripsi' => $request->deskripsi, // Menyimpan deskripsi
        ]);

        // Redirect ke halaman daftar paket dengan pesan sukses
        return redirect()->route('paket-laundry.index')->with('success', 'Paket berhasil diperbarui.');
    }

    // Menghapus paket dari database
    public function destroy(PaketLaundry $paketLaundry)
    {
        // Menghapus paket
        $paketLaundry->delete();

        // Redirect ke halaman daftar paket dengan pesan sukses
        return redirect()->route('paket-laundry.index')->with('success', 'Paket berhasil dihapus.');
    }
    
}
