<?php

namespace App\Http\Controllers;
use DB;
use App\models\TipoCorrespondencia;
use Illuminate\Http\Request;
use Response;
use Log;
//paquete para el manejo de errores
use League\Flysystem\Exception;
class TipoCorrespondenciaController extends Controller
{    
     public function index()
     {
    	  try 
    	 {
          $tipoCorrespondencia = DB::table('ta_tipo_corres')->whereNull('d_fecha_eliminacion')->orderBy('c_desc')->get();

    	  return response()->json(['datos'=>$tipoCorrespondencia],200);    
        }
        catch(Exception $e){       
             return response()->json('Error' . $e->getMessage(), $e->getCode());	
       	      Log::debug('Error al tratar de ver todos los tipos de correspondencia: '.$e);
        }

    }   
     public function show($n_tipo_corr)
     {      
         try 
    	   {
           $tipoCorrespondencia = DB::table('ta_tipo_corres')->where('n_tipo_corr',$n_tipo_corr)->whereNull('d_fecha_eliminacion')->get();
           //Obteniendo si existen registros
           $count = TipoCorrespondencia::where('n_tipo_corr',$n_tipo_corr)->count();
            //echo ss
            if(!$tipoCorrespondencia and $count==0)
            {
       	    return response()->json(['mensaje'=>'No se encuentra el tipo de correspondencia en la base de datos','codigo'=>404],404);
            }
            return response()->json(['datos'=>$tipoCorrespondencia,200]);
            
        }
        catch(Exception $e){
          //return response()->json(['mensaje'=>'error al mostrar el registro de tipo de correspondencia'],500);
           return response()->json('Error' . $e->getMessage(), $e->getCode());	
       	   Log::debug('Error al tratar de ver el tipo de correspondencia: '.$e);
        }
      }   
}
