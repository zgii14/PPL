<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;

class RiwayatUserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil riwayat hanya untuk pengguna yang sedang login
        $riwayats = Riwayat::with(['user', 'paket'])
            ->where('user_id', auth()->user()->id) // Filter hanya milik pengguna yang login
            ->latest()
            ->paginate(10);

        return view('riwayat.user.index', compact('riwayats'));
    }
}
