
                <div class="panel panel-default">
                  <div class="panel-heading warning">
                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#ac4-2" class="collapsed"><i class="icon s7-angle-down"></i> Options d'affichage</a></h4>
                  </div>
                  <div id="ac4-2" class="panel-collapse collapse">
                    <div class="panel-body">
                              <div class="col-sm-12">
                                <div class="tab-container">
                                  <ul class="nav nav-tabs">
                                    <li class="active"><a href="#home" data-toggle="tab">Accueil</a></li>
                                    <li><a href="#shop" data-toggle="tab">Boutique</a></li>
                                    <li><a href="#about" data-toggle="tab">A propos</a></li>
                                    <li><a href="#contact" data-toggle="tab">Contact</a></li>
                                  </ul>
                                <div class="tab-content">
                                  <div id="home" class="tab-pane active cont">
                                      <h3>Les images du slideshow</h3>
                                        <table class="table table-responsive table-condensed" style="width:300px;">
                                            <thead>
                                                <th>Images</th>
                                                <th style="text-align:center;">Supprimer</th>
                                            </thead>
                                            <tbody>
                                        <?php
                                            define('IMAGEPATH', 'pe\img\slider\slider-1/');
                                            foreach(glob(IMAGEPATH.'*') as $filename){                                    
                                        ?>        
                                                <tr>
                                                    <td style="width:100px;"><a target="_blank" href="<?php echo $filename; ?>"><img style="width:150%;height:auto;" src="<?php echo $filename; ?>" alt="" style="width:100%;height:auto;"></td>
                                                    <td style="text-align:center;"><a onclick="delete_img()" href="#"><i class="fa fa-close" style="color:red;font-size:120%;"></i></a></td>
                                                </tr>
                                                <!-- layer-1 end -->
                                        <?php        
                                            }
                                        ?>
                                            </tbody>    
                                        </table>
                                            <form role="form" class="col-sm-6">
                                                  <div class="form-group">
                                                    <label>Ajouter une image au slideshow (1500x600)</label>
                                                    <input type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control" id="slider">
                                                    <div id="image-holder10">
                                                      <?php
                                                          $banner = "assets/img/" . trim($xml->xpath( '/parametres/affichage/boutique/banner' )[0]);
                                                          if( $banner != "" ){
                                                              echo "<img src='" . '' . "'>";
                                                          }
                                                      ?>
                                                  </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="control-label"></label>
                                                    <div class="">
                                                      <?php
                                                          $grille           = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/grille' )[0]);
                                                          $liste            = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/liste' )[0]);
                                                          $tableauAvecImg   = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/tableauAvecImg' )[0]);
                                                          $tableauSansImg   = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/tableauSansImg' )[0]);
                                                          $produitsNonDispo = trim($xml->xpath( '/parametres/affichage/boutique/produitsNonDispo' )[0]);
                                                          $tva              = trim($xml->xpath( '/parametres/affichage/boutique/tva' )[0]);
                                                          $frais            = trim($xml->xpath( '/parametres/affichage/boutique/fraisLivraison' )[0]);
                                                      ?>
                                                      <div class="am-checkbox">
                                                        <input id="grille" type="checkbox" <?php if($grille == "Oui") echo "checked"; ?> >
                                                        <label for="grille">Afficher les marques</label>
                                                      </div>
                                                      <div class="am-checkbox">
                                                        <input id="liste" type="checkbox" <?php if($liste == "Oui") echo "checked"; ?> >
                                                        <label for="liste">Afficher les catégories</label>
                                                      </div>
                                                      <div class="am-checkbox">
                                                        <input id="tableauAvecImg" type="checkbox" <?php if($tableauAvecImg == "Oui") echo "checked"; ?> >
                                                        <label for="tableauAvecImg">Afficher les produits récents</label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="control-label">Nombre de produits récents à afficher</label>
                                                    <div class="">
                                                      <input id="produitsParPage" type="text" name="btn-class" class="form-control"
                                                            value="<?php echo trim($xml->xpath( '/parametres/affichage/boutique/produitsParPage' )[0]); ?>" >
                                                    </div>
                                                  </div>
                                                  <div class="text-right">
                                                    <button type="submit" class="btn btn-space btn-primary" onclick="updateBoutique()"><span class="s7-check"></span> Appliquer</button>
                                                  </div>
                                            </form>
                                  </div>
                                  <div id="shop" class="tab-pane cont">
                                            <form role="form" class="col-sm-6">
                                                  <div class="form-group">
                                                    <label>Bannière de la page (1480x210)</label>
                                                    <input type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control" id="banner2">
                                                    <div id="image-holder4">
                                                      <?php
                                                          $banner = "assets/img/" . trim($xml->xpath( '/parametres/affichage/boutique/banner' )[0]);
                                                          if( $banner != "" ){
                                                              echo "<img style='width:70%;height:auto;' src='" . $banner . "'>";
                                                          }
                                                      ?>
                                                  </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="control-label">Modes d'affichage des articles</label>
                                                    <div class="">
                                                      <?php
                                                          $grille           = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/grille' )[0]);
                                                          $liste            = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/liste' )[0]);
                                                          $tableauAvecImg   = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/tableauAvecImg' )[0]);
                                                          $tableauSansImg   = trim($xml->xpath( '/parametres/affichage/boutique/modesAffichage/tableauSansImg' )[0]);
                                                          $produitsNonDispo = trim($xml->xpath( '/parametres/affichage/boutique/produitsNonDispo' )[0]);
                                                          $tva              = trim($xml->xpath( '/parametres/affichage/boutique/tva' )[0]);
                                                          $frais            = trim($xml->xpath( '/parametres/affichage/boutique/fraisLivraison' )[0]);
                                                      ?>
                                                      <div class="am-checkbox">
                                                        <input id="grille" type="checkbox" <?php if($grille == "Oui") echo "checked"; ?> >
                                                        <label for="grille">Grille</label>
                                                      </div>
                                                      <div class="am-checkbox">
                                                        <input id="liste" type="checkbox" <?php if($liste == "Oui") echo "checked"; ?> >
                                                        <label for="liste">Liste</label>
                                                      </div>
                                                      <div class="am-checkbox">
                                                        <input id="tableauAvecImg" type="checkbox" <?php if($tableauAvecImg == "Oui") echo "checked"; ?> >
                                                        <label for="tableauAvecImg">Tableau condensé avec image</label>
                                                      </div>
                                                      <div class="am-checkbox">
                                                        <input id="tableauSansImg" type="checkbox" <?php if($tableauSansImg == "Oui") echo "checked"; ?> >
                                                        <label for="tableauSansImg">Tableau condensé sans image</label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="control-label">Nombre de produits par page</label>
                                                    <div class="">
                                                      <input id="produitsParPage" type="text" name="btn-class" class="form-control"
                                                            value="<?php echo trim($xml->xpath( '/parametres/affichage/boutique/produitsParPage' )[0]); ?>" >
                                                    </div>
                                                  </div>
                                                  <div class="am-checkbox">
                                                    <input id="produitsNonDispo" type="checkbox" <?php if($produitsNonDispo == "Oui") echo "checked"; ?> >
                                                    <label for="produitsNonDispo">Afficher les produits non disponible</label>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="control-label">TVA (%)</label>
                                                    <div class="">
                                                      <input id="tva" type="text" class="form-control" value="<?php echo $tva; ?>">
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                    <label class="control-label">Frais de livraison (DA)</label>
                                                    <div class="">
                                                      <input id="frais" type="text" class="form-control" value="<?php echo $frais; ?>">
                                                    </div>
                                                  </div>
                                                  <div class="text-right">
                                                    <button type="submit" class="btn btn-space btn-primary" onclick="updateBoutique()"><span class="s7-check"></span> Appliquer</button>
                                                  </div>
                                            </form>
                                  </div>
                                  <div id="about" class="tab-pane cont">
                                            <form role="form" class="col-sm-12">
                                              <?php
                                                  $banner     = "assets/img/" . trim($xml->xpath( '/parametres/affichage/about/banner' )[0]);
                                                  $societe    = trim($xml->xpath( '/parametres/affichage/about/societe' )[0]);
                                                  $slogan     = trim($xml->xpath( '/parametres/affichage/about/slogan' )[0]);
                                                  $img        = "assets/img/" . trim($xml->xpath( '/parametres/affichage/about/image' )[0]);
                                                  $text       = trim($xml->xpath( '/parametres/affichage/about/description' )[0]);
                                                  $text2      = trim($xml->xpath( '/parametres/affichage/about/description2' )[0]);
                                              ?>
                                              <div class="form-group">
                                                <label>Bannière de la page  (1480x210)</label>
                                                <input type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control" id="banner3">
                                                <div id="image-holder5">
                                                <?php
                                                    if( $banner != "" ){
                                                        echo "<img style='width:70%;height:auto;' src='" . $banner . "'>";
                                                    }
                                                  ?>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Nom de l'entreprise</label>
                                                <div class="">
                                                  <input id="societe" type="text" class="form-control" value="<?php echo $societe; ?>">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Slogan</label>
                                                <div class="">
                                                  <input id="slogan" type="text" class="form-control" value="<?php echo $slogan; ?>">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label>Image de la page (440x320)</label>
                                                <input id="imgAbout" type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control">
                                                <div id="image-holder6">
                                                <?php
                                                    if( $img != "" ){
                                                        echo "<img src='" . $img . "'>";
                                                    }
                                                ?>
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                  <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                      <div class="panel-title">Description de l'entreprise</div>
                                                      <div id="editor1"><?php echo $text; ?></div>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Description courte (pour les pieds de pages)</label>
                                                <div class="">
                                                  <input id="description2" type="text"placeholder="Description ourte" class="form-control" value="<?php echo $text2; ?>">
                                                </div>
                                              </div>
                                              <div class="text-right">
                                                <button type="submit" class="btn btn-space btn-primary" onclick="updateAbout()"><span class="s7-check"></span> Appliquer</button>
                                              </div>
                                            </form>
                                  </div>
                                  <div id="contact" class="tab-pane">
                                            <form role="form" class="col-sm-6">
                                              <?php
                                                  $banner     = "assets/img/" . trim($xml->xpath( '/parametres/affichage/contact/banner' )[0]);
                                                  $adresse    = trim($xml->xpath( '/parametres/affichage/contact/adresse' )[0]);
                                                  $ville      = trim($xml->xpath( '/parametres/affichage/contact/ville' )[0]);
                                                  $postal     = trim($xml->xpath( '/parametres/affichage/contact/postal' )[0]);
                                                  $fixe       = trim($xml->xpath( '/parametres/affichage/contact/fixe' )[0]);
                                                  $mobile     = trim($xml->xpath( '/parametres/affichage/contact/mobile' )[0]);
                                                  $email      = trim($xml->xpath( '/parametres/affichage/contact/email' )[0]);
                                                  $email2     = trim($xml->xpath( '/parametres/affichage/contact/email2' )[0]);
                                                  $latitude   = trim($xml->xpath( '/parametres/affichage/contact/googleMaps/latitude' )[0]);
                                                  $longitude  = trim($xml->xpath( '/parametres/affichage/contact/googleMaps/longitude' )[0]);
                                                  $facebook   = trim($xml->xpath( '/parametres/affichage/contact/facebook' )[0]);
                                                  $googleplus = trim($xml->xpath( '/parametres/affichage/contact/googleplus' )[0]);
                                                  $twitter    = trim($xml->xpath( '/parametres/affichage/contact/twitter' )[0]);
                                              ?>
                                              <div class="form-group">
                                                <label>Bannière de la page (1480x210)</label>
                                                <input type="file" accept="image/*" placeholder="Aucun fichier choisi" class="form-control" id="banner4">
                                                <div id="image-holder7">
                                                <?php
                                                    if( $banner != "" ){
                                                        echo "<img style='width:70%;height:auto;' src='" . $banner . "'>";
                                                    }
                                                ?>
                                              </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Adresse</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $adresse; ?>" id="adresse">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Ville</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $ville; ?>" id="ville">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Code postal</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $postal; ?>" id="postal">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Fixe</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $fixe; ?>" id="fixe">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Mobile</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $mobile; ?>" id="mobile">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Email</label>
                                                <div class="">
                                                  <input type="email" class="form-control" value="<?php echo $email; ?>" id="email">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Email 2</label>
                                                <div class="">
                                                  <input type="email" class="form-control" value="<?php echo $email2; ?>" id="email2">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Coordonnées google maps</label>
                                                <div class="">
                                                  <input type="text" placeholder="latitude"  class="form-control" value="<?php echo $latitude; ?>"  id="latitude">
                                                  <input type="text" placeholder="longitude" class="form-control" value="<?php echo $longitude; ?>" id="longitude">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Facebook</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $facebook; ?>" id="facebook">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Google plus</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $googleplus; ?>" id="googleplus">
                                                </div>
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Twitter</label>
                                                <div class="">
                                                  <input type="text" class="form-control" value="<?php echo $twitter; ?>" id="twitter">
                                                </div>
                                              </div>
                                              <div class="text-right">
                                                <button type="submit" class="btn btn-space btn-primary" onclick="updateContact()"><span class="s7-check"></span> Appliquer</button>
                                              </div>
                                            </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                    </div>
                  </div>
                    
<script>
    function delete_img(){
        alert("deleting ...");
    }
</script>