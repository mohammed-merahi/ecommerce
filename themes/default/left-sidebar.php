<?php
    $xml      = simplexml_load_file("config/parametres.xml");
    $dashbrd    = $xml->xpath( '/parametres/themes/dashboard' )[0];
    if( $dashbrd == "Modèle 1" )
        $dashbrd = "index.php";
    else
        $dashbrd = "index-2.php";
?>

<div class="am-left-sidebar">
  <div class="content">
    <div class="am-logo"></div>
    <ul class="sidebar-elements">

<?php if( $_SESSION["typeCompte"] == "Admin" ){ ?>        
      <li class="parent"><a href="<?php echo $dashbrd;  ?>"><i class="icon s7-monitor"></i><span>Tableau de bord</span></a>
      </li>
<?php } ?>

<?php if( $_SESSION["typeCompte"] == "Admin" ){ ?>
      <li class="parent"><a href="#"><i class="icon s7-note2"></i><span>Catalogue</span></a>
        <ul class="sub-menu">
          <li><a href="articles.php">Articles</a>
          </li>
          <li class="hidden"><a href="lots.php">Lots</a>
          </li>
          <li><a href="categories.php">Catégories</a>
          </li>
          <li><a href="familles.php">Familles</a>
          </li>
        </ul>
      </li>
      <li class="parent"><a href="#"><i class="icon s7-box2"></i><span>Tables</span></a>
        <ul class="sub-menu">
          <li><a href="clients.php">Clients</a>
          </li>
          <li><a href="livreurs.php">Livreurs</a>
          </li>
    <?php if(false){ ?>        
          <li><a href="expeditions.php">Expeditions</a>
          </li>
          <li><a href="transports.php">Mode de livraison</a>
          </li>
    <?php } ?>        
        </ul>
      </li>
<?php } ?>

      <li class="parent"><a href="#"><i class="icon s7-cart"></i><span>Ventes</span></a>
        <ul class="sub-menu">
          <li><a href="ccs.php">Commandes</a>
          </li>
            <li class="hidden"><a href="fcs.php">Factures</a>
          </li>
        </ul>
      </li>

<?php if( $_SESSION["typeCompte"] == "Admin" ){ ?>
      <li class="parent"><a href="parametres.php"><i class="icon s7-settings"></i><span>Paramètres</span></a>        
      </li>
<?php } ?>

      <li class="parent"><a href="#"><i class="icon s7-config"></i><span>Profile</span></a>
        <ul class="sub-menu">
          <li><a href="profile.php?p=1">Mon compte</a>
          </li>
          <li><a href="profile.php?p=2">Changer mon mot de passe</a>
          </li>
          <li><a href="logout.php">Déconnexion</a>
          </li>
        </ul>
      </li>
    </ul>
    <!--Sidebar bottom content-->
  </div>
</div>
