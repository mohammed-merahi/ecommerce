<?php
session_start();

if( isset($_SESSION['articles_count']) ){
    for( $i=1;$i<=$_SESSION['articles_count'];$i++ ){
        $art = $_SESSION['article_' . $i];
        
        if( $art != '0' )
            echo "article " . $i . ": " . $art . " -- Qte_i: " . $_SESSION['qte_' . $i] . "-- Qte_art: " . $_SESSION['qte_' . $art] .  "<br>";
    }
}else{
    echo "cart is empty";
}

echo "<br><pre>" . print_r( $_SESSION ) . "</pre><br>";

//session_destroy();
//$_SESSION['wishlist'] = "00004,00007,00043,00052,00009,00036";  
print_r( $_SESSION['wishlist'] );
    
