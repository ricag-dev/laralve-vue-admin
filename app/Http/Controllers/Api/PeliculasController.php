<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;

class PeliculasController extends Controller
{
    public function index(){
//        $sq = Pelicula::all();
//        foreach($sq as $prod){
//            $item = Pelicula::find($prod->id);
//
//            $item->imagen = "/storage/files/{$this->rand()}.jpg";
//            $item->save();
//        }


        return Pelicula::all();
    }

    function rand(){
        $rand = range(1, 6);
        $c= array_rand($rand);
        if(!$c){
            $c = $this->rand();
        }
        return $c;
    }

    public function update($id){
        return [$id];
    }


}
