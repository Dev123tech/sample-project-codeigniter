<?php 
    foreach ($query as $row1) 
    {
      $sale_price = $this->db->get_where('product',array('product_id'=>$row1['product_id']))->row()->bundle_sale1;

      if($row1['num_of_imgs'] !=NULL)
        {
            $num_of_img = explode(",", $row1['num_of_imgs']); 
            $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
        }
        else
        {
            $first_image = base_url('uploads/product_image/default.jpg');
        }
        ?>
    <tr>
        <td class="imgsize">
            <a class="media-link" href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>">
                <img width="100" src="<?php echo $first_image; ?>" alt=""/>
            </a>
        </td>
        <td class="pdngtop"><a href="<?php echo $this->crud_model->product_link($row1['product_id']); ?>"><?php echo ucwords($row1['title']); ?></a></td>
        <td class="pdngtop"><?php echo currency($sale_price); ?></td>
        <?php if($row1['current_stock'] > 0 ){ ?>
        <td class="pdngtop"><span>In Stock</span></td>
        <td><button type="button" data-toggle="modal" data-target="#wishlistmodal<?php echo $row1['product_id']; ?>" class="btn wishbtn">Add To Cart</button></td>
      <?php } else { ?>
        <td class="pdngtop soldout"><span>Sold Out</span></td>
        <td><button type="button" data-toggle="modal" data-target="#exampleModal" class="btn wishbtn">Add To Cart</button></td>
      <?php } ?>
        
        
        <td class="pdngtop">
            <div  class="remove_from_wish" data-pid='<?php echo $row1['product_id']; ?>'><ion-icon name="trash-sharp"></ion-icon></div>
        </td>                  
    </tr>                                      
<?php 
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