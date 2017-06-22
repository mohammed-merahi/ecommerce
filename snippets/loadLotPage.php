<?php
    session_start();
    include("../db.php");
    $page                       = $_POST['page'];
    $articlesPage               = $_POST['articlesPage'];
    $keyword                    = $_POST['search'];

    $query = "SELECT  if(lots.ref='',lots.num_lot,lots.ref) as 'N_lot',
                                          articles.codeart,
                                          articles.designation,
                                          articles.designation2 as 'DCI',
                                          lots.qte AS 'QTE',
                                          lots.shp AS 'SHP',
                                          lots.ppa AS 'PPA',
                                          lots.prix_revient,
                                          lots.qte*lots.prix_revient as 'Valeur_stock',
                                          lots.expire,
                                          lots.codebar_colis,
                                          lots.codebar,
                                          lots.rayon,
                                          lots.fabriquer,
                                          lots.fournisseur
                                      FROM lots CROSS JOIN articles USING(codeart)
                                      WHERE lots.qte > 0 ";

    //recherche
    if( $keyword != '' ){
            $query .= " AND ( ";  //debut des condition
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
            $query .= " OR    lower(articles.ref)           LIKE lower('$keyword') ";  
            $query .= " OR    lower(articles.codebar)       LIKE lower('$keyword') ";    
            $query .= " OR    lower(articles.marque)        LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(articles.designation2)  LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(articles.categorie)     LIKE lower('%$keyword%') ";   
            $query .= " ) ";//fin des conditions
    }

    //sort
    
    //which page
    if( $articlesPage != 'All' )
        $query .= " LIMIT " . ($page-1)* $articlesPage . "," . $articlesPage;


    $res = mysql_query( $query );
    $n = ($page-1) * $articlesPage + 1;

    while( $i = mysql_fetch_assoc( $res ) ){
        echo "<tr>";
            echo "<td>" . $n                . "</td>";
            echo "<td>" . $i['N_lot']     . "</td>";
            echo "<td>" . $i['codeart']         . "</td>";
            echo "<td>" . $i['DCI'] . "</td>";
            echo "<td>" . $i['QTE']     . "</td>";
            echo "<td>" . $i['SHP'] . "</td>";
            echo "<td>" . $i['PPA'] . "</td>";
            echo "<td>" . $i['Valeur_stock'] . "</td>";
            echo "<td>" . $i['expire'] . "</td>";
        echo "</tr>";
        $n++;
    }
    
?>