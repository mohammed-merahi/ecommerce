<?php
    session_start();

    if( !isset($_SESSION['typeCompte']) ){
        header("Location: login.php");
    }

    include("config/consts.php");
    //fichier de config
    $xml      = simplexml_load_file("config/parametres.xml");
    $theme    = $xml->xpath( '/parametres/themes/theme' )[0];
    $favicon  = $xml->xpath( '/parametres/themes/favicon' )[0];
    //$avatar  = $xml->xpath( '/parametres/themes/profile' )[0];

    if( isset($_SESSION['raison']) ){
        $raison = $_SESSION['raison'];
    }else{
        $raison = "Inconnu";
    }

?>
<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from foxythemes.net/preview/products/amaretti/pages-profile.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:47:10 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Mon profile</title>
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
  <body>
    <div class="am-wrapper">

    <?php
        include('db.php');
        $query = "SELECT codeclient, mail, raison, telephone, mobile, adresse, ville, cp, departement, pays, photo
                  FROM clients
                  LEFT JOIN myphotos ON CONCAT('US', clients.codeclient ) = myphotos.code
                  WHERE codeclient='" . $_SESSION['codeclient'] . "'";
        //echo $query;
        $res = mysql_query( $query );
        while( $i = mysql_fetch_assoc($res) ){
            $avatar       = $i['photo'];
            $codeclient   = $i['codeclient'];
            $mail         = $i['mail'];
            $raison       = $i['raison'];
            $tel          = $i['telephone'];
            $mobile       = $i['mobile'];
            $adresse      = $i['adresse'];
            $ville        = $i['ville'];
            $cp           = $i['cp'];
            $dep          = $i['departement'];
            $pays         = $i['pays'];
        }

        if( $avatar == "" )
          $avatar = "assets/img/" . trim($xml->xpath( '/parametres/themes/profile' )[0]);

    ?>

      <?php include("themes/default/top-nav.php"); ?>

      <?php include("themes/default/left-sidebar.php"); ?>


      <div class="am-content">

        <div class="main-content">
          <div class="user-profile">
            <div class="user-display">
              <div class="photo"><img src="assets/img/profile.jpg"></div>
              <div class="bottom">
                <div class="user-avatar"><span class="status"></span><img src="<?php echo $avatar; ?>"></div>
                <div class="user-info">
                  <h4><?php echo $raison; ?></h4><span class="hidden">I am a web developer and designer based in Montreal - Canada, I like read books, good music and nature.</span>
                </div>
              </div>
            </div>


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



            <div class="row">
              <div class="col-sm-12">
                <div id="accordion4" class="panel-group accordion accordion-semi">
                  <!------------------------------------------------------------Theme et logo------------------------------------------------------------>
                  <div class="panel panel-default">
                    <div class="panel-heading success">
                      <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#ac4-1" class="<?php if($_GET['p']!='1') echo 'collapsed'; ?>"
                          aria-expanded="<?php if($_GET['p']!='1') echo 'false';else echo 'true'; ?>"><i class="icon s7-angle-down"></i> Détails du profile</a></h4>
                    </div>
                    <div id="ac4-1" class="panel-collapse collapse <?php if($_GET['p']=='1') echo 'in'; ?>">

                            <div class="panel-body">
                              <form role="form" class="col-sm-6">
                                <div class="form-group">
                                  <label class="control-label">Code client</label>
                                  <div class="">
                                    <input id="codeclient" type="text" class="form-control" value="<?php echo $codeclient; ?>" readonly>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Email</label>
                                  <div class="">
                                    <input id="mail" type="text" class="form-control" value="<?php echo $mail; ?>">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Raison</label>
                                  <div class="">
                                    <input id="raison" type="text" class="form-control" value="<?php echo $raison; ?>">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Ville</label>
                                  <div class="">
                                    <input id="ville" type="text" class="form-control" value="<?php echo $ville; ?>">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Téléphone</label>
                                  <div class="">
                                    <input id="tel" type="text" class="form-control" value="<?php echo $tel; ?>">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="control-label">Mobile</label>
                                  <div class="">
                                    <input id="mobile" type="text" class="form-control" value="<?php echo $mobile; ?>">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label>Avatar</label>
                                  <input id="avatar" type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control" >
                                  <div id="image-holder">
                                    <?php
                                        echo "<img width='50%' height='50%' src='" . $avatar . "'>";
                                    ?>
                                </div>
                                </div>
                                <div class="form-group hidden">
                                  <label class="control-label">A propos de moi</label>
                                  <div class="">
                                    <input id="about_me" type="text" class="form-control" value="">
                                  </div>
                                </div>
                                <div class="form-group hidden">
                                  <label>Photo de couverture (1500x420)</label>
                                  <input id="logo" type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control" >
                                  <div id="image-holder">
                                    <?php
                                        $logo = "assets/img/" . trim($xml->xpath( '/parametres/themes/cover' )[0]);
                                        if( $logo != "" ){
                                            echo "<img width='75%' height='75%' src='" . $logo . "'>";
                                        }
                                    ?>
                                </div>
                                </div>

                                <div class="text-right">
                                  <button type="submit" class="btn btn-space btn-primary" onclick="updateMyProfile()"><span class="s7-check"></span> Appliquer</button>
                                </div>
                              </form>
                            </div>


                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading warning">
                      <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#ac4-2" class="<?php if($_GET['p']!='2') echo 'collapsed'; ?>"
                          aria-expanded="<?php if($_GET['p']!='2') echo 'false';else echo 'true'; ?>"><i class="icon s7-angle-down"></i> Changer mon mot de passe</a></h4>
                    </div>
                    <div id="ac4-2" class="panel-collapse collapse <?php if($_GET['p']=='2') echo 'in'; ?>">


                      <div class="panel-body">
                        <form role="form" class="col-sm-6" onsubmit="function(e){ e.preventDefault();return false; }">
                          <div class="form-group hidden">
                            <label class="control-label">Email</label>
                            <div class="">
                              <input id="mail_pass" type="text" class="form-control" value="<?php echo $mail; ?>" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Ancien mot de passe</label>
                            <div class="">
                              <input id="a_pass" type="password" class="form-control" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Nouveau mot de passe mot de passe</label>
                            <div class="">
                              <input id="n_pass" type="password" class="form-control" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label">Confirmer le nouveau mot de passe</label>
                            <div class="">
                              <input id="cn_pass" type="password" class="form-control" value="">
                            </div>
                          </div>


                          <div class="text-right">
                            <button type="submit" class="btn btn-space btn-primary" onclick="updateMyPassword()"><span class="s7-check"></span> Appliquer</button>
                          </div>
                        </form>
                      </div>



                    </div>
                  </div>
                  <div class="panel panel-default hidden">
                    <div class="panel-heading danger">
                      <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#ac4-3" class="collapsed"><i class="icon s7-angle-down"></i> Paiement</a></h4>
                    </div>
                    <div id="ac4-3" class="panel-collapse collapse">

                    </div>
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
    <script src="assets/lib/jquery-flot/jquery.flot.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/jquery.flot.pie.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/jquery.flot.resize.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/plugins/jquery.flot.orderBars.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-flot/plugins/curvedLines.js" type="text/javascript"></script>
    <script src="assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
            //prevent forms from submitting
            $("form").submit(function(e){
                e.preventDefault();
            });

            //preview avatar
            $("#avatar").on('change', function () {
                    if (typeof (FileReader) != "undefined") {

                        var image_holder = $("#image-holder");
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

          	//initialize the javascript
          	App.init();
          	App.pageProfile();


      });

      function updateMyProfile(){
              $.ajax({
                      url  : 'snippets/updateProfile.php',
                      type : "POST",
                      data : {
                                "codeclient" : $("#codeclient").val(),
                                "mail"       : $("#mail").val() ,
                                "raison"     : $("#raison").val() ,
                                "ville"      : $("#ville").val() ,
                                "tel"        : $("#tel").val() ,
                                "mobile"     : $("#mobile").val() ,
                                "avatar"     : $("#image-holder img").attr('src'),
                                "ext"        : $("#avatar").val().split(".")[ $("#avatar").val().split(".").length - 1]
                            },
                      success: function(data,status,xhr){
                          $("html, body").animate({ scrollTop: 0 }, "slow");
                          $("#successAlert").removeClass("hidden");
                          $("#errorAlert").addClass("hidden");
                          $("#errorAlert span#success_msg").text("Les modifications ont été enregistré");
                      }
              });
        }

      function updateMyPassword(){

            if( $("#a_pass").val() == "" ){
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#successAlert").addClass("hidden");
                $("#errorAlert").removeClass("hidden");
                $("#errorAlert span#error_msg").text("L'ancien mot de passe ne peut pas être vide");
                return;
            }else if( $("#n_pass").val() == "" ){
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#successAlert").addClass("hidden");
                $("#errorAlert").removeClass("hidden");
                $("#errorAlert span#error_msg").text("Le nouveau mot de passe ne peut pas être vide");
                return;
            }else if( $("#n_pass").val() != $("#cn_pass").val() ){
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#successAlert").addClass("hidden");
                $("#errorAlert").removeClass("hidden");
                $("#errorAlert span#error_msg").text("Merci de bien confirmer votre nouveau mot de passe");
                return;
            }else if( $("#n_pass").val().length < 6 ){
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#successAlert").addClass("hidden");
                $("#errorAlert").removeClass("hidden");
                $("#errorAlert span#error_msg").text("le mot de passe doit avoir au moins 6 caractères");
                return;
            }else if( (!$("#n_pass").val().match(/[a-z]/i)) || (!$("#n_pass").val().match(/[0-9]/i)) ){
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#successAlert").addClass("hidden");
                $("#errorAlert").removeClass("hidden");
                $("#errorAlert span#error_msg").text("le mot de passe doit être alphanumérique");
                return;
            }

            $.ajax({
                    url  : 'snippets/updatePassword.php',
                    type : "POST",
                    data : {
                              "mail"     : $("#mail_pass").val() ,
                              "a_pass"   : $("#a_pass").val() ,
                              "n_pass"   : $("#n_pass").val() ,
                              "cn_pass"  : $("#cn_pass").val()
                          },
                    success: function(data,status,xhr){
                        if( data == "0" ){
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                            $("#successAlert").removeClass("hidden");
                            $("#errorAlert").addClass("hidden");
                            $("#errorAlert span#success_msg").text("Votre mot de passe a été modifié");
                        }else {
                          $("html, body").animate({ scrollTop: 0 }, "slow");
                          $("#successAlert").addClass("hidden");
                          $("#errorAlert").removeClass("hidden");
                          $("#errorAlert span#error_msg").text("L'ancien mot de passe est incorrect");
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

<!-- Mirrored from foxythemes.net/preview/products/amaretti/pages-profile.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:47:12 GMT -->
</html>
