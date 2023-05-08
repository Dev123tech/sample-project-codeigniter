<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Webservices extends CI_Controller
    {

    public function __construct()
    {
      parent::__construct();
      $this->load->library('paypal');
    $this->load->library('twoCheckout_Lib');
    $this->load->library('vouguepay');
    $this->load->library('pum');
    }


    /*http://103.15.67.74/pro1/omgee/webservices/login*/

    public function login() {
        $email = $this->input->post('email');
        // $phone = $this->input->post('phone');
        $password = sha1($this->input->post('password'));
        if (!empty($email) AND !empty($password)) {
        
            $where = array('email'=>$email,'password'=>$password);
            $checkPhone = $this->Webservice_model->getNumRows('user', $where);
            if($checkPhone > 0)
            {

                $whereIs = array('email'=>$email);
                $data =  $this->Webservice_model->get_data_where('user', $whereIs);
                $data1 = $data[0];
                $path = 'uploads/user_image/';
                // print_r($data1);die();
                if(!empty($data1)){
                    $result['user_id'] = $data1['user_id'];
                    $result['countrycode'] = $data1['countrycode'];
                    $result['phone'] = $data1['phone'];
                    $result['password'] = $data1['password'];
                    $result['country'] = !empty($data1['country']) ? $data1['country'] : "";
                    // $result['titlename'] = $data1['titlename'];
                    $result['email'] = $data1['email'];

                    if(!empty($data1['profile_image'])){
                        $result['profile_image'] = base_url().$path.$data1['profile_image'];
                    }else{
                        $result['profile_image'] = "";
                    }
                    
                    $result['dob'] = !empty($data1['dob']) ? $data1['dob'] : '';
                    // $result['is_verify'] = $data1['is_verify'];
                    $result['full_name'] = $data1['username'].' '.$data1['surname'];

                    $res['status'] = 1;
                    $res['message'] = 'Login Succesfully';
                    $res['data'] = $result;

                }else{
                    $res['status'] = 0;
                    $res['message'] = 'Invalid password, please check.';
                }
            }// checkPhone
            else
            {
                $res['status'] = 0;
                $res['message'] = 'Invalid credential, please check.';
            }
        }
        else
        {
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';
        }
        // }
        exit(json_encode($res));
            
    }


    function rgb2hex($rgb) 
    {
        $sRegex     = '/rgba?\(\s?([0-9]{1,3}),\s?([0-9]{1,3}),\s?([0-9]{1,3})/i';
        preg_match($sRegex,$rgb,$matches);
        if(count($matches) != 4)
        {
            die('The color count does not match.');
        }
        $iRed   = (int) $matches[1];
        $iGreen = (int) $matches[2]; 
        $iBlue  = (int) $matches[3];
        $sHexValue = dechex($iRed) . dechex($iGreen) . dechex($iBlue);
        return '#' . $sHexValue;
    }

    public function uploadImage($file_name , $path,$field_name)
        {  
          $res = array();  
          $config = array();
          $config['upload_path']      = $path;
          $config['allowed_types']    = '*';
          $config['file_name']        = $file_name;
          $this->load->library('upload',$config);
          $this->upload->initialize($config);
          if(!$this->upload->do_upload($field_name))
          {
            $error = $this->upload->display_errors();
            $res['status'] = 0;
            $res['message'] = $error;
          }
          else
          {
            $res['status'] = 1;
            $res['message'] = 'success';
            $new_path = $path.$file_name;
            chmod($new_path, 0777);           
          }
          return $res;
        }





    /* http://103.15.67.74/pro1/teleboutik/webservices/signup */

    public function signup(){
        // echo "<pre>"; print_r($_POST);die;
        $res = $data = $final_data = array();
        // $device_type = $this->input->get_request_header('device_type');
        // $full_name = $this->input->post('full_name');
        // $arr = explode('\t', $full_name);
        // $arr1 = $arr[0];
        // $arr2 = $arr[1];
        // $arr3 = $arr[2];
        $first_name     = $this->input->post('first_name');
        $last_name     = $this->input->post('last_name');

        $phone     = $this->input->post('phone');
        // $titlename = $this->input->post('titlename');
        $email = $this->input->post('email');
        $countrycode = $this->input->post('countrycode');
        // $dob = $this->input->post('dob');
        $country  = $this->input->post('country');
        $password = sha1($this->input->post('password'));

        // $fcm_id  = $this->input->post('fcm_id');
        // $device_type  = $this->input->post('device_type') ? $this->input->post('device_type') : "0";
        // $user_type  = $this->input->post('user_type');

        if(isset($phone) && !empty($phone)){
            $where = array('phone'=>$phone);
            $checkUniquePhone = $this->Webservice_model->getNumRows('user',$where);
            if($checkUniquePhone == 0){
                $data['username']       = $first_name.' '.$last_name;
                // $data['username']       = $arr1.' '.$arr2;
                $data['country']        = $country;
                $data['phone']          = $phone;
                $data['password']       = $password;
                // $data['device_type']    = $device_type;
                // $data['titlename']      = $titlename;
                // $data['user_type']       = $this->input->post('user_type');
                $data['email']          = $email;
                $data['verification_key'] = uniqid();
                $data['countrycode']  = $countrycode;
                // $data['dob']            = $dob;
                $data['is_verify']      = 0;
                $user_id =  $this->Webservice_model->insert_data('user', $data);
                // $q = $this->Webservice_model->get_data_where('user', array('user_id' => $user_id));
                $data['user_id']= $user_id;
                $data['first_name']= $first_name; 
                $data['last_name']=$last_name;
                $data['user_id'] = json_encode($user_id);
                // unset( $data['surname']);
                unset( $data['username']);

                $res['status'] = 1;
                $res['message'] = 'Succesfully registered';
                $res['data'] = $data;
            }else{
                $res['status'] = 0;
                $res['message'] = 'User already exist!';
            }
        }else{
            $res['status'] = 0;
            $res['message'] = 'Phone number is required';
        }
        // }
        exit(json_encode($res));
    }


    /* http://103.15.67.74/pro1/teleboutik/webservices/forgot_password */

    public function forgot_password(){
        $phone = $this->input->post('phone');
        $data['password'] = sha1($this->input->post('password'));

        $where = array('phone'=>$phone);
        $isNumberValid = $this->Webservice_model->get_data_where('user',$where);        
        if(!empty($isNumberValid)){
            $where = array('phone'=>$phone);
            $returnData = $this->Webservice_model->update_data('user',$data, $where);
            $res['status'] = 1;
            $res['message'] = 'Password changed successfully';
        }else{
            $res['status'] = 0;
            $res['message'] = 'Invalid phone number';
        }
        exit(json_encode($res));
    }




    public function get_user_profile(){
        $user_id = $this->input->post('user_id');
        if (!empty($user_id)) {

            $where = array('user_id'=>$user_id);
            $userData = $this->Webservice_model->get_data_where('user',$where);

            $result = array();
            if(!empty($userData)){
                $userData = !empty($userData) ? $userData[0] : '';
                // echo "<pre>"; print_r($userData);die;

                // $arr = explode('\t', $userData['username']);
                // $arr1 = $arr[0];
                // $arr2 = $arr[1];
                // $arr3 = $arr[2];
                $result['user_id']   = $userData['user_id'];
                $result['full_name']  = $userData['username'];;
                // $result['last_name']   = !empty($arr2) ? $arr2 : "";
                $result['phone']   = $userData['phone'];
                $result['countrycode']  = $userData['countrycode'];
                $result['country']  = $userData['country'];
                if(!empty($userData['profile_image'])){
                    $result['profile_image_url'] = base_url('uploads/user_image/'.$userData['profile_image']);    
                }else{
                    $result['profile_image_url'] ="";
                }
                
                $result['user']   = $userData['email'];
                $result['dob'] = !empty($userData['dob']) ? $userData['dob'] : '';

                // echo "<pre>"; print_r($result);die;


                $res['status'] = 1;
                $res['data'] = $result;    
            }else{
                $res['status'] = 0;
                $res['message'] = 'Invalid user id';    
            }
        }else{
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';    
        }
        exit(json_encode($res));
    }





    /* http://103.15.67.74/pro1/teleboutik/webservices/profile_update */

    public function profile_update(){
         // echo "<pre>"; print_r($_POST);echo "<pre>";
         // echo "<pre>"; print_r($_FILES);echo "<pre>";die;
        $user_id = $this->input->post('user_id');
        $title   = "Mr/Mrs";
        $full_name = $this->input->post('full_name');
        $country  = $this->input->post('country');
        $countrycode = $this->input->post('countrycode');
        $phone = $this->input->post('phone');
        $dob = $this->input->post('dob');
      
        if (!empty($user_id) AND !empty($full_name) AND !empty($country) AND !empty($dob) AND !empty($countrycode) AND !empty($phone)){
            $where = array('user_id'=>$user_id);
            // $arr = explode(' ', $full_name);
      //    $arr1 = $arr[0];
      //    $arr2 = $arr[1];
      //    $arr3 = $arr[2];
            // $data['username']       = $arr1.' '.$arr2;
            // $data['username'] = $arr1;
            // $data['surname']  = $arr2.' '.$arr3 ;
            $data['titlename'] = $title;
            $data['username']  = $full_name;
            $data['phone']  = $phone;
            $data['dob']    = $dob;
            $data['countrycode'] = $countrycode;
            $data['country']  = $country;
            $where = array('user_id'=>$user_id);
            if(isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name'])){
                $profile_pic_name = '';
                $config['upload_path']          = './uploads/user_image/';
                $config['allowed_types']        = '*';
                // $config['max_size']             = 1000;
                // $config['max_width']            = 10240;
                $filename   = $_FILES['profile_image']['name'];
                $extension  = pathinfo($filename, PATHINFO_EXTENSION);
                $new        = 'user_';
                $newfilename=$new.$user_id;
                $config['file_name'] = $newfilename;
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('profile_image')){
                    $profile_pic_error = $this->upload->display_errors();
                    $res['status'] = 0;
                    $res['message'] = $profile_pic_error;
                }else {
                    $upload_data = $this->upload->data();         
                    $profile_pic_name = $upload_data['file_name'];
                    $data['profile_image'] = $profile_pic_name;
                    
                    $this->Webservice_model->update_data('user',$data, $where);
                    $data['profile_image_url'] = base_url('uploads/user_image/'.$profile_pic_name);

                    // echo "<pre>"; print_r($data);echo "<pre>";
        
                    $res['status'] = 1;
                    $res['message'] = 'Data Updated Succesfully';
                    $res['data'] = $data; 
                }
            }else{
                // echo "<pre>"; print_r($data);die;
                $this->Webservice_model->update_data('user',$data, $where);

                // $check = $this->db->select('*')->from('user')->get()->result();
                // $where = array('user_id'=>$user_id,'password'=>$old_password);
                // $check = $this->Webservice_model->getNumRows('user',$where);
                $check =  $this->Webservice_model->get_data_where('user', $where);
                $check = !empty($check) ? $check[0] : "";
                $profile_image = !empty($check) ? $check['profile_image'] : "";
                if(!empty($profile_image)){
                    $data['profile_image_url'] = base_url('uploads/user_image/'.$profile_image);
                }else{
                    $data['profile_image_url'] = "";
                }
                
                // $data['profile_image_url']="";
                // echo "<pre>"; print_r($check);die;
                $res['status'] = 1;
                $res['message'] = 'Data Updated Succesfully';
                $res['data'] = $data; 

            }
        }else{
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/change_password */

    public function change_password(){
        $res = array();
        $user_id = $this->input->post('user_id');
        $old_password = sha1($this->input->post('old_password'));
        $new_password = sha1($this->input->post('new_password'));
        $where = array('user_id'=>$user_id,'password'=>$old_password);
        $check = $this->Webservice_model->getNumRows('user',$where);
        if($check==1 && isset($check) && !empty($check)){
            $data['password'] = $new_password;
            $whereIs = array('user_id'=>$user_id);
            $this->Webservice_model->update_data('user',$data, $where);
            
            $res['status'] = 1;
            $res['message'] = 'Password changed succesfully';
        }else{
            $res['status'] = 0;
            $res['message'] = 'Old password is incorrect !';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/get_product_category */

    public function get_product_category()
    {
        $language_type = $this->input->post('language_type');
        if ($language_type == 'en') {
            $GetCategory = $this->db->select('category_id, category_name')->from('category')->get()->result();
            //print_r($GetCategory);
            $res['status'] = 1;
            $res['message'] = 'Show category data succesfully';
            $res['data'] = $GetCategory;
        }
        else
        {
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/product_by_category */

    public function product_by_category()
    {
        $category_id = $this->input->post('category_id');
        $language_type = $this->input->post('language_type');
        if($language_type == 'en')
        {
            $where = array('category'=>$category_id);
            $data =  $this->Webservice_model->get_data_where('product', $where);

            if($data){
                foreach($data as $k=>$dt){
                    $images = $this->crud_model->file_view('product',$dt['product_id'],'','','thumb','src','multi','all');
                    $data[$k]['images'] = $images;
                }

            }
            $res['status'] = 1;
            $res['message'] = 'Data fetched successfully';
            $res['data'] = $data;
        }
        else{
            $res['status'] = 0;
            $res['message'] = 'No data found !';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/product_detail */
    
    function searchArrayKeyVal($sKey, $id, $array) {
        if(!empty($array)){
            foreach ($array as $key => $val) {
               if ($val[$sKey] == $id) {
                   return $key;
               }
            }
        }
       return false;
    }


    function array_msort($array, $cols){
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;

    }


    function price_formula($rrp,$wholesale,$commission_amount,$orp_commission_amount,$discount)
    {
        $gap_revenue = $rrp - $wholesale;
        $gap_revenue_commission = $gap_revenue * $commission_amount;    
        $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);
        $total_discount = $orp * $discount;
        $total_orp = $orp - $total_discount;
        return $total_orp;
    }

    public function product_detail() {
        $results_array = array();
        $productId = $this->input->post('product_id');
        $user_id = $this->input->post('user_id');
        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';


       
         // $productInfo=$this->Webservice_model->getDataFromTabel('product', '*', array('product_id'=>$productId));
        // $row = !empty($productInfo) ? $productInfo[0] : "";
        $row = $this->db->get_where('product',array('product_id' => $productId,'remove'=>'0'))->row();
        
        
        if (!empty($row)) {
            $res = array();

            $default_price = !empty($row->sale_price_AU) ? $row->sale_price_AU : '0';
            if($currencyType=="AUD"){
                $sale_price = $default_price;
            }else if($currencyType=="HKD"){
                $sale_price = !empty($row->sale_price_HK) ? $row->sale_price_HK : $default_price;
            }else if($currencyType=="JPY"){
                $sale_price = !empty($row->sale_price_JP) ? $row->sale_price_JP : $default_price;
            }else if($currencyType=="SGD"){
                $sale_price = !empty($row->sale_price_SG) ? $row->sale_price_SG : $default_price;
            }else{
                $sale_price = $default_price;
            }


            $results_array['product_id'] = $row->product_id;
            $results_array['product_link']=$this->crud_model->product_link($row->product_id); 
            $results_array['food_section'] = $row->food_section;
            $results_array['food_title'] = !empty($row->food_title) ? $row->food_title : "";
            $results_array['food_description'] = !empty($row->food_description) ? $row->food_description : "";
            $results_array['food_image1'] = !empty($row->food_image1) ? base_url('uploads/product_image/'.$row->food_image1) : "";
            $results_array['food_image2'] = !empty($row->food_name2) ? base_url('uploads/product_image/'.$row->food_name2) : "";
            $results_array['food_image3'] = !empty($row->food_image3) ? base_url('uploads/product_image/'.$row->food_image3) : "";
            $results_array['food_image4'] = !empty($row->food_image4) ? base_url('uploads/product_image/'.$row->food_image4) : "";


            $results_array['title'] = !empty($row->title) ? $row->title : "";
            $results_array['decription'] = !empty($row->decription) ? $row->decription : "";
            // $results_array['images'] = base_url('uploads/product_image/').$row->num_of_imgs;


             if($row->num_of_imgs !=NULL){
                $num_of_img = explode(",", $row->num_of_imgs); 

                $results_array['images'] = base_url('uploads/product_image/'.$num_of_img[0]);
            }else{
                $results_array['images'] = base_url('uploads/product_image/default.jpg');
            }



            $max_stock = 72;
            $coupon_price = 0;
            $cashback_product = $this->db->get_where('coupon')->result_array();
            $already_add_product_arr = array();

            $current_date = date('Y-m-d');

            foreach($cashback_product as $key => $value) {
                $already_add_product_ar = json_decode($value['spec']);

                if(strtotime($value['till']) > strtotime($current_date)){
                    $till_ar[] = strtotime($value['till']);

                    foreach(json_decode($already_add_product_ar->set) as $key => $productids) {
                        $already_add_product_arr[] = array('productid'=>$productids,'discount_type'=>$already_add_product_ar->discount_type,'discount_value'=>$already_add_product_ar->discount_value);
                    }
                }
            }

            $productKey = $this->searchArrayKeyVal("productid", $product_id, $already_add_product_arr);
            if($productKey!==false) {
                 $coupon_price = $already_add_product_arr[$productKey]['discount_value'];
            }


            
            // $rrp = $sale_price;
            // $results_array['rrp'] = $sale_price;
            $wholesale = $row->wholesale;
            $orpData=$this->get_orp($sale_price,$wholesale,$row->discount,$row->limited_release);



            $orp = !empty($orpData['orp']) ? $orpData['orp'] : '0';
            $discount_orp = !empty($orpData['discount_orp']) ? $orpData['discount_orp'] : '0';


            $results_array['discount_orp'] = $discount_orp;
            $results_array['orp'] = $orp;

            
            $discount = ($row->discount) ? ($row->discount/100) : 0;
            



            // if($row->limited_release=="Yes"){
            //     $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
            
            //     $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
            // }else{
            //     $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
            
            //     $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
            // }


            // $discount = ($row['discount']) ? ($row['discount']/100) : 0;
    

            if($row->limited_release=="Yes")
            {
                $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
            
                $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
            }
            else
            {
                $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
            
                $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
            }

            $results_array['each'] = $this->price_formula($sale_price,$wholesale,$commission_amount,$orp_commission_amount,$discount)*1;
            $results_array['six'] = $this->price_formula($sale_price,$wholesale,$commission_amount,$orp_commission_amount,$discount)*6;
            $results_array['twelve'] = $this->price_formula($sale_price,$wholesale,$commission_amount,$orp_commission_amount,$discount)*12;



            $rating= $this->Webservice_model->getProductRating($product_id);
            // echo "<pre>"; print_r($results_array['reviews']);die;
            $results_array['reviews'] = !empty($rating) ? $rating : 0;
            $results_array['rating'] = !empty($rating) ? $rating : 0;

            $numbers = array($row->test1_number,$row->test11_number,$row->test2_number,$row->test22_number,$row->test3_number,$row->test33_number,$row->test4_number,$row->test44_number,$row->test5_number,$row->test55_number); 
                        
            $arr1 = array(
                array('id'=>$row->test1_number,'name'=>$row->test1_name),
                array('id'=>$row->test11_number,'name'=>$row->test11_name),
                array('id'=>$row->test2_number,'name'=>$row->test2_name),
                array('id'=>$row->test22_number,'name'=>$row->test22_name),
                array('id'=>$row->test3_number,'name'=>$row->test3_name),
                array('id'=>$row->test33_number,'name'=>$row->test33_name),
                array('id'=>$row->test4_number,'name'=>$row->test4_name),
                array('id'=>$row->test44_number,'name'=>$row->test44_name),
                array('id'=>$row->test5_number,'name'=>$row->test5_name),
                array('id'=>$row->test55_number,'name'=>$row->test55_name)
            );


            $arr2 = $this->array_msort($arr1, array('id'=>SORT_DESC));

            $newarr2 = array();
            foreach ($arr2 as $key => $value) {
                $newarr2[]= $value;
            }

            $results_array['product_id'] = $row->product_id;
            $results_array['test_title'] = $row->test_title;
            $results_array['test_sumary_title'] = $row->test_sumary_title;
            $results_array['test_sumary'] = $row->test_sumary;

            $results_array['wine_test'] = $newarr2;

            $wish = $this->Webservice_model->is_wished($row->product_id,$user_id); 
            $is_wished='0';
            if($wish=="yes"){
                $is_wished='1';
            }else if($wish=="no"){
                $is_wished='0';
            }
            // $results_array['orp']=$this->get_orp($row->bundle_sale1,$wholesale,$row->bundle_discount1,$row->limited_release);
            
            //  $food_paring = array();
            // if($row->food_section == 'yes'){
            //     // $food_paring['food_title']=$row->food_title;
            //     $food_paring['food_description']=$row->food_description;
            //     $food_paring['food_image1']= base_url('uploads/product_image/'.$row->food_image1); 
            //     $food_paring['food_image2']= base_url('uploads/product_image/'.$row->food_name2); 
            //     $food_paring['food_image3']= base_url('uploads/product_image/'.$row->food_image3); 
            //     $food_paring['food_image4']= base_url('uploads/product_image/'.$row->food_image4); 
            // }
                
            //  $results_array['food_paring'] = $food_paring;

            $likesArr = array();
            $you_also_likes = $this->db->get_where('product',array('added_by'=>$row->added_by,'remove'=>'0'))->result_array();
            // echo "<pre>"; print_r($you_also_likes);die;
            if(!empty($you_also_likes)){
                foreach ($you_also_likes as $pkey) {
                    $resp = array();

                    $default_price = !empty($row->sale_price_AU) ? $row->sale_price_AU : '0';
                    if($currencyType=="AUD"){
                        $sale_price = $default_price;
                    }else if($currencyType=="HKD"){
                        $sale_price = !empty($row->sale_price_HK) ? $row->sale_price_HK : $default_price;
                    }else if($currencyType=="JPY"){
                        $sale_price = !empty($row->sale_price_JP) ? $row->sale_price_JP : $default_price;
                    }else if($currencyType=="SGD"){
                        $sale_price = !empty($row->sale_price_SG) ? $row->sale_price_SG : $default_price;
                    }else{
                        $sale_price = $default_price;
                    }

                    $resp['discount'] = ($pkey->discount) ? ($pkey->discount/100) : 0;
                    // $resp['rrp'] = $sale_price;
                    // $resp['orp'] = $this->get_orp($sale_price,$pkey->wholesale,$pkey->discount,$pkey->limited_release);


                    $orp = !empty($orpData['orp']) ? $orpData['orp'] : '0';
                    $discount_orp = !empty($orpData['discount_orp']) ? $orpData['discount_orp'] : '0';


                    $resp['discount_orp'] = $discount_orp;
                    $resp['orp'] = $orp;



                    $resp['product_id'] = $pkey['product_id'];
                    $resp['title'] = $pkey['title'];


                    if($pdtvalue['num_of_imgs'] !=NULL){
                        $num_of_img = explode(",", $pkey['num_of_imgs']); 
                        $resp['product_image'] = base_url('uploads/product_image/'.$num_of_img[0]);
                        
                    }else{
                        $resp['product_image'] = base_url('uploads/product_image/default.jpg');
                    }

                    // $resp['product_image'] = base_url('uploads/product_image/'.$pkey['main_image']);                    
                    $resp['sale_price'] = $sale_price;
                    // $resp['purchase_price'] = $pkey['purchase_price'];
                    $resp['discount'] = !empty($pkey['discount']) ? $pkey['discount'] : "";


                    if($pkey['discount'] > 0){
                        $resp['off'] = '1';
                    }else{
                        // $community_arr['product_price'] = $row['bundle_discount1'];
                        $resp['off'] = '0';
                    }    
                    

                    $productKey = $this->searchArrayKeyVal("productid", $pkey['product_id'], $already_add_product_arr);

                    if($productKey!==false) {
                        $resp['cashback'] = '1';
                        $resp['discount_value'] = $already_add_product_arr[$productKey]['discount_value'];
                        $resp['discount_type'] = $already_add_product_arr[$productKey]['discount_type'];
                    }else{
                        $resp['cashback'] = '0';
                        $resp['discount_value'] = "";
                        $resp['discount_type'] = "";
                    }

                    $wish = $this->Webservice_model->is_wished($pkey['product_id'],$user_id); 
                    $is_wished='0';
                    if($wish=="yes"){
                        $is_wished='1';
                    }else if($wish=="no"){
                        $is_wished='0';
                    }

                    $resp['is_wished'] = $is_wished;
                    $likesArr[]  =$resp;;
                }    
            }
            


            $results_array['you_also_likes'] = $likesArr;

            $res['status'] = 1;
            $res['message'] = 'Data fetched successfully';
            $res['data'] = $results_array;

        }else{
            $res['status'] = 0;
            $res['message'] = 'Data not found';
            //$res['data'] = $data;
        }
        exit(json_encode($res));

        // echo "<pre>"; print_r($results_array);die;
    }



    public function get_orp($bundle_sale1,$whole_sale,$bundle_discount1,$limited_release){
        $response = array();
        $rrp = $bundle_sale1;
    
        $wholesale = $whole_sale;
        $discount = ($bundle_discount1) ? ($bundle_discount1/100) : 0;
        

        if($limited_release=="Yes"){
            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
        
            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
        }else{
            $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
        
            $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
        }

        $gap_revenue = $rrp - $wholesale;
        $gap_revenue_commission = $gap_revenue * $commission_amount;    
        $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);
        $total_discount = $orp * $discount;
        $total_orp = $orp - $total_discount;
        if(!empty($discount)){
            $lat_sale_price1 = $total_orp*1;    
        }else{
            $lat_sale_price1=0;
        }
        

        $response['orp'] = $orp;

        $response['discount_orp'] = $lat_sale_price1;
        return $response;
    }


    public function search(){
        $results_array = array();
        $product_search = $this->input->post('product_search');
        $filter = $this->input->post('search_by_filter');
        $brand_id = $this->input->post('brand_id');
        $user_id = $this->input->post('user_id');
        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';


        $data = $this->Webservice_model->searchProduct($product_search,$filter,$brand_id);
        // echo "<pre>"; print_r($data);die;
        if(!empty($data)){
            foreach ($data as $key) {
                $respo = array();


                $default_price = !empty($key->sale_price_AU) ? $key->sale_price_AU : '0';
                if($currencyType=="AUD"){
                    $sale_price = $default_price;
                }else if($currencyType=="HKD"){
                    $sale_price = !empty($key->sale_price_HK) ? $key->sale_price_HK : $default_price;
                }else if($currencyType=="JPY"){
                    $sale_price = !empty($key->sale_price_JP) ? $key->sale_price_JP : $default_price;
                }else if($currencyType=="SGD"){
                    $sale_price = !empty($key->sale_price_SG) ? $key->sale_price_SG : $default_price;
                }else{
                    $sale_price = $default_price;
                }

                $respo['product_id']   = $key->product_id;
                $respo['title']   = $key->title;
                $respo['description'] = $key->description;
                $respo['sale_price'] = $sale_price;
                $respo['rating'] = $this->crud_model->getProductRating($key->product_id);

                // $bundle_sale1=!empty($key->bundle_sale1)?$key->bundle_sale1:0;
                $wholesale=!empty($key->wholesale)?$key->wholesale:0;
                $discount=!empty($key->discount)?$key->discount:0;
                $limited_release=!empty($key->limited_release)?$key->limited_release:0;
                // $respo['rrp'] = $sale_price;
                $orpData = $this->get_orp($sale_price,$wholesale,$discount,$limited_release);


                $orp = !empty($orpData['orp']) ? $orpData['orp'] : '0';
                $discount_orp = !empty($orpData['discount_orp']) ? $orpData['discount_orp'] : '0';


                $respo['discount_orp'] = $discount_orp;
                $respo['orp'] = $orp;


                 $respo['discount'] = $key->discount;
            

                if($key->discount > 0){
                    // $respo['discount_price'] = $key->discount;
                    $respo['off'] = '1';
                }else{
                    // $community_arr['product_price'] = $row['bundle_discount1'];
                    $respo['off'] = '0';
                }    
                

                $productKey = $this->searchArrayKeyVal("productid", $key->product_id, $already_add_product_arr);

                if($productKey!==false) {
                    $respo['cashback']='1';
                    $respo['discount_value'] = $already_add_product_arr[$productKey]['discount_value'];
                    $respo['discount_type'] = $already_add_product_arr[$productKey]['discount_type'];
                }else{
                    $respo['cashback']='0';
                    $respo['discount_value'] = "";
                    $respo['discount_type'] = "";
                }


                $wish = $this->Webservice_model->is_wished($key->product_id,$user_id); 
                // echo "<pre>"; print_r($wish);die;
                $is_wished='0';
                if($wish=="yes"){
                    $is_wished='1';
                }else if($wish=="no"){
                    $is_wished='0';
                }
                $respo['is_wished']= $is_wished;



                if(!empty($key->num_of_imgs)){
                    $num_of_imgs = explode(",", $key->num_of_imgs); 
                    // echo "<pre>"; print_r($num_of_imgs);die;
                    $respo['image'] = base_url('uploads/product_image/'.$num_of_imgs[0]);
                }else{
                    $respo['image'] = base_url('uploads/product_image/default.jpg');
                }
                $results_array[] = $respo;
            }
            $res['status'] = 1;
            $res['message'] = 'Data found'; 
            $res['data'] = $results_array;    
        }else{
            $res['status'] = 0;
            $res['message'] = 'Data not found'; 
        }
        exit(json_encode($res));
    }




//is_wished
// rrp
// orp
// off
// cashback
// title
// product_image
// currency_type:AUD/HKD/JPY/SGD





    public function dashboard() {
        $user_id = $this->input->post('user_id');
        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';

        $results_array = array();
        // $events_array = array();
        $slider_array = array();
        

        $cartitem = $this->Webservice_model->countResult('forCart', array('user_id' => $user_id));
        $results_array['total_cart_item'] = !empty($cartitem) ? $cartitem : 0;
        // echo "<pre>"; print_r($cartitem);die;

        $already_add_product_arr = array();
        $this->db->where('status','approved');
        $this->db->order_by('events_id','desc');
        $events_data = $this->db->get('events')->result_array();
        // echo "<pre>"; print_r($events_data);die;
        $h = count($events_data);
        if($h>0){    
            $current_datetime =  date("Y-m-d H:i:s", time());
            $count_check=0;
            foreach($events_data as $check_count){
                $date = $check_count['date'];
                $end_time = $check_count['end_time'];
                $events_end_datetime = date("$date $end_time");
                if( $current_datetime < $events_end_datetime){
                    $count_check++;
                }
            }
        }    

        if($count_check > 0){   
            $n=1;
            foreach ($events_data as $row1) {  
                $sliderArr = array();
                $date = $row1['date'];
                $end_time = $row1['end_time'];
                $events_end_datetime = date("$date $end_time");
                if( ($row1['banner_image'] != NULL) && ( $current_datetime < $events_end_datetime) ){
                    $sliderArr['slider_id']=$row1['events_id'];
                    $sliderArr['banner_image']= base_url('uploads/events_image/'.$row1['banner_image']);
                    $slider_array[] = $sliderArr;
                    $n++;
                }
            }
            // $results_array['slider1'] = $events_array;
        }else {
            $this->db->where('status','ok');
            $this->db->order_by('serial','desc');
            $this->db->order_by('slider_id','desc');
            $sliders = $this->db->get('slider')->result_array();
            $h = count($sliders);
           
                      
            $n=1;
            foreach ($sliders as $row1) {
                $sliderArr = array();
                $elements = json_decode($row1['elements'],true);
                $txts   = $elements['texts'];
                // $countslider = count($row1['slider_id'])+$countslider; 
                $sliderArr['slider_id'] = $row1['slider_id'];
                $sliderArr['slider_image'] = base_url('uploads/background_'.$row1['slider_id'].'.jpg');
                $slider_array[] = $sliderArr;
                $n++;
            }
        }
        $results_array['sliders1'] = $slider_array;
        

        $slider2_array = array();
        $this->db->order_by('slides_id','desc');
        $slides = $this->db->get('slides')->result_array();
        $n=1;
        foreach ($slides as $rows) {
            $slider2ar = array();
            $elements = json_decode($rows['elements'],true);
            $txts   = $elements['texts'];
            $slider2ar['slides_id']= $rows['slides_id'];
            $slider2ar['slides_image'] = base_url('uploads/slides_image/slides_'.$rows['slides_id'].'.jpeg');
            $slider2_array[] = $slider2ar;                
            $n++;

        }
        $results_array['sliders2'] = $slider2_array;                
                       
       $video_type = $this->db->get_where('general_settings',array('type'=>'video_link'))->row_array();
       // $results_array['video_type'] = !empty($video_type) ? "https://www.youtube.com/player_api/".$video_type['value'] : "";
         $results_array['video_type'] = !empty($video_type) ? "https://www.youtube.com/watch?v=".$video_type['value'] : "";                   
       //top slider or bannder code end

        $cashback_product = $this->db->get_where('coupon')->result_array();
        $already_add_product_arr = array();
        // echo "<pre>"; print_r($results_array);echo "<pre>";
        
        $current_date = date('Y-m-d');

        foreach($cashback_product as $key => $value) {
            $already_add_product_ar = json_decode($value['spec']);

            if(strtotime($value['till']) > strtotime($current_date)){
                $till_ar[] = strtotime($value['till']);

                foreach(json_decode($already_add_product_ar->set) as $key => $productids) {
                    $already_add_product_arr[] = array('productid'=>$productids,'discount_type'=>$already_add_product_ar->discount_type,'discount_value'=>$already_add_product_ar->discount_value);
                }
            }
        }



                     
        $category_array = array();
        $categories = $this->db->order_by('category_id', 'desc')->get_where('category',array('digital'=> NULL))->result_array();

        //1st row : Popular,Top Deals, Wine=23,Spirits=17. Non-Alcohol=16

        $productcate1 = array();
        $productcate2 = array();
        $cat_count = 0;
        // foreach ($categories as $catvalue) {
        //     $cateArr = array();
        //      // Wine=23,Spirits=17. Non-Alcohol=16
        //     // echo $catvalue['category_id'];die;
        //     if( $catvalue['category_id']=='23' || $catvalue['category_id']=='17' || $catvalue['category_id'] == '16' ){

        //         $cateArr['category_name'] = $catvalue['category_name'];        
        //         $cateArr['category_id'] = $catvalue['category_id'];        
        //         $cateArr['category_image']= base_url('uploads/category_image/'.$catvalue['banner']);


        //         $sub_category_arr = array();     
        //         $sub_category = $this->db->get_where('sub_category',array('category'=>$catvalue['category_id']))->result_array();

        //         if(count($sub_category) > 0){
        //             foreach ($sub_category as $sub_category_value) {

        //                 $subCateArr = array();
        //                 if($sub_category_value['banner'] !=NULL){
        //                     $num_of_img = explode(",",$sub_category_value['banner']); 
                            
        //                     $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
        //                     $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
        //                     $subCateArr['category_image']= base_url('uploads/sub_category_image/'.$sub_category_value['banner']);
        //                 }else{
                            
        //                     $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
        //                     $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
        //                     $subCateArr['category_image']= base_url('uploads/sub_category_image/default.jpg');

        //                 }
        //                 $sub_category_arr[]=$subCateArr;
                                         
        //             }
        //             $cateArr['sub_category'] = $sub_category_arr;
        //         }else{
        //             $cateArr['sub_category'] = array();
        //         }
  
        //     }



        //     if(count($cateArr) > 0){
        //         $productcate1[] = $cateArr; 
        //     }
        //     $cat_count++;
        // }
       


        $popularArray= array();
        $popularArray['category_name'] = 'Popular';        
        $popularArray['category_id'] = '';        
        $popularArray['category_image']= base_url('template/omgee/images/iconfindericon/popular.png');
                
        $brandArray = array();
        $brands = $this->db->limit(12)->get_where('brand')->result_array();
        foreach ($brands as $brandsvalue) {
            $brand_arr = array();
            if($brandsvalue['logo'] !=NULL){
                $num_of_img = explode(",", $brandsvalue['logo']); 
                $brand_arr['category_image'] = base_url('uploads/brand_image/'.$num_of_img[0]);
                $brand_arr['sub_category_name'] = $brandsvalue['name'];
                $brand_arr['sub_category_id'] = $brandsvalue['brand_id'];
            }else{
                $brand_arr['category_image'] = base_url('uploads/product_image/default.jpg');
                $brand_arr['sub_category_name'] = $brandsvalue['name'];
                $brand_arr['sub_category_id'] = $brandsvalue['brand_id'];
                
            }
            $brandArray[]  = $brand_arr;
        }
        // $results_array['brand'] = $brandArray;                            
        
        $popularArray['sub_category']=$brandArray;


        $productcate1['0']=$popularArray;

        $topdealArray = array();
        $topdealArray['category_name'] = 'Top Deals';        
        $topdealArray['category_id'] = '';        
        $topdealArray['category_image']= base_url('template/omgee/images/iconfindericon/topdeals.png');


        $topdeal_array = array();                                    
        $topdeal_products = $this->db->limit(12)->get_where('product',array('deal'=>'ok','status'=>'ok','remove'=>'0'))->result_array();
        foreach ($topdeal_products as $pdtvalue) {
            $topdeal_arr  = array();
            if($pdtvalue['num_of_imgs'] !=NULL){
                $num_of_img = explode(",", $pdtvalue['num_of_imgs']); 
                $topdeal_arr['category_image'] = base_url('uploads/product_image/'.$num_of_img[0]);
                $topdeal_arr['sub_category_name'] = $pdtvalue['title'];
                $topdeal_arr['sub_category_id'] = $pdtvalue['product_id'];
            }else{
                
                $topdeal_arr['sub_category_name'] = $pdtvalue['title'];
                $topdeal_arr['category_image'] = base_url('uploads/product_image/default.jpg');
                $topdeal_arr['sub_category_id'] = $pdtvalue['product_id'];
              
            }
            $topdeal_array[] = $topdeal_arr;
        }
        // $results_array['topdeal_product'] = $topdeal_array;     

        $topdealArray['sub_category']=$topdeal_array;

        $productcate1['1']=$topdealArray;


        $wine_array = array();


        $wine_array['category_name'] = $categories['0']['category_name'];        
        $wine_array['category_id'] = $categories['0']['category_id'];        
        $wine_array['category_image']= base_url('uploads/category_image/'.$categories['0']['banner']);


        $sub_category_arr = array();     
        $sub_category = $this->db->get_where('sub_category',array('category'=>$categories['0']['category_id']))->result_array();

        if(count($sub_category) > 0){
            foreach ($sub_category as $sub_category_value) {

                $subCateArr = array();
                if($sub_category_value['banner'] !=NULL){
                    $num_of_img = explode(",",$sub_category_value['banner']); 
                    
                    $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                    $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                    $subCateArr['category_image']= base_url('uploads/sub_category_image/'.$sub_category_value['banner']);
                }else{
                    
                    $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                    $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                    $subCateArr['category_image']= base_url('uploads/sub_category_image/default.jpg');

                }
                $sub_category_arr[]=$subCateArr;
                                 
            }
            $wine_array['sub_category'] = $sub_category_arr;
        }else{
            $wine_array['sub_category'] = array();
        }


        $productcate1['2']=$wine_array;




        $spirits_array = array();


        $spirits_array['category_name'] = $categories['3']['category_name'];        
        $spirits_array['category_id'] = $categories['3']['category_id'];        
        $spirits_array['category_image']= base_url('uploads/category_image/'.$categories['3']['banner']);


        $sub_category_arr = array();     
        $sub_category = $this->db->get_where('sub_category',array('category'=>$categories['3']['category_id']))->result_array();

        if(count($sub_category) > 0){
            foreach ($sub_category as $sub_category_value) {

                $subCateArr = array();
                if($sub_category_value['banner'] !=NULL){
                    $num_of_img = explode(",",$sub_category_value['banner']); 
                    
                    $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                    $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                    $subCateArr['category_image']= base_url('uploads/sub_category_image/'.$sub_category_value['banner']);
                }else{
                    
                    $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                    $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                    $subCateArr['category_image']= base_url('uploads/sub_category_image/default.jpg');

                }
                $sub_category_arr[]=$subCateArr;
                                 
            }
            $spirits_array['sub_category'] = $sub_category_arr;
        }else{
            $spirits_array['sub_category'] = array();
        }


        $productcate1['3']=$spirits_array;




        $nonAlcoholArray = array();


        $nonAlcoholArray['category_name'] = $categories['4']['category_name'];        
        $nonAlcoholArray['category_id'] = $categories['4']['category_id'];        
        $nonAlcoholArray['category_image']= base_url('uploads/category_image/'.$categories['4']['banner']);


        $sub_category_arr = array();     
        $sub_category = $this->db->get_where('sub_category',array('category'=>$categories['4']['category_id']))->result_array();

        if(count($sub_category) > 0){
            foreach ($sub_category as $sub_category_value) {

                $subCateArr = array();
                if($sub_category_value['banner'] !=NULL){
                    $num_of_img = explode(",",$sub_category_value['banner']); 
                    
                    $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                    $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                    $subCateArr['category_image']= base_url('uploads/sub_category_image/'.$sub_category_value['banner']);
                }else{
                    
                    $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                    $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                    $subCateArr['category_image']= base_url('uploads/sub_category_image/default.jpg');

                }
                $sub_category_arr[]=$subCateArr;
                                 
            }
            $nonAlcoholArray['sub_category'] = $sub_category_arr;
        }else{
            $nonAlcoholArray['sub_category'] = array();
        }


        $productcate1['4']=$nonAlcoholArray;



         // echo "<pre>"; print_r($productcate1);die;
        $results_array['category1'] = $productcate1;  
                                 
        //2nd row : Food Pairing, Pantry Food=4, Beer=21,Cider=18, Other Beverages=5

        $cat_count = 0;
        foreach ($categories as $catvalue) {
            $cateArr = array();
            if( $catvalue['category_id']=='4' || $catvalue['category_id'] == '21' || $catvalue['category_id'] == '18' || $catvalue['category_id'] == '5' ){
                $cateArr['category_name'] = $catvalue['category_name'];        
                $cateArr['category_id'] = $catvalue['category_id'];        
                $cateArr['category_image']= base_url('uploads/category_image/'.$catvalue['banner']);

                $sub_category_arr = array();     
                $sub_category = $this->db->get_where('sub_category',array('category'=>$catvalue['category_id']))->result_array();

                if(count($sub_category) > 0){
                    foreach ($sub_category as $sub_category_value) {

                        $subCateArr = array();
                        if($sub_category_value['banner'] !=NULL){
                            $num_of_img = explode(",",$sub_category_value['banner']); 
                            
                            $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                            $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                            $subCateArr['category_image']= base_url('uploads/sub_category_image/'.$sub_category_value['banner']);
                        }else{
                            
                            $subCateArr['sub_category_name'] = $sub_category_value['sub_category_name'];
                            $subCateArr['sub_category_id'] = $sub_category_value['sub_category_id'];        
                            $subCateArr['category_image']= base_url('uploads/sub_category_image/default.jpg');

                        }
                        $sub_category_arr[]=$subCateArr;
                                         
                    }
                    $cateArr['sub_category'] = $sub_category_arr;
                }else{
                    $cateArr['sub_category'] = array();
                }
  
            }
            if(count($cateArr) > 0){
                $productcate2[] = $cateArr; 
            }
            $cat_count++;
        }

        $results_array['category2'] = $productcate2;  
                                 
      


        // foreach ($categories as $row1) {
        //     $cate_arr = array();
        //     if($this->Webservice_model->if_publishable_category($row1['category_id'])){
        //         $cate_arr['category_name'] = $row1['category_name'];        
        //         $cate_arr['category_id'] = $row1['category_id'];        
        //         $cate_arr['category_image']= base_url('uploads/category_image/'.$row1['banner']);
        //         $category_array[] = $cate_arr;
        //     }
        // }
        // $results_array['publish_category'] = $category_array;

        



        $lastWeekproduct = array();                  
        $latest =$this->crud_model->lastOneWeekproduct();
        // echo "<pre>";print_r($latest);die;
        $total_latest = count($latest);
        foreach($latest as $row){ 
            
            $latestPro = array();
            $latestPro['discount'] = $row['discount'];
            

            if($row['discount'] > 0){
                 $community_arr['discount_price'] = $row['discount'];
                $latestPro['off'] = '1';
            }else{
                // $community_arr['product_price'] = $row['bundle_discount1'];
                $latestPro['off'] = '0';
            }    
            

            $productKey = $this->searchArrayKeyVal("productid", $row['product_id'], $already_add_product_arr);

            if($productKey!==false) {
                $latestPro['cashback']='1';
                $latestPro['discount_value'] = $already_add_product_arr[$productKey]['discount_value'];
                $latestPro['discount_type'] = $already_add_product_arr[$productKey]['discount_type'];
            }else{
                $latestPro['cashback']='0';
                $latestPro['discount_value'] = "";
                $latestPro['discount_type'] = "";
            }




            $wish = $this->Webservice_model->is_wished($row['product_id'],$user_id); 
            // echo "<pre>"; print_r($wish);die;
            $is_wished='0';
            if($wish=="yes"){
                $is_wished='1';
            }else if($wish=="no"){
                $is_wished='0';
            }

        
                                       

            // $this->getFinalPrice($currencyType);
            $default_price = !empty($row['sale_price_AU']) ? $row['sale_price_AU'] : '0';
            if($currencyType=="AUD"){
                $sale_price = $default_price;
            }else if($currencyType=="HKD"){
                $sale_price = !empty($row['sale_price_HK']) ? $row['sale_price_HK'] : $default_price;
            }else if($currencyType=="JPY"){
                $sale_price = !empty($row['sale_price_JP']) ? $row['sale_price_JP'] : $default_price;
            }else if($currencyType=="SGD"){
                $sale_price = !empty($row['sale_price_SG']) ? $row['sale_price_SG'] : $default_price;
            }else{
                $sale_price = $default_price;
            }

            $orpData = $this->get_orp($sale_price,$row['wholesale'],$row['discount'],$row['limited_release']);

            $orp = !empty($orpData['orp']) ? $orpData['orp'] : '0';
            $discount_orp = !empty($orpData['discount_orp']) ? $orpData['discount_orp'] : '0';


            $latestPro['discount_orp'] = $discount_orp;
            $latestPro['orp'] = $orp;
            $latestPro['is_wished']= $is_wished;
                
            $latestPro['product_id'] =$row['product_id'];
            $latestPro['title'] =$row['title'];
            $latestPro['sale_price'] = $row['sale_price'];
            // $latestPro['purchase_price'] = $row['purchase_price'];

            if($row['num_of_imgs'] !=NULL){
                $num_of_img = explode(",", $row['num_of_imgs']); 

                $latestPro['num_of_imgs'] = base_url('uploads/product_image/'.$num_of_img[0]);
            }else{
                $latestPro['num_of_imgs'] = base_url('uploads/product_image/default.jpg');
            }
            $lastWeekproduct[] = $latestPro;
        }   
        $results_array['new_arrivals'] = $lastWeekproduct;

        //community product
        $communArr= array(); 
        $recentlyViewed=$this->crud_model->product_list_set('recently_viewed','');

        $total_recently_viewed = count($recentlyViewed);

        foreach($recentlyViewed as $row){
            $community_arr= array(); 
            
            if($row['discount'] > 0){
                $community_arr['discount_price'] = $row['discount'];
                $community_arr['off'] = '1';
            }else{
                $community_arr['off'] = '0';
            }

            $wish = $this->Webservice_model->is_wished($row['product_id'],$user_id); 
            // $wish = $this->crud_model->is_wished($row['product_id']); 
            $is_wished='0';
            if($wish=="yes"){
                $is_wished='1';
            }else if($wish=="no"){
                $is_wished='0';
            }
            $community_arr['is_wished']= $is_wished;
            $productKey = $this->searchArrayKeyVal("productid", $row['product_id'], $already_add_product_arr);

            if($productKey!==false) {
                $community_arr['cashback'] = '1';
                
                $community_arr['discount_value'] = $already_add_product_arr[$productKey]['discount_value'];
                $community_arr['discount_type'] = $already_add_product_arr[$productKey]['discount_type'];
            
            }else{
                $community_arr['cashback'] = '0';
                
                $community_arr['discount_value'] = "";
                $community_arr['discount_type'] = "";    
            }



            
            $community_arr['product_id'] = $row['product_id'];
            $community_arr['sale_price'] = $row['sale_price'];
            // $community_arr['purchase_price'] = $row['purchase_price'];
            
            
            if(!empty($row['num_of_imgs'])){
                $num_of_img = explode(",", $row['num_of_imgs']); 
                $product_image = base_url('uploads/product_image/'.$num_of_img[0]);
            }else{
                $product_image = base_url('uploads/product_image/default.jpg');
            }
            $community_arr['product_image'] = $product_image;
            $community_arr['title'] = $row['title'];
            // $community_arr['rrp'] = $row['sale_price_AU'];
            


            // $this->getFinalPrice($currencyType);
            $default_price = !empty($row['sale_price_AU']) ? $row['sale_price_AU'] : '0';
            if($currencyType=="AUD"){
                $sale_price = $default_price;
            }else if($currencyType=="HKD"){
                $sale_price = !empty($row['sale_price_HK']) ? $row['sale_price_HK'] : $default_price;
            }else if($currencyType=="JPY"){
                $sale_price = !empty($row['sale_price_JP']) ? $row['sale_price_JP'] : $default_price;
            }else if($currencyType=="SGD"){
                $sale_price = !empty($row['sale_price_SG']) ? $row['sale_price_SG'] : $default_price;
            }else{
                $sale_price = $default_price;
            }


            $orpData = $this->get_orp($sale_price,$row['wholesale'],$row['discount'],$row['limited_release']);
            $orp = !empty($orpData['orp']) ? $orpData['orp'] : '0';
            $discount_orp = !empty($orpData['discount_orp']) ? $orpData['discount_orp'] : '0';


            $community_arr['discount_orp'] = $discount_orp;
            $community_arr['orp'] = $orp;

            // $latestPro['rrp'] = $sale_price;
            
            // $latestPro['is_wished']= $is_wished;

            // if($row['sale_price_AU']){
            // $rrp = $sale_price;

            // $wholesale = $row['wholesale'];
            // $discount = ($row['discount']) ? ($row['discount']/100) : 0;
            
            // if($row['limited_release']=="Yes"){
            //     $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
            
            //     $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
            // } else {
            //     $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
            
            //     $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
            // }

            // $gap_revenue = $rrp - $wholesale;
            // $gap_revenue_commission = $gap_revenue * $commission_amount;    
            // $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);
            // $total_discount = $orp * $discount;
            // $total_orp = $orp - $total_discount;
        

            // $lat_sale_price1 = $total_orp*1;
            // $lat_sale_price2 = $total_orp*6;
            // $lat_sale_price3 = $total_orp*12;


            // $community_arr['rrp'] = $rrp;
            // $community_arr['orp'] = $orp;
            $community_arr['discount'] = (string)$discount;
            // $community_arr['Each'] = currency($orp *1);
            // $community_arr['Six'] = currency($orp *6); 
            // $community_arr['Twelve'] = currency($orp *12);

            // $community_arr['Each_new'] = currency($lat_sale_price1);
            // $community_arr['Six_new'] = currency($lat_sale_price2); 
            // $community_arr['Twelve_new'] = currency($lat_sale_price3);
            $communArr[] = $community_arr;
        }

        // echo "<pre>"; print_r($communArr);die;

        $results_array['community'] = $communArr;
        $results_array['status'] = 1;
        $results_array['message'] = 'Result found successfully';
        exit(json_encode($results_array));

        // echo "<pre>"; print_r($results_array);die;
    }













    public function getSubcategoryProduct() {
        $results_array = array();
        $sub_category = $this->input->post('sub_category');
        $user_id = $this->input->post('user_id');
        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';

        $product = $this->Webservice_model->getDataFromTabel('product','*', array('sub_category'=>$sub_category,'remove'=>'0'));
        
        // echo "<pre>"; print_r($product);die;
        if(!empty($product)){
            foreach ($product as $key) {
                $respo = array();
                // echo "<pre>"; print_r($key);die;
         
                $default_price = !empty($key->sale_price_AU) ? $key->sale_price_AU : '0';
                if($currencyType=="AUD"){
                    $sale_price = $default_price;
                }else if($currencyType=="HKD"){
                    $sale_price = !empty($key->sale_price_HK) ? $key->sale_price_HK : $default_price;
                }else if($currencyType=="JPY"){
                    $sale_price = !empty($key->sale_price_JP) ? $key->sale_price_JP : $default_price;
                }else if($currencyType=="SGD"){
                    $sale_price = !empty($key->sale_price_SG) ? $key->sale_price_SG : $default_price;
                }else{
                    $sale_price = $default_price;
                }

                $respo['product_id']   = $key->product_id;
                $respo['title']   = $key->title;
                $respo['description'] = $key->description;
                $respo['sale_price'] = $sale_price;
                $respo['rating'] = $this->crud_model->getProductRating($key->product_id);

                // $bundle_sale1=!empty($key->bundle_sale1)?$key->bundle_sale1:0;
                $wholesale=!empty($key->wholesale)?$key->wholesale:0;
                $discount=!empty($key->discount)?$key->discount:0;
                $limited_release=!empty($key->limited_release)?$key->limited_release:0;
                // $respo['rrp'] = $sale_price;
                $orpData = $this->get_orp($sale_price,$wholesale,$discount,$limited_release);


                $orp = !empty($orpData['orp']) ? $orpData['orp'] : '0';
                $discount_orp = !empty($orpData['discount_orp']) ? $orpData['discount_orp'] : '0';


                $respo['discount_orp'] = $discount_orp;
                $respo['orp'] = $orp;

                  $respo['discount'] = $key->discount;
            

                if($key->discount > 0){
                    // $respo['discount_price'] = $key->discount;
                    $respo['off'] = '1';
                }else{
                    // $community_arr['product_price'] = $row['bundle_discount1'];
                    $respo['off'] = '0';
                }    
                

                $productKey = $this->searchArrayKeyVal("productid", $key->product_id, $already_add_product_arr);

                if($productKey!==false) {
                    $respo['cashback']='1';
                    $respo['discount_value'] = $already_add_product_arr[$productKey]['discount_value'];
                    $respo['discount_type'] = $already_add_product_arr[$productKey]['discount_type'];
                }else{
                    $respo['cashback']='0';
                    $respo['discount_value'] = "";
                    $respo['discount_type'] = "";
                }


                $wish = $this->Webservice_model->is_wished($key->product_id,$user_id); 
                // echo "<pre>"; print_r($wish);die;
                $is_wished='0';
                if($wish=="yes"){
                    $is_wished='1';
                }else if($wish=="no"){
                    $is_wished='0';
                }
                $respo['is_wished']= $is_wished;




                if(!empty($key->num_of_imgs)){
                    $num_of_imgs = explode(",", $key->num_of_imgs); 
                    // echo "<pre>"; print_r($num_of_imgs);die;
                    $respo['image'] = base_url('uploads/product_image/'.$num_of_imgs[0]);
                }else{
                    $respo['image'] = base_url('uploads/product_image/default.jpg');
                }
                $results_array[] = $respo;
            }
            $res['status'] = 1;
            $res['message'] = 'Data found'; 
            $res['data'] = $results_array;    
        }else{
            $res['status'] = 0;
            $res['message'] = 'Data not found'; 
        }
        exit(json_encode($res));
    }









    // public function getFinalPrice(){
        
    // }





    //brand list
    public function brandList(){
        $brand = $this->Webservice_model->getDataFromTabel('brand','*');

        // echo "<pre>";print_r($brand);die();  
        $response = array();
        if(!empty($brand)){
            $res['status'] = 1;
            $res['message'] = 'Brand fetched';
            $res['data'] =  $brand;     
        }else{
            $res['status'] = 0;
            $res['message'] = 'No record found';
        }
        
        exit(json_encode($res));
    }


    



// $brandArray = array();
//                 $brands = $this->db->limit(12)->get_where('brand')->result_array();
//                 foreach ($brands as $brandsvalue) {
//                     $brand_arr = array();
//                     if($brandsvalue['logo'] !=NULL){
//                         $num_of_img = explode(",", $brandsvalue['logo']); 
//                         $brand_arr['category_image'] = base_url('uploads/brand_image/'.$num_of_img[0]);
//                         $brand_arr['sub_category_name'] = $brandsvalue['name'];
//                         $brand_arr['sub_category_id'] = $brandsvalue['brand_id'];
//                     }else{
//                         $brand_arr['category_image'] = base_url('uploads/product_image/default.jpg');
//                         $brand_arr['sub_category_name'] = $brandsvalue['name'];
//                         $brand_arr['sub_category_id'] = $brandsvalue['brand_id'];
                        
//                     }
//                     $brandArray[]  = $brand_arr;
//                 }
//                 // $results_array['brand'] = $brandArray;                            
                
//                 $cateArr['sub_category']=$brandArray;












    public function my_order(){
        $final_data = array();
        $user_id = $this->input->post('user_id');
        // $language_type = $this->input->post('language_type');
        $query = "SELECT * FROM `sale` WHERE `buyer`= ". $user_id ." ORDER BY `sale_datetime` DESC";
        $SQL = $this->db->query($query);
        $orderData = $SQL->result_array();
        $cartArr = array();
        // echo"<pre>"; print_r($orderData);echo"<pre>";die;
        if ($orderData){
            $cart_array = array();
            foreach ($orderData as $key => $value) {
               $response = array(); 

               // $response['product_details'] = $value['product_details'];
               // $response['payment_type'] = $value['payment_type'];
               // $response['buyer'] = $value['buyer'];
               // $response['sale_id'] = $value['sale_id'];

                
                
                $data1 = json_decode($value['product_details']);
            
                foreach($data1 as $valArr){
                    $arrayCart = array();

                    $productInfo=$this->Webservice_model->getDataFromTabel('product', 'product_id,title,num_of_imgs', array('product_id'=>$valArr->product_id,'remove'=>'0'));

                    $arrayCart['user_id']=$valArr->user_id;
                    $arrayCart['product_id']=$valArr->product_id;
                    $arrayCart['qty']=$valArr->qty;

                    $arrayCart['title'] = $productInfo[0]->title;
                    

                    $arrayCart['grand_total'] = $value['grand_total'];
                    $arrayCart['description'] = !empty($productInfo[0]->description) ? $productInfo[0]->description : "Lorem Ipsum is simply dummy text";

                    $arrayCart['track_order'] = $value['sale_code'];
                    $arrayCart['transaction_id'] = $value['sale_code'];
                    $arrayCart['order_date'] = date("d-m-Y",$value['sale_datetime']);

                    if(!empty($productInfo[0]->num_of_imgs)){
                        // $num_of_img = explode(",", $row['num_of_imgs']); 
                        $arrayCart['num_of_imgs'] = base_url('uploads/product_image/'.$productInfo[0]->num_of_imgs);
                    }else{
                        $arrayCart['num_of_imgs'] = base_url('uploads/product_image/default.jpg');
                    }


                    $cartArr[] = $arrayCart;
                }

               // $cart_array[]=$response;
            }
            // echo"<pre>"; print_r($cartArr);echo"<pre>";die;
            
            $cart_array['order'] = $cartArr;

            $final_data['status'] = 1;
            $final_data['message'] = 'Order found !';
            $final_data['data'] = $cart_array;
        }else{
            $final_data['status'] = 0;
            $final_data['message'] = 'Order not found !';
        }
        exit(json_encode($final_data));
    }






     // echo"<pre>"; print_r($cartArr);echo"<pre>";die;        
               // $data1 = array();
               // // $data2 = array();

               
                
                
                //  if(!empty($data1)){
                //     $myProductArr = array();    
                //     foreach ($data1 as $k => $vv) {
                //         $respo = array();
                //         $productInfo=$this->Webservice_model->getDataFromTabel('product', 'product_id,title,num_of_imgs', array('product_id'=>$vv->product_id));
                //         $respo['product_id'] = $productInfo[0]->product_id;
                //         $respo['title'] = $productInfo[0]->title;
                //         $respo['qty'] = $data1[$k]->qty;
                //         $respo['grand_total'] = $orderData[$key]['grand_total'];
                //         $respo['description'] = !empty($productInfo[0]->description) ? $productInfo[0]->description : "Lorem Ipsum is simply dummy text";

                //         $respo['track_order'] = $orderData[$key]['sale_code'];
                //         $respo['transaction_id'] = $orderData[$key]['sale_code'];
                //         $respo['order_date'] = date("d-m-Y",$orderData[$key]['sale_datetime']);

                //         if(!empty($productInfo[0]->num_of_imgs)){
                //             // $num_of_img = explode(",", $row['num_of_imgs']); 
                //             $respo['num_of_imgs'] = base_url('uploads/product_image/'.$productInfo[0]->num_of_imgs);
                //         }else{
                //             $respo['num_of_imgs'] = base_url('uploads/product_image/default.jpg');
                //         }
                //         $myProductArr[]=$respo;
                //     }
                // }  
                
                // $cart_array['myorder']= $myProductArr;
                // echo"<pre>"; print_r($myProductArr);die('yes'); //grand_total
                // $cart_array[]=$myProductArr;




    public function my_order_old(){
        $final_data = array();
        $user_id = $this->input->post('user_id');
        // $language_type = $this->input->post('language_type');
        $query = "SELECT * FROM `sale` WHERE `buyer`= ". $user_id ." ORDER BY `sale_datetime` DESC";
        $SQL = $this->db->query($query);
        $orderData = $SQL->result_array();
         // echo"<pre>"; print_r($orderData);
        if ($orderData){
            $cart_array = array();
            foreach ($orderData as $key => $value) {
               $data1 = array();
               // $data2 = array();
               $data1 = json_decode($value['product_details']);
                
                if(!empty($data1)){
                    $myProductArr = array();
                    foreach ($data1 as $k => $vv) {
                        $respo = array();
                        $productInfo=$this->Webservice_model->getDataFromTabel('product', 'product_id,title,num_of_imgs', array('product_id'=>$vv->product_id));
                        $respo['product_id'] = $productInfo[0]->product_id;
                        $respo['title'] = $productInfo[0]->title;
                        $respo['qty'] = 1;//$data1[$k]->qty;
                        $respo['grand_total'] = $orderData[$key]['grand_total'];
                        $respo['description'] = !empty($productInfo[0]->description) ? $productInfo[0]->description : "Lorem Ipsum is simply dummy text";

                        $respo['track_order'] = $orderData[$key]['sale_code'];
                        $respo['transaction_id'] = $orderData[$key]['sale_code'];
                        $respo['order_date'] = date("d-m-Y",$orderData[$key]['sale_datetime']);

                        if(!empty($productInfo[0]->num_of_imgs)){
                            // $num_of_img = explode(",", $row['num_of_imgs']); 
                            $respo['num_of_imgs'] = base_url('uploads/product_image/'.$productInfo[0]->num_of_imgs);
                        }else{
                            $respo['num_of_imgs'] = base_url('uploads/product_image/default.jpg');
                        }
                        $myProductArr[]=$respo;
                    }
                }  
                $cart_array['myorder']= $myProductArr;
                // echo"<pre>"; print_r($myProductArr);die('yes'); //grand_total
                // $cart_array[]=$myProductArr;
            }

            // $cart_array['order'] = $data2;

            $final_data['status'] = 1;
            $final_data['message'] = 'Order found !';
            $final_data['data'] = $cart_array;
        }else{
            $final_data['status'] = 0;
            $final_data['message'] = 'Order not found !';
        }
        exit(json_encode($final_data));
    }




    public function my_wish_list(){
        $user_id =  $this->input->post('user_id');
        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';

        // $language_type = $this->input->post('language_type');
        $where = array('user_id'=>$user_id);
        $wishlistData = $this->Webservice_model->get_data_where('user',$where);
        $wishlisting = !empty($wishlistData[0]['wishlist']) ? json_decode($wishlistData[0]['wishlist']) : "";
        $response = array();
        if(!empty($wishlisting)){

            foreach ($wishlisting as $key) {
                $resp = array();  
                $productInfo=$this->Webservice_model->getDataFromTabel('product', '*', array('product_id'=>$key));
                if(!empty($productInfo)){

                    $default_price = !empty($productInfo[0]->sale_price_AU) ? $productInfo[0]->sale_price_AU : '0';
                    if($currencyType=="AUD"){
                        $sale_price = $default_price;
                    }else if($currencyType=="HKD"){
                        $sale_price = !empty($productInfo[0]->sale_price_HK) ? $productInfo[0]->sale_price_HK : $default_price;
                    }else if($currencyType=="JPY"){
                        $sale_price = !empty($productInfo[0]->sale_price_JP) ? $productInfo[0]->sale_price_JP : $default_price;
                    }else if($currencyType=="SGD"){
                        $sale_price = !empty($productInfo[0]->sale_price_SG) ? $productInfo[0]->sale_price_SG : $default_price;
                    }else{
                        $sale_price = $default_price;
                    }


                    if($productInfo[0]->num_of_imgs !=NULL){
                        $num_of_img = explode(",", $productInfo[0]->num_of_imgs); 
                        $first_image = base_url('uploads/product_image/'.$productInfo[0]->num_of_imgs);
                    }else{
                        $first_image = base_url('uploads/product_image/default.jpg');
                    } 

                    if($productInfo[0]->current_stock > 0 ){
                        $in_stock = 'In Stock'; 
                    }else{
                        $in_stock = 'Sold Out'; 
                    } 
                    $resp['product_id'] = $productInfo[0]->product_id;
                    $resp['product_image'] = $first_image;
                    $resp['title'] = $productInfo[0]->title;
                    $resp['product_status'] = $in_stock;
                    $resp['product_price'] = $sale_price;
                    $resp['discount_price'] =$productInfo[0]->discount;
                    $resp['rating'] = $this->crud_model->getProductRating($productInfo[0]->product_id);
                    
                    $response[] = $resp;
                }
                 // echo "<pre>";print_r($response);die();  
            }   
            $res['status'] = 1;
            $res['message'] = 'Wishlist fetched';
            $res['data'] =  $response;
            
        }else{
            $res['status'] = 0;
            $res['message'] = 'Wishlist is empty';
        }
        
        exit(json_encode($res));
    }




    public function add_to_wish_list(){
        $user_id =  $this->input->post('user_id');
        $product_id = $this->input->post('product_id');

        $this->Webservice_model->add_wish($product_id,$user_id);

        // $res['status'] = 0;
        // $res['message'] = ' Removed from wishlist ';
        
        $res['status'] = 1;
        $res['message'] = ' Successfully added to wishlist ';
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/my_wish_list */
   
/* http://103.15.67.74/pro1/teleboutik/webservices/delete_wish_list_item */

    public function delete_wish_list_item(){
        $user_id =  $this->input->post('user_id');
        
        $product_id = $this->input->post('product_id');

        $this->Webservice_model->remove_wish($product_id,$user_id);

        // $res['status'] = 0;
        // $res['message'] = ' Removed from wishlist ';
        
        $res['status'] = 1;
        $res['message'] = ' Removed from wishlist ';
        exit(json_encode($res));
    }






    /*  http://103.15.67.74/pro1/teleboutik/webservices/get_rating */

    public function get_productRating(){
        $product_id = $this->input->post('product_id');
        // $language_type = $this->input->post('language_type');
        // if($language_type == 'en' || $language_type == 'fr') {
        $query = "SELECT rating.*, us.username FROM `rating` LEFT JOIN user AS us ON rating.user_id = us.user_id WHERE product_id =".$product_id;
        $SQL = $this->db->query($query);
        $data = $SQL->result_array();
        if($data){
            $res['status'] = 1;
            $res['message'] = 'Result found successfully';
            $res['data'] = $data;
        }else{
            $res['status'] = 0;
            $res['message'] = 'No result found ! ';
        }
        // }else{
        //     $res['status'] = 0;
        //     $res['message'] = 'Language error ! ';
        // }
        
        exit(json_encode($res));
    }



    public function getRatingList(){
        $user_id = $this->input->post('user_id');
        $url = site_url() . 'uploads/product_image/';
        $field = "rating.*,us.username,p.product_id,p.title,p.description,p.main_image, CONCAT('" . $url . "', p.main_image) as main_image";

        $query = "SELECT ".$field." FROM `rating` INNER JOIN user AS us ON rating.user_id = us.user_id INNER JOIN product AS p ON rating.product_id = p.product_id WHERE rating.user_id =".$user_id;
        $SQL = $this->db->query($query);
        $data = $SQL->result_array();
        if($data){
            $res['status'] = 1;
            $res['message'] = 'Result found successfully';
            $res['data'] = $data;
        }else{
            $res['status'] = 0;
            $res['message'] = 'No result found ! ';
        }
        exit(json_encode($res));
    }



         


//////////////////////////////// START CART //////////////////////////////////

/* http://103.15.67.74/pro1/teleboutik/webservices/add_to_cart */

    public function add_to_cart(){
        // echo "<pre>"; print_r($_POST);die;
        $user_id = $this->input->post('user_id');

        $product_id = $this->input->post('product_id');
        $qty = $this->input->post('qty');          
        $color = $this->input->post('color') ? $this->input->post('color') : "";
        $type = $this->input->post('type') ? $this->input->post('type') : "";

        $data['options']  = "";
        $data['type']  = $type;
        $data['user_id'] = $user_id ;
        $data['product_id'] = $product_id ;          
        $data['qty'] = $qty ;          
        $data['color'] = $color ;                   
        $dataUp['qty']= $qty;
        $dataUp['type']= $type;

        $where = array('product_id'=>$product_id, 'user_id'=>$user_id);
        $cartData = $this->Webservice_model->get_data_where('forCart',$where);


        if (empty($cartData)) {
            $rtrnInsertId = $this->Webservice_model->insert_data('forCart',$data);
            $res['status'] = 1;
            $res['message'] = 'Added to cart';
        }else{
            $whereIs = array('product_id'=>$product_id, 'user_id'=>$user_id);
            $returnData = $this->Webservice_model->update_data('forCart',$dataUp, $where);


            $res['status'] = 1;
            $res['message'] = 'Cart updated';
        }

        $cartitem = $this->Webservice_model->countResult('forCart', array('user_id' => $user_id));
        $res['total_cart_item'] = !empty($cartitem) ? $cartitem : 0;

        
         exit(json_encode($res));
    }





/* http://103.15.67.74/pro1/teleboutik/webservices/my_cart_items */
/*
    public function my_cart_items(){

        $user_id =  $this->input->post('user_id');
        // $language_type = $this->input->post('language_type');

        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';


        $where = array('user_id'=>$user_id);
        $cartContent = $this->Webservice_model->get_data_where('forCart',$where);
        if(!empty($cartContent)){
            foreach ($cartContent as $key => $value) {

                $where = array('product_id'=> $value['product_id']);
                $productDetail = $this->Webservice_model->get_data_where('product', $where);
                // echo "<pre>"; print_r($productDetail);echo "<pre>";
                

                if(!empty($productDetail[0]['num_of_imgs'])){
                    // $num_of_img = explode(",", $productDetail[0]['num_of_imgs']); 
                    $cartContent[$key]['images'] = base_url('uploads/product_image/'.$productDetail[0]['num_of_imgs']); //$images;    
                }else{
                    $cartContent[$key]['images'] = base_url('uploads/product_image/default.jpg');
                }

                $cartContent[$key]['title']  = $productDetail[0]['title'];


                $default_price = !empty($productDetail[0]['sale_price_AU']) ? $productDetail[0]['sale_price_AU'] : '0';
                if($currencyType=="AUD"){
                    $sale_price = $default_price;
                }else if($currencyType=="HKD"){
                    $sale_price = !empty($productDetail[0]['sale_price_HK']) ? $productDetail[0]['sale_price_HK'] : $default_price;
                }else if($currencyType=="JPY"){
                    $sale_price = !empty($productDetail[0]['sale_price_JP']) ? $productDetail[0]['sale_price_JP'] : $default_price;
                }else if($currencyType=="SGD"){
                    $sale_price = !empty($productDetail[0]['sale_price_SG']) ? $productDetail[0]['sale_price_SG'] : $default_price;
                }else{
                    $sale_price = $default_price;
                }



                // $rrp=$productDetail[0]['bundle_sale1'];
                $wholesale=$productDetail[0]['wholesale'];
                $bundle_discount1=$productDetail[0]['bundle_discount1'];

                $discount = ($bundle_discount1) ? ($bundle_discount1/100) : 0;
        

                if($productDetail[0]['limited_release']=="Yes"){
                    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
        
                    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
                }else{
                    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
        
                    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
                }

        
                $gap_revenue = $rrp - $wholesale;
                $gap_revenue_commission = $gap_revenue * $commission_amount;    
                $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);
                $total_discount = $orp * $discount;
                $total_orp = $orp /*- $total_discount;  


                $saving = (($bundle_sale1*$value['qty'])-($bundle_sale1*$value['qty']))+$total_discount;


                $cartContent[$key]['discount']      = !empty($total_discount*$value['qty']) ? $total_discount : "";
                $cartContent[$key]['sale_price']    = doubleval($rrp*$value['qty']);
                $cartContent[$key]['saving'] = $saving*$value['qty'];

                $cartContent[$key]['total_orp'] = $total_orp*$value['qty'];


                $stock = $this->crud_model->get_type_name_by_id('product', $value['product_id'], 'current_stock');
                if($stock == 0){
                     $cartContent[$key]['is_available'] = 0;
                }else{
                     $cartContent[$key]['is_available'] = 1;
                }
            }
       

            $alcohol_list = array('8.5');
            $volume_list = array('750');
            $price_list = array('35');
            $quantity_list = array('1');
            $weight_list = array('1.5');
            $category_product_list = array('WINE');
          
        

       
            $Streetlines = array('3 Chome-5-4 Shinjuku, Shinjuku City, Tokyo 160-0022, Japan');
            $data = array(
                        "api_key" =>"p6RertCvahmbQm28Byky",
                        "type" => "overseas",
                        "alcohol_list" => $alcohol_list,
                        "volume_list" => $volume_list,
                        "price_list" => $price_list,
                        "quantity_list" => $quantity_list,
                        "weight_list"=> $weight_list,
                        "category_product_list" => $category_product_list,
                        "category_product_sum" => 1,
                        "total_quantity" => 1,
                        "recipient_details" => array(
                            "PersonName" => 'John William',
                            "CompanyName" => "Google",
                            "PhoneNumber" => "0452593389",
                            "Address" => array(
                                "Streetlines" => $Streetlines,
                                "City" => "Tokyo",
                                "StateOrProvinceCode" => "JP",
                                "PostalCode" => "160-0022",
                                "CountryCode" => "JP",
                                "Residental" => false
                            )
                        )
                    );


            $url = 'http://www.ishipping.com.au/API/V1/php/Rate/calculate_rate.php';

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

            


            $cartContent[$key]['ishipping_data'] = json_decode($result);
            $res['status'] = 1;
            $res['message'] = ' Showing cart items ';
            $res['cart_data'] = $cartContent ;
        }else{
            $res['status'] = 0;
            $res['message'] = ' Cart is empty ';
        }
        exit(json_encode($res)); 
    }*/






    public function my_cart_items()
    {
        $total_discount = 0;
        $discount_total_item = 0;
        $total_cashback_discount = 0;
        $productKey = 0;

        $total_saving = 0;
        $total_promocode = 0;

        $total_sub_total = 0;


        $user_id =  $this->input->post('user_id');

        $cartitem = $this->Webservice_model->countResult('forCart', array('user_id' => $user_id));


        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';
        
        $cashback_product = $this->db->get_where('coupon')->result_array();

        $current_date = date('Y-m-d');

        $itemArr = array();
        $cart_array = array();
        $where = array('user_id'=>$user_id);
        $cartContent = $this->Webservice_model->get_data_where('forCart',$where);
        if(!empty($cartContent)){
            foreach ($cartContent as $item) {
                


                $response = array();
                $where = array('product_id'=> $item['product_id']);
                $productDetail = $this->Webservice_model->get_data_where('product', $where);
                
                

                if(!empty($productDetail[0]['num_of_imgs'])){
                    // $num_of_img = explode(",", $productDetail[0]['num_of_imgs']); 
                    $response['images'] = base_url('uploads/product_image/'.$productDetail[0]['num_of_imgs']); //$images;    
                }else{
                    $response['images'] = base_url('uploads/product_image/default.jpg');
                }
                // echo "<pre>"; print_r($item['qty']);echo "<pre>";die; 

                $response['title']  = $productDetail[0]['title'];
                $response['qty']  = $item['qty'];


                $default_price = !empty($productDetail[0]['sale_price_AU']) ? $productDetail[0]['sale_price_AU'] : 0;
                if($currencyType=="AUD"){
                    $sale_price = $default_price;
                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'aud_tax'))->row()->value;

                }else if($currencyType=="HKD"){
                    $sale_price = !empty($productDetail[0]['sale_price_HK']) ? $productDetail[0]['sale_price_HK'] : $default_price;

                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'hkd_tax'))->row()->value;
                }else if($currencyType=="JPY"){
                    $sale_price = !empty($productDetail[0]['sale_price_JP']) ? $productDetail[0]['sale_price_JP'] : $default_price;

                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'jpy_tax'))->row()->value;
                }else if($currencyType=="SGD"){
                    $sale_price = !empty($productDetail[0]['sale_price_SG']) ? $productDetail[0]['sale_price_SG'] : $default_price;


                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'sgd_tax'))->row()->value;
                }else{
                    $sale_price = $default_price;
                }
                
                $rrp = $sale_price*$item['qty'];
                
                $response['rrp']  = $rrp;
                $wholesale = $productDetail[0]['wholesale']*$item['qty'];

                if($product_details->limited_release =="Yes"){
                    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
                
                    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
                }else{
                    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
                
                    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
                }

                $discount = !empty($productDetail[0]['discount']) ? $productDetail[0]['discount'] : 0;  

                $limited_release = !empty($productDetail[0]['limited_release']) ? $productDetail[0]['limited_release'] : 0;

                $total_discount =  ($orpData['orp']*($discount/100));
                    
                $orpData=$this->get_orp($rrp,$wholesale,$discount,$limited_release);


                $total_sub_total_orp = $orpData['orp'] - ($orpData['orp']*($discount/100));

                $response['orp']  = $orpData['orp'];
                $response['saving']  = '0';
                $response['type']  = $item['type'];
                $response['product_id']  = $item['product_id'];
                $response['user_id']  = $item['user_id'];


                $gap_revenue = $rrp - $wholesale;
                $gap_revenue_commission = $gap_revenue * $commission_amount;    
                $orp = $rrp - (($gap_revenue - $gap_revenue_commission)*$orp_commission_amount);

               
                $total_discount = ($orp*($discount/100));

                $promocode = ($variationqty_arr->promocode_cal_discount_price > 0) ? $variationqty_arr->promocode_cal_discount_price *$items['qty'] : 0;

                $saving = ($rrp - $orp)+$total_discount;

                $total_sub_total_orp = $orp - ($orp*($discount/100));
                            

                $producttotal += $rrp;
                $total_saving += $saving;
                $total_promocode += $promocode;
                $total_discounts += $total_discount;
                $total_sub_total += $total_sub_total_orp;


                if(!empty($cashback_product))
                {
                    foreach($cashback_product as $key => $val) 
                    {
                        $already_add_product_ar = json_decode($val['spec']);

                        if(strtotime($val['till']) > strtotime($current_date))
                        {
                            $till_ar[] = strtotime($val['till']);

                            foreach(json_decode($already_add_product_ar->set) as $key => $productids) {
                                if($productids == $optiondata['productid']) {
                                   $productKey =  $productids;
                                   $discount_value = $already_add_product_ar->discount_value;
                                   $discount_type = $already_add_product_ar->discount_type;
                                }
                            }
                        }
                    }
                }


                if($productKey > 0 ) {
                    if($discount_type=='percent'){
                        $cashback_price += (($for_producttotal * ($discount_value/100))*$items['qty']);
                    }else{
                        $cashback_price += (($discount_value)*$value['qty']);
                    }
                }    
                $total_cashback_discount =  round($cashback_price, 2);                 
                
                $response['cashback']  = $total_cashback_discount;

                $coupon_price = currency($optiondata['coupon_price']);

                $ship  = 0;//currency($ship);
                //$tax   = print_r($ishipping);
                
                $shipping = 0;              
                
                // $this->session->set_userdata('total_cashback_discount',$total_cashback_discount);

                $total_cashback_discount = 0;              
                    
                $tax = ($producttotal - $total_discounts)*($currency_tax/100);
                $sub_total= ($total_sub_total + $tax)-$total_promocode;
                $grand = $sub_total + $shipping;            

                $cart_array['total_promocode']  = $total_promocode;
                $cart_array['coupon_price']  = $coupon_price;                
                $cart_array['producttotal']  = $producttotal;
                $cart_array['ship']  = $ship;
                $cart_array['tax']  = $tax;
                $cart_array['grand_total']  = $grand;
                $cart_array['total_saving']  = $total_saving;
                $cart_array['sub_total']  = $sub_total;

                // echo currency($producttotal) . '-' . $ship . '-' . currency($tax) . '-' . currency($grand) . '-' . $count . '-' . currency($total_saving) . '-' . $total_cashback_discount . '-' . currency($sub_total) . '-' . $coupon_price . '-' . currency($total_promocode);

                // $this->session->set_userdata('grand_total',$grand);

                $itemArr[] = $response;
            }
       
            // echo "<pre>"; print_r($cart_array);die;
            $alcohol_list = array('8.5');
            $volume_list = array('750');
            $price_list = array('35');
            $quantity_list = array('1');
            $weight_list = array('1.5');
            $category_product_list = array('WINE');
          
            
            $deliveryAdd=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id));

            
            if(!empty($deliveryAdd)){
                if(count($deliveryAdd)=='1'){
                    $name =  $deliveryAdd[0]->name;
                    $mobile =  $deliveryAdd[0]->mobile;
                    $city =  $deliveryAdd[0]->city;
                    $state =  $deliveryAdd[0]->state;
                    $country =  $deliveryAdd[0]->country;

                    $post_code =  $deliveryAdd[0]->post_code;
                    $country_code =  $deliveryAdd[0]->country_code;
                    $address1 =  $deliveryAdd[0]->address1;

                }else{
                    $name =  $deliveryAdd[1]->name;
                    $mobile =  $deliveryAdd[1]->mobile;
                    $city =  $deliveryAdd[1]->city;
                    $state =  $deliveryAdd[1]->state;
                    $country =  $deliveryAdd[1]->country;

                    $post_code =  $deliveryAdd[1]->post_code;
                    $country_code =  $deliveryAdd[1]->country_code;
                    $address1 =  $deliveryAdd[1]->address1;
                } 

                $CountryCode="AU";
                if($country_code=="+81"){
                    $CountryCode="JP";
                }else if($country_code=="+61"){
                    $CountryCode="AU";
                }else if($country_code=="+65"){
                    $CountryCode="SG";
                }else if($country_code=="+852"){
                    $CountryCode="HK";
                }


                $Streetlines = array($address1);
                $data = array(
                    "api_key" =>"p6RertCvahmbQm28Byky",
                    "type" => "overseas",
                    "alcohol_list" => $alcohol_list,
                    "volume_list" => $volume_list,
                    "price_list" => $price_list,
                    "quantity_list" => $quantity_list,
                    "weight_list"=> $weight_list,
                    "category_product_list" => $category_product_list,
                    "category_product_sum" => 1,
                    "total_quantity" => 1,
                    "recipient_details" => array(
                        "PersonName" => $name,
                        "CompanyName" => "Google",
                        "PhoneNumber" => $mobile,
                        "Address" => array(
                            "Streetlines" => $Streetlines,
                            "City" => $city,
                            "StateOrProvinceCode" => $state,
                            "PostalCode" => $post_code,
                            "CountryCode" => $CountryCode,
                            "Residental" => false
                        )
                    )
                );

                // echo "<pre>"; print_r($data);die;

                // $Streetlines = array('3 Chome-5-4 Shinjuku, Shinjuku City, Tokyo 160-0022, Japan');
                // $data = array(
                //     "api_key" =>"p6RertCvahmbQm28Byky",
                //     "type" => "overseas",
                //     "alcohol_list" => $alcohol_list,
                //     "volume_list" => $volume_list,
                //     "price_list" => $price_list,
                //     "quantity_list" => $quantity_list,
                //     "weight_list"=> $weight_list,
                //     "category_product_list" => $category_product_list,
                //     "category_product_sum" => 1,
                //     "total_quantity" => 1,
                //     "recipient_details" => array(
                //         "PersonName" => 'John William',
                //         "CompanyName" => "Google",
                //         "PhoneNumber" => "0452593389",
                //         "Address" => array(
                //             "Streetlines" => $Streetlines,
                //             "City" => "Tokyo",
                //             "StateOrProvinceCode" => "JP",
                //             "PostalCode" => "160-0022",
                //             "CountryCode" => "JP",
                //             "Residental" => false
                //         )
                //     )
                // );


                $url = 'http://www.ishipping.com.au/API/V1/php/Rate/calculate_rate.php';

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
                $cart_array['ishipping_data'] = json_decode($result);
            }else{
                // $cart_array['ishipping_data'] = "";
                $res['status'] = 0;
                $res['message'] = 'Please add Address first';
            }

                
                

                $res['status'] = 1;
                $res['message'] = ' Showing cart items ';
                $res['total_cart_item'] = !empty($cartitem) ? $cartitem : 0;

                $res['cart_total'] = $cart_array;
                $res['cart_data'] = $itemArr;

            // }else{
            //     //error address
            //     $res['status'] = 0;
            //     $res['message'] = 'Please add Address first';
            // }

       
        }else{
            $res['status'] = 0;
            $res['message'] = ' Cart is empty ';
        }
        exit(json_encode($res)); 
    }






    


    public function my_cart_items_old(){
        $total_discount = 0;
        $discount_total_item = 0;
        $total_cashback_discount = 0;
        $productKey = 0;

        $user_id =  $this->input->post('user_id');

        $currency_type = $this->input->post('currency_type');
        $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';
        
        $cashback_product = $this->db->get_where('coupon')->result_array();

        $current_date = date('Y-m-d');

        $cart_array = array();
        $where = array('user_id'=>$user_id);
        $cartContent = $this->Webservice_model->get_data_where('forCart',$where);
        if(!empty($cartContent)){
            foreach ($cartContent as $key => $value) {

                $where = array('product_id'=> $value['product_id']);
                $productDetail = $this->Webservice_model->get_data_where('product', $where);
                // echo "<pre>"; print_r($productDetail);echo "<pre>";
                

                if(!empty($productDetail[0]['num_of_imgs'])){
                    // $num_of_img = explode(",", $productDetail[0]['num_of_imgs']); 
                    $cartContent[$key]['images'] = base_url('uploads/product_image/'.$productDetail[0]['num_of_imgs']); //$images;    
                }else{
                    $cartContent[$key]['images'] = base_url('uploads/product_image/default.jpg');
                }

                $cartContent[$key]['title']  = $productDetail[0]['title'];


                $default_price = !empty($productDetail[0]['sale_price_AU']) ? $productDetail[0]['sale_price_AU'] : '0';
                if($currencyType=="AUD"){
                    $sale_price = $default_price;
                }else if($currencyType=="HKD"){
                    $sale_price = !empty($productDetail[0]['sale_price_HK']) ? $productDetail[0]['sale_price_HK'] : $default_price;
                }else if($currencyType=="JPY"){
                    $sale_price = !empty($productDetail[0]['sale_price_JP']) ? $productDetail[0]['sale_price_JP'] : $default_price;
                }else if($currencyType=="SGD"){
                    $sale_price = !empty($productDetail[0]['sale_price_SG']) ? $productDetail[0]['sale_price_SG'] : $default_price;
                }else{
                    $sale_price = $default_price;
                }


                $rrp = $sale_price*$value['qty'];
                $wholesale = $productDetail[0]['wholesale']*$value['qty'];

                if($product_details->limited_release =="Yes"){
                    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_orp_commission_amount'))->row()->value)/100;
                
                    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'limit_admin_commission_amount'))->row()->value)/100;   
                }else{
                    $orp_commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_orp_commission_amount'))->row()->value)/100;
                
                    $commission_amount = ($this->db->get_where('business_settings', array('type' => 'nolimit_admin_commission_amount'))->row()->value)/100;
                }


                $producttotal += $rrp;
                $total_saving += $saving;
                $total_promocode += $promocode;
                $total_discounts += $total_discount;
                $total_sub_total += $total_sub_total_orp;

                if(!empty($cashback_product)){
                    foreach($cashback_product as $key => $val) {
                        $already_add_product_ar = json_decode($val['spec']);

                        if(strtotime($val['till']) > strtotime($current_date)){
                            $till_ar[] = strtotime($val['till']);

                            foreach(json_decode($already_add_product_ar->set) as $key => $productids) {
                                if($productids == $optiondata['productid']) {
                                   $productKey =  $productids;
                                   $discount_value = $already_add_product_ar->discount_value;
                                   $discount_type = $already_add_product_ar->discount_type;
                                }
                            }
                        }
                    }
                }


                if($productKey > 0 ) {
                    if($discount_type=='percent'){
                        $cashback_price += (($for_producttotal * ($discount_value/100))*$items['qty']);
                    }else{
                        $cashback_price += (($discount_value)*$value['qty']);
                    }
                }    
                $total_cashback_discount =  round($cashback_price, 2);
                 
                $coupon_price = currency($optiondata['coupon_price']);

                $ship  = 0;//currency($ship);
                //$tax   = print_r($ishipping);
                
                $shipping = 0;              
                
                // $this->session->set_userdata('total_cashback_discount',$total_cashback_discount);

                $total_cashback_discount = 0;



                $default_price = !empty($productDetail[0]['sale_price_AU']) ? $productDetail[0]['sale_price_AU'] : '0';
                if($currencyType=="AUD"){
                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'aud_tax'))->row()->value;
                }
                if($currencyType=="HKD"){
                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'hkd_tax'))->row()->value;
                }
                if($currencyType=="JPY"){
                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'jpy_tax'))->row()->value;
                }
                if($currencyType=="SGD"){
                    $currency_tax  = $this->db->get_where('business_settings', array('type' => 'sgd_tax'))->row()->value;
                }

             
                
                $tax = ($producttotal - $total_discounts)*($currency_tax/100);
                $sub_total= ($total_sub_total + $tax)-$total_promocode;
                $grand = $sub_total + $shipping;
                
                $cart_array['total_promocode']  = $total_promocode;
                $cart_array['coupon_price']  = $coupon_price;
                
                $cart_array['producttotal']  = $producttotal;
                $cart_array['ship']  = $ship;
                $cart_array['tax']  = currency($tax);
                $cart_array['grand_total']  = currency($grand);
                $cart_array['total_saving']  = currency($total_saving);
                $cart_array['sub_total']  = currency($sub_total);

                // echo currency($producttotal) . '-' . $ship . '-' . currency($tax) . '-' . currency($grand) . '-' . $count . '-' . currency($total_saving) . '-' . $total_cashback_discount . '-' . currency($sub_total) . '-' . $coupon_price . '-' . currency($total_promocode);

                // $this->session->set_userdata('grand_total',$grand);


            }
       
            // echo "<pre>"; print_r($cart_array);die;
            $alcohol_list = array('8.5');
            $volume_list = array('750');
            $price_list = array('35');
            $quantity_list = array('1');
            $weight_list = array('1.5');
            $category_product_list = array('WINE');
          
            
            $deliveryAdd=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id));

            
            if(!empty($deliveryAdd)){
                if(count($deliveryAdd)=='1'){
                    $name =  $deliveryAdd[0]->name;
                    $mobile =  $deliveryAdd[0]->mobile;
                    $city =  $deliveryAdd[0]->city;
                    $state =  $deliveryAdd[0]->state;
                    $country =  $deliveryAdd[0]->country;

                    $post_code =  $deliveryAdd[0]->post_code;
                    $country_code =  $deliveryAdd[0]->country_code;
                    $address1 =  $deliveryAdd[0]->address1;

                }else{
                    $name =  $deliveryAdd[1]->name;
                    $mobile =  $deliveryAdd[1]->mobile;
                    $city =  $deliveryAdd[1]->city;
                    $state =  $deliveryAdd[1]->state;
                    $country =  $deliveryAdd[1]->country;

                    $post_code =  $deliveryAdd[1]->post_code;
                    $country_code =  $deliveryAdd[1]->country_code;
                    $address1 =  $deliveryAdd[1]->address1;
                } 

                // $Streetlines = array($address1);
                // $data = array(
                //     "api_key" =>"p6RertCvahmbQm28Byky",
                //     "type" => "overseas",
                //     "alcohol_list" => $alcohol_list,
                //     "volume_list" => $volume_list,
                //     "price_list" => $price_list,
                //     "quantity_list" => $quantity_list,
                //     "weight_list"=> $weight_list,
                //     "category_product_list" => $category_product_list,
                //     "category_product_sum" => 1,
                //     "total_quantity" => 1,
                //     "recipient_details" => array(
                //         "PersonName" => $name,
                //         "CompanyName" => "Google",
                //         "PhoneNumber" => $mobile,
                //         "Address" => array(
                //             "Streetlines" => $Streetlines,
                //             "City" => $city,
                //             "StateOrProvinceCode" => $country_code,
                //             "PostalCode" => $post_code,
                //             "CountryCode" => $country_code,
                //             "Residental" => false
                //         )
                //     )
                // );
                $Streetlines = array('3 Chome-5-4 Shinjuku, Shinjuku City, Tokyo 160-0022, Japan');
                $data = array(
                    "api_key" =>"p6RertCvahmbQm28Byky",
                    "type" => "overseas",
                    "alcohol_list" => $alcohol_list,
                    "volume_list" => $volume_list,
                    "price_list" => $price_list,
                    "quantity_list" => $quantity_list,
                    "weight_list"=> $weight_list,
                    "category_product_list" => $category_product_list,
                    "category_product_sum" => 1,
                    "total_quantity" => 1,
                    "recipient_details" => array(
                        "PersonName" => 'John William',
                        "CompanyName" => "Google",
                        "PhoneNumber" => "0452593389",
                        "Address" => array(
                            "Streetlines" => $Streetlines,
                            "City" => "Tokyo",
                            "StateOrProvinceCode" => "JP",
                            "PostalCode" => "160-0022",
                            "CountryCode" => "JP",
                            "Residental" => false
                        )
                    )
                );


                $url = 'http://www.ishipping.com.au/API/V1/php/Rate/calculate_rate.php';

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



                $cart_array['ishipping_data'] = json_decode($result);
                

                $res['status'] = 1;
                $res['message'] = ' Showing cart items ';
                $res['cart_total'] = $cart_array;
                $res['cart_data'] = $cartContent ;

            }else{
                //error address
                $res['status'] = 0;
                $res['message'] = 'Please add Address first';
            }

       
        }else{
            $res['status'] = 0;
            $res['message'] = ' Cart is empty ';
        }
        exit(json_encode($res)); 
    }






    public function add_address(){
        // echo "<pre>"; print_r($_POST);die;
        $addressArr1 = array();
        $addressArr2 = array();
        $user_id=$this->input->post('user_id');
        $addressArr1['user_id'] =  $user_id;
        $addressArr1['name'] = $this->input->post('name');
        $addressArr1['email'] = $this->input->post('email');
        $is_addres = $this->input->post('is_addres');
        $addressArr1['mobile'] =  $this->input->post('mobile');
        $addressArr1['address1'] = $this->input->post('address1');
        $addressArr1['address2'] = $this->input->post('address2');
        $addressArr1['city'] =  $this->input->post('city');
        $addressArr1['state'] = $this->input->post('state');
        $addressArr1['country'] = $this->input->post('country');
        $addressArr1['post_code'] = $this->input->post('post_code');
        $addressArr1['country_code'] = $this->input->post('country_code');
        $addressArr1['address_type'] =  '1'; //delivery address
        $addressArr2['email'] = $this->input->post('email1');
        $addressArr2['user_id'] =  $user_id;
        $addressArr2['name'] = $this->input->post('name1');
        $addressArr2['mobile'] =  $this->input->post('mobile1');
        $addressArr2['address1'] = $this->input->post('address11');
        $addressArr2['address2'] = $this->input->post('address21');
        $addressArr2['city'] =  $this->input->post('city1');
        $addressArr2['state'] = $this->input->post('state1');
        $addressArr2['country'] = $this->input->post('country1');
        $addressArr2['country_code'] = $this->input->post('country_code1');
        $addressArr2['post_code'] = $this->input->post('post_code1');
        $addressArr2['address_type'] =  '2'; //billing address


        $deliveryAdd=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id,'address_type'=>'1'));
        if(!empty($deliveryAdd)){
            $upData=array(
                'name'=>$this->input->post('name'),
                'email'=>$this->input->post('email'),
                'mobile'=>$this->input->post('mobile'),
                'address1'=> $this->input->post('address1'),
                'address2' => $this->input->post('address2'),
                'city' =>  $this->input->post('city'),
                'state'=> $this->input->post('state'),
                'country'=> $this->input->post('country'),
                'post_code'=> $this->input->post('post_code'),
                'country_code'=> $this->input->post('country_code'),
            );
            // echo "<pre>"; print_r($upData);die;
            $this->Webservice_model->updateDataFromTabel("delivery_address",$upData,array('user_id'=>$user_id,'address_type'=>'1'));    
        }else{
            $this->Webservice_model->addDataIntoTable('delivery_address',$addressArr1);
        }

        
        if($is_addres==1){
            $deliveryAdd=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id,'address_type'=>'2'));

            if(!empty($deliveryAdd)){
                $upData1=array(
                    'name'=>$this->input->post('name1'),
                    'email'=>$this->input->post('email1'),
                    'mobile'=>$this->input->post('mobile1'),
                    'address1'=> $this->input->post('address11'),
                    'address2' => $this->input->post('address21'),
                    'city' =>  $this->input->post('city1'),
                    'state'=> $this->input->post('state1'),
                    'country'=> $this->input->post('country1'),
                    'post_code'=> $this->input->post('post_code1'),
                    'country_code'=> $this->input->post('country_code1'),
                );
                $this->Webservice_model->updateDataFromTabel("delivery_address",$upData1,array('user_id'=>$user_id,'address_type'=>'2'));    
            }else{
                $this->Webservice_model->addDataIntoTable('delivery_address',$addressArr2);
            }
        }
        $res['status'] = 1;
        $res['message'] = 'Delivery address added';
    
        
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/get_address */

    public function get_address(){
        $user_id = $this->input->post('user_id');
        
        $addressData=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id));
        // print_r($addressData);die();

        if(!empty($addressData)){
            $res['status'] = 1;
            $res['message'] = 'Delivery address fetched';
            $res['data'] = $addressData;
            // $res['data'] = $data;
        }else{
            $res['status'] = 0;
            $res['message'] = 'Data not found';
        }
        exit(json_encode($res));
    }





    //     $carted = $this->cart->contents();
    //     
    //     $carted   = $this->cart->contents();
    //     $total    = $this->cart->total();
    //     $exchange = exchange('usd');
    //     $vat_per  = '';
    //     $vat      = $this->crud_model->cart_total_it('tax');
        
    //     $shipping = ($this->session->userdata('ishipping_total_price')) ? $this->session->userdata('ishipping_total_price') : 0;
        
    //     $grand_total     = $total + $shipping;
    //     $product_details = json_encode($carted);
        
    //     $this->db->where('user_id', $this->session->userdata('user_id'));
    //     $this->db->update('user', array(
    //         'langlat' => $this->input->post('langlat')
    //     ));




    // function checkstripe(){
    //     $user_id =  $this->input->post('user_id');
    //     $userAddress=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id));
    //     echo "<pre>"; print_r($userAddress);die;
    // }



//     user_id:321
// amount:10
// payment_type:wallet/stripe
// stripe_token:transaction_id
   /* function check_out(){
        $addressArr = array();
        $total =  $this->input->post('amount');
        
        $user_id =  $this->input->post('user_id');
        $amount = $this->input->post('amount');
        $stripe_token = $this->input->post('stripe_token');
        $payment_type=$this->input->post('payment_type');
        $query = "SELECT forCart_id,user_id,product_id,qty  FROM `forCart` WHERE user_id =".$user_id;
        $SQL = $this->db->query($query);
        $carted = $SQL->result_array();

        $shipping = 0;
        
        $grand_total = $total + $shipping;
        // $total    = $this->cart->total();
        $exchange = exchange('usd');
        $vat_per  = '';
        $vat      = $this->crud_model->cart_total_it('tax');
        
        // $shipping = ($this->session->userdata('ishipping_total_price')) ? $this->session->userdata('ishipping_total_price') : 0;
        $grand_total     = $total + $shipping;
        $product_details = json_encode($carted);
        


        $userAddress=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id));
        
        if ($payment_type == 'wallet') {
            $balance = $this->wallet_model->user_balance();
            $balance = !empty($balance) ? $balance : "10000";
            
            if($balance >= $grand_total){
                $data['buyer']             = $user_id;
                $data['product_details']   = $product_details;
                $data['shipping_address']  = json_encode($addressArr);
                $data['vat']               = !empty($vat) ? $vat : '0';
                $data['vat_percent']       = !empty($vat_per) ? $vat_per : '0';
                $data['shipping']          = $shipping;
                $data['delivery_status']   = '[]';
                $data['payment_type']      = 'wallet';
                $data['payment_status']    = '[]';
                $data['payment_details']   = '';
                $data['grand_total']       = $grand_total;
                $data['sale_datetime']     = time();
                $data['delivary_datetime'] = '';
                $this->db->insert('sale', $data);
                $sale_id  = $this->db->insert_id();
                // $sale_id = "842";
                $vendors = $this->crud_model->vendors_in_sale($sale_id);
                
                $delivery_status = array();
                $payment_status = array();
                foreach ($vendors as $p) {
                    $delivery_status[] = array('vendor'=>$p,'status'=>'pending','delivery_time'=>'');
                    $payment_status[] = array('vendor'=>$p,'status'=>'paid');
                }
                if($this->crud_model->is_admin_in_sale($sale_id)){
                    $delivery_status[] = array('admin'=>'','status'=>'pending','delivery_time'=>'');
                    $payment_status[] = array('admin'=>'','status'=>'paid');
                }
                $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                $data['delivery_status'] = json_encode($delivery_status);
                $data['payment_status'] = json_encode($payment_status);


                $this->db->where('sale_id', $sale_id);
                $this->db->update('sale', $data);
                $total_coupon_price = 0;

                foreach ($carted as $value) {
                    // $optiondata = json_decode($value['option'],true);
                    // $total_coupon_price += $optiondata['coupon_price'];                            

                    $this->crud_model->decrease_quantity($value['product_id'], $value['qty']);
                    $data1['type']    = 'destroy';
                    $data1['category']     = $this->db->get_where('product', array(
                            'product_id' => $value['product_id']
                        ))->row()->category;
                        $data1['sub_category'] = $this->db->get_where('product', array(
                            'product_id' => $value['product_id']
                        ))->row()->sub_category;
                    $data1['product']      = $value['product_id'];
                    $data1['quantity']     = $value['qty'];
                    $data1['total']        = 0;
                    $data1['reason_note']  = 'sale';
                    $data1['sale_id']      = $sale_id;
                    $data1['datetime']     = time();


                    $this->db->insert('stock', $data1);
                }

                // $this->wallet_model->reduce_user_balance($grand_total,$user_id);
                // $this->crud_model->digital_to_customer($sale_id);
                // $this->crud_model->email_invoice($sale_id);
                // $this->cart->destroy();
                // $this->session->set_userdata('couponer','');
                //echo $sale_id;
                // redirect(base_url() . 'home/thankyou/' . $sale_id, 'refresh');

                
                $this->Webservice_model->deleteRow('forCart',array('user_id'=>$user_id));

                $res['status'] = 1;
                $res['message'] = 'product checkout Successfully';

                
            } 
        } else if ($payment_type == 'stripe') {
            if(!empty($stripe_token)) {
                // if(isset($_POST['stripeToken'])) {
                require_once(APPPATH . 'libraries/stripe-php/init.php');
                $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
                    \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                $customer_email = $this->db->get_where('user' , array('user_id' => $user_id))->row()->email;
                    
                $customer = \Stripe\Customer::create(array(
                    'email' => $customer_email, // customer email id
                    'card'  => $stripe_token
                ));

                $charge = \Stripe\Charge::create(array(
                    'customer'  => $customer->id,
                    'amount'    => ceil($grand_total*100/$exchange),
                    'currency'  => 'USD'
                ));

                if($charge->paid == true){
                    $customer = (array) $customer;
                    $charge = (array) $charge; 

                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = json_encode($userAddress);
                    $data['vat']               = $vat;
                    $data['vat_percent']       = $vat_per;
                    $data['shipping']          = !empty($shipping) ? $shipping : 0;
                    $data['delivery_status']   = 'pending';
                    $data['payment_type']      = 'stripe';
                    $data['payment_status']    = 'paid';
                    $data['payment_details']   = "Customer Info: \n".json_encode($customer,true)."\n \n Charge Info: \n".json_encode($charge,true);
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
                        
                    $this->db->insert('sale', $data);
                        //echo $this->db->last_query();
                    $sale_id = $this->db->insert_id();
                    
                    $data['buyer'] = $user_id;    
                    
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                        


                    $delivery_status = array();
                    $payment_status = array();
                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','comment'=> '','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'paid');
                    }
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','comment'=> '','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'paid');
                    }
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);


                    if($data['sale_code']){
                        $data['ishipping_request_response'] = $this->send_order_ishipping($data['sale_code'],$_POST); // add address
                    }
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);
                    $total_coupon_price = 0;
                       
                    $this->cart->destroy(); //delete cart data
                        //$this->session->set_userdata('couponer','');
                    // if($this->session->userdata('total_cashback_discount') > 0){
                    //     $data2['user']                   = $this->session->userdata('user_id');
                    //     $data2['method']                 = 'stripe';
                    //     $data2['amount']                 = $this->session->userdata('total_cashback_discount');
                    //     $data2['status']                 = 'paid';
                    //     $data2['payment_details']        = "Customer Info: \n".json_encode($usera,true)."\n \n Charge Info: \n".json_encode($charge,true);;
                    //     $data2['timestamp']              = time();
                    //     $this->db->insert('wallet_load',$data2);
                    //     //echo $this->db->last_query();
                    //     $id = $this->db->insert_id();       
                    //     $user = $this->db->get_where('wallet_load', array('wallet_load_id' => $id))->row()->user;
                    //     $amount = $this->db->get_where('wallet_load', array('wallet_load_id' => $id))->row()->amount;
                    //     $balance = base64_decode($this->db->get_where('user',array('user_id'=>$user))->row()->wallet);
                    //     $new_balance = base64_encode($balance+$amount);
                    //     $this->db->where('user_id',$user);
                    //     $this->db->update('user',array('wallet'=>$new_balance));
                    // }    
                    // redirect(base_url().'home/thankyou/'.$sale_id,'refresh'); 
                    
                //}// 




                // }
                // else
                // {
                //     $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                //     redirect(base_url() . 'home/cart_checkout/', 'refresh');
                // }


                // require_once(APPPATH . 'libraries/stripe-php/init.php');
                // $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
                // \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                // $customer_email = $this->db->get_where('user' , array('user_id' => $user_id))->row()->email;
                // $customer = \Stripe\Customer::create(array(
                //     'email' => $customer_email, // customer email id
                //     'card'  => $stripe_token
                // ));
                // echo "<br>";
                // echo "1";
                // echo "<br>";
                // $charge = \Stripe\Charge::create(array(
                //     'customer'  => $customer->id,
                //     'amount'    => ceil($amount*100/$exchange),
                //     'currency'  => 'USD'
                // ));
                // echo "<br>";
                // echo "2";
                // echo "<br>";
                // if($charge->paid == true){
                    // echo "<br>";
                    // echo "3";
                    // echo "<br>";
                    $customer = (array) $customer;
                    $charge = (array) $charge; 
                    $data['buyer']  = $user_id;
                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = "";
                    $data['vat']               = !empty($vat) ? $vat : 0;
                    $data['vat_percent']       = !empty($vat_per) ? $vat_per : 0;
                    $data['shipping']          = !empty($shipping) ? $shipping : 0;
                    $data['delivery_status']   = 'pending';
                    $data['payment_type']      = 'stripe';
                    $data['payment_status']    = 'paid';
                    // $data['payment_details']   = "Customer Info: \n".json_encode($customer,true)."\n \n Charge Info: \n".json_encode($charge,true);
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
                    
                //      echo "<br>";
                // echo "sale data";
                // echo "<br>";
                    // echo "<pre>";print_r($data);echo "<pre>";

                    $this->db->insert('sale', $data);
                        //echo $this->db->last_query();
                    $sale_id = $this->db->insert_id();
                        
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                        
                    //  echo "<br>";
                    // echo "vendor";
                    // echo "<br>";     
                    // echo "<pre>";print_r($data);echo "<pre>";

                    $delivery_status = array();
                    $payment_status = array();

                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','comment'=> '','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'paid');
                    }
                    // echo "<br>";
                    // echo "45";
                    // echo "<br>";  
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','comment'=> '','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'paid');
                    }
                    // echo "<br>";
                    // echo "55";
                    // echo "<br>";  
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    // echo "<br>";
                    // echo "60";
                    // echo "<br>";  

                    // if($data['sale_code']){
                    //     $data['ishipping_request_response'] = $this->send_order_ishipping($data['sale_code'],$user_id);
                    // }
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);

                    // echo "<br>";
                    // echo "final";
                    // echo "<br>";  
                    $total_coupon_price = 0;
                    $this->Webservice_model->deleteRow('forCart',array('user_id'=>$user_id));
                // }
                    // $this->cart->destroy();
                     
                $res['status'] = 1;
                $res['message'] = 'product checkout Successfully';
            }else{
                $res['status'] = 0;
                $res['message'] = 'Invalid stripe token';
            }
        }
        exit(json_encode($res)); 
    }
    
*/


    function send_order_ishipping($sale_code,$user_id){
        $alcohol_list = array();
        $volume_list = array();
        $price_list = array();
        $quantity_list = array();
        $category_product_list = array();
        $product_name = array();
        $barcode = array();
        $addressData=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id));
        $addressData = !empty($addressData) ? $addressData[0] : "";
        $carted=$this->Webservice_model->getDataFromTabel('forCart', '*', array('user_id'=>$user_id));
        // $carted = $this->cart->contents();
        
        foreach ($carted as $row) {
            // $options = json_decode($row['option']);
            $result = $this->db->get_where('product',array('product_id'=>$row->product_id))->row();
            
            $barcode[] = $result->product_id;
            $product_name[] = $result->title;
            $alcohol_list[] = $result->product_abv;
            $volume_list[]  = $options->variationqty;
            $price_list[]   = $row['price'];
            $quantity_list[]= $row['qty'];

            $category = $this->db->get_where('category',array('category_id'=>$result->category))->row();
            $category_product_list[] = $category->category_name;
        }

        $category_product = array_count_values($category_product_list);
        $category_product_sum = 0;
        $total_quantity = array_sum($quantity_list);
        foreach ($category_product as $key => $value) 
        {
            $category_product_sum += $value;
        }
        $Streetlines = array($addressData->address1);
        $fullname = $addressData->name;
        $data = array(
            "api_key" =>"p6RertCvahmbQm28Byky",
            "type" => "overseas",
            "alcohol_list" => $alcohol_list,
            "volume_list" => $volume_list,
            "price_list" => $price_list,
            "quantity_list" => $quantity_list,
            "category_product_list" => $category_product_list,
            "category_product_sum" => $category_product_sum,
            "total_quantity" => $total_quantity,
            "notes" => "Pack with bubble wrap",
            "barcode" => $barcode,
            "product_name" => $product_name,
            "order_id" => "$sale_code",
            "recipient_details" => array(
                "PersonName" => $fullname,
                "CompanyName" => "Google",
                "PhoneNumber" => $addressData->phone,
                "Email" => "",
                "Address" => array(
                    "Streetlines" => $addressData->address1,//$Streetlines,
                    "City" => $addressData->city,
                    "StateOrProvinceCode" => "",//$posted['state_or_province_code'],
                    "PostalCode" => $addressData->post_code,
                    "CountryCode" => $addressData->country_code,
                    "Residental" => false
                )
            )
        );

        $url = 'http://www.ishipping.com.au/API/V1/php/Rate/send_order.php';

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

        $all_data = array('request'=>json_decode($postdata),'response'=>$result);

        return json_encode($all_data);
    }




/* http://103.15.67.74/pro1/teleboutik/webservices/remove_item_from_cart */

    public function remove_item_from_cart()
    {
        $user_id =  $this->input->post('user_id');
        $product_id = $this->input->post('product_id');
        $where = array('user_id' => $user_id,'product_id' => $product_id);
        $affectedRows = $this->Webservice_model->deleteRow('forCart',$where);

        $cartitem = $this->Webservice_model->countResult('forCart', array('user_id' => $user_id));
        $res['total_cart_item'] = !empty($cartitem) ? $cartitem : 0;

        if($affectedRows == 1){
            $res['status'] = 1;
            $res['message'] = ' Successfully removed from cart';
        }else{
            $res['status'] = 0;
            $res['message'] = 'Already removed this prouct ';
        }
        exit(json_encode($res)); 
    }

//////////////////////////////// END  CART //////////////////////////////////



/* http://103.15.67.74/pro1/teleboutik/webservices/add_to_wish_list */
    
  

/* http://103.15.67.74/pro1/teleboutik/webservices/send_otp */

    public function send_otp()
    {
        $phone =  $this->input->post('phone');
        $data['otp'] = mt_rand(1000,9999);

        // $data['expiry_time_now'] = date('Y-m-d H:i:s',strtotime("now")) ;//for checking current time
        $data['expiry_time'] = date("Y-m-d H:i:s", strtotime("+10 minutes"));

        require './vendor/autoload.php';

        $sid = "ACa43eb55ffad7d8c9259441b42b311170"; // Your Account SID from www.twilio.com/console
        $token = "fccd3bcd849e8c518f4acf53d8e8c5e3"; // Your Auth Token from www.twilio.com/console

        $client = new Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
          '+919754246805', // Text this number
          array(
            'from' => '+14692038022', // From a valid Twilio number
            'body' => $data['otp']
          )
        );


        $where = array('phone'=>$phone);
        $returnData = $this->Webservice_model->update_data('user',$data, $where);

        if($returnData==1)
        {
            $res['status'] = 1;
            $res['message'] = 'OTP send successfully';
            $res['data'] = $data;
        }else{
            $res['status'] = 0;
            $res['message'] = 'OTP sending fail';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/otp_verification */

    public function otp_verification()
    {
        $phone = $this->input->post('phone');
        $otp =   $this->input->post('otp');
        
        $finalData['is_verify'] = 1; 
        $where = array('phone'=>$phone);
        $returnData = $this->Webservice_model->update_data('user',$finalData, $where);
        
        // $where = array('phone'=>$phone,'otp'=>$otp);//for otp verify // original
        $where = array('phone'=>$phone);//not for verify
        $data =  $this->Webservice_model->get_data_where('user', $where);
        // print_r($data);die();
    if(!empty($data)){
        $data1 = $data[0];
        $result['user_id'] = $data1['user_id'];
        $result['fcm_id'] = $data1['fcm_id'];
        $result['phone'] = $data1['phone'];
        $result['password'] = $data1['password'];
        $result['user_type'] = $data1['user_type'];
        $result['device_type'] = $data1['device_type'];
        $result['email'] = $data1['email'];
        $result['profile_image'] = base_url().$path.$data1['profile_image'];
        $result['dob'] = $data1['dob'];
        $result['is_verify'] = $data1['is_verify'];
        $result['full_name'] = $data1['username'].' '.$data1['surname'];

        $currentTime = date('Y-m-d H:i:s',strtotime("now")) ;
        $checkOtpTime = $data1['expiry_time'];
        

        // if($currentTime > $checkOtpTime){
        //     $res['status'] = 0;
        //     $res['message'] = 'OTP is expired';
        // }
        // else{
            $finalData['is_verify'] = 1; 
            $where = array('phone'=>$phone);
            $returnData = $this->Webservice_model->update_data('user',$finalData, $where);
            if($returnData==1)
            {
                $res['status'] = 1;
                $res['message'] = 'OTP matched';
                $res['data'] = $result;
            }else{
                $res['status'] = 0;
                $res['message'] = 'OTP not matched';
            }
        // }
    
    //for cecking 
    }else{
        $res['status'] = 0;
        $res['message'] = 'OTP does not matched';
    }
        exit(json_encode($res));
    // }
    }



/* http://103.15.67.74/pro1/teleboutik/webservices/add_rating */
//COMPLETED
    public function add_rating()
    {
        $user_id = $this->input->post('user_id');
        $product_id = $this->input->post('product_id');
        $rating = $this->input->post('rating');
        $feedback = $this->input->post('feedback');
        $language_type = $this->input->post('language_type');

        $data['user_id'] = $user_id;
        $data['product_id'] = $product_id;
        $data['rate'] = $rating;
        $data['feedback'] = $feedback;

        if ($rating <= 5) {
            if ($this->Webservice_model->set_rating($product_id, $rating, $user_id) == 'yes') {
                $rating_id = $this->Webservice_model->insert_data('rating',$data);//for second table rate insert
                $res['status'] = 1;
                $res['message'] = 'Product rated successfully.Thankyou';
            } else if ($this->Webservice_model->set_rating($product_id, $rating, $user_id) == 'no') {
                $res['status'] = 0;
                $res['message'] = 'You already rate this product !';
            }
        } else {
            $res['status'] = 0;
            $res['message'] = 'Failed ! Rating should be contain less than or equal to 5 star';
        }
        exit(json_encode($res));
    }


/* http://103.15.67.74/pro1/teleboutik/webservices/deactivate_account */

    public function deactivate_account()
    {
        $user_id = $this->input->post('user_id');
        $data['is_verify'] = 0;
        
        $where = array('user_id'=>$user_id);
        $validUser = $this->Webservice_model->get_data_where('user',$where);
        
        if($validUser){
            $where = array('user_id'=>$user_id);
            $rtrnData = $this->Webservice_model->update_data('user',$data, $where);
            $res['status'] = 1;
            $res['message'] = 'Profile Deactivated';
        }else{
            $res['status'] = 0;
            $res['message'] = 'Invalid User !';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/add_new_delivery_address */

    


function check_out(){

    $addressArr = array();
                
    $user_id =  $this->input->post('user_id');
    $total = $this->input->post('amount');
    $stripe_token = $this->input->post('stripe_token');
    $payment_type=$this->input->post('payment_type');
    $currency_type = $this->input->post('currency_type');
    $currencyType  = !empty($currency_type) ? $currency_type : 'AUD';

    $deliveryAdd=$this->Webservice_model->getDataFromTabel('delivery_address', '*', array('user_id'=>$user_id));


    $query = "SELECT forCart_id,user_id,product_id,qty  FROM `forCart` WHERE user_id =".$user_id;
    $SQL = $this->db->query($query);
    $carted = $SQL->result_array();
    $shipping = 0;
    $grand_total  = $total + $shipping;

    // $total    = $this->cart->total();
    $exchange = exchange('usd');
    $vat_per  = '';
    $vat      = $this->crud_model->cart_total_it('tax');   
    $product_details = json_encode($carted);      
    // echo "<>";
    if(!empty($stripe_token)) {
        // require_once(APPPATH . 'libraries/stripe-php/init.php');
        // $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
        // \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
        // $customer_email = $this->db->get_where('user' , array('user_id' => $user_id))->row()->email;
        
        // $customer = \Stripe\Customer::create(array(
        //     'email' => $customer_email, // customer email id
        //     'card'  => $stripe_token //token
        // ));

        // $charge = \Stripe\Charge::create(array(
        //     'customer'  => $customer->id,
        //     'amount'    => ceil($grand_total*100/$exchange),
        //     'currency'  => 'USD'
        // ));


        // if($charge->paid == true){
            $customer = (array) $customer;
            $charge = (array) $charge; 

            $data['product_details']   = $product_details;
            $data['shipping_address']  = json_encode($deliveryAdd); //address
            $data['vat']               = $vat;
            $data['vat_percent']       = $vat_per;
            $data['shipping']          = $shipping;
            $data['delivery_status']   = 'pending';
            $data['payment_type']      = 'stripe';
            $data['payment_status']    = 'paid';
            $data['payment_details']   = "Customer Info: \n".json_encode($customer,true)."\n \n Charge Info: \n".json_encode($charge,true);
            $data['grand_total']       = $grand_total;
            $data['sale_datetime']     = time();
            $data['delivary_datetime'] = '';
            
            $this->db->insert('sale', $data);
            //echo $this->db->last_query();
            $sale_id = $this->db->insert_id();
            
            $data['buyer'] = $user_id;    
            
            $vendors = $this->crud_model->vendors_in_sale($sale_id);

            $delivery_status = array();
            $payment_status = array();
            foreach ($vendors as $p) {
                $delivery_status[] = array('vendor'=>$p,'status'=>'pending','comment'=> '','delivery_time'=>'');
                $payment_status[] = array('vendor'=>$p,'status'=>'paid');
            }
            if($this->crud_model->is_admin_in_sale($sale_id)){
                $delivery_status[] = array('admin'=>'','status'=>'pending','comment'=> '','delivery_time'=>'');
                $payment_status[] = array('admin'=>'','status'=>'paid');
            }
            $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
            $data['delivery_status'] = json_encode($delivery_status);
            $data['payment_status'] = json_encode($payment_status);


            if($data['sale_code']){
                $data['ishipping_request_response'] = ""; //$this->send_order_ishipping($data['sale_code'],$_POST);
            }
            $this->db->where('sale_id', $sale_id);
            $this->db->update('sale', $data);
            $total_coupon_price = 0;

            $this->Webservice_model->deleteRow('forCart',array('user_id'=>$user_id));
        // }  
                 
        $res['status'] = 1;
        $res['message'] = 'product checkout Successfully';
    
    }else{
        //token error
        $res['status'] = 0;
        $res['message'] = 'Invalid stripe token';
    }

    exit(json_encode($res)); 
}
  



function check_out_123(){
        $addressArr = array();
        // $amount =  $this->input->post('amount');
        
        $user_id =  $this->input->post('user_id');
        $amount = $this->input->post('amount');
        $stripe_token = $this->input->post('stripe_token');
        $payment_type=$this->input->post('payment_type');
        $query = "SELECT forCart_id,user_id,product_id,qty  FROM `forCart` WHERE user_id =".$user_id;
        $SQL = $this->db->query($query);
        $carted = $SQL->result_array();


        // $total    = $this->cart->total();
        $exchange = exchange('usd');
        $vat_per  = '';
        $vat      = $this->crud_model->cart_total_it('tax');
        
        // $shipping = ($this->session->userdata('ishipping_total_price')) ? $this->session->userdata('ishipping_total_price') : 0;
        $grand_total     = $total;// + $shipping;
        $product_details = json_encode($carted);
        if ($payment_type == 'stripe') {
            if(!empty($stripe_token)) {
                
                    $customer = (array) $customer;
                    $charge = (array) $charge; 

                    $data['product_details']   = $product_details;
                    $data['shipping_address']  = "";
                    $data['vat']               = !empty($vat) ? $vat : 0;
                    $data['vat_percent']       = !empty($vat_per) ? $vat_per : 0;
                    $data['shipping']          = !empty($shipping) ? $shipping : 0;
                    $data['delivery_status']   = 'pending';
                    $data['payment_type']      = 'stripe';
                    $data['payment_status']    = 'paid';
                    $data['buyer']             = $user_id; 
                    // $data['payment_details']   = "Customer Info: \n".json_encode($customer,true)."\n \n Charge Info: \n".json_encode($charge,true);
                    $data['grand_total']       = $grand_total;
                    $data['sale_datetime']     = time();
                    $data['delivary_datetime'] = '';
                    
                //      echo "<br>";
                // echo "sale data";
                // echo "<br>";
                    // echo "<pre>";print_r($data);echo "<pre>";

                    $this->db->insert('sale', $data);
                        //echo $this->db->last_query();
                    $sale_id = $this->db->insert_id();
                        
                    $vendors = $this->crud_model->vendors_in_sale($sale_id);
                        
                    //  echo "<br>";
                    // echo "vendor";
                    // echo "<br>";     
                    // echo "<pre>";print_r($data);echo "<pre>";

                    $delivery_status = array();
                    $payment_status = array();

                    foreach ($vendors as $p) {
                        $delivery_status[] = array('vendor'=>$p,'status'=>'pending','comment'=> '','delivery_time'=>'');
                        $payment_status[] = array('vendor'=>$p,'status'=>'paid');
                    }
                    // echo "<br>";
                    // echo "45";
                    // echo "<br>";  
                    if($this->crud_model->is_admin_in_sale($sale_id)){
                        $delivery_status[] = array('admin'=>'','status'=>'pending','comment'=> '','delivery_time'=>'');
                        $payment_status[] = array('admin'=>'','status'=>'paid');
                    }
                    // echo "<br>";
                    // echo "55";
                    // echo "<br>";  
                    $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
                    $data['delivery_status'] = json_encode($delivery_status);
                    $data['payment_status'] = json_encode($payment_status);
                    // echo "<br>";
                    // echo "60";
                    // echo "<br>";  

                    // if($data['sale_code']){
                    //     $data['ishipping_request_response'] = $this->send_order_ishipping($data['sale_code'],$user_id);
                    // }
                    $this->db->where('sale_id', $sale_id);
                    $this->db->update('sale', $data);

                    // echo "<br>";
                    // echo "final";
                    // echo "<br>";  
                    $total_coupon_price = 0;
                    $this->Webservice_model->deleteRow('forCart',array('user_id'=>$user_id));
                // }
                    // $this->cart->destroy();
                     
                $res['status'] = 1;
                $res['message'] = 'product checkout Successfully';
            }else{
                $res['status'] = 0;
                $res['message'] = 'Invalid stripe token';
            }
        }
        exit(json_encode($res)); 
    }
    









/* http://103.15.67.74/pro1/teleboutik/webservices/check_out */

    public function check_out_old()
    {

        $input = $this->input->post();


        $user_id = $this->input->post('user_id');
        $language_type = $this->input->post('language_type');
        $payment_type = $this->input->post('payment_type');
        $payment_details = $this->input->post('payment_details');
        $total_amount = $this->input->post('total_amount');
        $total_shipping = $this->input->post('total_shipping');
        $total_tax = $this->input->post('total_tax');



         if($payment_details==''){

            $res['status'] = 0;
            $res['message']='Payment gateway error !';
            exit(json_encode($res));
         }

        $where = array('user_id'=>$user_id);
        $cartContent = $this->Webservice_model->get_data_where('forCart',$where);
    if($payment_type == 'paypal' || $payment_type == 'stripe')
    {
        foreach ($cartContent as $key => $value) 
        {
            $where = array('product_id'=> $value['product_id']);
            $productDetail = $this->Webservice_model->get_data_where('product', $where);
            $cartContent[$key]['title']         = $productDetail[0]['title'];
            $cartContent[$key]['discount']      = $productDetail[0]['discount'];
            $cartContent[$key]['discount_type']      = $productDetail[0]['discount_type'];
            $cartContent[$key]['sale_price']    = $productDetail[0]['sale_price'];
            $cartContent[$key]['shipping_cost'] = $productDetail[0]['shipping_cost'];
            $cartContent[$key]['totalPriceQuantity']  = $cartContent[$key]['sale_price']*$value['qty'];
            $cartContent[$key]['totalShippingPrice ']  = $cartContent[$key]['shipping_cost']*$value['qty'];
            $cartContent[$key]['tax_type']  = $productDetail[0]['tax_type'];
            $cartContent[$key]['tax']  = $productDetail[0]['tax'];
            
            if($productDetail[0]['tax_type'] == 'percent'){
                $totalTaxAmount  = $cartContent[$key]['tax']*$value['qty'];
                $cartContent[$key]['totalTaxPrice'] = $cartContent[$key]['totalPriceQuantity'] * $totalTaxAmount /100;
            }else{
                $cartContent[$key]['totalTaxPrice']  = $cartContent[$key]['tax']*$value['qty'];
            }
            if($productDetail[0]['discount_type'] == 'percent'){
                $totalDiscountAmount  = $cartContent[$key]['discount']*$value['qty'];
                $cartContent[$key]['totalDiscountPrice'] = $cartContent[$key]['totalPriceQuantity'] * $totalDiscountAmount /100;
            }else{
                $cartContent[$key]['totalDiscountPrice']  = $cartContent[$key]['discount']*$value['qty'];
            }

            $cartContent[$key]['subTotal'] = $cartContent[$key]['totalShippingPrice '] + $cartContent[$key]['totalTaxPrice'] - $cartContent[$key]['totalDiscountPrice'] + $cartContent[$key]['totalPriceQuantity'];
            
        }//end foreach 
        if ($this->crud_model->get_type_name_by_id('business_settings', '3', 'value') == 'product_wise') {
            $shipping = $this->crud_model->cart_total_it('shipping');
        } else {
            $shipping = $this->crud_model->get_type_name_by_id('business_settings', '2', 'value');
        }
        

        $where = array('user_id'=>$user_id);
        $userData = $this->Webservice_model->get_data_where('user',$where);
        $userAddDetails['username'] = $userData[0]['username'];
        $userAddDetails['surname'] = $userData[0]['surname'];
        $userAddDetails['address1'] = $userData[0]['address1'];
        $userAddDetails['address2'] = $userData[0]['address2'];
        $userAddDetails['city'] = $userData[0]['city'];
        $userAddDetails['zip'] = $userData[0]['zip'];
        $userAddDetails['state'] = $userData[0]['state'];
        $userAddDetails['email'] = $userData[0]['email'];
        $userAddDetails['phone'] = $userData[0]['phone'];
        $userAddDetails['langlat'] = $userData[0]['langlat'];


        $data['product_details']  = json_encode($cartContent);
        $data['shipping_address'] = json_encode($userAddDetails);
        $data['payment_type']     = $payment_type;
        // $data['payment_status']   = '[]';
        $data['payment_details']   = $payment_details;
        $data['shipping']          = $total_shipping;
        $data['vat']               = $total_tax;
        $data['vat_percent']       = '';
        $data['sale_datetime']     = time();
        $data['delivary_datetime'] = '';
        $data['grand_total']       = $total_amount;
        $data['buyer']             = $user_id; 

        $sale_id = $this->Webservice_model->insert_data('sale', $data);
        $vendors = $this->Webservice_model->vendors_in_sale($sale_id);
        $delivery_status = array();
        $payment_status = array();
        // foreach ($vendors as $p) {
        //     $delivery_status[] = array('vendor'=>$p,'status'=>'pending','comment'=> '','delivery_time'=>'');
        //     $payment_status[] = array('vendor'=>$p,'status'=>'due');
        // }
        if($this->Webservice_model->is_admin_in_sale($sale_id)){
            $delivery_status[] = array('admin'=>'','status'=>'pending','comment'=> '','delivery_time'=>'');
            $payment_status[] = array('admin'=>'','status'=>'due');
        }
        else{
            $delivery_status[] = array('vendor'=>$user_id,'status'=>'pending','comment'=> '','delivery_time'=>'');
            $payment_status[] = array('vendor'=>$user_id,'status'=>'due');
        }
        $data['sale_code'] = date('Ym', $data['sale_datetime']) . $sale_id;
        $data['delivery_status'] = json_encode($delivery_status);
        $data['payment_status'] = json_encode($payment_status);
        
        $this->db->where('sale_id', $sale_id);
        $this->db->update('sale', $data);

        $where = array('user_id'=>$user_id);
        $cartDataForStock = $this->Webservice_model->get_data_where('forCart',$where);
        foreach ($cartDataForStock as $value) {
            $this->crud_model->decrease_quantity($value['product_id'], $value['qty']);
            $data1['type']         = 'destroy';
            $data1['category']     = $this->db->get_where('product', array(
                'product_id' => $value['product_id']
            ))->row()->category;
            $data1['sub_category'] = $this->db->get_where('product', array(
                'product_id' => $value['product_id']
            ))->row()->sub_category;
            $data1['product']      = $value['product_id'];
            $data1['quantity']     = $value['qty'];
            $data1['total']        = 0;
            $data1['reason_note']  = 'sale';
            $data1['sale_id']      = $sale_id;
            $data1['datetime']     = time();
            $this->db->insert('stock', $data1);
        }


        $this->wallet_model->reduce_user_balance($grand_total,$user_id);
        $this->Webservice_model->digital_to_customer($sale_id,$user_id);
        $this->crud_model->email_invoice($sale_id);

        $where = array('user_id'=>$user_id);
        $cartDataForRemove = $this->Webservice_model->get_data_where('forCart',$where);
        foreach ($cartDataForRemove as $key => $val) {
            $product_id = $val['product_id'];
            $where = array('user_id' => $user_id,'product_id' => $product_id);
            $affectedRows = $this->Webservice_model->deleteRow('forCart',$where);
        }

        if($sale_id!='' && $payment_details!=''){
            $res['status'] = 1;
            $res['message'] = 'Payment successful';
        }else{
            $res['status'] = 0;
            $res['message'] = 'Payment failed !';
        }
    }//end main if  
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/my_order */



/* http://103.15.67.74/pro1/teleboutik/webservices/search */


/*  http://103.15.67.74/pro1/teleboutik/webservices/home_page_data */

    public function home_page_data()
    {
        $language_type = $this->input->post('language_type');
        
        $allCategory = $this->db->get('category')->result_array();
        $limit = 20 ; 
        $featuredProduct=$this->crud_model->product_list_set('featured',$limit);
        foreach($featuredProduct as $key => $val) {
           $images = $this->crud_model->file_view('product',$val['product_id'],'','','thumb','src','multi','all');
           $featuredProduct[$key]['images'] = $images; 
        }

        $query = "SELECT product_id,discount,discount_type,title,category FROM `product` WHERE discount > 0 ORDER BY discount DESC LIMIT 10";
        $SQL = $this->db->query($query);
        $discountData = $SQL->result_array();
        foreach($discountData as $key => $value) {
           $images = $this->crud_model->file_view('product',$value['product_id'],'','','thumb','src','multi','all');
           $discountData[$key]['images'] = $images; 
        }
        
        $topProduct=$this->crud_model->product_list_set('latest',20);
        foreach($topProduct as $key => $v) {
           $images = $this->crud_model->file_view('product',$v['product_id'],'','','thumb','src','multi','all');
           $topProduct[$key]['images'] = $images; 
        }

        $allVendors = $this->db->get('vendor')->result_array();
        foreach ($allVendors as $key => $vals) {
             $vendorsList[$key]['image'] = base_url().'uploads/vendor_logo_image/logo_'.$vals['vendor_id'].'.'.'png';
             $vendorsList[$key]['vendor_id'] = $vals['vendor_id'];
             $vendorsList[$key]['name'] = $vals['name'];
             $vendorsList[$key]['description'] = $vals['description'];
        }
        $data['banner'] = $discountData;
        $data['category'] = $allCategory;
        $data['featured_product'] = $featuredProduct;
        $data['top_product'] = $topProduct;
        $data['vendor'] = $vendorsList;

        if ($data){
            $res['status'] = 1;
            $res['message'] = 'Result found successfully';
            $res['data'] = $data;
        }else{
            $res['status'] = 0;
            $res['message'] = 'No result found ! ';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/getProductByVendorid */

    public function getProductByVendorid()
    {
        header('Content-Type: application/json');
        $vendor_id = $this->input->post('vendor_id');
        $language_type = $this->input->post('language_type');
        if ($language_type == 'en')
        {
            $productList = $this->Webservice_model->vendorProductList($vendor_id);
            foreach($productList as $key => $value) {
                $images = $this->crud_model->file_view('product',$value['product_id'],'','','thumb','src','multi','all');
                $productList[$key]['images'] = $images;
            }
            if ($productList){
                foreach ($productList as $key => $value) {
                    $productList[$key]['rating_user'] = json_decode($value['rating_user']);
                    $productList[$key]['added_by'] = json_decode($value['added_by']);
                    $productList[$key]['additional_fields'] = json_decode($value['additional_fields']);
                    $productList[$key]['color'] = json_decode($value['color']);
                    $productList[$key]['options'] = json_decode($value['options']);
                    // print_r(json_encode(array('Hello'=>)));
                    // $value['additional_fields'] = json_decode(json_encode(json_decode($value['additional_fields'])), true);

                }
                $res['status'] = 1;
                $res['message'] = 'Result found successfully';
                $res['data'] = $productList;
            }else{
                $res['status'] = 0;
                $res['message'] = 'No result found ! ';
            }
        }else{
            $res['status'] = 0;
            $res['message'] = 'Language type error !';
        }

        echo json_encode($res);
        die();
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/payment_history */
    public function payment_history()
    {
        $language_type = $this->input->post('language_type');
        $user_id = $this->input->post('user_id');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        if (!empty($end_date) AND !empty($start_date) AND !empty($language_type) AND !empty($user_id)) {
            $s_date = strtotime($start_date);
            $e_date = strtotime($end_date);
            $filterdata = $this->db->select('*')->from('sale')->where('buyer',$user_id)->where('sale_datetime >=',$s_date)->where('sale_datetime <=',$e_date)->order_by('sale_id','DESC')->get()->result_array();
            //print_r($filterdata);
            if (!empty($filterdata)) {
                $Myobj = "";
                $response = array();
                foreach ($filterdata as $row) {
                    $product_details = json_decode($row['product_details'], true);
                    foreach ($product_details as $pdetail) {
                        @$Myobj['name'] = $pdetail['name'];
                        @$Myobj['product_img'] = $pdetail['image'];
                        @$Myobj['price'] = $pdetail['price'];
                        @$Myobj['subtotal'] = $pdetail['subtotal'];
                    }
                    $sale_status = json_decode($row['payment_status'], true);
                    foreach ($sale_status as $pay_status) {
                        @$Myobj['status'] = $pay_status['status'];
                    }
                    $dd = date('d-M-Y',$row['sale_datetime']);
                    $Myobj['date'] = $dd; 
                    $response[] = $Myobj;
                }
                $res['status'] = 1;
                $res['message'] = 'Filter data show successfully';
                $res['data']    = $response;
            }
            else
            {
                $res['status'] = 0;
                $res['message'] = 'No data found';
            }
            
        }
        elseif (!empty($language_type) AND !empty($user_id)) {
            if ($language_type == 'en') {
                $where = array('user_id'=>$user_id);
                $GetData = $this->db->where('buyer',$user_id)->order_by('sale_id','DESC')->get('sale')->result_array();
                //$GetData = $this->db->get_where('sale',array('buyer'=>$user_id))->result_array();
                $Myobj = array();
                $response = array();
                foreach ($GetData as $row) {
                    $product_details = json_decode($row['product_details'], true);
                    foreach ($product_details as $pdetail) {
                        @$Myobj['name'] = $pdetail['name'];
                        @$Myobj['product_img'] = $pdetail['image'];
                        @$Myobj['price'] = $pdetail['price'];
                        @$Myobj['subtotal'] = $pdetail['subtotal'];
                    }
                    $sale_status = json_decode($row['payment_status'], true);
                    foreach ($sale_status as $pay_status) {
                        @$Myobj['status'] = $pay_status['status'];
                    }
                    $dd = date('d-M-Y',$row['sale_datetime']);
                    $Myobj['date'] = $dd; 
                    $response[] = $Myobj;
                }
                $res['status'] = 1;
                $res['message'] = 'Show payment history successfully';
                $res['data'] = $response;
            }
        }
        else
        {
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';
        }

        
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/package_list */
    public function package_list()
    {
        $language_type = $this->input->post('language_type');
        if (!empty($language_type)) {
            if ($language_type == 'en') {
                $getPackage = $this->Webservice_model->getdata('package');
                $MyObject = array();   
                $response = array();
                foreach ($getPackage as $row) {
                    $getimgName = json_decode($row->image);
                    $packageimg = base_url('uploads/plan_image/'.$getimgName[0]->image);
                    @$MyObject['package_id']   =   $row->package_id;
                    @$MyObject['name']           = $row->name;
                    @$MyObject['amount']        = $row->amount;
                    @$MyObject['upload_amount']  = $row->upload_amount;
                    @$MyObject['img']          = $packageimg;
                    $response[] = $MyObject;
                }
                $res['status'] = 1;
                $res['message'] = 'Package show succesfully';
                $res['data'] = $response;
            }
        }
        else
        {
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';
        }
        exit(json_encode($res));
    }


    /* http://103.15.67.74/pro1/teleboutik/webservices/subscribe_package */

    public function product_image_upload()
    {
        $user_id = $this->input->post('user_id');
        if (!empty($user_id) AND !empty($_FILES['images']['name'])) {

            $data = array('user_id'=>$user_id);
            $addProduct =  $this->Webservice_model->insert_data('product', $data);
            $id = $addProduct;
            if (!empty($id)) {
                $upload = $this->crud_model->file_up("images", "product", $id, 'multi');
                $res['status'] = 1;
                $res['message'] = 'Images uploaded successfully';                
            }
        }
        else
        {
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';
        }
        exit(json_encode($res));
    }

/* http://103.15.67.74/pro1/teleboutik/webservices/add_product */
    public function add_product()
    {
        $user_id = $this->input->post('user_id');
        $product_id = $this->input->post('product_id');
        $product_name = $this->input->post('product_name');
        $category_id = $this->input->post('category_id');
        $product_price = $this->input->post('product_price');
        $product_description = $this->input->post('product_description');
        $status = $this->input->post('status');
        $stock = $this->input->post('stock');
        $discount = $this->input->post('discount');
        $discount_type = $this->input->post('discount_type');
        $code = $this->input->post('code');
        $user_rating = json_encode(["0"]);
        if ($_FILES["product_image"]['name'][0] == '') {
            $num_of_imgs = 0;
        } else {
            $num_of_imgs = count($_FILES["product_image"]['name']);
        }     
           
        if (isset($product_id)) {
            $data = [
                    'user_id'            =>    $user_id,
                    'title'              =>    $product_name,
                    'sale_price'         =>    $product_price,
                    'category'           =>    $category_id,
                    'description'        =>    $product_description,
                    'status'             =>    $status,
                    'current_stock'      =>    $stock,
                    'discount'           =>    $discount,
                    'discount_type'      =>    $discount_type,
                    'num_of_imgs'        =>    $num_of_imgs,
                    'rating_user'        =>    $user_rating,
                    'options'            =>    '[]',
                    'color'              =>    '[]',
                ];
                $where = array('product_id'=>$product_id);
                $update =  $this->Webservice_model->update_data('product', $data, $where);
                if ($update == true) {
                    for ($i=0; $i < count($_FILES['product_image']['name']); $i++) { 
                        $filename   = $_FILES['product_image']['name'][$i];
                        $extension  = pathinfo($filename, PATHINFO_EXTENSION);
                        $ext = '.'.$extension;
                        $upload = $this->crud_model->file_up("product_image", "product", $product_id, "multi", '', $ext);
                    }

                    $res['status'] = 1;
                    $res['message'] = 'Product Updated successfully';
                }
                else{
                    $res['status'] = 0;
                    $res['message'] = 'Something went wrong! in product updating';
                }
        }
        else{

            if (!empty($user_id) AND !empty($product_name) AND !empty($category_id) AND !empty($product_price) AND !empty($product_description) AND !empty($status) AND !empty($stock) AND !empty($discount) AND !empty($code) AND !empty($discount_type))
            {
                $added_by = '{"type":"vender","id":"'.$user_id.'"}';
                $data = [
                    'user_id'            =>    $user_id,
                    'title'              =>    $product_name,
                    'sale_price'         =>    $product_price,
                    'category'           =>    $category_id,
                    'description'        =>    $product_description,
                    'status'             =>    $status,
                    'current_stock'      =>    $stock,
                    'discount'           =>    $discount,
                    'discount_type'      =>    $discount_type,
                    'num_of_imgs'        =>    $num_of_imgs,
                    'rating_user'        =>    $user_rating,
                    'options'            =>    '[]',
                    'color'              =>    '[]',
                    'added_by'           =>    $added_by
                ];
                $addProduct =  $this->Webservice_model->insert_data('product', $data);
                if ($addProduct == true) {
                    
                    for ($i=0; $i < count($_FILES['product_image']['name']); $i++) { 
                        $filename   = $_FILES['product_image']['name'][$i];
                        $extension  = pathinfo($filename, PATHINFO_EXTENSION);
                        $ext = '.'.$extension;
                        $upload = $this->crud_model->file_up("product_image", "product", $addProduct, "multi", '', $ext);
                    }
                    
                    $res['status'] = 1;
                    $res['message'] = 'Product added successfully';
                }
                else
                {
                    $res['status'] = 0;
                    $res['message'] = 'Something went wrong!';
                }
            }
            else
            {
                $res['status'] = 0;
                $res['message'] = 'Parameter missing';
            }
                
        }
        exit(json_encode($res));
    }

    /* http://103.15.67.74/pro1/teleboutik/webservices/vender_product_list */
    public function vender_product_list()
    {
        $user_id = $this->input->post('user_id');
        $language_type = $this->input->post('language_type');
        if (!empty($user_id) AND !empty($language_type)) {
            $where = array('user_id' => $user_id);
            $GetData = $this->Webservice_model->get_data_where('product', $where);
            
            //print_r($GetData); //die();
            $MyObject = array();   
            $response = array();
            
            foreach ($GetData as $row) {
                $product_id = $row['product_id'];
                $avgRating = $this->crud_model->rating($product_id);
                $file = $this->crud_model->file_view('product',$product_id,'','','thumb','src','multi','one');
                @$MyObject['product_id'] = $row['product_id'];
                @$MyObject['user_id'] = $row['user_id'];
                $MyObject['rating_num'] = $row['rating_num'];
                $MyObject['rating_total'] = $row['rating_total'];
                $MyObject['rating_user'] = $row['rating_user'];
                $MyObject['avg_rating'] = $avgRating;
                $MyObject['title'] = $row['title'];
                $MyObject['added_by'] = $row['added_by'];
                $MyObject['category'] = $row['category'];
                $MyObject['description'] = $row['description'];
                $MyObject['sub_category'] = $row['sub_category'];
                $MyObject['num_of_imgs'] = $row['num_of_imgs'];
                $MyObject['sale_price'] = $row['sale_price'];
                $MyObject['purchase_price'] = $row['purchase_price'];
                $MyObject['shipping_cost'] = $row['shipping_cost'];
                $MyObject['add_timestamp'] = $row['add_timestamp'];
                $MyObject['featured'] = $row['featured'];
                $MyObject['tag'] = $row['tag'];
                $MyObject['status'] = $row['status'];
                $MyObject['front_image'] = $row['front_image'];
                $MyObject['brand'] = $row['brand'];
                $MyObject['unit'] = $row['unit'];
                $MyObject['current_stock'] = $row['current_stock'];
                $MyObject['additional_fields'] = $row['additional_fields'];
                $MyObject['number_of_view'] = $row['number_of_view'];
                $MyObject['background'] = $row['background'];
                $MyObject['discount'] = $row['discount'];
                $MyObject['discount_type'] = $row['discount_type'];
                $MyObject['tax'] = $row['tax'];
                $MyObject['tax_type'] = $row['tax_type'];
                $MyObject['color'] = $row['color'];
                $MyObject['options'] = $row['options'];
                $MyObject['main_image'] = $row['main_image'];
                $MyObject['download'] = $row['download'];
                $MyObject['download_name'] = $row['download_name'];
                $MyObject['deal'] = $row['deal'];
                $MyObject['num_of_downloads'] = $row['num_of_downloads'];
                $MyObject['update_time'] = $row['update_time'];
                $MyObject['requirements'] = $row['requirements'];
                $MyObject['logo'] = $row['logo'];
                $MyObject['video'] = $row['video'];
                $MyObject['last_viewed'] = $row['last_viewed'];
                $MyObject['products'] = $row['products'];
                $MyObject['is_bundle'] = $row['is_bundle'];
                $MyObject['vendor_featured'] = $row['vendor_featured'];
                $MyObject['cover_img'] = $file;
                $MyObject['total_sale_count'] = $row['sale_count'];
                $response[] = $MyObject;
            }
            if (!empty($response)) {
                $res['status'] = 1;
                $res['message'] = 'product list show successfully';
                $res['data'] = $response;
            }
            else{
                $res['status'] = 0;
                $res['message'] = 'No Data found';
            }
        }
        else
        {
            $res['status'] = 0;
            $res['message'] = 'Parameter missing';
        }
        exit(json_encode($res));
    }



    } // END OF CLASS
?>