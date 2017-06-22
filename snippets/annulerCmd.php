<?php
    $code = $_POST['code'];
    if( $code != '' ){
        include('../db.php');
        $query = "UPDATE ccs SET etat_web='Annuler' WHERE code='" . $code . "'";
        mysql_query( $query );
    }
?>