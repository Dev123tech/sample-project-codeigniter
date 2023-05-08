<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Vendor extends CI_Controller
{
    /*  
     *  Developed by: Active IT zone
     *  Date    : 14 July, 2015
     *  Active Supershop eCommerce CMS
     *  http://codecanyon.net/user/activeitezone
     */
    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('paypal');
        $this->load->library('twoCheckout_Lib');
        $this->load->library('vouguepay');
        $this->load->library('pum');
        $this->load->library('csvimport');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        //$this->crud_model->ip_data();
        $vendor_system   =  $this->db->get_where('general_settings',array('type' => 'vendor_system'))->row()->value;
        if($vendor_system !== 'ok'){
            redirect(base_url(), 'refresh');
        }
    }
    
    /* index of the vendor. Default: Dashboard; On No Login Session: Back to login page. */
    public function index()
    {
        if ($this->session->userdata('vendor_login') == 'yes') {
            // Starts the countdown
            //-----------gokul code start------------
            $productinfo = array();
            $sale=$this->Webservice_model->getDataFromTabel('sale', '*');
            $hk_data = array();$aus_data = array();$sg_data = array();$jp_data = array();
            if(!empty($sale)){
                foreach($sale as $key => $val){
                    // echo $val->product_details;die;
                    if(!empty($val->product_details)){
                        $saledata = json_decode($val->product_details);    
                        $getCountry = !empty($val->shipping_address) ? json_decode($val->shipping_address) : "";    
                        
                        $country = !empty($getCountry) ? $getCountry->country : "";
                        foreach($saledata as $data){
                            $saleArr = array();

                            $getoption = !empty($data->option) ? json_decode($data->option) : "";   
                            // echo "<pre>"; print_r($getoption);echo "<pre>";
                                // $cateRes=$this->crud_model->getProductCategory($getoption->productid);

                            if(!empty($country) && !empty($getoption->productid)){
                                $cate_id=$this->Webservice_model->getDataFromTabel('product', 'category,current_stock,variety');

                                $cate_id = !empty($cate_id) ? $cate_id[0] : 0;

                                $saleArr['product_id'] = $getoption->productid;
                                $category_id = !empty($cate_id) ? $cate_id->category : 0;
                                // echo $category_id;
                                // echo "<br>";
                                $subcate=$this->Webservice_model->getDataFromTabel('sub_category','*',array('category'=>$category_id));

                                // echo "<pre>"; print_r($subcate);echo "<pre>";
                                $subcate = !empty($subcate) ? $subcate[0] : 0;
                                
                                $saleArr['sub_category'] = !empty($subcate) ? $subcate->sub_category_name : "N/A";
                                $saleArr['country'] = $country;
                                $saleArr['qty'] = $data->qty;
                                $saleArr['current_stock'] = !empty($cate_id) ? $cate_id->current_stock : 50;
                                $saleArr['variety'] = !empty($cate_id) ? $cate_id->variety :"N/A";
                                $saleArr['price'] = $data->price;
                                // $saleArr['category'] = !empty($cateRes) ? $cateRes[0]->category_name : "";
                                $productinfo[]=$saleArr;
                            }
                        }

                    }
                    
                }
            }




            // $totalRevenue = '0';
            $totalQty = '0';
            $austotalQty = '0';
            $sgtotalQty = '0';
            $jptotalQty = '0';
            $hktotalQty = '0';


            $ausRevenue = '0';
            $sgRevenue = '0';
            $jpRevenue = '0';
            $hkRevenue = '0';

            // echo "<pre>"; print_r($productinfo);die('yes');
            $topProduct = array();
            $sg = array();$jp = array();$au = array();$hk = array();
            if(!empty($productinfo)){

                //top varity product
                $top_product = array_reduce($productinfo, function ($a, $b) {
                    isset($a[$b['product_id']]) ? $a[$b['product_id']]['qty'] += $b['qty'] : $a[$b['product_id']] = $b;  
                    return $a;
                });     
                $topProduct = !empty($top_product) ? array_values($top_product) : "";
                $proTop = array();
                if(!empty($topProduct)){
                    foreach ($topProduct as $key => $row){
                        $proTop[$key] = $row['qty'];
                    }    
                    array_multisort($proTop, SORT_DESC, $topProduct);
                }


                foreach($productinfo as $keyqty){
                    $totalQty=  $totalQty+$keyqty['qty'];      
                }
                
                foreach($productinfo as $keyval){
                    // $res = array();
                     $sgres = array();
                    if($keyval['country']=='SG'){
                        $sgres['product_id'] = $keyval['product_id'];
                        $sgres['country'] = $keyval['country'];
                        $sgres['qty'] = $keyval['qty'];
                        $sgres['sub_category'] = $keyval['sub_category'];
                        $sgres['current_stock'] = $keyval['current_stock'];
                        $sgres['price'] = $keyval['price'];
                        $sgres['variety'] = $keyval['variety'];
                        
                        $sgtotalQty=  $sgtotalQty+$keyval['qty'];
                        $sgRevenue= $sgRevenue+$keyval['price'];      
                        $sg[] = $sgres;
                    }
                }
                foreach($productinfo as $keyval1){
                    $aures = array();
                    if($keyval1['country']=='AU'){
                        $aures['product_id'] = $keyval1['product_id'];
                        $aures['country'] = $keyval1['country'];
                        $aures['qty'] = $keyval1['qty'];
                        $aures['sub_category'] = $keyval1['sub_category'];
                        $aures['current_stock'] = $keyval1['current_stock'];
                        $aures['price'] = $keyval1['price'];
                        $aures['variety'] = $keyval1['variety'];
                        $austotalQty=  $austotalQty+$keyval1['qty'];
                        $ausRevenue= $ausRevenue+$keyval1['price'];      
                        $au[] = $aures;
                    }
                }
                foreach($productinfo as $keyval2){
                    $jpres = array();
                    if($keyval2['country']=='JP'){
                        $jpres['product_id'] = $keyval2['product_id'];
                        $jpres['country'] = $keyval2['country'];
                        $jpres['qty'] = $keyval2['qty'];
                        $jpres['sub_category'] = $keyval2['sub_category'];
                        $jpres['current_stock'] = $keyval2['current_stock'];
                        $jpres['price'] = $keyval2['price'];
                        $jpres['variety'] = $keyval2['variety'];
                        $jptotalQty=  $jptotalQty+$keyval2['qty'];
                        $jpRevenue= $jpRevenue+$keyval2['price'];      
                        $jp[] = $jpres;
                    }
                }
                foreach($productinfo as $keyval3){
                    $hkres = array();
                    if($keyval3['country']=='HK'){
                        $hkres['product_id'] = $keyval3['product_id'];
                        $hkres['country'] = $keyval3['country'];
                        $hkres['qty'] = $keyval3['qty'];
                        $hkres['sub_category'] = $keyval3['sub_category'];
                        $hkres['current_stock'] = $keyval3['current_stock'];
                        $hkres['price'] = $keyval3['price'];
                        $hkres['variety'] =$keyval3['variety'];
                        $hktotalQty=  $hktotalQty+$keyval3['qty'];
                        $hkRevenue= $hkRevenue+$keyval3['price'];      
                        $hk[] = $hkres;
                    }
                }
            }


            

            // for HK

            if(!empty($hk)){
                 $sum3 = array_reduce($hk, function ($a, $b) {
                    isset($a[$b['product_id']]) ? $a[$b['product_id']]['qty'] += $b['qty'] : $a[$b['product_id']] = $b;  
                    return $a;
                });     
                $hk_data = !empty($sum3) ? array_values($sum3) : "";
                $qtty3 = array();
                if(!empty($hk_data)){
                    foreach ($hk_data as $key => $row){
                        $qtty3[$key] = $row['qty'];
                    }    
                    array_multisort($qtty3, SORT_DESC, $hk_data);
                }
            }

           


            // for australiya
            if(!empty($au)){
                 $sum = array_reduce($au, function ($a, $b) {
                    isset($a[$b['product_id']]) ? $a[$b['product_id']]['qty'] += $b['qty'] : $a[$b['product_id']] = $b;  
                    return $a;
                });     
                $aus_data = !empty($sum) ? array_values($sum) : "";
                $qtty = array();
                if(!empty($aus_data)){
                    foreach ($aus_data as $key => $row){
                        // echo "<pre>"; print_r($row);die('yes');
                        $qtty[$key] = $row['qty'];
                    }    
                    array_multisort($qtty, SORT_DESC, $aus_data);
                }
            }



            // for SG
            if(!empty($sg)){
                 $sum1 = array_reduce($sg, function ($a, $b) {
                    isset($a[$b['product_id']]) ? $a[$b['product_id']]['qty'] += $b['qty'] : $a[$b['product_id']] = $b;  
                    return $a;
                });     
                $sg_data = !empty($sum1) ? array_values($sum1) : "";
                $qtty1 = array();
                if(!empty($sg_data)){
                    foreach ($sg_data as $key => $row){
                        // echo "<pre>"; print_r($row);die('yes');
                        $qtty1[$key] = $row['qty'];
                    }    
                    array_multisort($qtty1, SORT_DESC, $sg_data);
                }
            }



            // for JP
            if(!empty($jp)){
                 $sum2 = array_reduce($jp, function ($a, $b) {
                    isset($a[$b['product_id']]) ? $a[$b['product_id']]['qty'] += $b['qty'] : $a[$b['product_id']] = $b;  
                    return $a;
                });     
                $jp_data = !empty($sum2) ? array_values($sum2) : "";
                $qtty2 = array();
                if(!empty($jp_data)){
                    foreach ($jp_data as $key => $row){
                        // echo "<pre>"; print_r($row);die('yes');
                        $qtty2[$key] = $row['qty'];
                    }    
                    array_multisort($qtty2, SORT_DESC, $jp_data);
                }
            }


            
            $page_data['hk_data'] = $hk_data;
            $page_data['aus_data'] = $aus_data;
            $page_data['sg_data'] = $sg_data;
            $page_data['jp_data'] = $jp_data;

            $page_data['totalQty'] = $totalQty;

            // $page_data['totalRevenue'] = $totalRevenue;

            
            $page_data['austotalQty'] = $austotalQty;
            $page_data['sgtotalQty'] = $sgtotalQty;
            $page_data['jptotalQty'] = $jptotalQty;
            $page_data['hktotalQty'] = $hktotalQty;


            $page_data['ausRevenue'] = $ausRevenue;
            $page_data['sgRevenue'] = $sgRevenue;
            $page_data['jpRevenue'] = $jpRevenue;
            $page_data['hkRevenue'] = $hkRevenue;

            $page_data['topProduct'] = $topProduct;


           

            //-------------gokul code end----------------------------
            $page_data['page_name'] = "dashboard";
            $this->load->view('back/index', $page_data);
        } else {
            $page_data['control'] = "vendor";
            $this->load->view('back/login',$page_data);
        }
    }
    /*Product slides add, edit, view, delete */
    function slides($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('slides')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'do_add') {
            $type                       = 'slides';
            $data['button_color']       = $this->input->post('color_button');
            $data['text_color']         = $this->input->post('color_text');
            $data['button_text']        = $this->input->post('button_text');
            $data['button_link']        = $this->input->post('button_link');
            $data['uploaded_by']        = 'vendor';
            $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $this->db->insert('slides', $data);
            $id = $this->db->insert_id();
            $this->crud_model->file_up("img", "slides", $id, '', '', '.jpg');
            recache();
        } elseif ($para1 == "update") {
            $data['button_color']       = $this->input->post('color_button');
            $data['text_color']         = $this->input->post('color_text');
            $data['button_text']        = $this->input->post('button_text');
            $data['button_link']        = $this->input->post('button_link');
            $this->db->where('slides_id', $para2);
            $this->db->update('slides', $data);
            $this->crud_model->file_up("img", "slides", $para2, '', '', '.jpg');
            recache();
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('slides', $para2, '.jpg');
            $this->db->where('slides_id', $para2);
            $this->db->delete('slides');
            recache();
        } elseif ($para1 == 'multi_delete') {
            $ids = explode('-', $param2);
            $this->crud_model->multi_delete('slides', $ids);
        } else if ($para1 == 'edit') {
            $page_data['slides_data'] = $this->db->get_where('slides', array(
                'slides_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/slides_edit', $page_data);
        } elseif ($para1 == 'list') {
            $this->db->order_by('slides_id', 'desc');
            $this->db->where('added_by', json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $page_data['all_slidess'] = $this->db->get('slides')->result_array();
            $this->load->view('back/vendor/slides_list', $page_data);
        }elseif ($para1 == 'slide_publish_set') {
            $slides_id = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('slides_id', $slides_id);
            $this->db->update('slides', $data);
            recache();
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/slides_add');
        } else {
            $page_data['page_name']  = "slides";
            $page_data['all_slidess'] = $this->db->get('slides')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    /* Login into vendor panel */
    function login($para1 = '')
    {
        if ($para1 == 'forget_form') {
            $page_data['control'] = 'vendor';
            $this->load->view('back/forget_password',$page_data);
        } else if ($para1 == 'forget') {
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');         
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $query = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email')
                ));
                if ($query->num_rows() > 0) {
                    $vendor_id         = $query->row()->vendor_id;
                    $password         = substr(hash('sha512', rand()), 0, 12);
                    $data['password'] = sha1($password);
                    $this->db->where('vendor_id', $vendor_id);
                    $this->db->update('vendor', $data);
                    if ($this->email_model->password_reset_email('vendor', $vendor_id, $password)) {
                        echo 'email_sent';
                    } else {
                        echo 'email_not_sent';
                    }
                } else {
                    echo 'email_nay';
                }
            }
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');
            
            if ($this->form_validation->run() == FALSE)
            {
                echo validation_errors();
            }
            else
            {
                $login_data = $this->db->get_where('vendor', array(
                    'email' => $this->input->post('email'),
                    'password' => sha1($this->input->post('password')),
                    'vendor_status' => 'complete'
                ));
                if ($login_data->num_rows() > 0) {
                    if($login_data->row()->status == 'approved' && $login_data->row()->vendor_status == 'complete'){
                        foreach ($login_data->result_array() as $row) {
                            $this->session->set_userdata('login', 'yes');
                            $this->session->set_userdata('vendor_login', 'yes');
                            $this->session->set_userdata('vendor_id', $row['vendor_id']);
                            $this->session->set_userdata('vendor_name', $row['name']);
                            $this->session->set_userdata('title', 'vendor');
                            echo 'lets_login';
                        }
                    } else {
                        echo 'unapproved';
                    }
                } else {
                    echo 'login_failed';
                }
            }
        }
    }
    
    
    /* Loging out from vendor panel */
    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url() . 'vendor', 'refresh');
    }
    
    /*Product coupon add, edit, view, delete */
    function coupon($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('coupon')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'do_add') {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['from'] = $this->input->post('from');
            $data['status'] = 'ok';
            $data['added_by'] = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['spec'] = json_encode(array(
                                'set_type'=>'product',
                                'set'=>json_encode($this->input->post('product')),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->insert('coupon', $data);
        } else if ($para1 == 'edit') {
            $page_data['coupon_data'] = $this->db->get_where('coupon', array(
                'coupon_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/coupon_edit', $page_data);
        } elseif ($para1 == "update") {
            $data['title'] = $this->input->post('title');
            $data['code'] = $this->input->post('code');
            $data['till'] = $this->input->post('till');
            $data['from'] = $this->input->post('from');
            $data['spec'] = json_encode(array(
                                'set_type'=>'product',
                                'set'=>json_encode($this->input->post('product')),
                                'discount_type'=>$this->input->post('discount_type'),
                                'discount_value'=>$this->input->post('discount_value'),
                                'shipping_free'=>$this->input->post('shipping_free')
                            ));
            $this->db->where('coupon_id', $para2);
            $this->db->update('coupon', $data);
        } elseif ($para1 == 'delete') {
            $this->db->where('coupon_id', $para2);
            $this->db->delete('coupon');
        } elseif ($para1 == 'list') {
            $this->db->order_by('coupon_id', 'desc');
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/vendor/coupon_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/coupon_add');
        } elseif ($para1 == 'publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('coupon_id', $product);
            $this->db->update('coupon', $data);
        } else {
            $page_data['page_name']      = "coupon";
            $page_data['all_coupons'] = $this->db->get('coupon')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /*Product Sale Comparison Reports*/
    function report($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'vendor');
        }
        $page_data['page_name'] = "report";
        $physical_system     =  $this->crud_model->get_type_name_by_id('general_settings','68','value');
        $digital_system      =  $this->crud_model->get_type_name_by_id('general_settings','69','value');
        if($physical_system !== 'ok' && $digital_system == 'ok'){
            $this->db->where('download','ok');
        }
        if($physical_system == 'ok' && $digital_system !== 'ok'){
            $this->db->where('download',NULL);
        }
        if($physical_system !== 'ok' && $digital_system !== 'ok'){
            $this->db->where('download','0');
        }
        $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
        $page_data['products']  = $this->db->get('product')->result_array();
        $this->load->view('back/index', $page_data);
    }
    
    /*Product Stock Comparison Reports*/
    function report_stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'vendor');
        }
        if ($this->crud_model->get_type_name_by_id('general_settings','68','value') !== 'ok') {
            redirect(base_url() . 'admin');
        }
        $page_data['page_name'] = "report_stock";
        if ($this->input->post('product')) {
            $page_data['product_name'] = $this->crud_model->get_type_name_by_id('product', $this->input->post('product'), 'title');
            $page_data['product']      = $this->input->post('product');
        }
        $this->load->view('back/index', $page_data);
    }
    
    /*Product Wish Comparison Reports*/
    function report_wish($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'vendor');
        }
        $page_data['page_name'] = "report_wish";
        $this->load->view('back/index', $page_data);
    }

    function import_product()
    {
        if (!$this->crud_model->vendor_permission('report')) {
            redirect(base_url() . 'vendor');
        }
        $page_data['page_name'] = "import_product";
        $this->load->view('back/index', $page_data);
    }
    function import()
    {
        $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);

        foreach($file_data as $row)
        {
            $data = array(
                'title' => $row["Title"],
                'variety'  => $row["variety"],
                'test_section' => $row["Rate meter section"],
                'test_title' => $row["Taste Title"],
                'test_sumary_title' => $row["Taste1 Name"],
                'test_sumary' => $row["Taste Summary"],
                'test1_name' => $row["Taste1 Name"],
                'test11_name' => $row["Taste2 Name"],
                'test2_name' => $row["Taste3 Name"],
                'test22_name' => $row["Taste4 Name"],
                'test3_name' => $row["Taste5 Name"],
                'test33_name' => $row["Taste6 Name"],
                'test4_name' => $row["Taste7 Name"],
                'test44_name' => $row["Taste8 Name"],
                'test5_name' => $row["Taste9 Name"],
                'test55_name' => $row["Taste10 Name"],
                'test1_number' => $row["T1 Rate Meter Number"],
                'test11_number' => $row["T2 Rate Meter Number"],
                'test2_number' => $row["T3 Rate Meter Number"],
                'test22_number' => $row["T4 Rate Meter Number"],
                'test3_number' => $row["T5 Rate Meter Number"],
                'test33_number' => $row["T6 Rate Meter Number"],
                'test4_number' => $row["T7 Rate Meter Number"],
                'test44_number' => $row["T8 Rate Meter Number"],
                'test5_number' => $row["T9 Rate Meter Number"],
                'test55_number' => $row["T10 Rate Meter Number"],
                'food_section' => $row["Food Pairing"],
                'food_title' => $row["Food Title"],
                'food_description' => $row["Food Description"],
                'food_name1' => $row["Food Name 1"],
                'food_name2' => $row["Food Name 2"],
                'food_name3' => $row["Food Name 3"],
                'food_name4' => $row["Food Name 4"],
                'category' => $row["Category"],
                'description' => $row["Description"],
                'sub_category' => $row["Sub Category"],
                'tag' => $row["Highlights"],
                'wholesale' => $row["wholesale"],
                'bundle_sale1' => $row["RRP"],
                'bundle_discount1' => $row["Product Discount"],
                'brand' => $row["Brand"],
                'current_stock' => $row["Stock"],
                'unit' => $row["unit"],
                'limited_release' => $row["Limited Release"],
                'product_abv' => $row["Product Abv"],
                'product_year' => $row["Product Year"],
                'regions' => $row["Regions"],
                'added_by' => json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))) 
            );
            $this->db->insert('product', $data);
        }
        echo "success";
    }
    public function cat_export_csv()
    { 
        // file name 
        $filename = 'category_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // file creation 
        $result = $this->db->select('category_id,category_name')->get_where('category')->result_array();

        $file = fopen('php://output','w');
        $header = array("Id","Name"); 
        fputcsv($file, $header);
        foreach ($result as $key=>$line)
        { 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
    }
    public function sub_cat_export_csv()
    { 
        // file name 
        $filename = 'sub_category_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // file creation 
        $result = $this->db->select('sub_category_id,sub_category_name')->get_where('sub_category')->result_array();

        $file = fopen('php://output','w');
        $header = array("Id","Name"); 
        fputcsv($file, $header);
        foreach ($result as $key=>$line)
        { 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
    }
    public function brands_export_csv()
    { 
        // file name 
        $filename = 'brands_'.date('Ymd').'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");
       
        // file creation 
        
        $result = $this->db->select('brand_id,name')->get_where('brand')->result_array();

        $file = fopen('php://output','w');
        $header = array("Id","Name"); 
        fputcsv($file, $header);
        foreach ($result as $key=>$line)
        { 
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
    }
    /* Product add, edit, view, delete, stock increase, decrease, discount */
    function product($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('product')) {
            redirect(base_url() . 'vendor');
        }
        if ($this->crud_model->get_type_name_by_id('general_settings','68','value') !== 'ok') {
            redirect(base_url() . 'admin');
        }
        if ($para1 == 'do_add') 
        {
            $options = array();
            $data['title']     = $this->input->post('title');
            $data['title_ch']     = $this->input->post('title_ch');
            $data['title_jp']     = $this->input->post('title_jp');
            $data['product_type'] = $this->input->post('product_type');
            $data['is_low_stock'] = $this->input->post('is_low_stock');
            $data['variety']      = $this->input->post('variety');
            $data['product_year'] = $this->input->post('product_year');
            $data['regions']      = $this->input->post('regions');
            if($this->input->post('product_abv') <= 30)
            {
                $data['product_abv']   = $this->input->post('product_abv');
            }
            else
            {
                echo "product Adv under 30";
            }
            
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description_en');
            $data['description_ch']        = $this->input->post('description_ch');
            $data['description_jp']        = $this->input->post('description_jp');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['test_section']       = $this->input->post('test_section');
            $data['test_title_en']         = $this->input->post('test_title_en');
            $data['test_title_ch']         = $this->input->post('test_title_ch');
            $data['test_title_jp']         = $this->input->post('test_title_jp');
            
            $data['test_sumary_title_en']        = $this->input->post('test_sumary_title_en');
            $data['test_sumary_title_ch']        = $this->input->post('test_sumary_title_ch');
            $data['test_sumary_title_jp']        = $this->input->post('test_sumary_title_jp');
            $data['test_sumary_en']         = $this->input->post('test_sumary_en');
            $data['test_sumary_ch']         = $this->input->post('test_sumary_ch');
            $data['test_sumary_jp']         = $this->input->post('test_sumary_jp');
            $data['test1_name']         = $this->input->post('test1_name');
            $data['test1_number']       = $this->input->post('test1_number');
            $data['test2_name']         = $this->input->post('test2_name');
            $data['test2_number']       = $this->input->post('test2_number');
            $data['test3_name']         = $this->input->post('test3_name');
            $data['test3_number']       = $this->input->post('test3_number');
            $data['test11_name']        = $this->input->post('test11_name');
            $data['test11_number']      = $this->input->post('test11_number');
            $data['test22_name']        = $this->input->post('test22_name');
            $data['test22_number']      = $this->input->post('test22_number');
            $data['test33_name']        = $this->input->post('test33_name');   
            $data['test33_number']      = $this->input->post('test33_number');
            $data['test4_name']      = $this->input->post('test4_name');  
            $data['test4_number']      = $this->input->post('test4_number'); 
            $data['test44_name']      = $this->input->post('test44_name');  
            $data['test44_number']      = $this->input->post('test44_number');
            $data['test5_name']      = $this->input->post('test5_name');  
            $data['test5_number']      = $this->input->post('test5_number'); 
            $data['test55_name']      = $this->input->post('test55_name');  
            $data['test55_number']      = $this->input->post('test55_number');  
            $data['wholesale']      = $this->input->post('wholesale');
            $data['wholesale_EXCL_WET_GST'] = $this->input->post('wholesale_EXCL_WET_GST');
            $data['sale_price_AU']      = $this->input->post('sale_price_AU');
            $data['sale_price_HK']      = $this->input->post('sale_price_HK');
            $data['sale_price_JP']      = $this->input->post('sale_price_JP');
            $data['sale_price_SG']      = $this->input->post('sale_price_SG');
            $data['discount']      = $this->input->post('discount');
            $data['add_timestamp']      = time();
            $data['download']           = NULL;
            $data['featured']           = 'no';
            $data['vendor_featured']    = 'no';
            $data['is_bundle']          = 'no';
            $data['status']             = 'ok';
            $data['rating_user']        = '[]';
            $data['tag']                = $this->input->post('tag');
            $data['limited_release']    = $this->input->post('limited_release');
            $data['color']              = json_encode($this->input->post('color'));
            
            $data['current_stock']      = $this->input->post('current_stock');
            $data['front_image']        = 0;
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            $data['brand']              = $this->input->post('brand');
            $data['unit']               = $this->input->post('unit');
            $choice_titles              = $this->input->post('op_title');
            $choice_types               = $this->input->post('op_type');
            $choice_no                  = $this->input->post('op_no');
            $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['food_section']       = $this->input->post('food_section');
            $data['food_title']         = $this->input->post('food_title');
            $data['food_description']   = $this->input->post('food_description');

            $data['food_preparation_1']         = $this->input->post('food_preparation_1');
            $data['food_preparation_2']         = $this->input->post('food_preparation_2');
            $data['food_preparation_3']         = $this->input->post('food_preparation_3');
            $data['food_preparation_4']         = $this->input->post('food_preparation_4');

            $data['food_origin_1']         = $this->input->post('food_origin_1');
            $data['food_origin_2']         = $this->input->post('food_origin_2');
            $data['food_origin_3']         = $this->input->post('food_origin_3');
            $data['food_origin_4']         = $this->input->post('food_origin_4');

            $data['food_name1']         = $this->input->post('food_name1');
            $data['food_name2']         = $this->input->post('food_name2');
            $data['food_name3']         = $this->input->post('food_name3');
            $data['food_name4']         = $this->input->post('food_name4');
            $data['food_image1']         = $this->input->post('food_image1');
            $data['food_image2']         = $this->input->post('food_image2');
            $data['food_image3']         = $this->input->post('food_image3');
            $data['food_image4']         = $this->input->post('food_image4');
            
            $total_img = $_FILES["images"];
            if ($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'no') 
            {
                if($this->crud_model->can_add_product($this->session->userdata('vendor_id')))
                {
                    $data["num_of_imgs"] = $this->crud_model->product_img_upload($total_img);
                    $this->db->insert('product', $data);
                    echo $this->db->last_query();
                    $id = $this->db->insert_id();
                    $this->benchmark->mark_time();
                }
                else
                {
                    echo 'already uploaded maximum product';
                }
            }
            elseif ($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'yes') 
            {
                $data["num_of_imgs"] = $this->crud_model->product_img_upload($total_img);
                $this->db->insert('product', $data);
               
                $id = $this->db->insert_id();
                $this->benchmark->mark_time();
               
            }
            $this->crud_model->set_category_data(0);
            recache();
        } else if ($para1 == "update") {
            $options = array();
            if (count($_FILES["images"]['name']) == 0 ) 
            {
                $num_of_imgs = 0;
            }
            else
            {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $download                   = $this->crud_model->get_type_name_by_id('product', $para2, 'download');
            $data['title']     = $this->input->post('title');
            $data['title_ch']     = $this->input->post('title_ch');
            $data['title_jp']     = $this->input->post('title_jp');
            $data['variety']            = $this->input->post('variety');
            $data['is_low_stock']       = $this->input->post('is_low_stock');
            $data['product_year']       = $this->input->post('product_year');
            $data['regions']       = $this->input->post('regions');
            $data['product_abv']       = $this->input->post('product_abv');
            $data['category']           = $this->input->post('category');
             $data['description']        = $this->input->post('description_en');
            $data['description_ch']        = $this->input->post('description_ch');
            $data['description_jp']        = $this->input->post('description_jp');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['unit']               = $this->input->post('unit');
            $data['limited_release']    = $this->input->post('limited_release');
            $data['tag']                = $this->input->post('tag');
            $data['test_section']       = $this->input->post('test_section');
           $data['test_title_en']         = $this->input->post('test_title_en');
            $data['test_title_ch']         = $this->input->post('test_title_ch');
            $data['test_title_jp']         = $this->input->post('test_title_jp');
            
            $data['test_sumary_title_en']        = $this->input->post('test_sumary_title_en');
            $data['test_sumary_title_ch']        = $this->input->post('test_sumary_title_ch');
            $data['test_sumary_title_jp']        = $this->input->post('test_sumary_title_jp');
            $data['test_sumary_en']         = $this->input->post('test_sumary_en');
            $data['test_sumary_ch']         = $this->input->post('test_sumary_ch');
            $data['test_sumary_jp']         = $this->input->post('test_sumary_jp');
            $data['test1_name']         = $this->input->post('test1_name');
            $data['test1_number']       = $this->input->post('test1_number');
            $data['test2_name']         = $this->input->post('test2_name');
            $data['test2_number']       = $this->input->post('test2_number');
            $data['test3_name']         = $this->input->post('test3_name');
            $data['test3_number']       = $this->input->post('test3_number');
            $data['test11_name']        = $this->input->post('test11_name');
            $data['test11_number']      = $this->input->post('test11_number');
            $data['test22_name']        = $this->input->post('test22_name');
            $data['test22_number']      = $this->input->post('test22_number');
            $data['test33_name']        = $this->input->post('test33_name');   
            $data['test33_number']      = $this->input->post('test33_number');  
            $data['test4_name']      = $this->input->post('test4_name');  
            $data['test4_number']      = $this->input->post('test4_number'); 
            $data['test44_name']      = $this->input->post('test44_name');  
            $data['test44_number']      = $this->input->post('test44_number');
            $data['test5_name']      = $this->input->post('test5_name');  
            $data['test5_number']      = $this->input->post('test5_number'); 
            $data['test55_name']      = $this->input->post('test55_name');  
            $data['test55_number']      = $this->input->post('test55_number');
            $data['wholesale']      = $this->input->post('wholesale'); 
            $data['wholesale_EXCL_WET_GST'] = $this->input->post('wholesale_EXCL_WET_GST');
            $data['sale_price_AU']      = $this->input->post('sale_price_AU');
            $data['sale_price_HK']      = $this->input->post('sale_price_HK');
            $data['sale_price_JP']      = $this->input->post('sale_price_JP');
            $data['sale_price_SG']      = $this->input->post('sale_price_SG'); 
            $data['discount']      = $this->input->post('discount');
            $data['brand']              = $this->input->post('brand');
            $data['food_section']         = $this->input->post('food_section');
            $data['food_title']         = $this->input->post('food_title');
            $data['food_description']   = $this->input->post('food_description');
            $data['food_preparation_1']         = $this->input->post('food_preparation_1');
            $data['food_preparation_2']         = $this->input->post('food_preparation_2');
            $data['food_preparation_3']         = $this->input->post('food_preparation_3');
            $data['food_preparation_4']         = $this->input->post('food_preparation_4');

            $data['food_origin_1']         = $this->input->post('food_origin_1');
            $data['food_origin_2']         = $this->input->post('food_origin_2');
            $data['food_origin_3']         = $this->input->post('food_origin_3');
            $data['food_origin_4']         = $this->input->post('food_origin_4');

            $data['food_name1']         = $this->input->post('food_name1');
            $data['food_name2']         = $this->input->post('food_name2');
            $data['food_name3']         = $this->input->post('food_name3');
            $data['food_name4']         = $this->input->post('food_name4');
            $data['food_image1']         = $this->input->post('food_image1');
            $data['food_image2']         = $this->input->post('food_image2');
            $data['food_image3']         = $this->input->post('food_image3');
            $data['food_image4']         = $this->input->post('food_image4');
            

            $total_img = $_FILES["images"];
            $last_products_images = $this->input->post('last_products_images');

            $data["num_of_imgs"] = $this->crud_model->product_img_upload($total_img,$para2,$last_products_images);

            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
            echo $this->db->last_query();
            $this->crud_model->set_category_data(0);
            recache();
        } 
        else if ($para1 == 'edit') 
        {
            recache();
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_edit', $page_data);
        }
        else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_view', $page_data);
        } 
        elseif ($para1 == 'delete_food') 
        {
            $productid = $this->input->post('productid');
            $imageid = $this->input->post('imageid');
            $remove_food_image = $this->db->get_where('product',array('product_id'=>$productid))->row();
            $var = "food_image".$imageid;
            unlink("uploads/product_image/".$remove_food_image->$var);
            $data_food_image["food_image$imageid"] = '';
            $this->db->where('product_id',$productid)->update('product', $data_food_image);
        }
        elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
            $this->crud_model->set_category_data(0);
            recache();
        }    

 		elseif ($para1 == 'add_remove') {

            $data['product'] = $para2;
            $this->load->view('back/vendor/product_remove', $data);
            
        } elseif ($para1 == 'remove') {
            $p_id        = $this->input->post('product_id');
            $data['remove']  = $this->input->post('remove');
            $this->db->where('product_id', $p_id);
            $this->db->update('product', $data);
            $this->db->last_query();
        
        }

        elseif ($para1 == 'list') {
            $this->db->order_by('product_id', 'desc');
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=',NULL);
            $page_data['all_product'] = $this->db->get('product')->result_array();
            // echo $this->db->last_query();
            // exit;
            $this->load->view('back/vendor/product_list', $page_data);
        } elseif ($para1 == 'list_data') {
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $this->db->where('download=',NULL);
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $total      = $this->db->get('product')->num_rows();
            $this->db->limit($limit);
            if($sort == ''){
                $sort = 'product_id';
                $order = 'DESC';
            }
            $this->db->order_by($sort,$order);
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=',NULL);
            $products   = $this->db->get('product', $limit, $offset)->result_array();
            $data       = array();
            $time = date("H:i:s");
            foreach ($products as $row) {

                $res    = array(
                             'image' => '',
                             'title' => '',
                             'current_stock' => '',
                             'publish' => '',
                             // 'featured' => '',
                             'options' => ''
                          );

                if($row['num_of_imgs'] !=NULL)
                {
                    $num_of_img = explode(",", $row['num_of_imgs']); 
                    $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                }
                else
                {
                    $first_image = base_url('uploads/product_image/default.jpg');
                }

                $res['image']  = '<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="'.$first_image.'?time='.strtotime($time).'"  />';
                
                $res['title']  = ucwords($row['title']);

                

                $s_cat_name = $this->db->get_where('sub_category',array('sub_category_id'=>$row['sub_category']))->row()->sub_category_name;
                $res['sub-category'] = ucwords($s_cat_name);                

                $res['variety'] = ucwords($row['variety']);

                $res['whlsale_gst'] = $row['wholesale_EXCL_WET_GST'];

                $res['whlsale_dmst'] = $row['wholesale'];
  
                $res['rrp_au'] = $row['sale_price_AU'];

                $res['rrp_hk'] = $row['sale_price_HK'];

                $res['rrp_jp'] = $row['sale_price_JP'];

                $res['rrp_sg'] = $row['sale_price_SG'];

                $res['limited_release'] = ucwords($row['limited_release']);

                if($row['is_low_stock']){
                    $res['low_stock'] = ucwords($row['is_low_stock']);
                } 

                if($row['remove']=='1'){
                    $res['remove'] =    "<a class=\"btn btn-danger btn-xs btn-labeled fa fa-close\" data-toggle=\"tooltip\"
                                            onclick=\"ajax_modal('add_remove','".translate('')."','".translate('remove_product!')."','add_remove','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                        </a>";
                } 

                if($row['status'] == 'ok'){
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" />';
                }
                if($row['vendor_featured'] == 'ok'){
                    $res['featured']  = '<input id="v_fet_'.$row['product_id'].'" class="sw4" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['featured']  = '<input id="v_fet_'.$row['product_id'].'" class="sw4" type="checkbox" data-id="'.$row['product_id'].'" />';
                }
                if($row['current_stock'] > 0){ 
                    /*$res['current_stock']  = $row['current_stock'].$row['unit'].'(s)';*/
                    $res['current_stock']  = $row['current_stock'];                     
                } else {
                    $res['current_stock']  = '<span class="label label-danger">'.translate('out_of_stock').'</span>';
                }

                //add html for action
                $res['options'] = "  <a  class=\"btn btn-info btn-xs btn-labeled fa fa-location-arrow\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('view','".translate('view_product')."','".translate('successfully_viewed!')."','product_view','".$row['product_id']."');proceed('to_list');\" data-original-title=\"View\" data-container=\"body\">
                                    ".translate('view')."
                            </a>
                            <a style='display:none;' class=\"btn btn-purple btn-xs btn-labeled fa fa-tag\" data-toggle=\"tooltip\"
                                onclick=\"ajax_modal('add_discount','".translate('view_discount')."','".translate('viewing_discount!')."','add_discount','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('discount')."
                            </a>
                            <a style='display:none;' class=\"btn btn-mint btn-xs btn-labeled fa fa-plus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('add_stock','".translate('add_product_quantity')."','".translate('quantity_added!')."','stock_add','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('stock')."
                            </a>
                            <a style='display:none;' class=\"btn btn-dark btn-xs btn-labeled fa fa-minus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('destroy_stock','".translate('reduce_product_quantity')."','".translate('quantity_reduced!')."','destroy_stock','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('destroy')."
                            </a>
                            
                            <a class=\"btn btn-success btn-xs btn-labeled fa fa-wrench\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('edit','".translate('edit_product')."','".translate('successfully_edited!')."','product_edit','".$row['product_id']."');proceed('to_list');\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('edit')."
                            </a>
                            
                            <a style='display:none;' onclick=\"delete_confirm('".$row['product_id']."','".translate('really_want_to_delete_this?')."')\" 
                                class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                    ".translate('delete')."
                            </a>
                            <a class=\"btn btn-danger btn-xs btn-labeled fa fa-close\" data-toggle=\"tooltip\"
                                            onclick=\"ajax_modal('add_remove','".translate('')."','".translate('remove_product!')."','add_remove','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                        </a>

                            ";
                $data[] = $res;
            }
            $result = array(
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } 
        else if ($para1 == 'dlt_img') 
        {
            $result = $this->db->get_where('product',array('product_id'=>$para3))->row()->num_of_imgs;
            $img_result = explode(",",$result);
            $img_arr = array();
            foreach ($img_result as $key => $value) 
            {
                if($value == $para2)
                {
                    if(file_exists('uploads/product_image/'.$para2))
                    {
                        unlink('uploads/product_image/'.$para2);
                    }
                }
                else
                {
                    $img_arr[] = $value;
                }
            }
            $implode_img  = implode(",",$img_arr);
            $this->db->where('product_id', $para3);
            $this->db->update('product', array('num_of_imgs' => $implode_img));
            echo $implode_img;
            recache();
        } 
        elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_brnd');
        } elseif ($para1 == 'brand_by_sub') {
            $brands=json_decode($this->crud_model->get_type_name_by_id('sub_category',$para2,'brand'),true);
            echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select required', '', 'brand_id', $brands, '', 'multi');
        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res');
        } elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        } elseif ($para1 == 'add') {
            if ($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'no') {
                if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
                    $this->load->view('back/vendor/product_add');
                } else {
                    $this->load->view('back/vendor/product_limit');
                }
            }
            elseif($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'yes'){
                $this->load->view('back/vendor/product_add');
            }
        } elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_destroy', $data);
        } elseif ($para1 == 'stock_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_add_discount', $data);
        } elseif ($para1 == 'product_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_v_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['vendor_featured'] = 'ok';
            } else {
                $data['vendor_featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_deal_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['deal'] = 'ok';
            } else {
                $data['deal'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            $this->crud_model->set_category_data(0);
            recache();
        } elseif ($para1 == 'add_discount_set') {
            $product               = $this->input->post('product');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            $this->crud_model->set_category_data(0);
            recache();
        } else {
            // echo " fdsdf";exit;
            $page_data['page_name']   = "product";
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $page_data['all_product'] = $this->db->get('product')->result_array();
            
            $this->load->view('back/index', $page_data);
        }
    }

    function remove_product($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('product')) {
            redirect(base_url() . 'vendor');
        }
        if ($this->crud_model->get_type_name_by_id('general_settings','68','value') !== 'ok') {
            redirect(base_url() . 'admin');
        }
        if ($para1 == "update") {
            $options = array();
            if (count($_FILES["images"]['name']) == 0 ) 
            {
                $num_of_imgs = 0;
            }
            else
            {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $download                   = $this->crud_model->get_type_name_by_id('product', $para2, 'download');
            $data['title']              = $this->input->post('title');
            $data['product_type']       = $this->input->post('product_type');
            $data['variety']            = $this->input->post('variety');
            $data['is_low_stock']       = $this->input->post('is_low_stock');
            $data['product_year']       = $this->input->post('product_year');
            $data['regions']       = $this->input->post('regions');
            $data['product_abv']       = $this->input->post('product_abv');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['unit']               = $this->input->post('unit');
            $data['limited_release']    = $this->input->post('limited_release');
            $data['tag']                = $this->input->post('tag');
            $data['test_section']       = $this->input->post('test_section');
            $data['test_title']         = $this->input->post('test_title');
            $data['test_sumary_title']  = $this->input->post('test_sumary_title');
            $data['test_sumary']        = $this->input->post('test_sumary');
            $data['test1_name']         = $this->input->post('test1_name');
            $data['test1_number']       = $this->input->post('test1_number');
            $data['test2_name']         = $this->input->post('test2_name');
            $data['test2_number']       = $this->input->post('test2_number');
            $data['test3_name']         = $this->input->post('test3_name');
            $data['test3_number']       = $this->input->post('test3_number');
            $data['test11_name']        = $this->input->post('test11_name');
            $data['test11_number']      = $this->input->post('test11_number');
            $data['test22_name']        = $this->input->post('test22_name');
            $data['test22_number']      = $this->input->post('test22_number');
            $data['test33_name']        = $this->input->post('test33_name');   
            $data['test33_number']      = $this->input->post('test33_number');  
            $data['test4_name']      = $this->input->post('test4_name');  
            $data['test4_number']      = $this->input->post('test4_number'); 
            $data['test44_name']      = $this->input->post('test44_name');  
            $data['test44_number']      = $this->input->post('test44_number');
            $data['test5_name']      = $this->input->post('test5_name');  
            $data['test5_number']      = $this->input->post('test5_number'); 
            $data['test55_name']      = $this->input->post('test55_name');  
            $data['test55_number']      = $this->input->post('test55_number');
            $data['wholesale']      = $this->input->post('wholesale'); 
            $data['sale_price_AU']      = $this->input->post('sale_price_AU');
            $data['sale_price_HK']      = $this->input->post('sale_price_HK');
            $data['sale_price_JP']      = $this->input->post('sale_price_JP');
            $data['sale_price_SG']      = $this->input->post('sale_price_SG'); 
            $data['discount']      = $this->input->post('discount');
            $data['brand']              = $this->input->post('brand');
            $data['food_section']         = $this->input->post('food_section');
            $data['food_title']         = $this->input->post('food_title');
            $data['food_description']   = $this->input->post('food_description');
            $data['food_name1']   = $this->input->post('food_name1');
            $data['food_name2']   = $this->input->post('food_name2');
            $data['food_name3']   = $this->input->post('food_name3');
            $data['food_name4']   = $this->input->post('food_name4');

            $extension = array("jpeg","jpg","png","gif");
            for ($food_img=1; $food_img <=4 ; $food_img++) 
            {
                if($_FILES["food_image$food_img"]["name"])
                { 
                    $file_name = $_FILES["food_image$food_img"]["name"];
                    $file_tmp = $_FILES["food_image$food_img"]["tmp_name"];
                    $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                    if(in_array($ext,$extension)) 
                    {
                        $filename = basename($file_name,$ext);
                        $newFileName = $filename.time().".".$ext;
                        $data["food_image$food_img"]  = $newFileName;
                        move_uploaded_file($file_tmp,"uploads/product_image/".$newFileName);
                    }
                    else
                    {
                        $data["food_image$food_img"]  = $this->input->post('last_food_image'.$food_img);
                    }
                }    
            }
            

            $total_img = $_FILES["images"];
            $last_products_images = $this->input->post('last_products_images');

            $data["num_of_imgs"] = $this->crud_model->product_img_upload($total_img,$para2,$last_products_images);

            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
            echo $this->db->last_query();

            $this->crud_model->set_category_data(0);
            recache();
        } 
        else if ($para1 == 'edit') 
        {
            recache();
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_edit', $page_data);
        }
        else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_view', $page_data);
        } 
        elseif ($para1 == 'delete_food') 
        {
            $productid = $this->input->post('productid');
            $imageid = $this->input->post('imageid');
            $remove_food_image = $this->db->get_where('product',array('product_id'=>$productid))->row();
            $var = "food_image".$imageid;
            unlink("uploads/product_image/".$remove_food_image->$var);
            $data_food_image["food_image$imageid"] = '';
            $this->db->where('product_id',$productid)->update('product', $data_food_image);
        }
        elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
            $this->crud_model->set_category_data(0);
            recache();

            
        }elseif ($para1 == 'add_revert') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_revert', $data);
            
        } elseif ($para1 == 'revert') {
            $p_id        = $this->input->post('product_id');
            $data['remove']        = $this->input->post('remove');
            $this->db->where('product_id', $p_id);
            $this->db->update('product', $data);
            
        
        }elseif ($para1 == 'list') {

            $this->db->order_by('product_id', 'desc');
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=',NULL);
            
            $page_data['all_product'] = $this->db->get('product')->result_array();
            
            $this->load->view('back/vendor/remove_product_list', $page_data);
        } elseif ($para1 == 'list_data') {
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $this->db->where('download=',NULL);
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $total      = $this->db->get('product')->num_rows();
            $this->db->limit($limit);
            if($sort == ''){
                $sort = 'product_id';
                $order = 'DESC';
            }
            $this->db->order_by($sort,$order);
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=',NULL);
            $this->db->where('remove','1');
            $products   = $this->db->get('product', $limit, $offset)->result_array();
            $data       = array();
            $time = date("H:i:s");
            foreach ($products as $row) {

                $res    = array(
                             'image' => '',
                             'title' => '',
                             'current_stock' => '',
                             'options' => ''
                          );

                if($row['num_of_imgs'] !=NULL)
                {
                    $num_of_img = explode(",", $row['num_of_imgs']); 
                    $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
                }
                else
                {
                    $first_image = base_url('uploads/product_image/default.jpg');
                }

                $res['image']  = '<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="'.$first_image.'?time='.strtotime($time).'"  />';
                
                $res['title']  = ucwords($row['title']);

                $s_cat_name = $this->db->get_where('sub_category',array('sub_category_id'=>$row['sub_category']))->row()->sub_category_name;
                $res['sub-category'] = ucwords($s_cat_name);

                $res['variety'] = ucwords($row['variety']);

                $res['whlsale_gst'] = $row['wholesale_EXCL_WET_GST'];

                $res['whlsale_dmst'] = $row['wholesale'];
  
                $res['rrp_au'] = $row['sale_price_AU'];

                $res['rrp_hk'] = $row['sale_price_HK'];

                $res['rrp_jp'] = $row['sale_price_JP'];

                $res['rrp_sg'] = $row['sale_price_SG'];

                $res['limited_release'] = ucwords($row['limited_release']);

                if($row['is_low_stock']){
                    $res['low_stock'] = ucwords($row['is_low_stock']);
                } 

                if($row['remove']=='1'){
                    $res['remove'] =    "<a class=\"btn btn-success btn-xs btn-labeled fa fa-check\" data-toggle=\"tooltip\"
                                            onclick=\"ajax_modal('add_revert','".translate('')."','".translate('revert_product!')."','add_revert','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                        </a>";
                } 

                if($row['vendor_featured'] == 'ok'){
                    $res['featured']  = '<input id="v_fet_'.$row['product_id'].'" class="sw4" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['featured']  = '<input id="v_fet_'.$row['product_id'].'" class="sw4" type="checkbox" data-id="'.$row['product_id'].'" />';
                }

                //add html for action
                
                $data[] = $res;
            }
            $result = array(
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } 
        else if ($para1 == 'dlt_img') 
        {
            $result = $this->db->get_where('product',array('product_id'=>$para3))->row()->num_of_imgs;
            $img_result = explode(",",$result);
            $img_arr = array();
            foreach ($img_result as $key => $value) 
            {
                if($value == $para2)
                {
                    if(file_exists('uploads/product_image/'.$para2))
                    {
                        unlink('uploads/product_image/'.$para2);
                    }
                }
                else
                {
                    $img_arr[] = $value;
                }
            }
            $implode_img  = implode(",",$img_arr);
            $this->db->where('product_id', $para3);
            $this->db->update('product', array('num_of_imgs' => $implode_img));
            echo $implode_img;
            recache();
        } 
        elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_brnd');
        } elseif ($para1 == 'brand_by_sub') {
            $brands=json_decode($this->crud_model->get_type_name_by_id('sub_category',$para2,'brand'),true);
            echo $this->crud_model->select_html('brand', 'brand', 'name', 'add', 'demo-chosen-select required', '', 'brand_id', $brands, '', 'multi');
        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res');
        } elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        } elseif ($para1 == 'add') {
            if ($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'no') {
                if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
                    $this->load->view('back/vendor/product_add');
                } else {
                    $this->load->view('back/vendor/product_limit');
                }
            }
            elseif($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'yes'){
                $this->load->view('back/vendor/product_add');
            }
        } elseif ($para1 == 'add_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_destroy', $data);
        } elseif ($para1 == 'stock_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_stock_report', $data);
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_add_discount', $data);
        } elseif ($para1 == 'product_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_v_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['vendor_featured'] = 'ok';
            } else {
                $data['vendor_featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_deal_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['deal'] = 'ok';
            } else {
                $data['deal'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            $this->crud_model->set_category_data(0);
            recache();
        } elseif ($para1 == 'add_discount_set') {
            $product               = $this->input->post('product');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            $this->crud_model->set_category_data(0);
            recache();
        } else {
            $page_data['page_name']   = "remove_product";
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Digital add, edit, view, delete, stock increase, decrease, discount */
    function digital($para1 = '', $para2 = '', $para3 = '')
    {
        if (!$this->crud_model->vendor_permission('product')) {
            redirect(base_url() . 'vendor');
        }
        if ($this->crud_model->get_type_name_by_id('general_settings','69','value') !== 'ok') {
            redirect(base_url() . 'admin');
        }
        if ($para1 == 'do_add') {
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            if ($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'no') {
                if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))) {
                    $data['title']              = $this->input->post('title');
                    $data['category']           = $this->input->post('category');
                    $data['description']        = $this->input->post('description');
                    $data['sub_category']       = $this->input->post('sub_category');
                    $data['sale_price']         = $this->input->post('sale_price');
                    $data['purchase_price']     = $this->input->post('purchase_price');
                    $data['add_timestamp']      = time();
                    $data['featured']           = 'no';
                    $data['status']             = 'ok';
                    $data['rating_user']        = '[]';
                    // $data['tax']                = $this->input->post('tax');
                    $data['discount']           = $this->input->post('discount');
                    $data['discount_type']      = $this->input->post('discount_type');
                    // $data['tax_type']           = $this->input->post('tax_type');
                    // $data['shipping_cost']      = 0;
                    $data['tag']                = $this->input->post('tag');
                    $data['num_of_imgs']        = $num_of_imgs;
                    $data['front_image']        = $this->input->post('front_image');
                    $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
                    $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
                    $data['additional_fields']  = json_encode($additional_fields);
                    $data['requirements']       =   '[]';
                    $data['video']              =   '[]';
                    
                    $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
                    
                    $this->db->insert('product', $data);
                    $id = $this->db->insert_id();
                    $this->benchmark->mark_time();
                    
                    $this->crud_model->file_up("images", "product", $id, 'multi');
                    
                    $path = $_FILES['logo']['name'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $data_logo['logo']       = 'digital_logo_'.$id.'.'.$ext;
                    $this->db->where('product_id' , $id);
                    $this->db->update('product' , $data_logo);
                    $this->crud_model->file_up("logo", "digital_logo", $id, '','no','.'.$ext);
                    
                    //Requirements add
                    $requirements               =   array();
                    $req_title                  =   $this->input->post('req_title');
                    $req_desc                   =   $this->input->post('req_desc');
                    if(!empty($req_title)){
                        foreach($req_title as $i => $row){
                            $requirements[]         =   array('index'=>$i,'field'=>$row,'desc'=>$req_desc[$i]);
                        }
                    }
                    
                    $data_req['requirements']           =   json_encode($requirements);
                    $this->db->where('product_id' , $id);
                    $this->db->update('product' , $data_req);
                    
                    //File upload
                    $rand           = substr(hash('sha512', rand()), 0, 20);
                    $name           = $id.'_'.$rand.'_'.$_FILES['product_file']['name'];
                    $da['download_name'] = $name;
                    $da['download'] = 'ok';
                    $folder = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;
                    move_uploaded_file($_FILES['product_file']['tmp_name'], 'uploads/file_products/' . $folder .'/' . $name);
                    $this->db->where('product_id', $id);
                    $this->db->update('product', $da);
                    
                    //vdo upload
                    $video_details              =   array();
                    if($this->input->post('upload_method') == 'upload'){                
                        $video              =   $_FILES['videoFile']['name'];
                        $ext                =   pathinfo($video,PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES['videoFile']['tmp_name'],'uploads/video_digital_product/digital_'.$id.'.'.$ext);
                        $video_src          =   'uploads/video_digital_product/digital_'.$id.'.'.$ext;
                        $video_details[]    =   array('type'=>'upload','from'=>'local','video_link'=>'','video_src'=>$video_src);
                        $data_vdo['video']  =   json_encode($video_details);
                        $this->db->where('product_id',$id);
                        $this->db->update('product',$data_vdo);     
                    }
                    elseif ($this->input->post('upload_method') == 'share'){
                        $from               = $this->input->post('site');
                        $video_link         = $this->input->post('video_link');
                        $code               = $this->input->post('video_code');
                        if($from=='youtube'){
                            $video_src      = 'https://www.youtube.com/embed/'.$code;
                        }else if($from=='dailymotion'){
                            $video_src      = '//www.dailymotion.com/embed/video/'.$code;
                        }else if($from=='vimeo'){
                            $video_src      = 'https://player.vimeo.com/video/'.$code;
                        }
                        $video_details[]    =   array('type'=>'share','from'=>$from,'video_link'=>$video_link,'video_src'=>$video_src);
                        $data_vdo['video']  =   json_encode($video_details);
                        $this->db->where('product_id',$id);
                        $this->db->update('product',$data_vdo); 
                    }
                } else {
                    echo 'already uploaded maximum product';
                }
            }
            elseif($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'yes'){
                $data['title']              = $this->input->post('title');
                $data['category']           = $this->input->post('category');
                $data['description']        = $this->input->post('description');
                $data['sub_category']       = $this->input->post('sub_category');
                $data['sale_price']         = $this->input->post('sale_price');
                $data['purchase_price']     = $this->input->post('purchase_price');
                $data['add_timestamp']      = time();
                $data['featured']           = 'no';
                $data['status']             = 'ok';
                $data['rating_user']        = '[]';
                // $data['tax']                = $this->input->post('tax');
                $data['discount']           = $this->input->post('discount');
                $data['discount_type']      = $this->input->post('discount_type');
                // $data['tax_type']           = $this->input->post('tax_type');
                // $data['shipping_cost']      = 0;
                $data['tag']                = $this->input->post('tag');
                $data['num_of_imgs']        = $num_of_imgs;
                $data['front_image']        = $this->input->post('front_image');
                $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
                $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
                $data['additional_fields']  = json_encode($additional_fields);
                $data['requirements']       =   '[]';
                $data['video']              =   '[]';
                
                $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
                
                $this->db->insert('product', $data);
                $id = $this->db->insert_id();
                $this->benchmark->mark_time();
                
                $this->crud_model->file_up("images", "product", $id, 'multi');
                
                $path = $_FILES['logo']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $data_logo['logo']       = 'digital_logo_'.$id.'.'.$ext;
                $this->db->where('product_id' , $id);
                $this->db->update('product' , $data_logo);
                $this->crud_model->file_up("logo", "digital_logo", $id, '','no','.'.$ext);
                
                //Requirements add
                $requirements               =   array();
                $req_title                  =   $this->input->post('req_title');
                $req_desc                   =   $this->input->post('req_desc');
                if(!empty($req_title)){
                    foreach($req_title as $i => $row){
                        $requirements[]         =   array('index'=>$i,'field'=>$row,'desc'=>$req_desc[$i]);
                    }
                }
                
                $data_req['requirements']           =   json_encode($requirements);
                $this->db->where('product_id' , $id);
                $this->db->update('product' , $data_req);
                
                //File upload
                $rand           = substr(hash('sha512', rand()), 0, 20);
                $name           = $id.'_'.$rand.'_'.$_FILES['product_file']['name'];
                $da['download_name'] = $name;
                $da['download'] = 'ok';
                $folder = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;
                move_uploaded_file($_FILES['product_file']['tmp_name'], 'uploads/file_products/' . $folder .'/' . $name);
                $this->db->where('product_id', $id);
                $this->db->update('product', $da);
                
                //vdo upload
                $video_details              =   array();
                if($this->input->post('upload_method') == 'upload'){                
                    $video              =   $_FILES['videoFile']['name'];
                    $ext                =   pathinfo($video,PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['videoFile']['tmp_name'],'uploads/video_digital_product/digital_'.$id.'.'.$ext);
                    $video_src          =   'uploads/video_digital_product/digital_'.$id.'.'.$ext;
                    $video_details[]    =   array('type'=>'upload','from'=>'local','video_link'=>'','video_src'=>$video_src);
                    $data_vdo['video']  =   json_encode($video_details);
                    $this->db->where('product_id',$id);
                    $this->db->update('product',$data_vdo);     
                }
                elseif ($this->input->post('upload_method') == 'share'){
                    $from               = $this->input->post('site');
                    $video_link         = $this->input->post('video_link');
                    $code               = $this->input->post('video_code');
                    if($from=='youtube'){
                        $video_src      = 'https://www.youtube.com/embed/'.$code;
                    }else if($from=='dailymotion'){
                        $video_src      = '//www.dailymotion.com/embed/video/'.$code;
                    }else if($from=='vimeo'){
                        $video_src      = 'https://player.vimeo.com/video/'.$code;
                    }
                    $video_details[]    =   array('type'=>'share','from'=>$from,'video_link'=>$video_link,'video_src'=>$video_src);
                    $data_vdo['video']  =   json_encode($video_details);
                    $this->db->where('product_id',$id);
                    $this->db->update('product',$data_vdo); 
                }
            }
            $this->crud_model->set_category_data(0);
            recache();
        } else if ($para1 == "update") {
            $options = array();
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $download                   = $this->crud_model->get_type_name_by_id('product', $para2, 'download');
            $data['title']              = $this->input->post('title');
            $data['category']           = $this->input->post('category');
            $data['description']        = $this->input->post('description');
            $data['sub_category']       = $this->input->post('sub_category');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            // $data['tax']                = $this->input->post('tax');
            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            // $data['tax_type']           = $this->input->post('tax_type');
            $data['tag']                = $this->input->post('tag');
            $data['update_time']        = time();
            $data['num_of_imgs']        = $num + $num_of_imgs;
            $data['front_image']        = $this->input->post('front_image');
            $additional_fields['name']  = json_encode($this->input->post('ad_field_names'));
            $additional_fields['value'] = json_encode($this->input->post('ad_field_values'));
            $data['additional_fields']  = json_encode($additional_fields);
            
            //File upload
            $this->crud_model->file_up("images", "product", $para2, 'multi');
            if($_FILES['product_file']['name'] !== ''){
                $rand           = substr(hash('sha512', rand()), 0, 20);
                $name           = $para2.'_'.$rand.'_'.$_FILES['product_file']['name'];
                $data['download_name'] = $name;
                $folder = $this->db->get_where('general_settings', array('type' => 'file_folder'))->row()->value;
                move_uploaded_file($_FILES['product_file']['tmp_name'], 'uploads/file_products/' . $folder .'/' . $name);
            }
            
            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
            
            if($_FILES['logo']['name'] !== ''){
                $path = $_FILES['logo']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $data_logo['logo']       = 'digital_logo_'.$para2.'.'.$ext;
                $this->db->where('product_id' , $para2);
                $this->db->update('product' , $data_logo);
                $this->crud_model->file_up("logo", "digital_logo", $para2, '','no','.'.$ext);
            }
            
            //Requirements add
            $requirements               =   array();
            $req_title                  =   $this->input->post('req_title');
            $req_desc                   =   $this->input->post('req_desc');
            if(!empty($req_title)){
                foreach($req_title as $i => $row){
                    $requirements[]         =   array('index'=>$i,'field'=>$row,'desc'=>$req_desc[$i]);
                }
            }
            $data_req['requirements']           =   json_encode($requirements);
            $this->db->where('product_id' , $para2);
            $this->db->update('product' , $data_req);
            
            //vdo upload
            $video_details              =   array();
            if($this->input->post('upload_method') == 'upload'){                
                $video              =   $_FILES['videoFile']['name'];
                $ext                =   pathinfo($video,PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['videoFile']['tmp_name'],'uploads/video_digital_product/digital_'.$para2.'.'.$ext);
                $video_src          =   'uploads/video_digital_product/digital_'.$para2.'.'.$ext;
                $video_details[]    =   array('type'=>'upload','from'=>'local','video_link'=>'','video_src'=>$video_src);
                $data_vdo['video']  =   json_encode($video_details);
                $this->db->where('product_id',$para2);
                $this->db->update('product',$data_vdo);     
            }
            elseif ($this->input->post('upload_method') == 'share'){
                $video= json_decode($this->crud_model->get_type_name_by_id('product',$para2,'video'),true);
                if($video[0]['type'] == 'upload'){
                    if(file_exists($video[0]['video_src'])){
                        unlink($video[0]['video_src']);         
                    }
                }
                $from               = $this->input->post('site');
                $video_link         = $this->input->post('video_link');
                $code               = $this->input->post('video_code');
                if($from=='youtube'){
                    $video_src      = 'https://www.youtube.com/embed/'.$code;
                }else if($from=='dailymotion'){
                    $video_src      = '//www.dailymotion.com/embed/video/'.$code;
                }else if($from=='vimeo'){
                    $video_src      = 'https://player.vimeo.com/video/'.$code;
                }
                $video_details[]    =   array('type'=>'share','from'=>$from,'video_link'=>$video_link,'video_src'=>$video_src);
                $data_vdo['video']  =   json_encode($video_details);
                $this->db->where('product_id',$para2);
                $this->db->update('product',$data_vdo); 
            }
            elseif ($this->input->post('upload_method') == 'delete'){
                $data_vdo['video']  =   '[]';
                $this->db->where('product_id',$para2);
                $this->db->update('product',$data_vdo);
                
                $video= json_decode($this->crud_model->get_type_name_by_id('product',$para2,'video'),true);
                if($video[0]['type'] == 'upload'){
                    if(file_exists($video[0]['video_src'])){
                        unlink($video[0]['video_src']);         
                    }
                }
            }
            $this->crud_model->set_category_data(0);
            
            recache();
        } else if ($para1 == 'edit') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/digital_edit', $page_data);
        } else if ($para1 == 'view') {
            $page_data['product_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/digital_view', $page_data);
        } else if ($para1 == 'download_file') {
            $this->crud_model->download_product($para2);
        } else if ($para1 == 'can_download') {
            if($this->crud_model->can_download($para2)){
                echo "yes";
            } else{
                echo "no";
            }
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            unlink("uploads/digital_logo_image/" .$this->crud_model->get_type_name_by_id('product',$para2,'logo'));
            $video=$this->crud_model->get_type_name_by_id('product',$para2,'video');
            if($video!=='[]'){
                $video_details= json_decode($video,true);
                if($video_details[0]['type'] == 'upload'){
                    if(file_exists($video_details[0]['video_src'])){
                        unlink($video_details[0]['video_src']);         
                    }
                }
            }
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
            $this->crud_model->set_category_data(0);
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('product_id', 'desc');
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=','ok');
            $page_data['all_product'] = $this->db->get('product')->result_array();
            $this->load->view('back/vendor/digital_list', $page_data);
        } elseif ($para1 == 'list_data') {
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=','ok');
            $total= $this->db->get('product')->num_rows();
            $this->db->limit($limit);
            if($sort == ''){
                $sort = 'product_id';
                $order = 'DESC';
            }
            $this->db->order_by($sort,$order);
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=','ok');
            $products   = $this->db->get('product', $limit, $offset)->result_array();
            $data       = array();
            foreach ($products as $row) {

                $res    = array(
                             'image' => '',
                             'title' => '',
                             'publish' => '',
                             'options' => ''
                          );

                $res['image']  = '<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="'.$this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one').'"  />';
                $res['title']  = $row['title'];
                if($row['status'] == 'ok'){
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" />';
                }

                //add html for action
                $res['options'] = "  <a class=\"btn btn-info btn-xs btn-labeled fa fa-location-arrow\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('view','".translate('view_product')."','".translate('successfully_viewed!')."','digital_view','".$row['product_id']."');proceed('to_list');\" data-original-title=\"View\" data-container=\"body\">
                                    ".translate('view')."
                            </a>
                            <a class=\"btn btn-purple btn-xs btn-labeled fa fa-tag\" data-toggle=\"tooltip\"
                                onclick=\"ajax_modal('add_discount','".translate('view_discount')."','".translate('viewing_discount!')."','add_discount','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('discount')."
                            </a>
                            <a class=\"btn btn-mint btn-xs btn-labeled fa fa-download\" data-toggle=\"tooltip\" 
                                onclick=\"digital_download(".$row['product_id'].")\" data-original-title=\"Download\" data-container=\"body\">
                                    ".translate('download')."
                            </a>
                            
                            <a class=\"btn btn-success btn-xs btn-labeled fa fa-wrench\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('edit','".translate('edit_product_(_digital_product_)')."','".translate('successfully_edited!')."','digital_edit','".$row['product_id']."');proceed('to_list');\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('edit')."
                            </a>
                            
                            <a onclick=\"delete_confirm('".$row['product_id']."','".translate('really_want_to_delete_this?')."')\" 
                                class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                    ".translate('delete')."
                            </a>";
                $data[] = $res;
            }
            $result = array(
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
            recache();
        } elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, '');
        } elseif ($para1 == 'product_by_sub') {
            echo $this->crud_model->select_html('product', 'product', 'title', 'add', 'demo-chosen-select required', '', 'sub_category', $para2, 'get_pro_res');
        } 
        elseif ($para1 == 'pur_by_pro') {
            echo $this->crud_model->get_type_name_by_id('product', $para2, 'purchase_price');
        }elseif ($para1 == 'add') {
            if ($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'no') {
                if($this->crud_model->can_add_product($this->session->userdata('vendor_id'))){
                    $this->load->view('back/vendor/digital_add');
                } else {
                    $this->load->view('back/vendor/product_limit');
                }
            }
            elseif ($this->db->get_where('business_settings',array('type' => 'commission_set'))->row()->value == 'yes') {
                $this->load->view('back/vendor/digital_add');
            }
            //$this->load->view('back/vendor/digital_add');
        } elseif ($para1 == 'sale_report') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/product_sale_report', $data);
        } elseif ($para1 == 'add_discount') {
            $data['product'] = $para2;
            $this->load->view('back/vendor/digital_add_discount', $data);
        } elseif ($para1 == 'product_featured_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_deal_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['deal'] = 'ok';
            } else {
                $data['deal'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'product_publish_set') {
            $product = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            $this->crud_model->set_category_data(0);
            recache();
        } elseif ($para1 == 'add_discount_set') {
            $product               = $this->input->post('product');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product);
            $this->db->update('product', $data);
            $this->crud_model->set_category_data(0);
            recache();
        }elseif ($para1 == 'video_preview') {
            if($para2 == 'youtube'){
                echo '<iframe width="400" height="300" src="https://www.youtube.com/embed/'.$para3.'" frameborder="0"></iframe>';
            }else if($para2 == 'dailymotion'){
                echo '<iframe width="400" height="300" src="//www.dailymotion.com/embed/video/'.$para3.'" frameborder="0"></iframe>';
            }else if($para2 == 'vimeo'){
                echo '<iframe src="https://player.vimeo.com/video/'.$para3.'" width="400" height="300" frameborder="0"></iframe>';
            }
        }else {
            $page_data['page_name']   = "digital";
            $this->db->order_by('product_id', 'desc');
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $this->db->where('download=','ok');
            $page_data['all_product'] = $this->db->get('product')->result_array();
            
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Product Stock add, edit, view, delete, stock increase, decrease, discount */
    function stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('stock')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'do_add') {
            $data['type']         = 'add';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['rate']         = $this->input->post('rate');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['added_by']     = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $data1['current_stock'] = $prev_quantity + $data['quantity'];
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
            recache();
        } else if ($para1 == 'do_destroy') {
            $data['type']         = 'destroy';
            $data['category']     = $this->input->post('category');
            $data['sub_category'] = $this->input->post('sub_category');
            $data['product']      = $this->input->post('product');
            $data['quantity']     = $this->input->post('quantity');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['added_by']     = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            $data['datetime']     = time();
            $this->db->insert('stock', $data);
            $prev_quantity = $this->crud_model->get_type_name_by_id('product', $data['product'], 'current_stock');
            $current       = $prev_quantity - $data['quantity'];
            if ($current <= 0) {
                $current = 0;
            }
            $data1['current_stock'] = $current;
            $this->db->where('product_id', $data['product']);
            $this->db->update('product', $data1);
            recache();
        } elseif ($para1 == 'delete') {
            $quantity = $this->crud_model->get_type_name_by_id('stock', $para2, 'quantity');
            $product  = $this->crud_model->get_type_name_by_id('stock', $para2, 'product');
            $type     = $this->crud_model->get_type_name_by_id('stock', $para2, 'type');
            if ($type == 'add') {
                $this->crud_model->decrease_quantity($product, $quantity);
            } else if ($type == 'destroy') {
                $this->crud_model->increase_quantity($product, $quantity);
            }
            $this->db->where('stock_id', $para2);
            $this->db->delete('stock');
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('stock_id', 'desc');
            $this->db->where('added_by',json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/vendor/stock_list', $page_data);
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/stock_add');
        } elseif ($para1 == 'destroy') {
            $this->load->view('back/vendor/stock_destroy');
        } elseif ($para1 == 'sub_by_cat') {
            $subcat_by_vendor= $this->crud_model->vendor_sub_categories($this->session->userdata('vendor_id'),$para2);
            $result = '';
            $result .=  "<select name=\"sub_category\" class=\"demo-chosen-select required\" onChange=\"get_product(this.value);\"><option value=\"\">".translate('select_sub_category')."</option>";
            foreach ($subcat_by_vendor as $row){
                $result .=  "<option value=\"".$row."\">".$this->crud_model->get_type_name_by_id('sub_category',$row,'sub_category_name')."</option>";
            }
            $result .=  "</select>";
            echo $result;
        }elseif ($para1 == 'pro_by_sub') {
            $product_by_vendor= $this->crud_model->vendor_products_by_sub($this->session->userdata('vendor_id'),$para2);
            $result = '';
            $result .=  "<select name=\"product\" class=\"demo-chosen-select required\" onChange=\"get_pro_res(this.value);\"><option value=\"\">".translate('select_product')."</option>";
            foreach ($product_by_vendor as $row){
                $result .=  "<option value=\"".$row."\">".$this->crud_model->get_type_name_by_id('product',$row,'title')."</option>";
            }

            $result .=  "</select>";
            echo $result;
        }
        else {
            $page_data['page_name'] = "stock";
            $page_data['all_stock'] = $this->db->get('stock')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Managing sales by users */
    function sales($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('sale')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'delete') {
            $carted = $this->db->get_where('stock', array(
                'sale_id' => $para2
            ))->result_array();
            foreach ($carted as $row2) {
                $this->stock('delete', $row2['stock_id']);
            }
            $this->db->where('sale_id', $para2);
            $this->db->delete('sale');
        }
        elseif ($para1 == 'list') 
        {
            $vendor_data = array("vendor"=>$this->session->userdata('vendor_id'),"status"=>"paid");
            $array[] = json_encode($vendor_data);

            $productinfo = array();
            $sale=$this->Webservice_model->getDataFromTabel('sale', '*');
            if(!empty($sale))
            {
                foreach($sale as $key => $val)
                {
                    if(!empty($val->product_details)){

                        $sale_vendor_id = json_decode($val->payment_status);
                        if($sale_vendor_id[0]->vendor == $this->session->userdata('vendor_id'))
                        {
                            $saledata = json_decode($val->product_details);    
                            $getCountry = !empty($val->shipping_address) ? json_decode($val->shipping_address) : "";    

                            $country = !empty($getCountry) ? $getCountry->country : "";
                            foreach($saledata as $data){
                                $saleArr = array();

                                $getoption = !empty($data->option) ? json_decode($data->option) : "";   
                                if(!empty($getoption->productid)){
                                    $productInfo=$this->Webservice_model->getDataFromTabel('product', 'category,current_stock,title,wholesale,wholesale_EXCL_WET_GST,shipping_cost',array('product_id'=>$getoption->productid));

                                    $productInfo = !empty($productInfo) ? $productInfo[0] : 0;
                                    $saleArr['product_id'] = $getoption->productid;
                                    $saleArr['country'] = $country;
                                    $saleArr['buyer'] = !empty($val->buyer) ?$val->buyer: "";
                                    $saleArr['sale_code'] = !empty($val->sale_code) ?$val->sale_code: "";
                                    $saleArr['sale_id'] = !empty($val->sale_id) ?$val->sale_id: "";
                                    $saleArr['grand_total'] = !empty($val->grand_total) ?$val->grand_total: "";
                                    $saleArr['sale_datetime'] = !empty($val->sale_datetime) ?$val->sale_datetime: "";
                                    $saleArr['qty'] = $data->qty;
                                    $saleArr['current_stock'] = !empty($cate_id) ? $cate_id->current_stock : 0;
                                    $saleArr['wholesale'] = !empty($productInfo) ? $productInfo->wholesale : 0;
                                    $saleArr['title'] = !empty($productInfo) ? $productInfo->title : "";
                                    $saleArr['wholesaleEXCLWETGST'] = !empty($productInfo) ? $productInfo->wholesale_EXCL_WET_GST : 0;
                                    $saleArr['shipping_cost'] = !empty($productInfo) ? $productInfo->shipping_cost : 0;
                                    $productinfo[]=$saleArr;
                                }
                            }
                        }    
                    }
                    
                }
            }

            $page_data['all_sales'] =$productinfo;

            // echo "<pre>"; print_r($productinfo);die;
            // $page_data['all_sales'] = $this->db->get('sale')->result_array();
            $this->load->view('back/vendor/sales_list', $page_data);
        } elseif ($para1 == 'view') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/sales_view', $page_data);
        } elseif ($para1 == 'send_invoice') {
            $page_data['sale'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->result_array();
            $text              = $this->load->view('back/includes_top', $page_data);
            $text .= $this->load->view('back/vendor/sales_view', $page_data);
            $text .= $this->load->view('back/includes_bottom', $page_data);
        } elseif ($para1 == 'delivery_payment') {
            $data['viewed'] = 'ok';
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
            $page_data['sale_id']         = $para2;
            $page_data['payment_type']    = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_type;
            $page_data['payment_details'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_details;

            $page_data['shipping_company'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->shipping_company;

            $page_data['tracking_id'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->tracking_id;

            $page_data['dispatch_date'] = $this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->dispatch_date;

            
            
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            foreach ($delivery_status as $row) 
            {
                if(isset($row['vendor']))
                {
                    if($row['vendor'] == $this->session->userdata('vendor_id'))
                    {
                        $page_data['delivery_status'] = $row['status'];
                        if(isset($row['comment']))
                        {
                            $page_data['comment'] = $row['comment'];
                        }
                        else
                        {
                            $page_data['comment'] = '';
                        }
                    }
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            foreach ($payment_status as $row) 
            {
                if(isset($row['vendor']))
                {
                    if($row['vendor'] == $this->session->userdata('vendor_id'))
                    {
                        $page_data['payment_status'] = $row['status'];
                    }
                }
            }
            
            $this->load->view('back/vendor/sales_delivery_payment', $page_data);
        }
        elseif ($para1 == 'delivery_payment_set') 
        {
            $delivery_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->delivery_status,true);
            $new_delivery_status = array();
            foreach ($delivery_status as $row) 
            {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$this->input->post('delivery_status'),'comment'=>$this->input->post('comment'),'delivery_time'=>time());
                    } else {
                        $new_delivery_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status'],'comment'=>$row['comment'],'delivery_time'=>$row['delivery_time']);
                    }
                }
                else if(isset($row['admin'])){
                    $new_delivery_status[] = array('admin'=>'','status'=>$row['status'],'delivery_time'=>$row['delivery_time']);
                }
            }
            $payment_status = json_decode($this->db->get_where('sale', array(
                'sale_id' => $para2
            ))->row()->payment_status,true);
            $new_payment_status = array();
            foreach ($payment_status as $row) {
                if(isset($row['vendor'])){
                    if($row['vendor'] == $this->session->userdata('vendor_id')){
                        $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$this->input->post('payment_status'));
                    } else {
                        $new_payment_status[] = array('vendor'=>$row['vendor'],'status'=>$row['status']);
                    }
                }
                else if(isset($row['admin'])){
                    $new_payment_status[] = array('admin'=>'','status'=>$row['status']);
                }
            }
            $data['payment_status']  = json_encode($new_payment_status);
            $data['delivery_status'] = json_encode($new_delivery_status);
            $data['payment_details'] = $this->input->post('payment_details');
            $data['shipping_company'] = $this->input->post('shipping_company');
            $data['tracking_id'] = $this->input->post('tracking_id');
            $data['dispatch_date'] = $this->input->post('dispatch_date');
            $this->db->where('sale_id', $para2);
            $this->db->update('sale', $data);
        }
        elseif ($para1 == 'add') 
        {
            $this->load->view('back/vendor/sales_add');
        }
        elseif ($para1 == 'total')
        {
            $sales = $this->db->get('sale')->result_array();
            $i = 0;
            foreach($sales as $row)
            {
                if($this->crud_model->is_sale_of_vendor($row['sale_id'],$this->session->userdata('vendor_id')))
                {
                    $i++;
                }
            }
            echo $i;
        }
        else
        {
            $page_data['page_name']      = "sales";
            $page_data['all_categories'] = $this->db->get('sale')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }
    
    /* Payments From Admin */
    
    function admin_payments($para1='', $para2=''){
        if(!$this->crud_model->vendor_permission('pay_to_vendor')){
            redirect(base_url() . 'vendor');
        }
        if($para1 == 'list'){
            $this->db->order_by('vendor_invoice_id','desc');
            $page_data['payment_list']  = $this->db->get_where('vendor_invoice',array('vendor_id' => $this->session->userdata('vendor_id')))->result_array();
            $this->load->view('back/vendor/admin_payments_list',$page_data);
        }
        else if($para1 == 'view'){
            $page_data['details']  = $this->db->get_where('vendor_invoice',array('vendor_id' => $this->session->userdata('vendor_id'), 'vendor_invoice_id' => $para2))->result_array();
            $this->load->view('back/vendor/admin_payments_view',$page_data);
        }
        else{
            $page_data['page_name'] = 'admin_payments';
            $this->load->view('back/index',$page_data);
        }
        
    }
    
    /* Package Upgrade History */ 
    
    function upgrade_history($para1='',$para2=''){
        if(!$this->crud_model->vendor_permission('business_settings')){
            redirect(base_url() . 'vendor');
        }
        if($para1=='list'){
            $this->db->order_by('membership_payment_id','desc');
            $page_data['package_history']   = $this->db->get_where('membership_payment',array('vendor' => $this->session->userdata('vendor_id')))->result_array();
            $this->load->view('back/vendor/upgrade_history_list',$page_data);
        }
        else if($para1 == 'view'){
            $page_data['upgrade_history_data'] = $this->db->get_where('membership_payment',array('membership_payment_id' => $para2))->result_array();
            $this->load->view('back/vendor/upgrade_history_view',$page_data);
        }
        else{
            $page_data['page_name'] = 'upgrade_history';
            $this->load->view('back/index',$page_data);
        }
    }
    
    /* Checking Login Stat */
    function is_logged()
    {
        if ($this->session->userdata('vendor_login') == 'yes') {
            echo 'yah!good';
        } else {
            echo 'nope!bad';
        }
    }
    
    /* Manage Site Settings */
    function site_settings($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        $page_data['page_name'] = "site_settings";
        $page_data['tab_name']  = $para1;
        $this->load->view('back/index', $page_data);
    }
    

    /* Manage Business Settings */
    function package($para1 = "", $para2 = "")
    {
        if ($para1 == 'upgrade') {
            $method         = $this->input->post('method');
            $type           = $this->input->post('membership');
            $vendor         = $this->session->userdata('vendor_id');
            if($type !== '0'){
                $amount         = $this->db->get_where('membership',array('membership_id'=>$type))->row()->price;
                $amount_in_usd  = $amount/exchange('usd');
                if ($method == 'paypal') {

                    $paypal_email           = $this->db->get_where('business_settings',array('type'=>'paypal_email'))->row()->value;
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'paypal';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_xclick');
                    
                    $this->paypal->add_field('amount', $this->cart->format_number($amount_in_usd));

                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $invoice_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'vendor/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'vendor/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'vendor/paypal_success');
                    
                    $this->paypal->submit_paypal_post();
                    // submit the fields to paypal

                }elseif ($method == 'pum') {

                    $pum_key           = $this->db->get_where('business_settings',array('type'=>'pum_merchant_key'))->row()->value;
                    $pum_salt           = $this->db->get_where('business_settings',array('type'=>'pum_merchant_salt'))->row()->value;
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'PayUmoney';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    $this->pum->add_field('key', $pum_key);
                    $this->pum->add_field('txnid',substr(hash('sha256', mt_rand() . microtime()), 0, 20));
                    $this->pum->add_field('amount', $amount);
                    $this->pum->add_field('firstname', $this->db->get_where('vendor', array('vendor_id' => $vendor))->row()->name);
                    $this->pum->add_field('email', $this->db->get_where('vendor', array('vendor_id' => $vendor))->row()->email);
                    $this->pum->add_field('phone', 'Not Given');
                    $this->pum->add_field('productinfo', 'Payment with PayUmoney');
                    $this->pum->add_field('service_provider', 'payu_paisa');
                    $this->pum->add_field('udf1', $vendor);
                    
                    $this->pum->add_field('surl', base_url().'vendor/vendor_pum_success');
                    $this->pum->add_field('furl', base_url().'vendor/vendor_pum_failure');
                    
                    // submit the fields to pum
                    $this->pum->submit_pum_post();

                }elseif ($method == 'ssl') {

                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'SSlcommerz';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    $ssl_store_id = $this->db->get_where('business_settings', array('type' => 'ssl_store_id'))->row()->value;
                    $ssl_store_passwd = $this->db->get_where('business_settings', array('type' => 'ssl_store_passwd'))->row()->value;
                    $ssl_type = $this->db->get_where('business_settings', array('type' => 'ssl_type'))->row()->value;

                    /* PHP */
                    $post_data = array();
                    $post_data['store_id'] = $ssl_store_id;
                    $post_data['store_passwd'] = $ssl_store_passwd;
                    $post_data['total_amount'] = $amount;
                    $post_data['currency'] = "BDT";
                    $post_data['tran_id'] = date('Ym', $data['timestamp']) . $invoice_id;
                    $post_data['success_url'] = base_url()."vendor/vendor_sslcommerz_success";
                    $post_data['fail_url'] = base_url()."vendor/vendor_sslcommerz_fail";
                    $post_data['cancel_url'] = base_url()."vendor/vendor_sslcommerz_cancel";
                    # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

                    # EMI INFO
                    $post_data['emi_option'] = "1";
                    $post_data['emi_max_inst_option'] = "9";
                    $post_data['emi_selected_inst'] = "9";

                    $user_id = $this->session->userdata('vendor_id');
                    $user_info = $this->db->get_where('vendor', array('vendor_id' => $user_id))->row();

                    $cus_name = $user_info->name;
                    
                    # CUSTOMER INFORMATION
                    $post_data['cus_name'] = $cus_name;
                    $post_data['cus_email'] = $user_info->email;
                    $post_data['cus_add1'] = $user_info->address1;
                    $post_data['cus_add2'] = $user_info->address2;
                    $post_data['cus_city'] = $user_info->city;
                    $post_data['cus_state'] = $user_info->state;
                    $post_data['cus_postcode'] = $user_info->zip;
                    $post_data['cus_country'] = $user_info->country;
                    $post_data['cus_phone'] = $user_info->phone;

                    # REQUEST SEND TO SSLCOMMERZ
                    if ($ssl_type == "sandbox") {
                        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php"; // Sandbox
                    } elseif ($ssl_type == "live") {
                        $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v3/api.php"; // Live
                    }

                    $handle = curl_init();
                    curl_setopt($handle, CURLOPT_URL, $direct_api_url );
                    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
                    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($handle, CURLOPT_POST, 1 );
                    curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    if ($ssl_type == "sandbox") {
                        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC
                    } elseif ($ssl_type == "live") {
                        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, TRUE);
                    }


                    $content = curl_exec($handle);

                    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                    if($code == 200 && !( curl_errno($handle))) {
                        curl_close( $handle);
                        $sslcommerzResponse = $content;
                    } else {
                        curl_close( $handle);
                        echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
                        exit;
                    }

                    # PARSE THE JSON RESPONSE
                    $sslcz = json_decode($sslcommerzResponse, true );

                    if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
                        # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
                        # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
                        echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
                        # header("Location: ". $sslcz['GatewayPageURL']);
                        exit;
                    } else {
                        echo "JSON Data parsing error!";
                    }

                }else if ($method == 'c2') {
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'c2';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);

                    $c2_user = $this->db->get_where('business_settings',array('type' => 'c2_user'))->row()->value; 
                    $c2_secret = $this->db->get_where('business_settings',array('type' => 'c2_secret'))->row()->value;
                    

                    $this->twocheckout_lib->set_acct_info($c2_user, $c2_secret, 'Y');
                    $this->twocheckout_lib->add_field('sid', $this->twocheckout_lib->sid);              //Required - 2Checkout account number
                    $this->twocheckout_lib->add_field('cart_order_id', $invoice_id);   //Required - Cart ID
                    $this->twocheckout_lib->add_field('total',$this->cart->format_number($amount_in_usd));          
                    
                    $this->twocheckout_lib->add_field('x_receipt_link_url', base_url().'vendor/twocheckout_success');
                    $this->twocheckout_lib->add_field('demo', $this->twocheckout_lib->demo);                    //Either Y or N
                    
                    $this->twocheckout_lib->submit_form();
                }else if($method == 'vp'){
                    $vp_id                  = $this->db->get_where('business_settings',array('type'=>'vp_merchant_id'))->row()->value;
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'vouguepay';
                    $data['membership']     = $type; 
                    $data['timestamp']      = time();

                    $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);

                    /****TRANSFERRING USER TO vouguepay TERMINAL****/
                    $this->vouguepay->add_field('v_merchant_id', $vp_id);
                    $this->vouguepay->add_field('merchant_ref', $invoice_id);
                    $this->vouguepay->add_field('memo', 'Package Upgrade to '.$type);
                    //$this->vouguepay->add_field('developer_code', $developer_code);
                    //$this->vouguepay->add_field('store_id', $store_id);

                    
                    $this->vouguepay->add_field('total', $amount);

                    //$this->vouguepay->add_field('amount', $grand_total);
                    //$this->vouguepay->add_field('custom', $sale_id);
                    //$this->vouguepay->add_field('business', $vouguepay_email);

                    $this->vouguepay->add_field('notify_url', base_url() . 'vendor/vouguepay_ipn');
                    $this->vouguepay->add_field('fail_url', base_url() . 'vendor/vouguepay_cancel');
                    $this->vouguepay->add_field('success_url', base_url() . 'vendor/vouguepay_success');
                    
                    $this->vouguepay->submit_vouguepay_post();
                    // submit the fields to vouguepay
                } else if ($method == 'stripe') {
                    if($this->input->post('stripeToken')) {
                        
                        $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
                        require_once(APPPATH . 'libraries/stripe-php/init.php');
                        \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                        $vendor_email = $this->db->get_where('vendor' , array('vendor_id' => $vendor))->row()->email;
                        
                        $vendora = \Stripe\Customer::create(array(
                            'email' => $vendor_email, // customer email id
                            'card'  => $_POST['stripeToken']
                        ));

                        $charge = \Stripe\Charge::create(array(
                            'customer'  => $vendora->id,
                            'amount'    => ceil($amount_in_usd*100),
                            'currency'  => 'USD'
                        ));

                        if($charge->paid == true){
                            $vendora = (array) $vendora;
                            $charge = (array) $charge;
                            
                            $data['vendor']         = $vendor;
                            $data['amount']         = $amount;
                            $data['status']         = 'paid';
                            $data['method']         = 'stripe';
                            $data['timestamp']      = time();
                            $data['membership']     = $type;
                            $data['details']        = "Customer Info: \n".json_encode($vendora,true)."\n \n Charge Info: \n".json_encode($charge,true);
                            
                            $this->db->insert('membership_payment', $data);
                            $this->crud_model->upgrade_membership($vendor,$type);
                            redirect(base_url() . 'vendor/package/', 'refresh');
                        } else {
                            $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                            redirect(base_url() . 'vendor/package/', 'refresh');
                        }
                        
                    } else{
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'vendor/package/', 'refresh');
                    }
                } else if ($method == 'cash') {
                    $data['vendor']         = $vendor;
                    $data['amount']         = $amount;
                    $data['status']         = 'due';
                    $data['method']         = 'cash';
                    $data['timestamp']      = time();
                    $data['membership']     = $type;
                    $this->db->insert('membership_payment', $data);
                    redirect(base_url() . 'vendor/package/', 'refresh');
                } else {
                    echo 'putu';
                }
            } else {
                redirect(base_url() . 'vendor/package/', 'refresh');
            }
        } else {
            $page_data['page_name'] = "package";
            $this->load->view('back/index', $page_data);
        }
    }

    function premium_packages($para1 = "", $para2 = "")
    {
        if ($para1 == 'upgrade') {

            $method         = $this->input->post('method');
            $package_id     = $this->input->post('package_id');
            $vendor         = $this->session->userdata('vendor_id');

            
            if($package_id < '1'){
                $amount         = $this->db->get_where('package',array('package_id'=>$package_id))->row()->amount;
                $validity = $this->db->get_where('package', array('package_id' => $package_id))->row()->validity;
                $curr_date =  date('Y-m-d');
                $expire_date = date('Y-m-d', strtotime($curr_date. ' + '.$validity .'days'));
                $amount_in_usd  = $amount/exchange('usd');

                if ($method == 'paypal') {

                    $paypal_email           = $this->db->get_where('business_settings',array('type'=>'paypal_email'))->row()->value;
                    $data['user_id']            = $vendor;
                    $data['amount']             = $amount;
                    $data['payment_status']     = 'due';
                    $data['payment_type']       = 'paypal';
                    $data['package_id']         = $package_id; 
                    $data['purchase_datetime']  = time();
                    $data['payment_timestamp']  = time();
                    $data['expire']             = 'yes';
                    $data['expire_timestamp']   = strtotime($expire_date);

                    $this->db->insert('package_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    /****TRANSFERRING USER TO PAYPAL TERMINAL****/
                    $this->paypal->add_field('rm', 2);
                    $this->paypal->add_field('no_note', 0);
                    $this->paypal->add_field('cmd', '_xclick');
                    
                    $this->paypal->add_field('amount', $this->cart->format_number($amount_in_usd));

                    //$this->paypal->add_field('amount', $grand_total);
                    $this->paypal->add_field('custom', $invoice_id);
                    $this->paypal->add_field('business', $paypal_email);
                    $this->paypal->add_field('notify_url', base_url() . 'vendor/paypal_ipn');
                    $this->paypal->add_field('cancel_return', base_url() . 'vendor/paypal_cancel');
                    $this->paypal->add_field('return', base_url() . 'vendor/paypal_success');
                    
                    $this->paypal->submit_paypal_post();
                    // submit the fields to paypal

                }elseif ($method == 'pum') {

                    $pum_key           = $this->db->get_where('business_settings',array('type'=>'pum_merchant_key'))->row()->value;
                    $pum_salt           = $this->db->get_where('business_settings',array('type'=>'pum_merchant_salt'))->row()->value;

                    $data['user_id']            = $vendor;
                    $data['amount']             = $amount;
                    $data['payment_status']     = 'due';
                    $data['payment_type']       = 'PayUmoney';
                    $data['package_id']         = $package_id; 
                    $data['purchase_datetime']  = time();
                    $data['payment_timestamp']  = time();
                    $data['expire']             = 'yes';
                    $data['expire_timestamp']   = strtotime($expire_date);

                    $this->db->insert('package_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    $this->pum->add_field('key', $pum_key);
                    $this->pum->add_field('txnid',substr(hash('sha256', mt_rand() . microtime()), 0, 20));
                    $this->pum->add_field('amount', $amount);
                    $this->pum->add_field('firstname', $this->db->get_where('vendor', array('vendor_id' => $vendor))->row()->name);
                    $this->pum->add_field('email', $this->db->get_where('vendor', array('vendor_id' => $vendor))->row()->email);
                    $this->pum->add_field('phone', 'Not Given');
                    $this->pum->add_field('productinfo', 'Payment with PayUmoney');
                    $this->pum->add_field('service_provider', 'payu_paisa');
                    $this->pum->add_field('udf1', $vendor);
                    
                    $this->pum->add_field('surl', base_url().'vendor/vendor_pum_success');
                    $this->pum->add_field('furl', base_url().'vendor/vendor_pum_failure');
                    
                    // submit the fields to pum
                    $this->pum->submit_pum_post();

                }elseif ($method == 'ssl') {

                    // $data['vendor']         = $vendor;
                    // $data['amount']         = $amount;
                    // $data['status']         = 'due';
                    // $data['method']         = 'SSlcommerz';
                    // $data['membership']     = $type; 
                    // $data['timestamp']      = time();

                    $data['user_id']            = $vendor;
                    $data['amount']             = $amount;
                    $data['payment_status']     = 'due';
                    $data['payment_type']       = 'SSlcommerz';
                    $data['package_id']         = $package_id; 
                    $data['purchase_datetime']  = time();
                    $data['payment_timestamp']  = time();
                    $data['expire']             = 'yes';
                    $data['expire_timestamp']   = strtotime($expire_date);

                    $this->db->insert('package_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);
                    
                    $ssl_store_id = $this->db->get_where('business_settings', array('type' => 'ssl_store_id'))->row()->value;
                    $ssl_store_passwd = $this->db->get_where('business_settings', array('type' => 'ssl_store_passwd'))->row()->value;
                    $ssl_type = $this->db->get_where('business_settings', array('type' => 'ssl_type'))->row()->value;

                    /* PHP */
                    $post_data = array();
                    $post_data['store_id'] = $ssl_store_id;
                    $post_data['store_passwd'] = $ssl_store_passwd;
                    $post_data['total_amount'] = $amount;
                    $post_data['currency'] = "BDT";
                    $post_data['tran_id'] = date('Ym', $data['timestamp']) . $invoice_id;
                    $post_data['success_url'] = base_url()."vendor/vendor_sslcommerz_success";
                    $post_data['fail_url'] = base_url()."vendor/vendor_sslcommerz_fail";
                    $post_data['cancel_url'] = base_url()."vendor/vendor_sslcommerz_cancel";
                    # $post_data['multi_card_name'] = "mastercard,visacard,amexcard";  # DISABLE TO DISPLAY ALL AVAILABLE

                    # EMI INFO
                    $post_data['emi_option'] = "1";
                    $post_data['emi_max_inst_option'] = "9";
                    $post_data['emi_selected_inst'] = "9";

                    $user_id = $this->session->userdata('vendor_id');
                    $user_info = $this->db->get_where('vendor', array('vendor_id' => $user_id))->row();

                    $cus_name = $user_info->name;
                    
                    # CUSTOMER INFORMATION
                    $post_data['cus_name'] = $cus_name;
                    $post_data['cus_email'] = $user_info->email;
                    $post_data['cus_add1'] = $user_info->address1;
                    $post_data['cus_add2'] = $user_info->address2;
                    $post_data['cus_city'] = $user_info->city;
                    $post_data['cus_state'] = $user_info->state;
                    $post_data['cus_postcode'] = $user_info->zip;
                    $post_data['cus_country'] = $user_info->country;
                    $post_data['cus_phone'] = $user_info->phone;

                    # REQUEST SEND TO SSLCOMMERZ
                    if ($ssl_type == "sandbox") {
                        $direct_api_url = "https://sandbox.sslcommerz.com/gwprocess/v3/api.php"; // Sandbox
                    } elseif ($ssl_type == "live") {
                        $direct_api_url = "https://securepay.sslcommerz.com/gwprocess/v3/api.php"; // Live
                    }

                    $handle = curl_init();
                    curl_setopt($handle, CURLOPT_URL, $direct_api_url );
                    curl_setopt($handle, CURLOPT_TIMEOUT, 30);
                    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
                    curl_setopt($handle, CURLOPT_POST, 1 );
                    curl_setopt($handle, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    if ($ssl_type == "sandbox") {
                        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE); # KEEP IT FALSE IF YOU RUN FROM LOCAL PC
                    } elseif ($ssl_type == "live") {
                        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, TRUE);
                    }


                    $content = curl_exec($handle);

                    $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

                    if($code == 200 && !( curl_errno($handle))) {
                        curl_close( $handle);
                        $sslcommerzResponse = $content;
                    } else {
                        curl_close( $handle);
                        echo "FAILED TO CONNECT WITH SSLCOMMERZ API";
                        exit;
                    }

                    # PARSE THE JSON RESPONSE
                    $sslcz = json_decode($sslcommerzResponse, true );

                    if(isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL']!="" ) {
                        # THERE ARE MANY WAYS TO REDIRECT - Javascript, Meta Tag or Php Header Redirect or Other
                        # echo "<script>window.location.href = '". $sslcz['GatewayPageURL'] ."';</script>";
                        echo "<meta http-equiv='refresh' content='0;url=".$sslcz['GatewayPageURL']."'>";
                        # header("Location: ". $sslcz['GatewayPageURL']);
                        exit;
                    } else {
                        echo "JSON Data parsing error!";
                    }

                }else if ($method == 'c2') {
                    // $data['vendor']         = $vendor;
                    // $data['amount']         = $amount;
                    // $data['status']         = 'due';
                    // $data['method']         = 'c2';
                    // $data['membership']     = $type; 
                    // $data['timestamp']      = time();


                    $data['user_id']            = $vendor;
                    $data['amount']             = $amount;
                    $data['payment_status']     = 'due';
                    $data['payment_type']       = 'c2';
                    $data['package_id']         = $package_id; 
                    $data['purchase_datetime']  = time();
                    $data['payment_timestamp']  = time();
                    $data['expire']             = 'yes';
                    $data['expire_timestamp']   = strtotime($expire_date);

                    $this->db->insert('package_payment', $data);

                    // $this->db->insert('membership_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);

                    $c2_user = $this->db->get_where('business_settings',array('type' => 'c2_user'))->row()->value; 
                    $c2_secret = $this->db->get_where('business_settings',array('type' => 'c2_secret'))->row()->value;
                    

                    $this->twocheckout_lib->set_acct_info($c2_user, $c2_secret, 'Y');
                    $this->twocheckout_lib->add_field('sid', $this->twocheckout_lib->sid);              //Required - 2Checkout account number
                    $this->twocheckout_lib->add_field('cart_order_id', $invoice_id);   //Required - Cart ID
                    $this->twocheckout_lib->add_field('total',$this->cart->format_number($amount_in_usd));          
                    
                    $this->twocheckout_lib->add_field('x_receipt_link_url', base_url().'vendor/twocheckout_success');
                    $this->twocheckout_lib->add_field('demo', $this->twocheckout_lib->demo);                    //Either Y or N
                    
                    $this->twocheckout_lib->submit_form();
                }else if($method == 'vp'){
                    $vp_id                  = $this->db->get_where('business_settings',array('type'=>'vp_merchant_id'))->row()->value;
                    // $data['vendor']         = $vendor;
                    // $data['amount']         = $amount;
                    // $data['status']         = 'due';
                    // $data['method']         = 'vouguepay';
                    // $data['membership']     = $type; 
                    // $data['timestamp']      = time();

                    $data['user_id']            = $vendor;
                    $data['amount']             = $amount;
                    $data['payment_status']     = 'due';
                    $data['payment_type']       = 'vouguepay';
                    $data['package_id']         = $package_id; 
                    $data['purchase_datetime']  = time();
                    $data['payment_timestamp']  = time();
                    $data['expire']             = 'yes';
                    $data['expire_timestamp']   = strtotime($expire_date);

                    $this->db->insert('package_payment', $data);
                    $invoice_id           = $this->db->insert_id();
                    $this->session->set_userdata('invoice_id', $invoice_id);

                    /****TRANSFERRING USER TO vouguepay TERMINAL****/
                    $this->vouguepay->add_field('v_merchant_id', $vp_id);
                    $this->vouguepay->add_field('merchant_ref', $invoice_id);
                    $this->vouguepay->add_field('memo', 'Package Upgrade to '.$type);
                    //$this->vouguepay->add_field('developer_code', $developer_code);
                    //$this->vouguepay->add_field('store_id', $store_id);

                    
                    $this->vouguepay->add_field('total', $amount);

                    //$this->vouguepay->add_field('amount', $grand_total);
                    //$this->vouguepay->add_field('custom', $sale_id);
                    //$this->vouguepay->add_field('business', $vouguepay_email);

                    $this->vouguepay->add_field('notify_url', base_url() . 'vendor/vouguepay_ipn');
                    $this->vouguepay->add_field('fail_url', base_url() . 'vendor/vouguepay_cancel');
                    $this->vouguepay->add_field('success_url', base_url() . 'vendor/vouguepay_success');
                    
                    $this->vouguepay->submit_vouguepay_post();
                    // submit the fields to vouguepay
                } else if ($method == 'stripe') {
                    if($this->input->post('stripeToken')) {
                        
                        $stripe_api_key = $this->db->get_where('business_settings' , array('type' => 'stripe_secret'))->row()->value;
                        require_once(APPPATH . 'libraries/stripe-php/init.php');
                        \Stripe\Stripe::setApiKey($stripe_api_key); //system payment settings
                        $vendor_email = $this->db->get_where('vendor' , array('vendor_id' => $vendor))->row()->email;
                        
                        $vendora = \Stripe\Customer::create(array(
                            'email' => $vendor_email, // customer email id
                            'card'  => $_POST['stripeToken']
                        ));

                        $charge = \Stripe\Charge::create(array(
                            'customer'  => $vendora->id,
                            'amount'    => ceil($amount_in_usd*100),
                            'currency'  => 'USD'
                        ));

                        if($charge->paid == true){
                            $vendora = (array) $vendora;
                            $charge = (array) $charge;
                            
                            // $data['vendor']         = $vendor;
                            // $data['amount']         = $amount;
                            // $data['status']         = 'paid';
                            // $data['method']         = 'stripe';
                            // $data['timestamp']      = time();
                            // $data['membership']     = $type;
                            // $data['details']        = "Customer Info: \n".json_encode($vendora,true)."\n \n Charge Info: \n".json_encode($charge,true);

                            $data['user_id']            = $vendor;
                            $data['amount']             = $amount;
                            $data['payment_status']     = 'paid';
                            $data['payment_type']       = 'stripe';
                            $data['package_id']         = $package_id; 
                            $data['purchase_datetime']  = time();
                            $data['payment_timestamp']  = time();
                            $data['expire']             = 'yes';
                            $data['expire_timestamp']   = strtotime($expire_date);

                            $this->db->insert('package_payment', $data);
                            // $this->db->insert('membership_payment', $data);
                            $this->crud_model->upgrade_membership($vendor,$type);
                            redirect(base_url() . 'vendor/package/', 'refresh');
                        } else {
                            $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                            redirect(base_url() . 'vendor/package/', 'refresh');
                        }
                        
                    } else{
                        $this->session->set_flashdata('alert', 'unsuccessful_stripe');
                        redirect(base_url() . 'vendor/package/', 'refresh');
                    }
                } else if ($method == 'cash') {
                    // $data['vendor']         = $vendor;
                    // $data['amount']         = $amount;
                    // $data['status']         = 'due';
                    // $data['method']         = 'cash';
                    // $data['timestamp']      = time();
                    // $data['membership']     = $type;

                    $data['user_id']            = $vendor;
                    $data['amount']             = $amount;
                    $data['payment_status']     = 'due';
                    $data['payment_type']       = 'cash';
                    $data['package_id']         = $package_id; 
                    $data['purchase_datetime']  = time();
                    $data['payment_timestamp']  = time();
                    $data['expire']             = 'yes';
                    $data['expire_timestamp']   = strtotime($expire_date);
                    // $this->db->insert('membership_payment', $data);
                    $this->db->insert('package_payment', $data);
                    redirect(base_url() . 'vendor/package/', 'refresh');
                } else {
                    echo 'putu';
                }
            } else {
                redirect(base_url() . 'vendor/package/', 'refresh');
            }
        
            
        }
        else {
            $page_data['page_name'] = "premium_packages";
            $this->load->view('back/index', $page_data);
        }
    }



    function get_package_detail($para1='', $para2='')
    { 
        if ($para1 == "package_info") {
            $return = '<div class="table-responsive"><table class="table table-striped">';
            if($para2 >= '1'){
                $results = $this->db->get_where('package',array('package_id'=>$para2))->result_array();
                foreach ($results as $row) {
                    $return .= '<tr>';
                    $return .= '<td>'.translate('title').'</td>';
                    $return .= '<td>'.$row['name'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('price').'</td>';
                    $return .= '<td>'.currency($row['amount'],'def').'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('Validity').'</td>';
                    $return .= '<td>'.$row['validity'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('maximum_product').'</td>';
                    $return .= '<td>'.$row['upload_amount'].'</td>';
                    $return .= '</tr>';
                }
            }
            $return .= '</table></div>';
            echo $return;
        }
    }

    function vendor_pum_success()
    {
        $status         =   $_POST["status"];
        $firstname      =   $_POST["firstname"];
        $amount         =   $_POST["amount"];
        $txnid          =   $_POST["txnid"];
        $posted_hash    =   $_POST["hash"];
        $key            =   $_POST["key"];
        $productinfo    =   $_POST["productinfo"];
        $email          =   $_POST["email"];
        $udf1           =   $_POST['udf1'];
        $salt           =   $this->Crud_model->get_settings_value('business_settings', 'pum_merchant_salt', 'value');

        if (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'||||||||||'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        } else {
            $retHashSeq = $salt.'|'.$status.'||||||||||'.$udf1.'|'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        }
        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            $invoice_id = $this->session->userdata('invoice_id');
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->delete('membership_payment');
            $this->session->set_userdata('invoice_id', '');
            $this->session->set_flashdata('alert', 'payment_cancel');
            redirect(base_url() . 'vendor/package/', 'refresh');
        } else {

            $data['status']         = 'paid';
            $data['details']        = json_encode($_POST);
            $invoice_id             = $_POST['custom'];
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);
            
            $this->session->set_userdata('invoice_id', '');
            redirect(base_url() . 'vendor/package/', 'refresh');
        }
    }

    function vendor_pum_failure()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }

    function vendor_sslcommerz_success()
    {
        $invoice_id = $this->session->userdata('invoice_id');

        if ($invoice_id != '' || !empty($invoice_id)) {

            $data['status']         = 'paid';
            $data['details']        = json_encode($_POST);

            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);
            
            $this->session->set_userdata('invoice_id', '');
            redirect(base_url() . 'vendor/package/', 'refresh');
        } else {
            redirect(base_url() . 'vendor/package/', 'refresh');
        }
    }

    function vendor_sslcommerz_fail()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }

    function vendor_sslcommerz_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }
    
    /* FUNCTION: Verify paypal payment by IPN*/
    function paypal_ipn()
    {
        if ($this->paypal->validate_ipn() == true) {
            
            $data['status']         = 'paid';
            $data['details']        = json_encode($_POST);
            $invoice_id             = $_POST['custom'];
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);
        }
    }
    

    /* FUNCTION: Loads after cancelling paypal*/
    function paypal_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful paypal payment*/
    function paypal_success()
    {
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }
    
    function twocheckout_success()
    {

        /*$this->twocheckout_lib->set_acct_info('532001', 'tango', 'Y');*/
        $c2_user = $this->db->get_where('business_settings',array('type' => 'c2_user'))->row()->value; 
        $c2_secret = $this->db->get_where('business_settings',array('type' => 'c2_secret'))->row()->value;
        
        $this->twocheckout_lib->set_acct_info($c2_user, $c2_secret, 'Y');
        $data2['response'] = $this->twocheckout_lib->validate_response();
        //var_dump($this->twocheckout_lib->validate_response());
        $status = $data2['response']['status'];
        if ($status == 'pass') {
            $data1['status']             = 'paid';
            $data1['details']   = json_encode($this->twocheckout_lib->validate_response());
            $invoice_id         = $this->session->userdata('invoice_id');
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data1);
            $type = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->membership;
            $vendor = $this->db->get_where('membership_payment',array('membership_payment_id'=>$invoice_id))->row()->vendor;
            $this->crud_model->upgrade_membership($vendor,$type);
            redirect(base_url() . 'vendor/package/', 'refresh');

        } else {
            //var_dump($data2['response']);
            $invoice_id = $this->session->userdata('invoice_id');
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->delete('membership_payment');
            $this->session->set_userdata('invoice_id', '');
            $this->session->set_flashdata('alert', 'payment_cancel');
            redirect(base_url() . 'vendor/package', 'refresh');
        }
    }
 /* FUNCTION: Verify vouguepay payment by IPN*/
    function vouguepay_ipn()
    {
        $res = $this->vouguepay->validate_ipn();
        $invoice_id = $res['merchant_ref'];
        $merchant_id = 'demo';

        if ($res['total'] !== 0 && $res['status'] == 'Approved' && $res['merchant_id'] == $merchant_id) {
            $data['status']         = 'paid';
            $data['details']        = json_encode($res);
            $this->db->where('membership_payment_id', $invoice_id);
            $this->db->update('membership_payment', $data);
        }
    }
    
    /* FUNCTION: Loads after cancelling vouguepay*/
    function vouguepay_cancel()
    {
        $invoice_id = $this->session->userdata('invoice_id');
        $this->db->where('membership_payment_id', $invoice_id);
        $this->db->delete('membership_payment');
        $this->session->set_userdata('invoice_id', '');
        $this->session->set_flashdata('alert', 'payment_cancel');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }
    
    /* FUNCTION: Loads after successful vouguepay payment*/
    function vouguepay_success()
    {
        $this->session->set_userdata('invoice_id', '');
        redirect(base_url() . 'vendor/package/', 'refresh');
    }
    /* Manage Business Settings */
    function business_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('business_settings')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == "cash_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'cash_set' => $val
            ));
            recache();
        }
         else if ($para1 == "bank_set") {
            
            $data['bank_name'] = $this->input->post('bank_name');
            $data['account_name'] = $this->input->post('account_name');
            $data['bank_account_number'] = $this->input->post('bank_account_number');
            $data['bsb_number'] = $this->input->post('bsb_number');
           
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor',$data);

            recache();
        }
        else if ($para1 == "paypal_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'paypal_set' => $val
            ));
            recache();
        }
        else if ($para1 == "pum_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'pum_set' => $val
            ));
            recache();
        }
        else if ($para1 == "stripe_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'stripe_set' => $val
            ));
            recache();
        }
        else if ($para1 == "c2_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'c2_set' => $val
            ));
            recache();
        }
        else if ($para1 == "vp_set") {
            $val = '';
            if ($para2 == 'true') {
                $val = 'ok';
            } else if ($para2 == 'false') {
                $val = 'no';
            }
            echo $val;
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'vp_set' => $val
            ));
            recache();
        }
        else if ($para1 == "membership_price") {
            echo $this->db->get_where('membership',array('membership_id'=>$para2))->row()->price;
        }
        else if ($para1 == "membership_info") {
            $return = '<div class="table-responsive"><table class="table table-striped">';
            if($para2 !== '0'){
                $results = $this->db->get_where('membership',array('membership_id'=>$para2))->result_array();
                foreach ($results as $row) {
                    $return .= '<tr>';
                    $return .= '<td>'.translate('title').'</td>';
                    $return .= '<td>'.$row['title'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('price').'</td>';
                    $return .= '<td>'.currency($row['price'],'def').'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('timespan').'</td>';
                    $return .= '<td>'.$row['timespan'].'</td>';
                    $return .= '</tr>';

                    $return .= '<tr>';
                    $return .= '<td>'.translate('maximum_product').'</td>';
                    $return .= '<td>'.$row['product_limit'].'</td>';
                    $return .= '</tr>';
                }
            } else if($para2 == '0'){
                $return .= '<tr>';
                $return .= '<td>'.translate('title').'</td>';
                $return .= '<td>'.translate('default').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('price').'</td>';
                $return .= '<td>'.translate('free').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('timespan').'</td>';
                $return .= '<td>'.translate('lifetime').'</td>';
                $return .= '</tr>';

                $return .= '<tr>';
                $return .= '<td>'.translate('maximum_product').'</td>';
                $return .= '<td>'.$this->db->get_where('general_settings',array('type'=>'default_member_product_limit'))->row()->value.'</td>';
                $return .= '</tr>';
            }
            $return .= '</table></div>';
            echo $return;
        }
        else if ($para1 == 'set') {
            $publishable    = $this->input->post('stripe_publishable');
            $secret         = $this->input->post('stripe_secret');
            $stripe         = json_encode(array('publishable'=>$publishable,'secret'=>$secret));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'paypal_email' => $this->input->post('paypal_email')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'stripe_details' => $stripe
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'c2_user' => $this->input->post('c2_user'),
                'c2_secret' => $this->input->post('c2_secret'),
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'vp_merchant_id' => $this->input->post('vp_merchant_id')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'pum_merchant_key' => $this->input->post('pum_merchant_key')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'pum_merchant_salt' => $this->input->post('pum_merchant_salt')
            ));
            recache();
        } else {
            $page_data['page_name'] = "business_settings";
            $this->load->view('back/index', $page_data);
        }
    }
    

    /* Manage vendor Settings */
    function manage_vendor($para1 = "",$para2 = "")
    {
        if ($this->session->userdata('vendor_login') != 'yes') {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == 'update_password') {
            $user_data['password'] = $this->input->post('password');
            $account_data          = $this->db->get_where('vendor', array(
                'vendor_id' => $this->session->userdata('vendor_id')
            ))->result_array();
            foreach ($account_data as $row) {
                if (sha1($user_data['password']) == $row['password']) {
                    if ($this->input->post('password1') == $this->input->post('password2')) {
                        $data['password'] = sha1($this->input->post('password1'));
                        $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
                        $this->db->update('vendor', $data);
                        echo 'updated';
                    }
                } else {
                    echo 'pass_prb';
                }
            }
        } else if ($para1 == 'update_profile') {
            
                $images_arr = array();  
                $extension = array("jpeg","jpg","png","gif");
                $file_name = $_FILES["images"]["name"];
                $file_tmp = $_FILES["images"]["tmp_name"];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                if(in_array($ext,$extension)) 
                {
                    $filename = basename($file_name,$ext);
                    $newFileName = $filename.time().".".$ext;
                    $images_arr[] =  $newFileName; 
                    move_uploaded_file($file_tmp,"uploads/events_image/".$newFileName);
                }   
                $data["company_image"] = (count($images_arr)>0) ? implode(",",$images_arr) : $this->input->post('last_images');  

                // $data['name'] = $this->input->post('name');
                $data['first_name'] = $this->input->post('first_name');
                $data['last_name'] = $this->input->post('last_name');
                $data['email'] = $this->input->post('email');
                $data['phone_code'] = $this->input->post('phone_code');
                $data['direct_code'] = $this->input->post('direct_code');
                $data['address1'] = $this->input->post('address1');
                // $data['address2'] = $this->input->post('address2');
                $data['company'] = $this->input->post('company');
                $data['city'] = $this->input->post('city');
                $data['state'] = $this->input->post('state');
                // ['country'] = $this->input->post('country');
                $data['zip'] = $this->input->post('zip');
                $data['website'] = $this->input->post('website');

                $data['bank_name'] = $this->input->post('bank_name');
                $data['account_name'] = $this->input->post('account_name');
                $data['bank_account_number'] = $this->input->post('bank_account_number');
                $data['bsb_number'] = $this->input->post('bsb_number');
                $data['acn_and_abn'] = $this->input->post('acn_and_abn');
                $data['trading_name'] = $this->input->post('trading_name');
                $data['license_number'] = $this->input->post('license_number');

                $data['contact_person'] = $this->input->post('contact_person');
                $data['direct_number'] = $this->input->post('direct_number');
                $data['mobile_number'] = $this->input->post('mobile_number');
                $data['direct_email'] = $this->input->post('direct_email');

                //$data['brands'] = $this->input->post('brands');
                //$data['category'] = $this->input->post('category');
                $data['minimum_tick'] = $this->input->post('minimum_tick');
                $data['free_delivery'] = $this->input->post('free_delivery');
                $data['delivery_fee'] = $this->input->post('delivery_fee');
                $data['c_d_english'] = $this->input->post('c_d_english');
                $data['c_d_chinese'] = $this->input->post('c_d_chinese');
                $data['c_d_japanese'] = $this->input->post('c_d_japanese');
                
                $data['details'] = $this->input->post('details');
                $data['phone'] = $this->input->post('phone');
                $data['lat_lang'] = $this->input->post('lat_lang');

                $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
                $this->db->update('vendor',$data);                               
        }
        elseif($para1 == 'add_brand') 
        {
            $brand_arr = explode(",",$this->input->post('brands'));
            $cat_arr = json_decode($this->input->post('category'));     
            $data1['user_id'] =  $this->session->userdata('vendor_id');

            $extension = array("jpeg","jpg","png","gif");


            foreach($brand_arr as $key => $br) 
            {
                $val= $key+1;
                $data1['name'] = $br;
                $data1['category'] = implode(",",$cat_arr[$key]->selected);

                $file_name = preg_replace('/\s+/','',$_FILES["brand_images$val"]["name"]);

                
                $file_tmp = $_FILES["brand_images$val"]["tmp_name"];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                if(in_array($ext,$extension)) 
                {
                    $filename = basename($file_name,$ext);
                    $newFileName = $filename.time().".".$ext;
                    move_uploaded_file($file_tmp,"uploads/brand_image/".$newFileName);
                }
                $data1['image'] = $newFileName;
                $this->db->insert('vendorbrands',$data1);
            }
        }
        elseif($para1 == 'update_brand') 
        {     
            $images_arr = array();  
            $extension = array("jpeg","jpg","png","gif");

            $file_name = $_FILES["brand_image"]["name"];
            $file_tmp = $_FILES["brand_image"]["tmp_name"];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);

            if(in_array($ext,$extension)) 
            {
                $filename = basename($file_name,$ext);
                $newFileName = $filename.time().".".$ext; 
                move_uploaded_file($file_tmp,"uploads/brand_image/".$newFileName);
            } 
            
            if($newFileName)
            {
                $change_image = $newFileName;
            }
            else
            {
                $change_image = $this->input->post('last_brand_image');
            }

            $this->db->where('id',$this->input->post('brand_id'));
            $this->db->where('user_id',$this->session->userdata('vendor_id'));
            $this->db->update('vendorbrands', array('name'=>$this->input->post('name'),'category'=>$this->input->post('category'),'image'=>$change_image));
            echo 'success';      
        } 
        elseif($para1 == 'dlt_brands')
        {
            $this->db->where('id', $para2);
            $this->db->delete('vendorbrands');
        }
        else {
            $page_data['page_name'] = "manage_vendor";
            $this->load->view('back/index', $page_data);
        }
    }

    public function add_brand(){
        
    }


       public function uploadProfileImage($name,$dirPath,$fileName) {
        // echo $fileName;die;
        $data = array();
        $response=array();
        if (isset($_FILES[$fileName]["name"]) && $_FILES[$fileName]["name"]!="") {
            $cdate= date("dmyHis");
            $imageName = str_replace(" ","-",$name).'-'.$cdate;
            $this->load->library('upload');
            $this->upload->initialize($this->set_upload_options($dirPath,'jpg|JPEG|PNG|png|jpeg',$imageName));
            
            $cscx=$this->upload->do_upload($fileName);
            // echo "<pre>"; print_r($cscx);die;
            if($this->upload->display_errors()){
                // $this->messages->setMessageFront($this->upload->display_errors(),'error');  
                return array("status" => 'error');
            }else{
                $data=$this->upload->data();
    //          if(($data['image_width']<'100') || ($data['image_height']<'40')) {
                //      $this->messages->setMessageFront('The image you are attempting to upload should be greater than 100*40','error');   
                //      return array("status" => 'error');
                // } else {
                    $file_path=$dirPath.$data['file_name'];
                    
                    //$file_path=$restMenuFolderName.$data['file_name'];
                    $this->load->library('image_lib');
                    // clear config array
                    $config = array();
                    $config['image_library']    = 'gd2';
                    $config['source_image']     = $file_path;
                    $config['maintain_ratio']   = TRUE;
                    $config['create_thumb']     = FALSE;
                    $response = array(
                        "status" => 'success',
                        "imageName" => $data['file_name'],
                        "width" => $data['image_width'],
                        "height" => $data['image_height']
                    );
                // }
            }
        }
        return $response;
    }

    //single image upload
        function set_upload_options($dirPath,$allowedTypes,$fileName="") {   
           //  upload an image and document options
            $config = array();
            $config['upload_path'] = $dirPath;
            $config['allowed_types'] = $allowedTypes;
            $config['overwrite'] = FALSE;
            
            if($fileName!=""){
                 $config['file_name'] = $fileName;
            }
            
            return $config;
        }




    /* Manage General Settings */
    function general_settings($para1 = "", $para2 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }

    }
    
    /* Manage Social Links */
    function social_links($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == "set") {

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'facebook' => $this->input->post('facebook')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'google_plus' => $this->input->post('google-plus')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'twitter' => $this->input->post('twitter')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'skype' => $this->input->post('skype')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'pinterest' => $this->input->post('pinterest')
            ));

            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'youtube' => $this->input->post('youtube')
            ));
            recache();
            redirect(base_url() . 'vendor/site_settings/social_links/', 'refresh');
        
        }
    }

    /* Manage SEO relateds */
    function seo_settings($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        if ($para1 == "set") {
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'description' => $this->input->post('description')
            ));
            $this->db->where('vendor_id', $this->session->userdata('vendor_id'));
            $this->db->update('vendor', array(
                'keywords' => $this->input->post('keywords')
            ));
            recache();
        }
    }
    /* Manage Favicons */
    function vendor_images($para1 = "")
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        move_uploaded_file($_FILES["logo"]['tmp_name'], 'uploads/vendor_logo_image/logo_' . $this->session->userdata('vendor_id') . '.png');
        move_uploaded_file($_FILES["banner"]['tmp_name'], 'uploads/vendor_banner_image/banner_' . $this->session->userdata('vendor_id') . '.jpg');
        recache();
    }
     /* Product Bundle add, edit, view, delete, stock increase, decrease, discount */
    function product_bundle($para1 = '', $para2 = '', $para3 = '', $para4 = '')
    {
        if (!$this->crud_model->vendor_permission('site_settings')) {
            redirect(base_url() . 'vendor');
        }
        if ($this->crud_model->get_type_name_by_id('general_settings','68','value') !== 'ok') {
            redirect(base_url() . 'admin');
        }
        if ($para1 == 'do_add') {
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $products = array();
            $data['num_of_imgs']        = $num_of_imgs;
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['test_section']       = $this->input->post('test_section');
            $data['test_title']         = $this->input->post('test_title');
            $data['test_sumary_title']  = $this->input->post('test_sumary_title');
            $data['test_sumary']        = $this->input->post('test_sumary');
            $data['test1_name']         = $this->input->post('test1_name');
            $data['test1_number']       = $this->input->post('test1_number');
            $data['test2_name']         = $this->input->post('test2_name');
            $data['test2_number']       = $this->input->post('test2_number');
            $data['test3_name']         = $this->input->post('test3_name');
            $data['test3_number']       = $this->input->post('test3_number');
            $data['test11_name']        = $this->input->post('test11_name');
            $data['test11_number']      = $this->input->post('test11_number');
            $data['test22_name']        = $this->input->post('test22_name');
            $data['test22_number']      = $this->input->post('test22_number');
            $data['test33_name']        = $this->input->post('test33_name');   
            $data['test33_number']      = $this->input->post('test33_number');   
            $data['add_timestamp']      = time();
            $data['featured']           = 'no';
            $data['status']             = 'ok';
            $data['rating_user']        = '[]';
            // $data['tax']                = $this->input->post('tax');
            $data['discount']           = ($this->input->post('discount')) ? $this->input->post('discount') : 0 ;
            $data['discount_type']      = $this->input->post('discount_type');
            // $data['tax_type']           = $this->input->post('tax_type');
            // $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['is_bundle']          = 'yes';
            $data['tag']                = $this->input->post('tag');
            $data['current_stock']      = '1';
            $data['unit']               = $this->input->post('unit');
            $product_no                 = $this->input->post('product_no');
            $product_id                 = $this->input->post('product');
            $product_quantity           = $this->input->post('quantity');
            $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            if(count($product_id) > 0){
                foreach ($product_id as $i => $row) {
                    $products[]              =   array(
                                                    'product_no' => $product_no[$i],
                                                    'product_id' => $product_id[$i],
                                                    'quantity' => $product_quantity[$i],
                                                );
                }
            }
            $data['products']            = json_encode($products);
            $data['food_section']   = $this->input->post('food_section');
            $data['food_title']         = $this->input->post('food_title');
            $data['food_description']   = $this->input->post('food_description');
            $data['food_name1']   = $this->input->post('food_name1');
            $data['food_name2']   = $this->input->post('food_name2');
            $data['food_name3']   = $this->input->post('food_name3');
            $data['food_name4']   = $this->input->post('food_name4');


            $extension = array("jpeg","jpg","png","gif");
            for ($food_img=1; $food_img <=4 ; $food_img++) 
            {
                if($_FILES["food_image$food_img"]["name"])
                { 
                    $file_name = $_FILES["food_image$food_img"]["name"];
                    $file_tmp = $_FILES["food_image$food_img"]["tmp_name"];
                    $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                    if(in_array($ext,$extension)) 
                    {
                        $filename = basename($file_name,$ext);
                        $newFileName = $filename.time().".".$ext;
                        $data["food_image$food_img"]  = $newFileName;
                        move_uploaded_file($file_tmp,"uploads/product_image/".$newFileName);
                    }
                }    
            }
            $this->db->insert('product', $data);
            
            
            $id = $this->db->insert_id();
            $this->benchmark->mark_time();
            $this->crud_model->file_up("images", "product", $id, 'multi');
            /*if($id)
            {
                $ib = 1; $count_img = 1;
                foreach ($_FILES["images"]['name'] as $p => $row) 
                {
                    $filename   = $_FILES["images"]['name'][$p];
                    $extension  = pathinfo($filename, PATHINFO_EXTENSION);
                    $ext = '.'.$extension;
                    //$ib =  $this->crud_model->file_exist_ret('product', $id, $ib, $ext);
                    
                    move_uploaded_file($_FILES["images"]['tmp_name'][$p], 'uploads/' . 'product' . '_image/' . 'product' . '_' . $id .'_'.$count_img. $ext);
                    move_uploaded_file($_FILES["images"]['tmp_name'][$p], 'uploads/' . 'product' . '_image/' . 'product' . '_' . $id .'_'.$count_img. $ext);
                    
                    if($no_thumb == '') 
                    {
                        $this->crud_model->img_thumb('product', $id . '_' . $ib, $ext);
                    }
                    $count_img++;
                }
            }*/    
            recache();
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/product_bundle_add');
        } else if ($para1 == 'edit') {
            $page_data['product_bundle_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_bundle_edit', $page_data);
        } elseif($para1 == 'update') {
            if ($_FILES["images"]['name'][0] == '') {
                $num_of_imgs = 0;
            } else {
                $num_of_imgs = count($_FILES["images"]['name']);
            }
            $num                        = $this->crud_model->get_type_name_by_id('product', $para2, 'num_of_imgs');
            $products = array();
            $data['num_of_imgs']        = $num + $num_of_imgs;
            $data['title']              = $this->input->post('title');
            $data['description']        = $this->input->post('description');
            $data['sale_price']         = $this->input->post('sale_price');
            $data['purchase_price']     = $this->input->post('purchase_price');
            $data['test_section']       = $this->input->post('test_section');
            $data['test_title']         = $this->input->post('test_title');
            $data['test_sumary_title']  = $this->input->post('test_sumary_title');
            $data['test_sumary']        = $this->input->post('test_sumary');
            $data['test1_name']         = $this->input->post('test1_name');
            $data['test1_number']       = $this->input->post('test1_number');
            $data['test2_name']         = $this->input->post('test2_name');
            $data['test2_number']       = $this->input->post('test2_number');
            $data['test3_name']         = $this->input->post('test3_name');
            $data['test3_number']       = $this->input->post('test3_number');
            $data['test11_name']        = $this->input->post('test11_name');
            $data['test11_number']      = $this->input->post('test11_number');
            $data['test22_name']        = $this->input->post('test22_name');
            $data['test22_number']      = $this->input->post('test22_number');
            $data['test33_name']        = $this->input->post('test33_name');   
            $data['test33_number']      = $this->input->post('test33_number');   
            $data['update_time']        = time();
            // $data['tax']             = $this->input->post('tax');
            $data['discount']           = $this->input->post('discount');
            $data['discount_type']      = $this->input->post('discount_type');
            // $data['tax_type']           = $this->input->post('tax_type');
            // $data['shipping_cost']      = $this->input->post('shipping_cost');
            $data['tag']                = $this->input->post('tag');
            $data['unit']               = $this->input->post('unit');
            $product_no                 = $this->input->post('product_no');
            $product_id                 = $this->input->post('product');
            $product_quantity           = $this->input->post('quantity');
            $data['added_by']           = json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')));
            if(count($product_id) > 0){
                foreach ($product_id as $i => $row) {
                    $products[]              =   array(
                                                    'product_no' => $product_no[$i],
                                                    'product_id' => $product_id[$i],
                                                    'quantity' => $product_quantity[$i],
                                                );
                }
            }
            $data['products']           = json_encode($products);
            $data['food_section']       = $this->input->post('food_section');
            $data['food_title']         = $this->input->post('food_title');
            $data['food_description']   = $this->input->post('food_description');
            $data['food_name1']         = $this->input->post('food_name1');
            $data['food_name2']         = $this->input->post('food_name2');
            $data['food_name3']         = $this->input->post('food_name3');
            $data['food_name4']         = $this->input->post('food_name4');
            
            
            $extension = array("jpeg","jpg","png","gif");
            for ($food_img=1; $food_img <=4 ; $food_img++) 
            {
                if($_FILES["food_image$food_img"]["name"])
                { 
                    $file_name = $_FILES["food_image$food_img"]["name"];
                    $file_tmp = $_FILES["food_image$food_img"]["tmp_name"];
                    $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                    if(in_array($ext,$extension)) 
                    {
                        $filename = basename($file_name,$ext);
                        $newFileName = $filename.time().".".$ext;
                        $data["food_image$food_img"]  = $newFileName;
                        move_uploaded_file($file_tmp,"uploads/product_image/".$newFileName);
                    }
                    else
                    {
                        $data["food_image$food_img"]  = $this->input->post('last_food_image'.$food_img);
                    }
                }    
            }
            $this->crud_model->file_up("images", "product", $para2, 'multi');
            
            $this->db->where('product_id', $para2);
            $this->db->update('product', $data);
            recache();
        } 
        elseif ($para1 == 'delete_food') 
        {
            $productid = $this->input->post('productid');
            $imageid = $this->input->post('imageid');
            $remove_food_image = $this->db->get_where('product',array('product_id'=>$productid))->row();
            $var = "food_image".$imageid;
            unlink("uploads/product_image/".$remove_food_image->$var);
            $data_food_image["food_image$imageid"] = '';
            $this->db->where('product_id',$productid)->update('product', $data_food_image);
            
        }
        elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('product', $para2, '.jpg', 'multi');
            $this->db->where('product_id', $para2);
            $this->db->delete('product');
            recache();
        } else if ($para1 == 'view') {
            $page_data['product_bundle_data'] = $this->db->get_where('product', array(
                'product_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/product_bundle_view', $page_data);
        } else if ($para1 == 'do_destroy') {
            
        } elseif ($para1 == 'list') {
            $this->db->order_by('product_id', 'desc');
            $page_data['all_product_bundle'] = $this->db->get_where('product', array('is_bundle' => 'yes','added_by'=>json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')))))->result_array();
            $this->load->view('back/vendor/product_bundle_list', $page_data);
        } elseif ($para1 == 'list_data') {
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $this->db->where('is_bundle', 'yes');
            $this->db->where('added_by', json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id'))));
            $total= $this->db->get('product')->num_rows();
            $this->db->limit($limit);
            if($sort == ''){
                $sort = 'product_id';
                $order = 'DESC';
            }
            $this->db->order_by($sort,$order);
            if($search){
                $this->db->like('title', $search, 'both');
            }
            $product_bundles   = $this->db->get_where('product', array('is_bundle' => 'yes','added_by'=>json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')))), $limit, $offset)->result_array();
            $data       = array();
            foreach ($product_bundles as $row) {

                $res    = array(
                             'image' => '',
                             'title' => '',
                             'publish' => '',
                             'featured' => '',
                             'options' => ''
                          );

                $res['image']  = '<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="'.$this->crud_model->file_view('product',$row['product_id'],'','','thumb','src','multi','one').'"  />';
                $res['title']  = $row['title'];

                if($row['status'] == 'ok'){
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['publish']  = '<input id="pub_'.$row['product_id'].'" class="sw1" type="checkbox" data-id="'.$row['product_id'].'" />';
                }
                if($row['current_stock'] > 0){ 
                    $res['current_stock']  = $row['current_stock'].$row['unit'].'(s)';                     
                } else {
                    $res['current_stock']  = '<span class="label label-danger">'.translate('out_of_stock').'</span>';
                }
                if($row['featured'] == 'ok'){
                    $res['featured'] = '<input id="fet_'.$row['product_id'].'" class="sw2" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['featured'] = '<input id="fet_'.$row['product_id'].'" class="sw2" type="checkbox" data-id="'.$row['product_id'].'" />';
                }
                if($row['deal'] == 'ok'){
                    $res['deal'] = '<input id="del_'.$row['product_id'].'" class="sw3" type="checkbox" data-id="'.$row['product_id'].'" checked />';
                } else {
                    $res['deal'] = '<input id="del_'.$row['product_id'].'" class="sw3" type="checkbox" data-id="'.$row['product_id'].'" />';
                }
                //add html for action
                $res['options'] = "  <a class=\"btn btn-info btn-xs btn-labeled fa fa-location-arrow\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('view','".translate('view_product_bundle')."','".translate('successfully_viewed!')."','product_bundle_view','".$row['product_id']."');proceed('to_list');\" data-original-title=\"View\" data-container=\"body\">
                                    ".translate('view')."
                            </a>
                            <a class=\"btn btn-purple btn-xs btn-labeled fa fa-tag\" data-toggle=\"tooltip\"
                                onclick=\"ajax_modal('add_discount','".translate('view_discount')."','".translate('viewing_discount!')."','add_bundle_discount','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('discount')."
                            </a>
                            <a class=\"btn btn-mint btn-xs btn-labeled fa fa-plus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('add_stock','".translate('add_bundle_quantity')."','".translate('quantity_added!')."','bundle_stock_add','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('stock')."
                            </a>
                            <a class=\"btn btn-dark btn-xs btn-labeled fa fa-minus-square\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('destroy_stock','".translate('reduce_bundle_quantity')."','".translate('quantity_reduced!')."','destroy_bundle_stock','".$row['product_id']."')\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('destroy')."
                            </a>
                            
                            <a class=\"btn btn-success btn-xs btn-labeled fa fa-wrench\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('edit','".translate('edit_product_bundle')."','".translate('successfully_edited!')."','product_bundle_edit','".$row['product_id']."');proceed('to_list');\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('edit')."
                            </a>
                            
                            <a onclick=\"delete_confirm('".$row['product_id']."','".translate('really_want_to_delete_this?')."')\" 
                                class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                    ".translate('delete')."
                            </a>";
                $data[] = $res;
            }
            $result = array(
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } elseif ($para1 == 'add_discount') {
            $data['product_bundle'] = $para2;
            $this->load->view('back/vendor/product_bundle_add_discount', $data);
        } elseif ($para1 == 'add_discount_set') {
            $product_bundle               = $this->input->post('product_bundle');
            $data['discount']      = $this->input->post('discount');
            $data['discount_type'] = $this->input->post('discount_type');
            $this->db->where('product_id', $product_bundle);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'add_stock') {
            $data['product_bundle'] = $para2;
            $this->load->view('back/vendor/product_bundle_stock_add', $data);
        } elseif ($para1 == 'destroy_stock') {
            $data['product_bundle'] = $para2;
            $this->load->view('back/vendor/product_bundle_stock_destroy', $data);
        } elseif ($para1 == 'bundle_publish_set') {
            $product_bundle = $para2;
            if ($para3 == 'true') {
                $data['status'] = 'ok';
            } else {
                $data['status'] = '0';
            }
            $this->db->where('product_id', $product_bundle);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'bundle_featured_set') {
            $product_bundle = $para2;
            if ($para3 == 'true') {
                $data['featured'] = 'ok';
            } else {
                $data['featured'] = '0';
            }
            $this->db->where('product_id', $product_bundle);
            $this->db->update('product', $data);
            recache();
        } elseif ($para1 == 'bundle_deal_set') {
            $product_bundle = $para2;
            if ($para3 == 'true') {
                $data['deal'] = 'ok';
            } else {
                $data['deal'] = '0';
            }
            $this->db->where('product_id', $product_bundle);
            $this->db->update('product', $data);
            recache();
        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('product', $a[0], '.jpg', 'multi', $a[1]);
            recache();
        } elseif ($para1 == 'sub_by_cat') {
            echo $this->crud_model->select_html('sub_category', 'sub_category[]', 'sub_category_name', 'add', 'demo-chosen-select required', '', 'category', $para2, 'get_brnd');
        } elseif ($para1 == 'brand_by_sub') {
            $brands=json_decode($this->crud_model->get_type_name_by_id('sub_category',$para2,'brand'),true);
            /*if(empty($brands)){
                echo translate("<p class='control-label'>No brands are available for this sub category</p>");
            } else {*/
                echo $this->crud_model->select_html('brand', 'brand[]', 'name', 'add', 'demo-chosen-select required', '', 'brand_id', $brands, 'get_prod', 'multi', 'none');
            // }
        } elseif ($para1 == 'prod_by_brand') {
            if ($para2 == 'none') {
                $prod_ids = array();
                $products = $this->db->get_where('product', array('sub_category' => $para3, 'category' => $para4))->result_array();
                foreach ($products as $product) {
                    $prod_ids[] = $product['product_id'];
                }
                if(empty($prod_ids)){
                    echo translate("<p class='control-label'>No Products are available for this brand</p>");
                } else {
                    echo $this->crud_model->select_html('product', 'product[]', 'title', 'add', 'demo-chosen-select required', '', 'product_id', $prod_ids, '', 'multi');
                }
            } else {
                $prod_ids = array();
                $products = $this->db->get_where('product', array('brand' => $para2, 'sub_category' => $para3, 'category' => $para4))->result_array();
                foreach ($products as $product) {
                    $prod_ids[] = $product['product_id'];
                }
                if(empty($prod_ids)){
                    echo translate("<p class='control-label'>No Products are available for this brand</p>");
                } else {
                    echo $this->crud_model->select_html('product', 'product[]', 'title', 'add', 'demo-chosen-select required', '', 'product_id', $prod_ids, '', 'multi');
                }
            }
        } else {
            $page_data['page_name'] = "product_bundle";
            
            $this->load->view('back/index', $page_data);
        }
    }

    /* Product Bundle Stock add, edit, view, delete, stock increase, decrease, discount */
    function bundle_stock($para1 = '', $para2 = '')
    {
        if (!$this->crud_model->vendor_permission('bundle_stock')) {
            redirect(base_url() . 'vendor');
        }
        if ($this->crud_model->get_type_name_by_id('general_settings','68','value') !== 'ok') {
            redirect(base_url() . 'admin');
        }
        if ($para1 == 'do_add') {
            $data['type']         = 'add';
            $data['product_bundle']      = $this->input->post('product_bundle');
            $data['quantity']     = $this->input->post('quantity');
            $data['rate']         = $this->input->post('rate');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('bundle_stock', $data);
            $prev_quantity          = $this->crud_model->get_type_name_by_id('product', $data['product_bundle'], 'current_stock');
            $data1['current_stock'] = $prev_quantity + $data['quantity'];
            $this->db->where('product_id', $data['product_bundle']);
            $this->db->update('product', $data1);
            recache();
        } else if ($para1 == 'do_destroy') {
            $data['type']         = 'destroy';
            $data['product_bundle']      = $this->input->post('product_bundle');
            $data['quantity']     = $this->input->post('quantity');
            $data['total']        = $this->input->post('total');
            $data['reason_note']  = $this->input->post('reason_note');
            $data['datetime']     = time();
            $this->db->insert('bundle_stock', $data);
            $prev_quantity = $this->crud_model->get_type_name_by_id('product', $data['product_bundle'], 'current_stock');
            $current       = $prev_quantity - $data['quantity'];
            if ($current <= 0) {
                $current = 0;
            }
            $data1['current_stock'] = $current;
            $this->db->where('product_id', $data['product_bundle']);
            $this->db->update('product', $data1);
            recache();
        } else {
            $page_data['page_name'] = "bundle_stock";
            
            $this->load->view('back/index', $page_data);
        }
    } 

    function events($para1 = '', $para2 = '', $para3 = '')
    {
        if ($para1 == 'do_add') 
        {
            $images_arr = array();  
            $extension = array("jpeg","jpg","png","gif");
            for($img=0; $img <=count($_FILES["images"]['name']); $img++) 
            { 
                $file_name = $_FILES["images"]["name"][$img];
                $file_tmp = $_FILES["images"]["tmp_name"][$img];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                if(in_array($ext,$extension)) 
                {
                    $filename = basename($file_name,$ext);
                    $newFileName = $filename.time().".".$ext;
  
                    $images_arr[] =  $newFileName; 
                    move_uploaded_file($file_tmp,"uploads/events_image/".$newFileName);
                } 
            }
            $data["image"] = implode(",",$images_arr); 

            $banner_images_arr = array();  
            $extension = array("jpeg","jpg","png","gif");
            for($img=0; $img <=count($_FILES["images"]['name']); $img++) 
            { 
                $file_name = $_FILES["banner_images"]["name"][$img];
                $file_tmp = $_FILES["banner_images"]["tmp_name"][$img];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                if(in_array($ext,$extension)) 
                {
                    $filename = basename($file_name,$ext);
                    $newFileName = $filename.time().".".$ext;
                    $banner_images_arr[] =  $newFileName; 
                    move_uploaded_file($file_tmp,"uploads/events_image/".$newFileName);
                }   
            }
            $data["banner_image"] = implode(",", $banner_images_arr); 

            $product_arr =  $this->input->post('choose_product');
            $data["choose_product"]  = implode(",",$product_arr); 
            $v_id = $this->session->userdata('vendor_id');
            $vendor_name = $this->db->get_where('vendor',array('vendor_id'=>$v_id))->row_array(); 
            $data['vendor']           = $vendor_name['name'];
            $data['vendor_id']        = $v_id;
            $data['presenter_name']   = $this->input->post('presenter_name');
            $data['presenter_title']  = $this->input->post('presenter_title');
            $data['presenter_bio']    = $this->input->post('presenter_bio');
            $data['date']             = $this->input->post('date');
            $data['time_slot']         = $this->input->post('time_slot');
            $data['promocode_id']         = $this->input->post('promocode_id');
            $data['promocode_products']         = implode(",",$this->input->post('promocode_products'));
            
            $this->db->insert('events', $data);
            $email_send = $this->db->get_where('vendor',array('vendor_id'=>$v_id))->row()->email;
            $msg = 'done';


            if($this->email_model->create_event('vendor', 'vendor@omgee.com.au') == true)
            {
                if($this->email_model->vendor_event_email_to_admin('vendor', $email_send) == false){
                    $msg = 'done_but_not_sent';
                }else{
                    $msg = 'done_and_sent';
                }
            }else{
                $msg = 'msg_not_sent';
            }
           
            echo $this->db->last_query();
           
        } else if ($para1 == "update") {
            $images_arr = array();  
            $extension = array("jpeg","jpg","png","gif");
            for($img=0; $img <=count($_FILES["images"]['name']); $img++) 
            { 
                $file_name = $_FILES["images"]["name"][$img];
                $file_tmp = $_FILES["images"]["tmp_name"][$img];
                $ext=pathinfo($file_name,PATHINFO_EXTENSION);

                if(in_array($ext,$extension)) 
                {
                    $filename = basename($file_name,$ext);
                    $newFileName = $filename.time().".".$ext;
                    $images_arr[] =  $newFileName; 
                    move_uploaded_file($file_tmp,"uploads/events_image/".$newFileName);
                }   
            }
            $data["image"] = (count($images_arr)>0) ? implode(",", $images_arr) : $this->input->post('last_images');    
            
            $banner_images_arr = array();  
            $extension = array("jpeg","jpg","png","gif");
            for($img1=0; $img1 <=count($_FILES["images"]['name']); $img1++) 
            { 
                $file_name1 = $_FILES["banner_images"]["name"][$img1];
                $file_tmp = $_FILES["banner_images"]["tmp_name"][$img1];
                $ext=pathinfo($file_name1,PATHINFO_EXTENSION);

                if(in_array($ext,$extension)) 
                {
                    $filename = basename($file_name1,$ext);
                    $newFileName1 = $filename.time().".".$ext;
                    $banner_images_arr[] =  $newFileName1; 
                    move_uploaded_file($file_tmp,"uploads/events_image/".$newFileName1);
                }   
            }
           $data["banner_image"] = (count($banner_images_arr)>0) ? implode(",", $banner_images_arr) : $this->input->post('banner_last_images');    
            $product_arr =  $this->input->post('choose_product');
            $data["choose_product"]  = implode(",",$product_arr);   
            $data['presenter_name']  = $this->input->post('presenter_name');
            $data['presenter_title']  = $this->input->post('presenter_title');
            $data['presenter_bio']   = $this->input->post('presenter_bio');
            $data['date']            = $this->input->post('date'); 
            $data['time_slot']         = $this->input->post('time_slot');
            $data['promocode_id']    = $this->input->post('promocode_id');
            $data['promocode_products'] = implode(",",$this->input->post('promocode_products'));
            
            $this->db->where('events_id', $para2);
            $this->db->update('events', $data);

            $this->crud_model->set_category_data(0);
            recache();
        } 

        elseif ($para1 == 'view') {
            $page_data['vendor_events_data'] = $this->db->get_where('events', array('events_id' => $para2))->row();
            $this->load->view('back/vendor/vendor_events_view', $page_data); 
        }
        elseif ($para1 == 'choose_products') 
        {
            $product_ids = $this->input->post('depart');
            if($product_ids > 0)
            {
                $products_arr = array();

                foreach ($product_ids as $key => $value) 
                {
                    $products = $this->db->get_where('product',array('product_id'=>$value,'added_by'=>json_encode(array('type'=>'vendor','id'=>$this->session->userdata('vendor_id')))))->row();
                     $products_arr[] = array("id" => $products->product_id, "name" => $products->title);
                }
                echo json_encode($products_arr);
            }    
        }
        elseif ($para1 == 'promocode_details') 
        {
            $promocodeid = $this->input->post('promocodeid');
            $promocodes = $this->db->get_where('promocode',array('promocode_id'=>$promocodeid))->row();
            echo json_encode($promocodes);
        }
        else if ($para1 == 'edit') {
            $page_data['events_data'] = $this->db->get_where('events', array(
                'events_id' => $para2
            ))->result_array();
            $this->load->view('back/vendor/events_edit', $page_data);
        } elseif ($para1 == 'delete') {
            $this->crud_model->file_dlt('events', $para2, '.jpg', 'multi');
            $this->db->where('events_id', $para2);
            $this->db->delete('events');
            $this->crud_model->set_category_data(0);
            recache();
        } elseif ($para1 == 'list') {
            $this->db->order_by('events_id', 'desc');
            $page_data['all_events'] = $this->db->get('events')->result_array();
            $this->load->view('back/vendor/events_list', $page_data);
        } elseif ($para1 == 'list_data') {
            $limit      = $this->input->get('limit');
            $search     = $this->input->get('search');
            $order      = $this->input->get('order');
            $offset     = $this->input->get('offset');
            $sort       = $this->input->get('sort');
            if($search){
                $this->db->like('presenter_name', $search, 'both');
            }
           
            $total      = $this->db->get_where('events',array('vendor_id'=>$this->session->userdata('vendor_id')))->num_rows();
            $this->db->limit($limit);
            if($sort == ''){
                $sort = 'events_id';
                $order = 'DESC';
            }
            $this->db->order_by($sort,$order);
            if($search){
                $this->db->like('presenter_name', $search, 'both');
            }
            $products   = $this->db->get_where('events',array('vendor_id'=>$this->session->userdata('vendor_id')))->result_array();
            $data       = array();
            foreach ($products as $row) {

                $res    = array(
                             'image' => '',
                             'presenter_name' => '',
                             'presenter_title' => '',
                             'submitted' => '',
                             'event_date' => '',
                             'event_time' => '',
                             'duration' => '',
                             'highlights_product' => '',
                             'promo' => '',
                             'status' => '',
                             'options' => ''
                          );

                $res['image']  = '<img class="img-sm" style="height:auto !important; border:1px solid #ddd;padding:2px; border-radius:2px !important;" src="'.base_url('/uploads/events_image/'.$row['image']).'"  />';  

                $res['presenter_name']  = ucwords($row['presenter_name']);
                
                $res['presenter_title']  = ucwords($row['presenter_title']);

                $res['submitted']            = date('d/m/yy ',strtotime($row['timestamp']));

                $res['date']            = date('d/m/yy ',strtotime($row['date']));
               
                

                // Duration Start
                    $current_slot = $row['time_slot'];
                    $start_duration = json_decode($this->db->get_where('event_time_slot',array('event_time_id'=>'1'))->row()->$current_slot);

                    $date = $row['date'];    $start = $start_duration->start_time;     $end = $start_duration->end_time;

                    $date1 = strtotime("$date $end");  
                    $date2 = strtotime("$date $start");  
     
                    $diff = abs($date2 - $date1);  
                    $hours = floor(($diff - $days*60*60*24) / (60*60)); 

                    $minutes = floor(($diff - $hours*60*60)/ 60);  
                
                $res['duration'] = $hours."(hours AEST) ".$minutes."mins";
                // Duration End

                $res['start_time']      = date('H:i A',strtotime($start_duration->start_time));
                
                $product_arr = explode(",", $row['promocode_products']);
                foreach ($product_arr as $value) 
                {
                   $product_name[] = $this->db->get_where('product',array('product_id'=>$value))->row()->title;
                }
                $res['highlights'] = implode(",", $product_name);


                $promo_detail = json_decode($this->db->get_where('promocode',array('promocode_id'=>$row['promocode_id']))->row()->spec);
                $promo_data = $promo_detail->discount_value;

                if($promo_data){
                    $res['promo']  = $promo_data." % Free";
                }
                 
                $res['status']          = ucwords($row['status']);

                $res['options'] = "  

                            <a class=\"btn btn-info btn-xs btn-labeled fa fa-location-arrow\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_modal('view','".translate('view_events')."','".translate('successfully_viewed!')."','vendor_events_view','".$row['events_id']."');proceed('to_list');\" data-original-title=\"View\" data-container=\"body\">
                                    ".translate('view')."
                            </a>

                            <a class=\"btn btn-success btn-xs btn-labeled fa fa-wrench\" data-toggle=\"tooltip\" 
                                onclick=\"ajax_set_full('edit','".translate('edit_events')."','".translate('successfully_edited!')."','events_edit','".$row['events_id']."');proceed('to_list');\" data-original-title=\"Edit\" data-container=\"body\">
                                    ".translate('edit')."
                            </a>
                            
                            <a onclick=\"delete_confirm('".$row['events_id']."','".translate('really_want_to_delete_this?')."')\" 
                                class=\"btn btn-danger btn-xs btn-labeled fa fa-trash\" data-toggle=\"tooltip\" data-original-title=\"Delete\" data-container=\"body\">
                                    ".translate('delete')."
                            </a>";
                $data[] = $res;

                unset($product_name);
            }
            $result = array(
                             'total' => $total,
                             'rows' => $data
                           );

            echo json_encode($result);

        } else if ($para1 == 'dlt_img') {
            $a = explode('_', $para2);
            $this->crud_model->file_dlt('events', $a[0], '.jpg', 'multi', $a[1]);
            recache();
        } elseif ($para1 == 'add') {
            $this->load->view('back/vendor/add_events');              
        }else {
            $page_data['page_name']   = "events";
           
            $page_data['all_events'] = $this->db->get('events')->result_array();
            $this->load->view('back/index', $page_data);
        }
    }



    

}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */