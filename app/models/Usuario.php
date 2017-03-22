<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{    
   //relacionando con la tabla que requerimos
    protected $table = 'ta_usuarios';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('n_id','n_item','n_tipo','n_super_usuario','n_doble_rol','n_solo_ver','c_usuario','c_password','c_nombres','n_cod_ger','n_cod_suc','d_fecha_ingreso','d_fecha_salida','c_acceso_gerencias','n_derivar','n_finalizar','n_adicionar_corres_ext','n_reactivar_correspondencia','n_editar_finalizacion','nResponsabilidad');    
}
