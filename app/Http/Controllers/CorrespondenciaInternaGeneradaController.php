<?php

namespace App\Http\Controllers;

use App\models\CorrespondenciaInternaGenerada;
//Librerias adicionales que requerimos
use DB;
//paquete para el manejo de errores
use League\Flysystem\Exception;
use Log;
use Response;

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
            return response()->json(['datos' => $correspondencias], 200);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver la correspondencia interna generada: ' . $e);
        }

    }
    public function show($id)
    {
        try
        {

            $correspondenciaInternaGenerada = DB::table('ta_corres_int_gen')->where('id', $id)->whereNull('d_fecha_eliminacion')->get();
            Log::debug($correspondenciaInternaGenerada);
            if (!$correspondenciaInternaGenerada) {
                return response()->json(['mensaje' => 'No se encuentra la correspondencia interna generada en la base de datos', 'codigo' => 404], 404);
            }
            return response()->json(['datos' => $correspondenciaInternaGenerada, 200]);

        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver la correspondencia interna generada: ' . $e);
        }
    }
    public function store(Request $request)
    {
        $correspondenciaInterna = new CorrespondenciaInternaGenerada;
        //Verificando que se estan enviando todos los valores y que son obligatorios
        if (!$request->input('n_nro') || !$request->input('n_ano') || !$request->input('n_mes') || !$request->input('n_guardado')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: numero, gestion, mes o bandera de guardado', 'codigo' => 422], 422);
        }
        if (!$request->input('n_id_usuario') || !$request->input('d_fecha_registro') || !$request->input('t_hora_registro')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: id de usuario,fecha de registro o hora de registro', 'codigo' => 422], 422);
        }
        //d_fecha_eliminacion debe tomar  valores nulos, esto para controlar la eliminacion logica del sistema
        if (!$request->input('d_fecha_ingreso') || !$request->input('id_ta_corres_interna') || !$request->input('n_id_emp_der')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: fecha de ingreso,id de empleado,id corres interna y empleado.', 'codigo' => 422], 422);
        }
        if (!$request->input('n_ger_origen') || !$request->input('n_ger_destino') || !$request->input('c_estado')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: id de gerencia origen, destino y el estado ', 'codigo' => 422], 422);
        }
        if (!$request->input('n_destinatario_principal') || !$request->input('n_id_tipo_ta_tipo_destinatario') || !$request->input('n_cod_suc')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: bandera de destinario principal, id de tipo de destinatario y id de sucursal', 'codigo' => 422], 422);
        }

        //EE
        if (!$request->input('c_cod_cite')) {
            // $request->input('c_cod_cite') = null;
        }

        //inicio: estas condiciones deben ser modificadas
        if ($request->input('n_cod_trab') == 10) {
            //$request->input('n_urgente') = 1;
        } else {
            //$request->input('n_urgente') = 0;
        }

        CorrespondenciaInterna::create($request->all());
        return response()->json(['mensaje' => 'Correspondencia Interna creada'], 201);
    }
}
