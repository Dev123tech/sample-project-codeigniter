<div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Shop Top Area Start -->
                <div class="shop-top-bar d-flex">
                    <!-- Left Side start -->
                    <div class="shop-tab nav d-flex view_select_btn">
                        <a  href="#" class="active grid" onClick="set_view('grid')"><i class="fa fa-th"></i></a>
                        <a href="#" class="list" onClick="set_view('list')" ><i class="fa fa-list"></i></a>
                        <p style="display: none;">There Are <?php echo $count; ?> Products.</p>
                    </div>
                    <!-- Left Side End -->
                    <!-- Right Side Start -->
                    <div class="select-shoing-wrap d-flex">
                        <div class="shot-product shotvariety d-none">
                            <a href="#">Variety</a>
                        </div>
                        <div class="shot-product shotnew d-none">
                            <div class="header-menu  sticky-nav d-xl-block custommegamenu">
                                <div class="header-horizontal-menu">
                                    <ul class="menu-content">
                                        <li class="menu-dropdown">
                                            <a href="#">Category<i class="ion-ios-arrow-down"></i></a>
                                            <ul class="mega-menu-wrap row dropdown-menu newdrop">
                                                <?php
                                                $all_category = $this->db->get('category')->result_array();
                                                foreach($all_category as $row)
                                                {
                                                    if($this->crud_model->if_publishable_category($row['category_id']))
                                                    {
                                                        ?>
                                                <li class="maindrop">
                                                    <a class="dropdown-item" href="#">
                                                        <ion-icon name="play-forward-sharp"></ion-icon>
                                                        <?php echo $row['category_name']; ?>
                                                    </a>
                                                    <ul class="submenu dropdown-menu">
                                                        <?php
                                                            $sub_category = $this->db->get_where('sub_category',array('category'=>$row['category_id']))->result_array();
                                                            foreach($sub_category as $row1)
                                                            {
                                                        ?>
                                                        <li>
                                                            <a class="dropdown-item" href="">
                                                                <ion-icon name="play-forward-sharp"></ion-icon>
                                                                <?php echo $row1['sub_category_name']; ?>
                                                            </a>
                                                        </li>
                                                        <?php
                                                    }
                                                    ?>
                                                    </ul>
                                                </li>
                                                <?php }
                                                } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="shop-select">
                            <select class="input-price sorter_search" onChange="delayed_search()">
                                <option value="">Sort by new arrival</option>
                                <option value="price_high" <?php echo $sort_by == "price_high" ? "selected" : '' ?>>High To Low</option>
                                <option value="price_low" <?php echo $sort_by == "price_low" ? "selected" : '' ?>>Low To High</option>
                                <option value="brands" <?php echo $sort_by == "brands" ? "selected" : '' ?>>Brands</option>
                                <option value="a_to_z" <?php echo $sort_by == "a_to_z" ? "selected" : '' ?>>A to Z</option>
                                <option value="z_to_a" <?php echo $sort_by == "z_to_a" ? "selected" : '' ?>>Z to A</option>
                                <option value="product_year" <?php echo $sort_by == "product_year" ? "selected" : '' ?>>Year(Wine)</option>
                                <option value="product_abv" <?php echo $sort_by == "product_abv" ? "selected" : '' ?>>ABV</option>
                                <option value="cashback" <?php echo $sort_by == "cashback" ? "selected" : '' ?>>Cashback</option>
                                <option value="limited_release" <?php echo $sort_by == "limited_release" ? "selected" : '' ?>>Limited Release</option>
                                
                                <option value="">Promotion</option>
                            </select>
                        </div>
                    </div>
                    <!-- Right Side End -->
                </div>
                <!-- Shop Top Area End -->
                <!-- Shop Bottom Area Start -->
                <div class="shop-bottom-area mt-35">
                    <div class="tab-content jump">
                        <?php 

                            if(count($all_products)>0){
                               ?>
                        <div class="tab-pane <?php echo $viewtype; ?> active">
                        	<?php
                        		if($viewtype == 'grid'){ echo "<div class='row responsive-md-class'>";  }
                                
                                foreach ($all_products as $row) 
                                {
                                    echo $this->html_model->product_box1($row,$viewtype, '1',$other_data);
                                }
                                if($viewtype == 'grid'){ echo "</div>";  }
                                ?>    
                        </div>
                        <!-- Tab Two End -->
                        <?php   }else{ ?> 
                            <div class="pro_view">
                                <h4><span class="text-center">No Record Found.</span></h4>
                            </div>    
                        <?php } ?>
                    </div>
                   
                    <!--  Pagination Area Start -->
                    <div class="pro-pagination-style text-center mb-60px mt-30px">
                        <?php echo $this->ajax_pagination->create_links(); ?>
                    </div>
                    <!--  Pagination Area End -->
                </div>
                <!-- Shop Tab Content End -->
        </div>
    </div>
</div>    
<script>
$(document).ready(function(){
	set_product_box_height();
	$('[data-toggle="tooltip"]').tooltip();
});

function set_product_box_height(){
	var max_img = 0;
	$('.products .media img').each(function(){
        var current_height= parseInt($(this).css('height'));
		if(current_height >= max_img){
			max_img = current_height;
		}
    });
	$('.products .media img').css('height',max_img);
	
	var max_title=0;
	$('.products .caption-title').each(function(){
        var current_height= parseInt($(this).css('height'));
		if(current_height >= max_title){
			max_title = current_height;
		}
    });
	$('.products .caption-title').css('height',max_title);
}
</script>