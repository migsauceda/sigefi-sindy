<?php

include('models/Usuario.php');
session_start();
use Phalcon\Loader;
use Phalcon\Mvc\Micro;
use Phalcon\Di\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Postgresql  as PdoPostgresql;
use Phalcon\Http\Response;
use Phalcon\Exception;




$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
        __DIR__ . '/models/',
        __DIR__ . '/pojoresponse/'
    )
)->register();

$di = new FactoryDefault();
$di->set('db', function(){
	 $db = new PdoPostgresql(
	  array(
           "host"      => "127.0.0.1",
            "username"  => "postgres",
            "port"      => 5432,
            "password"  => "postgres",
            "dbname"    => "sigefi"
			//"schema" 	=>"mini_sedi"
			//"dbname"=>"bd_muestra_lufergo.mini_sedi",
        )
	 );
    return $db;

});


$app =  new Micro($di);

$app->get('/',function(){
  $response = new Response();
  $response->setJsonContent(
      array(
        'api' => 'fund'
        )
    );
  return $response;
});

	
$app->post('/robotsprueba', function() use ($app) 
{
	 $response = new Response();
	
    $robot = $app->request->getJsonRawBody();
	
	$time = time();
	// $transactionManager = new TransactionManager();

	//$transaction = $transactionManager->get();
  try
    {
			 foreach ($robot->DataFinalPersona as $detalle) { 

				
				$phql = "INSERT INTO mini_sedi.tbl_entrevistas_denunciante (cnombres,capellidos,cgenero,nprofesionid,nocupacionid,nescolaridadid,netniaid,ndiscapacidadid,iedad,cdireccion,nestadocivilid,ctelefono,personanatural,aplicagbti,nidentificacionid,cidentificacion)"
						."VALUES (:cnombres:, :capellidos:,:cgenero:,:nprofesionid:,:nocupacionid:,:nescolaridadid:,:netniaid:,:ndiscapacidadid:,:iedad:,:cdireccion:,:nestadocivilid:,:ctelefono:,:personanatural:,:aplicagbti:,:nidentificacionid:,:cidentificacion:)";
			 
				$status = $app->modelsManager->executeQuery($phql, array(
					'cnombres' => $detalle->cnombres,
					'capellidos' => $detalle->capellidos,
					'cgenero' => $detalle->cgenero,
					'nprofesionid' => $detalle->nprofesionid,
					'nocupacionid' => $detalle->nocupacionid,
					'nescolaridadid' => $detalle->nescolaridadid,
					'netniaid' => $detalle->netniaid,
					'ndiscapacidadid' => $detalle->ndiscapacidadid,
					'iedad' => $detalle->iedad,
					'cdireccion' => $detalle->cdireccion,
					'nestadocivilid' => $detalle->nestadocivilid,
					'ctelefono' => $detalle->ctelefono,
					'personanatural' => $detalle->personanatural,
					'aplicagbti' => $detalle->aplicagbti,
					'nidentificacionid' => $detalle->nidentificacionid,
					'cidentificacion' => $detalle->cidentificacion

				));
				
				$id=$robot->entrevistaid = $status->getModel()->entrevistaid;
			 
		
				
			}
		
			
			if($status->success() == true){
				 foreach ($robot->DataFinalDenuncia as $detalle) { 

				
				$phql2 = "INSERT INTO mini_sedi.tbl_denuncia_previa (dfecha_denuncia,dfecha_hecho,cnarracionhecho,cdeptodenuncia,cmunicipiodenuncia,caldea,cdireccion_denuncia,cdireccion_hecho,ccreada,dfecha_registro,thora_denuncia,thora_hecho,flatitud_lugar_hecho,flongitud_lugar_hecho,baplica_denuncia,nentrevistaid)"
				."VALUES (:dfecha_denuncia:,:dfecha_hecho:,:cnarracionhecho:,:cdeptodenuncia:,:cmunicipiodenuncia:,:caldea:,:cdireccion_denuncia:,:cdireccion_hecho:,:ccreada:,:dfecha_registro:,:thora_denuncia:,:thora_hecho:,:flatitud_lugar_hecho:,:flongitud_lugar_hecho:,:baplica_denuncia:,:nentrevistaid:)";
			 
				$statuss = $app->modelsManager->executeQuery($phql2, array(
					'dfecha_denuncia' => date("Y-m-d",$time),
					'dfecha_hecho' =>$detalle->dfecha_hecho,
					'cnarracionhecho' => $detalle->cnarracionhecho,
					'cdeptodenuncia' =>$detalle->cdeptodenuncia,
					'cmunicipiodenuncia' => $detalle->cmunicipiodenuncia,
					'caldea' =>$detalle->caldea,
					'cdireccion_denuncia' => $detalle->cdireccion_denuncia,
					'cdireccion_hecho' =>$detalle->cdireccion_hecho,
					'ccreada' => 'ELagos',
					'dfecha_registro' =>date("Y-m-d",$time),
					'thora_denuncia' => date("H:i:s", $time),
					'thora_hecho' =>$detalle->thora_hecho,
					'flatitud_lugar_hecho' => $detalle->flatitud_lugar_hecho,
					'flongitud_lugar_hecho' =>$detalle->flongitud_lugar_hecho,
					'baplica_denuncia' => $detalle->baplica_denuncia,
					'nentrevistaid' =>$id,
				));
			 }
				
				
			}
				$statuss="no entro";
			
	
			
		$response->setJsonContent(
           array(
               'status' => 200,
               'message' => 'success',
			  'data'=> $status,
			  
			  'id'=>$id,
			  'data'=> $statuss
			
           )
       );
       return $response;
	}catch(\Exception $e){
		 //$transaction->rollback("Can't save robot");
        $response->setJsonContent(
           array(
               'status' => 500,
               'message' => 'Internar error services',
               'error' => $e,
			   'data'=> $status,
			  
			  'id'=>$id,
			  'data2'=> $statuss
           )
       );
       return $response;
    }
    return $response;
});



$app->post('/denuncia',function() use($app) {
    $response = new Response();
   
	$time = time();

  try
    {
         
     $personaid=null;

         $request = $app->request->getJsonRawBody();
      
       foreach ($request->DataFinalPersona as $detalle) { 
          //$detalle->data->DataFinalPersona;

           $resentrevista= new TblEntrevistasDenunciante();
			$resentrevista->cnombres = $detalle->cnombres;
			$resentrevista->capellidos = $detalle->capellidos;
			$resentrevista->cgenero = $detalle->cgenero;
			$resentrevista->nprofesionid = $detalle->nprofesionid;
			$resentrevista->nocupacionid = $detalle->nocupacionid;
			$resentrevista->nescolaridadid = $detalle->nescolaridadid;
			$resentrevista->netniaid = $detalle->netniaid;
			$resentrevista->ndiscapacidadid = $detalle->ndiscapacidadid;	
			$resentrevista->iedad = $detalle->iedad;
			//$resentrevista->cbarrioid = $request->cbarrioid;
			//$resentrevista->orientacionsexual = $request->orientacionsexual;
			$resentrevista->cdireccion = $detalle->cdireccion;
			$resentrevista->nestadocivilid = $detalle->nestadocivilid;
			$resentrevista->ctelefono = $detalle->ctelefono;
			//$resentrevista->cmetanombre = $request->cmetanombre;
			//$resentrevista->cmetaapellido = $request->cmetaapellido;
			$resentrevista->bpersonanatural = $detalle->bpersonanatural;
			$resentrevista->baplicagbti = $detalle->baplicagbti;
			$resentrevista->nidentificacionid = $detalle->nidentificacionid;
			$resentrevista->cidentificacion = $detalle->cidentificacion;

    		$isCommit = $resentrevista->save($resentrevista);    
            $personaid=$resentrevista->entrevistaid;
		
     }

         foreach ($request->DataFinalDenuncia as $detalle2) {         
			$resdenuncia = new TblDenunciaPrevia();
			
			$resdenuncia->dfecha_denuncia = date("Y-m-d",$time);
			$resdenuncia->dfecha_hecho = $detalle2->dfecha_hecho;
			$resdenuncia->cnarracionhecho = $detalle2->cnarracionhecho;
			$resdenuncia->cdeptodenuncia = $detalle2->cdeptodenuncia;
			$resdenuncia->cmunicipiodenuncia = $detalle2->cmunicipiodenuncia;
			$resdenuncia->caldea = $detalle2->caldea;
			$resdenuncia->cdireccion_denuncia = $detalle2->cdireccion_denuncia;
			$resdenuncia->cdireccion_hecho = $detalle2->cdireccion_hecho;
			$resdenuncia->ccreada = $_SESSION['objUsuario'];
			//$resdenuncia->nidbandejaid = $request->nidbandejaid;
			$resdenuncia->dfecha_registro = date("Y-m-d",$time);
			$resdenuncia->thora_denuncia = date("H:i:s", $time);
			$resdenuncia->thora_hecho = $detalle2->thora_hecho ;
			$resdenuncia->flatitud_lugar_hecho = $detalle2->flatitud_lugar_hecho;
			$resdenuncia->flongitud_lugar_hecho = $detalle2->flongitud_lugar_hecho;
			//$resdenuncia->ntipodenunciaid = $request->ntipodenunciaid;
			$resdenuncia->baplica_denuncia = $detalle2->baplica_denuncia;
			$resdenuncia->nentrevistaid =$personaid;
        
            
    		$isCommit2 = $resdenuncia->save($resdenuncia);
       }
       
        $response->setJsonContent(
           array(
               'status' => 200,
               'message' => 'success',
			  'data'=> $resdenuncia,
			  'commit' => $isCommit
           )
       );
       return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
               'status' => 500,
               'message' => 'Internar error services',
               'error' => $e
           )
       );
       return $response;
    }
});





/**************etnias*****************/
$app->get('/etnias',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Ietnia = TblEtnia::find();
        
        foreach ($Ietnia as $res) {
            $resdato= new TblEtnia();
            $resdato->netniaid = $res->netniaid;
            $resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/**************Estado Civil*****************/
$app->get('/estadocivil',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Iestadocivil = TblEstadoCivil::find();
        
        foreach ($Iestadocivil as $res) {
            $resdato= new TblEstadoCivil();
            $resdato->ncivil = $res->ncivil;
            $resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/**************Escolaridad*****************/
$app->get('/escolaridad',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Iescolaridad = TblEscolaridad::find();
        
        foreach ($Iescolaridad as $res) {
            $resdato= new TblEscolaridad();
            $resdato->nescolaridadid = $res->nescolaridadid;
            $resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});
/********profesion************/
$app->get('/profesion',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Iprofesion = TblProfesion::find();
        
        foreach ($Iprofesion as $res) {
            $resdato= new TblProfesion();
            $resdato->nprofesionid = $res->nprofesionid;
            $resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/***********ocupacion ****************/
$app->get('/ocupacion',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Iocupacion = TblOcupacion::find();
        
        foreach ($Iocupacion as $res) {
            $resdato= new TblOcupacion();
            $resdato->nocupacionid = $res->nocupacionid;
            $resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});


/***********municipio ****************/
$app->get('/municipios/{cdepartamentoid:[0-9]+}',function($cdepartamentoid) use($app){
   $response = new Response();
      
    try{
        $data =  array();
		
		
		
        $Imunicipio = TblMunicipio::GetMuncipio($cdepartamentoid);
        
        foreach ($Imunicipio as $res) {
            $resdato= new TblMunicipio();
            $resdato->cmunicipioid = $res->cmunicipioid;
			$resdato->cdepartamentoid = $res->cdepartamentoid;
            $resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/***********municipio ****************/
$app->get('/aldeas/{municipio:[0-9]+}',function($municipio) use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Ialdea= TblAldea::GetAldea($municipio);
        
        foreach ($Ialdea as $res) {
            $resdato= new TblAldea();
			 $resdato->caldeaid = $res->caldeaid;
			$resdato->cmunicipioid = $res->cmunicipioid;
            $resdato->cdepartamentoid = $res->cdepartamentoid;
			$resdato->cdescripcion = $res->cdescripcion;
			
            $resdato->carea = $res->carea;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/***********municipio ****************/
$app->get('/tipodenuncia',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Itipodenuncia= TblTipodenuncia::find();
        
        foreach ($Itipodenuncia as $res) {
            $resdato= new TblTipodenuncia();
			 $resdato->istipodenucnia = $res->istipodenucnia;
			$resdato->cdescripcion = $res->cdescripcion;
			
  
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/***********Bandejas ****************/
$app->get('/bandejas',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Ibandeja= TblBandejas::find();
        
        foreach ($Ibandeja as $res) {
            $resdato= new TblBandejas();
			 $resdato->ilugarid = $res->ilugarid;
			$resdato->cdescripcion = $res->cdescripcion;
			$resdato->cdeptopais = $res->cdeptopais;
			$resdato->cmunicipio = $res->cmunicipio;
			$resdato->ibandejaid = $res->ibandejaid;
			$resdato->dfechatrans = $res->dfechatrans;
			
  
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});
/*********sub bandejas*************/
$app->get('/subbandejas',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Isubbandeja= TblSubbandejas::find();
        
        foreach ($Isubbandeja as $res) {
            $resdato= new TblSubbandejas();
			 $resdato->isubbandejaid = $res->isubbandejaid;
			$resdato->cdescripcion = $res->cdescripcion;
			$resdato->dfechacreacion = $res->dfechacreacion;
			$resdato->ibandejaid = $res->ibandejaid;
			$resdato->cdeptopaisid = $res->cdeptopaisid;
			$resdato->cmunicipioid = $res->cmunicipioid;
			
  
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/*********tipo de identifacion*************/
$app->get('/tipoidentificacion',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Itipodidentificacion= TblTipoDocumento::find();
        
        foreach ($Itipodidentificacion as $res) {
            $resdato= new TblTipoDocumento();
			$resdato->ndocumentoid = $res->ndocumentoid;
			$resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/*********tipo de discaoacidad*************/
$app->get('/discapacidad',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Itipodidentificacion= TblDiscapacidad::find();
        
        foreach ($Itipodidentificacion as $res) {
            $resdato= new TblDiscapacidad();
			$resdato->ndiscapacidadid = $res->ndiscapacidadid;
			$resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/*********Departamentos*************/
$app->get('/deptospais',function() use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Ideptopais= TblDepartamentoPais::GetDepto();
        
        foreach ($Ideptopais as $res) {
            $resdato= new TblDepartamentoPais();
			$resdato->cdepartamentoid = $res->cdepartamentoid;
			$resdato->cdescripcion = $res->cdescripcion;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

/*********Usuario Fiscalia*************/
$app->get('/usuariofiscalia/{idbandeja:[0-9]+}',function($idbandeja) use($app){
   $response = new Response();
      
    try{
        $data =  array();
        $Ideptopais= TblUsuarios::find("ibandejaid=$idbandeja");
        
        foreach ($Ideptopais as $res) {
            $resdato= new TblUsuarios();
			$resdato->usuario = $res->usuario;
			$resdato->contrasena = $res->contrasena;
			$resdato->ilugarid = $res->ilugarid;
			$resdato->nombres = $res->nombres;
			$resdato->pedircambiopasswd = $res->pedircambiopasswd;
			$resdato->ibandejaid = $res->ibandejaid;
			$resdato->identidad = $res->identidad;
			$resdato->apellidos = $res->apellidos;
			$resdato->vencimientoclave = $res->vencimientoclave;
			$resdato->isubbandejaid = $res->isubbandejaid;
			$resdato->rol = $res->rol;
			$resdato->fiscal = $res->fiscal;
			$resdato->bactivo = $res->bactivo;
            array_push($data,$resdato);
        }
        $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
        
    }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }
});

$app->get('/actividadfiscal/{usuario}', function ($usuario) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::ActividadFiscal($usuario);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'materia_descripcion'=>$res->materia_descripcion,
			'descripcion_actividad'=>$res->descripcion_actividad,
			'descripcion_etapa'=>$res->descripcion_etapa,
			'descripcion_sub_etapa'=>$res->descripcion_sub_etapa,
			'dfechadenuncia'=>$res->dfechadenuncia,
			'cexpedientesedi'=>$res->cexpedientesedi,
			'tdenunciaid'=>$res->tdenunciaid,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'ibandejaid'=>$res->ibandejaid,
			'fiscalia_asignada'=>$res->fiscalia_asignada,
			'cnombres'=>$res->cnombres,
			'crtn'=>$res->crtn
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});

$app->get('/ActividadFiscalpersona/{usuario}', function ($usuario) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::ActividadFiscalPersonal($usuario);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'materia_descripcion'=>$res->materia_descripcion,
			'descripcion_actividad'=>$res->descripcion_actividad,
			'descripcion_etapa'=>$res->descripcion_etapa,
			'descripcion_sub_etapa'=>$res->descripcion_sub_etapa,
			'dfechadenuncia'=>$res->dfechadenuncia,
			'cexpedientesedi'=>$res->cexpedientesedi,
			'tdenunciaid'=>$res->tdenunciaid,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'ibandejaid'=>$res->ibandejaid,
			'fiscalia_asignada'=>$res->fiscalia_asignada,
			'cnombres'=>$res->cnombres,
			'crtn'=>$res->crtn
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});


$app->get('/actividadfiscal/{usuario}/{fechainicio}/{fechafinal}', function ($usuario,$fechainicio,$fechafinal) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::ActividadFiscalFechas($usuario,$fechainicio,$fechafinal);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'materia_descripcion'=>$res->materia_descripcion,
			'descripcion_actividad'=>$res->descripcion_actividad,
			'descripcion_etapa'=>$res->descripcion_etapa,
			'descripcion_sub_etapa'=>$res->descripcion_sub_etapa,
			'dfechadenuncia'=>$res->dfechadenuncia,
			'cexpedientesedi'=>$res->cexpedientesedi,
			'tdenunciaid'=>$res->tdenunciaid,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'ibandejaid'=>$res->ibandejaid,
			'fiscalia_asignada'=>$res->fiscalia_asignada,
			'cnombres'=>$res->cnombres,
			'crtn'=>$res->crtn
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});

$app->get('/actividadfiscalpersona/{usuario}/{fechainicio}/{fechafinal}', function ($usuario,$fechainicio,$fechafinal) use ($app) {

/*if(isset($_SESSION['objUsuario'])){
	$var=$_SESSION['objUsuario'];

	echo $var->getUsuario();

}*/
$response = new Response();
	try{
	$ar = Reportes::ActividadFiscalFechas($usuario,$fechainicio,$fechafinal);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'materia_descripcion'=>$res->materia_descripcion,
			'descripcion_actividad'=>$res->descripcion_actividad,
			'descripcion_etapa'=>$res->descripcion_etapa,
			'descripcion_sub_etapa'=>$res->descripcion_sub_etapa,
			'dfechadenuncia'=>$res->dfechadenuncia,
			'cexpedientesedi'=>$res->cexpedientesedi,
			'tdenunciaid'=>$res->tdenunciaid,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'ibandejaid'=>$res->ibandejaid,
			'fiscalia_asignada'=>$res->fiscalia_asignada,
			'cnombres'=>$res->cnombres,
			'crtn'=>$res->crtn
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
	   
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});

$app->get('/actividadfiscal/{fechainicio}/{fechafinal}', function ($fechainicio,$fechafinal) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::ActividadFiscalFechasPersona($fechainicio,$fechafinal);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'materia_descripcion'=>$res->materia_descripcion,
			'descripcion_actividad'=>$res->descripcion_actividad,
			'descripcion_etapa'=>$res->descripcion_etapa,
			'descripcion_sub_etapa'=>$res->descripcion_sub_etapa,
			'dfechadenuncia'=>$res->dfechadenuncia,
			'cexpedientesedi'=>$res->cexpedientesedi,
			'tdenunciaid'=>$res->tdenunciaid,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'ibandejaid'=>$res->ibandejaid,
			'fiscalia_asignada'=>$res->fiscalia_asignada,
			'cnombres'=>$res->cnombres,
			'crtn'=>$res->crtn
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});

$app->get('/confirmaciondenuncia', function () use ($app) {

$response = new Response();
	try{
	$ar = Reportes::ConfirmacionDenuncia();
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'tdenunciaid'=>$res->tdenunciaid,
			'tpersonaid'=>$res->tpersonaid,
			'cnombres'=>$res->cnombres,
			'crtn'=>$res->crtn,
			'ndelito'=>$res->ndelito,
			'nfiscaliaid'=>$res->nfiscaliaid,
			'timputadoid'=>$res->timputadoid,
			'dfechaasignacion'=>$res->dfechaasignacion,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'cexpedientesedi'=>$res->cexpedientesedi,
			'bandeja'=>$res->bandeja,
			'subbandeja'=>$res->subbandeja
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});

$app->get('/confirmaciondenunciajefe/{usuario}', function ($usuario) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::Usuariohijos($usuario);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'usuario'=>$res->usuario,
			'nombres'=>$res->nombres
		
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});



/*$app->get('/confirmaciondenuncia/{nombre}', function ($nombre) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::ConfirmacionDenunciaNombre($nombre);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'tdenunciaid'=>$res->tdenunciaid,
			'tpersonaid'=>$res->tpersonaid,
			'cnombres'=>$res->cnombres,
			'crtn'=>$res->crtn,
			'ndelito'=>$res->ndelito,
			'nfiscaliaid'=>$res->nfiscaliaid,
			'timputadoid'=>$res->timputadoid,
			'dfechaasignacion'=>$res->dfechaasignacion,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'cexpedientesedi'=>$res->cexpedientesedi,
			'bandeja'=>$res->bandeja,
			'sub_bandeja'=>$res->sub_bandeja
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

	// third
	//echo json_encode($data);
	
});*/
$app->get('/confirmaciondenuncia/{nombre}', function ($nombre) use ($app) {
$comprobar=preg_replace('/\w/','',$nombre);



$response = new Response();
  try{
        
if($comprobar==""){
                
$ar = Reportes::ConfirmacionDenunciaNombre($nombre);
  $data = array();
  foreach($ar as $res) {
    $data[] = array(
      'tdenunciaid'=>$res->tdenunciaid,
      'tpersonaid'=>$res->tpersonaid,
      'cnombres'=>$res->cnombres,
      'crtn'=>$res->crtn,
      'ndelito'=>$res->ndelito,
      'nombredelito'=>$res->nombredelito,
      'nfiscaliaid'=>$res->nfiscaliaid,
      'timputadoid'=>$res->timputadoid,
      'dfechaasignacion'=>$res->dfechaasignacion,
      'basignadafiscalia'=>$res->basignadafiscalia,
      'cexpedientesedi'=>$res->cexpedientesedi,
      'bandeja'=>$res->bandeja,
      'subbandeja'=>$res->subbandeja
    );
  }
  $response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
            }
            else{
            $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Envio algun caracter no valido'
           
           )
            
        );
        
        return $response;

            }


   }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

  // third
  //echo json_encode($data);
   
  
});
/*$app->get('/vaciadodenuncia/{delito}', function ($delito) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::VaciadoDenuncia($delito);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'tpersonaid'=>$res->tpersonaid,
			'ndelito'=>$res->ndelito,
            'delitodescripcion'=>$res->delitodescripcion,
			'tdenunciaid'=>$res->tdenunciaid,
			'cclasificacion'=>$res->cclasificacion,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'narracion_denuncia'=>$res->narracion_denuncia,
			'fecha_denuncia'=>$res->fecha_denuncia,
			'nombres_imputados'=>$res->nombres_imputados,
			'genero_imputados'=>$res->genero_imputados,
			'direccion_imputados'=>$res->direccion_imputados,
			'sexo_imputados'=>$res->sexo_imputados,
			'aplicalgbti_imputados'=>$res->aplicalgbti_imputados,
			'netniaid_imputados'=>$res->netniaid_imputados,
			'barrio_imputados'=>$res->barrio_imputados,
			'nombre_ofendido'=>$res->nombre_ofendido,
			//'rtn_ofendido'=>$res->rtn_ofendido,
			'genero_ofendido'=>$res->genero_ofendido,
			'nacionalidad_ofendido'=>$res->nacionalidad_ofendido,
			'etnia_ofendido'=>$res->etnia_ofendido,
			'edad_ofendido'=>$res->edad_ofendido,
			'direccion_ofendido'=>$res->direccion_ofendido,
			'aplicalbti_ofendido'=>$res->aplicalbti_ofendido,
			'sexo_ofendido'=>$res->sexo_ofendido,
			'nombre_denunciante'=>$res->nombre_denunciante
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

});

$app->get('/vaciadodenunciafecha/{delito}/{fechainicio}/{fechafinal}', function ($delito,$fechainicio,$fechafinal) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::VaciadoDenunciaFechas($delito,$fechainicio,$fechafinal);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'tpersonaid'=>$res->tpersonaid,
			'ndelito'=>$res->ndelito,
            'delitodescripcion'=>$res->delitodescripcion,
			'tdenunciaid'=>$res->tdenunciaid,
			'cclasificacion'=>$res->cclasificacion,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'narracion_denuncia'=>$res->narracion_denuncia,
			'fecha_denuncia'=>$res->fecha_denuncia,
			'nombres_imputados'=>$res->nombres_imputados,
			'genero_imputados'=>$res->genero_imputados,
			'direccion_imputados'=>$res->direccion_imputados,
			'sexo_imputados'=>$res->sexo_imputados,
			'aplicalgbti_imputados'=>$res->aplicalgbti_imputados,
			'netniaid_imputados'=>$res->netniaid_imputados,
			'barrio_imputados'=>$res->barrio_imputados,
			'nombre_ofendido'=>$res->nombre_ofendido,
			//'rtn_ofendido'=>$res->rtn_ofendido,
			'genero_ofendido'=>$res->genero_ofendido,
			'nacionalidad_ofendido'=>$res->nacionalidad_ofendido,
			'etnia_ofendido'=>$res->etnia_ofendido,
			'edad_ofendido'=>$res->edad_ofendido,
			'direccion_ofendido'=>$res->direccion_ofendido,
			'aplicalbti_ofendido'=>$res->aplicalbti_ofendido,
			'sexo_ofendido'=>$res->sexo_ofendido,
			'nombre_denunciante'=>$res->nombre_denunciante
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

});*/
	// third
	//echo json_encode($data);

$app->get('/vaciadodenuncia/{delito}', function ($delito) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::VaciadoDenuncia($delito);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'tdenunciaid'=>$res->tdenunciaid,
			'personaimputada'=>$res->personaimputada,
            'fechadenuncia'=>$res->fechadenuncia,
			'fechahecho'=>$res->fechahecho,
			'thoradenuncia'=>$res->thoradenuncia,
			'thorahecho'=>$res->thorahecho,
			'narracionhecho'=>$res->narracionhecho,
			'delitodescripcion'=>$res->delitodescripcion,
			'departamentodenuncia'=>$res->departamentodenuncia,
			'cclasificacion'=>$res->cclasificacion,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'direccionhecho'=>$res->direccionhecho,
			'nombres_imputados'=>$res->nombres_imputados,
			'genero_imputados'=>$res->genero_imputados,
			'direccion_imputados'=>$res->direccion_imputados,
			'sexo_imputados'=>$res->sexo_imputados,
			'aplicalgbti_imputados'=>$res->aplicalgbti_imputados,
			'netniaid_imputados'=>$res->netniaid_imputados,
			'barrio_imputados'=>$res->barrio_imputados,
			'nombre_ofendido'=>$res->nombre_ofendido,
			'genero_ofendido'=>$res->genero_ofendido,
			'nacionalidad_ofendido'=>$res->nacionalidad_ofendido,
			//'etnia_ofendido'=>$res->etnia_ofendido,
			'edad_ofendido'=>$res->edad_ofendido,
			'direccion_ofendido'=>$res->direccion_ofendido,
			'aplicalbti_ofendido'=>$res->aplicalbti_ofendido,
			'sexo_ofendido'=>$res->sexo_ofendido,
			'nombre_denunciante'=>$res->nombre_denunciante,
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

});

$app->get('/vaciadodenunciafecha/{delito}/{fechainicio}/{fechafinal}', function ($delito,$fechainicio,$fechafinal) use ($app) {

$response = new Response();
	try{
	$ar = Reportes::VaciadoDenunciaFechas($delito,$fechainicio,$fechafinal);
	// second
	$data = array();
	foreach($ar as $res) {
		$data[] = array(
			'tdenunciaid'=>$res->tdenunciaid,
			'personaimputada'=>$res->personaimputada,
            'fechadenuncia'=>$res->fechadenuncia,
			'fechahecho'=>$res->fechahecho,
			'thoradenuncia'=>$res->thoradenuncia,
			'thorahecho'=>$res->thorahecho,
			'narracionhecho'=>$res->narracionhecho,
			'delitodescripcion'=>$res->delitodescripcion,
			'departamentodenuncia'=>$res->departamentodenuncia,
			'cclasificacion'=>$res->cclasificacion,
			'basignadafiscalia'=>$res->basignadafiscalia,
			'direccionhecho'=>$res->direccionhecho,
			'nombres_imputados'=>$res->nombres_imputados,
			'genero_imputados'=>$res->genero_imputados,
			'direccion_imputados'=>$res->direccion_imputados,
			'sexo_imputados'=>$res->sexo_imputados,
			'aplicalgbti_imputados'=>$res->aplicalgbti_imputados,
			'netniaid_imputados'=>$res->netniaid_imputados,
			'barrio_imputados'=>$res->barrio_imputados,
			'nombre_ofendido'=>$res->nombre_ofendido,
			'genero_ofendido'=>$res->genero_ofendido,
			'nacionalidad_ofendido'=>$res->nacionalidad_ofendido,
			//'etnia_ofendido'=>$res->etnia_ofendido,
			'edad_ofendido'=>$res->edad_ofendido,
			'direccion_ofendido'=>$res->direccion_ofendido,
			'aplicalbti_ofendido'=>$res->aplicalbti_ofendido,
			'sexo_ofendido'=>$res->sexo_ofendido,
			'nombre_denunciante'=>$res->nombre_denunciante,
		);
	}
	$response->setJsonContent(
           array(
            'status' => 200,
            'message' => 'success',
            'resdato' => $data
           )
            
        );
        
        return $response;
	 }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }

});
$app->get('/delito', function () use ($app) {
$response = new Response();
  try{
                
            $ar = TblDelito::delitos();
            $data = array();
            foreach($ar as $res) {
                $data[] = array(
                'ndelitoid'=>$res->ndelitoid,
                'cdescripcion'=>$res->cdescripcion
                );
            }
            $response->setJsonContent(
                    array(
                        'status' => 200,
                        'message' => 'success',
                        'resdato' => $data
                    )
                        
                    );

            return $response;
   }catch(\Exception $e){
        $response->setJsonContent(
           array(
            'status' => 500,
            'message' => 'Internal error services',
            'resdato' => $e
           )
            
        );
        
        return $response;
    }  
  
});
	

/*******fin impuestos**********/
$app->handle();
