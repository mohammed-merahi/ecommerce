<?php
    
    $banner       = trim($_POST['banner']);
    $data1        = trim( $_POST['data1'] );
    $societe      = trim($_POST['societe']);
    $slogan       = trim( $_POST['slogan'] );
    $image        = trim($_POST['image']);
    $data2        = trim( $_POST['data2'] );
    $description  = trim( $_POST['description'] );
    $description2 = trim( $_POST['description2'] );
        
    $xml = simplexml_load_file("../config/parametres.xml");
    $obj = $xml->xpath( '/parametres/affichage/about' );    


    if( $banner != "" )
        $obj[0]->banner   = $banner;
    
    if( $societe != "" )    
        $obj[0]->societe   = $societe;
    
    if( $slogan != "" )    
        $obj[0]->slogan   = $slogan;
    
    if( $image != "" )    
        $obj[0]->image   = $image;
    
    if( $description != "" )    
        $obj[0]->description   = $description;
    
    if( $description2 != "" )    
        $obj[0]->description2   = $description2;


    $xml->asXML("../config/parametres.xml");

    //uploading banner
    if( $banner != "" ){
        $source = fopen($data1, 'r');
        $destination = fopen('../assets/img/' . $banner, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }


    //uploading image
    if( $image != "" ){
        $source = fopen($data2, 'r');
        $destination = fopen('../assets/img/' . $image, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

?>