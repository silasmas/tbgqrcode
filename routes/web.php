<?php

use App\Models\reunion;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReunionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/reunion', [ReunionController::class, 'index'])->name('reunion');
    Route::get('/participan', [AboutController::class, 'addSlide'])->name('participan');
    Route::get('/agent', [AboutController::class, 'addSlide'])->name('agent');
    Route::get('viewQrcode/{id}', [ReunionController::class, 'show'])->name('viewQrcode');

    Route::get('scanne', [ReunionController::class, 'scanne'])->name('scanne');
    Route::get('viewListe/{id}', [ReunionController::class, 'viewListe'])->name('viewListe');
    Route::get('verify/{id}', [ReunionController::class, 'verify'])->name('verify');

    Route::post('/add.reunion', [ReunionController::class, 'store'])->name('add.reunion');
});

Route::get('/dashboard', function () {
    $reunionns=reunion::where([["status","Ouvert"],["date_fin",">",NOW()]])->get();
    return view('dashboard',compact('reunionns'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
