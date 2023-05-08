<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Wallet_model extends CI_Model
{
    /*	
	 *	Developed by: Active IT zone
	 *	Date	: 14 July, 2015
	 *	Active Supershop eCommerce CMS
	 *	http://codecanyon.net/user/activeitezone
	 */
	 
    function __construct()
    {
        parent::__construct();
    }

    function user_balance($id=''){
        if($this->session->userdata('user_login') == 'yes' || $this->session->userdata('admin_login') == 'yes'){ 
            if($id == ''){
                $id = $this->session->userdata('user_id');
            }
            $balance = base64_decode($this->db->get_where('user',array('user_id'=>$id))->row()->wallet);
            $earn =  $this->db->get_where('general_settings',array('type' => 'earn'))->row()->value;
            $refered_count = 0;
            $updateamount = 0;
            $refers = $this->db->get('refer')->result_array();
            foreach ($refers as $row) 
            {
                if($row['user_id'] == $id)
                {
                    $check_id = $this->db->get_where('user',array('email'=>$row['refer_email']))->row()->user_id;
                    $order_buyer = $this->db->get_where('sale',array('buyer'=>$check_id))->row()->buyer;
                   
                    if($row['status']=="Joined" && $order_buyer)
                    {   
                       $refered_count = ($count++) + $refered_count ;
                       $updateamount =   $refered_count*$earn ;
                    }
                }  
            }
            if($balance == ''){
                return '0';
            } else {
                return $balance+$updateamount;
            }
        }
    }

    function add_user_balance($amount,$id=''){
        if($this->session->userdata('user_login') == 'yes' || $this->session->userdata('admin_login') == 'yes'){ 
            if($id == ''){
                $id = $this->session->userdata('user_id');
            }
            $balance = base64_decode($this->db->get_where('user',array('user_id'=>$id))->row()->wallet);
            $new_balance = base64_encode($balance+$amount);
            //echo $new_balance;
            $this->db->where('user_id',$id);
            $this->db->update('user',array('wallet'=>$new_balance));
            return $new_balance;
        }
    }

    function reduce_user_balance($amount,$id=''){
        if($this->session->userdata('user_login') == 'yes' || $this->session->userdata('admin_login') == 'yes'){ 
            if($id == ''){
                $id = $this->session->userdata('user_id');
            }
            $balance = base64_decode($this->db->get_where('user',array('user_id'=>$id))->row()->wallet);
            $new_balance = base64_encode($balance-$amount);
            $this->db->where('user_id',$id);
            $this->db->update('user',array('wallet'=>$new_balance));
            return $new_balance;
        }
    }
	
}






