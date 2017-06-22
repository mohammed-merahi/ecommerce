<?php
    session_start();
    include("db.php");
    //fichier de config
    $xml      = simplexml_load_file("config/parametres.xml");
    $theme    = $xml->xpath( '/parametres/themes/theme' )[0];
    $favicon  = $xml->xpath( '/parametres/themes/favicon' )[0];
    $logo     = $xml->xpath( '/parametres/themes/logo' )[0];
?>
<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from foxythemes.net/preview/products/amaretti/pages-login.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:47:04 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Connexion</title>
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

</head>
  <body class="am-splash-screen">
    <div class="am-wrapper am-login">
      <div class="am-content">
        <div class="main-content">
          <div class="login-container">
            <div class="panel panel-default">



            <div id="successAlert" role="alert" class="col-sm-6 alert alert-success alert-icon alert-dismissible hidden">
              <div class="icon"><span class="s7-check"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span id="success_msg"> Les modifications ont été sauvegardé</span>
              </div>
            </div>

            <div  id="errorAlert" role="alert" class="col-sm-6 alert alert-danger alert-icon alert-dismissible hidden">
              <div class="icon"><span class="s7-close-circle"></span></div>
              <div class="message">
                <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span id="error_msg">Erreur lors de la sauvegarde des modifications</span>
              </div>
            </div>



              <div class="panel-heading"><a href="pe/shop.php"><img src="<?php echo "assets/img/" . $logo; ?>" alt="logo" width="50%" height="50%" class="logo-img"></a><span>Merci d'entrer les informations de votre compte</span></div>
              <div class="panel-body">

                <form action="snippets/loginscript.php" method="GET" class="form-horizontal">
                  <div class="login-form">
                    <div class="form-group">
                      <div class="input-group"><span class="input-group-addon"><i class="icon s7-user"></i></span>
                        <input id="username" name="username" type="text" placeholder="Nom d'utilisateur" autocomplete="off" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group"><span class="input-group-addon"><i class="icon s7-lock"></i></span>
                        <input id="password" name="password" type="password" placeholder="Mot de passe" class="form-control">
                      </div>
                    </div>
                    <div class="form-group login-submit">
                      <button data-dismiss="modal" type="submit" class="btn btn-primary btn-lg" onclick="login()">Se connecter</button>
                    </div>
                    <div class="form-group footer row">
                      <div class="col-xs-6"><a href="#">Mot de passe oublié?</a></div>
                      <div class="col-xs-6 remember">
                        <label for="remember">Se souvenir de moi</label>
                        <div class="am-checkbox">
                          <input type="checkbox" id="remember">
                          <label for="remember"></label>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();

        //prevent forms from submitting
        $("form").submit(function(e){
            e.preventDefault();
        });

      });

      function login(){
            $.ajax({
                    url : 'snippets/loginscript.php' ,
                    type: "POST",
                    data : {
                              "username"       : $("#username").val(),
                              "password"       : $("#password").val() ,
                              "remember"       : $("#remember").prop('checked')
                          },
                    success: function(data,status,xhr){
                        if( data == "0" ){//valid user
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $("#errorAlert").addClass("hidden");
                            $("#successAlert").removeClass("hidden");
                            $("#successAlert span#success_msg").text("Vous êtes connecté(e)");
                            document.location.href="index.php";
                        }else if( data == "-1" ){//invalied user
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $("#successAlert").addClass("hidden");
                            $("#errorAlert").removeClass("hidden");
                            $("#errorAlert span#error_msg").text("Nom d'utilisateur ou mot de passe incorrect");
                        }
                    }
            });
      }

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

  </body>

<!-- Mirrored from foxythemes.net/preview/products/amaretti/pages-login.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:47:05 GMT -->
</html>
