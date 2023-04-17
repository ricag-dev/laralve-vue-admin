<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculasController extends Controller
{
    public function index(){
        return Pelicula::all();
    }
}
