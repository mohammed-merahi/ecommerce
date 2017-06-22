<?php
    
    $titre      = trim($_POST['titre']);
    $theme      = trim($_POST['theme']);
    $logo       = trim($_POST['logo']);
    $ext1       = trim( $_POST['ext1'] );
    $data1      = trim( $_POST['data1'] );
    $favicon    = trim($_POST['favicon']);
    $ext2       = trim( $_POST['ext2'] );
    $data2      = trim( $_POST['data2'] );
    $banner     = trim($_POST['banner']);
    $ext3       = trim( $_POST['ext3'] );
    $data3      = trim( $_POST['data3'] );
    $bgImg      = trim($_POST['bgImage']);
    $ext4       = trim( $_POST['ext4'] );
    $data4      = trim( $_POST['data4'] );
    $dashbrd    = trim( $_POST['dashbrd'] );
    $pharmacien = trim( $_POST['pharmacien'] );
    $avatar     = trim($_POST['avatar']);
    $data5      = trim( $_POST['data5'] );
        
    $xml = simplexml_load_file("../config/parametres.xml");
    $obj = $xml->xpath( '/parametres/themes' );    
    
    if( $dashbrd != "" )
        $obj[0]->dashboard          = $dashbrd;
    if( $titre != "" )
        $obj[0]->titre              = $titre;
    if( $theme != "" )
        $obj[0]->theme              = $theme;
    if( $logo != "" )    
        $obj[0]->logo               = $logo;
    if( $favicon != "" )    
        $obj[0]->favicon            = $favicon;
    if( $banner != "" )    
        $obj[0]->banner             = $banner;
    if( $bgImg != "" )    
        $obj[0]->backgroundImage    = $bgImg;
    if( $pharmacien != "" )
        $obj[0]->pharmacien         = $pharmacien;
    if( $avatar != "" )
        $obj[0]->profile             = $avatar;

    $xml->asXML("../config/parametres.xml");

    //uploading logo
    if( $logo != "" ){
        $source = fopen($data1, 'r');
        $destination = fopen('../assets/img/' . $logo, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

    //uploading favicon
    if( $favicon != "" ){
        $source = fopen($data2, 'r');
        $destination = fopen('../assets/img/' . $favicon, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

    //uploading banner
    if( $banner != "" ){
        $source = fopen($data3, 'r');
        $destination = fopen('../assets/img/' . $banner, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

    //uploading bg image
    if( $bgImg != "" ){
        $source = fopen($data4, 'r');
        $destination = fopen('../assets/img/' . $bgImg, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

    //uploading avatar
    if( $avatar != "" ){
        $source = fopen($data5, 'r');
        $destination = fopen('../assets/img/' . $avatar, 'w');

        stream_copy_to_stream($source, $destination);

        fclose($source);
        fclose($destination);
    }

?>