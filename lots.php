<?php
    session_start();

    if( !isset($_SESSION['typeCompte']) ){
        header("Location: login.php");
    }else if( $_SESSION['typeCompte'] == 'Client' ){
        header("Location: ccs.php");
    }

    include("config/consts.php");
    include("db.php");
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
    <title>Lots</title>
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

  	<link href="assets/lib/datatables/plugins/KeyTable/css/keyTable.dataTables.min.css" rel="stylesheet" />
    <link href="assets/lib/datatables/plugins/Scroller/css/scroller.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/lib/datatables/plugins/Buttons/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="assets/lib/datatables/plugins/Select/css/select.dataTables.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="assets/lib/datatables/css/dataTables.bootstrap.min.css"/>
  </head>
  <body>
    <div class="am-wrapper">

      <?php include("themes/default/top-nav.php"); ?>

      <?php include("themes/default/left-sidebar.php"); ?>

      <div class="am-content">
        <div class="page-head">
          <h2>Lots</h2>
          <ol class="breadcrumb">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Catalogue</a></li>
            <li class="active">Articles</li>
          </ol>
        </div>
        <div class="main-content">

          <div class="row">
            <div class="col-sm-12">
              <div class="widget widget-fullwidth widget-small" style="padding:10px;">

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

                <table id="table3" class="display table table-striped table-hover table-fw-widget">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>N° lot</th>
                      <th>code article</th>
                      <th>Désignation</th>
                      <th>Qte</th>
                      <th>SHP</th>
                      <th>PPA</th>
                      <th>Valeur stock</th>
                      <th>DDP</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                        $query = "SELECT  if(lots.ref='',lots.num_lot,lots.ref) as 'N_lot',
                                          articles.codeart,
                                          articles.designation,
                                          articles.designation2 as 'DCI',
                                          lots.qte AS 'QTE',
                                          lots.shp AS 'SHP',
                                          lots.ppa AS 'PPA',
                                          lots.prix_revient,
                                          lots.qte*lots.prix_revient as 'Valeur_stock',
                                          lots.expire,
                                          lots.codebar_colis,
                                          lots.codebar,
                                          lots.rayon,
                                          lots.fabriquer,
                                          lots.fournisseur
                                      FROM lots CROSS JOIN articles USING(codeart)
                                      WHERE lots.qte > 0 ";

                        if( $articlesPage != 'All' )
                            $query .= " LIMIT " . $articlesPage;

                        $res = mysql_query( $query );
                        $n = 1;
                        while( $i = mysql_fetch_assoc( $res ) ){
                            echo "<tr>";
                                echo "<td>" . $n                . "</td>";
                                echo "<td>" . $i['N_lot']     . "</td>";
                                echo "<td>" . $i['codeart']         . "</td>";
                                echo "<td>" . $i['DCI'] . "</td>";
                                echo "<td>" . $i['QTE']     . "</td>";
                                echo "<td>" . $i['SHP'] . "</td>";
                                echo "<td>" . $i['PPA'] . "</td>";
                                echo "<td>" . $i['Valeur_stock'] . "</td>";
                                echo "<td>" . $i['expire'] . "</td>";
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
                      $query = " SELECT count(*) AS NB FROM lots CROSS JOIN articles USING(codeart) WHERE lots.qte > 0 ";
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

    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>

    <script type="text/javascript">

      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      	
      });

      //when length changes
      function changeLength(){
          loadPage(1);
      }

      //go from page to page
      function loadPage( p ){
          var articlesPage = $("#articlesPage option:selected").val();
          var searchTerm   = $('#search').val();
          //load page p
          $.ajax({
              url  : "snippets/loadLotPage.php" ,
              type : "POST",
              data : {    "page"          : p, 
                          "articlesPage"  : articlesPage,
                          "search"        : searchTerm
                     },
              success: function(data,status,xhr){
                  $('table tbody').html( data );
              }
          });
          //load paginator
          $.ajax({
              url  : "snippets/loadLotPaginator.php" ,
              type : "POST",
              data : {    "page"          : p, 
                          "articlesPage"  : articlesPage,
                          "search"        : searchTerm
                     },
              success: function(data,status,xhr){
                  $('#pagination').html( data );
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
