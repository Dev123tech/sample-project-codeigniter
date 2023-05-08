 <!-- Shop Tab Content Start -->
                    <div class="tab-content jump">
                        <?php 
                            if(count($products)>0){
                               ?>
                        <div class="tab-pane <?php echo $viewtype; ?> active">
                        	<?php
                        		if($viewtype == 'grid'){ echo "<div class='row responsive-md-class'>";  }
                                foreach ($products as $row) 
                                {
                                    echo $this->html_model->product_box($row,'list', '1');
                                }
                                if($viewtype == 'grid'){ echo "</div>";  }
                                ?>    
                        </div>
                        <!-- Tab Two End -->
                        <?php   }else{ ?> 
                        <h4 class="text-center alert alert-danger">No Record Found!</h4>
                        <?php } ?>
                    </div>
                    <!-- Shop Tab Content End -->
                    <!--  Pagination Area Start -->
                    <div class="pro-pagination-style text-center mb-60px mt-30px">
                        <?php echo $this->ajax_pagination->create_links(); ?>
                    </div>
<!-- /Pagination -->
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