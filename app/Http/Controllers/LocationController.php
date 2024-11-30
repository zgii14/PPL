<?php

namespace App\Http\Controllers;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // app/Http/Controllers/LocationController.php
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        try {
            $user = auth()->user(); // Kurir yang sedang login
    
            // Update lokasi kurir
            $user->location()->updateOrCreate([], [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
    
            return response()->json(['message' => 'Lokasi berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    public function getLocation($id)
    {
        $location = Location::where('user_id', $id)->first();
    
        if (!$location) {
            return response()->json(['message' => 'Lokasi tidak ditemukan'], 404);
        }
    
        return response()->json([
            'latitude' => $location->latitude,
            'longitude' => $location->longitude,
            'message' => 'Lokasi ditemukan'
        ]);
    }
    
public function getKurirLocation(Request $request)
{
    // Dapatkan lokasi kurir berdasarkan ID
    $userId = $request->input('kurir_id'); // Kurir ID dari frontend
    $location = Location::where('user_id', $userId)->first();

    // Pastikan lokasi ditemukan
    if (!$location) {
        return response()->json(['status' => 'error', 'message' => 'Lokasi kurir tidak ditemukan'], 404);
    }

    // Kembalikan lokasi dalam format JSON
    return response()->json([
        'status' => 'success',
        'latitude' => $location->latitude,
        'longitude' => $location->longitude,
    ]);
}


}
