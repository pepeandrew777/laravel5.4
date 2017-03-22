<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Sucursal;
use App\models\CorrespondenciaInterna;
use App\models\Usuario;
use App\models\DocumentoInternoAdjunto;
use App\models\TipoCorrespondencia;
class RevisionInterna extends Model
{
    //relacionando con la tabla que requerimos
    protected  $table = 'ta_revision_int';
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
                                 'id_ta_doc_int_adj',
                                 'n_tipo_corr_ta_tipo_corres', 
                                 'n_revisado',
                                 'c_principal',  
                                 'c_obs',
                                 'n_cantidad');  
    //Una revision tiene un usuario que la crea
    public function usuario(){
      return $this->belongsTo('Usuario');
    }
    //Una revision tiene un id de correspondencia generada
    public function correspondenciaInterna(){
      return $this->belongsTo('CorrespondenciaInterna');
    } 
    //Una revision se realiza desde una sucursal
    public function sucursal(){        
      return $this->belongsTo('Sucursal'); 
    }   
    //Una revision tiene un documento
    public function documentoInternoAdjunto(){        
       return $this->belongsTo('DocumentoInternoAdjunto'); 
    }
    //Una revision tiene un tipo de correspondencia
    public function tipoCorrespondencia(){
        return $this->belongsTo('TipoCorrespondencia');    
    }
}
