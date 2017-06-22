
            <div class="featured-product-section mb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-left mb-40">
                                <h2 class="uppercase">Produits récents</h2>
                            </div>
                        </div>
                    </div>
                    <div class="featured-product">
                        <div class="row active-featured-product slick-arrow-2">
                            <?php
                                $query = "SELECT    articles.codeart,
                                                    photo,
                                                    extention,
                                                    designation,
                                                    prix_vente" . $tarification . " AS 'prix_vente'
                                              FROM  articles
                                              LEFT  JOIN descriptions ON articles.codeart = descriptions.codeart
                                              LEFT  JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart)
                                              WHERE bloquer='Non'
                                                AND web=1
                                              ORDER BY 'create'
                                              LIMIT 7";
                                $res = mysql_query( $query );
                                while( $i = mysql_fetch_assoc( $res ) ){
                                    $img = gzuncompress( $i['photo'] );
                                    $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                                    if( !file_exists( $file ) )
                                        file_put_contents($file, $img);
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
                        </div>
                    </div>          
                </div>            
            </div>