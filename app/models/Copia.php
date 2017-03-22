<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Copia extends Model
{
     //relacionando con la tabla que requerimos
    protected $table = 'ta_copia';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('n_id','c_tipo','d_fecha_registro','d_fecha_eliminacion');
}
