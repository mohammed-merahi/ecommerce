<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product clearfix">
                                <div class="product-images">
                                    <div class="main-image images">
                                        <img id="modalImg" alt="" src="img/product/quickview.jpg">
                                    </div>
                                </div><!-- .product-images -->
                                
                                <div class="product-info">
                                    <h1 id="productName" data-val="codeart">product name</h1>
                                    <div class="price-box-3">
                                        <div class="s-price-box">
                                            <span id="productPrix" class="new-price"></span>
                                            <span class="old-price">1700 DA</span>
                                        </div>
                                    </div>
                                    <a id="details" href="single-product.php" target="_blank" class="see-all">Voir les détails</a>
                                    <div class="quick-add-to-cart">
                                        <form method="post" class="cart">
                                            <div class="numbers-row">
                                                <input id="productQte" type="number" id="french-hens" value="3" onkeyup="QteChange()" onchange="QteChange()" >
                                            </div>
                                            <button data-dismiss="modal" aria-label="Close" class="single_add_to_cart_button" id="btnAdd2Cart" type="submit" onclick="add2Cart(codeart)">Ajouter au panier</button>
                                        </form>
                                    </div>
                                    <div id="productDescription" class="quick-desc"></div>
                                    <div class="social-sharing">
                                        <div class="widget widget_socialsharing_widget">
                                            <h3 class="widget-title-modal">Partager ce produit</h3>
                                            <ul class="social-icons clearfix">
                                                <li>
                                                    <a class="facebook" href="https://www.facebook.com" target="_blank" title="Facebook">
                                                        <i class="zmdi zmdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="google-plus" href="https://www.google.com" target="_blank" title="Google +">
                                                        <i class="zmdi zmdi-google-plus"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="twitter" href="https://www.twitter.com" target="_blank" title="Twitter">
                                                        <i class="zmdi zmdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="hidden">
                                                    <a class="pinterest" href="#" target="_blank" title="Pinterest">
                                                        <i class="zmdi zmdi-pinterest"></i>
                                                    </a>
                                                </li>
                                                <li class="hidden">
                                                    <a class="rss" href="#" target="_blank" title="RSS">
                                                        <i class="zmdi zmdi-rss"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .product-info -->
                            </div><!-- .modal-product -->
                        </div><!-- .modal-body -->
                    </div><!-- .modal-content -->
                </div><!-- .modal-dialog -->
            </div>