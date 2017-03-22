<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Usuario;
use App\models\CorrespondenciaInterna;
use App\models\TipoDestinatario;
use App\models\TipoCorrespondencia;
use App\models\Copia;
class DocumentoInternoAdjunto extends Model
{  
   //relacionando con la tabla que requerimos
    protected  $table = 'ta_doc_int_adj';
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
                                 'n_id_tipo_destinatario',   
                                 'n_id_ta_tipo_documento',
                                 'n_can', 
                                 'n_id_ta_copia', 
                                 'c_cod_cite');

    //Un documento adjuntado tiene un usuario que la crea
    public function usuario(){
      return $this->belongsTo('Usuario');
    }
    //Un documento adjuntado tiene un id de correspondencia generada
    public function correspondenciaInterna(){
      return $this->belongsTo('CorrespondenciaInterna');
    }
    //un documento adjuntado tiene 1 tipo de destinatario
    public function tipoDestinatario(){

      return $this->belongsTo('TipoDestinatario');
    }
    //un documento adjuntado tiene un tipo de correspondencia
    public function tipoCorrespondencia(){

      return $this->belongsTo('TipoCorrespondencia');
    }
    //un documento adjuntado tiene un documento , fotocopia o original
    public function copia(){

      return $this->belongsTo('Copia');
    }

}
