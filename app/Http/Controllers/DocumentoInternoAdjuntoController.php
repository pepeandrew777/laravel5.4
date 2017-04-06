<?php

namespace App\Http\Controllers;

//Librerias adicionales que requerimos
use App\models\DocumentoInternoAdjunto;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//paquete para el manejo de errores
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class DocumentoInternoAdjuntoController extends Controller
{
    //
    public function index()
    {
        try {


            $documentoInternoAdjunto = DB::table('ta_doc_int_adj')
                ->whereNull('d_fecha_eliminacion')
                ->orderBy('d_fecha_registro')
                ->get();
            $numero = sizeof($documentoInternoAdjunto);
            if ($numero == 0) {
                return response()->json([
                    'mensaje' => 'No se encuentran los datos de adjuntos de correspondencia en la base de datos',
                    'codigo' => 404
                ], 404);
            }
            return response()->json(['datos' => $documentoInternoAdjunto], 200);


        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver los datos de relacion de documento adjunto de correspondencia: ' . $e);
        }

    }

    public function show($id)
    {
        try {
            $documentoInternoAdjunto = DB::table('ta_doc_int_adj')->where('id',
                $id)->whereNull('d_fecha_eliminacion')->get();
            $numero = sizeof($documentoInternoAdjunto);
            log::debug($numero);
            if (!$documentoInternoAdjunto || $numero == 0) {
                return response()->json([
                    'mensaje' => 'No se encuentra el dato de adjunto de correspondencia en la base de datos',
                    'codigo' => 404
                ], 404);
            }
            return response()->json(['datos' => $documentoInternoAdjunto, 200]);
        } catch (Exception $e) {
            return response()->json('Error' . $e->getMessage(), $e->getCode());
            Log::debug('Error al tratar de ver el adjunto de correspondencia: ' . $e);
        }

    }

    public function store(Request $request)
    {
        //$correspondenciaInterna = new CorrespondenciaInterna;
        $token = csrf_token();
        log::debug($token);
        //Verificando que se estan enviando todos los valores y que son obligatorios
        if (!$request->input('n_nro') || !$request->input('n_ano') || !$request->input('n_mes') || !$request->input('n_cod_suc')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: numero, gestion, mes o codigo de sucursal de documento adjunto',
                'codigo' => 422
            ], 422);
        }
        if (!$request->input('n_id_usuario') || !$request->input('d_fecha_registro') || !$request->input('t_hora_registro') || !$request->input('id_ta_corres_interna')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: id de usuario,fecha de registro,hora de registro o id de documento adjunto',
                'codigo' => 422
            ], 422);
        }
        if (!$request->input('n_id_tipo_destinatario') || !$request->input('n_id_ta_tipo_documento') || !$request->input('n_can')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de: id de tipo de destinatario, id de tipo de documento o cantidad del documento adjunto',
                'codigo' => 422
            ], 422);
        }
        if (!$request->input('n_id_ta_copia')) {
            return response()->json([
                'mensaje' => 'No se pudieron procesar los valores de : id de documento(copia o fotocopia)',
                'codigo' => 422
            ], 422);
        }

        DocumentoInternoAdjunto::create($request->all());
        return response()->json(['mensaje' => 'Adjunto creado correctamente!'], 201);

    }


    public function update(Request $request, $id)
    {

        $bandera = false;
        $adjunto = DocumentoInternoAdjunto::find($id);
        //Datos que pueden ser modificados

        $dFechaEliminacion = $request->input('d_fecha_eliminacion');
        $nTipoDestinatario = $request->input('n_id_tipo_destinatario');
        $nTipoDocumento = $request->input('n_id_ta_tipo_documento');
        $nCan = $request->input('n_can');
        $nCopia = $request->input('n_id_ta_copia');
        $cCite = $request->input('c_cod_cite');
        $numero = sizeof($adjunto);
        //Obteniendo los datos
        if (!$adjunto || $numero == 0) {
            return response()->json([
                'mensaje' => 'No se encuentra los datos del adjunto ha ser modificado',
                'codigo' => 404
            ], 404);
        }

        if ($dFechaEliminacion != null && $dFechaEliminacion != '') {
            $adjunto->d_fecha_eliminacion = $dFechaEliminacion;
            $bandera = true;
            //log::debug('holas montavacas222');
        }
        if ($nTipoDestinatario != null && $nTipoDestinatario != '') {
            $adjunto->n_id_tipo_destinatario = $nTipoDestinatario;
            $bandera = true;
        }
        if ($nTipoDocumento != null && $nTipoDocumento != '') {
            $adjunto->n_id_ta_tipo_documento = $nTipoDocumento;
            $bandera = true;
        }
        if ($nCan != null && $nCan != '') {
            $adjunto->n_can = $nCan;
            $bandera = true;
        }
        if ($nCopia != null && $nCopia != '') {
            $adjunto->n_id_ta_copia = $nCopia;
            $bandera = true;
        }
        if ($cCite != null && $cCite != '') {
            $adjunto->c_cod_cite = $cCite;
            $bandera = true;
        }


        if ($bandera) {
            $adjunto->save();
            return response()->json(['mensaje' => 'Datos de adjuntos de correspondencia editados'], 200);
        }

        return response()->json([
            'mensaje' => 'No se pudieron editar los valores de adjunto de correspondencia',
            'codigo' => 422
        ], 422);

    }

}
