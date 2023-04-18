<?php

use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TurnoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/peliculas', [PeliculaController::class, 'index'])->name('peliculas');

    //CREAR PELICULA
    Route::get('/pelicula', [PeliculaController::class, 'new'])->name('pelicula.new');
    Route::post('/pelicula', [PeliculaController::class, 'store'])->name('peliculas.new');

    //EDITAR PELICULA
    Route::get('/pelicula/{pelicula}', [PeliculaController::class, 'edit'])->name('pelicula.edit');
    Route::patch('/pelicula/{pelicula}', [PeliculaController::class, 'update'])->name('pelicula.update');

    //ACTUALIZAR ESTADO
    Route::put('/pelicula/{pelicula}/estado', [PeliculaController::class, 'estado'])->name('pelicula.estado');

    //ELIMINAR ESTADO
    Route::delete('/pelicula/{id}', [PeliculaController::class, 'destroy'])->name('pelicula.destroy');

    Route::get('/pelicula/{id}/turnos', [TurnoController::class, 'turnos'])->name('pelicula.turnos');
});


require __DIR__.'/auth.php';
