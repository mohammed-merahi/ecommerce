<?php
    $code = $_POST['code'];
    if( $code != '' ){
        include('../db.php');
        $query = "UPDATE ccs SET etat_web='Livrer' WHERE code='" . $code . "'";
        mysql_query( $query );
    }
?>