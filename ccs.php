<?php
    session_start();

    if( !isset($_SESSION['typeCompte']) ){
        header("Location: login.php");
    }else if( $_SESSION["typeCompte"] == "Admin" )
          $title = "Commandes";
    else
          $title = "Mes commandes";

    include("config/consts.php");
    //fichier de config
    $xml      = simplexml_load_file("config/parametres.xml");
    $theme    = $xml->xpath( '/parametres/themes/theme' )[0];
    $favicon  = $xml->xpath( '/parametres/themes/favicon' )[0];
    
    //Nb d'articles par pages
    $articlesPage = 10;

    //always start at first page
    $current_page = 1;

?>
<!DOCTYPE html>
<html lang="fr">

<!-- Mirrored from foxythemes.net/preview/products/amaretti/tables-datatables.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:46:57 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title; ?></title>
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

      <?php include("themes/default/top-nav.php"); ?>

      <?php include("themes/default/left-sidebar.php"); ?>

      <div class="am-content">
        <div class="page-head">
          <h2><?php echo $title; ?></h2>
          <ol class="breadcrumb">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Catalogue</a></li>
            <li class="active">Articles</li>
          </ol>
        </div>
        <div class="main-content">

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

          <div class="row">
            <div class="col-sm-12">
              <div class="widget widget-fullwidth widget-small" style="padding:10px;overflow:auto;">

                <div class="col-sm-6"><div class="dataTables_length" id="table3_length">
                  <label>
                    <select id="articlesPage" name="table3_length" id="table3_length" aria-controls="table3" class="form-control input-sm" onchange="changeLength()">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="All">Tous</option>
                    </select> </label>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div id="table3_filter" class="dataTables_filter">
                      <label>Recherche:<input id="search" onkeyup="loadPage(1)" type="search" class="form-control input-xs" placeholder="" aria-controls="table3"></label>
                  </div>
                </div>  

                <table id="table3" class="display responsive table table-striped table-hover table-fw-widget table-condensed" style="overflow:auto;">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Code</th>
                      <th>Etat</th>
                      <th>Raison sociale</th>
                      <th>Date</th>
                      <th>Remise</th>
                      <th>Net</th>
                      <th>Réglé</th>
                      <th>Reste</th>
                      <th>Total HT</th>
                      <th>Total TVA</th>
                      <th>Mode</th>
                      <th>Etat</th>
                      <th>PDF</th>
                    <?php if( $_SESSION["typeCompte"] == "Admin" ){ ?>    
                      <th>Actions</th>
                    <?php } ?>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                        include("db.php");
                        $query = "SELECT    `code`,
                                            `raison`,
                                            `date`,
                                            `remise`,
                                            (`total_ht` + `total_tva` + `taxe_supp` + `timbre` ) AS 'Net',
                                            `regler`,
                                            (`total_ht` + `total_tva` + `taxe_supp` + `timbre` - `regler`) AS 'reste',
                                            `total_ht`,
                                            `total_tva`,
                                            `mode`,
                                            `trans_type`,
                                            `trans_num`,
                                            `agent`,
                                            `etat`,
                                            `etat_web`
                                        FROM ccs ";

                        if( $_SESSION["typeCompte"] == "Client" ){
                            $query .= " WHERE codeclient='" . $_SESSION['codeclient'] . "'";
                        }
                      
                        if( $articlesPage != 'All' )
                            $query .= " ORDER BY `date` DESC LIMIT " . $articlesPage;

                        //echo $query;
                        $res = mysql_query( $query );
                        $n = 1;
                        while( $i = mysql_fetch_assoc( $res ) ){
                            $code     = $i['code'];
                            $etat_web = $i['etat_web'];
                            echo "<tr nowrap>";
                                echo "<td>" . $n                . "</td>";
                                echo "<td nowrap>" . $i['code']     . "</td>";

                                if( $i['etat_web'] == "En cours" )
                                    echo "<td>En cours</td>";
                                else if( $i['etat_web'] == "Annuler" )  
                                    echo "<td style='color:red;'>Annulée</td>";
                                else if( $i['etat_web'] == "Valider" ) 
                                    echo "<td style='color:green;'>Confirmée</td>";
                                else if( $i['etat_web'] == "Livrer" ) 
                                    echo "<td style='color:green;'>Livrée</td>";

                                echo "<td nowrap>" . $i['raison']         . "</td>";
                                echo "<td nowrap>" . Date('d-m-Y', strtotime( $i['date'] ) )       . "</td>";
                                echo "<td nowrap style='text-align:right;'>" . number_format( $i['remise'],2,'.',' ' )        . "</td>";
                                echo "<td nowrap style='text-align:right;'>" . number_format( $i['Net'],2,'.',' ' )         . "</td>";
                                echo "<td nowrap style='text-align:right;'>" . number_format( $i['regler'],2,'.',' ' )         . "</td>";
                                echo "<td nowrap style='text-align:right;'>" . number_format( $i['reste'],2,'.',' ' )         . "</td>";
                                echo "<td nowrap style='text-align:right;'>" . number_format( $i['total_ht'] ,2,'.',' ' )        . "</td>";
                                echo "<td nowrap style='text-align:right;'>" . number_format( $i['total_tva'] ,2,'.',' ' )        . "</td>";
                                echo "<td nowrap>" . $i['mode']         . "</td>";
                                echo "<td nowrap>" . $i['etat']         . "</td>";
                                echo "<td nowrap><a target='_blank' href='pdf/print/ccs.pdf.php?id=" . $i['code']         . "'' ><img src='assets/img/pdf.png'></a></td>";                            
                          ?>
                           
                      <?php if( $_SESSION["typeCompte"] == "Admin" ){ ?>
                      <td nowrap>

                    <div class="btn-group btn-hspace">
                      <button type="button" class="btn btn-default">Changer l'état</button>
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                      <ul role="menu" class="dropdown-menu">
                          <?php if($etat_web!='Annuler'){ ?><li data-modal="colored-danger" class="md-trigger" onclick="annulerClick('<?php echo $code; ?>')"><a href="#">Annuler</a></li><?php } ?>
                          <?php if($etat_web!='Valider'){ ?><li onclick="validerClick('<?php echo $code; ?>')" data-modal="colored-success" class="md-trigger"><a href="#">Confirmer</a></li><?php } ?>
                          <?php if($etat_web!='Livrer'){ ?><li onclick="livrerClick('<?php echo $code; ?>')" data-modal="colored-info" class="md-trigger"><a href="#">Livrer</a></li><?php } ?>
                      </ul>
                    </div>
                                
                      </td>
                      <?php } ?>
                      
                          <?php                                
                            echo "</tr>";
                            $n++;
                        }
                    ?>
                  </tbody>
                </table>

            <div class="dataTables_paginate paging_simple_numbers" id="table3_paginate">

                <ul class="pagination pull-right" id="pagination">
                    <li title="Première" onclick="loadPage(1)" class="paginate_button previous" id="table3_previous"><a href="#" aria-controls="table3" data-dt-idx="0" tabindex="0">Première</a></li>

                  <?php
                      $query = "SELECT count(*) AS NB FROM ccs ";
                      $res   = mysql_query( $query );
                      while( $i = mysql_fetch_assoc($res) ){
                          $NB = intval($i['NB'] / $articlesPage);
                          if( $i['NB'] % $articlesPage != 0 )
                              $NB++;
                      }

                      $first_page = intval( $current_page ) - 5;
                      if( $first_page < 1 )
                          $first_page = 1;

                      $last_page  = intval( $current_page ) + 4;
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
                      
                      <li onclick="loadPage(<?php echo $p; ?>)" class="paginate_button<?php echo $active; ?>"><a href="#" aria-controls="table3" data-dt-idx="<?php echo $p; ?>" tabindex="0"><?php echo $p; ?></a></li>
                      
                    <?php
                        }
                    ?>

                      <li title="Dernière" onclick="loadPage(<?php echo $NB; ?>)" class="paginate_button next" id="table3_next"><a href="#" aria-controls="table3" data-dt-idx="8" tabindex="0">Dernière</a></li>  
                  </ul>
                </div>
                
              </div>
            </div>
          </div>

        </div>
      </div>

      <?php include("themes/default/right-sidebar.php"); ?>

    </div>

                  <!-- Valider Modal-->
                  <div id="colored-success" class="modal-container modal-colored-header modal-colored-header-success modal-effect-10">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><i class="icon s7-close"></i></button>
                        <h3 class="modal-title">Custom Header Color</h3>
                      </div>
                      <div class="modal-body">
                        <div class="text-center">
                          <div class="i-circle text-success"><i class="icon s7-check"></i></div>
                          <h4></h4>
                          <p>Êtes vous-sûr de vouloir valider cette commande?</p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Non</button>
                        <button type="button" data-dismiss="modal" class="btn btn-success modal-close" onclick="">Oui</button>
                      </div>
                    </div>
                  </div>
                  <!-- Valider Modal-->

                  <!-- Annuler Modal-->
                  <div id="colored-danger" class="modal-container modal-colored-header modal-colored-header-danger modal-effect-6">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><i class="icon s7-close"></i></button>
                        <h3 class="modal-title">Annuler la commande N° </h3>
                      </div>
                      <div class="modal-body">
                        <div class="text-center">
                          <div class="i-circle text-warning"><i class="icon s7-help1"></i></div>
                          <h4></h4>
                          <p>Êtes vous-sûr de vouloir annuler cette commande?</p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Non</button>
                        <button type="button" data-dismiss="modal" class="btn btn-danger modal-close" onclick="">Oui</button>
                      </div>
                    </div>
                  </div>
                  <!-- Annuler Modal-->

                  <!-- Livrer Modal-->
                  <div id="colored-info" class="modal-container modal-colored-header modal-colored-header-info modal-effect-10">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><i class="icon s7-close"></i></button>
                        <h3 class="modal-title">Livrer la commande N°</h3>
                      </div>
                      <div class="modal-body">
                        <div class="text-center">
                          <div class="i-circle text-info"><i class="icon s7-check"></i></div>
                          <h4></h4>
                          <p>Êtes-vous sûr de vouloir changer l'état de cette commande à 'Livrée' ?</p>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Non</button>
                        <button type="button" data-dismiss="modal" class="btn btn-info modal-close">Oui</button>
                      </div>
                    </div>
                  </div>
                  <!-- Livrer Modal-->


    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.niftymodals/dist/jquery.niftymodals.js" type="text/javascript"></script>

    <script type="text/javascript">

      //Set Nifty Modals defaults
      $.fn.niftyModal('setDefaults',{
            overlaySelector: '.modal-overlay',
            contentSelector: '.modal-content',
            closeSelector: '.modal-close',
            classAddAfterOpen: 'modal-show',
            classModalOpen: 'modal-open',
            classScrollbarMeasure: 'modal-scrollbar-measure',
            afterOpen: function(){
             $("html").addClass('am-modal-open');
            },
            afterClose: function(){
              $("html").removeClass('am-modal-open');
            }
      });


      $(document).ready(function(){
      	//initialize the javascript
      	App.init();

      });

      function validerClick(code){
          $('#colored-success h3.modal-title').text( "Validerer la commande N° " + code );
          $('#colored-success button.btn-success').attr( 'onclick', "validerCmd('" + code + "')" );
      }

      function annulerClick(code){
          $('#colored-danger h3.modal-title').text( "Annuler la commande N° " + code );
          $('#colored-danger button.btn-danger').attr( 'onclick', "annulerCmd('" + code + "')" );
      }

      function livrerClick(code){
          $('#colored-info h3.modal-title').text( "Livrer la commande N° " + code );
          $('#colored-info button.btn-info').attr( 'onclick', "livrerCmd('" + code + "')" );
      }

      function livrerCmd(code){
          //cancel cmd
          $.ajax({
              url  : "snippets/livrerCmd.php" ,
              type : "POST",
              data : {    
                          "code"          : code
                     },
              success: function(data,status,xhr){
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      $("#errorAlert").addClass("hidden");
                      $("#successAlert").removeClass("hidden");
                      $("#successAlert span#success_msg").text("La commande " + code + " a été livrée");            
              }
          });
      }

      function annulerCmd(code){
          //cancel cmd
          $.ajax({
              url  : "snippets/annulerCmd.php" ,
              type : "POST",
              data : {    
                          "code"          : code
                     },
              success: function(data,status,xhr){
                      $("html, body").animate({ scrollTop: 0 }, "slow");
                      $("#successAlert").addClass("hidden");
                      $("#errorAlert").removeClass("hidden");
                      $("#errorAlert span#error_msg").text("La commande " + code + " a été annulée");                  
              }
          });
      }

      function validerCmd(code){
          //valider cmd
          $.ajax({
              url  : "snippets/validerCmd.php" ,
              type : "POST",
              data : {    
                          "code"          : code
                     },
              success: function(data,status,xhr){
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    $("#errorAlert").addClass("hidden");
                    $("#successAlert").removeClass("hidden");
                    $("#successAlert span#success_msg").text("La commande " + code + " a été confirmée");              
              }
          });
      }

      //when length changes
      function changeLength(){
          loadPage(1);
      }

      //go from page to page
      function loadPage( p ){
          var articlesPage = $("#articlesPage option:selected").val();
          var searchTerm   = $('#search').val();
          //load paginator
          $.ajax({
              url  : "snippets/loadCcsPaginator.php" ,
              type : "POST",
              data : {    "page"          : p, 
                          "articlesPage"  : articlesPage,
                          "search"        : searchTerm
                     },
              success: function(data,status,xhr){
                  $('#pagination').html( data );
              }
          });
          //load page p
          $.ajax({
              url  : "snippets/loadCcsPage.php" ,
              type : "POST",
              data : {    "page"          : p, 
                          "articlesPage"  : articlesPage,
                          "search"        : searchTerm
                     },
              success: function(data,status,xhr){
                  $('table tbody').html( data );
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

<!-- Mirrored from foxythemes.net/preview/products/amaretti/tables-datatables.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:47:01 GMT -->
</html>
