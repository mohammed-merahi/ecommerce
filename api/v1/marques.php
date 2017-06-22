<?php


$app->get('/marques', 'authenticateAdmin', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllMarques();
    $response = array();
    $response['error'] = false;
    $response['marques'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['marque'] = utf8_encode($row['marque']);
        $temp['commentaire'] = utf8_encode($row['commentaire']);
        array_push($response['marques'],$temp);
    }

    echoResponse(200,$response);
});


$app->get('/marque/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    $result = $db->getMarque($id);
    $response = array();
    $response['error'] = false;
    $response['marques'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['marque'] = utf8_encode($row['marque']);
        $temp['commentaire'] = utf8_encode($row['commentaire']);
        array_push($response['marques'],$temp);
    }
    echoResponse(200,$response);
});


$app->post('/marque/add', 'authenticateAdmin', function () use ($app) {
    verifyRequiredParams(array('marque', 'commentaire'));
	
    $marque = $app->request->post('marque');
    $commentaire = $app->request->post('commentaire');
    $response = array();
	
	if( $marque != ""  ){
		$db = new DbOperation();
		$res = $db->createMarque($marque, $commentaire);
		
		if ($res == 0) {
			$response["error"] = false;
			$response["marque"] = "Marque créé avec succès";
		} else if ($res == 1) {
			$response["error"] = true;
			$response["marque"] = "une erreur s'est produite";
		} 
	}else{
		$response["error"] = true;
		$response["marque"] = "Paramètres incomplets";
	}	
	
    echoResponse(200,$response);
	
});

$app->put('/marque/update/:id', 'authenticateAdmin', function($id) use ($app){
    verifyRequiredParams(array('marque', 'commentaire'));
    $db = new DbOperation();
	$oldmarque = $id;
	$newmarque = $app->request->put('marque');
    $commentaire = $app->request->put('commentaire');
	
    $result = $db->updateMarque($oldmarque,$newmarque,$commentaire);
    $response = array();
    if($result){
        $response['error'] = false;
        $response['message'] = "Marque modifiée avec succès";
    }else{
        $response['error'] = true;
        $response['message'] = "Erreur lors de la modification de la marque" ;
    }
    echoResponse(200,$response);
});

$app->delete('/marque/delete/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    if($db->deleteMarque($id)){
        $response['error'] = false;
        $response['message'] = "La marque a été supprimée";
    }else{
        $response['error'] = true;
        $response['message'] = "La marque n'a pas pu être supprimée";
    }
    echoResponse(200,$response);
});