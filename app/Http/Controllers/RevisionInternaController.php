<?php

namespace App\Http\Controllers;

//Librerias requeridas para el controlador
use App\models\RevisionInterna;
//Librerias adicionales que requerimos
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//paquete para el manejo de errores
use Illuminate\Support\Facades\Log;

class RevisionInternaController extends Controller
{
    //
    public function index()
    {
        try {
            $revisiones = DB::table('ta_revision_int')
                ->orderBy('d_fecha_registro')
                ->whereNull('d_fecha_eliminacion')
                ->get();
            $numero = sizeof($revisiones);
            if ($numero == 0) {
                return response()->json([
                    'mensaje' => 'No se encuentran los datos de revisiones en la base de datos',
                    'codigo' => 404
                ], 404);
            }

            return response()->json(['datos' => $revisiones], 200);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver los datos de revisiones en la base de dato: ' . $e);
        }

    }

    public function show($id)
    {
        try {

            $revision = DB::table('ta_revision_int')->where('id',
                $id)->whereNull('d_fecha_eliminacion')->get();
            Log::debug($revision);
            $numero = sizeof($revision);
            if (!$revision || $numero == 0) {
                return response()->json([
                    'mensaje' => 'No se encuentra los datos de revision en la base de datos',
                    'codigo' => 404
                ], 404);
            }
            return response()->json(['datos' => $revision, 200]);

        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver los datos de revision: ' . $e);
        }
    }

    public function store(Request $request)
    {

        if (!$request->input('n_nro') || !$request->input('n_ano') || !$request->input('n_mes') || !$request->input('n_cod_suc')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: numero, gestion, mes o id de sucursal de la revision de documentos',
                'codigo' => 422
            ], 422);
        }
        if (!$request->input('n_id_usuario') || !$request->input('d_fecha_registro') || !$request->input('t_hora_registro')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: id de usuario,fecha de registro o hora de registro de la revision de documentos',
                'codigo' => 422
            ], 422);
        }

        if (!$request->input('id_ta_corres_interna') || !$request->input('id_ta_doc_int_adj') || !$request->input('n_tipo_corr_ta_tipo_corres')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: id de correspondencia interna,id de doc adjunto o id del tipo de correspondencia.',
                'codigo' => 422
            ], 422);
        }

        log::debug($request->input('n_revisado'));
        log::debug($request->input('c_principal'));
        log::debug($request->input('n_cantidad'));

        if(!$request->input('n_revisado'))
        {
            //return "falta este dato de revisado";
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: bandera de revisado.',
                'codigo' => 422
            ], 422);
        }
        if(!$request->input('n_cantidad'))
        {
            //return "falta este dato de revisado";
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: cantidad.',
                'codigo' => 422
            ], 422);
        }
        if(!$request->input('c_principal'))
        {
            //return "falta este dato de revisado";
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: si es documento principal (P) o adjunto(A).',
                'codigo' => 422
            ], 422);
        }

        RevisionInterna::create($request->all());
        return response()->json(['mensaje' => 'Datos de revision de documentos fue creado'], 201);

    }

}
