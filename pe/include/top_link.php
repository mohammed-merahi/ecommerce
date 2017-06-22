<div class="col-sm-6 col-xs-12">
    <div class="top-link clearfix">
        <ul class="link f-right">
            <li>
                <a href="../index.php">
                    <i class="zmdi zmdi-account"></i>
                    <?php
                        if( !isset($_SESSION["compte"]) ){
                            echo "Mon compte";
                        }else{
                            echo $_SESSION["raison"];
                        }
                    ?>
                </a>
            </li>
            <li>
                <a href="panier.php">
                    <i class="zmdi zmdi-favorite"></i>
                    Mes souhaits (0)
                </a>
            </li>
            <li>
                <a href="../login.php">
                    <i class="zmdi zmdi-lock"></i>
                    Connexion
                </a>
            </li>
        </ul>
    </div>
</div>