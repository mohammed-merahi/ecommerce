<?php
    include('db.php');
        
    $xml     = simplexml_load_file("../config/parametres.xml");
    $logo    = $xml->xpath( '/parametres/themes/logo' )[0];

?>
<div class="col-md-2 col-sm-6 col-xs-12">
    <div class="logo" style="padding-bottom:0px;padding-top:20px;">
        <a href="shop.php">
            <img style="width:50%;height:50%;" src="<?php echo "../assets/img/" . $logo; ?>" alt="main logo">
        </a>
    </div>
</div>