<?php

namespace App\Http\Controllers;
use DB;
use App\models\TipoDestinatario;
use Illuminate\Http\Request;
//paquete para el manejo de errores
use League\Flysystem\Exception;
use Response;
use Log;
class TipoDestinatarioController extends Controller
{
    
    public function index()
    {
    	 try
       {
        $tipoDestinatario = DB::table('ta_tipo_destinatario')->whereNull('d_fecha_eliminacion')
                                                             ->orderBy('c_descripcion')  
                                                             ->get();
         return response()->json(['datos'=>TipoDestinatario::all()],200);
       }
       catch(Exception $e){       
             return response()->json('Error' . $e->getMessage(), $e->getCode());    
              Log::debug('Error al tratar de ver todos los tipos de destinatario: '.$e);
       }
 
    }

    public function show($n_id_tipo)
    {
    	  try 
    	 {
           $tipoDestinatario = DB::table('ta_tipo_destinatario')->where('n_id_tipo',$n_id_tipo)->whereNull('d_fecha_eliminacion')->get();
         
           if(!$tipoDestinatario)
           {
       	    return response()->json(['mensaje'=>'No se encuentra el tipo de destinatario en la base de datos','codigo'=>404],404);
           }
           return response()->json(['datos'=>$tipoDestinatario,200]);
         }
         catch(Exception $e){
           return response()->json('Error' . $e->getMessage(), $e->getCode());    
           Log::debug('Error al tratar de ver el tipo de destinatario: '.$e);
        }
     
   }
}
