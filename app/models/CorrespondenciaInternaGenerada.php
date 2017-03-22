<?php

namespace App\models;
use Illuminate\Database\Eloquent\Model;
use App\models\Usuario;
use App\models\CorrespondenciaInterna;
use App\models\Empleado;
use App\models\Gerencia;
use App\models\TipoDestinatario;
use App\models\Sucursal;
class CorrespondenciaInternaGenerada extends Model
{
      //relacionando con la tabla que requerimos
    protected  $table = 'ta_corres_int_gen';
   //relacionando con los campos que necesitamos
    protected  $fillable = array('id',
                                 'n_nro',
                                 'n_ano',   
                                 'n_mes',   
                                 'n_guardado',
                                 'n_id_usuario',
                                 'd_fecha_registro',
                                 't_hora_registro',
                                 'd_fecha_eliminacion',
                                 'd_fecha_ingreso',
                                 'id_ta_corres_interna',
                                 'n_id_emp_der', 
                                 'n_ger_origen', 
                                 'n_ger_destino', 
                                 'c_estado',  
                                 'n_destinatario_principal',       
                                 'n_id_tipo_ta_tipo_destinatario',
                                 'n_cod_suc');

   //una correspondencia generada tiene un usuario que lo genero
     public function usuario(){
      return $this->belongsTo('Usuario');
    }
   //tiene un id de correspondencia interna de la cual se genera
    public function correspondenciaInterna(){
      return $this->belongsTo('CorrespondenciaInterna');
    }
    //tiene un id o  ninguno donde se deriva
    public function empleado(){
      return $this->belongsTo('Empleado');
    }
    //tiene un id de una gerencia de destino
     public function gerencia(){
      return $this->belongsTo('Gerencia');
    } 
   //una correspondencia generada tiene 1 tipo de destinatario
    public function tipoDestinatario(){

      return $this->belongsTo('TipoDestinatario');
    }
   //Una correspondencia interna generada tiene una sucursal de donde se registran los datos
    public function sucursal(){
        return $this->belongsTo('Sucursal'); 
    }   

}
