    <?php if($this->router->fetch_method() =='product_view') { 

     ?>
        <?php
            if($product_details[0]['num_of_imgs'] !=NULL)
            {
                $num_of_img = explode(",", $product_details[0]['num_of_imgs']); 
                $first_image = base_url('uploads/product_image/'.$num_of_img[0]);
            }
            else
            {
                $first_image = base_url('uploads/product_image/default.jpg');
            }    
        ?>
        <meta property="og:url"                content="<?php echo CURRENT_URL; ?>" />
        <meta property="og:type"               content="product" />
        <meta property="og:title"              content="<?php echo ucwords($page_title);?>" />
        <meta property="og:description"        content="<?php echo strip_tags($product_details[0]['description']); ?>" />
        <meta property="og:image"              content="<?php echo $first_image; ?>" />
<?php } ?>
        <meta charset="UTF-8">
        <meta name="description" content="<?php echo $description; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->description; } ?>">
        <meta name="keywords" content="<?php echo $keywords; if($page_name == 'vendor_home'){ echo ', '.$this->db->get_where('vendor',array('vendor_id'=>$vendor))->row()->keywords; }  if($page_name == 'others/custom_page'){ echo ', '.$tags; } ?>">
        <meta name="author" content="<?php echo $author; ?>">
        <meta name="revisit-after" content="<?php echo $revisit_after; ?> days">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php
        	include 'meta/'.$asset_page.'.php';
		?>      
        <!-- Favicon -->
        <?php $ext =  $this->db->get_where('ui_settings',array('type' => 'fav_ext'))->row()->value;?>
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url(); ?>template/front/ico/apple-touch-icon-144-precomposed.png">
        
        <link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/others/favicon.<?php echo $ext; ?>">
        
        <title><?php echo $page_title; ?></title>
        <?php if($this->crud_model->get_type_name_by_id('general_settings','80','value') == 'ok'){?>
        <!-- Google Analytics -->
        <!-- <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', "<?php echo $this->db->get_where('general_settings',array('type'=>'google_analytics_key'))->row()->value; ?>", 'auto');
        ga('send', 'pageview');
        </script> -->
        
        <!-- End Google Analytics -->
        <?php } ?>
        <!-- CSS Global -->
     



        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800&amp;display=swap" rel="stylesheet" />
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/vendor/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/vendor/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/vendor/simple-line-icons.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/vendor/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
 
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/vendor/vendor.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/plugins/plugins.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/style.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>template/omgee/css/responsive.css">
        <script src="<?php echo base_url(); ?>template/front/plugins/jquery/jquery-1.11.1.min.js"></script>