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
    $bg          = $xml->xpath( '/parametres/themes/backgroundImage' )[0];
    $banner      = $xml->xpath( '/parametres/affichage/contact/banner' )[0];
    $adresse     = $xml->xpath( '/parametres/affichage/contact/adresse' )[0];
    $ville       = $xml->xpath( '/parametres/affichage/contact/ville' )[0];
    $postal      = $xml->xpath( '/parametres/affichage/contact/postal' )[0];
    $fixe        = $xml->xpath( '/parametres/affichage/contact/fixe' )[0];
    $mobile      = $xml->xpath( '/parametres/affichage/contact/mobile' )[0];
    $email       = $xml->xpath( '/parametres/affichage/contact/email' )[0];
    $email2      = $xml->xpath( '/parametres/affichage/contact/email2' )[0];
    $facebook    = $xml->xpath( '/parametres/affichage/contact/facebook' )[0];
    $googleplus  = $xml->xpath( '/parametres/affichage/contact/googleplus' )[0];
    $twitter     = $xml->xpath( '/parametres/affichage/contact/twitter' )[0];
    $latitude    = $xml->xpath( '/parametres/affichage/contact/googleMaps/latitude' )[0];
    $longitude   = $xml->xpath( '/parametres/affichage/contact/googleMaps/longitude' )[0];
    //SEO
    $metaDescription  = trim($xml->xpath( '/parametres/seo/metaDescription' )[0]);
    $keywords         = trim($xml->xpath( '/parametres/seo/keywords' )[0]);

?>
<!doctype html>
<html class="no-js" lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Contact</title>
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

    <style>
        body{
            background-image: url('<?php echo "../assets/img/" . $bg; ?>');
        }
    </style>
</head>

<body class="">
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
                                <p class="mb-0 roboto"><?php echo $mobile ?></p>
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

            <!-- ADDRESS SECTION START -->
            <div class="address-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="contact-address box-shadow">
                                <i class="zmdi zmdi-pin"></i>
                                <h6><?php echo $adresse; ?></h6>
                                <h6><?php echo $ville . ", " . $postal; ?></h6>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="contact-address box-shadow">
                                <i class="zmdi zmdi-phone"></i>
                                <h6><?php echo $fixe; ?></h6>
                                <h6><?php echo $mobile; ?></h6>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="contact-address box-shadow">
                                <i class="zmdi zmdi-email"></i>
                                <h6><?php echo $email; ?></h6>
                                <h6><?php echo $email2; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ADDRESS SECTION END -->

            <!-- GOOGLE MAP SECTION START -->
            <div class="google-map-section">
                <div class="container-fluid">
                    <div class="google-map plr-185">
                        <div id="googleMa" class="col-sm-12">
<iframe class="col-sm-12" height="600" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $latitude . "," . $longitude; ?>&hl=fr;z=14&amp;output=embed"></iframe>
    <br />
<small><a href="https://maps.google.com/maps?q=<?php echo $latitude . "," . $longitude; ?>&hl=es;z=14&amp;output=embed" style="color:#0000FF;text-align:left" target="_blank">Agrandir</a></small>

                        </div>
                    </div>
                </div>
            </div>
            <!-- GOOGLE MAP SECTION END -->

            <!-- MESSAGE BOX SECTION START -->
            <div class="message-box-section mt--50 mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="message-box box-shadow white-bg">
                                <form id="contact-form" action="mail.php" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="blog-section-title border-left mb-30">Contactez-nous</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="name" placeholder="Votre nom ici ...">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="email" placeholder="Votre email ici ...">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="subject" placeholder="Objet">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="phone" placeholder="Votre téléphone ici ...">
                                        </div>
                                        <div class="col-md-12">
                                            <textarea class="custom-textarea" name="message" placeholder="Message"></textarea>
                                            <button class="submit-btn-1 mt-30 btn-hover-1" type="submit" onclick="sendMail()">Envoyer</button>
                                        </div>
                                    </div>
                                </form>
                                <p class="form-messege"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MESSAGE BOX SECTION END -->
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
    <!-- Google Map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuU_0_uLMnFM-2oWod_fzC0atPZj7dHlU"></script>
    <script src="js/map.js"></script>
    <script type="text/javascript" src="js/gmaps.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="js/plugins.js"></script>
    <!-- ajax-mail js -->
    <script src="js/ajax-mail.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function (){
            window.onload = loadScript;
            initialize();
            
           //prevent forms from submitting
           $("form").submit(function(e){
                e.preventDefault();
           });

        });

                        
        function initialize() {
            var myLatlng = new google.maps.LatLng(36.252372,6.569417 );
            var myOptions = {
                zoom: 8,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(document.getElementById("googleMap"), myOptions);//googleMap
        }

        function loadScript() {
            var script = document.createElement("script");
                script.type = "text/javascript";
                script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
                document.body.appendChild(script);
        }



    </script>

</body>

</html>
