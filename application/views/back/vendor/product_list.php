<div class="panel-body" id="demo_s">
        <table id="demo-table" class="table table-striped"   data-pagination="true" data-show-refresh="true"  data-show-toggle="true" data-show-columns="true" data-search="true" >
        <thead>
            <tr>
                <th data-field="image" data-align="right" data-sortable="true">
                    <?php echo translate('image');?>
                </th>
                <th data-field="title" data-align="center" data-sortable="true">
                    <?php echo translate('product');?><br> Name
                </th>
                <th data-field="category" data-align="center" data-sortable="true">
                    <?php echo translate('category');?><br> 
                </th>
                <th data-field="sub-category" data-align="center" data-sortable="true">
                    <?php echo translate('sub');?><br> Category
                </th>
                <th data-field="variety" data-align="center" data-sortable="true">
                    <?php echo translate('variety');?>
                </th>
                <th data-field="whlsale_gst" data-align="center" data-sortable="true">
                    <?php echo translate('wholesale');?><br> (EXCL WET & GST)
                </th>
                <th data-field="whlsale_dmst" data-align="center" data-sortable="true">
                    <?php echo translate('wholesale');?><br> (INCL GST + WET)
                </th>
                <th data-field="rrp_au" data-align="center" data-sortable="true">
                    <?php echo translate('r_r_p');?> <br> (AUD) 
                </th>
                <th data-field="rrp_hk" data-align="center" data-sortable="true">
                    <?php echo translate('r_r_p');?> <br> (HKD) 
                </th>
                <th data-field="rrp_jp" data-align="center" data-sortable="true">
                    <?php echo translate('r_r_p');?> <br> (JP Yen)
                </th>
                <th data-field="rrp_sg" data-align="center" data-sortable="true">
                    <?php echo translate('r_r_p');?> <br> (SGD)
                </th>
                <th data-field="limited_release" data-sortable="true">
                    <?php echo translate('limited');?><br> release
                </th>
                 <th data-field="low_stock" data-sortable="true">
                    <?php echo translate('low_stock');?>
                </th>
               <!--   <th  data-field="remove" data-sortable="true">
                    <?php echo translate('remove');?>
                </th>
                <th data-field="publish" data-sortable="false">
                    <?php echo translate('publish');?>
                </th> -->
                <th data-field="options" data-sortable="false" data-align="right">
                    <?php echo translate('options');?>
                </th>
            </tr>
        </thead>
        <?php
        $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
        $products   = $this->db->get('product', $limit, $offset)->result_array();
            $data       = array();
            $time = date("H:i:s");
            foreach ($products as $row) 
            {
                
                if($row['remove'] == '0')
                {
                    if($row['num_of_imgs'] !=NULL)
                    {
                        $num_of_img = explode(",", $row['num_of_imgs']); 
                        $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                    }
                    else
                    {
                        $first_image = base_url('uploads/product_image/default.jpg');
                    }

                    ?>
                    <tr>
                        <td><img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="<?php echo $first_image.'?time='.strtotime($time); ?>"  /></td>
                        <td><?php echo ucwords($row['title']); ?></td>
                        <td>
                            <?php  
                                $cat_name = $this->db->get_where('category',array('category_id'=>$row['category']))->row()->category_name; 
                                echo ucwords($cat_name);
                            ?>
                        </td>
                        <td><?php $s_cat_name = $this->db->get_where('sub_category',array('sub_category_id'=>$row['sub_category']))->row()->sub_category_name;
                        echo ucwords($s_cat_name) ?></td>
                       
                        <td><?php echo ucwords($row['variety']); ?></td>
                        <td><?php echo $row['wholesale_EXCL_WET_GST']; ?></td>
                        <td><?php echo $row['wholesale']; ?></td>
                        <td><?php echo $row['sale_price_AU']; ?></td>
                        <td><?php echo $row['sale_price_HK']; ?></td>
                        <td><?php echo $row['sale_price_JP']; ?></td>
                        <td><?php echo $row['sale_price_SG']; ?></td>
                        <td><?php echo ucwords($row['limited_release']); ?></td>
                        <td><?php if($row['is_low_stock']) {       echo ucwords($row['is_low_stock']);    }; ?></td>
                        <td>
                            <a  class="btn btn-info btn-xs btn-labeled fa fa-location-arrow" data-toggle="tooltip" 
                                    onclick="ajax_modal('view','<?php echo translate('view_product'); ?>','<?php echo translate('successfully_viewed!'); ?>','product_view','<?php echo $row['product_id']; ?>');proceed('to_list');" data-original-title="View" data-container="body"><?php echo translate('view'); ?>
                                </a>
                                <a class="btn btn-success btn-xs btn-labeled fa fa-wrench" data-toggle="tooltip" 
                                    onclick="ajax_set_full('edit','<?php echo translate('edit_product'); ?>','<?php echo translate('successfully_edited!'); ?>','product_edit','<?php echo $row['product_id']; ?>');proceed('to_list');" data-original-title="Edit" data-container="body"><?php echo translate('edit'); ?>
                                </a>
                                <a class="btn btn-danger btn-xs btn-labeled fa fa-close" data-toggle="tooltip"
                                                onclick="ajax_modal('add_remove','<?php echo translate(''); ?>','<?php echo  translate('remove_product!'); ?>','add_remove','<?php echo $row['product_id']; ?>')" data-original-title="Edit" data-container="body">
                                            </a>
                        </td>
                    </tr>
                   <?php
               }
            }
            ?>
    </table>
</div>
<div id="vendr"></div>
    <div id='export-div' style="padding:40px;">
        <h1 id ='export-title' style="display:none;"><?php echo translate('products'); ?></h1>
        <table id="export-table" class="table" data-name='product_list' data-orientation='p' data-width='1500' style="display:none;">
                <colgroup>
                    <col width="50">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                </colgroup>
                <thead>
                    <tr>
                        <th><?php echo translate('image');?></th>
                        <th><?php echo translate('product');?> Name</th>
                        <th><?php echo translate('sub');?> Category</th>
                        <th><?php echo translate('variety');?></th>
                        <th><?php echo translate('wholesale');?> (EXCL WET & GST)</th>
                        <th><?php echo translate('wholesale');?> (INCL GST + WET)</th>
                        <th><?php echo translate('r_r_p');?>  (AUD) </th>
                        <th><?php echo translate('r_r_p');?>  (HKD) </th>
                        <th><?php echo translate('r_r_p');?>  (JP Yen)</th>
                        <th><?php echo translate('r_r_p');?>  (SGD)</th>
                        <th><?php echo translate('limited');?> release</th>
                        <th><?php echo translate('low_stock');?></th>
                    </tr>
                </thead>
                <tbody >
                <?php
                  
            foreach ($products as $row) 
            {
                if($row['remove'] == 1)
                {
                    if($row['num_of_imgs'] !=NULL)
                    {
                        $num_of_img = explode(",", $row['num_of_imgs']); 
                        $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                    }
                    else
                    {
                        $first_image = base_url('uploads/product_image/default.jpg');
                    }
                ?>
                <tr>
                    <td><?php echo $first_image.'?time='.strtotime($time); ?></td>
                        <td><?php echo ucwords($row['title']); ?></td>
                        <td><?php $s_cat_name = $this->db->get_where('sub_category',array('sub_category_id'=>$row['sub_category']))->row()->sub_category_name;
                        $res['sub-category'] = ucwords($s_cat_name) ?></td>
                        <td><?php echo ucwords($row['variety']); ?></td>
                        <td><?php echo $row['wholesale_EXCL_WET_GST']; ?></td>
                        <td><?php echo $row['wholesale']; ?></td>
                        <td><?php echo $row['sale_price_AU']; ?></td>
                        <td><?php echo $row['sale_price_HK']; ?></td>
                        <td><?php echo $row['sale_price_JP']; ?></td>
                        <td><?php echo $row['sale_price_SG']; ?></td>
                        <td><?php echo ucwords($row['limited_release']); ?></td>
                        <td><?php if($row['is_low_stock']) {       echo ucwords($row['is_low_stock']);    }; ?></td>         
                </tr>
                <?php
                    } }
                ?>
                </tbody>
        </table>
    </div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#events-table').bootstrapTable({
            /*
            onAll: function (name, args) {
                console.log('Event: onAll, data: ', args);
            }
            onClickRow: function (row) {
                $result.text('Event: onClickRow, data: ' + JSON.stringify(row));
            },
            onDblClickRow: function (row) {
                $result.text('Event: onDblClickRow, data: ' + JSON.stringify(row));
            },
            onSort: function (name, order) {
                $result.text('Event: onSort, data: ' + name + ', ' + order);
            },
            onCheck: function (row) {
                $result.text('Event: onCheck, data: ' + JSON.stringify(row));
            },
            onUncheck: function (row) {
                $result.text('Event: onUncheck, data: ' + JSON.stringify(row));
            },
            onCheckAll: function () {
                $result.text('Event: onCheckAll');
            },
            onUncheckAll: function () {
                $result.text('Event: onUncheckAll');
            },
            onLoadSuccess: function (data) {
                $result.text('Event: onLoadSuccess, data: ' + data);
            },
            onLoadError: function (status) {
                $result.text('Event: onLoadError, data: ' + status);
            },
            onColumnSwitch: function (field, checked) {
                $result.text('Event: onSort, data: ' + field + ', ' + checked);
            },
            onPageChange: function (number, size) {
                $result.text('Event: onPageChange, data: ' + number + ', ' + size);
            },
            onSearch: function (text) {
                $result.text('Event: onSearch, data: ' + text);
            }
            */
        }).on('all.bs.table', function (e, name, args) {
            //alert('1');
            //set_switchery();
        }).on('click-row.bs.table', function (e, row, $element) {
            
        }).on('dbl-click-row.bs.table', function (e, row, $element) {
            
        }).on('sort.bs.table', function (e, name, order) {
            
        }).on('check.bs.table', function (e, row) {
            
        }).on('uncheck.bs.table', function (e, row) {
            
        }).on('check-all.bs.table', function (e) {
            
        }).on('uncheck-all.bs.table', function (e) {
            
        }).on('load-success.bs.table', function (e, data) {
            set_switchery();
        }).on('load-error.bs.table', function (e, status) {
            
        }).on('column-switch.bs.table', function (e, field, checked) {
            
        }).on('page-change.bs.table', function (e, size, number) {
			
        }).on('search.bs.table', function (e, text) {
            
        });
    });

</script>

