<?php
    session_start();

    if( !isset($_SESSION['typeCompte']) ){
        header("Location: login.php");
    }

    include("config/consts.php");
    include("db.php");
    //fichier de config
    $xml      = simplexml_load_file("config/parametres.xml");
    $theme    = $xml->xpath( '/parametres/themes/theme' )[0];
    $favicon  = $xml->xpath( '/parametres/themes/favicon' )[0];
?>
<!DOCTYPE html>
<html lang="en">
  
<!-- Mirrored from foxythemes.net/preview/products/amaretti/pages-404.php?theme=sunrise by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:48:07 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Amaretti</title>
    <link rel="stylesheet" type="text/css" href="assets/lib/stroke-7/style.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/jquery.nanoscroller/css/nanoscroller.css"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->    
  </head>
  <body class="am-splash-screen">
    <div class="am-wrapper am-error am-error-404">
      <div class="am-content">
        <div class="main-content">
          <div class="error-container">
            <div class="error-image"></div>
            <div class="error-number">404</div>
            <p class="error-description">The page you are looking for might have been removed.</p>
            <div class="error-goback-text">Would you like to go <a href="#">home</a>?</div>
            <div class="footer">&copy; 2015 <a href="#">Your Company</a></div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/lib/theme-switcher/theme-switcher.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      });
      
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
      	App.livePreview();
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
    <div class="ft_theme_switcher ocult">
      <div class="toggle"><i class="icon s7-settings"></i></div>
      <div class="desc">
        <h3>Theme Switcher</h3>
        <p>Select a color scheme. You can create your own color theme with less files.</p>
      </div>
      <div class="style_list">
        <div class="style">
          <div class="colors">
            <div style="background: #EF6262;" class="color"></div>
            <div style="background: #95d9f0;" class="color"></div>
            <div style="background: #ffdc7a;" class="color"></div>
            <div style="background: #7a98bf;" class="color"></div>
            <div style="background: #cccccc;" class="color"></div>
            <div class="name"> Default</div>
          </div><a href="pages-404d976.html?theme=default"></a>
        </div>
        <div class="style">
          <div class="colors">
            <div style="background: #7F64B5;" class="color"></div>
            <div style="background: #65CEEC;" class="color"></div>
            <div style="background: #ffdc7a;" class="color"></div>
            <div style="background: #45D8C2;" class="color"></div>
            <div style="background: #e0e0e0;" class="color"></div>
            <div class="name"> Twilight</div>
          </div><a href="pages-404056d.html?theme=twilight"></a>
        </div>
        <div class="style">
          <div class="colors">
            <div style="background: #4e91ff;" class="color"></div>
            <div style="background: #f55244;" class="color"></div>
            <div style="background: #FBBF22;" class="color"></div>
            <div style="background: #49AD70;" class="color"></div>
            <div style="background: #DFDFDF;" class="color"></div>
            <div class="name"> Google</div>
          </div><a href="pages-404421b.html?theme=google"></a>
        </div>
        <div class="style">
          <div class="colors">
            <div style="background: #f7c954;" class="color"></div>
            <div style="background: #88ca92;" class="color"></div>
            <div style="background: #7fcff5;" class="color"></div>
            <div style="background: #8B8CCC;" class="color"></div>
            <div style="background: #CCCCCC;" class="color"></div>
            <div class="name"> Sunrise</div>
          </div><a href="pages-404a494.html?theme=sunrise"></a>
        </div>
        <div class="style">
          <div class="colors">
            <div style="background: #6bc3b0;" class="color"></div>
            <div style="background: #FFE088;" class="color"></div>
            <div style="background: #bda5d7;" class="color"></div>
            <div style="background: #FF7FA0;" class="color"></div>
            <div style="background: #dfdfdf;" class="color"></div>
            <div class="name">Cake</div>
          </div><a href="pages-404e2f8.html?theme=cake"></a>
        </div>
      </div>
    </div>
  </body>

<!-- Mirrored from foxythemes.net/preview/products/amaretti/pages-404.php?theme=sunrise by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:48:07 GMT -->
</html>