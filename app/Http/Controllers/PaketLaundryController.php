<?php

namespace App\Http\Controllers;

use App\Models\PaketLaundry;
use Illuminate\Http\Request;

class PaketLaundryController extends Controller
{
    // Display list of all packages
    public function index()
    {
        $paket = PaketLaundry::paginate(10);
        return view('paket-laundry.index', compact('paket'));
    }

    // Show form to create a new package
    public function create()
    {
        return view('paket-laundry.create');
    }

    // Store a new package in the database
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required',
            'harga' => 'required|numeric',
            'jenis' => 'required'
        ]);

        PaketLaundry::create($request->all());
        return redirect()->route('paket-laundry.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    // Display details for a specific package
    public function show(PaketLaundry $paketLaundry)
    {
        return view('paket-laundry.show', compact('paketLaundry'));
    }

    // Show form to edit an existing package
    public function edit(PaketLaundry $paketLaundry)
    {
        return view('paket-laundry.edit', compact('paketLaundry'));
    }

    // Update an existing package in the database
    public function update(Request $request, PaketLaundry $paketLaundry)
    {
        $request->validate([
            'nama_paket' => 'required',
            'harga' => 'required|numeric',
            'jenis' => 'required'
        ]);

        $paketLaundry->update($request->all());
        return redirect()->route('paket-laundry.index')->with('success', 'Paket berhasil diperbarui.');
    }

    // Delete a package from the database
    public function destroy(PaketLaundry $paketLaundry)
    {
        $paketLaundry->delete();
        return redirect()->route('paket-laundry.index')->with('success', 'Paket berhasil dihapus.');
    }
}
