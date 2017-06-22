<?php

    /* *
 * URL: http://localhost/StudentApp/v1/categories
 * */
$app->get('/categories', 'authenticateAdmin', function() use ($app){
    $db = new DbOperation();
    $result = $db->getAllCategories();
    $response = array();
    $response['error'] = false;
    $response['categories'] = array();

    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['categorie'] = utf8_encode($row['categorie']);
        $temp['color'] = $row['color'];
        $temp['commentaire'] = utf8_encode($row['commentaire']);
        array_push($response['categories'],$temp);
    }

    echoResponse(200,$response);
});


$app->get('/categorie/:id', 'authenticateAdmin', function($categorie_id) use ($app){
    $db = new DbOperation();
    $result = $db->getCategorie($categorie_id);
    $response = array();
    $response['error'] = false;
    $response['assignments'] = array();
    while($row = $result->fetch_assoc()){
        $temp = array();
        $temp['categorie'] = utf8_encode($row['categorie']);
        $temp['color'] = $row['color'];
        $temp['commentaire'] = utf8_encode($row['commentaire']);
        array_push($response['assignments'],$temp);
    }
    echoResponse(200,$response);
});


$app->post('/categorie/add', 'authenticateAdmin', function () use ($app) {
    verifyRequiredParams(array('categorie', 'color', 'commentaire'));
	
    $categorie = $app->request->post('categorie');
    $color = $app->request->post('color');
    $commentaire = $app->request->post('commentaire');
    $response = array();
	
	if( $categorie != "" and $color != "" ){
		$db = new DbOperation();
		$res = $db->createCategorie($categorie, $color, $commentaire);
		// $res = $db->createCategorie("ACCESSORIESSSS", 555, "me te re");
		
		if ($res == 0) {
			$response["error"] = false;
			$response["message"] = "categorie créé avec succès";
		} else if ($res == 1) {
			$response["error"] = true;
			$response["message"] = "une erreur s'est produite";
		} 
	}else{
		$response["error"] = true;
		$response["message"] = "Paramètres incomplets";
	}	
	
    echoResponse(200,$response);
	
});

$app->put('/categorie/update/:id', 'authenticateAdmin', function($id) use ($app){
    verifyRequiredParams(array('categorie', 'color', 'commentaire'));
    $db = new DbOperation();
	$oldcateg = $id;
	$newcateg = $app->request->put('categorie');
    $color = $app->request->put('color');
    $commentaire = $app->request->put('commentaire');
	
    $result = $db->updateCategorie($oldcateg,$newcateg,$color,$commentaire);
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

$app->delete('/categorie/delete/:id', 'authenticateAdmin', function($id) use ($app){
    $db = new DbOperation();
    if($db->deleteCategorie($id)){
        $response['error'] = false;
        $response['message'] = "La catégorie a été supprimée";
    }else{
        $response['error'] = true;
        $response['message'] = "La catégorie n'a pas pu être supprimée";
    }
    echoResponse(200,$response);
});