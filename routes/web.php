<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaketLaundryController;
use App\Models\Pesanan;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RiwayatUserController;
Route::get('/', function () {
    return view('welcome');
});

// Place this after other routes for clarity

Route::middleware(['auth', 'verified'])->get('/dashboard', [PesananController::class, 'dashboard'])->name('dashboard');
// Admin route to display user details and their orders
Route::get('admin/profile', [ProfileController::class, 'show'])->name('admin.profile.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('users', function (Illuminate\Http\Request $request) {
    $query = App\Models\User::query();

    // Search by name or email
    if ($search = $request->input('search')) {
        $query->where('name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%");
    }

    // Filter by role
    if ($role = $request->input('role')) {
        $query->where('role', $role);
    }

    // Paginate the results
    $users = $query->paginate(10);

    return view('admin.index', compact('users'));
})->name('admin.users.index');

// Create User (Form)
Route::get('users/create', function () {
    return view('admin.create');
})->name('admin.users.create');

// View User (Show)
Route::get('users/{user}', function (App\Models\User $user) {
    return view('admin.show', compact('user'));
})->name('admin.users.show');

// Store User (Submit Form)
Route::post('users', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'phone' => 'required|digits_between:10,15|unique:users,phone', // Nomor telepon valid & unik
        'role' => 'required|in:admin,staff,pelanggan,kurir',
    ]);

    App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'phone' => $validated['phone'],
        'role' => $validated['role'],
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
})->name('admin.users.store');

// Edit User (Form)
Route::get('users/{user}/edit', function (App\Models\User $user) {
    return view('admin.edit', compact('user'));
})->name('admin.users.edit');

// Update User (Submit Form)
Route::put('users/{user}', function (Illuminate\Http\Request $request, App\Models\User $user) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8',
        'phone' => 'nullable|digits_between:10,15|unique:users,phone,' . $user->id, 
        'role' => 'nullable|in:admin,staff,pelanggan,kurir',  $user->role,
    ]);
// Pastikan hanya admin yang dapat mengubah role
if (Auth::user()->role !== \App\Models\User::ROLE_ADMIN) {
    $validated['role'] = $user->role; // Gunakan role yang sudah ada
}
    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        'phone' => $validated['phone'],
        'role' => $validated['role'],
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
})->name('admin.users.update');

// Delete User
Route::delete('users/{user}', function (App\Models\User $user) {
    // Cek apakah pengguna yang login adalah admin
    if (auth()->user()->role !== 'admin') {
        return redirect()->route('admin.users.index')->with('error', 'Anda tidak memiliki izin untuk menghapus pengguna.');
    }

    // Cegah admin menghapus dirinya sendiri
    if (auth()->user()->id === $user->id) {
        return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    }

    // Hapus pengguna
    $user->delete();

    return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
})->name('admin.users.destroy');

Route::get('paket-laundry/create', [PaketLaundryController::class, 'create'])->name('paket-laundry.create');
Route::middleware(['auth'])->group(function () {
    // Rute untuk semua pengguna yang telah login
    Route::get('paket-laundry', [PaketLaundryController::class, 'index'])->name('paket-laundry.index');
    Route::get('paket-laundry/{paket_laundry}', [PaketLaundryController::class, 'show'])->name('paket-laundry.show');

    // Rute khusus untuk admin (akses penuh)
    Route::middleware(['auth', 'role:admin'])->group(function () {
       
        Route::post('paket-laundry', [PaketLaundryController::class, 'store'])->name('paket-laundry.store');
        Route::get('paket-laundry/{paket_laundry}/edit', [PaketLaundryController::class, 'edit'])->name('paket-laundry.edit');
        Route::put('paket-laundry/{paket_laundry}', [PaketLaundryController::class, 'update'])->name('paket-laundry.update');
        Route::delete('paket-laundry/{paket_laundry}', [PaketLaundryController::class, 'destroy'])->name('paket-laundry.destroy');
    });
});
// routes/web.php
// Middleware untuk akses yang dibatasi pada staff, pelanggan, dan kurir
Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
Route::middleware(['auth'])->group(function () {
    
    // Route utama untuk melihat semua pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    
    // Melihat detail pesanan
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');

    // Hanya staff dan pelanggan yang bisa membuat pesanan baru
  
    // Mengupdate jumlah pesanan (staff hanya bisa melakukan ini)
    Route::middleware(['role:staff'])->group(function () {
        Route::patch('/pesanan/{id}/update-jumlah', [PesananController::class, 'updateJumlah'])->name('pesanan.update-jumlah');
    });

    // Konfirmasi pembayaran untuk kurir
    Route::middleware(['role:kurir,staff,pelanggan'])->group(function () {
        Route::get('/pesanan/{id}/acc_payment', [PesananController::class, 'showAccPaymentForm'])->name('pesanan.acc_payment');
        Route::post('/pesanan/{id}/acc_payment', [PesananController::class, 'accPayment'])->name('pesanan.process_payment');
    });

    // Mengupdate status pesanan hanya untuk staff, admin, dan kurir
    Route::middleware(['role:staff,admin,kurir'])->group(function () {
        Route::patch('/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    });

    // Cetak struk atau laporan PDF hanya untuk staff dan admin
    Route::middleware(['role:staff,admin'])->group(function () {
        Route::get('/pesanan/{id}/cetak-pdf', [PesananController::class, 'cetakPdf'])->name('pesanan.cetak-pdf');
    });

    // Menghapus pesanan
    Route::middleware(['role:staff'])->group(function () {
        Route::delete('/pesanan/{id}/destroy', [PesananController::class, 'destroy'])->name('pesanan.destroy');
    });
    
    // Mengedit pesanan hanya untuk staff
    Route::middleware(['role:staff'])->group(function () {
        Route::get('/pesanan/{id}/edit', [PesananController::class, 'edit'])->name('pesanan.edit');
        Route::put('/pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.update');
    });

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/laporan-bulanan', [PesananController::class, 'laporanBulanan'])->name('laporan.bulanan');
});
Route::middleware(['auth','role:pelanggan'])->group(function () {
    Route::get('/riwayat-saya', [RiwayatUserController::class, 'index'])->name('riwayat.saya');
});
Route::middleware(['auth','role:admin,staff'])->group(function () {
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('riwayat/{id}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
});

