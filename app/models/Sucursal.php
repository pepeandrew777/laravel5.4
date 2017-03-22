<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    //relacionando con la tabla que requerimos
    protected $table = 'ta_sucursal';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('n_cod_suc','c_descripcion','c_abreviatura','d_fecha_creacion','d_fecha_eliminacion');
    

}
