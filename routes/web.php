<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CsvController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::controller(TaskController::class)
        ->prefix('task')
        ->name('task.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{task}', 'show')->name('show');
            Route::get('/{task}/edit', 'edit')->name('edit');
            Route::put('/{task}', 'update')->name('update');
            Route::delete('/{task}', 'destroy')->name('destroy');
        });
    Route::get('/csv-download', [CsvController::class, 'downloadCsv'])->name('csvDownload');
    Route::post('/csv-upload', [CsvController::class, 'uploadCsv'])->name('csvUpload');
});

require __DIR__ . '/auth.php';
