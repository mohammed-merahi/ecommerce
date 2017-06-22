<?php
    session_start();
    include('../db.php');

    $email    = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT codeclient, mail, ville, raison, adresse, cp, departement, pays, photo
                FROM clients
                LEFT JOIN myphotos ON CONCAT('US', clients.codeclient ) = myphotos.code
                WHERE mail='". $email ."' AND pass='". md5($password) ."'";
    $res = mysql_query( $query );
    if( mysql_num_rows($res) == 1 ){//valid user
          while( $i = mysql_fetch_assoc($res) ){
              $_SESSION['typeCompte']   = 'Client';
              $_SESSION['mail']         = $email;
              $_SESSION['codeclient']   = $i['codeclient'];
              $_SESSION['ville']        = $i['ville'];
              $_SESSION['raison']       = $i['raison'];
              $_SESSION['avatar']       = $i['photo'];
          }

          echo "true";
    }else{
        echo "false";
    }

?>