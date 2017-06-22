<?php
    session_start();
    include("../db.php");
    $page                       = $_POST['page'];
    $articlesPage               = $_POST['articlesPage'];
    $keyword                    = $_POST['search'];

    $query = "SELECT  articles.codeart,
                      photo,
                      extention,
                      ref, 
                      designation, 
                      qte,  
                      libelle, 
                      marque,
                      prix_vente1 

                FROM articles 
                LEFT JOIN fam_articles ON articles.famille = fam_articles.famille
                LEFT JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart) ";

    //recherche
    if( $keyword != '' ){
            $query .= " WHERE ( ";  //debut des condition
            $query .= " lower(articles.designation) like lower('%$keyword%') ";
            
            if( strpos($keyword, ' ') !== false ){
                $mots = explode(" ",$keyword);
                $i    = 0;
                $mot1 = '';
                foreach( $mots as $mot ){
                    if( $i == 0 ){
                        $query .= " OR ( lower(articles.designation) like lower('%$mot%') ";
                        $mot1   = $mot;
                    }else
                        $query .= " AND   lower(articles.designation) like lower('%$mot%') ";
                    
                    $i++;
                }
                $query .= ")";
            }
            $query .= " OR    lower(articles.codeart)       LIKE lower('$keyword') ";  
            $query .= " OR    lower(ref)                    LIKE lower('$keyword') ";  
            $query .= " OR    lower(codebar)                LIKE lower('$keyword') ";    
            $query .= " OR    lower(marque)                 LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(designation2)           LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(libelle)                LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(categorie)              LIKE lower('%$keyword%') ";   
            $query .= " ) ";//fin des conditions
    }

    //sort

    //which page
    if( $articlesPage != 'All' )
        $query .= " LIMIT " . ($page-1)* $articlesPage . "," . $articlesPage;


    //echo $query;exit;  
    $res = mysql_query( $query );
    $n = ($page-1) * $articlesPage + 1;

    while( $i = mysql_fetch_assoc( $res ) ){
        $codeart = $i['codeart'];
        if( $i['photo'] != '' ){
            $img = gzuncompress( $i['photo'] );
            $file = "pe/img/articles/thumbnails/" . $i['codeart'] . '_img' . $i['extention'];
            if( !file_exists( '../' . $file ) )
                file_put_contents( '../' . $file, $img);
        }else{
            $file = '';
        }    

        echo "<tr nowrap>";
            echo "<td>" . $n                . "</td>";
            //echo "<td nowrap><a title='visualiser' target='_blank' href='" . $file   . "' ><i style='font-size:150%;' class='icon s7-next-2' aria-hidden='true'></i></a></td>";
            echo "<td nowrap><a title='visualiser' target='_blank' href='" . $file   . "' ><img style='width:33%;height:auto;' src='" . $file . "'></a></td>";
            echo "<td nowrap>" . $i['codeart']     . "</td>";
            echo "<td nowrap>" . $i['ref']         . "</td>";
            echo "<td nowrap>" . $i['designation'] . "</td>";
            echo "<td nowrap>" . $i['qte']     . "</td>";
            echo "<td nowrap>" . $i['libelle']     . "</td>";
            echo "<td nowrap>" . $i['marque']     . "</td>";
            echo "<td nowrap style='text-align:right;'>" . number_format( $i['prix_vente1'] ,2,'.',' ') . "</td>";
        echo "</tr>";
        $n++;
    }
    
?>