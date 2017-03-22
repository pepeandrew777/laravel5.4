<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TipoDestinatario extends Model
{
    //relacionando con la tabla que requerimos
    protected $table = 'ta_tipo_destinatario';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('n_id_tipo','c_descripcion','d_fecha_registro','d_fecha_eliminacion','n_eliminado');
}
