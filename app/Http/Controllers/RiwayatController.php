<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        $tanggal = $request->input('tanggal');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Mulai query
        $riwayats = Riwayat::with(['user', 'paket']);

        // Filter berdasarkan nama pengguna jika ada query search
        if ($searchQuery) {
            $riwayats = $riwayats->whereHas('user', function ($userQuery) use ($searchQuery) {
                $userQuery->where('name', 'like', "%$searchQuery%");
            });
        }

        // Filter berdasarkan tanggal jika ada input tanggal
        if ($tanggal) {
            $riwayats = $riwayats->whereDate('created_at', $tanggal);
        }

        // Filter berdasarkan bulan dan tahun
        if ($bulan && $tahun) {
            $riwayats = $riwayats->whereMonth('created_at', $bulan)
                                 ->whereYear('created_at', $tahun);
        }

        // Urutkan berdasarkan waktu terbaru dan aktifkan pagination
        $riwayats = $riwayats->latest()->paginate(10);

        return view('riwayat.index', compact('riwayats'));
    }
    public function destroy($id)
{
    // Cek apakah pengguna yang login adalah admin
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('riwayat.index')->with('error', 'Anda tidak memiliki izin untuk menghapus riwayat.');
    }

    $riwayat = Riwayat::findOrFail($id);
    $riwayat->delete();

    return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil dihapus.');
}



}
