<?php

    /* *
 * URL: http://localhost/StudentApp/v1/categories
 * */
$app->get('/mylogos', 'authenticateAdmin', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllMylogos();
    $response = array();
    $response['error'] = false;
    $response['mylogos'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['photo'] = utf8_encode($row['photo']);
        $temp['extention'] = $row['extention'];
        array_push($response['mylogos'],$temp);
    }

    echoResponse(200,$response);
});


$app->get('/mylogo/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    $result = $db->getMylogo($id);
    $response = array();
    $response['error'] = false;
    $response['mylogo'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['id'] = $row['id'];
        $temp['photo'] = utf8_encode($row['photo']);
        $temp['extention'] = $row['extention'];
        array_push($response['mylogo'],$temp);
    }
    echoResponse(200,$response);
});


$app->post('/mylogo/add', 'authenticateAdmin', function () use ($app) {
    verifyRequiredParams(array('id', 'photo', 'extention'));
	
    $id = $app->request->post('id');
    $photo = $app->request->post('photo');
    $extention = $app->request->post('extention');
    $response = array();
	
	$db = new DbOperation();
	$res = $db->createMylogo($id, $photo, $extention);
	
	if ($res == 0) {
		$response["error"] = false;
		$response["message"] = "Logo créé avec succès";
	} else if ($res == 1) {
		$response["error"] = true;
		$response["message"] = "une erreur s'est produite";
	} 
	
    echoResponse(200,$response);
	
});

$app->put('/mylogo/update/:id', 'authenticateAdmin', function($id) use ($app){
    verifyRequiredParams(array('photo', 'extention'));
    $db = new DbOperation();
    $photo = $app->request->put('photo');
    $extention = $app->request->put('extention');
	
    $result = $db->updateMylogo($id,$photo,$extention);
    $response = array();
    if($result){
        $response['error'] = false;
        $response['message'] = "Catégorie modifiée avec succès";
    }else{
        $response['error'] = true;
        $response['message'] = "Erreur lors de la modification de la catégorie" ;
    }
    echoResponse(200,$response);
});

$app->delete('/mylogo/delete/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    if($db->deleteMylogo($id)){
        $response['error'] = false;
        $response['message'] = "Le logo a été supprimée";
    }else{
        $response['error'] = true;
        $response['message'] = "Le logo n'a pas pu être supprimée";
    }
    echoResponse(200,$response);
});