<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Brand extends CI_Controller {

 public function __construct()
 {
  parent::__construct();
  $this->load->model('Brand_model');
 }

 
  function fetch_Brand(){  
            
           $fetch_data = $this->Brand_model->make_datatables();  
           $data = array();  
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();  
                $sub_array[] = '<img src="'.base_url().'uploads/'.$row->image.'" class="img-thumbnail" width="50" height="35" />';  
                $sub_array[] = $name;  
                
                $sub_array[] = '<button type="button" name="update" id="'.$row->id.'" class="btn btn-warning btn-xs update">Update</button>';  
                $sub_array[] = '<button type="button" name="delete" id="'.$row->id.'" class="btn btn-danger btn-xs delete">Delete</button>';  
                $data[] = $sub_array;  
           }  
           $output = array(  
                "draw"                    =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->crud_model->get_all_data(),  
                "recordsFiltered"     =>     $this->crud_model->get_filtered_data(),  
                "data"                    =>     $data  
           );  
           echo json_encode($output);  
      }  



 function vendor_action(){   
            
                $insert_data = array(  
                     'user_id'=> $this->input->post('vendor_id'),
                     'name'          =>     $this->input->post('vendor_name'),  
                     
                     'image'                    =>     $this->upload_image()  
                );  
                 
               $this->Brand_model->insert_crud($insert_data);  

               
                     echo "Vendor Brand Saved"; 
              
            
           if($_POST["action"] == "Edit")  
           {  
                $user_image = '';  
                if($_FILES["vendor_image"]["name"] != '')  
                {  
                     $user_image = $this->upload_image();  
                }  
                else  
                {  
                     $user_image = $this->input->post("hidden_user_image");  
                }  
                $updated_data = array(  
                     'name'          =>     $this->input->post('vendor_name'),  
              
                     'image'                    =>     $user_image  
                );  
                 
                $this->vendorBrand_model->update_crud($this->input->post("user_id"), $updated_data);  
                echo 'Data Updated';  
           }  
      }  
      function upload_image()  
      {  
           if(isset($_FILES["vendor_image"]))  
           {  
                $extension = explode('.', $_FILES['vendor_image']['name']);  
                $new_name = rand() . '.' . $extension[1];  
                $destination = './uploads/' . $new_name;  
                move_uploaded_file($_FILES['vendor_image']['tmp_name'], $destination);  
                return $new_name;  
           }  
      }  




  }

?>
