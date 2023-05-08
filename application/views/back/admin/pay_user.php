
    <?php
        echo form_open(base_url() . 'admin/transaction/pay/'.$transactions->transaction_id, array(
            'class' => 'form-horizontal',
            'method' => 'post',
            'id' => 'user_pay',
            'enctype' => 'multipart/form-data'
        ));
    ?>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <td><?php echo translate('bank_name');?></td>
                        <td><?php echo $transactions->bank_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo translate('bank_account_number');?></td>
                        <td><?php echo $transactions->bank_account_number; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo translate('bsb_number');?></td>
                        <td><?php echo $transactions->bsb_number; ?></td>
                    </tr>
                </table>
            </div>

                <?php //echo currency('','def').$this->crud_model->total_sale($row['vendor_id']); ?>
            
            <div class="form-group">
                <label class="col-sm-4 control-label" for="demo-hor-1"><?php echo translate('amount');?> (<?php echo currency('','def'); ?>)</label>
                <div class="col-sm-6">
                    <input type="text" name="amount" value="<?php echo $transactions->amount; ?>" class="form-control totals" readonly>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button data-bb-handler="success" type="button" class="btn btn-purple">Pay</button>
            <button data-bb-handler="danger" type="button" class="btn btn-dark">Cancel</button>
        </div>

    </form>


<script type="text/javascript">

    $(document).ready(function() {
        $('.demo-chosen-select').chosen();
        $('.demo-cs-multiselect').chosen({width:'100%'});
        total();
    });

    function total(){
        var total = Number($('#quantity').val())*Number($('#rate').val());
        $('#total').val(total);
    }

    $(".totals").change(function(){
        total();
    });


    $(document).ready(function() {
        $("form").submit(function(e){
            //return false;
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.enterer').hide();
        $('.btn-dark').hide();


    });
</script>

<div id="reserve"></div>

