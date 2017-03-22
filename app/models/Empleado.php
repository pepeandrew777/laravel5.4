<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
     //relacionando con la tabla que requerimos
    protected $table = 'ta_empleado';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('n_id_emp','n_item_emp','n_ci_emp','c_nombres','c_paterno','c_materno','c_cargo','c_contrato','n_eliminado','d_fecha_alta','d_fecha_baja','n_area','c_nombre_completo');
        
}
