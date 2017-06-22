<?php
    session_start();
    include("db.php");

    //tarification pour ce client
    if( !isset($_SESSION['tarification']) or $_SESSION['tarification'] == 1 ){
        $tarification = 1;
    }else{
        $tarification = $_SESSION['tarification'];
    }

    //**************
    if( !isset($_SESSION['articles_count']) ){
        $_SESSION['articles_count'] = 0;
        $_SESSION['articles_real']  = 0;
    }
    //always start at first page
    $_SESSION['current_page'] = 1;
    $current_page = 1;

    $xml              = simplexml_load_file("../config/parametres.xml");
    $favicon          = $xml->xpath( '/parametres/themes/favicon' )[0];
    $banner           = $xml->xpath( '/parametres/themes/banner' )[0];
    $tel              = $xml->xpath( '/parametres/affichage/contact/mobile' )[0];
    $societe          = $xml->xpath( '/parametres/affichage/about/societe' )[0];
    $description      = $xml->xpath( '/parametres/affichage/about/description' )[0];
    $facebook         = $xml->xpath( '/parametres/affichage/contact/facebook' )[0];
    $googleplus       = $xml->xpath( '/parametres/affichage/contact/googleplus' )[0];
    $twitter          = $xml->xpath( '/parametres/affichage/contact/twitter' )[0];
    //options des articles
    $grille           = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/grille' )[0]);
    $liste            = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/liste' )[0]);
    $tableauAvecImg   = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/tableauAvecImg' )[0]);
    $tableauSansImg   = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/tableauSansImg' )[0]);
    $produitsNonDispo = trim($xml->xpath( '/parametres/affichage/boutique/produitsNonDispo' )[0]);
    $articlesPage     = trim($xml->xpath( '/parametres/affichage/boutique/produitsParPage' )[0]);
    //SEO
    $metaDescription  = trim($xml->xpath( '/parametres/seo/metaDescription' )[0]);
    $keywords         = trim($xml->xpath( '/parametres/seo/keywords' )[0]);

    $tab = 0;
	
	$fam   = "";
	$categ = "";
	if( isset( $_GET['categ'] ) ){
		$categ  = $_GET['categ'];
	}else if( isset( $_GET['fam'] ) ){
		$fam    = $_GET['fam'];
	}
	
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Produits</title>
    <link rel="icon" href="<?php echo '../assets/img/' . $favicon; ?>" />
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>"></meta>

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

    <link rel='stylesheet' id='avia-google-webfont' href='//fonts.googleapis.com/css?family=Raleway:100,200,300,400,500,600,700,800,900' type='text/css' media='all'/>

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
            <?php include("include/mobile_menu.php"); ?>
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
        <div id="page-content" class="page-wrapper">

            <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container" id="products">
                    <div class="row">


                        <div class="col-md-9 col-md-push-3 col-sm-12">
                            <div class="shop-content">
                                <!-- shop-option start -->
                                <div class="shop-option box-shadow mb-30 clearfix">
                                    <!-- Nav tabs -->
                                    <ul class="shop-tab f-left" role="tablist">
                                            <?php if($grille=="Oui"){ ?>
                                                <li class="<?php if($tab==0){echo 'active';$tab++;$_SESSION['mode_affichage'] = 1; } ?>">
                                                    <a href="#grid-view" data-toggle="tab" onclick="articleView(1)"><i class="zmdi zmdi-view-comfy" title="Grille"></i></a>
                                                </li>
                                            <?php } ?>
                                            <?php if($liste=="Oui"){ ?>
                                                <li class="<?php if($tab==0){echo 'active';$tab++;$_SESSION['mode_affichage'] = 2; } ?>">
                                                    <a href="#list-view" data-toggle="tab" onclick="articleView(2)"><i class="zmdi zmdi-view-list-alt" title="Liste"></i></a>
                                                </li>
                                            <?php } ?>
                                            <?php if($tableauAvecImg=="Oui"){ ?>
                                                <li class="<?php if($tab==0){echo 'active';$tab++;$_SESSION['mode_affichage'] = 3; } ?>">
                                                    <a href="#simple-list-view" data-toggle="tab" onclick="articleView(3)"><i class="zmdi zmdi-view-module" style="" title="Tableau avec images"></i></a>
                                                </li>
                                            <?php } ?>
                                            <?php if($tableauSansImg=="Oui"){ ?>
                                                <li class="<?php if($tab==0){echo 'active';$tab++;$_SESSION['mode_affichage'] = 4; } ?>">
                                                    <a href="#tableau-sans-img" data-toggle="tab" onclick="articleView(4)"><i class="zmdi zmdi-view-week" style="" title="Tableau sans images"></i></a>
                                                </li>
                                            <?php } ?>
                                    </ul>
                                    <!-- short-by -->
                                    <div class="short-by f-left text-center">
        									<?php
        									?>
                                        <span>Trier par :</span>
                                        <select id="sort" onchange="sort(<?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')">
                                            <option value="-">-----------------</option>
                                            <option value="0">Nouveaux articles</option>
                                            <option value="1">Prix Croissant</option>
                                            <option value="2">Prix décroissant</option>
                                        </select>
                                    </div>
                                    <!-- showing -->
                                    <div class="showing f-right text-right hidden">
                                        <span>Affichage : 01-09 parmi 17.</span>
                                    </div>
                                </div>
                                <!-- shop-option end -->


                                        <?php
                                            //réinitialiser la variable $tab
                                            $tab = 0;
                                         ?>


                                <!-- Tab Content start -->
                                <div class="tab-content">
                                    
                                    <!-- ********************************************************** grid-view ********************************************************** -->
                                    
                                    <?php if( $grille == 'Oui' ){ ?>
                                        <div role="tabpanel" class="tab-pane<?php if($tab==0){echo 'active';$tab++;}else{echo '';} ?>" id="grid-view">
                                            <div class="row">
                                            <?php
                                                $query = "SELECT    articles.codeart,
                                                                    photo2,
                                                                    extention,
                                                                    designation,
                                                                    description,
                                                                    prix_vente" . $tarification . " AS 'prix_vente',
                                                                    articles.tva
                                                              FROM articles
                                                              LEFT JOIN descriptions ON articles.codeart = descriptions.codeart
                                                              LEFT JOIN fam_articles ON articles.famille = fam_articles.famille
                                                              LEFT JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart)
                                                              WHERE bloquer='Non'
                                                                AND web=1 ";

                                                if( isset( $_GET['categ'] ) ){
                                                    $query .= " AND categorie='" . mysql_real_escape_string( $_GET['categ'] ) . "' ";
                                                }else if( isset( $_GET['fam'] ) ){
                                                    $query .= " AND famille='" . mysql_real_escape_string( $_GET['fam'] ) . "' ";
                                                }

                                                $query .= " ORDER BY articles.famille, categorie DESC
                                                              LIMIT " . $articlesPage;
                                                
                                                $res = mysql_query( $query );
                                                while( $i = mysql_fetch_assoc( $res ) ){
                                                    $tva     = $i['tva'];
                                                    $codeart = $i['codeart'];
                                                    if( $i['photo2'] != '' ){
                                                        $img = gzuncompress( $i['photo2'] );
                                                        $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                                                        if( !file_exists( $file ) )
                                                            file_put_contents( $file, $img);
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
                                            </div>
                                        </div>
                                    <?php } ?>
                                        <!-- ********************************************************** list-view ********************************************************** -->
                                    <?php if( $liste == 'Oui' ){ ?>
                                        <div role="tabpanel" class="tab-pane<?php if($tab==0){echo 'active';$tab++;}else{echo '';} ?>" id="list-view">
                                            <div class="row">

                                                            <?php
                                                                    $query = "SELECT    articles.codeart,
                                                                                        photo2,
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
                                                                                    AND web=1 ";

                                                                    if( isset( $_GET['categ'] ) ){
                                                                        $query .= " AND categorie='" . mysql_real_escape_string( $_GET['categ'] ) . "' ";
                                                                    }else if( isset( $_GET['fam'] ) ){
                                                                        $query .= " AND famille='" . mysql_real_escape_string( $_GET['fam'] ) . "' ";
                                                                    }

                                                                    $query .= " ORDER BY articles.famille, categorie DESC
                                                                                  LIMIT " . $articlesPage;
                                                                    $res = mysql_query( $query );
                                                                    while( $i = mysql_fetch_assoc( $res ) ){
                                                                        $tva     = $i['tva'];
                                                                        $codeart = $i['codeart'];
                                                                        if( $i['photo2'] != '' ){
                                                                            $img = gzuncompress( $i['photo2'] );
                                                                            $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                                                                            if( !file_exists( $file ) )
                                                                                file_put_contents( $file, $img);
                                                                        }else{
                                                                            $file = '';
                                                                        }  
                                                            ?>
                                                            <!-- product-item start -->
                                                            <div class="col-md-12">
                                                                <div class="shop-list product-item">
                                                                    <div class="product-img">
                                                                        <a href="single-product.php?id=<?php echo $codeart ?>">
                                                                            <img src="<?php echo $file; ?>" alt=""/>
                                                                        </a>
                                                                    </div>
                                                                    <div class="product-info">
                                                                        <div class="clearfix">
                                                                            <h6 class="product-title f-left">
                                                                                <a href="single-product.php"> <?php echo $i["designation"]; ?> </a>
                                                                            </h6>
                                                                            <div class="pro-rating f-right">
                                                                                <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                                                <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                                                <a href="#"><i class="zmdi zmdi-star"></i></a>
                                                                                <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                                                                <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <h6 class="brand-name mb-30"><?php echo $i['marque']; ?></h6>
                                                                        <h3 class="pro-price"><?php echo number_format($i['prix_vente'], 2, ',', ' ') . ' DA'; ?></h3>
                                                                        <p><?php echo substr($i["description"], 0, 80) . '...'; ?></p>
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
                                    <?php } ?>
                                        <!-- ********************************************************** tableau avec images ********************************************************** -->
                                    <?php if( $tableauAvecImg == 'Oui' ){ ?>
                                        <div role="tabpanel" class="tab-pane<?php if($tab==0){echo 'active';$tab++;}else{echo '';} ?>" id="simple-list-view">
                                            <div class="row">

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
                                                                                                photo2,
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
                                                                                            AND web=1 ";

                                                                            if( isset( $_GET['categ'] ) ){
                                                                                $query .= " AND categorie='" . mysql_real_escape_string( $_GET['categ'] ) . "' ";
                                                                            }else if( isset( $_GET['fam'] ) ){
                                                                                $query .= " AND famille='" . mysql_real_escape_string( $_GET['fam'] ) . "' ";
                                                                            }

                                                                            $query .= " ORDER BY articles.famille, categorie DESC
                                                                                          LIMIT " . $articlesPage;
                                                                            //echo $query;                
                                                                            $res = mysql_query( $query );
                                                                            while( $i = mysql_fetch_assoc( $res ) ){
                                                                                $tva     = $i['tva'];
                                                                                $codeart = $i['codeart'];
                                                                                if( $i['photo2'] != '' ){
                                                                                    $img = gzuncompress( $i['photo2'] );
                                                                                    $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                                                                                    if( !file_exists( $file ) )
                                                                                        file_put_contents( $file, $img);
                                                                                }else{
                                                                                    $file = '';
                                                                                }
                                                                    ?>

                                                                    <!-- tr -->
                                                                    <tr>
                                                                        <td class=""  style="padding-top:5px;padding-bottom:5px;">
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

                                            </div>
                                        </div>
                                    <?php } ?>
                                        <!-- ********************************************************** tableau sans images ********************************************************** -->
                                    <?php if( $tableauSansImg == 'Oui' ){ ?>
                                        <div role="tabpanel" class="tab-pane<?php if($tab==0){echo 'active';$tab++;}else{echo '';} ?>" id="tableau-sans-img">
                                            <div class="row">

                                                <div class="table-content table-condensed table-responsive mb-50">
                                                    <table class="text-center">
                                                        <thead>
                                                            <tr>
                                                                <th class="product-thumbnail" style="padding-top:10px;padding-bottom:10px;">Produit</th>
                                                                <th class="product-thumbnail" style="padding-top:10px;padding-bottom:10px;">Référence</th>
                                                                <th class="product-thumbnail" style="padding-top:10px;padding-bottom:10px;">Marque</th>
                                                                <th class="product-quantity" style="padding-top:10px;padding-bottom:10px;">Prix</th>
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
                                                                                AND web=1 ";

                                                                if( isset( $_GET['categ'] ) ){
                                                                    $query .= " AND categorie='" . mysql_real_escape_string( $_GET['categ'] ) . "' ";
                                                                }else if( isset( $_GET['fam'] ) ){
                                                                    $query .= " AND famille='" . mysql_real_escape_string( $_GET['fam'] ) . "' ";
                                                                }

                                                                $query .= " ORDER BY articles.famille, categorie DESC
                                                                              LIMIT " . $articlesPage;
                                                                //echo $query;                
                                                                $res = mysql_query( $query );
                                                                while( $i = mysql_fetch_assoc( $res ) ){
                                                                    $tva     = $i['tva'];
                                                                    $codeart = $i['codeart'];
                                                            ?>

                                                            <!-- tr -->
                                                            <tr>
                                                                <td class="" style="padding-top:5px;padding-bottom:5px;">
                                                                            <a style="text-align:center;" href="#"> <b><?php echo $i["designation"]; ?></b> </a>
                                                                </td>

                                                                <td nowrap class="" style="padding-top:5px;padding-bottom:5px;"><?php echo $i['ref']; ?></td>

                                                                <td nowrap class="" style="padding-top:5px;padding-bottom:5px;"><?php echo $i['marque']; ?></td>

                                                                <td nowrap class="" style="padding-top:5px;padding-bottom:5px;"><?php echo number_format($i['prix_vente'], 2, ',', ' ') . ' DA'; ?></td>

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

                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>

                                <!-- Tab Content end -->
                                        <!-- ********************************************************** shop-pagination-start ********************************************************** -->
                                
                                    <ul id="pagination" class="shop-pagination box-shadow text-center ptblr-10-30" data-page="1">
                                        <li title="Première" onclick="loadPage(<?php echo "1"; ?>, <?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')"><a href="#"><i class="zmdi zmdi-chevron-left"></i></a></li>
                                        <?php
                                            $query = "SELECT count(codeart) AS NB FROM articles WHERE bloquer='Non' AND web=1 ";
                                            if( isset( $_GET['categ'] ) ){
                                                $query .= " AND categorie='" . mysql_real_escape_string( $_GET['categ'] ) . "' ";
                                            }else if( isset( $_GET['fam'] ) ){
                                                $query .= " AND famille='" . mysql_real_escape_string( $_GET['fam'] ) . "' ";
                                            }

                                            $res   = mysql_query( $query );
                                            //$NB    = ceil( mysql_num_rows($res) / $articlesPage );
                                            while( $i = mysql_fetch_assoc($res) ){
                                                $NB = intval($i['NB'] / $articlesPage);
                                                if( $i['NB'] % $articlesPage != 0 )
                                                    $NB++;
                                            }

                                            $first_page = intval($current_page) - 5;
                                            if( $first_page < 1 )
                                                $first_page = 1;

                                            $last_page  = intval($current_page) + 4;
                                            if( $last_page < 10 )
                                                $last_page = 10;
                                            if( $last_page > $NB ){
                                                $last_page  = $NB;
                                                $first_page = $NB - 9;
                                                if( $first_page < 1 )
                                                    $first_page = 1;
                                            }

                                            for($p=$first_page;$p<=$last_page;$p++){
                                                if( $p == $current_page )
                                                    $active = " active";
                                                else
                                                    $active = "";
                                        ?>
                                                <li class="li_page<?php echo $active; ?>" id="li_<?php echo $p; ?>"
                                                    onclick="loadPage(<?php echo $p; ?>, <?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')">
                                                    <a class="page" href="#"><?php echo $p; ?></a>
                                                </li>
                                        <?php
                                                //echo '<li class="li_page ' . $active . '" id="li_' . $p . '" onclick="loadPage(' . $p . ', ' . $articlesPage . ',' . $fam . ',' . $categ . ')"><a class="page" href="#">' . $p . '</a></li>';
                                            }
                                        ?>
                                        <li title="Dernière" onclick="loadPage(<?php echo $NB; ?>, <?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')" class=""><a href="#"><i class="zmdi zmdi-chevron-right"></i></a></li>
                                    </ul>
                                
                                <!-- ********************************************************** shop-pagination end ********************************************************** -->
                            </div>
                        </div>




                        <!-- sidebar -->
                        <div class="col-md-3 col-md-pull-9 col-sm-12">
                            <!-- widget-search -->
                            <aside class="widget-search mb-30">
                                <form action="#">
                                    <input style="display:inline;" type="text" placeholder="Recherche...">
                                    <button type="submit"><i class="zmdi zmdi-search"></i></button>
                                </form>
                            </aside>
                            <!-- widget-familles-articles -->
                            <aside class="widget widget-categories box-shadow mb-30" style="height:313px;overflow:auto;">
                                <h6 class="widget-title border-left mb-20">Familles</h6>
                                <div id="cat-treeview" class="product-cat">
                                    <ul>
                                        <?php
                                            $query = "SELECT famille, lower(libelle) AS libelle FROM fam_articles WHERE parent='' ";
                                            $res   = mysql_query( $query );
                                            while( $i = mysql_fetch_assoc($res) ){
                                                $fami = $i['famille'];
                                                echo '<li class="closed"><a href="shop.php?fam=' . $fami . '" style="text-transform: none;">' . ucfirst($i['libelle']) . '</a>';

                                                $query2 = "SELECT famille, lower(libelle) AS libelle FROM fam_articles WHERE parent='" . $fami . "' ";
                                                $res2   = mysql_query( $query2 );
                                                if( mysql_num_rows($res2) > 0 ){
                                                    echo "<ul>";
                                                    while( $j = mysql_fetch_assoc($res2) ){
                                                            $fami = $j['famille'];
                                                            echo '<li><a href="shop.php?fam=' . $fami . '" style="text-transform: none">' . ucfirst($j['libelle']) . '</a></li>';
                                                    }
                                                    echo "</ul>";
                                                }
                                                echo '</li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </aside>
                            <!-- widget-categories-articles -->
                            <aside class="widget widget-categories box-shadow mb-30" style="height:313px;overflow:auto;">
                                <h6 class="widget-title border-left mb-20">Catégories</h6>
                                <div id="cat-treeview" class="product-cat">
                                    <ul>
                                        <?php
                                            $query = "SELECT lower(categorie) AS categorie FROM categories";
                                            $res   = mysql_query( $query );
                                            while( $i = mysql_fetch_assoc($res) ){
                                                $catego = $i['categorie'];
                                                echo '<li class="closed"><a href="shop.php?categ=' . $catego . '" style="text-transform: none;">' . ucfirst($i['categorie']) . '</a>';
                                                echo '</li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </aside>
                            <!-- shop-filter -->
                            <aside class="widget shop-filter box-shadow mb-30">

    							<?php
    								$query = "SELECT min(prix_vente1) as minP, max(prix_vente1) as maxP FROM articles ";
    								$res   = mysql_query( $query );
    								while( $p = mysql_fetch_assoc($res) ){
    									$min = $p['minP'];
    									$max = $p['maxP'];
    								}
    							?>
                                <h6 class="widget-title border-left mb-20">Intervalle de Prix (DA)</h6>
                                <div class="price_filter hidden" data-min="<?php echo $min; ?>" data-max="<?php echo $max; ?>">
                                    <div class="price_slider_amount">
                                        <input type="submit"  value="Intervalle:"/>
                                        <input type="text" id="amount" name="price"  placeholder="Ajouter votre prix" />
                                    </div>
                                    <div id="slider-range"></div>
                                </div>
								
								<div class="price_filter">	
									<input onchange="" type="number" id="minPrice" class="form-control numeric" value="<?php echo $min; ?>" ><br>
									<input onchange="" type="number" id="maxPrice" class="form-control numeric" value="<?php echo $max; ?>" ><br>
									<button style="background-color:#FF962F;color:white;margin-top:-10px;" 
											class="btn btn- pull-right" 
											onclick="filterPrice(<?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')">Filtrer</button>
								</div>
								
                            </aside>
                            <!-- widget-color -->
                            <aside class="widget widget-color box-shadow mb-30 hidden">
                                <h6 class="widget-title border-left mb-20">Couleur</h6>
                                <ul>
                                    <li class="color-1"><a href="#">LightSalmon</a></li>
                                    <li class="color-2"><a href="#">Dark Salmon</a></li>
                                    <li class="color-3"><a href="#">Tomato</a></li>
                                    <li class="color-4"><a href="#">Deep Sky Blue</a></li>
                                    <li class="color-5"><a href="#">Electric Purple</a></li>
                                    <li class="color-6"><a href="#">Atlantis</a></li>
                                </ul>
                            </aside>
                            <!-- operating-system -->
                            <aside class="widget operating-system box-shadow mb-30" style="height:313px;overflow:auto;">
                                <h6 class="widget-title border-left mb-20">Marques</h6>
                                <form action="action_page.php">
                                    <?php
                                        $query = "SELECT marque AS marque FROM marques ";
                                        $res   = mysql_query( $query );
    								?>
    										<label><input checked class="marque" style="text-transform:none;" type="radio" onclick="filterMarque(1, '-', '<?php echo $fam; ?>', '<?php echo $categ; ?>', <?php echo $articlesPage; ?>)" name="marque" value="-"> Toutes</label><br>
    								<?php	
                                        while( $i = mysql_fetch_assoc( $res ) ){
                                    ?>
                                            <label><input class="marque" style="text-transform:none;" type="radio" onclick="filterMarque(1, '<?php echo $i['marque']; ?>', '<?php echo $fam; ?>', '<?php echo $categ; ?>', <?php echo $articlesPage; ?>)" name="marque" value="<?php echo $i['marque']; ?>"> <?php echo ucfirst($i['marque']); ?></label><br>
                                    <?php
                                        }
                                    ?>

                                </form>
                            </aside>

                            <!-- widget-product -->
                            <aside class="widget widget-product box-shadow">
                                <h6 class="widget-title border-left mb-20">Produits récents</h6>
                                        <?php
                                            $query = "SELECT    articles.codeart,
                                                                photo,
                                                                extention,
                                                                designation,
                                                                prix_vente1
                                                          FROM  articles
                                                          LEFT  JOIN descriptions ON articles.codeart = descriptions.codeart
                                                          LEFT  JOIN myphotos     ON myphotos.code = concat('AR',articles.codeart)
                                                          WHERE bloquer='Non'
                                                            AND web=1
                                                          ORDER BY 'create'
                                                          LIMIT 3";
                                            $res = mysql_query( $query );
                                            while( $i = mysql_fetch_assoc( $res ) ){
                                                $img = gzuncompress( $i['photo'] );
                                                $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                                                if( !file_exists( $file ) )
                                                    file_put_contents($file, $img);
                                        ?>
                                    <!-- product-item start -->
                                    <div class="product-item">
                                        <div class="product-img">
                                            <a href="single-product.php">
                                                <img src="<?php echo $file; ?>" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <h6 class="product-title">
                                                <a href="single-product.html"> <?php echo $i["designation"]; ?></a>
                                            </h6>
                                            <h3 class="pro-price"> <?php echo number_format($i["prix_vente1"], 2, ',', ' ') . ' DA'; ?></h3>
                                        </div>
                                    </div>
                                    <!-- product-item end -->
                                        <?php
                                            }
                                        ?>
                            </aside>

                        </div>








                    </div>
                </div>
            </div>
            <!-- SHOP SECTION END -->

        </div>
        <!-- End page content -->

        <!-- START FOOTER AREA -->
            <?php include("include/footer.php"); ?>
        <!-- END FOOTER AREA -->

        <!-- START QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <!-- Modal -->
                <?php include("include/modalProduct.php"); ?>
            <!-- END Modal -->
        </div>
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

    <script>
		
        $(document).ready(function() {
              //prevent forms from submitting
              $("form").submit(function(e){
                  e.preventDefault();
              });

              //corriger boutique
              if( $("#grid-view") )
                  articleView(1);
              else if( $("#list-view") )
                  articleView(2);
              else if( $("#simple-list-view") )
                  articleView(3);
              else if( $("#tableau-sans-img") )
                  articleView(4);
			  
        });
		
		function priceSlider(minPrice, maxPrice){
				$( "#slider-range" ).slider({
					range: true,
					min: minPrice,
					max: maxPrice,
					values: [ minPrice, maxPrice ],
					slide: function( event, ui ) {
						$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
					}
				});
				
			$( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) + " - " + 

			$( "#slider-range" ).slider( "values", 1 )  );
		}
		
		function searchProduct( articlesPage, fam, categ ){
			var marque = "";
			if( $("input.marque:checked").length > 0 )
				marque  = $("input.marque:checked").val(); 
		
            var sort    = $("#sort option:selected").val();
			var prixMin = $("#minPrice").val();
			var prixMax = $("#maxPrice").val();
			//search terme
			var searchTerm = $("#term").val();
			
            reloadProducts( 1, articlesPage, fam, categ, marque, prixMin, prixMax, sort, searchTerm );
		}
		
		function sort(articlesPage, fam, categ){
			var marque = "";
			if( $("input.marque:checked").length > 0 )
				marque  = $("input.marque:checked").val(); 
		
            var sort    = $("#sort option:selected").val();
			var prixMin = $("#minPrice").val();
			var prixMax = $("#maxPrice").val();
            //search terme
            var searchTerm = $("#term").val();
			
            reloadProducts( 1, articlesPage, fam, categ, marque, prixMin, prixMax, sort, searchTerm );
		}
		
        //go from page to page
        function loadPage( p, articlesPage, fam, categ ){
			var marque = "";
			if( $("input.marque:checked").length > 0 )
				marque  = $("input.marque:checked").val(); 
		
            var sort    = $("#sort option:selected").val();
			var prixMin = $("#minPrice").val();
			var prixMax = $("#maxPrice").val();
            //search terme
            var searchTerm = $("#term").val();
			
            reloadProducts( p, articlesPage, fam, categ, marque, prixMin, prixMax, sort, searchTerm );
        }
		
		function filterPrice(articlesPage, fam, categ){
			var marque = "";
			if( $("input.marque:checked").length > 0 )
				marque  = $("input.marque:checked").val(); 
		
            var sort    = $("#sort option:selected").val();
			var prixMin = $("#minPrice").val();
			var prixMax = $("#maxPrice").val();
            //search terme
            var searchTerm = $("#term").val();
			
            reloadProducts( 1, articlesPage, fam, categ, marque, prixMin, prixMax, sort, searchTerm );
		}
		
        function filterMarque(p, marque, fam, categ, articlesPage){
            var sort 	= $("#sort option:selected").val();
			var prixMin = $("#minPrice").val();
			var prixMax = $("#maxPrice").val();
            //search terme
            var searchTerm = $("#term").val();
            
            reloadProducts( p, articlesPage, fam, categ, marque, prixMin, prixMax, sort, searchTerm );
        }
		
        function reloadProducts( p, articlesPage, fam, categ, marque, prixMin, prixMax, sort, search ){
                    //update paginator
                    $.ajax({
                        url  : "snippets/loadPaginator.php" ,
                        type : "POST",
                        data : { "page"   : p, "articlesPage" : articlesPage, "fam" : fam, "categ"    : categ,
                                 "marque" : marque, "prixMin" : prixMin, "prixMax"  : prixMax, "sort" : sort, "search" : search
                               },
                        success: function(data,status,xhr){
                            $('#pagination').html( data );
                        }
                    });
                    //grid view
                    if( $('#grid-view .row').length > 0 ){
                        $.ajax({
                            url : "snippets/loadPageGrid.php" ,
                            type: "POST",
                            data : { "page" : p, "articlesPage" : articlesPage, "fam" : fam, "categ" : categ,
                                     "marque" : marque, "prixMin" : prixMin, "prixMax" : prixMax, "sort" : sort, "search" : search
                                   },
                            success: function(data,status,xhr){
                                $('#grid-view .row').html( data );
                            }
                        });
                    }    
                    //list view
                    if( $('#list-view .row').length > 0 ){
                        $.ajax({
                            url : "snippets/loadPageList.php" ,
                            type: "POST",
                            data : { "page" : p, "articlesPage" : articlesPage, "fam" : fam, "categ" : categ,
                                     "marque" : marque, "prixMin" : prixMin, "prixMax" : prixMax, "sort" : sort, "search" : search
                                   },
                            success: function(data,status,xhr){
                                $('#list-view .row').html( data );
                            }
                        });
                    }    
                    //table view (avec img)
                    if( $('#simple-list-view .row').length > 0 ){
                        $.ajax({
                            url : "snippets/loadPageTable.php" ,
                            type: "POST",
                            data : { "page" : p, "articlesPage" : articlesPage, "fam" : fam, "categ" : categ,
                                     "marque" : marque, "prixMin" : prixMin, "prixMax" : prixMax, "sort" : sort, "search" : search
                                   },
                            success: function(data,status,xhr){
                                $('#simple-list-view .row').html( data );
                            }
                        });
                    }
                    //table view (sans img)
                    if( $('#tableau-sans-img .row').length > 0 ){
                        $.ajax({
                            url : "snippets/loadPageTable-sansImg.php" ,
                            type: "POST",
                            data : { "page" : p, "articlesPage" : articlesPage, "fam" : fam, "categ" : categ,
                                     "marque" : marque, "prixMin" : prixMin, "prixMax" : prixMax, "sort" : sort, "search" : search
                                   },
                            success: function(data,status,xhr){
                                $('#tableau-sans-img .row').html( data );
                            }
                        });
                    }    
                    //$('.li_page').removeClass('active');
                    //$('#li_'+p).addClass('active');

                    $('html, body').animate({
                        scrollTop: $("#products").offset().top
                    }, 2000);
        }         
            
        function add2WishList(codeart){
          //ajouter à la liste des souhaits
          $.ajax({
              url : "snippets/add2WishList.php" ,
              type: "POST",
              data : { "codeart" : codeart },
              success: function(data,status,xhr){

              }
          });
        }

        function add2CartModal( codeart, qte ){
            add2Cart( codeart, qte );
        }

        function add2Cart( codeart, qte ){
            //ajouter à la carte
            $.ajax({
                url : "snippets/add2Cart.php" ,
                type: "POST",
                data : { "codeart" : codeart, "qte" : qte },
                success: function(data,status,xhr){
                    ;
                }
            });
        }

        function articleView(t){
            if( t == 1 ){
                $("#grid-view").show();                 
                $("#list-view").hide();                 
                $("#simple-list-view").hide();          
                $('#tableau-sans-img').hide();          
            }else if( t == 2 ){
                $("#grid-view").hide();                 
                $("#list-view").show();                 
                $("#simple-list-view").hide();          
                $('#tableau-sans-img').hide();          
            }else if( t == 3 ){
                $("#grid-view").hide();                 
                $("#list-view").hide();                 
                $("#simple-list-view").show();          
                $('#tableau-sans-img').hide();          
            }else if( t == 4 ){
                $("#grid-view").hide();                 
                $("#list-view").hide();                 
                $("#simple-list-view").hide();          
                $('#tableau-sans-img').show();
            }
        }

        function QteChange(codeart){
            var click = "add2CartModal('" + codeart + "'," + $("#productQte").val() + ")";
            $("#btnAdd2Cart").attr( "onclick", click );
        }

        function changeModal(codeart){
            $("#modalImg").attr("src", $("#photo_" + codeart).attr('src') );
            $("#productName").text( $('#designation_' + codeart).text() );
            $("#productName").data("val", codeart);
            $("#productPrix").text( $("#prix_" + codeart).text() );
            $("#productDescription").html( $("#description_" + codeart).html() );
            $("#details").attr("href", 'single-product.php?id=' + codeart );

            //Qte
            $.ajax({
                url : "snippets/panierQte.php",
                type: "POST",
                data : { "codeart" : codeart },
                success: function(data,status,xhr){
                    if( data == "0" ){
                        $("#productQte").val( "2" );
                    }else{
                        $("#productQte").val( data );
                    }
                }
            });

            //bouton add 2 cart
            var keyup = "QteChange('" + codeart + "'" + ")";
            $("#productQte").attr( "onkeyup", keyup );
            $("#productQte").attr( "onchange", keyup );

            var click = "add2CartModal('" + codeart + "'," + $("#productQte").val() + ")";
            $("#btnAdd2Cart").attr( "onclick", click );
        }

    </script>

</body>

</html>
