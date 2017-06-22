<?php
    session_start();

    if( !isset($_SESSION['typeCompte']) ){
        header("Location: login.php");
    }else if( $_SESSION['typeCompte'] == 'Client' ){
        header("Location: ccs.php");
    }

    include("config/consts.php");
    //fichier de config
    $xml      = simplexml_load_file("config/parametres.xml");
    $theme    = $xml->xpath( '/parametres/themes/theme' )[0];
    $favicon  = $xml->xpath( '/parametres/themes/favicon' )[0];
?>
<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from foxythemes.net/preview/products/amaretti/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:44:49 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Tableau de bord</title>
    <link rel="icon" href="<?php echo 'assets/img/' . $favicon; ?>" />
    <link rel="stylesheet" type="text/css" href="assets/lib/stroke-7/style.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/jquery.nanoscroller/css/nanoscroller.css"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
        if( $theme == "Twilight" )
            echo '<link type="text/css" href="assets/css/themes/theme-twilight.css" rel="stylesheet">';
        else if( $theme == "Google" )
            echo '<link type="text/css" href="assets/css/themes/theme-google.css" rel="stylesheet">';
        else if( $theme == "Sunrise" )
            echo '<link type="text/css" href="assets/css/themes/theme-sunrise.css" rel="stylesheet">';
        else if( $theme == "Cake" )
            echo '<link type="text/css" href="assets/css/themes/theme-cake.css" rel="stylesheet">';
        else
            echo '<link type="text/css" href="assets/css/style.css" rel="stylesheet">';
    ?>

    <link rel="stylesheet" type="text/css" href="assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.css"/>
</head>
  <body>
    <div class="am-wrapper">

      <?php include("themes/default/top-nav.php"); ?>

      <?php include("themes/default/left-sidebar.php"); ?>

      <div class="am-content">
        <div class="main-content">
          <!--+general-chart("classes", "title", "height", "id", "counter value", "counter desc", tools enabled (use true or false))-->
          <div class="row">
            <?php include("themes/default/stats-row1.php"); ?>
          </div>

          <div class="row">
            <?php include("themes/default/stats-row2.php"); ?>
          </div>

          <div class="row hidden">
            <?php include("themes/default/stats-row3.php"); ?>
          </div>

        </div>
      </div>

      <?php include("themes/default/right-sidebar.php"); ?>

    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>

    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="assets/lib/jquery-flot/jquery.flot.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
    
    <script src="assets/lib/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    
    <script src="assets/lib/jquery.vectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-uk-mill-en.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-fr-merc-en.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-us-il-chicago-mill-en.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-au-mill-en.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-in-mill-en.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-map.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.vectormap/maps/jquery-jvectormap-ca-lcc-en.js" type="text/javascript"></script>

    <script src="assets/lib/countup/countUp.min.js" type="text/javascript"></script>
    <script src="assets/lib/chartjs/Chart.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      	App.dashboard();

      });
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
      	App.livePreview();

        $('.last_10_cmds').height("height", $('.top_clients').height() + 'px'  );
      });

    </script>
    <script type="text/javascript">
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','../../../../www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-68396117-1', 'auto');
      ga('send', 'pageview');


    </script>

  </body>

<!-- Mirrored from foxythemes.net/preview/products/amaretti/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:45:20 GMT -->
</html>
