<?php
    
    $banner     = trim($_POST['banner']);
    $data1      = trim( $_POST['data1'] );
    $adresse    = trim($_POST['adresse']);
    $ville      = trim($_POST['ville']);
    $postal     = trim($_POST['postal']);
    $fixe       = trim( $_POST['fixe'] );
    $mobile     = trim($_POST['mobile']);
    $email      = trim( $_POST['email'] );
    $email2     = trim( $_POST['email2'] );
    $latitude   = trim( $_POST['latitude'] );
    $longitude  = trim( $_POST['longitude'] );
    $facebook   = trim( $_POST['facebook'] );
    $googleplus = trim( $_POST['googleplus'] );
    $twitter    = trim( $_POST['twitter'] );
        
    $xml = simplexml_load_file("../config/parametres.xml");
    $obj = $xml->xpath( '/parametres/affichage/contact' );    


    if( $banner != "" )
        $obj[0]->banner     = $banner;
    
    if( $adresse != "" )    
        $obj[0]->adresse    = $adresse;
    
    if( $ville != "" )    
        $obj[0]->ville      = $ville;
    
    if( $postal != "" )    
        $obj[0]->postal    = $postal;
    
    if( $fixe != "" )    
        $obj[0]->fixe       = $fixe;

    
    if( $mobile != "" )    
        $obj[0]->mobile     = $mobile;
    
    if( $email != "" )    
        $obj[0]->email      = $email;

    if( $email2 != "" )    
        $obj[0]->email2     = $email2;

    if( $latitude != "" )    
        $obj[0]->googleMaps->latitude   = $latitude;

    if( $longitude != "" )    
        $obj[0]->googleMaps->longitude  = $longitude;

    if( $facebook != "" )    
        $obj[0]->facebook      = $facebook;

    if( $googleplus != "" )    
        $obj[0]->googleplus    = $googleplus;

    if( $twitter != "" )    
        $obj[0]->twitter       = $twitter;

    $xml->asXML("../config/parametres.xml");

    //uploading banner
    if( $banner != "" ){
        $source = fopen($data1, 'r');
        $destination = fopen('../assets/img/' . $banner, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

?>