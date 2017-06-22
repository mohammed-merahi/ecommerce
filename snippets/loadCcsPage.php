<?php
    session_start();
    include("../db.php");
    $page                       = $_POST['page'];
    $articlesPage               = $_POST['articlesPage'];
    $keyword                    = $_POST['search'];

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

    //recherche
    if( $keyword != '' ){
            $query .= " WHERE ( ";  //debut des condition
            $query .= " lower(raison) like lower('%$keyword%') ";
            
            if( strpos($keyword, ' ') !== false ){
                $mots = explode(" ",$keyword);
                $i    = 0;
                $mot1 = '';
                foreach( $mots as $mot ){
                    if( $i == 0 ){
                        $query .= " OR ( lower(raison) like lower('%$mot%') ";
                        $mot1   = $mot;
                    }else
                        $query .= " AND   lower(raison) like lower('%$mot%') ";
                    
                    $i++;
                }
                $query .= ")";
            }
            $query .= " OR    lower(code)                   LIKE lower('$keyword') ";  
            $query .= " OR    lower(date)                   LIKE lower('$keyword') ";  
            $query .= " OR    lower(mode)                   LIKE lower('$keyword') ";    
            $query .= " OR    lower(etat)                   LIKE lower('%$keyword%') ";   
            $query .= " OR    lower(agent)                  LIKE lower('%$keyword%') ";   
            $query .= " ) ";//fin des conditions
    }

    //sort
    $query .= " ORDER BY `date` DESC ";

    //which page
    if( $articlesPage != 'All' )
        $query .= " LIMIT " . ($page-1)* $articlesPage . "," . $articlesPage;


    $res = mysql_query( $query );
    $n = ($page-1) * $articlesPage + 1;

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
                        echo "<td nowrap>" . $i['agent']         . "</td>";
                        echo "<td nowrap>" . $i['etat']         . "</td>";
                        echo "<td nowrap><a target='_blank' href='pdf/print/ccs.pdf.php?id=" . $i['code']         . "'' ><img src='assets/img/pdf.png'></a></td>";
                  ?>
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
                  <?php                                
                    echo "</tr>";
                    $n++;
    }
    
?>