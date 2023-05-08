<?php
	foreach($user_info as $row)
	{
    ?>

      <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                    <div class="profileimg">
                        <img src="<?php 
                                if($row['profile_image'] != NULL){ 
                                    echo base_url('uploads/user_image/'.$row['profile_image']);
                                } else if(empty($row['fb_id']) !== true){ 
                                    echo 'https://graph.facebook.com/'. $row['fb_id'] .'/picture?type=large';
                                } else if(empty($row['g_id']) !== true ){
                                    echo $row['g_photo'];
                                } else {
                                    echo base_url().'uploads/user_image/default.jpg';
                                } 
                            ?>">
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="profileinformation">
                        <h4><?php echo ucwords($row['username']);?></h4>
                        <h5>
                            <?php 
                                if($row['city'])
                                    { echo ucwords($row['city'].", ");
                                }
                                if($row['state'])
                                    { echo ucwords($row['state'].", ");
                                }
                                if($row['country'])
                                    { echo ucwords($row['country']);
                                }
                            ?>
                        </h5>
                        <div class="contactinformation">
                            <ul>
                                <li>
                                    <ion-icon name="mail"></ion-icon> <span><?php echo $row['email'];?></span>
                                </li>
                                <li>
                                    <ion-icon name="phone-landscape"></ion-icon> <span><?php echo $row['phone'];?></span>
                                </li>
                                <li>
                                    <ion-icon name="map"></ion-icon> <span><?php echo ucwords($row['address1']);?><?php 
                                                                    if($row['address2'])
                                                                        { echo ", ".ucwords($row['address2']).", ";
                                                                    }
                                                                    if($row['country'])
                                                                        { echo ucwords($row['country']);
                                                                    }
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
      <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 project-tab">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo translate('purchase_summary');?></a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo translate('others_info');?></a>
                                <a class="nav-item nav-link d-none" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"><?php echo translate('package_info');?></a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="contacttable">
                                    <table class="table table-dark table-stripped table-hover">
                                        <tbody>
                                            <tr>
                                                <td><?php echo translate('total_purchase');?></td>
                                                <td><?php echo currency($this->crud_model->user_total(0)); ?></td>
                                                </tr>
                                                <tr>
                                                <td><?php echo translate('last_7_days');?></td>
                                                <td><?php echo currency($this->crud_model->user_total(7)); ?></td>
                                                    </tr>
                                                    <tr>
                                                <td><?php echo translate('last_30_days');?></td>                                                
                                                <td><?php echo currency($this->crud_model->user_total(30)); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="contacttable">
                                    <table class="table table-dark table-stripped table-hover">
                                        <tbody>
                                            <tr>
                                                <td><?php echo translate('wished_products');?></td>
                                                <td><?php echo $this->crud_model->user_wished();?></td>
                                                </tr>
                                                <tr>
                                                <td><?php echo translate('user_since');?></td>
                                                <td><?php echo date('d M, Y',$row['creation_date']); ?></td>
                                                    </tr>
                                                    <tr>
                                                <td><?php echo translate('last_login');?></td>
                                            <td><?php echo date('d M, Y',$row['last_login']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                           
                            </div>
                            <div class="tab-pane fade d-none" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="contacttable">
                                    <table class="table table-dark table-stripped table-hover">
                                        <tbody>
                                            <tr>
                                                <td><?php echo translate('remaining_upload_amount');?></td>
                                                <td><?php echo $this->db->get_where('user', array('user_id' => $this->session->userdata('user_id')))->row()->product_upload; ?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo translate('current_package');?></td>
                                                <td><?php if ($row['package_info'] == "[]" || $row['package_info'] == "") { echo translate('default'); } else { echo $package_info[0]['current_package'];}?></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo translate('payment_type');?></td>
                                                <td><?php if ($row['package_info'] == "[]" || $row['package_info'] == "") { echo translate('none'); } else { echo $package_info[0]['payment_type'];}?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
            
            </div>
        </div>
      </section>




    <?php
	}
?> 
<script type="text/javascript">
	function abnv(thiss){
		$('#savepic').hide();
		$('#inppic').hide();
		$('#'+thiss).show();
	}
	function change_state(va){
		$('#state').val(va);
	}

	$('.user-profile-img').on('mouseenter',function(){
		//$('.pic_changer').show('fast');
	});

	//$('.set_image').on('click',function(){
	//    $('#imgInp').click();
	//});

	$('.user-profile-img').on('mouseleave',function(){
		if($('#state').val() == 'normal'){
			//$('.pic_changer').hide('fast');
		}
	});
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$('#blah').css('backgroundImage', "url('"+e.target.result+"')");
				$('#blah').css('backgroundSize', "cover");
			}
			reader.readAsDataURL(input.files[0]);
			abnv('savepic');
			change_state('saving');
		}
	}

	$("#imgInp").change(function() {
		readURL(this);
	});
	
	
	window.addEventListener("keydown", checkKeyPressed, false);
	 
	function checkKeyPressed(e) {
		if (e.keyCode == "13") {
			$(":focus").closest('form').find('.submit_button').click();
		}
	}
</script>