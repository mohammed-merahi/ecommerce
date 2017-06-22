<?php
    session_start();

    //tarification pour ce client
    if( !isset($_SESSION['tarification']) or $_SESSION['tarification'] == 1 ){ 
        $tarification = 1;
    }else{
        $tarification = $_SESSION['tarification'];
    }

    if( !isset($_SESSION['articles_count']) ){
        $_SESSION['articles_count'] = 0;    
        $_SESSION['articles_real'] = 0;    
    }
    
    $codeart = $_POST['codeart'];
    if( !isset( $_POST['qte'] ) ){
        $qte = 1;
    }else {
        $qte = $_POST['qte'];
    }

    //search codeart in the current cart
    $exists = false;
    for( $i=1;$i<=$_SESSION['articles_count'];$i++ ){
        if( $_SESSION['article_' . $i] == $_POST['codeart'] ){
            $exists = true;
            break;
        }
    }

    if( !$exists ){
        $_SESSION['articles_count'] += 1;
        $_SESSION['articles_real'] += 1;
        $_SESSION["article_" . $_SESSION['articles_count'] ] = $codeart;
        $_SESSION["qte_"     . $_SESSION['articles_count'] ] = $qte;
        $_SESSION["qte_"     . $codeart ] = $qte;
    }else{
        $_SESSION["qte_"     . $i ]         = $qte;    
        $_SESSION["qte_"     . $codeart ]   = $qte;    
    }

    if( isset($_POST['wishlist']) ){
                    //delete from wishlist ex: 00045,00036,00009
                    $_SESSION['wishlist'] = str_replace(    $codeart.',', "" , $_SESSION['wishlist']);
                    $_SESSION['wishlist'] = str_replace(','.$codeart    , "" , $_SESSION['wishlist']);
                    $_SESSION['wishlist'] = str_replace(    $codeart    , "", $_SESSION['wishlist']);
                    //préparer la ligne pour l'ajouter dans la table du panier
                    
                    include('../db.php');
                    $query = "SELECT    articles.codeart,
                                        photo2,
                                        extention,
                                        designation,
                                        prix_vente" . $tarification . " AS 'prix_vente',
                                        marque,
                                        if(articles.tva1=1,articles.tva,0) AS 'tva'
                                  FROM articles
                                  LEFT JOIN descriptions ON articles.codeart = descriptions.codeart
                                  LEFT JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart)
                                  WHERE bloquer='Non'
                                    AND web=1
                                    AND articles.codeart = '" . $codeart . "'";
                                
                    $res = mysql_query( $query );
                    while( $i = mysql_fetch_assoc($res) ){
                        $tva     = $i['tva'];
                        $codeart = $i['codeart'];
                        $qte     = 1;

                        $total   = $i['prix_vente'] * $qte;

                        $img = gzuncompress( $i['photo2'] );
                        $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                        if( !file_exists( '../' . $file ) )
                            file_put_contents('../' . $file, $img);

?>
                    <tr id="<?php echo $codeart; ?>">
                        <td nowrap class="product-">
                            <div class="pro-thumbnail-img">
                                <img src="<?php echo $file; ?>" alt="">
                            </div>
                            <div class="pro-thumbnail-info text-left">
                                <h6 class="product-title-2">
                                    <a href="#"><?php echo $i['designation']; ?></a>
                                </h6>
                                <p><?php echo $i['marque']; ?></p>
                            </div>
                        </td>

                        <td nowrap class="product-price prix-article" data-prix="<?php echo $i['prix_vente']; ?>"><?php echo number_format($i['prix_vente'], 2, ',',' ') . ' DA'; ?></td>

                        <td class="product-quantity">
                            <div class="cart-plus-minus f-left" data-codeart="<?php echo $codeart; ?>">
                                <input id="prodQte_<?php echo $codeart; ?>" type="text" value="<?php echo $qte; ?>" name="qtybutton" class="cart-plus-minus-box"
                                        onkeyup="QteChangePanier('<?php echo $codeart; ?>')" onchange="QteChangePanier('<?php echo $codeart; ?>')">
                            </div>
                        </td>

                        <td nowrap class="product-price total-article" data-tva="<?php echo $tva; ?>" data-tot="<?php echo $total; ?>"><?php echo number_format($total, 2, ',',' ') . ' DA'; ?></td>
                        
                        <td nowrap class="product-">
                            <a href="#"><i class="zmdi zmdi-close" onclick="deleteFromCart('<?php echo $codeart; ?>')"></i></a>
                        </td>
                    </tr>

<?php
                    }
    }
?>
