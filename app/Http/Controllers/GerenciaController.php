<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\models\Gerencia;
//paquete para el manejo de errores
use League\Flysystem\Exception;
use Response;
use Log;
class GerenciaController extends Controller
{
    public function index()
    {
    	try
        {
          $gerencias = DB::table('ta_gerencia')
                                ->orderBy('c_desc_ger')
                                ->whereNull('d_fecha_eliminacion')
                                ->get(); 	
          return response()->json(['datos'=>$gerencias],200);
        }
       catch(Exception $e){       
              return response()->json('Error' . $e->getMessage(), $e->getCode());    
              Log::debug('Error al tratar de ver todas las areas: '.$e);
       }
 
    }
    public function show($n_cod_ger)
    {
    	  try 
    	 {
           $gerencia = DB::table('ta_gerencia')->where('n_cod_ger',$n_cod_ger)->whereNull('d_fecha_eliminacion')->get();
         
           if(!$gerencia)
           {
       	    return response()->json(['mensaje'=>'No se encuentra la gerencia en la base de datos','codigo'=>404],404);
           }
           return response()->json(['datos'=>$gerencia,200]);
         }
         catch(Exception $e){
           return response()->json('Error' . $e->getMessage(), $e->getCode());    
           Log::debug('Error al tratar de ver la gerencia: '.$e);
        }
     
   }


}
