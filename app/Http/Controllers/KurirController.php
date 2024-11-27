<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    // Menampilkan daftar pesanan untuk kurir
    public function index()
    {
        // Mengambil semua pesanan yang statusnya dijemput atau antar untuk kurir
        $pesanan = Pesanan::whereIn('status', [1, 5]) // Status 1: Dijemput, 5: Antar
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('kurir.pesanan.index', compact('pesanan'));
    }

    // Mengubah status pesanan
    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        // Pastikan status hanya bisa diubah ke "Dijemput" (1) atau "Antar" (5)
        if ($pesanan->status == 1 || $pesanan->status == 5) {
            $pesanan->status = $request->status;
            $pesanan->save();
        }

        return redirect()->route('kurir.pesanan.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }

    // Menambahkan bukti transaksi
    public function storeBuktiTransaksi(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Validasi file bukti transaksi
        $request->validate([
            'bukti_transaksi' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Menyimpan bukti transaksi
        $bukti = $request->file('bukti_transaksi')->store('bukti-transaksi');

        // Menyimpan bukti transaksi ke database
        $pesanan->bukti_transaksi = $bukti;
        $pesanan->save();

        return redirect()->route('kurir.pesanan.index')->with('success', 'Bukti transaksi berhasil diunggah.');
    }
}
