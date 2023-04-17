<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeliculaRequest;
use App\Http\Requests\UpdatePeliculaRequest;
use App\Models\Pelicula;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
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
        Pelicula::create(
            $request->all()
        );
        return Redirect::route('peliculas')->with('success', 'Pelicula creada!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function new()
    {
        return Inertia::render('Peliculas/Edit', [
            'pelicula' => []
        ]);
    }
    public function edit(Int $id)
    {
        return Inertia::render('Peliculas/Edit', [
            'pelicula' => Pelicula::find($id)
        ]);
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
