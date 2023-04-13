<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReunionController;
use App\Models\reunion;
use Illuminate\Support\Facades\Route;

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
Route::get('verify/{id}', [ReunionController::class, 'verify'])->name('verify');
Route::get('scanne', [ReunionController::class, 'scanne'])->name('scanne');
Route::middleware(['auth'])->group(function () {
    Route::get('/reunion', [ReunionController::class, 'index'])->name('reunion');
    Route::get('/participan', [AboutController::class, 'addSlide'])->name('participan');
    Route::get('/agent', [AboutController::class, 'addSlide'])->name('agent');
    Route::get('viewQrcode/{id}', [ReunionController::class, 'show'])->name('viewQrcode');

    Route::get('viewListe/{id}', [ReunionController::class, 'viewListe'])->name('viewListe');
    Route::get('viewListeReunion/{id}', [ReunionController::class, 'viewListeReunion'])->name('viewListeReunion');

    Route::post('/add.reunion', [ReunionController::class, 'store'])->name('add.reunion');

    Route::get('delReunion/{id}', [ReunionController::class, 'destroy'])->name('delReunion');
    Route::get('delPartReunion/{id}', [ReunionController::class, 'delPartReunion'])->name('delPartReunion');
});

Route::get('/dashboard', function () {
    $reunionns = reunion::where([["status", "Ouvert"], ["date_fin", ">", NOW()]])->with("participan")->get();
    return view('dashboard', compact('reunionns'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
