<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\models\CorrespondenciaInterna;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

//Estos son los datos correctos
class CorrespondenciaInternaController extends Controller
{

    public function index()
    {
        try
        {
            $correspondencias = DB::table('ta_corres_interna')
                ->orderBy('d_fecha_ingreso')
                ->whereNull('d_fecha_eliminacion')
                ->get();
            return response()->json(['datos' => $correspondencias], 200);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver la correspondencia interna: ' . $e);
        }

    }

    /*
    public function show($id)
    {
    try
    {

    $correspondencia = DB::table('ta_corres_interna')->where('id', $id)->whereNull('d_fecha_eliminacion')->get();
    Log::debug($correspondencia);
    if (!$correspondencia) {
    return response()->json(['mensaje' => 'No se encuentra la correspondencia interna en la base de datos', 'codigo' => 404], 404);
    }
    return response()->json(['datos' => $correspondencia, 200]);

    } catch (Exception $e) {
    return response()->json('Error' . $e->getMessage(), $e->getCode());
    Log::debug('Error al tratar de ver la correspondencia interna: ' . $e);
    }
    } */
    public function store(Request $request)
    {
        $correspondenciaInterna = new CorrespondenciaInterna;
        //Verificando que se estan enviando todos los valores y que son obligatorios
        if (!$request->input('n_nro') || !$request->input('n_ano') || !$request->input('n_mes') || !$request->input('n_id_usuario')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: numero, gestion, mes o usuario', 'codigo' => 422], 422);
        }
        if (!$request->input('n_id_tipo_ta_tipo_destinatario') || !$request->input('n_ger_origen') || !$request->input('n_ger_destino') || !$request->input('n_gerencia_doc_fis')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: tipo de destinatario, gerencia origen, gerencia destino o gerencia fis', 'codigo' => 422], 422);
        }
        if (!$request->input('n_id_emp_der') || !$request->input('n_cod_suc') || !$request->input('d_fecha_ingreso') || !$request->input('t_hora_ingreso')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores de: empleado, sucursal, fecha de ingreso o hora de ingreso.', 'codigo' => 422], 422);
        }
        if (!$request->input('c_referencia') || !$request->input('n_cod_trab')) {
            return response()->json(['mensaje' => 'No se pudieron procesar los valores: asunto y trabajo', 'codigo' => 422], 422);
        }
        //
        if (!$request->input('c_cod_cite')) {
            // $request->input('c_cod_cite') = null;
        }

        //inicio: estas condiciones deben ser modificadas
        if ($request->input('n_cod_trab') == 10) {
            //$request->input('n_urgente') = 1;
        } else {
            //$request->input('n_urgente') = 0;
        }
        //estos datos son modificables de acuerdo a lo que se envia o registra de adjuntos y correspondencia externa
        //$request->input('n_corres_externa') = 0;
        //$request->input('n_adjuntos')       = 0;
        // fin: estas condiciones deben ser modificadas
        //valores iniciales para estos campos deben ser mantenidos
        //$request->input('d_fecha_finalizacion') = null;
        //$request->input('d_fecha_eliminacion')  = null;
        //$request->input('n_eliminado')          = 0;
        //$request->input('n_visto')              = 0;
        //$request->input('c_estado')             = 'P';

        CorrespondenciaInterna::create($request->all());
        return response()->json(['mensaje' => 'Correspondencia Interna creada'], 201);
        //return 'hola amigos';
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $correspondenciaInterna = CorrespondenciaInterna::find($id);
        if (!$correspondenciaInterna) {
            return response()->json(['mensaje' => 'No se pudieron encontrar los datos de la correspondencia interna', 'codigo' => 404], 404);
        }
        return response()->json(['datos' => $correspondenciaInterna, 200]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $bandera                = false;
        $correspondenciaInterna = correspondenciaInterna::find($id);
        //Datos que pueden ser modificados
        $nTipoDestinatario     = $request->input('n_id_tipo_ta_tipo_destinatario');
        $nGerenciaOrigen       = $request->input('n_ger_origen');
        $nGerenciaDestino      = $request->input('n_ger_destino');
        $nGerenciaDocumentoFis = $request->input('n_gerencia_doc_fis');
        $nIdEmpleado           = $request->input('n_id_emp_der');
        $cReferencia           = $request->input('c_referencia');
        $cCite                 = $request->input('c_cod_cite');
        $nCodTrabajo           = $request->input('n_cod_trab');
        $nUrgente              = $request->input('n_urgente');
        $nCorresExterna        = $request->input('n_corres_externa');
        $nAdjuntos             = $request->input('n_adjuntos');

        //Obteniendo los datos

        if (!$correspondenciaInterna) {
            return response()->json(['mensaje' => 'No se encuentra los datos de la correspondencia interna', 'codigo' => 404], 404);
        }

        if ($nTipoDestinatario != null && $nTipoDestinatario != '') {
            $correspondenciaInterna->n_id_tipo_ta_tipo_destinatario = $nTipoDestinatario;
            $bandera                                                = true;
            log::debug('holas montavacas222');
        }
        if ($nGerenciaOrigen != null && $nGerenciaOrigen != '') {
            $correspondenciaInterna->n_ger_origen = $nGerenciaOrigen;
            $bandera                              = true;
        }
        if ($nGerenciaDestino != null && $nGerenciaDestino != '') {
            $correspondenciaInterna->n_ger_destino = $nGerenciaDestino;
            $bandera                               = true;
        }
        if ($nGerenciaDocumentoFis != null && $nGerenciaDocumentoFis != '') {
            $correspondenciaInterna->n_gerencia_doc_fis = $nGerenciaDocumentoFis;
            $bandera                                    = true;
        }
        if ($nIdEmpleado != null && $nIdEmpleado != '') {
            $correspondenciaInterna->n_id_emp_der = $nIdEmpleado;
            $bandera                              = true;
        }
        if ($cReferencia != null && $cReferencia != '') {
            $correspondenciaInterna->c_referencia = $cReferencia;
            $bandera                              = true;
        }
        if ($cCite != null && $cCite != '') {
            $correspondenciaInterna->c_cod_cite = $cCite;
            $bandera                            = true;
        }
        if ($nCodTrabajo != null && $nCodTrabajo != '') {
            $correspondenciaInterna->n_cod_trab = $nCodTrabajo;
            $bandera                            = true;
        }
        if ($nUrgente != null && $nUrgente != '') {
            $correspondenciaInterna->n_urgente = $nUrgente;
            $bandera                           = true;
        }
        if ($nCorresExterna != null && $nCorresExterna != '') {
            $correspondenciaInterna->n_corres_externa = $nCorresExterna;
            $bandera                                  = true;
        }
        if ($nAdjuntos != null && $nAdjuntos != '') {
            $correspondenciaInterna->n_adjuntos = $nAdjuntos;
            $bandera                            = true;
        }
        if ($bandera) {
            $correspondenciaInterna->save();
            return response()->json(['mensaje' => 'Datos de correspondencia interna editados'], 200);
        }

        return response()->json(['mensaje' => 'No se pudieron editar los valores de corrrespondencia interna', 'codigo' => 422], 422);

    }
    /*
public function update(Request $request, $id)
{
$correspondenciaInterna = CorrespondenciaInterna::find($id);
$dato = $request->n_id_tipo_ta_tipo_destinatario;
$correspondenciaInterna->n_id_tipo_ta_tipo_destinatario = $dato;
$correspondenciaInterna->save();

} */

}
