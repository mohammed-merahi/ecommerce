<?php
    session_start();
    include("db.php");

    $xml         = simplexml_load_file("../config/parametres.xml");
    $favicon     = $xml->xpath( '/parametres/themes/favicon' )[0];
    $banner      = $xml->xpath( '/parametres/affichage/about/banner' )[0];
    $societe     = $xml->xpath( '/parametres/affichage/about/societe' )[0];
    $slogan      = $xml->xpath( '/parametres/affichage/about/slogan' )[0];
    $image       = $xml->xpath( '/parametres/affichage/about/image' )[0];
    $description = $xml->xpath( '/parametres/affichage/about/description' )[0];
    $tel         = $xml->xpath( '/parametres/affichage/contact/mobile' )[0];
    $facebook    = $xml->xpath( '/parametres/affichage/contact/facebook' )[0];
    $googleplus  = $xml->xpath( '/parametres/affichage/contact/googleplus' )[0];
    $twitter     = $xml->xpath( '/parametres/affichage/contact/twitter' )[0];
    //SEO
    $metaDescription  = trim($xml->xpath( '/parametres/seo/metaDescription' )[0]);
    $keywords         = trim($xml->xpath( '/parametres/seo/keywords' )[0]);

?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>A propos</title>
    <link rel="icon" href="<?php echo '../assets/img/' . $favicon; ?>" />
    <meta name="description" content="<?php echo $metaDescription; ?>">
    <meta name="keywords" content="<?php echo $keywords; ?>"></meta>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/icon/favicon.png">

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
            <?php include("include/mobile_menu.php"); ?>
        <!-- END MOBILE MENU AREA -->

        <!-- BREADCRUMBS SETCTION START -->
        <div class="breadcrumbs-section plr-200 mb-80" style="">
            <div class="breadcrumbs" style="background: #f6f6f6 url(<?php echo "../assets/img/" . $banner; ?>) no-repeat scroll center center;">
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

            <!-- ABOUT SECTION START -->
            <div class="about-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-left ">
                                <h2 class="uppercase"><?php echo $societe; ?></h2>
                                <h6 class="mb-40"><?php echo $slogan; ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="about-photo p-20 bg-img-1">
                                <img src="<?php echo "../assets/img/" . $image; ?>" alt="">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="about-description mt-50">
                                <?php echo $description; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ABOUT SECTION END -->

            <!-- TEAM SECTION START -->
            <div class="team-section mb-50 hidden">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-left ">
                                <h2 class="uppercase">team member</h2>
                                <h6 class="mb-40">There are many variations of passages of brands available,</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="active-team-member">
                            <!-- team-member start -->
                            <div class="col-md-12">
                                <div class="team-member box-shadow bg-shape">
                                    <div class="team-member-photo">
                                        <img src="img/team/2.png" alt="">
                                    </div>
                                    <div class="team-member-info pt-20">
                                        <h5 class="member-name"><a href="#">Nancy holland</a></h5>
                                        <p class="member-position">Chairman</p>
                                        <p class="mb-20">There are many variations of passage of Lorem Ipsum available, but the in majority have suffered.</p>
                                        <ul class="footer-social">
                                            <li>
                                                <a class="facebook" href="" title="Facebook"><i class="zmdi zmdi-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a class="google-plus" href="" title="Google Plus"><i class="zmdi zmdi-google-plus"></i></a>
                                            </li>
                                            <li>
                                                <a class="twitter" href="" title="Twitter"><i class="zmdi zmdi-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a class="rss" href="" title="RSS"><i class="zmdi zmdi-rss"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- team-member end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- TEAM SECTION END -->
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

</body>

</html>
