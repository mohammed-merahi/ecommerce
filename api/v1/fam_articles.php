<?php

$app->post('/fam_article/add', 'authenticateAdmin', function () use ($app) {
    verifyRequiredParams(array('famille', 'libelle'));
	
    $famille = $app->request->post('famille');
    $libelle = $app->request->post('libelle');
	
	$parent = $app->request->post('parent');
	if( !isset($parent) )
		$parent = "";
    $tva = $app->request->post('tva');
	if( !isset($tva) )
		$tva = "";
	$codeart = $app->request->post('codeart');
	if( !isset($codeart) )
		$codeart = "";
	$codetaxe = $app->request->post('codetaxe');
	if( !isset($codetaxe) )
		$codetaxe = "";
	$marge1 = $app->request->post('marge1');
	if( !isset($marge1) )
		$marge1 = "";
	$marge2 = $app->request->post('marge2');
	if( !isset($marge2) )
		$marge2 = "";
	$marge3 = $app->request->post('marge3');
	if( !isset($marge3) )
		$marge3 = "";
	$marge4 = $app->request->post('marge4');
	if( !isset($marge4) )
		$marge4 = "";
	$marge5 = $app->request->post('marge5');
	if( !isset($marge5) )
		$marge5 = "";
	$ct = $app->request->post('ct');
	if( !isset($ct) )
		$ct = "";
	$color = $app->request->post('color');
	if( !isset($color) )
		$color = "";
	$printer = $app->request->post('printer');
	if( !isset($printer) )
		$printer = "";
	
	
    $response = array();
	
	$db = new DbOperation();
	$res = $db->createFamArticle( $famille,$libelle,$parent,$tva,$codeart,$codetaxe,$marge1,$marge2,$marge3,$marge4,$marge5,$ct,$color,$printer );
	
	if ( $res != 0 ) {
		$response["error"] = true;
		$response["message"] = "une erreur s'est produite";
	} else {
		$response["error"] = false;
		$response["message"] = "Famille article créée avec succès";
	} 
	echoResponse(200,$response);
	
	
});

$app->get('/fam_articles', 'authenticateAdmin', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllFam_Articles();
    $response = array();
    $response['error'] = false;
    $response['test'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['famille'] = $row['famille'];
        $temp['libelle'] = $row['libelle'];
        $temp['parent'] = $row['parent'];
        $temp['tva'] = $row['tva'];
        $temp['codeart'] = $row['codeart'];
        $temp['codetaxe'] = $row['codetaxe'];
        $temp['marge1'] = $row['marge1'];
        $temp['marge2'] = $row['marge2'];
        $temp['marge3'] = $row['marge3'];
        $temp['marge4'] = $row['marge4'];
        $temp['marge5'] = $row['marge5'];
        $temp['ct'] = $row['ct'];
        $temp['color'] = $row['color'];
        $temp['printer'] = $row['printer'];
        array_push($response['test'],$temp);
    }

    echoResponse(200,$response);
});

$app->get('/fam_article/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    $result = $db->getFamArticle($id);
    $response = array();
    $response['error'] = false;
    $response['myphoto'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['famille'] = $row['famille'];
        $temp['libelle'] = $row['libelle'];
        $temp['parent'] = $row['parent'];
        $temp['tva'] = $row['tva'];
        $temp['codeart'] = $row['codeart'];
        $temp['codetaxe'] = $row['codetaxe'];
        $temp['marge1'] = $row['marge1'];
        $temp['marge2'] = $row['marge2'];
        $temp['marge3'] = $row['marge3'];
        $temp['marge4'] = $row['marge4'];
        $temp['marge5'] = $row['marge5'];
        $temp['ct'] = $row['ct'];
        $temp['color'] = $row['color'];
        $temp['printer'] = $row['printer'];
        array_push($response['myphoto'],$temp);
    }
    echoResponse(200,$response);
});

$app->put('/fam_article/update/:id', 'authenticateAdmin', function($id) use ($app){
    verifyRequiredParams(array('famille','libelle','parent','tva','codeart','codetaxe','marge1','marge2','marge3','marge4','marge5','ct','color','printer'));
    $db = new DbOperation();
	
    $oldfamille = $id;
    $newfamille = $app->request->put('famille');
    $libelle = $app->request->put('libelle');
	
	$parent = $app->request->put('parent');
	if( !isset($parent) )
		$parent = "";
    $tva = $app->request->put('tva');
	if( !isset($tva) )
		$tva = "";
	$codeart = $app->request->put('codeart');
	if( !isset($codeart) )
		$codeart = "";
	$codetaxe = $app->request->put('codetaxe');
	if( !isset($codetaxe) )
		$codetaxe = "";
	$marge1 = $app->request->put('marge1');
	if( !isset($marge1) )
		$marge1 = "";
	$marge2 = $app->request->put('marge2');
	if( !isset($marge2) )
		$marge2 = "";
	$marge3 = $app->request->put('marge3');
	if( !isset($marge3) )
		$marge3 = "";
	$marge4 = $app->request->put('marge4');
	if( !isset($marge4) )
		$marge4 = "";
	$marge5 = $app->request->put('marge5');
	if( !isset($marge5) )
		$marge5 = "";
	$ct = $app->request->put('ct');
	if( !isset($ct) )
		$ct = "";
	$color = $app->request->put('color');
	if( !isset($color) )
		$color = "";
	$printer = $app->request->put('printer');
	if( !isset($printer) )
		$printer = "";
    
	$photo = $app->request->put('photo');
	if( !isset($photo) )
		$photo = "";
    $photo2 = $app->request->put('photo2');
	if( !isset($photo2) )
		$photo2 = "";
	
	
    $result = $db->updateFamArticle($oldfamille,$newfamille,$libelle,$parent,$tva,$codeart,$codetaxe,$marge1,$marge2,$marge3,$marge4,$marge5,$ct,$color,$printer);
    $response = array();
    if($result){
        $response['error'] = false;
        $response['message'] = "Photo modifiée avec succès";
    }else{
        $response['error'] = true;
        $response['message'] = "Erreur lors de la modification de la photo";
    }
    echoResponse(200,$response);
});

$app->delete('/fam_article/delete/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    if($db->deleteFamArticle($id)){
        $response['error'] = false;
        $response['message'] = "La famille article a été supprimée";
    }else{
        $response['error'] = true;
        $response['message'] = "La famille article n'a pas pu être supprimée";
    }
    echoResponse(200,$response);
});