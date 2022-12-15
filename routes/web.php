<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

session_start();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('index');
});



Route::get('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get("/auth/callback", function () {
    $gitUser = Socialite::driver('github')->user();
    session()->put('username', $gitUser->nickname);
    $user = User::updateOrCreate([
        'github_id' => $gitUser->id
    ], [
        'name' => $gitUser->name,
        'email' => $gitUser->email,
        'github_id' => $gitUser->id,
        'github_token' => $gitUser->token,
        'github_refresh_token' => $gitUser->refreshToken,
    ]);

    Auth::login($user);

    return redirect('/');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
