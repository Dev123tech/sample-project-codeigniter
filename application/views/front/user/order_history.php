<div class="row">
    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
        <div class="information-title">
            <?php echo translate('your_order_history');?>
        </div>
        <div class="details-wrap">                                    
            <div class="details-box orders">
                    <div class="contacttable ordertable">
                                    <table class="table table-dark table-stripped table-hover table-responsive">
              
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo translate('date');?></th>
                            <th><?php echo translate('amount');?></th>
                            <th><?php echo translate('payment_status');?></th>
                            <th><?php echo translate('delivery_status');?><ion-icon name="star-outline" data-toggle="modal" data-target="#reviewblock"></ion-icon></th>
                            <th><?php echo translate('invoice');?></th>
                        </tr>
                        <div class="modal fade sliderpop review_new" id="reviewblock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title h6 text-sm-center" id="myModalLabel">
               
                    Review
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body wishleftimg">
                   
                <div class="row">
               <div class="col-sm-12">
               <div class="reviewform row">
                <div class="col-sm-3 lab_sty">
                <label>Ratings</label>
            </div>
            <div class="col-sm-9">
                <div class="rate">
          <input type="radio" id="star5" name="rate" value="5" onkeydown="navRadioGroup(event)" onfocus="setFocus(event)" required="">
          <label for="star5" title="5 stars">5 stars</label>
          <input type="radio" id="star4" name="rate" value="4" onkeydown="navRadioGroup(event)">
          <label for="star4" title="4 stars">4 stars</label>
          <input type="radio" id="star3" name="rate" value="3" onkeydown="navRadioGroup(event)">
          <label for="star3" title="3 stars">3 stars</label>
          <input type="radio" id="star2" name="rate" value="2" onkeydown="navRadioGroup(event)">
          <label for="star2" title="2 stars">2 stars</label>
          <input type="radio" id="star1" name="https://codepen.io/pen/rate" value="1" onkeydown="navRadioGroup(event)" onfocus="setFocus(event)">
          <label for="star1" title="1 star">1 star</label>
        </div>
    </div>
    <div class="col-sm-3 lab_sty">
        <label>Comments</label>
    </div>
    <div class="col-sm-9">
        <textarea class="form-control" rows="3" placeholder="Enter your comments"></textarea>
    </div>
    <div class="col-sm-6 offset-sm-6 text-right">
        <button type="button" class="btn btngra">Submit</button>
    </div>
               </div>
           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          </thead>
                    <tbody id="result2">
                    </tbody>
                </table>
            </div>
            </div>
        </div>

        <input type="hidden" id="page_num2" value="0" />

        <div class="pagination_box pro-pagination-style text-center mb-60px mt-30px">

        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <div class="information-title">
            <?php echo translate('order_tracing');?>
        </div>
        <div class="details-wrap">                                    
            <div class="details-box orders">                
                <?php
                    echo form_open(base_url() . 'home/profile/order_tracing/', array(
                        'class' => 'form-login',
                        'method' => 'post',
                        'enctype' => 'multipart/form-data'
                    ));
                ?>    
                    <div class="row orderoffer">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span>#</span><ion-icon name="arrow-redo-sharp"></ion-icon>
                                <input class="form-control" name="sale_code" type="text" placeholder="<?php echo translate('sale_code');?>">
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:0px;">
                            <span class="btn btn-theme btn-block signup_btn" data-callback="order_tracing" data-unsuccessful='<?php echo translate('order_tracing_unsuccessful!'); ?>' data-success='<?php echo translate('order_traced_successfully!'); ?>' data-ing='<?php echo translate('checking..') ?>' >
                                <?php echo translate('trace_my_order');?>
                            </span>
                            <div id="trace_details">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
  <style type="text/css">
                        
.reviewform .rate label, #reviewform.rate input,
#reviewform .rate1 label, #reviewform .rate1 input {
  display: inline-block;
}
.reviewform .rate {
  /* float: left; */
  /* display: inline-block; */
  height: 36px;
  display: inline-flex;
  flex-direction: row-reverse;
  align-items: flex-start;
  justify-content: flex-end;
}
.reviewform .rate > label {
  margin-bottom: 0;
 margin-top: -3px;
  height: 30px;
}
.reviewform .rate:not(:checked) > input {
  /* position: absolute; */
  top: -9999px;
  margin-left: -24px;
  width: 20px;
  padding-right: 14px;
  z-index: -10;
  display: none;
}
.reviewform .rate:not(:checked) > label {
  float:right;
  width:1em;
  overflow:hidden;
  white-space:nowrap;
  cursor:pointer;
  font-size:30px;
  color:#ccc;
}

.reviewform .rate2 {
  float: none;
}
.reviewform .rate:not(:checked) > label::before {
  content: '★ ';
  position: relative;
  top: -7px;
  left: 2px;
}
.reviewform .rate > input:checked ~ label {
  color: #ffc700;
}

.reviewform .rate:not(:checked) > label:hover,
.reviewform .rate:not(:checked) > label:hover ~ label {
  color: #deb217;
}
.reviewform .rate > input:checked + label:hover,
.reviewform .rate > input:checked + label:hover ~ label,
.reviewform .rate > input:checked ~ label:hover,
.reviewform .rate > input:checked ~ label:hover ~ label,
.reviewform .rate > label:hover ~ input:checked ~ label {
  color: #c59b08;
}
.lab_sty label{
color: #081346;
 font-weight: bold;
    font-size: 15px;
    }
    .review_new  .close {
    right: -13px;
    }
                    </style>
                    <script type="text/javascript">
                        const setFocus = (evt) => {
  const rateRadios = document.getElementsByName('rate');
  const rateRadiosArr = Array.from(rateRadios);
  const anyChecked = rateRadiosArr.some(radio => { return radio.checked === true; });
  // console.log('anyChecked', anyChecked);
  if (!anyChecked) {
    const star1 = document.getElementById('star1');
    star1.focus();
    // star1.checked = true;
  }
};

const navRadioGroup = (evt) => {
  // console.log('key', evt.key, 'code', evt.code, 'which', evt.which);
  // console.log(evt);
  
  const star1 = document.getElementById('star1');  
  const star2 = document.getElementById('star2');  
  const star3 = document.getElementById('star3');  
  const star4 = document.getElementById('star4');  
  const star5 = document.getElementById('star5');  

  if (['ArrowRight', 'ArrowLeft', 'ArrowDown', 'ArrowUp'].includes(evt.key)) {
    evt.preventDefault();
    // console.log('attempting return');
    if (evt.key === 'ArrowRight' || evt.key === 'ArrowDown') {
      switch(evt.target.id) {
        case 'star1':
          star2.focus();
          star2.checked = true;
          break;
        case 'star2':
          star3.focus();
          star3.checked = true;
          break;
        case 'star3':
          star4.focus();
          star4.checked = true;
          break;
        case 'star4':
          star5.focus();
          star5.checked = true;
          break;
        case 'star5':
          star1.focus();
          star1.checked = true;
          break;
      }
    } else if (evt.key === 'ArrowLeft' || evt.key === 'ArrowUp') {
      switch(evt.target.id) {
        case 'star1':
          star5.focus();
          star5.checked = true;
          break;
        case 'star2':
          star1.focus();
          star1.checked = true;
          break;
        case 'star3':
          star2.focus();
          star2.checked = true;
          break;
        case 'star4':
          star3.focus();
          star3.checked = true;
          break;
        case 'star5':
          star4.focus();
          star4.checked = true;
          break;
      }
    }
  }
};
                    </script>
<script>
    function order_listed(page){
        if(page == 'no'){
            page = $('#page_num2').val();   
        } else {
            $('#page_num2').val(page);
        }
        var alert = $('#result2');
        alert.load('<?php echo base_url();?>home/order_listed/'+page,
            function(){
                //set_switchery();
            }
        );   
    }
    $(document).ready(function() {
        order_listed('0');
    });

</script>