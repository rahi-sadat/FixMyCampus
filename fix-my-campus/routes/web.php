<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'role' => ['required', 'string', 'in:student,staff'],
        'name' => ['required', 'string', 'max:100'],
        'roll' => ['required', 'string', 'max:50'],
        'batch' => ['required', 'string', 'max:50'],
        'email' => ['required', 'email', 'max:100', 'unique:users,email'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $roleName = $request->role;
    $roleId = DB::table('roles')
        ->where('role_name', $roleName)
        ->value('id');

    if (! $roleId) {
        $roleId = DB::table('roles')->insertGetId([
            'role_name' => $roleName,
            'description' => ucfirst($roleName).' role',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    $userData = [
        'role_id' => $roleId,
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'department' => $request->batch,
        'status' => 'active',
    ];

    if ($roleName === 'staff') {
        $userData['staff_id'] = $request->roll;
    } else {
        $userData['student_id'] = $request->roll;
    }

    $user = User::create($userData);

    return redirect()->route('login')->with('registration_status', 'Your account has been created successfully. Please login.');
})->name('register.store');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $role = Auth::user()->role->role_name ?? null;

        if ($role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($role === 'staff') {
            return redirect()->intended('/staff/dashboard');
        } elseif ($role === 'student') {
            return redirect()->intended('/student/dashboard');
        }

        return redirect()->intended('/');
    }

    return back()
        ->withErrors(['email' => 'The provided credentials do not match our records.'])
        ->onlyInput('email');
})->name('login.attempt');

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('status', 'You have been logged out.');
})->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});

foreach (glob(__DIR__.'/features/*.php') as $featureRoutes) {
    require $featureRoutes;
}
