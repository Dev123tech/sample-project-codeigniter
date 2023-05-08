<?php
	echo $status; 

	$order_id =  array("657316", "4429582"); 
	$data = array(
            "api_key" =>"p6RertCvahmbQm28Byky",
            "order_id" => $order_id
        );
    $url = 'http://www.ishipping.com.au/API/V1/php/Rate/order_status.php';
    $postdata = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $result = curl_exec($ch);
    
    curl_close($ch);

    echo $result;



	if($status == 'done')
	{
?>
	<table class="table">
<?php
		foreach ($delivery_status as $row) 
		{
			if($row['delivery_time'] == '')
			{
				$delivery_time = $sale_datetime;
			}
			else
			{
				$delivery_time = $row['delivery_time'];
			}
            if(isset($row['admin']))
            {
            	$status_updated_on = date('d m, Y h:i:s A',$delivery_time);
            	$from = $this->crud_model->provider_detail('admin','','with_link');
            	$delivery_status_p = $row['status'];
            	$delivery_status_c = '('.$row['comment'].')';
			}
			else
			{
            	$status_updated_on = date('d m, Y h:i:s A',$delivery_time);
            	$from = $this->crud_model->provider_detail('vendor',$row['vendor'],'with_link');
            	$delivery_status_p = $row['status'];
            	$delivery_status_c = '('.$row['comment'].')';
			}
?>
		<tr>
			<td>
				<b><?php echo translate('order_from'); ?> : </b> <?php echo $from; ?><br><br>
				<b><?php echo translate('delivery_status'); ?> : </b> <?php echo translate($delivery_status_p); ?> <?php echo $delivery_status_c; ?><br><br>
				<b><?php echo translate('status_updated_on'); ?> : </b> <?php echo $status_updated_on; ?>
			</td>
		</tr>

<?php
		}
?>
	</table>	
<?php
	}
	else
	{
		echo translate('wrong_order_id!');
	}
?>