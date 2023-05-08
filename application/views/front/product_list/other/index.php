<div class="offcanvas-overlay"></div>
<!-- Breadcrumb Area Start -->
 <?php include 'sidebar.php'; ?>
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li><?php  
                        if($product_type == 'todays_deal')
                        {
                            echo translate('todays_deal');
                        }
                        else
                        {
                            if($cur_category > 0)
                            {
                                echo ucwords($this->db->get_where('category', array('category_id'=>$cur_category))->row()->category_name);
                                if($cur_sub_category > 0)
                                {
                                    echo '<li>'.ucwords($this->db->get_where('sub_category', array('sub_category_id'=>$cur_sub_category))->row()->sub_category_name).'</li>';
                                }
                            }
                            elseif($cur_brand > 0)
                            {
                                echo ucwords($this->db->get_where('brand', array('brand_id'=>$cur_brand))->row()->name);
                            }
                            else
                            {
                                echo $text;
                            }
                        }
                        ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="shop-Col di Bacche-area mt-30px shop-category-area" id="result">
</div>
<script>
    $('.remove-filter').on('click',function(){
        location.reload();
    });
    $(document).ready(function(e) {
        close_sidebar();
    });
    function open_sidebar(){
        $('.sidebar').removeClass('close_now');
        $('.sidebar').addClass('open');
    }
    function close_sidebar(){
        $('.sidebar').removeClass('open');
        $('.sidebar').addClass('close_now');
    }
</script>