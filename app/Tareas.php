<?php

namespace Laravuetest;

use Illuminate\Database\Eloquent\Model;

class Tareas extends Model
{
   //public $table = "tareas";
   protected $fillable = ['nombre', 'descripcion', 'estado'];
}
