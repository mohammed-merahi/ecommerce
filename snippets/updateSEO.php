<?php
    
    $metaDescription  = trim($_POST['metaDescription']);
    $keywords         = trim($_POST['keywords']);
        
    $xml = simplexml_load_file("../config/parametres.xml");
    $obj = $xml->xpath( '/parametres/seo' );    
    
    if( $metaDescription != "" )
        $obj[0]->metaDescription          = $metaDescription;

    if( $keywords != "" )
        $obj[0]->keywords              = $keywords;

    $xml->asXML("../config/parametres.xml");

?>