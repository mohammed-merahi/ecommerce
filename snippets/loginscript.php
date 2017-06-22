<?php
      session_start();
      include('../db.php');

      $username = trim($_POST['username']);
      $password = trim($_POST['password']);
      $remember = trim($_POST['remember']);

      if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
          //client
          $query = "SELECT  codeclient, 
                            mail, 
                            ville, 
                            raison, 
                            adresse, 
                            telephone,
                            cp, 
                            departement, 
                            pays, 
                            photo, 
                            clients.remise,
                            clients.notva,
                            clients.tarification
                    FROM clients
                    LEFT JOIN myphotos ON CONCAT('US', clients.codeclient ) = myphotos.code
                    WHERE mail='$username' AND pass=md5('$password') ";

          $res = mysql_query( $query );
          if( mysql_num_rows($res) == 1 ){//valid user
              while( $i = mysql_fetch_assoc($res) ){
                  $_SESSION['typeCompte']   = 'Client';
                  $_SESSION['mail']         = $username;
                  $_SESSION['codeclient']   = $i['codeclient'];
                  $_SESSION['ville']        = $i['ville'];
                  $_SESSION['raison']       = $i['raison'];
                  $_SESSION['adresse']      = $i['adresse'];
                  $_SESSION['telephone']    = $i['telephone'];
                  $_SESSION['avatar']       = $i['photo'];
                  $_SESSION['remise']       = $i['remise'];
                  $_SESSION['tarification'] = $i['tarification'];
                  $_SESSION['notva']        = $i['notva'];
              }
              echo "0";
          }else{
              echo "-1";
          }

      }
      else {
          //utilisateur
          $query = "SELECT  login,
                            cat,
                            lastacces,
                            Module_PPA,
                            Module_GammeOperatoire,
                            Module_Production,
                            Module_Importation
                      FROM myusers
                      LEFT JOIN mymodules ON 1=1
                      WHERE login LIKE '$username'
                          AND pass=md5('$password') ";

          $res = mysql_query( $query );
          if( mysql_num_rows($res) == 1 ){//valid user
              while( $i = mysql_fetch_assoc($res) ){
                    $_SESSION['login']        = $i['login'];
                    $_SESSION['cat']          = $i['cat'];
                    $_SESSION['typeCompte']   = 'Admin';
                    $_SESSION['mail']         = $username;
                    $_SESSION['PPA']          = $i['Module_PPA'];
                    $_SESSION['adresse']      = '';
                    $_SESSION['telephone']    = '';

                    $xml      = simplexml_load_file("../config/parametres.xml");
                    $_SESSION['avatar']       = "assets/img/" . $xml->xpath( '/parametres/themes/profile' )[0];
              }
              echo "0";
          }else{
              echo "-1";
          }

      }

?>
