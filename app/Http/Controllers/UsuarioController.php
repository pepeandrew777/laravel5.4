<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
//paquete para el manejo de errores
use League\Flysystem\Exception;
use Response;
use Log;
use App\models\Usuario;
class UsuarioController extends Controller
{
    
    public function index()
    {
    	try
        {
          $usuario = DB::table('ta_usuarios')
          ->whereNull('d_fecha_salida')
          ->orderBy('c_nombres')
          ->get();	
          return response()->json(['datos'=>$usuario],200);
        }
       catch(Exception $e){       
             return response()->json('Error' . $e->getMessage(), $e->getCode());    
              Log::debug('Error al tratar de ver a los usuarios: '.$e);
       }
 
    }

    public function show($n_id)
    {
    	 
        //Log::debug('no es que no');

    	 try 
    	 {
           $usuario = DB::table('ta_usuarios')->where('n_id',$n_id)->whereNull('d_fecha_salida')->get();
         
           if(!$usuario)
           {
       	    return response()->json(['mensaje'=>'No se encuentra el usuario en la base de datos','codigo'=>404],404);
           }
           return response()->json(['datos'=>$usuario,200]);
         }
         catch(Exception $e){
           return response()->json('Error' . $e->getMessage(), $e->getCode());    
           Log::debug('Error al tratar de ver el usuario: '.$e);
        }
     
   }
}
