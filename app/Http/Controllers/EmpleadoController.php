<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use DB;
use Response;
use Log;
use App\models\Empleado;
class EmpleadoController extends Controller
{
    public function index()
    {
    	try
        {
         $empleado = DB::table('ta_empleado')         
         ->whereNull('d_fecha_baja')
         ->orderBy('c_nombre_completo')
         ->get();	
         return response()->json(['datos'=>$empleado],200);
        }
       catch(Exception $e){       
             return response()->json('Error' . $e->getMessage(), $e->getCode());    
              Log::debug('Error al tratar de ver a los empleados: '.$e);
       }
 
    }

    public function show($n_id_emp)
    {
    	 
    	 try 
    	 {
           $empleado = DB::table('ta_empleado')->where('n_id_emp',$n_id_emp)->whereNull('d_fecha_baja')->get();
         
           if(!$empleado)
           {
       	    return response()->json(['mensaje'=>'No se encuentra el empleado en la base de datos','codigo'=>404],404);
           }
           return response()->json(['datos'=>$empleado,200]);
         }
         catch(Exception $e){
           return response()->json('Error' . $e->getMessage(), $e->getCode());    
           Log::debug('Error al tratar de ver el empleado especificado: '.$e);
        }
     
   }
}
