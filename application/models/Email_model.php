<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Email_model extends CI_Model
{
    
    /*	
	 *	Developed by    : Active IT zone
	 *	Date	        : 14 July, 2015
	 *	Active Supershop eCommerce CMS
	 *	http://codecanyon.net/user/activeitezone
     *  Last Modified   : 18 January, 2017 
	 */
    
    function __construct()
    {
        parent::__construct();
    }
    
    
    function password_reset_email($account_type = '', $id = '', $pass = '')
    {   
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
        //$this->load->database();
        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        
        $query  = $this->db->get_where($account_type, array($account_type . '_id' => $id));

        if ($query->num_rows() > 0){

            $sub    = $this->db->get_where('email_template', array('email_template_id' => 1))->row()->subject;
            $to     = $query->row()->email;
			if($account_type == 'user'){
				$to_name	= $query->row()->username;
			}else{
				$to_name	= $query->row()->name;
			}
			$email_body      = $this->db->get_where('email_template', array('email_template_id' => 1))->row()->body;
			$email_body      = str_replace('[[to]]',$to_name,$email_body);
			$email_body      = str_replace('[[account_type]]',$account_type,$email_body);
			$email_body      = str_replace('[[password]]',$pass,$email_body);
			$email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
			
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
			if($background !== 'style_1'){
				$final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
				$final_email = str_replace('[[body]]',$email_body,$final_email);
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
			}else{
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
			}
			
            return $send_mail;
        } 
        else {
            return false;
        }
    }
    function status_email($account_type = '', $id = '')
    {
        //$this->load->database();
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';

        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        if($account_type == 'vendor'){
            $password    = $this->db->get_where('vendor',array('vendor_id'=>$id))->row()->password;
        }

        $query = $this->db->get_where($account_type, array($account_type . '_id' => $id));
        $url        = "<a href='".base_url()."vendor/'>".base_url()."vendor</a>";
		if ($query->num_rows() > 0) {
            $sub        = $this->db->get_where('email_template', array('email_template_id' => 2))->row()->subject;
            $to         = $query->row()->email;
			if($account_type == 'user'){
				$to_name	= $query->row()->username;
			}else{
				$to_name	= $query->row()->name;
			}
            
			if($query->row()->status == 'approved'){
                $status = "Approved";
            } else {
                $status = "Postponed";
            }
			$email_body      = $this->db->get_where('email_template', array('email_template_id' => 2))->row()->body;
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
			$email_body      = str_replace('[[to]]',$to_name,$email_body);
			$email_body      = str_replace('[[account_type]]',$account_type,$email_body);
            $email_body      = str_replace('[[email]]',$to,$email_body);
			$email_body      = str_replace('[[password]]',$password,$email_body);
			$email_body      = str_replace('[[status]]',$status,$email_body);
			$email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[url]]',$url,$email_body);
			
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
			if($background !== 'style_1'){
				$final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
				$final_email = str_replace('[[body]]',$email_body,$final_email);
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
			}else{
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
			}
			
            return $send_mail;
        }
        else {
            return false;
        }
    }

    
    
    function membership_upgrade_email($vendor)
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
        //$this->load->database();
        $account_type = 'vendor';

        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        
        
        $query = $this->db->get_where($account_type, array($account_type . '_id' => $vendor));
		
		if ($query->num_rows() > 0) {
            $sub        = $this->db->get_where('email_template', array('email_template_id' => 3))->row()->subject;
            $to         = $query->row()->email;
			
			$to_name	= $query->row()->name;
			
			if($query->row()->membership == '0'){
                $package    = "reduced to : Default";
            } 
            else {
                $package    = "upgraded to : " . $this->db->get_where('membership',array('membership_id'=>$query->row()->membership))->row()->title;
            }
			$email_body      = $this->db->get_where('email_template', array('email_template_id' => 3))->row()->body;
			$email_body      = str_replace('[[to]]',$to_name,$email_body);
			$email_body      = str_replace('[[account_type]]',$account_type,$email_body);
			$email_body      = str_replace('[[email]]',$to,$email_body);
			$email_body      = str_replace('[[package]]',$package,$email_body);
			$email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
			
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
			if($background !== 'style_1'){
				$final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
				$final_email = str_replace('[[body]]',$email_body,$final_email);
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
			} else {
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
			}
			
            return $send_mail;
        }
        else {
            return false;
        }
    }

    function vendor_payment($vendor,$amount)
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
        //$this->load->database();
        $account_type = 'vendor';

        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        
        
        $query = $this->db->get_where($account_type, array($account_type . '_id' => $vendor));
        
        if ($query->num_rows() > 0) {
            $sub        = $this->db->get_where('email_template', array('email_template_id' => 3))->row()->subject;
            $to         = $query->row()->email;
            
            $to_name    = $query->row()->name;
            
            $email_body      = $this->db->get_where('email_template', array('email_template_id' => 9))->row()->body;
            $email_body      = str_replace('[[to]]',$to_name,$email_body);
            $email_body      = str_replace('[[vendor_name]]',$vendor_name,$email_body);
            $email_body      = str_replace('[[amount]]',$amount,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
            
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
            if($background !== 'style_1'){
                $final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
                $final_email = str_replace('[[body]]',$email_body,$final_email);
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
            } else {
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
            }
            
            return $send_mail;
        }
        else {
            return false;
        }
    }

    function membership_upgrade_email_to_admin($vendor)
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
        //$this->load->database();
        $account_type = 'vendor';

        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        
        
        $query = $this->db->get_where($account_type, array($account_type . '_id' => $vendor));
        
        if ($query->num_rows() > 0) {
            $sub        = $this->db->get_where('email_template', array('email_template_id' => 8))->row()->subject;
            $to = $this->db->get_where('general_settings', array('type' => 'contact_email'))->row()->value;
            
            $vendor_name    = $query->row()->name;
            
            if($query->row()->membership == '0'){
                $package    = "reduced to : Default";
            } 
            else {
                $package    = "upgraded to : " . $this->db->get_where('membership',array('membership_id'=>$query->row()->membership))->row()->title;
            }
            $amount    =$this->db->get_where('membership',array('membership_id'=>$query->row()->membership))->row()->price;

            $email_body      = str_replace('[[to]]',$vendor_name,$email_body);
            $email_body      = str_replace('[[email]]',$email,$email_body);
            $email_body      = str_replace('[[vendor_package]]',$package,$email_body);
            $email_body      = str_replace('[[package_amount]]',$amount,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
            
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
            if($background !== 'style_1'){
                $final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
                $final_email = str_replace('[[body]]',$email_body,$final_email);
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
            } else {
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
            }
            
            return $send_mail;
        }
        else {
            return false;
        }
    }
    
    function account_opening($account_type = '', $email = '', $pass = '', $verification_key = '')
    {
        //$this->load->database();
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';


        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        
        $to   = $email;
        $query = $this->db->get_where($account_type, array('email' => $email));
 
        if ($query->num_rows() > 0) {
			if($account_type == 'admin'){
                $to_name    = $query->row()->name;
                $url        = "<a href='".base_url()."admin/'>".base_url()."admin</a>";
                $sub        = $this->db->get_where('email_template', array('email_template_id' => 6))->row()->subject;
                $email_body      = $this->db->get_where('email_template', array('email_template_id' => 6))->row()->body;
			}
			if($account_type == 'vendor')
            {

                $query->row()->vendor_id;


               

				$to_name	= $query->row()->name;
				$url 		= "<a href='".base_url()."vendor/'>".base_url()."vendor</a>";
				$verify_url = "<a href='".base_url()."home/vendor_verification?verifykey=".base64_encode($verification_key)."'>".base_url()."home/vendor_verification?verifykey=".base64_encode($verification_key)."</a>"; 

                
                $sub        = $this->db->get_where('email_template', array('email_template_id' => 4))->row()->subject;
				$email_body = $this->db->get_where('email_template', array('email_template_id' => 4))->row()->body;
			}
			if($account_type == 'user')
            {
				$to_name	= $query->row()->username;
				$url 		= "<a href='".base_url()."home/login_set/login'>".base_url()."home/login_set/login</a>";
                $verify_url = "<a href='".base_url()."home/verification?verifykey=".base64_encode($verification_key)."'>".base_url()."home/verification?verifykey=".base64_encode($verification_key)."</a>"; 
                $sub        = $this->db->get_where('email_template', array('email_template_id' => 5))->row()->subject;
				$email_body      = $this->db->get_where('email_template', array('email_template_id' => 5))->row()->body;
			}
            
            $email_body      = str_replace('[[to]]',ucwords($to_name),$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
            $email_body      = str_replace('[[sitename]]',$from_name,$email_body);
            $email_body      = str_replace('[[account_type]]',$account_type,$email_body);
            $email_body      = str_replace('[[email]]',$to,$email_body);
            $email_body      = str_replace('[[password]]',$pass,$email_body);
            $email_body      = str_replace('[[url]]',$url,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            if($verify_url)
            {
                $email_body      = str_replace('[[verify_url]]',$verify_url,$email_body);
            }

			
			$background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
			if($background !== 'style_1'){
				$final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
				if($background == 'style_4'){
					$home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
					$logo =base_url().'uploads/logo_image/logo_'.$home_top_logo.'.png';
					$final_email = str_replace('[[logo]]',$logo,$final_email);
				}
				$final_email = str_replace('[[body]]',$email_body,$final_email);
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
			}else{
				$send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
			}

            return $send_mail;
        }
        else {
            return false;
        }
    }
    function withdrawal_amount($account_type = '', $id = '',$status = '', $amount = '')
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }

            $to_name    = $this->db->get_where('user',array('user_id'=>$id))->row()->username;
            $email      = $this->db->get_where('user',array('user_id'=>$id))->row()->email;
            
            $sub        = $this->db->get_where('email_template', array('email_template_id' => 14))->row()->subject;
            $email_body = $this->db->get_where('email_template', array('email_template_id' => 14))->row()->body;
            
            $email_body      = str_replace('[[to]]',$to_name,$email_body);
            $email_body      = str_replace('[[account_type]]',$account_type,$email_body);
            $email_body      = str_replace('[[email]]',$email,$email_body);
            $email_body      = str_replace('[[amount]]',$amount,$email_body);
            $email_body      = str_replace('[[status]]',$status,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
            
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
            $to=$this->db->get_where('general_settings', array('type' => 'contact_email'))->row()->value;

            if($background !== 'style_1'){
                $final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
                if($background == 'style_4'){
                    $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                    $logo =base_url().'uploads/logo_image/logo_'.$home_top_logo.'.png';
                    $final_email = str_replace('[[logo]]',$logo,$final_email);
                }
                
                $final_email = str_replace('[[body]]',$email_body,$final_email);

                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email); // from = sytem/ smtp, to = contact er email
            }else{
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
            }

            return $send_mail;
    }

    function create_event($account_type = '', $email = '')
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
        //$this->load->database();
        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        
        $to   = $email;
        $query = $this->db->get_where($account_type, array('email' => $email));
        
        if ($query->num_rows() > 0) {
            
            if($account_type == 'vendor'){
                $to_name    = $query->row()->name;
                $url        = "<a href='".base_url()."vendor/events'>".base_url()."vendor/events</a>";
                
                $sub        = $this->db->get_where('email_template', array('email_template_id' => 10))->row()->subject;
                $email_body = $this->db->get_where('email_template', array('email_template_id' => 10))->row()->body;
            }
            
            $email_body      = str_replace('[[to]]',$to_name,$email_body);
            $email_body      = str_replace('[[sitename]]',$from_name,$email_body);
            $email_body      = str_replace('[[account_type]]',$account_type,$email_body);
            $email_body      = str_replace('[[email]]',$to,$email_body);
            $email_body      = str_replace('[[password]]',$pass,$email_body);
            $email_body      = str_replace('[[url]]',$url,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
            
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
            if($background !== 'style_1'){
                $final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
                if($background == 'style_4'){
                    $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                    $logo =base_url().'uploads/logo_image/logo_'.$home_top_logo.'.png';
                    $final_email = str_replace('[[logo]]',$logo,$final_email);
                }
                $final_email = str_replace('[[body]]',$email_body,$final_email);
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
            }else{
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
            }

            return $send_mail;
        }
        else {
            return false;
        }
    } 

    function vendor_event_email_to_admin($account_type = '',$email = '')
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
       //$this->load->database();
        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }

            //$query = $this->db->get_where('vendor', array('email' => 'dipesh9897@gmail.com'));
            
            $query = $this->db->get_where($account_type, array('email' => $email));
        
            if ($query->num_rows() > 0) {
            
                if($account_type == 'vendor'){
                    $to_name    = $query->row()->name;
                 }   
            }     
            

            $url        = "<a href='".base_url()."vendor/events'>".base_url()."vendor/events</a>";
            
            $sub        = $this->db->get_where('email_template', array('email_template_id' => 11))->row()->subject;
            $email_body = $this->db->get_where('email_template', array('email_template_id' => 11))->row()->body;
            
            $email_body      = str_replace('[[account_type]]',$account_type,$email_body);
            $email_body      = str_replace('[[to]]',$to_name,$email_body);
            $email_body      = str_replace('[[url]]',$url,$email_body);
            $email_body      = str_replace('[[email]]',$email,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
            
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
            $to = $this->db->get_where('general_settings', array('type' => 'contact_email'))->row()->value;

            if($background !== 'style_1'){
                $final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
                if($background == 'style_4'){
                    $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                    $logo =base_url().'uploads/logo_image/logo_'.$home_top_logo.'.png';
                    $final_email = str_replace('[[logo]]',$logo,$final_email);
                }
                
                $final_email = str_replace('[[body]]',$email_body,$final_email);

                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email); // from = sytem/ smtp, to = contact er email
            }else{
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
            }

            return $send_mail;

    }
    function approved_event($account_type = '', $email = '',$youtube_id = '', $youtube_password = '',$video_link = '')
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
        //$this->load->database();
        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        
        $to   = $email;
        $query = $this->db->get_where($account_type, array('email' => $email));
        
        if ($query->num_rows() > 0) {
            
            if($account_type == 'vendor'){
                $to_name    = $query->row()->name;
                $url        = "<a href='".base_url()."vendor/events'>".base_url()."vendor/events</a>";
                $sub        = $this->db->get_where('email_template', array('email_template_id' => 12))->row()->subject;
                $email_body = $this->db->get_where('email_template', array('email_template_id' => 12))->row()->body;
            }
            
            $email_body      = str_replace('[[to]]',$to_name,$email_body);
            $email_body      = str_replace('[[sitename]]',$from_name,$email_body);
            $email_body      = str_replace('[[account_type]]',$account_type,$email_body);
            $email_body      = str_replace('[[email]]',$email,$email_body);
            $email_body      = str_replace('[[url]]',$url,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[youtube_id]]',$youtube_id,$email_body);
            $email_body      = str_replace('[[youtube_password]]',$youtube_password,$email_body);
            $email_body      = str_replace('[[video_link]]',$video_link,$email_body);
            
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
            if($background !== 'style_1'){
                $final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
                if($background == 'style_4'){
                    $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                    $logo =base_url().'uploads/logo_image/logo_'.$home_top_logo.'.png';
                    $final_email = str_replace('[[logo]]',$logo,$final_email);
                }
                $final_email = str_replace('[[body]]',$email_body,$final_email);
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email);
            }else{
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
            }

            return $send_mail;
        }
        else {
            return false;
        }
    }

 
    function vendor_reg_email_to_admin($email = '', $pass = '')
    {
        $omgee_image_url        = '<img src="'.base_url().'uploads/logo_image/omgee_logo.png">';
        $fb_image_url        = '<a href="'.'https://www.facebook.com/omgeeau"><img src="'.base_url().'uploads/logo_image/facebook_logo.png"></a>';
        $insta_image_url        = '<a href="'.'https://www.instagram.com/omgeeau/"><img src="'.base_url().'uploads/logo_image/instagram_logo.png"></a>';
        $linkdin_image_url        = '<a href="'.'https://www.linkedin.com/company/omgeeau/"><img src="'.base_url().'uploads/logo_image/linkdin_logo.png"></a>';
        
       //$this->load->database();
        $from_name  = $this->db->get_where('general_settings',array('type' => 'system_name'))->row()->value;
        $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }

            $query = $this->db->get_where('vendor', array('email' => $email));

            
            $vendor_name    = $query->row()->name;


            $vendorbrands = $this->db->get_where('vendorbrands',array('user_id'=>$query->row()->vendor_id))->result_array();

            $brands = "";
            $category_arr = array();

            foreach($vendorbrands as $key => $value) 
            {
               if($value['name'])
               { 
                   foreach(explode(",",$value['category']) as $value1) 
                   {
                        $category_name = $this->db->get_where('category',array('category_id'=>$value1))->row()->category_name; 
                        $category_arr[] = $category_name; 
                   }
                   $brands .= "Brand : ".$value['name']." Category : ".implode(",", $category_arr)."<br>";
                   unset($category_arr);
                }   
            }

            $all_brands_names = $brands;

            $create_date = $this->db->get_where('vendor', array('email' => $email))->row()->create_timestamp;
            $request_date = date('D M Y H:i A',$create_date);
            $website = $this->db->get_where('vendor', array('email' => $email))->row()->website;
            $suburb = $this->db->get_where('vendor', array('email' => $email))->row()->city;
            $state = $this->db->get_where('vendor', array('email' => $email))->row()->state;

            $url        = "<a href='".base_url()."vendor/'>".base_url()."vendor</a>";
            
            $sub        = $this->db->get_where('email_template', array('email_template_id' => 7))->row()->subject;
            $email_body = $this->db->get_where('email_template', array('email_template_id' => 7))->row()->body;
            
            
            $email_body      = str_replace('[[to]]', ucwords($vendor_name),$email_body);
            $email_body      = str_replace('[[email]]',$email,$email_body);
            $email_body      = str_replace('[[request_date]]',$request_date,$email_body);
            $email_body      = str_replace('[[website]]',$website,$email_body);
            $email_body      = str_replace('[[suburb]]',$suburb,$email_body);
            $email_body      = str_replace('[[brands_category]]',$all_brands_names,$email_body);
            $email_body      = str_replace('[[state]]',$state,$email_body);
            $email_body      = str_replace('[[from]]',$from_name,$email_body);
            $email_body      = str_replace('[[omgee_image_url]]',$omgee_image_url,$email_body);
            $email_body      = str_replace('[[fb_image_url]]',$fb_image_url,$email_body);
            $email_body      = str_replace('[[insta_image_url]]',$insta_image_url,$email_body);
            $email_body      = str_replace('[[linkdin_image_url]]',$linkdin_image_url,$email_body);
            
            $background = $this->db->get_where('ui_settings',array('type' => 'email_theme_style'))->row()->value;
            $to=$this->db->get_where('general_settings', array('type' => 'contact_email'))->row()->value;

            if($background !== 'style_1'){
                $final_email = $this->db->get_where('ui_settings',array('type' => 'email_theme_'.$background))->row()->value;
                if($background == 'style_4'){
                    $home_top_logo = $this->db->get_where('ui_settings',array('type' => 'home_top_logo'))->row()->value;
                    $logo =base_url().'uploads/logo_image/logo_'.$home_top_logo.'.png';
                    $final_email = str_replace('[[logo]]',$logo,$final_email);
                }
                
                $final_email = str_replace('[[body]]',$email_body,$final_email);

                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $final_email); // from = sytem/ smtp, to = contact er email
            }else{
                $send_mail  = $this->do_email($from,$from_name,$to, $sub, $email_body);
            }

            return $send_mail;

    }
    
    
    
    function newsletter($title = '', $text = '', $email = '', $from = '')
    {

        $from_name  = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
        $this->do_email($from, $from_name, $email, $title, $text);
    }
    
    /* Email Invoice */
    function email_invoice($sale_id){
        $CI =& get_instance();
        $CI->load->model('crud_model');

        $from_name  = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
        $protocol   = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
        if($protocol == 'smtp'){
            $from   = $this->db->get_where('general_settings',array('type' => 'smtp_user'))->row()->value;
        }
        else if($protocol == 'mail'){
            $from   = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
        }
        $is_guest = $this->db->get_where('sale', array('sale_id' => $sale_id))->row()->buyer;
        if ($is_guest == "guest") {
            $info = json_decode($this->db->get_where('sale', array('sale_id' => $sale_id))->row()->shipping_address,true);
            $to =  $info['email'];   
        }
        else {
            $to         = $CI->crud_model->get_type_name_by_id('user', $CI->crud_model->get_type_name_by_id('sale', $sale_id, 'buyer'), 'email');
        }
        $subject    = '#'.$CI->crud_model->get_type_name_by_id('sale', $sale_id, 'sale_code');
        $page_data['sale_id'] = $sale_id;
        $msg        = $this->load->view('front/shopping_cart/invoice_email', $page_data, TRUE);

        $this->do_email($from, $from_name, $to, $subject, $msg);

        $admins     = $this->db->get_where('admin',array('role'=>'1'))->result_array();
        foreach ($admins as $row) {
            $this->do_email($from, $from_name, $row['email'], $subject, $msg);
        }       
    }
    
    /***custom email sender****/
    
    function do_email($from = '', $from_name = '', $to = '', $sub ='', $msg ='')
    {   
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from($from, $from_name);
        $this->email->to($to);        
        $this->email->subject($sub);
        $this->email->message($msg);
        
        if($this->email->send()){
            return true;
        }else{
            // echo $this->email->print_debugger();
            return false;
        }
        //echo $this->email->print_debugger();
    }
    
}