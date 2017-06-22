
            <div class="by-brand-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-left mb-40">
                                <h2 class="uppercase">Marques</h2>
                                <h6></h6>
                            </div>
                        </div>
                    </div>
                    <div class="by-brand-product">
                        <div class="row active-by-brand slick-arrow-2">
                            <?php
                                include('db.php');
                                $query = "SELECT marque,
                                                 photo,
                                                 photo2,
                                                 extention
                                            FROM marques 
                                            LEFT JOIN myphotos ON myphotos.code= CONCAT('MQ', marques.marque) ";
                                $res   = mysql_query( $query );
                                while( $i = mysql_fetch_assoc($res) ){
                                    if( $i['photo'] != '' ){
                                        $img = gzuncompress( $i['photo'] );
                                        $file = "img/fam_articles/" . $i['famille'] . '_img' . $i['extention'];   
                                        if( !file_exists( $file ) )
                                            file_put_contents( $file, $img);
                                    }else{
                                        $file = '';
                                    }  
                                    $file = 'img/product/5.jpg';
                            ?>
                            <!-- single-brand-product start -->
                            <div class="col-xs-12">
                                <div class="single-brand-product">
                                    <a href="single-product.html"><img src="img/product/5.jpg" alt=""></a>
                                    <h3 class="brand-title text-gray">
                                        <a href="#"><?php echo $i['marque']; ?></a>
                                    </h3>
                                </div>
                            </div>
                            <!-- single-brand-product end -->
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>