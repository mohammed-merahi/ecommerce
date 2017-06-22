<?php
    session_start();
    include('../db.php');
    //$xml              = simplexml_load_file("../../config/parametres.xml");
    //$articlesPage     = trim($xml->xpath( '/parametres/affichage/boutique/produitsParPage' )[0]);
    
    //tarification pour ce client
    if( !isset($_SESSION['tarification']) or $_SESSION['tarification'] == 1 ){
        $tarification = 1;
    }else{
        $tarification = $_SESSION['tarification'];
    }

    if( isset($_POST['page']) )
        $page = $_POST['page'];
    else 
        $page = 1;

    $fam      = $_POST['fam'];
    $categ    = $_POST['categ'];
    $marque   = $_POST['marque'];
    $prixMin  = $_POST['prixMin'];
    $prixMax  = $_POST['prixMax'];
    $sort     = $_POST['sort'];
    $keyword  = $_POST['search'];

    $articlesPage = $_POST['articlesPage'];

    $_SESSION['current_page'] = $page;

    $query = "SELECT    articles.codeart,
                        photo2,
                        extention,
                        designation,
                        prix_vente" . $tarification . " AS 'prix_vente',
                        articles.tva
                  FROM articles
                  LEFT JOIN descriptions ON articles.codeart = descriptions.codeart 
                  LEFT JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart) 
                  WHERE bloquer='Non'
                    AND web=1  ";
    
    if( $categ != "" ){
        $query .= " AND categorie='" . mysql_real_escape_string( $categ ) . "' ";
    }else if( $fam != "" ){
        $query .= " AND famille='" . mysql_real_escape_string( $fam ) . "' ";
    }

    if( $prixMin != '' )
        $query .= " AND prix_vente" . $tarification . " >= " . $prixMin;
    if( $prixMax != '' )
        $query .= " AND prix_vente" . $tarification . " <= " . $prixMax;
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

    //sorting
    if( $sort == '0' )//nouveaux articles
        $query .= " ORDER BY paupdate DESC LIMIT ";
    else if( $sort == "1" )//prix croisant    
        $query .= " ORDER BY prix_vente ASC LIMIT ";
    else if( $sort == "2" )//prix decroissant
        $query .= " ORDER BY prix_vente DESC LIMIT ";   
    else    
        $query .= " ORDER BY famille, categorie DESC LIMIT ";
    
    //which page
    $query .= ($page-1)* $articlesPage . "," . $articlesPage;

    //echo $query;exit;
    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc( $res ) ){
        $tva     = $i['tva'];
        $codeart = $i['codeart'];
        if( $i['photo2'] != '' ){
            $img = gzuncompress( $i['photo2'] );
            $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
            if( !file_exists( '../' . $file ) )
                file_put_contents( '../' . $file, $img);
        }else{
            $file = '';
        }  
?>    
    <!-- product-item start -->
    <div class="col-md-4 col-sm-4 col-xs-12" data-codeart="<?php echo $codeart; ?>" data-tva="<?php echo $tva; ?>">
        <div class="product-item">
            <div class="product-img">
                <a href="single-product.php?id=<?php echo $codeart ?>">
                    <img id="photo_<?php echo $i['codeart']; ?>" width="270" height="300" src="<?php echo $file; ?>" alt=""/>
                </a>
            </div>
            <div class="product-info">
                <h6 class="product-title">
                    <a id="designation_<?php echo $i['codeart']; ?>" href="single-product.html"> <?php echo $i["designation"]; ?> </a>
                </h6>
                <div class="pro-rating">
                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                    <a href="#"><i class="zmdi zmdi-star"></i></a>
                    <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                    <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                </div>
                <h3 class="pro-price" id="prix_<?php echo $i['codeart']; ?>"><?php echo number_format($i['prix_vente'], 2, ',', ' ') . ' DA'; ?></h3>
                <p id="description_<?php echo $i['codeart']; ?>" class="hidden"><?php echo substr($i["description"],0,160) . '...'; ?></p>
                <ul class="action-button">
                    <li>
                        <a style="cursor:Pointer;" title="Liste de souhaits" onclick="add2WishList('<?php echo $codeart ?>')"><i style="color:;" class="zmdi zmdi-favorite"></i></a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" onclick="changeModal('<?php echo $codeart; ?>')"  data-target="#productModal" title="Détails"><i class="zmdi zmdi-zoom-in"></i></a>
                    </li>
                    <li>
                        <a style="cursor:Pointer;" title="Ajouter à la carte" onclick="add2Cart('<?php echo $codeart; ?>', 1)"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- product-item end -->
<?php    
    }
?>






