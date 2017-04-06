<?php

namespace App\Http\Controllers;

use DB;
//paquete para el manejo de errores
use League\Flysystem\Exception;
use Log;
use Response;

class CopiaController extends Controller
{
    public function index()
    {
        try
        {
            $copia = DB::table('ta_copia')
                ->orderBy('c_tipo')
                ->whereNull('d_fecha_eliminacion')
                ->get();
            return response()->json(['datos' => $copia], 200);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver todos los tipos de copia del documento: ' . $e);
        }
    }
    public function show($n_id)
    {
        // $sucursal = Sucursal::find($n_cod_suc);
        //No utilizamos el metodo find, porque en nuestra tabla no se encuentra esa columna, el nombre es diferente
        try
        {
            $copia = DB::table('ta_copia')->where('n_id', $n_id)->whereNull('d_fecha_eliminacion')->get();
            if (!$copia) {
                return response()->json(['mensaje' => 'No se encuentra este tipo de copia de documento en la base de datos', 'codigo' => 404], 404);
            }
            return response()->json(['datos' => $copia, 200]);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver la copia del documento:' . $e);
        }

    }
    //revisar los cambios
}
