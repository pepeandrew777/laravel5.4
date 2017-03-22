<?php
namespace App\Http\Controllers;
use DB;
use App\models\CorrespondenciaInterna;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;


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
          return response()->json(['datos'=>$correspondencias],200);
        }
       catch(Exception $e){       
              return response()->json('Error' . $e->getMessage(), $e->getCode());    
              Log::debug('Error al tratar de ver la correspondencia interna: '.$e);
       }
 
    }
    public function show($id)
    {    
    	  try 
    	  {

            $correspondencia = DB::table('ta_corres_interna')->where('id',$id)->whereNull('d_fecha_eliminacion')->get();                
            Log::debug($correspondencia);
            if(!$correspondencia)
            {
       	     return response()->json(['mensaje'=>'No se encuentra la correspondencia interna en la base de datos','codigo'=>404],404);
            }
             return response()->json(['datos'=>$correspondencia,200]);
          
          }
         catch(Exception $e){
           return response()->json('Error' . $e->getMessage(), $e->getCode());    
           Log::debug('Error al tratar de ver la correspondencia interna: '.$e);              
         }
   }
   
    // public function store(Request $request)
     public function store(Request $request)
    {

          $correspondenciaInterna = new CorrespondenciaInterna;                         
          if(!$request->input('n_nro') || !$request->input('n_ano') || !$request->input('n_mes') )
                                     
                   /*
                                       || !$request->input('n_id_usuario') 

                                       || !$request->input('n_id_tipo_ta_tipo_destinatario') 
                                       || !$request->input('n_ger_origen') 
                                       || !$request->input('n_ger_destino') 
                                       || !$request->input('n_gerencia_doc_fis')
                                       || !$request->input('n_id_emp_der')
                                       || !$request->input('n_cod_suc')
                                       || !$request->input('d_fecha_ingreso')
                                       || !$request->input('t_hora_ingreso')
                                       || !$request->input('d_fecha_finalizacion')
                                       || !$request->input('d_fecha_eliminacion')
                                       || !$request->input('n_eliminado')
                                       || !$request->input('c_referencia')
                                       || !$request->input('c_cod_cite')
                                       || !$request->input('c_estado')
                                       || !$request->input('n_cod_trab')
                                       || !$request->input('n_visto')
                                       || !$request->input('n_urgente')
                                       || !$request->input('n_corres_externa')
                                       || !$request->input('n_adjuntos')) */
        {
         return response()->json(['mensaje'=>'No se pudieron procesar los valores','codigo'=>422],422);
        }  
        
        CorrespondenciaInterna::create($request->all());
        return response()->json(['mensaje'=>'Correspondencia Interna creada'],201);   
        //return 'hola amigos';
    }
}