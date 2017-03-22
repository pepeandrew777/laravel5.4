<?php

namespace App\Http\Controllers;
use DB;
use App\models\Sucursal;
use Illuminate\Http\Request;
use Log;
//paquete para el manejo de errores
use League\Flysystem\Exception;
class SucursalController extends Controller
{
    //
    public function index()
    {
       try
       {
          // $sucursal = Sucursal::all();
           $sucursal = DB::table('ta_sucursal')
                       ->whereNull('d_fecha_eliminacion')
                       ->orderBy('c_descripcion')
                       ->get();                                                      
           return response()->json(['datos'=>$sucursal,200]);                 
       }
       catch(Exception $e){       
             return response()->json('Error' . $e->getMessage(), $e->getCode());  
             Log::debug('Error al tratar de ver todos los tipos de sucursal: '.$e);
      }
    }

    public function show($n_cod_suc)
    {
      // $sucursal = Sucursal::find($n_cod_suc);
    	//No utilizamos el metodo find, porque en nuestra tabla no se encuentra esa columna, el nombre es diferente
      try
      {
        $sucursal = DB::table('ta_sucursal')->where('n_cod_suc',$n_cod_suc)->whereNull('d_fecha_eliminacion')->get();
        if(!$sucursal)
        {
       	 return response()->json(['mensaje'=>'No se encuentra esta sucursal en la base de datos','codigo'=>404],404);
        }
        return response()->json(['datos'=>$sucursal,200]);
      }
      catch(Exception $e){          
             return response()->json('Error' . $e->getMessage(), $e->getCode());  
              Log::debug('Error al tratar de ver la sucursal:'.$e);
      } 

    }
 }
