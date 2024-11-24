<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaketLaundryController;
use App\Models\Pesanan;
use App\Http\Controllers\PesananController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
})->name('admin.users.destroy');

Route::resource('paket-laundry', PaketLaundryController::class);
// routes/web.php

Route::middleware(['auth', 'role:staff'])->group(function () {
Route::resource('pesanan', PesananController::class);
Route::patch('/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])->name('pesanan.update-status');

});