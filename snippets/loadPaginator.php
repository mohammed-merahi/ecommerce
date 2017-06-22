<?php 
    session_start();
    include('../db.php');
    $page     = $_POST['page'];
    $fam      = $_POST['fam'];
    $categ    = $_POST['categ'];
    $marque   = $_POST['marque'];
    $prixMin  = $_POST['prixMin'];
    $prixMax  = $_POST['prixMax'];
    $sort     = $_POST['sort'];
    $keyword  = $_POST['search'];
    
    $articlesPage = $_POST['articlesPage'];
    $_SESSION['current_page'] = $page;
    
?>
<li title="Première" onclick="loadPage(<?php echo "1"; ?>, <?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')"><a href="#"><i class="zmdi zmdi-chevron-left"></i></a></li>
<?php
    $query = "SELECT count(codeart) AS NB FROM articles WHERE bloquer='Non' AND web=1 ";
    if( $categ != "" ){
        $query .= " AND categorie='" . mysql_real_escape_string( $categ ) . "' ";
    }else if( $fam != "" ){
        $query .= " AND famille='" . mysql_real_escape_string( $fam ) . "' ";
    }

    if( $prixMin != '' )
        $query .= " AND prix_vente1 >= " . $prixMin;
    if( $prixMax != '' )
        $query .= " AND prix_vente1 <= " . $prixMax;
    if( $marque != '' and $marque != '-' )
        $query .= " AND marque = '" . $marque . "'";

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
            $query .= " OR    lower(ref)                    LIKE lower('$keyword') ";  
            $query .= " OR    lower(codebar)                LIKE lower('$keyword') ";    
            $query .= " OR    lower(marque)                 LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(designation2)           LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(famille)                LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(categorie)              LIKE lower('%$keyword%') ";   
            $query .= " ) ";//fin des conditions
    }

    $res   = mysql_query( $query );
    while( $i = mysql_fetch_assoc($res) ){
        $NB = intval($i['NB'] / $articlesPage);
        if( $i['NB'] % $articlesPage != 0 )
            $NB++;
    }

    $first_page = intval($_SESSION['current_page']) - 5;
    if( $first_page < 1 )
        $first_page = 1;

    $last_page  = intval($_SESSION['current_page']) + 4;
    if( $last_page < 10 )
        $last_page = 10;
    if( $last_page > $NB ){
        $last_page  = $NB;
        $first_page = $NB - 9;
        if( $first_page < 1 )
            $first_page = 1;
    }


    for($p=$first_page;$p<=$last_page;$p++){
        if( $p == $page )
            $active = " active";
        else
            $active = "";
  
?>
        <li class="li_page<?php echo $active; ?>" id="li_<?php echo $p; ?>"
            onclick="loadPage(<?php echo $p; ?>, <?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')">
            <a class="page" href="#"><?php echo $p; ?></a>
        </li>
<?php  
        
        //echo '<li class="li_page ' . $active . '" id="li_' . $p . '" onclick="loadPage(' . $p . ', ' . $articlesPage . ')"><a class="page" href="#">' . $p . '</a></li>';
    }
    

?>
<li title="Dernière" onclick="loadPage(<?php echo $NB; ?>, <?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')" class=""><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li>
