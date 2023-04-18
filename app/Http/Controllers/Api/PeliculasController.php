<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;

class PeliculasController extends Controller
{
    public function index(){
        return Pelicula::all();
    }

    public function update($id){
        return [$id];
    }


}
