<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = ['activo'];

    protected $appends = ['pelicula'];

    public function getPeliculaAttribute(){
        return Pelicula::find($this->pelicula_id);
    }
}
