<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\StateController;
use App\Models\State;

require __DIR__ . '/auth.php';

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

// Validate Admin routes
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return view('auth.login');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('states', StateController::class)->except(['show']);
    Route::get('/dashboard', [StateController::class, 'index'])->name('dashboard');
});

// Middleware to restrict access based on IP range
Route::middleware(['auth', 'checkip'])->group(function () {
    Route::resource('states', StateController::class)->except(['show']);
    Route::get('/dashboard', [StateController::class, 'index'])->name('dashboard');
});

Route::get('/states/{id}', function ($id) {
    $state = State::findOrFail($id);

    return response()->json([
        'success' => true,
        'state' => $state,
    ]);
});

// Custom middleware to check the IP address against the Israel IP range
Route::middleware('checkip')->group(function () {
    Route::middleware('auth')->get('/dashboard', [StateController::class, 'index'])->name('dashboard');
});