<?php
    include('../db.php');

    $query = "SELECT    codeclient, 
                        raison, 
                        SUM(total_ht) AS 'S'
                    FROM ccs      
                    GROUP BY codeclient 
                    ORDER BY S DESC
                    LIMIT 3 ";    

    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc($res) ){
        //echo "<span class='hidden' id='". $i['codeart'] ."' data-designation='". $i['designation'] ."' data-sum='". $i['S'] ."' >";
        
        $return_arr[] = array(  "codeclient"    => $i['codeclient'],
                                "raison"        => $i['raison'],
                                "sum"           => $i['S'] 
                             );
    }

    // Encoding array in JSON format
    echo json_encode( $return_arr, JSON_HEX_QUOT );

?>