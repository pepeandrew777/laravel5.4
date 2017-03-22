<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
   //relacionando con la tabla que requerimos
   protected $table = 'ta_gerencia';
   //relacionando con los campos que necesitamos
   protected  $fillable = array('n_cod_ger','c_desc_ger','c_abrev_ger','c_correo','c_correo_copia','c_gerente','c_encargado','d_fecha_creacion','c_tipo','d_fecha_eliminacion');
    
}
