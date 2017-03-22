<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TipoCorrespondencia extends Model
{
    //relacionando con la tabla que requerimos
    protected $table = 'ta_tipo_corres';
    //relacionando con los campos que necesitamos
    protected  $fillable = array('n_tipo_corr','c_desc','d_fecha_creacion','d_fecha_eliminacion');
}
