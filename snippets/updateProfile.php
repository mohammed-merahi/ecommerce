<?php
    $codeclient =   trim($_POST['codeclient']);
    $mail       =   trim($_POST['mail']);
    $raison     =   trim($_POST['raison']);
    $ville      =   trim($_POST['ville']);
    $tel        =   trim($_POST['tel']);
    $mobile     =   trim($_POST['mobile']);
    $avatar     =   trim($_POST['avatar']);
    $ext        =   trim($_POST['ext']);

    include("../db.php");
    $query = "UPDATE clients
                SET mail        = '$mail',
                    raison      = '$raison',
                    ville       = '$ville',
                    telephone   = '$tel',
                    mobile      = '$mobile'
                WHERE codeclient='$codeclient' ";
    $res = mysql_query( $query );

    //photo de profile
    if( $ext != '' and $ext != 'undefined' ){
        $code = "US" . $codeclient;
        $query = "REPLACE INTO myphotos(code, photo, extention) VALUES('$code', '$avatar', '$ext')  ";
        mysql_query( $query );
    }
?>
