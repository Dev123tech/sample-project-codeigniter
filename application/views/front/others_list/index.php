<div class="offcanvas-overlay"></div>
<!-- Breadcrumb Area Start -->
<?php include 'sidebar.php'; ?>
 <input type="hidden" value="<?php echo $product_type; ?>" id="type" />
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li> All 
                        <?php
                        if($product_type == 'todays_deal')
                        {
                            echo translate('todays_deal');
                        }
                        else
                        {
                            echo "Popular";
                        }
                        ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="shop-Col di Bacche-area mt-30px shop-category-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Shop Top Area Start -->
                <div class="shop-top-bar d-flex">
                    <!-- Left Side start -->
                    <div class="shop-tab nav d-flex">
                        <a  href="#" class="grid" onClick="set_view('grid')"><i class="fa fa-th"></i></a>
                        <a class="active list" onClick="set_view('list')" href="#"><i class="fa fa-list"></i></a>
                        <p>There Are 12 Products.</p>
                    </div>
                    <!-- Left Side End -->
                    <!-- Right Side Start -->
                    <div class="select-shoing-wrap d-flex">
                        <div class="shot-product shotvariety">
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
                                <option value="">Sort by newness</option>
                                <option value="a_to_z">A to Z</option>
                                <option value="z_to_a">Z to A</option>
                                <option value="">ABV</option>
                                <option value="">Cashback</option>
                                <option value="discount">Discount</option>
                                <option value="limited_release">Limited Release</option>
                                <option value="">Year(Wine)</option>
                            </select>
                        </div>
                    </div>
                    <!-- Right Side End -->
                </div>
                <!-- Shop Top Area End -->
                <!-- Shop Bottom Area Start -->
                <div class="shop-bottom-area mt-35" id="result">
                </div>
                <!-- Shop Bottom Area End -->
            </div>
        </div>
    </div>
</div>
<script>
    function product_by_type(type){ 
        var top = Number(200);
        var loading_set = '<div style="text-align:center;width:100%;height:'+(top*2)+'px; position:relative;top:'+top+'px;"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></div>';
        $("#page_content").html(loading_set);
        $("#page_content").load("<?php echo base_url()?>home/product_by_type/"+type);
    }
    $(document).ready(function(){
        var product_type=$('#type').val();
        product_by_type(product_type);
    });
</script>