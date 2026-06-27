<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        'name' => ['required', 'string', 'max:100'],
        'roll' => ['required', 'string', 'max:50'],
        'batch' => ['required', 'string', 'max:50'],
        'email' => ['required', 'email', 'max:100'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    return back()
        ->with('registration_status', 'Registration form submitted.')
        ->onlyInput('name', 'roll', 'batch', 'email');
})->name('register.store');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    return back()
        ->withErrors(['email' => 'The provided credentials do not match our records.'])
        ->onlyInput('email');
})->name('login.attempt');
