<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeliculaRequest;
use App\Http\Requests\UpdatePeliculaRequest;
use App\Models\Pelicula;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Inertia\Inertia;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Peliculas/Index', [
            'peliculas' => Pelicula::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeliculaRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelicula $pelicula)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeliculaRequest $request, Pelicula $pelicula)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelicula $pelicula)
    {
        //
    }
}
