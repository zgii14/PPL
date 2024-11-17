<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PaketLaundry;
use App\Models\User;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $paket_id = $request->get('paket_id');
        $harga_min = $request->get('harga_min');
        $harga_max = $request->get('harga_max');
        
        $pesanan = Pesanan::when($search, function ($query, $search) {
                return $query->where('nama_paket', 'like', '%' . $search . '%');
            })
            ->when($paket_id, function ($query, $paket_id) {
                return $query->where('paket_id', $paket_id);
            })
            ->when($harga_min, function ($query, $harga_min) {
                return $query->where('total_harga', '>=', $harga_min);
            })
            ->when($harga_max, function ($query, $harga_max) {
                return $query->where('total_harga', '<=', $harga_max);
            })
            ->paginate(10);
        
        $paket_laundries = PaketLaundry::all(); // Untuk filter berdasarkan paket

        return view('pesanan.index', compact('pesanan', 'paket_laundries'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('paket')->findOrFail($id); 
        return view('pesanan.show', compact('pesanan'));
    }

    public function create()
    {
        $paket = PaketLaundry::all();

        $users = User::all();
        return view('pesanan.create', compact('paket', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket_laundry,id',
            'jumlah' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        Pesanan::create($request->all());

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibuat');
    }

    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $paket_laundries = PaketLaundry::all(); // Ambil semua paket laundry untuk pilihan dropdown
        return view('pesanan.edit', compact('pesanan', 'paket_laundries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket_laundries,id',
            'jumlah' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update($request->all()); // Update data pesanan

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil diperbarui');
    }
}
