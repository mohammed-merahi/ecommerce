<?php
    session_start();
    include("../db.php");
    $page                       = $_POST['page'];
    $articlesPage               = $_POST['articlesPage'];
    $keyword                    = $_POST['search'];

    if( $articlesPage == 'All' )
        exit;
?>
    <li title="Première" onclick="loadPage(1)" class="paginate_button previous" id="table3_previous"><a href="#" aria-controls="table3" data-dt-idx="0" tabindex="0">Première</a></li>

<?php
  $query = "SELECT  count(*) AS NB
                  FROM lots CROSS JOIN articles USING(codeart)
                  WHERE lots.qte > 0 ";

    //recherche
    if( $keyword != '' ){
            $query .= " AND ( ";  //debut des condition
            $query .= " lower(articles.designation) like lower('%$keyword%') ";

            if( strpos($keyword, ' ') !== false ){
                $mots = explode(" ",$keyword);
                $i    = 0;
                $mot1 = '';
                foreach( $mots as $mot ){
                    if( $i == 0 ){
                        $query .= " OR ( lower(articles.designation) like lower('%$mot%') ";  
                        $mot1   = $mot;
                    }else
                        $query .= " AND   lower(articles.designation) like lower('%$mot%') "; 

                    $i++;
                }
                $query .= ")";
            }
            $query .= " OR    lower(articles.codeart)       LIKE lower('$keyword') ";  
            $query .= " OR    lower(articles.ref)           LIKE lower('$keyword') ";  
            $query .= " OR    lower(articles.codebar)       LIKE lower('$keyword') ";    
            $query .= " OR    lower(articles.marque)        LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(articles.designation2)  LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(articles.categorie)     LIKE lower('%$keyword%') ";   
            $query .= " ) ";//fin des conditions
    }

  $res   = mysql_query( $query );
  while( $i = mysql_fetch_assoc($res) ){
      $NB = intval($i['NB'] / $articlesPage);
      if( $i['NB'] % $articlesPage != 0 )
          $NB++;
  }

  $first_page = intval($page) - 5;
  if( $first_page < 1 )
      $first_page = 1;

  $last_page  = intval($page) + 4;
  if( $last_page < 10 )
      $last_page = 10;
  if( $last_page > $NB ){
      $last_page  = $NB;
      $first_page = $NB - 9;
      if( $first_page < 1 )
          $first_page = 1;
  }


  for($p=$first_page;$p<=$last_page;$p++){
      if( $p == $page )
          $active = " active";
      else
          $active = "";

?>

  <li onclick="loadPage(<?php echo $p; ?>)" class="paginate_button<?php echo $active; ?>"><a href="#" aria-controls="table3" data-dt-idx="<?php echo $p; ?>" tabindex="0"><?php echo $p; ?></a></li>

<?php
    }
?>

  <li title="Dernière" onclick="loadPage(<?php echo $NB; ?>)" class="paginate_button next" id="table3_next"><a href="#" aria-controls="table3" data-dt-idx="8" tabindex="0">Dernière</a></li>  
