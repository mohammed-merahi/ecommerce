<?php
    $mail       = trim($_POST['mail']);
    $a_pass     = trim($_POST['a_pass']);
    $n_pass     = trim($_POST['n_pass']);
    $cn_pass    = trim($_POST['cn_pass']);


    include("../db.php");
    $query = "SELECT count(codeclient) FROM clients
                WHERE mail='$mail' AND pass='$n_pass' ";
    $res = mysql_query( $query );

    if( mysql_num_rows( $res ) == 1 ){
        $query = "UPDATE clients SET pass=md5('$n_pass')
                    WHERE mail='$mail' ";
        mysql_query( $query );
        echo "0";
    }else{
        echo "-1";//mot de passe incorrect ou email n'existe pas
    }


?>
