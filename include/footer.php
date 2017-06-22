<?php    
    $description2 = $xml->xpath( '/parametres/affichage/about/description2' )[0];
?>
<footer id="footer" class="footer-area">
            <div class="footer-top">
                <div class="container-fluid">
                    <div class="plr-185">
                        <div class="footer-top-inner gray-bg">
                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-4">
                                    <div class="single-footer footer-about">
                                        <div class="footer-logo">
                                            <h2 class="uppercase"><?php echo $societe; ?></h2>
                                        </div>
                                        <div class="footer-brief">
                                            <?php echo $description2; ?>
                                        </div>
                                        <ul class="footer-social">
                                            <li>
                                                <a class="facebook" href="<?php echo $facebook; ?>" target="_blank" title="Facebook"><i class="zmdi zmdi-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a class="google-plus" href="<?php echo $googleplus; ?>" target="_blank" title="Google Plus"><i class="zmdi zmdi-google-plus"></i></a>
                                            </li>
                                            <li>
                                                <a class="twitter" href="<?php echo $twitter; ?>" target="_blank" title="Twitter"><i class="zmdi zmdi-twitter"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 hidden-md hidden-sm">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">Produits</h4>
                                        <ul class="footer-menu">
                                            <li>
                                                <a href="../shop.php?sort=0"><i class="zmdi zmdi-circle"></i><span>Nouveaux produits</span></a>
                                            </li>
                                            <li>
                                                <a href="../shop.php?sort=1"><i class="zmdi zmdi-circle"></i><span>Les moins chers</span></a>
                                            </li>
                                            <li>
                                                <a href="../shop.php?sort=2"><i class="zmdi zmdi-circle"></i><span>Les plus chers</span></a>
                                            </li>
                                            <li>
                                                <a href="../shop.php?vendus"><i class="zmdi zmdi-circle"></i><span>Les plus vendus</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">Compte</h4>
                                        <ul class="footer-menu">
                                            <li>
                                                <a href="../../profile.php?p=1"><i class="zmdi zmdi-circle"></i><span>Mon profile</span></a>
                                            </li>
                                            <li>
                                                <a href="../../login.php"><i class="zmdi zmdi-circle"></i><span>Connexion</span></a>
                                            </li>
                                            <li>
                                                <a href="../panier.php?p=0"><i class="zmdi zmdi-circle"></i><span>Ma carte</span></a>
                                            </li>
                                            <li>
                                                <a href="../panier.php?p=1"><i class="zmdi zmdi-circle"></i><span>List de souhaits</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">Contactez-nous</h4>
                                        <span id="footerMail"></span>
                                        <div class="footer-message">
                                            <div action="#">
                                                <input type="text" id="name" placeholder="Votre nom ici ...">
                                                <input type="text" id="email" placeholder="Votre email ici ...">
                                                <textarea class="height-80" id="message" placeholder="Votre message ici ..."></textarea>
                                                <button class="submit-btn-1 mt-20 btn-hover-1" type="submit" onclick="sendMail()">Envoyer</button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom black-bg">
                <div class="container-fluid">
                    <div class="plr-185">
                        <div class="copyright">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="copyright-text">
                                        <p>&copy; <a href="http://www.cirtait.com" target="_blank">CiRTA iT</a> <?php echo Date('Y'); ?>. Tous droits réservés.</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <ul class="footer-payment text-right hidden">
                                        <li>
                                            <a href="#"><img src="img/payment/1.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/2.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/3.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/4.jpg" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

<script>

        function sendMail(){ 
            var name     = $("#name").val();
            var email    = $("#email").val();
            var message  = $("#message").val();  
            //send mail via ajax
            if( (name === '') || (email === '') || (message === '') ){  
                $("#footerMail").html("<i style='color:red;'>Merci de bien remplir le formulaire</i>");
            }else{
                alert('entered');
                $.ajax({
                    url  : "snippets/footerMail.php" ,
                    type : "POST",
                    data : { 
                                "name"    : name ,
                                "email"   : email,
                                "message" : message
                           },
                    success: function(data,status,xhr){
                        if( data == "Merci! Votre message a été envoyé." )
                            $("#footerMail").html( "<i style='color:green;'>" + data + "</i>" );
                        else
                            $("#footerMail").html( "<i style='color:red;'>" + data + "</i>" );
                    }
                });
            }
        }             
        
</script>