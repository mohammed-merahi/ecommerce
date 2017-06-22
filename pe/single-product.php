<?php
    session_start();
    include("db.php");

    $xml         = simplexml_load_file("../config/parametres.xml");
    $favicon     = $xml->xpath( '/parametres/themes/favicon' )[0];
    $banner      = $xml->xpath( '/parametres/themes/banner' )[0];
    $tel         = $xml->xpath( '/parametres/affichage/contact/mobile' )[0];
    $societe     = $xml->xpath( '/parametres/affichage/about/societe' )[0];
    $description = $xml->xpath( '/parametres/affichage/about/description' )[0];
    $facebook    = $xml->xpath( '/parametres/affichage/contact/facebook' )[0];
    $googleplus  = $xml->xpath( '/parametres/affichage/contact/googleplus' )[0];
    $twitter     = $xml->xpath( '/parametres/affichage/contact/twitter' )[0];
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Détails article</title>
    <link rel="icon" href="<?php echo '../assets/img/' . $favicon; ?>" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- All CSS Files -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Nivo-slider css -->
    <link rel="stylesheet" href="lib/css/nivo-slider.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- Template color css -->
    <link href="css/color/color-core.css" data-style="styles" rel="stylesheet">
    <!-- User style -->
    <link rel="stylesheet" href="css/custom.css">

    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- START HEADER AREA -->
        <header class="header-area header-wrapper">
            <!-- header-top-bar -->
            <div class="header-top-bar plr-185">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 hidden-xs">
                            <div class="call-us">
                                <p class="mb-0 roboto"><?php echo $tel ?></p>
                            </div>
                        </div>
                            <?php include("include/top_link.php"); ?>
                    </div>
                </div>
            </div>
            <!-- header-middle-area -->
            <div id="sticky-header" class="header-middle-area plr-185">
              <div class="container-fluid">
                  <div class="full-width-mega-dropdown">
                      <div class="row">
                          <!-- logo -->
                              <?php include("include/logo.php"); ?>
                          <!-- primary-menu -->
                              <?php include("include/menu.php"); ?>
                          <!-- header-search & total-cart -->
                          <div class="col-md-2 col-sm-6 col-xs-12">
                              <div class="search-top-cart  f-right">
                                  <!-- header-search -->
                                      <?php include("include/search.php"); ?>
                                  <!-- total-cart -->
                                      <?php include("include/cart.php"); ?>

                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </header>
        <!-- END HEADER AREA -->

        <!-- START MOBILE MENU AREA -->
        <div class="mobile-menu-area hidden-lg hidden-md">
            <?php include("include/mobile_menu.php"); ?>
        </div>
        <!-- END MOBILE MENU AREA -->

        <!-- BREADCRUMBS SETCTION START -->
        <div class="breadcrumbs-section plr-200 mb-80">
            <div class="breadcrumbs overlay-bg" style="background: #f6f6f6 url(<?php echo "../assets/img/" . $banner; ?>) no-repeat scroll center center;">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="breadcrumbs-inner">
                                <h1 class="breadcrumbs-title"></h1>
                                <ul class="breadcrumb-list">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCRUMBS SETCTION END -->

        <!-- Start page content -->
        <section id="page-content" class="page-wrapper">

            <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <!-- single-product-area start -->

<?php
      $query = "SELECT    articles.codeart,
                          articles.categorie,
                          articles.famille,
                          photo,
                          extention,
                          designation,
                          prix_vente1,
                          marque,
                          description
                    FROM articles
                    LEFT JOIN descriptions ON articles.codeart = descriptions.codeart
                    LEFT JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart)
                    WHERE bloquer='Non'
                      AND web=1
                      AND articles.codeart='" . $_GET['id'] . "'";

    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc( $res ) ){
        $codeart      = $i['codeart'];
        $designation  = $i['designation'];
        $description  = $i['description'];
        $prix_vente1  = $i['prix_vente1'];
        $marque       = $i['marque'];
        $categorie    = $i['categorie'];
        $famille      = $i['famille'];
        $img = gzuncompress( $i['photo'] );
        $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
        if( !file_exists( $file ) )
            file_put_contents($file, $img);
    }
?>

                            <div class="single-product-area mb-80">
                                <div class="row">
                                    <!-- imgs-zoom-area start -->
                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                        <div class="imgs-zoom-area">
                                            <img id="zoom_03" src="<?php echo $file ?>" data-zoom-image="<?php echo $file ?>" alt="">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div id="gallery_01" class="carousel-btn slick-arrow-3 mt-30">
                                                        <div class="p-c">
                                                            <a href="#" data-image="img/product/2.jpg" data-zoom-image="img/product/2.jpg">
                                                                <img class="zoom_03" src="img/product/2.jpg" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="p-c">
                                                            <a href="#" data-image="img/product/3.jpg" data-zoom-image="img/product/3.jpg">
                                                                <img class="zoom_03" src="img/product/3.jpg" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="p-c">
                                                            <a href="#" data-image="img/product/4.jpg" data-zoom-image="img/product/4.jpg">
                                                                <img class="zoom_03" src="img/product/4.jpg" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="p-c">
                                                            <a href="#" data-image="img/product/5.jpg" data-zoom-image="img/product/5.jpg">
                                                                <img class="zoom_03" src="img/product/5.jpg" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="p-c">
                                                            <a href="#" data-image="img/product/6.jpg" data-zoom-image="img/product/6.jpg">
                                                                <img class="zoom_03" src="img/product/6.jpg" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="p-c">
                                                            <a href="#" data-image="img/product/7.jpg" data-zoom-image="img/product/7.jpg">
                                                                <img class="zoom_03" src="img/product/7.jpg" alt="">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- imgs-zoom-area end -->
                                    <!-- single-product-info start -->
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <div class="single-product-info">
                                            <h3 class="text-black-1"><?php echo $designation; ?></h3>
                                            <h6 class="brand-name-2"><?php echo $marque; ?></h6>
                                            <!-- hr -->
                                            <hr>
                                            <!-- single-product-tab -->
                                            <div class="single-product-tab">
                                                <ul class="reviews-tab mb-20">
                                                    <li  class="active"><a href="#description" data-toggle="tab">description</a></li>
                                                    <li class="hidden"><a href="#information" data-toggle="tab">information</a></li>
                                                    <li class="hidden"><a href="#reviews" data-toggle="tab">reviews</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active" id="description">
                                                        <p><?php echo $description; ?></p>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane hidden" id="information">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem, neque fugit inventore quo dignissimos est iure natus quis nam illo officiis,  deleniti consectetur non ,aspernatur.</p>
                                                        <p>rerum blanditiis dolore dignissimos expedita consequatur deleniti consectetur non exercitationem.</p>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane hidden" id="reviews">
                                                        <!-- reviews-tab-desc -->
                                                        <div class="reviews-tab-desc">
                                                            <!-- single comments -->
                                                            <div class="media mt-30">
                                                                <div class="media-left">
                                                                    <a href="#"><img class="media-object" src="img/author/1.jpg" alt="#"></a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="clearfix">
                                                                        <div class="name-commenter pull-left">
                                                                            <h6 class="media-heading"><a href="#">Gerald Barnes</a></h6>
                                                                            <p class="mb-10">27 Jun, 2016 at 2:30pm</p>
                                                                        </div>
                                                                        <div class="pull-right">
                                                                            <ul class="reply-delate">
                                                                                <li><a href="#">Reply</a></li>
                                                                                <li>/</li>
                                                                                <li><a href="#">Delate</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas .</p>
                                                                </div>
                                                            </div>
                                                            <!-- single comments -->
                                                            <div class="media mt-30">
                                                                <div class="media-left">
                                                                    <a href="#"><img class="media-object" src="img/author/2.jpg" alt="#"></a>
                                                                </div>
                                                                <div class="media-body">
                                                                    <div class="clearfix">
                                                                        <div class="name-commenter pull-left">
                                                                            <h6 class="media-heading"><a href="#">Gerald Barnes</a></h6>
                                                                            <p class="mb-10">27 Jun, 2016 at 2:30pm</p>
                                                                        </div>
                                                                        <div class="pull-right">
                                                                            <ul class="reply-delate">
                                                                                <li><a href="#">Reply</a></li>
                                                                                <li>/</li>
                                                                                <li><a href="#">Delate</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas .</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--  hr -->
                                            <hr>
                                            <!-- single-pro-color-rating -->
                                            <div class="single-pro-color-rating clearfix hidden">
                                                <div class="sin-pro-color f-left">
                                                    <p class="color-title f-left">Color</p>
                                                    <div class="widget-color f-left">
                                                        <ul>
                                                            <li class="color-1"><a href="#"></a></li>
                                                            <li class="color-2"><a href="#"></a></li>
                                                            <li class="color-3"><a href="#"></a></li>
                                                            <li class="color-4"><a href="#"></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="pro-rating sin-pro-rating f-right">
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star-half"></i></a>
                                                    <a href="#" tabindex="0"><i class="zmdi zmdi-star-outline"></i></a>
                                                    <span class="text-black-5">( 27 Rating )</span>
                                                </div>
                                            </div>
                                            <!-- hr -->
                                            <hr class="hidden">
                                            <!-- plus-minus-pro-action -->
                                            <div class="plus-minus-pro-action">
                                                <div class="sin-plus-minus f-left clearfix">
                                                    <p class="color-title f-left">Qté</p>
                                                    <div class="cart-plus-minus f-left">
                                                        <input type="text" value="02" name="qtybutton" class="cart-plus-minus-box">
                                                    </div>
                                                </div>
                                                <div class="sin-pro-action f-right">
                                                    <ul class="action-button">
                                                        <li>
                                                            <a href="#" title="Wishlist" tabindex="0"><i class="zmdi zmdi-favorite"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal" data-target="#productModal" title="Quickview" tabindex="0"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li class="hidden">
                                                            <a href="#" title="Compare" tabindex="0"><i class="zmdi zmdi-refresh"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Add to cart" tabindex="0"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single-product-info end -->
                                </div>
                            </div>
                            <!-- single-product-area end -->
                            <div class="related-product-area">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="section-title text-left mb-40">
                                            <h2 class="uppercase">Produits en relation</h2>
                                            <h6 class="hidden">There are many variations of passages of brands available,</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="active-related-product">
                                         <!-- product-item start -->
            <?php
                      $query = "SELECT    articles.codeart,
                                          photo,
                                          extention,
                                          designation,
                                          prix_vente1,
                                          marque,
                                          description
                                    FROM articles
                                    LEFT JOIN descriptions ON articles.codeart = descriptions.codeart
                                    LEFT JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart)
                                    WHERE bloquer='Non'
                                      AND web=1
                                      AND ( articles.categorie = '" .$categorie. "' )
                                      AND articles.codeart <> '" . $codeart . "'
                                      LIMIT 3";

                    //echo $query;
                    $res = mysql_query( $query );
                    while( $i = mysql_fetch_assoc( $res ) ){
                        $codeart      = $i['codeart'];
                        $designation  = $i['designation'];
                        $description  = $i['description'];
                        $prix_vente1  = $i['prix_vente1'];
                        $marque       = $i['marque'];
                        $img = gzuncompress( $i['photo'] );
                        $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                        if( !file_exists( $file ) )
                            file_put_contents($file, $img);

            ?>
                                        <div class="col-xs-12">
                                            <div class="product-item">
                                                <div class="product-img">
                                                    <a href="single-product.php?id=<?php echo $codeart; ?>">
                                                        <img src="<?php echo $file; ?>" alt=""/>
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-title">
                                                        <a href="single-product.html"><?php echo $designation; ?></a>
                                                    </h6>
                                                    <div class="pro-rating">
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                        <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                    </div>
                                                    <h3 class="pro-price"><?php echo number_format($prix_vente1, 2, ',', ' '); ?></h3>
                                                    <ul class="action-button">
                                                        <li>
                                                            <a href="#" title="Ajouter à la liste de souhaits"><i class="zmdi zmdi-favorite"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" data-toggle="modal"  data-target="#productModal" title="Détails de l'article"><i class="zmdi zmdi-zoom-in"></i></a>
                                                        </li>
                                                        <li class="hidden">
                                                            <a href="#" title="Comparer"><i class="zmdi zmdi-refresh"></i></a>
                                                        </li>
                                                        <li>
                                                            <a href="#" title="Ajouter au panier"><i class="zmdi zmdi-shopping-cart-plus"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

<?php
                   }
?>

                                        <!-- product-item end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SHOP SECTION END -->

        </section>
        <!-- End page content -->

        <!-- START FOOTER AREA -->
            <?php include("include/footer.php"); ?>
        <!-- END FOOTER AREA -->

        <!-- START QUICKVIEW PRODUCT -->

        <!-- END QUICKVIEW PRODUCT -->
    </div>
    <!-- Body main wrapper end -->


    <!-- Placed JS at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="js/vendor/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- jquery.nivo.slider js -->
    <script src="lib/js/jquery.nivo.slider.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>

</body>

</html>
