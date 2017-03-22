<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Usuario;
use App\models\CorrespondenciaInterna;

class EscaneadoInterno extends Model
{
   //relacionando con la tabla que requerimos
    protected  $table = 'ta_escaneado_int';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('id',
                                 'n_nro',
                                 'n_ano',   
                                 'n_mes',   
                                 'n_cod_suc',
                                 'n_id_usuario',
                                 'd_fecha_registro',
                                 't_hora_registro',
                                 'd_fecha_eliminacion',
                                 'id_ta_corres_interna',
                                 'c_palabras_clave',   
                                 'c_ruta');

    //Un documento escaneado tiene un usuario que la crea
    public function usuario(){
      return $this->belongsTo('Usuario');
    }
    //Un documento escaneado tiene un id de correspondencia generada
    public function correspondenciaInterna(){
      return $this->belongsTo('CorrespondenciaInterna');
    } 
    //Una documento escaneado tiene una sucursal de donde se escanearon los datos
    public function sucursal(){        
        return $this->belongsTo('Sucursal'); 
    }   
}
