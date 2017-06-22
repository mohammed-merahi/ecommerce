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

<!-- Mirrored from foxythemes.net/preview/products/amaretti/ui-tabs-accordions.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:46:28 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Paramètres</title>
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

    <link rel="stylesheet" type="text/css" href="assets/lib/summernote/summernote.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/font-awesome/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/lib/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css">
</head>
  <body>
    <div class="am-wrapper">

      <?php include("themes/default/top-nav.php"); ?>

      <?php include("themes/default/left-sidebar.php"); ?>

      <div class="am-content">
        <div class="page-head">
          <h2>Paramètres</h2>
          <ol class="breadcrumb">
            <li><a href="#">Accueil</a></li>
            <li class="active">Paramètres</li>
          </ol>
        </div>

        <br>

        <div id="successAlert" role="alert" class="col-sm-6 alert alert-success alert-icon alert-dismissible hidden">
          <div class="icon"><span class="s7-check"></span></div>
          <div class="message">
            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><strong></strong> Les modifications ont été sauvegardé
          </div>
        </div>

        <div  id="errorAlert" role="alert" class="col-sm-6 alert alert-danger alert-icon alert-dismissible hidden">
          <div class="icon"><span class="s7-close-circle"></span></div>
          <div class="message">
            <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><strong></strong>Erreur lors de la sauvegarde des modifications
          </div>
        </div>


        <div class="main-content">
          <!--Accordions-->
          <div class="row">
            <div class="col-sm-12">

              <div id="accordion4" class="panel-group accordion accordion-semi">
                <!------------------------------------------------------------Theme et logo------------------------------------------------------------>
                <div class="panel panel-default">
                  <div class="panel-heading success">
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#ac4-1" class="collapsed"><i class="icon s7-angle-down"></i> Thème et logo</a></h4>
                  </div>
                  <div id="ac4-1" class="panel-collapse collapse">
                          <div class="panel-body">
                            <form role="form" class="col-sm-6">
                              <div class="form-group">
                                <label class="control-label">Titre du site</label>
                                <div class="">
                                  <input id="titre" type="text" class="form-control" value="<?php echo $xml->xpath( '/parametres/themes/titre' )[0]; ?>">
                                </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label">Thème (Administration)</label>
                                <div class="">
                                  <select id="theme" class="form-control">
                                    <option value="Default"  <?php if($xml->xpath( '/parametres/themes/theme' )[0] == "Default" )  echo "selected"; ?> >Par défaut</option>
                                    <option value="Twilight" <?php if($xml->xpath( '/parametres/themes/theme' )[0] == "Twilight" ) echo "selected"; ?> >Twilight</option>
                                    <option value="Google"   <?php if($xml->xpath( '/parametres/themes/theme' )[0] == "Google" )   echo "selected"; ?> >Google</option>
                                    <option value="Sunrise"  <?php if($xml->xpath( '/parametres/themes/theme' )[0] == "Sunrise" ) echo "selected"; ?> >Sunrise</option>
                                    <option value="Sunrise"  <?php if($xml->xpath( '/parametres/themes/theme' )[0] == "Cake" )    echo "selected"; ?> >Cake</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Logo</label>
                                <input id="logo" type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control" >
                                <div id="image-holder">
                                  <?php
                                      $logo = "assets/img/" . trim($xml->xpath( '/parametres/themes/logo' )[0]);
                                      if( $logo != "" ){
                                          echo "<img src='" . $logo . "'>";
                                      }
                                  ?>
                              </div>
                              </div>
                              <div class="form-group">
                                <label>Icône du site</label>
                                <input id="favicon" type="file" accept="image/*" placeholder="Password" class="form-control">
                                <div id="image-holder2">
                                  <?php
                                      $favicon = "assets/img/" . trim($xml->xpath( '/parametres/themes/favicon' )[0]);
                                      if( $favicon != "" ){
                                          echo "<img src='" . $favicon . "'>";
                                      }
                                  ?>
                              </div>
                              </div>
                              <div class="form-group hidden">
                                <label class="control-label">Modèle du tableau de bord</label>
                                <div class="">
                                  <select id="dashboard" class="form-control">
                                    <option value="1"  <?php if($xml->xpath( '/parametres/themes/dashboard' )[0] == "1")  echo "selected"; ?> >Modèle 1</option>
                                    <option value="2" <?php if($xml->xpath( '/parametres/themes/dashboard' )[0] == "2") echo "selected"; ?> >Modèle 2</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group hidden">
                                <label>Bannière de l'accueil</label>
                                <input id="banner1" type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control">
                                <div id="image-holder3">
                                  <?php
                                      $banner = "assets/img/" . trim($xml->xpath( '/parametres/themes/banner' )[0]);
                                      if( $banner != "" ){
                                          echo "<img src='" . $banner . "'>";
                                      }
                                  ?>
                              </div>
                              </div>
                              <div class="form-group hidden">
                                <label>Image de fond de la boutique</label>
                                <input id="banner5" type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control">
                                <div id="image-holder8">
                                  <?php
                                      $banner = "assets/img/" . trim($xml->xpath( '/parametres/themes/backgroundImage' )[0]);
                                      if( $banner != "" ){
                                          echo "<img width='50%' height='50%' src='" . $banner . "'>";
                                      }
                                  ?>
                              </div>
                              </div>
                              <div class="form-group">
                                <label class="control-label">Pharmacien</label>
                                <div class="">
                                  <select id="pharmacien" class="form-control">
                                    <option value="Oui"  <?php if($xml->xpath( '/parametres/themes/pharmacien' )[0] == "Oui")  echo "selected"; ?> >Oui</option>
                                    <option value="Non" <?php if($xml->xpath( '/parametres/themes/pharmacien' )[0] == "Non") echo "selected"; ?> >Non</option>
                                  </select>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Image de profile par défaut</label>
                                <input id="profile" type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control">
                                <div id="image-holder9">
                                  <?php
                                      $profile = "assets/img/" . trim($xml->xpath( '/parametres/themes/profile' )[0]);
                                      if( $profile != "" ){
                                          echo "<img width='50%' height='50%' src='" . $profile . "'>";
                                      }
                                  ?>
                              </div>
                              </div>
                              <div class="text-right">
                                <button type="submit" class="btn btn-space btn-primary" onclick="updateThemeLogo()"><span class="s7-check"></span> Appliquer</button>
                              </div>
                            </form>
                          </div>
                  </div>
                </div>
                  <!----------------------------------------------------------- options d'affichage -------------------------------------------------------->
                  <?php include("snippets/parametres_accordion.php"); ?>
                </div>
                  <!--Paiement-->
                <div class="panel panel-default">
                  <div class="panel-heading danger">
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#ac4-3" class="collapsed"><i class="icon s7-angle-down"></i> SEO</a></h4>
                  </div>
                  <div id="ac4-3" class="panel-collapse collapse">

                            <form role="form" class="col-sm-6">
                                  <div class="form-group">
                                    <label class="control-label">SEO est le processus d'améliorer la visibilité d'un site web dans les résultats de recherche d'un moteur de recherche</label>
                                    <div class="hidden">
                                      <input id="tit" type="text" class="form-control" value="<?php echo ''; ?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="control-label">Meta description: La description du site aide les moteurs de recherche à connaitre le type contenu sur le site. Il est préférable de ne pas dépasser 150 caractères.</label>
                                    <div class="">
                                      <textarea id="metaDescription" class="form-control" rows="5" cols="50"></textarea>
                                    </div>
                                  </div>
                                  <div>
                                    <label class="control-label">Mots clés (séparé par des ,)</label>
                                    <div class="">
                                      <textarea id="keywords" class="form-control" rows="5" cols="150"></textarea>
                                    </div>
                                  </div>

                                  <div class="text-right">
                                    <button type="submit" class="btn btn-space btn-primary" onclick="updateSEO()"><span class="s7-check"></span> Appliquer</button>
                                  </div>
                            </form>

                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <?php include("themes/default/right-sidebar.php"); ?>

    </div>

    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/lib/summernote/summernote.min.js" type="text/javascript"></script>
    <script src="assets/lib/summernote/summernote-ext-amaretti.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
          	//initialize the javascript
          	App.init();
          	App.textEditors();
            App.bootstrapSpinner();

            //prevent forms from submitting
            $("form").submit(function(e){
                e.preventDefault();
            });

            //preview logo
                $("#logo").on('change', function () {
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview logo
                $("#favicon").on('change', function (){
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder2");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview banner
                $("#banner1").on('change', function (){
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder3");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "70%",
                                "height": "auto"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview banner boutique
                $("#banner2").on('change', function (){
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder4");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "70%",
                                "height": "auto"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview banner about
                $("#banner3").on('change', function (){
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder5");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "70%",
                                "height": "auto"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview image boutique
                $("#imgAbout").on('change', function () {
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder6");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "70%",
                                "height": "auto"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview banner contact
                $("#banner4").on('change', function () {
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder7");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "70%",
                                "height": "auto"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview backgroundImage
                $("#banner5").on('change', function () {
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder8");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "50%",
                                "height": "50%"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
            //preview avatar
                $("#profile").on('change', function () {
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder9");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "50%",
                                "height": "50%"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });
                //preview avatar
                $("#slider").on('change', function () {
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder10");
                        image_holder.empty();

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $("<img />", {
                                "src": e.target.result,
                                "class": "thumb-image",
                                "width": "70%",
                                "height": "auto"
                            }).appendTo(image_holder);

                        }
                        image_holder.show();
                        reader.readAsDataURL($(this)[0].files[0]);
                    } else {
                        alert("This browser does not support FileReader.");
                    }
                });

      });

      function updateSEO(){
            $.ajax({
                    url : 'snippets/updateSEO.php' ,
                    type: "POST",
                    data : {
                              "metaDescription"  : $("#metaDescription").val() ,
                              "keywords"         : $("#keywords").val()
                          },
                    success: function(data,status,xhr){
                        $("html, body").animate({ scrollTop: 0 }, "slow");
                        $("#successAlert").removeClass("hidden");
                    }
            });
      }

      function updateThemeLogo(){
          $.ajax({
                  url : 'snippets/updateThemeLogo.php' ,
                  type: "POST",
                  data : {  "titre"       : $("#titre").val() ,
                            "theme"       : $("#theme option:selected").text() ,
                            "logo"        : $("#logo").val().split("\\")[ $("#logo").val().split("\\").length - 1 ] ,
                            "ext1"        : $("#logo").val().split(".")[1] ,
                            "data1"       : $("#image-holder img").attr("src") ,
                            "favicon"     : $("#favicon").val().split("\\")[ $("#favicon").val().split("\\").length - 1 ] ,
                            "ext2"        : $("#favicon").val().split(".")[1] ,
                            "data2"       : $("#image-holder2 img").attr("src") ,
                            "banner"      : $("#banner1").val().split("\\")[ $("#banner1").val().split("\\").length - 1 ] ,
                            "ext3"        : $("#banner1").val().split(".")[1] ,
                            "data3"       : $("#image-holder3 img").attr("src") ,
                            "bgImage"     : $("#banner5").val().split("\\")[ $("#banner5").val().split("\\").length - 1 ] ,
                            "ext4"        : $("#banner5").val().split(".")[1] ,
                            "data4"       : $("#image-holder8 img").attr("src"),
                            "dashbrd"     : $("#dashboard option:selected").text(),
                            "pharmacien"  : $("#pharmacien option:selected").text(),
                            "avatar"      : $("#profile").val().split("\\")[ $("#profile").val().split("\\").length - 1 ] ,
                            "data5"       : $("#image-holder9 img").attr("src")
                        },
                  success: function(data,status,xhr){
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      $("#successAlert").removeClass("hidden");   successAlert
                  }
          });
      }

      function updateBoutique(){
        $.ajax({
                url : 'snippets/updateBoutique.php' ,
                type: "POST",
                data : {
                          "banner"           : $("#banner2").val().split("\\")[ $("#banner2").val().split("\\").length - 1 ] ,
                          "data"             : $("#image-holder4 img").attr("src"),
                          "grille"           : $("#grille").prop("checked") ,
                          "liste"            : $("#liste").prop("checked") ,
                          "tableauAvecImg"   : $("#tableauAvecImg").prop("checked") ,
                          "tableauSansImg"   : $("#tableauSansImg").prop("checked") ,
                          "produitsParPage"  : $("#produitsParPage").val() ,
                          "produitsNonDispo" : $("#produitsNonDispo").prop("checked") ,
                          "tva"              : $("#tva").val() ,
                          "frais"            : $("#frais").val()
                      },
                success: function(data,status,xhr){
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#successAlert").removeClass("hidden");
                }
        });
      }

      function updateAbout(){   alert( $("#description2").val() );
          $.ajax({
                  url : 'snippets/updateAbout.php' ,
                  type: "POST",
                  data : {
                            "banner"        : $("#banner3").val().split("\\")[ $("#banner3").val().split("\\").length - 1 ] ,
                            "data1"         : $("#image-holder5 img").attr("src"),
                            "societe"       : $("#societe").val(),
                            "slogan"        : $("#slogan").val() ,
                            "image"         : $("#imgAbout").val().split("\\")[ $("#imgAbout").val().split("\\").length - 1 ] ,
                            "data2"         : $("#image-holder6 img").attr("src"),
                            "description"   : $(".note-editable.panel-body").html(),
                            "description2"  : $("#description2").val()
                        },
                  success: function(data,status,xhr){
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      $("#successAlert").removeClass("hidden");
                  }
          });
      }

      function updateContact(){
          $.ajax({
                  url : 'snippets/updateContact.php' ,
                  type: "POST",
                  data : {
                            "banner"        : $("#banner4").val().split("\\")[ $("#banner4").val().split("\\").length - 1 ] ,
                            "data1"         : $("#image-holder7 img").attr("src") ,
                            "adresse"       : $("#adresse").val(),
                            "ville"         : $("#ville").val(),
                            "postal"        : $("#postal").val(),
                            "fixe"          : $("#fixe").val() ,
                            "mobile"        : $("#mobile").val() ,
                            "email"         : $("#email").val(),
                            "email2"        : $("#email2").val(),
                            "latitude"      : $("#latitude").val(),
                            "longitude"     : $("#longitude").val(),
                            "facebook"      : $("#facebook").val(),
                            "googleplus"    : $("#googleplus").val(),
                            "twitter"       : $("#twitter").val()
                        },
                  success: function(data,status,xhr){
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      $("#successAlert").removeClass("hidden");
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

    <script>

    </script>

  </body>

<!-- Mirrored from foxythemes.net/preview/products/amaretti/ui-tabs-accordions.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:46:29 GMT -->
</html>
