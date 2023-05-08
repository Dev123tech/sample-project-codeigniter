<?php
    $check_amount = $this->wallet_model->user_balance();
    $user_id = $this->session->userdata('user_id');
    $bank_name = $this->db->get_where('user',array('user_id'=>$user_id))->row()->bank_name;
    $account_name = $this->db->get_where('user',array('user_id'=>$user_id))->row()->account_name;
    $bank_account_number = $this->db->get_where('user',array('user_id'=>$user_id))->row()->bank_account_number;
    $bsb_number = $this->db->get_where('user',array('user_id'=>$user_id))->row()->bsb_number;
    $agreed_check = $this->db->get_where('user',array('user_id'=>$user_id))->row()->agreed;
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<div class="row">
    <div class="col-sm-6">
        <div class="caption-inner div-cell ewalletblock">
            <div class="grand-totall">
                <h5>Current Balance <span><?php echo currency($this->wallet_model->user_balance()); ?></span></h5>
            </div>
         
        </div>
    </div>
    <div class="col-sm-6">
        <button type="button" class="btn drawlbtn" data-toggle="modal" onclick="myFunction()" data-target="<?php if($check_amount > 199){ ?>#exampleModal<?php } ?>">Withdrawal</button>
          <!--  <div class="information-title" style="padding-top: 10px;"> Withdrawal Money
                <ion-icon name="add-circle-sharp" data-toggle="modal" onclick="myFunction()" data-target="<?php if($check_amount > 199){ ?>#exampleModal<?php } ?>"></ion-icon>
            </div> -->
    </div>
    <div class="modal fade sliderpop" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Withdrawal Request</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-body">
                    <section class="events_pop">
                        <div class="container">
                            <?php
                                echo form_open(base_url() . 'home/profile/withdrawal_add/', array('method' => 'post','class'=>'add_bank_detail'));
                            ?>
                                <div class="row">

                                    <label class="col-sm-3 control-label"><?php echo translate('amount');?></label>
                                    <div class="col-md-8">
                                        <input type="text" style="height: 43px;" name="amount" value="<?php echo ucwords($enter_amount); ?>" class="form-control" onkeypress="isInputNumber(event)" id="amountpick" required>
                                        <span class="amount_error"></span>
                                    </div>

                                    <label class="col-sm-3 control-label"><?php echo translate('bank_name');?></label>
                                    <div class="col-md-8">
                                        <input type="text" style="height: 43px;" name="bank_name" value="<?php echo ucwords($bank_name); ?>" class="form-control" required>
                                    </div> 

                                    <label class="col-sm-3 control-label"><?php echo translate('account_name');?></label>
                                    <div class="col-md-8">
                                        <input type="text" style="height: 43px;" name="account_name" value="<?php echo ucwords($account_name); ?>" class="form-control" required>
                                    </div> 

                                    <label class="col-sm-3 control-label"><?php echo translate('bank_account_number');?></label>
                                    <div class="col-md-8">
                                        <input type="text" style="height: 43px;" name="bank_account_number" value="<?php echo $bank_account_number; ?>" class="form-control" onkeypress="isInputNumber(event)" required>
                                    </div> 

                                    <label class="col-sm-3 control-label"><?php echo translate('bsb_number');?></label>
                                    <div class="col-md-8">
                                        <input type="text" style="height: 43px;" name="bsb_number" value="<?php echo $bsb_number; ?>" class="form-control" onkeypress="isInputNumber(event)" required>
                                    </div> 

                                    <label>
                                        <input name="agreed" id="agreed"  type="checkbox" value="ok" <?php if($agreed_check=='ok'){ echo "checked"; } ?> > 
                                           <span class="agreed_error"> Are you agreed to bear the 3% of commission that will be deducted under ORP management charges and bank processing fee?
                                            </span>
                                    </label>

                                    <div class="col-md-6">
                                        <button class="btn btngra" id="submit-button" type="submit"><?php echo translate('submit');?></button>
                                    </div>
                                </div>
                            <?php echo form_close() ; ?>     
                        </div>
                </div>
                </section>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="information-title">
            <?php echo translate('your_wallet_history');?>
        </div>
        <div class="contacttable ordertable">
            <table class="table table-dark table-stripped table-hover table-responsive">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo translate('amount');?></th>
                        <th><?php echo translate('time');?></th>
                        <th><?php echo translate('details');?></th>
                        <th><?php echo translate('payment_info');?></th>
                    </tr>
                </thead>
                <tbody id="result6">
                </tbody>
            </table>
        </div>
        <input type="hidden" id="page_num6" value="0" />
        <div class="pagination_box pro-pagination-style text-center mb-60px mt-30px">
        </div>
        <script>    
            function isInputNumber(evt){
                var ch = String.fromCharCode(evt.which);
                if(!(/[0-9]/.test(ch))){
                    evt.preventDefault();
                }
            }    

            function wallet_listed(page){
                if(page == 'no'){
                    page = $('#page_num6').val();   
                } else {
                    $('#page_num6').val(page);
                }
                var alerta = $('#result6');
                alerta.html('<td colspan="5" align="center"><i class="fa fa-refresh fa-spin fa-3x fa-fw"></i></td>');
                alerta.load('<?php echo base_url();?>home/wallet_listed/'+page,
                    function(){
                        //set_switchery();
                    }
                );   
            }
            $(document).ready(function() {
                wallet_listed('0');
            });  
        </script>
    </div>
</div>
<script type="text/javascript">
	$('body').on('submit','.add_bank_detail', function(e) {
        var form = $(this);
        e.preventDefault(); // avoid to execute the actual submit of the form.
        if(!$('#agreed').is(":checked"))
        {
            $('.agreed_error').html("Are you agreed to bear the 3% of commission that will be deducted under ORP management charges and bank processing fee?").css('color','red');
        }
        else
        {
        	$.ajax({
            url: form.attr('action'),
            dataType: 'json',
            method: form.attr('method'),
            data: form.serialize(),
            success: function(result) 
            {
            	console.log(result);
                if(result == 'success')
                {	
                    $('#exampleModal').modal('hide');

                    setTimeout(function(){ 

                        $("#profile_content").html(loading_set);
                        $("#profile_content").load("<?php echo base_url()?>home/profile/wallet");
                        $(".pleft_nav").find("li").removeClass("active");
                        $(".pnav_wallet").find("li").addClass("active");
                        notify('Withdrawal Submitted Successfully','success','bottom','right');
                    },1000);    
                } 
                else
                {
                    notify('Not Withdrawal','warning','bottom','right');
                }
            },
            error: function(e) {
                console.log(e)
            }
        }); 
       }                 
    });
    $("#amountpick").on("change",function()
    {
        var getamount = document.getElementById("amountpick").value;
        var che_amount = <?php echo $check_amount ?>;

        //console.log(getamount);
        if (getamount < 200) 
        {
            $('.amount_error').html("Minimum withdrawal amount is $200").css('color','red');
            $('#submit-button').attr('disabled', 'disabled');
        }
        else if (getamount > che_amount) 
        {
            $('.amount_error').html("Not Enough Balance in your Wallet").css('color','red');
            $('#submit-button').attr('disabled', 'disabled');
        }
        else
        {
            $('.amount_error').html(" ");
            $('#submit-button').removeAttr('disabled');
        }
    });   

    function myFunction() {
      var amount = <?php echo $check_amount ?>;
      if (amount < 200) 
        {
            notify('Minimum withdrawal amount is $200','warning','bottom','right');
                    
        }
    }
</script>

