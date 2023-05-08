<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<section id="profile-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mob_padding">
                <div class="information-title">Taste Note <ion-icon name="add-circle-sharp" data-toggle="modal" data-target="#exampleModal"></ion-icon></div>
                <div class="contacttable ordertable">
                    <table class="table table-dark table-stripped table-hover table-responsive">
                        <thead>
                            <th class="th_width">#</th>
                            <th class="th_align_left">Product</th>
                            <th class="th_align_left">Taste Note</th>
                            <th class="th_align_left">Food Paring</th>
                            <th>Private/Public</th>
                            <th>Action</th>
                        </thead>
                        <?php 
                            $i=1;
                            foreach ($sticky_data as $row) 
                            {
                                $product_name = $this->db->get_where('product',array('product_id'=>$row['product_id']))->row()->title;
                        ?>
                        <tbody>
                            <tr>
                                <td><?php if($i>0){ echo $i; } ?></td>
                                <td class="th_align_left"><?php echo ucwords($product_name); ?></td>
                                <td class="th_align_left"><?php echo ucwords($row['note']); ?></td>
                                <td class="th_align_left">
                                    <?php 
                                        $food_paring = json_decode($row['food_paring']);
                                        if($food_paring->food_name1 !=NULL)
                                        {
                                           echo $food_paring->food_name1;
                                        }
                                        if($food_paring->food_name2 !=NULL)
                                        {
                                            echo ($food_paring->food_name1) ? ', '.$food_paring->food_name2 : $food_paring->food_name2;
                                        }
                                        if($food_paring->food_name3 !=NULL)
                                        {
                                            echo ($food_paring->food_name2) ? ', '.$food_paring->food_name3 : $food_paring->food_name3;
                                        }
                                        if($food_paring->food_name4 !=NULL)
                                        {
                                            echo ($food_paring->food_name3) ? ', '.$food_paring->food_name4 : $food_paring->food_name4;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <div class="switchkey">
                                        <label class="switch change_status_sticky" data-stickid="<?php echo $row['sticky_id']; ?>" data-status="<?php echo $row['status']; ?>">
                                        <input type="checkbox" name="status" <?php if($row['status'] == 'public'){ echo "checked"; } ?>>
                                        <span class="slider round"></span>
                                        </label>
                                    </div>
                                </td>
                                <td class="total">
                                    <a href="javascript:void(0);" class="close float-none remove_sticky" data-stickyid="<?php echo $row['sticky_id']; ?>">
                                        <ion-icon name="trash-sharp"></ion-icon>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                        <?php
                            $i++;
                            }
                        ?>
                    </table>
                </div>
                <button type="button" class="btn btngra d-none" data-toggle="modal" data-target="#exampleModal">Add New</button>
                <div class="modal fade sliderpop" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Taste Note</h4>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="modal-body">
                                <section class="events_pop">
                                    <div class="container">
                                        <?php
                                            echo form_open(base_url() . 'home/profile/sticky_add/', array('method' => 'post','class'=>'add_sticky_note'));
                                        ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select name="product_id" id='all_product' class="form-control" >
                                                        <option value="">Select...</option>
                                                    <?php
                                                        $result = $this->db->get_where('product', array('status'=>'ok'))->result_array();
                                                        foreach($result as $row)
                                                        {
                                                            ?>
                                                        <option value='<?php echo $row['product_id']; ?>'><?php echo $row['title']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="get_food_var"></div>
                                                </div>
                                                
                                                <div class="col-md-12 events_pop">
                                                    <textarea class="form-control required" rows="2" name="note" placeholder="Type your Taste Note here" required></textarea>
                                                </div>
                                                <div class="col-md-2 col-12 sta_event">
                                                    <span>Status</span>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <p>Private</p>
                                                </div>
                                                <div class="col-md-2 col-4 switchkey">
                                                    <label class="switch">
                                                    <input type="checkbox" name="status" value="public" >
                                                    <span class="slider round"></span>
                                                    </label>
                                                </div>
                                                <div class="col-md-2 col-4">
                                                    <p>Public</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="btn btngra" type="submit"><?php echo translate('save');?></button>
                                                </div>
                                            </div>
                                        <?php echo form_close() ; ?>     
                                    </div>
                            </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<script>
    $("#all_product").select2({width: 'resolve'});
    $('#all_product').on("select2:select", function (e) 
    { 
        var html = "";
        var select_val = $(e.currentTarget).val();
        $.ajax({
            url: base_url+"home/sticky_products",
            method:"POST",
            data:{'select_val':select_val},
            dataType:"json",
            success:function(data)
            {
                if((data.food_name1 != 'NULL')&&(data.food_name1))
                {
                     html += '<label><input type="checkbox" name="food_name1" class="select_one" value="'+data.food_name1+'">'+data.food_name1+'</label>';
                }
                if((data.food_name2 != 'NULL')&&(data.food_name2))
                {
                     html += '<label><input type="checkbox" name="food_name2" class="select_one" value="'+data.food_name2+'">'+data.food_name2+'</label>';
                }
                if((data.food_name3 != 'NULL')&&(data.food_name3))
                {
                     html += '<label><input type="checkbox" name="food_name3" class="select_one" value="'+data.food_name3+'">'+data.food_name3+'</label>';
                }
                if((data.food_name4 != 'NULL')&&(data.food_name4))
                {
                     html += '<label><input type="checkbox" name="food_name4" class="select_one" value="'+data.food_name4+'">'+data.food_name4+'</label>';
                }
                $('.get_food_var').html(html);
            }
        });    
    });
</script> 
