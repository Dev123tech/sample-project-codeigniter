<?php 
$earn_find =  $this->db->get_where('general_settings',array('type' => 'earn'))->row()->value;
    $i = 0;
    if($query)
    {
        foreach ($query as $value) 
        {    
            $i++;   
                $row = $value['detail'];
                $amount = ($row['amount']) ? $row['amount'] : $earn_find;

                $times = $row['date'];
                $timedate = strtotime($times)." ";
                $date = date('d M Y h:i:s A',$timedate);

                $date = $date ? $date : date('d M Y h:i:s A',$row['timestamp']); 
                $status = $row['status'];
               ?> 
                <tr>
                    <td><?php echo $i; ?></td>
                    <td class="price"><?php echo currency($amount); ?></td>
                    <td class="description"><?php echo $date; ?></td>
                    <td class="description"><?php echo $status; ?></td> 
                    <td class="total">
                        <span class="btn mainbutton" style="cursor:pointer;" data-toggle="modal" data-target="#walletmodal" onclick="wallet('<?php echo base_url(); ?>home/profile/wallet/info_view/<?php echo $row1['wallet_load_id']; ?>')" >
                        <?php echo translate('transaction_info');?>
                        </span>
                        <div class="modal fade" id="walletmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title h6 text-sm-center" id="myModalLabel">
                                        Select Product Type
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </td> 
                </tr>
        <?php
        } 
    }         
        ?>

<tr class="text-center" style="display:none;" >
    <td id="pagenation_set_links" ><?php echo $this->ajax_pagination->create_links(); ?></td>
</tr>
<!--/end pagination-->
<script>
    $(document).ready(function(){ 
        product_listing_defaults();
        $('.pagination_box').html($('#pagenation_set_links').html());
    });
</script>