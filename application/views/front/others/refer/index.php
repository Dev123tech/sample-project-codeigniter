<div class="offcanvas-overlay"></div>
<!-- Breadcrumb Area Start -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content">
                    <ul class="nav">
                        <li><a href="index.html">Home</a></li>
                        <li>Refer Offer</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
if($this->session->userdata('user_login') == 'yes'){ ?>
<!-- Breadcrumb Area End-->
<!-- section start -->
<section class="referblock subscribe-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="subscribe-content">
                    <div class="referoffer">
                        <img class="firstrefer" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/money.png">
                        <h5>Earn $10 from referral</h5>
                        <img class="offerlast" src="<?php echo base_url(); ?>template/omgee/images/iconfindericon/money.png">
                    </div>
                    <span class="sub-title">OMGee Offer</span>
                    <h2>Invite Your Friends Via Email or Link</h2>
                </div>
            </div>
            <div class="col-md-4 offset-sm-2 col-12">
                <div class="subscribe-content">
                    <?php  echo form_open(base_url() . 'home/others/do_refer/', array('method' => 'post')); ?>
                    <div class="newsletter-form" data-toggle="validator" novalidate="true">
                        <input type="text"  class="input-newsletter" placeholder="john@example.com" name="email" autocomplete="off">
                        <button type="submit" class="default-btn disabled" style="pointer-events: all; cursor: pointer;">Send</button>
                        <div id="validator-newsletter" class="form-result"></div>
                    </div>
                    </form>
                </div>
            </div>  
            <?php

                $user_id = $this->session->userdata('user_id');
                $refer = $this->db->get_where('user',array('user_id'=>$user_id))->row()->user_id;
                $wallet_earn = $this->db->get_where('user',array('user_id'=>$user_id))->row()->earn;
                $earn =  $this->db->get_where('general_settings',array('type' => 'earn'))->row()->value;

            ?>
            <div class="col-md-4 col-12">
                <div class="subscribe-content">
                    <form class="newsletter-form" data-toggle="validator" novalidate="true">
                        <input type="text" class="input-newsletter" value="<?php echo base_url(); ?>home/login_set/login?code=<?php echo base64_encode($refer); ?>" placeholder="Share Your OMGee Invite Link" name="copy" id="myInput"  autocomplete="off">
                        <button type="button" class="default-btn disabled" onclick="myFunction()" style="pointer-events: all; cursor: pointer;">Copy</button>
                        <div id="validator-newsletter" class="form-result"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="shape9" id="loading"><img src="<?php echo base_url(); ?>template/omgee/images/shapes/3.png" alt="image"></div>
    <div class="shape11" id="loading"><img src="<?php echo base_url(); ?>template/omgee/images/shapes/3.png" alt="image"></div>
    <!--   <div class="shape10"><img src="assets/img/shape/shape10.png" alt="image"></div>
        <div class="shape12"><img src="assets/img/shape/shape12.png" alt="image"></div> -->
</section>
<!-- end -->
<!-- section start -->
<!-- end -->
<section class="referinvited">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h2 class="section-heading">Your Referral Activity</h2>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tableinvite">
                    <table class="table table-dark table-striped table-hover table-responsive">
                        <thead>
                            <th>Date</th>
                            <th>Invite Email</th>
                            <th>Status</th>
                            <th>Earn</th>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($refers as $row) 
                                {
                                    // $unique_refer = $this->db->get_where('user',array('user.unique_refer_key'=>$row['user_id']))->join('refer', 'refer.user_id = user.unique_refer_key', 'left')->row();
                                    if($row['user_id'] == $user_id)
                                    {
                                ?>  
                                    <tr>
                                        <td>
                                            <?php 
                                                $date = $row['date'];
                                                $pieces = explode(" ", $date);
                                                echo $pieces[0]; 
                                            ?>
                                        </td>    
                                        <td> <?php echo $row['refer_email']; ?> </td>
                                        <td> <?php echo ucwords($row['status']); ?> </td>
                                        <td> 
                                        <?php 
                                            $check_id = $this->db->get_where('user',array('email'=>$row['refer_email']))->row()->user_id;
                                            // echo $this->db->last_query(); 
                                            $order_buyer = $this->db->get_where('sale',array('buyer'=>$check_id))->row()->buyer;
                                            
                                            if($row['status']=="Joined" && $order_buyer)
                                            {
                                                echo currency($earn);
                                            

                                            }else{
                                                echo "$0";
                                            }
                                        ?>
                                        </td>
                                    </tr>
                            <?php 
                                }  
                            }   
                                  
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- 
 <script src="<?php $this->benchmark->mark_time(); echo base_url(); ?>template/back/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"> -->
</script>
<script type="text/javascript">
        function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
       copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
    }
</script>

<?php
}else{
    redirect(base_url('home/login_set/login'));
}
?>