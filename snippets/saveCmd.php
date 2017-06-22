<?php
    session_start();
    
    if( isset( $_SESSION['codeclient'] ) ){
            //générer code cmd
            include('../db.php');
            $q   = "SELECT max(code) AS NB FROM ccs";
            $res = mysql_query( $q );
            while( $i = mysql_fetch_assoc($res) ){
                $code   = $i['NB'];
                $code   = explode("/", $i['NB'])[0];
                $prefix = explode("/", $i['NB'])[1];
                $code   = intval($code) + 1;

                if( $code < 10 )
                    $code = '00' . $code;
                else if( $code < 100 )
                    $code = '0' . $code;

                $code .= '/' . $prefix;        
            }

            //insert line into 'ccs'
            $codeclient = $_SESSION['codeclient'];
            $raison     = $_SESSION['raison'];
            $date       = Date('Y-m-d');
            $total_ht   = $_SESSION['total_ht'];
            $total_tva  = $_SESSION['total_tva'];
            $livrer     = 'Non';
            $create     = Date('Y-m-d h:i:s');
            $update     = Date('Y-m-d h:i:s');
            $agent      = 'admin';
            $etat_web   = 'En cours';

            $query = "INSERT INTO ccs(code,codeclient,raison,date,total_ht,total_tva,livrer,`create`,`update`,agent,
                                      depot,commercial,mode,devise,trans_type,trans_num,bc_num,etat,etat_web) 
                VALUES('$code','$codeclient','$raison','$date',$total_ht,$total_tva,'$livrer','$create','$update','$agent',
                                        '','','','','','','','','$etat_web') ";
            
            mysql_query( $query );
        
            //insert articles into cmds_clients
            for($a=1;$a<$_SESSION['articles_count'];$a++){
                if( $_SESSION['qte_'.$a] == 0 )
                    continue;
                else{
                    $codeart = $_SESSION['article_'.$a];
                    $qte     = $_SESSION['qte_'.$a];
                                        
                    $q = "SELECT ref,designation, pmp, prix_vente1,tva FROM articles WHERE codeart='" . $codeart . "'";
                    $res = mysql_query( $q );
                    while( $i = mysql_fetch_assoc( $res ) ){
                        $ref          = $i['ref'];
                        $designation  = $i['designation'];
                        $prix_achat   = $i['pmp'];
                        $prix_ht      = $i['prix_vente1'];
                        $prix_org     = $i['prix_vente1'];
                        $tva          = $i['tva'];   
                    }
                    
                    $query = "INSERT INTO cmds_clients(piece,num_piece,codeart,ref,designation,prix_achat,qte,prix_ht,tva,date,codeclient,prix_org) 
                                        VALUES('CC','$code','$codeart','$ref','$designation',$prix_achat,$qte,$prix_ht,$tva,'$date','$codeclient', $prix_org ) ";
                    //echo $query;exit;
                    mysql_query( $query );
                }
            }
        
            echo "true";exit;
    }else{
        echo "false";exit;
    }
?>