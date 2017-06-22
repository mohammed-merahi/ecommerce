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
    else $page = 1;

    $fam      = $_POST['fam'];
    $categ    = $_POST['categ'];
    $marque   = $_POST['marque'];
    $prixMin  = $_POST['prixMin'];
    $prixMax  = $_POST['prixMax'];
    $sort     = $_POST['sort'];
    $keyword  = $_POST['search'];

    $articlesPage = $_POST['articlesPage'];

    $_SESSION['current_page'] = $page;

    if( !isset( $_SESSION['articles_count'] ) ){
        $_SESSION['articles_count'] = 0;
    }

?>


    <div class="table-content table-responsive mb-50">
        <table class="text-center">
            <thead>
                <tr>
                    <th class="product-thumbnail" style="padding-top:10px;padding-bottom:10px;">Produit</th>
                    <th class="product-thumbnail" style="padding-top:10px;padding-bottom:10px;">Référence</th>
                    <th class="product-quantity" style="padding-top:10px;padding-bottom:10px;">Marque</th>
                    <th class="product-quantity" style="padding-top:10px;padding-bottom:10px;">Prix</th>
                    <th class="product-quantity" style="padding-top:10px;padding-bottom:10px;">Image</th>
                    <th class="product-quantity" style="padding-top:10px;padding-bottom:10px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                    
    <?php
    $query = "SELECT    articles.codeart,
                        articles.ref,
                        photo,
                        extention,
                        designation,
                        prix_vente" . $tarification . " AS 'prix_vente',
                        marque,
                        description,
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
    else if( $sort == '1' )//prix croisant    
        $query .= " ORDER BY prix_vente" . $tarification . " ASC LIMIT ";
    else if( $sort == '2' )//prix decroissant
        $query .= " ORDER BY prix_vente" . $tarification . " DESC LIMIT ";   
    else    
        $query .= " ORDER BY famille, categorie DESC LIMIT ";
    
    //which page
    $query .= ($page-1)* $articlesPage . "," . $articlesPage;
                
    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc( $res ) ){
        $codeart = $i['codeart'];
        $img = gzuncompress( $i['photo'] );
        $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
        if( !file_exists( '../' . $file ) )
            file_put_contents( '../' . $file, $img);
?>  

                <!-- tr -->
                <tr>
                    <td nowrap class="" style="padding-top:5px;padding-bottom:5px;">
                                <a style="text-align:center;" href="#"> <b><?php echo $i["designation"]; ?></b> </a>
                    </td>

                    <td nowrap class="" style="padding-top:5px;padding-bottom:5px;"><?php echo $i['ref']; ?></td>

                    <td nowrap class="" style="padding-top:5px;padding-bottom:5px;"><?php echo $i['marque']; ?></td>

                    <td nowrap class="" style="padding-top:5px;padding-bottom:5px;"><?php echo number_format($i['prix_vente'], 2, ',', ' ') . ' DA'; ?></td>


                    <td nowrap class="" align="center" style="text-align:center;padding-top:5px;padding-bottom:5px;">
                        <img style="width:500%;height:auto;" src="<?php echo $file; ?>" alt="<?php echo $i['designation']; ?>">
                    </td>

                    <td class="" nowrap style="padding-top:5px;padding-bottom:5px;">
                            <ul class="action-button">
                                <li>
                                    <a style="cursor:Pointer;" title="Liste de souhaits" onclick="add2WishList('<?php echo $codeart ?>')"><i class="zmdi zmdi-favorite"></i></a>
                                </li>
                                <li>
                                    <a href="#" data-toggle="modal" onclick="changeModal('<?php echo $codeart; ?>')"  data-target="#productModal" title="Détails"><i class="zmdi zmdi-zoom-in"></i></a>
                                </li>
                                <li>
                                    <a style="cursor:Pointer;" title="Ajouter à la carte"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
                                </li>
                            </ul>                                                                      
                    </td>
                </tr>
                <!-- tr -->

<?php    
    }
?>
            </tbody>
        </table>
    </div>