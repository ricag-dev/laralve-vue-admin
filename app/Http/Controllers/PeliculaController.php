<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeliculaRequest;
use App\Models\Pelicula;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
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
        $fields = $request->all();

        if($request->hasFile('imagen')){
            $name = now()->timestamp.".{$request->imagen->getClientOriginalName()}";
            $path = $request->file('imagen')->storeAs('files', $name, 'public');

            $fields["imagen"] = "/storage/{$path}";
        }

        Pelicula::create($fields);
        return Redirect::route('peliculas')->with('success', 'Pelicula creada!');
    }

    /**
     * @param Pelicula $pelicula
     * @return void
     */
    public function estado(Pelicula $pelicula)
    {
        try {
            $pelicula->update(
                Request::validate([
                    "estado" => ["required", Rule::in([1,0])]
                ])
            );
        }catch (\Throwable $exception){
            \Sentry\captureException($exception);
        }
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
    public function edit(Pelicula $pelicula)
    {
        $pelicula->turnos = $pelicula->turnos()->get();
        return Inertia::render('Peliculas/Edit', [
            'pelicula' => $pelicula
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Pelicula $pelicula, StorePeliculaRequest $request)
    {
        $fields = $request->all();
        if($request->hasFile('imagen')){
            $name = now()->timestamp.".{$request->imagen->getClientOriginalName()}";
            $path = $request->file('imagen')->storeAs('files', $name, 'public');

            $fields["imagen"] = "/storage/{$path}";
        }

        $pelicula->update($fields);
        return Redirect::route('peliculas')->with('success', 'Pelicula Actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelicula $pelicula)
    {
        try {
            $pelicula->delete();
        }catch (\Throwable $exception){
            \Sentry\captureException($exception);
        }

        return Redirect::route('peliculas')->with('success', 'Pelicula eliminada!');
    }
}
