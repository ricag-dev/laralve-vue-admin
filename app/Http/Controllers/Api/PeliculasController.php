<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use App\Models\Turno;

class PeliculasController extends Controller
{
    public function index(){

        return $this->peliculas();
    }

    function turnos(){
//        $list = [];
//        $peliculas = Pelicula::all()->pluck('id');
//        foreach (range(0,150) as $r){
//            $list=[
//                'activo' => rand(0,1),
//                'pelicula_id' => array_rand($peliculas->toArray()),
//                'turno' => str_pad(array_rand(range(0,23)), 2, "0", STR_PAD_LEFT)
//                     . ":" .
//                    str_pad(array_rand(range(0,59)), 2, "0", STR_PAD_LEFT)
//            ];
//
//            Turno::create($list);
//        }

//        return $list;


        return Turno::all();
    }

    function peliculas(){
//                $sq = Pelicula::all();
//        foreach($sq as $prod){
//            $item = Pelicula::find($prod->id);
//
//            $item->imagen = "/storage/files/{$this->rand()}.jpg";
//            $fecha = date("Y-m-d", mktime(0, 0, 0, $this->rand(1, 12), $this->rand(1, 30),   $this->rand(2000, 2025, 2000)));
//            $item->fecha_publicacion =  $fecha;
//            $item->save();
//        }


        return Pelicula::all();
    }


    function rand($ini=1, $fin=6,$rep=1){
        $c = mt_rand($ini, $fin);
        if($c<$rep){
            $c = $this->rand($ini, $fin, $rep);
        }
        return $c;
    }

    public function update($id){
        return [$id];
    }


}
