<!--CONTENT CONTAINER-->
<style type="text/css">
    .admin_eve_view .inner-div{
        padding: 0 !important;
    }
</style>
<h4 class="modal-title text-center padd-all"><?php echo translate('details_of');?> <?php echo $admin_events_data->presenter_name; ?></h4>
	<hr style="margin: 10px 0 !important;">
    <div class="row">
    <div class="col-md-12">
        <div class="text-center pad-all">
            <div class="col-md-4 admin_eve_view">
                <div class="col-md-12">
                    <?php 
                        $images = explode(",",$admin_events_data->image);
                        // print_r($images);
                        if($images){
                            foreach ($images as $row1){
                    ?>
                        <div class="inner-div">
                            <img class="img-responsive" src="<?php echo base_url(); ?>uploads/events_image/<?php echo $row1; ?> "alt="User_Image" >
                        </div>
                    <?php 
                            }
                        } 
                    ?>
                </div>
                <div class="col-md-12" style="text-align:justify;">
                    <p><?php  echo $admin_events_data->presenter_bio;?></p>
                </div>

                <div class="col-md-12">
                    <?php 
                        $images = explode(",",$admin_events_data->banner_image);
                        // print_r($images);
                        if($images){
                            foreach ($images as $row1){
                    ?>
                        <div class="inner-div">
                            <img class="img-responsive" src="<?php echo base_url(); ?>uploads/events_image/<?php echo $row1; ?> "alt="User_Image" >
                        </div>
                    <?php 
                            }
                        } 
                    ?>
                </div>

            </div>
            <div class="col-md-8">   
                <table class="table table-striped" style="border-radius:3px;">
                    <tr>
                        <th class="custom_td"><?php echo translate('presenter_name');?></th>
                        <td class="custom_td"><?php echo $admin_events_data->presenter_name; ?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('Vendor_name');?></th>
                        <td class="custom_td"><?php echo $admin_events_data->vendor; ?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('youtube_id');?></th>
                        <td class="custom_td"><?php echo $admin_events_data->youtube_id; ?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('youtube_password');?></th>
                        <td class="custom_td"><?php echo $admin_events_data->youtube_password; ?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('choose_product');?></th>
                        <td class="custom_td">
                            <?php 
                                $product_arr = explode(",", $admin_events_data->choose_product);
                                foreach ($product_arr as $key => $value) 
                                {
                                    $products_name[] = $this->db->get_where('product',array('product_id'=>$value))->row()->title;
                                }
                                echo $product  = implode(",",$products_name);
                            ?>
                            
                        </td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('status');?></th>
                        <td class="custom_td"><?php echo ucwords($admin_events_data->status); ?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('video_link');?></th>
                        <td class="custom_td"><?php echo $admin_events_data->video_link; ?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('date');?></th>
                        <td class="custom_td"><?php echo $admin_events_data->date; ?></td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('start_time');?></th>
                        <td class="custom_td">
                            <?php 
                                if($admin_events_data->start_time >= '12:00:00')
                                    {  
                                        echo $admin_events_data->start_time." pm"; 
                                    }
                                else{  
                                        echo $admin_events_data->start_time." am"; 
                                    } 
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th class="custom_td"><?php echo translate('end_time');?></th>
                        <td class="custom_td">
                            <?php 
                                if($admin_events_data->end_time >= '12:00:00')
                                    {  
                                        echo $admin_events_data->end_time." pm"; 
                                    }
                                else{  
                                        echo $admin_events_data->end_time." am"; 
                                    } 
                            ?>
                        </td>
                    </tr>
                    
                    
                    <?php
                        if(!empty($all_af)){
                            foreach($all_af as $row1){
                    ?>
                    <tr>
                        <th class="custom_td"><?php echo $row1['name']; ?></th>
                        <td class="custom_td"><?php echo $row1['value']; ?></td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>
            </div>
            <hr>
        </div>
    </div>
</div>				


            
<style>
.custom_td{
border-left: 1px solid #ddd;
border-right: 1px solid #ddd;
border-bottom: 1px solid #ddd;
}
</style>

<script>
	$(document).ready(function(e) {
		proceed('to_list');
	});
</script>