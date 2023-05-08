<div class="panel-body" id="demo_s">
    <table id="demo-table" class="table table-striped"  data-pagination="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" >
        <thead>
            <tr>
                <th><?php echo translate('no');?></th>
                <th><?php echo translate('name');?></th>
                <th><?php echo translate('amount');?></th>
                <th><?php echo translate('bank_name');?></th>
                <th><?php echo translate('account_name');?></th>
                <th><?php echo translate('bank_account_number');?></th>
                <th><?php echo translate('bsb_number');?></th>
                <th><?php echo translate('status');?></th>
                
                

                <th class="text-right"><?php echo translate('options');?></th>
            </tr>
        </thead>				
        <tbody >
        <?php
            $i = 0;
            foreach($all_transaction as $row){
                $i++;
        ?>                
        <tr>
            <td>
                <?php echo $i ;
                    $user_name =$this->db->get_where('user',array('user_id'=>$row['user_id']))->row()->username;
                    $bank_name =$this->db->get_where('user',array('user_id'=>$row['user_id']))->row()->bank_name;
                    $account_name =$this->db->get_where('user',array('user_id'=>$row['user_id']))->row()->account_name;
                    $bank_account_number =$this->db->get_where('user',array('user_id'=>$row['user_id']))->row()->bank_account_number;
                    $bsb_number =$this->db->get_where('user',array('user_id'=>$row['user_id']))->row()->bsb_number;
                ?>                
            </td>
           
            <td><?php echo $usernme = ucwords($user_name);
                ?></td>
            <td><?php echo ucwords($row['amount']); ?></td>
            <td><?php echo ucwords( $bank_name); ?></td>
            <td><?php echo ucwords($account_name); ?></td>
            <td><?php echo $bank_account_number; ?></td>
            <td><?php echo $bsb_number; ?></td>   
            <td>
            	<div class="label label-<?php if($row['status'] == 'paid'){ ?>purple<?php } else { ?>danger<?php } ?>">
                	<?php echo $row['status']; ?>
                </div>
            </td>
            <td class="text-right">
               
               <a class="btn btn-info btn-xs btn-labeled fa fa-dollar" data-toggle="tooltip" 
                    onclick="ajax_modal('pay_form','<?php echo translate('pay_user'); ?>','<?php echo translate('paid_successfully!'); ?>','user_pay','<?php echo $row['transaction_id']; ?>')" data-original-title="View" data-container="body" <?php if($row['status'] == 'paid'){ ?> disabled <?php }?>>
                        <?php echo translate('pay');?>
                </a>
               
            </td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>
