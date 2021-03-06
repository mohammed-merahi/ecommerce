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

<!-- Mirrored from foxythemes.net/preview/products/amaretti/tables-datatables.php by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 27 Mar 2017 09:46:57 GMT -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Familles</title>
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
          <h2>Familles</h2>
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
                    <select name="table3_length" id="table3_length" aria-controls="table3" class="form-control input-sm" onclick="changeLength()">
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                      <option value="100">100</option>
                    </select> </label>
                  </div>
                </div>

                <table id="table3" class="display table table-striped table-hover table-fw-widget">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Famille</th>
                      <th>Libellé</th>
                      <th>Parent</th>
                      <th>marge1</th>
                      <th>marge2</th>
                      <th>marge3</th>
                      <th>marge4</th>
                      <th>marge5</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                        include("db.php");
                        $query = "SELECT  famille,
                                          libelle,
                                          parent,
                                          marge1,
                                          marge2,
                                          marge3,
                                          marge4,
                                          marge5
                                   FROM fam_articles ";

                        //echo $query;
                        $res = mysql_query( $query );
                        $n = 1;
                        while( $i = mysql_fetch_assoc( $res ) ){
                            echo "<tr>";
                                echo "<td>" . $n                . "</td>";
                                echo "<td>" . $i['famille']     . "</td>";
                                echo "<td>" . $i['libelle']         . "</td>";
                                echo "<td>" . $i['parent']         . "</td>";
                                echo "<td>" . $i['marge1']         . "</td>";
                                echo "<td>" . $i['marge2']         . "</td>";
                                echo "<td>" . $i['marge3']         . "</td>";
                                echo "<td>" . $i['marge4']         . "</td>";
                                echo "<td>" . $i['marge5']         . "</td>";
                            echo "</tr>";
                            $n++;
                        }
                    ?>
                  </tbody>
                </table>
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
    <script src="assets/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.html5.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.flash.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.print.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.colVis.js" type="text/javascript"></script>
    <script src="assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js" type="text/javascript"></script>
  	<script src="assets/lib/datatables/plugins/KeyTable/js/dataTables.keyTable.min.js"></script>
  	<script src="assets/lib/datatables/plugins/Scroller/js/dataTables.scroller.min.js"></script>
  	<script src="assets/lib/datatables/plugins/ColReorder/js/dataTables.colReorder.min.js"></script>
  	<script src="assets/lib/datatables/plugins/Select/js/dataTables.select.min.js"></script>

    <script type="text/javascript">

      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      	//App.dataTables();
        $('#table3').DataTable( {
          deferRender:    true,
          scrollCollapse: true,
          scroller:       true,
          scrollY:    '450px',
          paging:     true,
          colReorder: true,
          info  : true,
          pageLength : 10,
          lengthMenu : [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
          //select: { style: 'multi' },
          fixedColumns:   {
                              leftColumns: 1
                          },
          keys: true,
          dom: 'Bfrtip',
          buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                   ]
        } );
      });

      function changeLength(){
        var nb = $("#table3_length option:selected").val();

        if( nb ){
            var table = $('#table3').dataTable({
              destroy: true,
              scrollY:    '500px',
              paging:     true,
              colReorder: true,
              info  : true,
              pageLength : nb,
              lengthMenu : [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
              //select: { style: 'multi' },
              fixedColumns:   {
                                  leftColumns: 1
                              },
              keys: true,
              dom: 'Bfrtip',
              buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ]
            });
            table.draw();
        }

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
