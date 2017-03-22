<?php
namespace App\models;
use Illuminate\Database\Eloquent\Model;
//Importando las clases que necesitamos
use App\models\Usuario;
use App\models\TipoDestinatario;
use App\models\Empleado;
use App\models\Gerencia;
use App\models\Sucursal;
use App\models\TipoTrabajo;
class CorrespondenciaInterna extends Model
{
    //relacionando con la tabla que requerimos
    protected $table = 'ta_corres_interna';
    public $timestamps = false;
   //relacionando con los campos que necesitamos
    protected  $fillable = array('id','n_nro','n_ano','n_mes','n_id_usuario','n_id_tipo_ta_tipo_destinatario','n_ger_origen','n_ger_destino','n_gerencia_doc_fis','n_id_emp_der','n_cod_suc','d_fecha_ingreso','t_hora_ingreso','d_fecha_finalizacion','d_fecha_eliminacion','n_eliminado','c_referencia','c_cod_cite','c_estado','n_cod_trab','n_visto','n_urgente',' n_corres_externa','n_adjuntos');    
    //una correspondencia interna tiene 1 usuario 

    /*
    public function usuario(){
    	return $this->belongsTo('Usuario');
    }
    //una correspondencia tiene 1 tipo de destinatario
    public function tipoDestinatario(){

    	return $this->belongsTo('TipoDestinatario');
    }
    //Una correspondencia tiene 1 tipo de empleado, esto para obtener el id del empleado a quien se deriva la correspondencia
    public function empleado(){

    	return $this->belongsTo('Empleado');
    }
    //Una correspondencia tiene una gerencia de destino y gerencia fisica donde se quedaran los documentos
    public function gerencia(){
    	return $this->belongsTo('Gerencia');
    } 
    //Una correspondencia tiene una sucursal de donde se registran los datos
    public function sucursal(){
        return $this->belongsTo('Sucursal');	
    }   
    //Una correspondencia tiene un tipo de trabajo asignado
    public function trabajo(){
        return $this->belongsTo('TipoTrabajo');	
    } 
    */ 

}
