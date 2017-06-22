<?php

/* *
 * URL: http://localhost/StudentApp/v1/myphotos
 * */
$app->get('/myphotos', 'authenticateAdmin', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllMyphotos();
    $response = array();
    $response['error'] = false;
    $response['test'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['code'] = $row['code'];
        $temp['photo'] = utf8_encode($row['photo']);
        $temp['photo2'] = utf8_encode($row['photo2']);
        $temp['extention'] = $row['extention'];
        array_push($response['test'],$temp);
    }

    echoResponse(200,$response);
});

$app->get('/myphoto/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    $result = $db->getMyphoto($id);
    $response = array();
    $response['error'] = false;
    $response['myphoto'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['code'] = $row['code'];
        $temp['photo'] = utf8_encode($row['photo']);
        $temp['photo2'] = utf8_encode($row['photo2']);
        $temp['extention'] = $row['extention'];
        array_push($response['myphoto'],$temp);
    }
    echoResponse(200,$response);
});



$app->post('/myphoto/add', 'authenticateAdmin', function () use ($app) {
    verifyRequiredParams(array('code', 'extention' ));
	
    $code = $app->request->post('code');
    $extention = $app->request->post('extention');
	
	$photo = $app->request->post('photo');
	if( !isset($photo) )
		$photo = "";
    $photo2 = $app->request->post('photo2');
	if( !isset($photo2) )
		$photo2 = "";
	
    $response = array();
	
	$db = new DbOperation();
	$res = $db->createMyphoto( $code, $photo, $photo2, $extention );
	
	if ( $res != 0 ) {
		$response["error"] = true;
		$response["message"] = "une erreur s'est produite";
	} else {
		$response["error"] = false;
		$response["message"] = "Photo créée avec succès";
	} 
	echoResponse(200,$response);
	
	
});

$app->put('/myphoto/update/:id', 'authenticateAdmin', function($id) use ($app){
    verifyRequiredParams(array('code', 'extention' ));
    $db = new DbOperation();
	$oldcode = $id;
	$newcode = $app->request->put('code');
    $extention = $app->request->post('extention');
    
	$photo = $app->request->post('photo');
	if( !isset($photo) )
		$photo = "";
    $photo2 = $app->request->post('photo2');
	if( !isset($photo2) )
		$photo2 = "";
	
	
    $result = $db->updateMyphoto($oldcode,$newcode,$photo, $photo2, $extention);
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

$app->delete('/myphoto/delete/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    if($db->deleteMyphoto($id)){
        $response['error'] = false;
        $response['message'] = "La photo a été supprimée";
    }else{
        $response['error'] = true;
        $response['message'] = "La photo n'a pas pu être supprimée";
    }
    echoResponse(200,$response);
});