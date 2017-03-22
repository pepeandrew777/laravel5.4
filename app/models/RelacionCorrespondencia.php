<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Usuario;
use App\models\CorrespondenciaInterna;
class RelacionCorrespondencia extends Model
{
    //relacionando con la tabla que requerimos
    protected $table = 'ta_relacion_corres';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('id','n_nro','n_ano','n_nro_cite ','n_ano_externo','n_id_usuario','id_ta_corres_interna','d_fecha_registro','t_hora_registro','d_fecha_eliminacion');    
    //Una relacion de correspondencia tiene un usuario que la crea
    public function usuario(){
      return $this->belongsTo('Usuario');
    }
    //Tiene un id de correspondencia generarada
    public function correspondenciaInterna(){
      return $this->belongsTo('CorrespondenciaInterna');
    }

}
