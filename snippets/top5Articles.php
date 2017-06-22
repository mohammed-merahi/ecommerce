<?php
    session_start();
    include('../db.php');

    $query = "SELECT    codeart, 
                        designation, 
                        SUM(qte * prix_ht) AS 'S'
                    FROM cmds_clients ";    

    //filtre client
    if( $_SESSION['typeCompte'] == "Client" ){
        $query .= " WHERE codeclient = '" . $_SESSION['codeclient'] . "'";
    }

    $query .= " GROUP BY codeart 
                ORDER BY S DESC
                LIMIT 5 ";

    $res = mysql_query( $query );
    while( $i = mysql_fetch_assoc($res) ){
        //echo "<span class='hidden' id='". $i['codeart'] ."' data-designation='". $i['designation'] ."' data-sum='". $i['S'] ."' >";
        
        $return_arr[] = array(  "codeart"       => $i['codeart'],
                                "designation"   => $i['designation'],
                                "sum"           => $i['S'] 
                             );
    }

    // Encoding array in JSON format
    echo json_encode( $return_arr, JSON_HEX_QUOT );

?>