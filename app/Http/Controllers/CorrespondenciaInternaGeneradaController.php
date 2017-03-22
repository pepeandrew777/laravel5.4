<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Librerias adicionales que requerimos
use DB;
use App\models\CorrespondenciaInternaGenerada;
//paquete para el manejo de errores
use League\Flysystem\Exception;
use Response;
use Log;

class CorrespondenciaInternaGeneradaController extends Controller
{
    public function index()
    {
       try
        {
          $correspondencias = DB::table('ta_corres_int_gen')
                                ->orderBy('d_fecha_registro')
                                ->whereNull('d_fecha_eliminacion')
                                ->get(); 	
          return response()->json(['datos'=>$correspondencias],200);
        }
        catch(Exception $e){       
              return response()->json('Error' . $e->getMessage(), $e->getCode());    
              Log::debug('Error al tratar de ver la correspondencia interna generada: '.$e);
        }
 
   }
    public function show($id)
    {    
    	  try 
    	  {

            $correspondenciaGenerada = DB::table('ta_corres_int_gen')->where('id',$id)->whereNull('d_fecha_eliminacion')->get();                
            Log::debug($correspondenciaGenerada);
            if(!$correspondenciaGenerada)
            {
       	     return response()->json(['mensaje'=>'No se encuentra la correspondencia interna generada en la base de datos','codigo'=>404],404);
            }
             return response()->json(['datos'=>$correspondenciaGenerada,200]);
          
          }
         catch(Exception $e){
           return response()->json('Error' . $e->getMessage(), $e->getCode());    
           Log::debug('Error al tratar de ver la correspondencia interna generada: '.$e);              
         }
   }
}
