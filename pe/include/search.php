<div class="header-search f-left">
    <div class="header-search-inner">
       <button class="search-toggle">
        <i class="zmdi zmdi-search"></i>
       </button>
        <form action="#">
            <div class="top-search-box">
                <input type="text" id="term" placeholder="Chercher votre produit ici...">
                <button type="submit" onclick="searchProduct( <?php echo $articlesPage; ?>, '<?php echo $fam; ?>', '<?php echo $categ; ?>')">
                    <i class="zmdi zmdi-search"></i>
                </button>
            </div>
        </form> 
    </div>
</div>