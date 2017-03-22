<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
    //relacionando con la tabla que requerimos
   protected $table = 'ta_trabajos';
   //relacionando con los campos que necesitamos
   protected  $fillable = array('n_cod_tra','c_descripcion','d_fecha_registro','d_fecha_eliminacion');   
}
