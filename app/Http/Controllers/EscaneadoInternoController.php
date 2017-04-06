<?php

namespace App\Http\Controllers;
use App\models\EscaneadoInterno;
//Librerias adicionales que requerimos
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//paquete para el manejo de errores
use Illuminate\Support\Facades\Log;


class EscaneadoInternoController extends Controller
{
    public function index()
    {
        try {
            $escaneados = DB::table('ta_escaneado_int')
                ->orderBy('d_fecha_registro')
                ->whereNull('d_fecha_eliminacion')
                ->get();
            $numero = sizeof($escaneados);
            if ($numero == 0) {
                return response()->json([
                    'mensaje' => 'No se encuentran los datos de documentos escaneados en la base de datos',
                    'codigo' => 404
                ], 404);
            }

            return response()->json(['datos' => $escaneados], 200);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver la correspondencia interna generada: ' . $e);
        }

    }

    public function show($id)
    {
        try {

            $escaneado = DB::table('ta_escaneado_int')->where('id',
                $id)->whereNull('d_fecha_eliminacion')->get();
            Log::debug($escaneado);
            $numero = sizeof($escaneado);
            if (!$escaneado || $numero == 0) {
                return response()->json([
                    'mensaje' => 'No se encuentra el documento escaneado en la base de datos',
                    'codigo' => 404
                ], 404);
            }
            return response()->json(['datos' => $escaneado, 200]);

        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver la correspondencia interna generada: ' . $e);
        }
    }
    public function store(Request $request)
    {

        if (!$request->input('n_nro') || !$request->input('n_ano') || !$request->input('n_mes') || !$request->input('n_cod_suc')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: numero, gestion, mes o id de sucursal de documentos escaneados',
                'codigo' => 422
            ], 422);
        }
        if (!$request->input('n_id_usuario') || !$request->input('d_fecha_registro') || !$request->input('t_hora_registro')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: id de usuario,fecha de registro o hora de registro de documentos escaneados',
                'codigo' => 422
            ], 422);
        }
        if (!$request->input('id_ta_corres_interna') || !$request->input('c_palabras_clave') || !$request->input('c_ruta')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: id de correspondencia interna,palabras clave o no subio la imagen del documento escaneado.',
                'codigo' => 422
            ], 422);
        }

        EscaneadoInterno::create($request->all());
        return response()->json(['mensaje' => 'Documento escaneado fue creado'], 201);

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bandera = false;
        $escaneado = EscaneadoInterno::find($id);
        log::debug($escaneado);
        //Datos que pueden ser modificados
        $dFechaEliminacion = $request->input('d_fecha_eliminacion');
        $cPalabrasClave = $request->input('c_palabras_clave');
        $cRuta = $request->input('c_ruta');

        //Obteniendo los datos
        $numero = sizeof($escaneado);
        log::debug($numero);
        if (!$escaneado || $numero == 0) {
            return response()->json([
                'mensaje' => 'No se encuentra los datos de la correspondencia interna generada',
                'codigo' => 404
            ], 404);
        }
        log::debug($request->input('d_fecha_eliminacion'));
        if ($dFechaEliminacion != null && $dFechaEliminacion != '') {
            $escaneado->d_fecha_eliminacion = $dFechaEliminacion;
            $bandera = true;
        }

        if ($cPalabrasClave != null && $cPalabrasClave != '') {
            $escaneado->c_palabras_clave = $cPalabrasClave;
            $bandera = true;
        }
        if ($cRuta != null && $cRuta != '') {
            $escaneado->c_ruta = $cRuta;
            $bandera = true;
        }
        if ($bandera) {
            $escaneado->save();
            return response()->json(['mensaje' => 'Datos de documento escaneado fueron editados'], 200);
        }

        return response()->json([
            'mensaje' => 'No se pudieron editar los valores de documento escaneado',
            'codigo' => 422
        ], 422);

    }
}
