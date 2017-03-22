<?php

namespace App\Http\Controllers;

use DB;
//paquete para el manejo de errores
use League\Flysystem\Exception;
use Log;
use Response;

class TipoTrabajoController extends Controller
{

    public function index()
    {
        try
        {
            $trabajo = DB::table('ta_trabajos')
                ->whereNull('d_fecha_eliminacion')
                ->orderBy('c_descripcion')
                ->get();
            return response()->json(['datos' => $trabajo], 200);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver los trabajos: ' . $e);
        }

    }

    public function show($n_cod_tra)
    {

        try
        {
            $trabajo = DB::table('ta_trabajos')->where('n_cod_tra', $n_cod_tra)->whereNull('d_fecha_eliminacion')->get();
            if (!$trabajo) {
                return response()->json(['mensaje' => 'No se encuentra el trabajo en la base de datos', 'codigo' => 404], 404);
            }
            return response()->json(['datos' => $trabajo, 200]);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver el trabajo: ' . $e);
        }

    }
}
