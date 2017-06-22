<?php
    include('../db.php');

    $query = "SELECT 
                        sum(total_ht) AS S,
                        date,
                        extract( MONTH FROM date ) AS mois,
                        extract( YEAR FROM date ) AS annee
                FROM ccs
                GROUP BY annee, mois
                order by annee DESC, mois DESC 
                LIMIT 7";    

    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc($res) ){
        //echo "<span class='hidden' id='". $i['codeart'] ."' data-designation='". $i['designation'] ."' data-sum='". $i['S'] ."' >";
        
        $return_arr[] = array(  "mois"    => $i['mois'] . '/' . $i['annee'] ,
                                "sum"     => intval( $i['S'] )
                             );
    }

    // Encoding array in JSON format
    echo json_encode( $return_arr, JSON_HEX_QUOT );

?>