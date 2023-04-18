<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTurnoRequest;
use App\Http\Requests\UpdateTurnoRequest;
use App\Models\Pelicula;
use App\Models\Turno;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Turnos/Index', [
            'turnos' => Turno::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTurnoRequest $request)
    {
        $fields = $request->all();
        Turno::insert($fields);
        return Redirect::route('turnos')->with('success', 'Turno creado!');
    }

    /**
     * @param Turno $turno
     * @return void
     */
    public function estado(Turno $turno)
    {
        try {
            $turno->update(
                Request::validate([
                    "activo" => ["required", Rule::in([1,0])]
                ])
            );
        }catch (\Throwable $exception){
            \Sentry\captureException($exception);
        }
    }


    /**
     * Display the specified resource.
     */
    public function new()
    {
        return Inertia::render('Turnos/Edit', [
            'turno' => [],
            'peliculas' => Pelicula::all()
        ]);
    }
    public function new_by_peli(Pelicula $pelicula)
    {
        return Inertia::render('Turnos/Edit', [
            'turno' => [
                'pelicula_id' => $pelicula->id
            ],
            'peliculas' => Pelicula::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Turno $turno)
    {
        return Inertia::render('Turnos/Edit', [
            'turno' => $turno,
            'peliculas' => Pelicula::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTurnoRequest $request, Turno $turno)
    {
        try {
            $fields = $request->all();
            $turno->update($fields);
        }catch (\Throwable $exception){
            \Sentry\captureException($exception);
        }

        return Redirect::route('turnos')->with('success', 'Turno Actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turno $turno)
    {
        try {
            $turno->delete();
        }catch (\Throwable $exception){
            \Sentry\captureException($exception);
        }

        return Redirect::route('turnos')->with('success', 'Turno eliminada!');
    }
}
