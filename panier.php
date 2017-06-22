<?php
    session_start();
    include("db.php");

    $xml         = simplexml_load_file("../config/parametres.xml");
    $societe     = $xml->xpath( '/parametres/affichage/about/societe' )[0];
    $description = $xml->xpath( '/parametres/affichage/about/description' )[0];
    $facebook    = $xml->xpath( '/parametres/affichage/contact/facebook' )[0];
    $googleplus  = $xml->xpath( '/parametres/affichage/contact/googleplus' )[0];
    $twitter     = $xml->xpath( '/parametres/affichage/contact/twitter' )[0];
    $favicon     = $xml->xpath( '/parametres/themes/favicon' )[0];
    $tel         = $xml->xpath( '/parametres/affichage/contact/mobile' )[0];
    $banner      = $xml->xpath( '/parametres/themes/banner' )[0];

    $fraisLivraison = $xml->xpath( '/parametres/affichage/boutique/fraisLivraison' )[0];
    
    //peut être le client n'est pas sujetté à la tva
    if( !isset($_SESSION['notva']) or $_SESSION['notva'] == 0 ){ 
        //$tva = $xml->xpath( '/parametres/affichage/boutique/tva' )[0];
        $notva = "true";
    }else{
        $notva = "false";
    }

    //tarification pour ce client
    if( !isset($_SESSION['tarification']) or $_SESSION['tarification'] == 1 ){ 
        $tarification = 1;
    }else{
        $tarification = $_SESSION['tarification'];
    }

    //SEO
    $metaDescription  = trim($xml->xpath( '/parametres/seo/metaDescription' )[0]);
    $keywords         = trim($xml->xpath( '/parametres/seo/keywords' )[0]);

    if( !isset( $_SESSION['wishlist'] ) ){
        $_SESSION['wishlist'] = "";
    }

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Panier</title>
    <link rel="icon" href="<?php echo '../assets/img/' . $favicon; ?>" />
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>"></meta>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/icon/favicon.png">

    <!-- All CSS Files -->
    <!-- 7 stroke -->
    <link rel="stylesheet" type="text/css" href="assets/lib/stroke-7/style.css">
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


            <div id="successAlert" role="alert" class="col-sm-6 alert alert-success alert-icon alert-dismissible hidden" style="margin-top:3px;">
              <div class="icon"><span class="s7-check"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span id="success_msg"> Les modifications ont été sauvegardé</span>
              </div>
            </div>

            <div  id="errorAlert" role="alert" class="col-sm-6 alert alert-danger alert-icon alert-dismissible hidden" style="margin-top:3px;">
              <div class="icon"><span class="s7-close-circle"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span id="error_msg">Erreur lors de la sauvegarde des modifications</span>
              </div>
            </div>


        </div>
        <!-- BREADCRUMBS SETCTION END -->

        <!-- Start page content -->
        <section id="page-content" class="page-wrapper" data-notva="<?php echo $notva; ?>">

            <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <ul class="cart-tab">
                                <li>
                                    <a class="active" href="#shopping-cart" data-toggle="tab">
                                        <span>01</span>
                                        Mon panier
                                    </a>
                                </li>
                                <li>
                                    <a href="#wishlist" data-toggle="tab">
                                        <span>02</span>
                                        Liste de souhaits
                                    </a>
                                </li>
                                <li>
                                    <a href="#checkout" data-toggle="tab">
                                        <span>03</span>
                                        Compte
                                    </a>
                                </li>
                                <li>
                                    <a href="#order-complete" data-toggle="tab">
                                        <span>04</span>
                                        Finlisation
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- shopping-cart start -->
                                <div class="tab-pane active" id="shopping-cart">
                                    <div class="shopping-cart-content">
                                        <form action="#">
                                            <div class="table-content table-responsive mb-50">
                                                <table class="text-center" id="panier">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-">Produit</th>
                                                            <th class="product-price">Prix</th>
                                                            <th class="product-quantity">Quantité</th>
                                                            <th class="product-price">Total</th>
                                                            <th class="product-">Supprimer</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $NB = 0;
                                                        $articles = "()";

                                                        if( isset( $_SESSION['articles_count'] ) ){
                                                            $NB = $_SESSION['articles_count'];
                                                            $articles = "(";
                                                            for($i=1; $i<=$NB; $i++ ){
                                                                if( $articles == "(" )
                                                                    $articles .= "'" . $_SESSION["article_" . $i] . "'";
                                                                else
                                                                    $articles .= ",'" . $_SESSION["article_" . $i] . "'";
                                                            }
                                                            $articles .= ")";
                                                        }                                                        

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
                                                                        AND articles.codeart IN " . $articles;


                                                        if( $res = mysql_query( $query ) ){
                                                              while( $i = mysql_fetch_assoc($res) ){
                                                                  $tva     = $i['tva'];
                                                                  $codeart = $i['codeart'];
                                                                  $qte     = $_SESSION['qte_' . $codeart];
                                                                  if( $qte == 0 )
                                                                      continue;

                                                                  $total   = $i['prix_vente'] * $qte;

                                                                  $img = gzuncompress( $i['photo2'] );
                                                                  $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                                                                  if( !file_exists( $file ) )
                                                                      file_put_contents($file, $img);

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
                                                            }else{
                                                              echo "<tr><td colspan='5'>Aucun article dans votre panier</td></tr>";
                                                            }
                                                          ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="coupon-discount box-shadow p-30 mb-50 hidden">
                                                        <h6 class="widget-title border-left mb-20">Coupon</h6>
                                                        <p>Veuillez indiquer ici le code de votre coupon (le cas échéant)</p>
                                                        <input type="text" name="name" placeholder="Code coupon ici">
                                                        <button class="submit-btn-1 black-bg btn-hover-2" type="submit">Appliquer</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="payment-details box-shadow p-30 mb-50">
                                                        <h6 class="widget-title border-left mb-20">Détails du paiement</h6>
                                                        <table>
                                                            <tr>
                                                                <td class="td-title-1">Total HT</td>
                                                                <td class="td-title-2" id="total_ht" data-totalht="0.00">0.00 DA</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">Frais de livraison</td>
                                                                <td class="td-title-2" id="frais" data-frais="<?php echo $fraisLivraison; ?>"><?php echo number_format(floatval($fraisLivraison), 2, ',', ' ') . " DA"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">TVA</td>
                                                                <td class="td-title-2 tva" id="tva" data-tva="<?php echo $tva; ?>"><?php echo number_format(floatval($tva), 2, ',', ' ') . " %"; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="order-total">Total</td>
                                                                <td class="order-total-price" id="total" data-total="0.00">0.00 DA</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row hidden">
                                                <div class="col-md-12">
                                                    <div class="culculate-shipping box-shadow p-30">
                                                        <h6 class="widget-title border-left mb-20">Calcul des frais de livraison</h6>
                                                        <p>Enter your coupon code if you have one!</p>
                                                        <div class="row">
                                                            <div class="col-sm-4 col-xs-12">
                                                                <input type="text"  placeholder="Country">
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12">
                                                                <input type="text"  placeholder="Region / State">
                                                            </div>
                                                            <div class="col-sm-4 col-xs-12">
                                                                <input type="text"  placeholder="Post code">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button class="submit-btn-1 black-bg btn-hover-2">get a quote</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- shopping-cart end -->
                                <!-- wishlist start -->
                                <div class="tab-pane" id="wishlist">
                                    <div class="wishlist-content">
                                        <form action="#">
                                            <div class="table-content table-responsive mb-50">
                                                <table class="text-center">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-thumbnail">Produit</th>
                                                            <th class="product-price">Prix</th>
                                                            <th class="product-stock">Disponibilité</th>
                                                            <th class="product-add-cart">Ajouter à la carte</th>
                                                            <th class="product-remove">Supprimer</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                      <?php

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
                                                                          AND articles.codeart IN (" . $_SESSION["wishlist"] . ")";

                                                          if( $res = mysql_query( $query ) ){
                                                                while( $i = mysql_fetch_assoc($res) ){
                                                                    $codeart = $i['codeart'];
                                                                    //$total   = $i['prix_vente'] * $qte;

                                                                    $img = gzuncompress( $i['photo2'] );
                                                                    $file = "img/articles/" . $i['codeart'] . '_img' . $i['extention'];
                                                                    if( !file_exists( $file ) )
                                                                        file_put_contents($file, $img);

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

                                                                    <td nowrap class="product-price"><?php echo number_format($i['prix_vente'], 2, ',',' ') . ' DA'; ?></td>

                                                                    <td class="product-stock text-uppercase">Disponible</td>
                                                                    <td class="product-add-cart">
                                                                        <a href="#" title="Add To Cart" onclick="add2Cart('<?php echo $codeart; ?>', 1)">
                                                                            <i class="zmdi zmdi-shopping-cart-plus"></i>
                                                                        </a>
                                                                    </td>

                                                                    <td nowrap class="product-">
                                                                        <a href="#"><i class="zmdi zmdi-close" onclick="deleteFromWishlist('<?php echo $codeart; ?>')"></i></a>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                                }
                                                              }else{
                                                                    echo "<tr><td colspan='5'>Aucun article dans votre liste de souhaits</td></tr>";
                                                              }
                                                            ?>

                                                        </tr>
                                                        <!-- tr -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- wishlist end -->
                                <!-- checkout start -->
                                <div class="tab-pane" id="checkout">
                                    <div class="checkout-content box-shadow p-30">

                                            <div class="row">
                                                <!-- billing details -->
                                                <?php if( !isset( $_SESSION['typeCompte'] ) ){ ?>
                                                        <!-- create account and save cmd -->
                                                        <div class="col-md-6">
                                                            <div class="billing-details pr-10">
                                                                <h6 class="widget-title border-left mb-20">Créer un compte</h6>
                                                                <form action="#">
                                                                    <input type="text"     name="raison"    id="raison"     placeholder="Raison sociale" >
                                                                    <input type="text"     name="email"     id="email"      placeholder="Email" >
                                                                    <input type="password" name="pass"      id="pass"       placeholder="Mot de passe" >
                                                                    <input type="password" name="cpass"     id="cpass"      placeholder="Confirmer le mot de passe" >
                                                                    <input type="text"     name="telephone" id="telephone"  placeholder="Téléphone">
                                                                    <select class="custom-select" id="pays">
                                                                        <?php include('include/pays.php'); ?>
                                                                    </select>
                                                                    <input type="text" name="departement"   id="departement"    placeholder="Département">
                                                                    <input type="text" name="ville"         id="ville"          placeholder="Ville">
                                                                    <textarea class="custom-textarea" name="adresse" id="adresse" placeholder="Adresse"></textarea>
                                                                    <button class="submit-btn-1 mt-30 btn-hover-1 pull-right" onclick="createAccount()">Créer</button>
                                                                </form>    
                                                            </div>
                                                        </div>
                                                        <!-- login and save cmd -->
                                                        <div class="col-md-6">
                                                            <div class="billing-details pr-10">
                                                                <h6 class="widget-title border-left mb-20">Connectez-vous</h6>
                                                                <form action="#" method="POST">    
                                                                    <input type="text"     name="username"  id="username"      placeholder="Email">
                                                                    <input type="password" name="password"  id="password"   placeholder="Mot de passe">
                                                                    <button type="submit" class="submit-btn-1 mt-30 btn-hover-1 pull-right" type="submit" onclick="login()">Connexion</button>
                                                                </form>    
                                                            </div>
                                                        </div>
                                                <?php }else{ ?>
                                                        <div class="col-md-6">
                                                            <div class="billing-details pr-10">
                                                                <h6 class="widget-title border-left mb-20">Vous êtes connecté(e)</h6>
                                                                <i class="zmdi zmdi-account-box-o" style="color:;font-size: 1200%;margin-left:50px;"></i>  
                                                            </div>
                                                        </div>
                                                <?php } ?>

                                                <br>        
                                                <div class="col-md-6">
                                                    <!-- our order -->
                                                    <div class="payment-details pl-10 mb-50">
                                                        <h6 class="widget-title border-left mb-20">Détails de la commande</h6>
                                                        <table>
                                                              <tr>
                                                                  <td class="td-title-1">Total HT de la commande</td>
                                                                  <td class="td-title-2 total_ht">0.00 DA</td>
                                                              </tr>
                                                              <tr>
                                                                  <td class="td-title-1">Frais de livraison</td>
                                                                  <td class="td-title-2 frais"><?php echo number_format(floatval($fraisLivraison), 2, ',', ' ') . ' DA'; ?></td>
                                                              </tr>
                                                              <tr>
                                                                  <td class="td-title-1">TVA</td>
                                                                  <td class="td-title-2 tva"><?php echo number_format(floatval($tva), 2, ',',' ') . "%"; ?></td>
                                                              </tr>
                                                              <tr>
                                                                  <td class="order-total">Total de la commande</td>
                                                                  <td class="order-total-price total">0.00 DA</td>
                                                              </tr>
                                                        </table>
                                                    </div>
                                                    <!-- payment-method -->
                                                    <?php if(false){ ?>
                                                      <div class="payment-method">
                                                        <h6 class="widget-title border-left mb-20">Méthode de paiement</h6>
                                                        <div id="accordion">
                                                            <div class="panel">
                                                                <h4 class="payment-title box-shadow">
                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#bank-transfer" >
                                                                    Virement banciare
                                                                    </a>
                                                                </h4>
                                                                <div id="bank-transfer" class="panel-collapse collapse in" >
                                                                    <div class="payment-content">
                                                                    <p>Lorem Ipsum is simply in dummy text of the printing and type setting industry. Lorem Ipsum has been.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel">
                                                                <h4 class="payment-title box-shadow">
                                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                                    Paiement par chèque
                                                                    </a>
                                                                </h4>
                                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                                    <div class="payment-content">
                                                                        <p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel">
                                                                <h4 class="payment-title box-shadow">
                                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" >
                                                                    Paypal
                                                                    </a>
                                                                </h4>
                                                                <div id="collapseThree" class="panel-collapse collapse" >
                                                                    <div class="payment-content">
                                                                        <p>Pay via PayPal; you can pay with your credit card if you don't have a PayPal account.</p>
                                                                        <ul class="payent-type mt-10">
                                                                            <li><a href="#"><img src="img/payment/1.png" alt=""></a></li>
                                                                            <li><a href="#"><img src="img/payment/2.png" alt=""></a></li>
                                                                            <li><a href="#"><img src="img/payment/3.png" alt=""></a></li>
                                                                            <li><a href="#"><img src="img/payment/4.png" alt=""></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <!-- payment-method end -->

                                                </div>
                                            </div>

                                    </div>
                                </div>
                                <!-- checkout end -->
                                <!-- order-complete start -->
                                <div class="tab-pane" id="order-complete">
                                    <div class="order-complete-content box-shadow">
                                        <div class="thank-you p-30 text-center hidden" id="merci">
                                            <h6 class="text-black-5 mb-0" style="color:green;">Merci. Votre commande a été bien reçu</h6>
                                        </div>
                                        <div class="order-info p-30 mb-10">
                                            <ul class="order-info-list">
                                                <li>
                                                    <h6>Enregistrement de la commande</h6>
                                                    <p id="numero_cmd"></p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <!-- our order -->
                                            <div class="col-md-6">
                                                <div class="payment-details p-30">
                                                    <h6 class="widget-title border-left mb-20">Détails de la commande</h6>
                                                    <table>
                                                          <tr>
                                                              <td class="td-title-1">Total HT de la commande</td>
                                                              <td class="td-title-2 total_ht">0.00 DA</td>
                                                          </tr>
                                                          <tr>
                                                              <td class="td-title-1">Frais de livraison</td>
                                                              <td class="td-title-2 frais"><?php echo number_format(floatval($fraisLivraison), 2, ',', ' ') . ' DA'; ?></td>
                                                          </tr>
                                                          <tr>
                                                              <td class="td-title-1">TVA</td>
                                                              <td class="td-title-2 tva"><?php echo number_format(floatval($tva), 2, ',',' ') . "%"; ?></td>
                                                          </tr>
                                                          <tr>
                                                              <td class="order-total">Total de la commande</td>
                                                              <td class="order-total-price total">0.00 DA</td>
                                                          </tr>
                                                        
                                                          <tr>  
                                                                <td></td>
                                                                <td><button type="submit" class="submit-btn-1 mt-30 btn-hover-1 pull-right" onclick="saveCmd()">Valider</button></td>
                                                          </tr>

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bill-details p-30">
                                                    <h6 class="widget-title border-left mb-20">Coordonnées du client</h6>
                                                    <ul class="bill-address">
                                                          <li id="adresse1">
                                                              <span>Addresse : </span>
                                                              <?php if( isset( $_SESSION['typeCompte'] ) ) echo $_SESSION['adresse']; ?>
                                                          </li>
                                                          <li id="email1">
                                                              <span>Email : </span>
                                                              <?php if( isset( $_SESSION['typeCompte'] ) ) echo $_SESSION['mail']; ?>
                                                          </li>
                                                          <li id="telephone1">
                                                              <span>Téléphone : </span>
                                                              <?php if( isset( $_SESSION['typeCompte'] ) ) echo $_SESSION['telephone']; ?>
                                                          </li>
                                                    </ul>
                                                </div>
                                                <?php if(false){ ?>
                                                <div class="bill-details pl-30">
                                                    <h6 class="widget-title border-left mb-20">billing details</h6>
                                                    <ul class="bill-address">
                                                          <li>
                                                              <span>Addresse:</span>
                                                              <span>28 Green Tower, Street Name, New York City, USA<
                                                          </li>
                                                          <li>
                                                              <span>Email:</span>
                                                              <span>info@companyname.com</span>
                                                          </li>
                                                          <li>
                                                              <span>Téléphone : </span>
                                                              <span>(+880) 19453 821758</span>
                                                          </li>
                                                    </ul>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- order-complete end -->
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

              //some work
              $(".cart-plus-minus.f-left").each(function(){
                  var qte     = $(this).children("input").val();
                  var codeart = $(this).attr("data-codeart");
                  $(this).children("div.inc.qtybutton").attr("data-codeart", codeart);
                  $(this).children("div.dec.qtybutton").attr("data-codeart", codeart);
              });

              //qte inc button
              $(".inc.qtybutton").click(function(){
                  var codeart = $(this).attr("data-codeart");
                  updateCart(codeart);
              });
              //qte dec button
              $(".dec.qtybutton").click(function(){
                  var codeart = $(this).attr("data-codeart");
                  updateCart(codeart);
              });

              //calcul du total
              caclTotal();

        });

        function createAccount(){
                //attempt to login
                var raison       = $("#raison").val();
                var email        = $("#email").val(); 
                var pass         = $("#pass").val();
                var cpass        = $("#cpass").val();
                var telephone    = $("#telephone").val();
                var pays         = $("#pays option:selected").val();
                var departement  = $("#departement").val();
                var ville        = $("#ville").val();
                var adresse      = $("#adresse").val();

                $("#adresse1").html("<span>Adresse : </span>" + adresse);
                $("#email1").html("<span>Email : </span>" + email);
                $("#telephone1").html("<span>Téléphone : </span>" + telephone);

                if( (raison=='') || (email=='') || (pass=='') || (pays=='')  ){
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#successAlert").addClass("hidden");
                    $("#errorAlert").removeClass("hidden");
                    $("#errorAlert span#error_msg").text("Merci de bien remplir le formulaire");
                    return;
                }else if( pass != cpass ){
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#successAlert").addClass("hidden");
                    $("#errorAlert").removeClass("hidden");
                    $("#errorAlert span#error_msg").text("Merci de bien confirmer votre mot de passe");
                    return;
                }else if( pass.length < 6 ){
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#successAlert").addClass("hidden");
                    $("#errorAlert").removeClass("hidden");
                    $("#errorAlert span#error_msg").text("le mot de passe doit avoir au moins 6 caractères");
                    return;
                }else if( (!pass.match(/[a-z]/i)) || (!pass.match(/[0-9]/i)) ){
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#successAlert").addClass("hidden");
                    $("#errorAlert").removeClass("hidden");
                    $("#errorAlert span#error_msg").text("le mot de passe doit être alphanumérique");
                    return;
                }else{
                    $.ajax({
                        url  : "snippets/createAccount.php" ,
                        type : "POST",
                        data : {    "email"      : email, 
                                    "raison"     : raison,
                                    "pass"       : pass,
                                    "telephone"  : telephone,
                                    "pays"       : pays,
                                    "departement": departement, 
                                    "ville"      : ville,
                                    "adresse"    : adresse
                               },
                        success: function(data,status,xhr){
                            if( data == 'true' ){//valid user
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                                $("#errorAlert").addClass("hidden");
                                $("#successAlert").removeClass("hidden");
                                $("#successAlert span#success_msg").text("Votre compte a été créé");
                            }else if( data == "false" ){
                                $("html, body").animate({ scrollTop: 0 }, "slow");
                                $("#successAlert").addClass("hidden");
                                $("#errorAlert").removeClass("hidden");
                                $("#errorAlert span#error_msg").text("Cet email est déjà utilisé");
                            }
                        }
                    });
                }

        }

        function login(){
                //attempt to login
                var email    = $("#username").val();
                var password = $("#password").val();

                $.ajax({
                    url  : "snippets/loginScript.php" ,
                    type : "POST",
                    data : {    "email"      : email, 
                                "password"   : password
                           },
                    success: function(data,status,xhr){
                        if( data == 'true' ){//valid user
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $("#errorAlert").addClass("hidden");
                            $("#successAlert").removeClass("hidden");
                            $("#successAlert span#success_msg").text("Vous êtes maintenant connecté(e)");
                            //ramener l'adresse du client
                        }else{
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $("#successAlert").addClass("hidden");
                            $("#errorAlert").removeClass("hidden");
                            $("#errorAlert span#error_msg").text("Email et/ou mot de passe incorrect");
                        }
                    }
                });
        }

        function saveCmd(){
              $.ajax({
                  url  : "snippets/saveCmd.php" ,
                  type : "POST",
                  data : {  },
                  success: function(data,status,xhr){
                        if( data == 'true' ){//valid cmd
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $("#errorAlert").addClass("hidden");
                            $("#successAlert").removeClass("hidden");
                            $("#successAlert span#success_msg").text("Votre commande a été enregistré");
                            //show thank you msg
                            $("#merci").show();
                        }else{
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $("#successAlert").addClass("hidden");
                            $("#errorAlert").removeClass("hidden");
                            $("#errorAlert span#error_msg").text("Erreur lors de l'enregistrement de votre commande");
                        }
                  }
              });
        }

        function thousandSeparator(n, sep){
              var sRegExp = new RegExp('(-?[0-9]+)([0-9]{3})'),
                sValue = n + '';
              if(sep === undefined)
              {
                sep = ',';
              }
              while(sRegExp.test(sValue))
              {
                sValue = sValue.replace(sRegExp, '$1' + sep + '$2');
              }
              return sValue;
        }


        function caclTotal(){
            var total_ht = 0;
            var frais    = $("#frais").data('frais');
            //var tva      = $("#tva").data('tva');
            var tva = 0;
            var total    = 0;

            //calcul du 'total_ht' et total de 'tva'
            $(".total-article").each(function(){
                var toti  = parseFloat($(this).attr('data-tot'));  //alert( toti );
                total_ht += toti;

                if( $("#page-content").attr("data-notva") == "true" ){
                    var tvai  = parseFloat($(this).attr('data-tva'));
                    tva      += toti * tvai/100;
                }
            });
            
            $(".td-title-2.tva").text( thousandSeparator((tva).toFixed(2), ' ') + ' DA' );

            total       = total_ht + tva + frais;
            total_tva   = total_ht*tva/100     + frais;

            $("#total_ht").text( thousandSeparator((total_ht).toFixed(2), ' ') + ' DA' );
            $(".total_ht").text( thousandSeparator((total_ht).toFixed(2), ' ') + ' DA' );
            $("#total").text( thousandSeparator((total).toFixed(2), ' ') + ' DA' );
            $(".order-total-price").text( thousandSeparator((total).toFixed(2), ' ') + ' DA' );

            //update total
              $.ajax({
                  url : "snippets/updateCartTotal.php",
                  type: "POST",
                  data : { "total" : total, "total_ht" : total_ht, "total_tva": total_tva },
                  success: function(data,status,xhr){
                        //updating on the page    order-total-price total
                        $("#total_panier").text( thousandSeparator((total).toFixed(2), ' ') + ' DA' );
                  }
              });
        }

        function caclTotal1(){
            var total_ht = 0;
            var frais    = $("#frais").data('frais');
            var tva      = $("#tva").data('tva');
            var total    = 0;

            //calcul du total_ht
            $(".total-article").each(function(){
                var toti  = parseFloat($(this).attr('data-tot'));  //alert( toti );
                total_ht += toti;
            });
            total       = total_ht*(1+tva/100) + frais;
            total_tva   = total_ht*tva/100     + frais;

            $("#total_ht").text( thousandSeparator((total_ht).toFixed(2), ' ') + ' DA' );
            $(".total_ht").text( thousandSeparator((total_ht).toFixed(2), ' ') + ' DA' );
            $("#total").text( thousandSeparator((total).toFixed(2), ' ') + ' DA' );
            $(".order-total-price").text( thousandSeparator((total).toFixed(2), ' ') + ' DA' );

            //update total
              $.ajax({
                  url : "snippets/updateCartTotal.php",
                  type: "POST",
                  data : { "total" : total, "total_ht" : total_ht, "total_tva": total_tva },
                  success: function(data,status,xhr){
                        //updating on the page    order-total-price total
                        $("#total_panier").text( thousandSeparator((total).toFixed(2), ' ') + ' DA' );
                  }
              });
        }

        function add2Cart( codeart, qte ){
            //ajouter à la carte
            $.ajax({
                url : "snippets/add2Cart.php" ,
                type: "POST",
                data : { "codeart" : codeart, "qte" : qte, "wishlist" : "Oui" },
                success: function(data,status,xhr){
                        //remove from wishlist table
                        $("#"+codeart).remove();
                        //add to shopping cart table
                        $("#panier tbody").append( data );

                        //plus minus buttons
                        $("#" + codeart + " div.cart-plus-minus").prepend('<div class="dec qtybutton">-</div>');
                        $("#" + codeart + " div.cart-plus-minus").append('<div class="inc qtybutton">+</div>');
                        $("#" + codeart + " div.qtybutton").on("click", function() {
                            var $button = $(this);
                            var oldValue = $button.parent().find("input").val();
                            if ($button.text() == "+") {
                                var newVal = parseFloat(oldValue) + 1;
                            }else {
                                // Don't allow decrementing below zero
                                if (oldValue > 0) {
                                    var newVal = parseFloat(oldValue) - 1;
                                }else {
                                    newVal = 0;
                                }
                            }
                            $button.parent().find("input").val(newVal);
                        });
                        //some work
                        $("#" + codeart + " div.cart-plus-minus.f-left div.inc.qtybutton").attr("data-codeart", codeart);
                        $("#" + codeart + " div.cart-plus-minus.f-left div.dec.qtybutton").attr("data-codeart", codeart);

                        //qte inc button
                        $("#" + codeart + " div.inc.qtybutton").click(function(){
                            updateCart(codeart);
                        });
                        //qte dec button
                        $("#" + codeart + " div.inc.qtybutton").click(function(){
                            updateCart(codeart);
                        });

                        //recalculer le totla
                        caclTotal();
                }//end success fct
            });//end ajax
        }

        function updateCart(codeart){
              var qte = $("#prodQte_"+codeart).val();
              $.ajax({
                  url : "snippets/updateCart.php" ,
                  type: "POST",
                  data : { "codeart" : codeart, "qte" : qte },
                  success: function(data,status,xhr){
                      //updating totals per article
                      var t = qte * $("#" + codeart + " .prix-article" ).data("prix");
                      $("#" + codeart + " .total-article").attr("data-tot", t );
                      $("#" + codeart + " .total-article").text( thousandSeparator((t).toFixed(2), ' ') + ' DA' );
                      //recalcul du total
                      caclTotal();
                  }
              });
        }

        function QteChangePanier(codeart){
            updateCart(codeart);
        }

        function deleteFromCart(codeart){
            $.ajax({
                url : "snippets/deleteFromCart.php" ,
                type: "POST",
                data : { "codeart" : codeart },
                success: function(data,status,xhr){
                    //remove the line
                    $("#"+codeart).remove();
                    //scroll to beginning of table   id=shopping-cart
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    //recalcul du total
                    caclTotal();
                }
            });
        }

    </script>

</body>

</html>
