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
          //Verificando que se estan enviando todos los valores y que son obligatorios
          if(!$request->input('n_nro') || !$request->input('n_ano') || !$request->input('n_mes') || !$request->input('n_id_usuario'))                      
          {
             return response()->json(['mensaje'=>'No se pudieron procesar los valores de: numero, gestion, mes o usuario','codigo'=>422],422);
          }
          if(!$request->input('n_id_tipo_ta_tipo_destinatario') || !$request->input('n_ger_origen') || !$request->input('n_ger_destino') || !$request->input('n_gerencia_doc_fis'))
          {
            return response()->json(['mensaje'=>'No se pudieron procesar los valores de: tipo de destinatario, gerencia origen, gerencia destino o gerencia fis','codigo'=>422],422);
          }
          if(!$request->input('n_id_emp_der') || !$request->input('n_cod_suc') || !$request->input('d_fecha_ingreso') || !$request->input('t_hora_ingreso'))
          {
           return response()->json(['mensaje'=>'No se pudieron procesar los valores de: empleado, sucursal, fecha de ingreso o hora de ingreso.','codigo'=>422],422); 
          } 
          if(!$request->input('c_referencia') || !$request->input('n_cod_trab'))
          {
            return response()->json(['mensaje'=>'No se pudieron procesar los valores: asunto y trabajo','codigo'=>422],422); 
          }
          // 
          if(!$request->input('c_cod_cite'))
          {
           $request->input('c_cod_cite') = null;
          }  

          //inicio: estas condiciones deben ser modificadas
          if($request->input('n_cod_trab')==10)
          {
            $request->input('n_urgente') = 1;
          } 
          else
          {
             $request->input('n_urgente') = 0;
          } 
          //estos datos son modificables de acuerdo a lo que se envia o registra de adjuntos y correspondencia externa
          $request->input('n_corres_externa') = 0;
          $request->input('n_adjuntos') = 0;
          // fin: estas condiciones deben ser modificadas
                                        
                                        
          $request->input('d_fecha_finalizacion') = null;
          $request->input('d_fecha_eliminacion') = null;                                       
          $request->input('n_eliminado') = 0;
          $request->input('n_visto') = 0;
          $request->input('c_estado') = 'P';
          //alguna vez puede ser nullo
                                         
                                           
                                       

                                       
                                      
        
        
          
        
        CorrespondenciaInterna::create($request->all());
        return response()->json(['mensaje'=>'Correspondencia Interna creada'],201);   
        //return 'hola amigos';
    }
}