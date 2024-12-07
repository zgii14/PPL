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
        'role' => 'required|in:admin,staff,pelanggan,kurir',
    ]);

    App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
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
        'role' => 'required|in:admin,staff,pelanggan,kurir',
    ]);

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
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


Route::resource('paket-laundry', PaketLaundryController::class)->middleware(['auth',]);
// routes/web.php
Route::resource('pesanan', PesananController::class)->except(['index', 'show']);
Route::middleware(['auth', 'role:staff,admin,kurir'])->group(function () {

    Route::patch('/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    
});

// Allow all roles to view pesanan, with special rules for kurir
Route::middleware(['auth'])->group(function () {
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    
});

// Route to show payment confirmation form
Route::get('/pesanan/{id}/acc_payment', [PesananController::class, 'showAccPaymentForm'])->name('pesanan.acc_payment');

// Route to process the payment and update status
Route::post('/pesanan/{id}/acc_payment', [PesananController::class, 'accPayment'])->name('pesanan.process_payment');
Route::get('/pesanan/{id}/cetak-pdf', [PesananController::class, 'cetakPdf'])->name('pesanan.cetak-pdf');
Route::patch('/pesanan/{id}/update-jumlah', [PesananController::class, 'updateJumlah'])->name('pesanan.update-jumlah');


// web.php (Route)
// Kurir-specific routes
Route::middleware(['role:kurir'])->prefix('kurir')->group(function () {
    Route::get('/pesanan', [KurirController::class, 'index'])->name('kurir.pesanan.index');
    Route::patch('/pesanan/{id}/status', [KurirController::class, 'updateStatus'])->name('kurir.pesanan.updateStatus');
    Route::post('/pesanan/{id}/konfirmasi-bayar', [KurirController::class, 'konfirmasiBayar'])->name('kurir.pesanan.konfirmasiBayar');
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

