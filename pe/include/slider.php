
        <div class="slider-area  plr-185  mb-80">
            <div class="container-fluid">
                <div class="slider-content">
                    <div class="row">
                        <div class="active-slider-1 slick-arrow-1 slick-dots-1">
                            <?php
                                define('IMAGEPATH', 'img\slider\slider-1/');
                                foreach(glob(IMAGEPATH.'*') as $filename){                                    
                            ?>        
                                    <!-- layer-1 Start -->
                                    <div class="col-md-12">
                                                <img src="<?php echo $filename; ?>" alt="" style="width:100%;height:auto;">
                                    </div>
                                    <!-- layer-1 end -->
                            <?php        
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>