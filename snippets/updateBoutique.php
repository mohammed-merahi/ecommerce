<?php
    
    $banner           = trim($_POST['banner']);
    $data             = trim( $_POST['data'] );
    $grille           = trim($_POST['grille']);
    $liste            = trim( $_POST['liste'] );
    $tableauAvecImg   = trim($_POST['tableauAvecImg']);
    $tableauSansImg   = trim( $_POST['tableauSansImg'] );
    $produitsParPage  = trim( $_POST['produitsParPage'] );
    $produitsNonDispo = trim($_POST['produitsNonDispo']);
    $tva              = trim( $_POST['tva'] );
    $frais            = trim( $_POST['frais'] );
        
    $xml = simplexml_load_file("../config/parametres.xml");
    $obj = $xml->xpath( '/parametres/affichage/boutique' );    
    
    if( $banner != "" )
        $obj[0]->banner   = $banner;
    

    if( $grille == "true" )
        $obj[0]->modesAffichage->grille = "Oui";
    else
        $obj[0]->modesAffichage->grille = "Non";

    if( $liste == "true" )
        $obj[0]->modesAffichage->liste = "Oui";
    else
        $obj[0]->modesAffichage->liste = "Non";

    if( $tableauAvecImg == "true" )
        $obj[0]->modesAffichage->tableauAvecImg = "Oui";
    else
        $obj[0]->modesAffichage->tableauAvecImg = "Non";

    if( $tableauSansImg == "true" )
        $obj[0]->modesAffichage->tableauSansImg = "Oui";
    else
        $obj[0]->modesAffichage->tableauSansImg = "Non";

    if( $produitsParPage != "" )    
        $obj[0]->produitsParPage   = $produitsParPage;

    if( $produitsNonDispo == "true" )    
        $obj[0]->produitsNonDispo  = "Oui";
    else
        $obj[0]->produitsNonDispo  = "Non";

    if( $tva != "" )
        $obj[0]->tva             = $tva;

    if( $frais != "" )
        $obj[0]->fraisLivraison  = $frais;
    

    $xml->asXML("../config/parametres.xml");

    //uploading banner
    if( $banner != "" ){
        $source = fopen($data, 'r');
        $destination = fopen('../assets/img/' . $banner, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

?>