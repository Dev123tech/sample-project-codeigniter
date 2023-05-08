<link rel="stylesheet" href="<?php echo base_url(); ?>template/back//amcharts/style.css" type="text/css">
<script src="<?php echo base_url(); ?>template/back/amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>template/back/amcharts/serial.js" type="text/javascript"></script>
<link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0/src/markerclusterer.js"></script>
<script src="<?php echo base_url(); ?>template/back/plugins/gauge-js/gauge.min.js"></script>



<div id="content-container">
    <script type="text/template" id="main-example-template">
            <div class="time <%= label %>">
              <span class="count curr top"><%= curr %></span>
              <span class="count next top"><%= next %></span>
              <span class="count next bottom"><%= next %></span>
              <span class="count curr bottom"><%= curr %></span>
              <span class="label label-purple"><%= label.length < 6 ? label : label.substr(0, 3)  %></span>
            </div>
        </script>
        <script type="text/javascript">
            $(window).on('load', function() {
                var labels = ['weeks', 'days', 'hours', 'minutes', 'seconds'],
                    nextYear = '<?php echo date('Y/m/d', $vend->member_expire_timestamp); ?>',
                    template = _.template($('#main-example-template').html()),
                    currDate = '00:00:00:00:00',
                    nextDate = '00:00:00:00:00',
                    parser = /([0-9]{2})/gi,
                    $example = $('#main-example');
                // Parse countdown string to an object
                function strfobj(str) {
                    var parsed = str.match(parser),
                        obj = {};
                    labels.forEach(function(label, i) {
                        obj[label] = parsed[i]
                    });
                    return obj;
                }
                // Return the time components that diffs
                function diff(obj1, obj2) {
                    var diff = [];
                    labels.forEach(function(key) {
                        if (obj1[key] !== obj2[key]) {
                            diff.push(key);
                        }
                    });
                    return diff;
                }
                // Build the layout
                var initData = strfobj(currDate);
                labels.forEach(function(label, i) {
                    $example.append(template({
                        curr: initData[label],
                        next: initData[label],
                        label: label
                    }));
                });
                // Starts the countdown
                $example.countdown(nextYear, function(event) {
                    var newDate = event.strftime('%w:%d:%H:%M:%S'),
                        data;
                    if (newDate !== nextDate) {
                        currDate = nextDate;
                        nextDate = newDate;
                        // Setup the data
                        data = {
                            'curr': strfobj(currDate),
                            'next': strfobj(nextDate)
                        };
                        // Apply the new values to each node that changed
                        diff(data.curr, data.next).forEach(function(label) {
                            var selector = '.%s'.replace(/%s/, label),
                                $node = $example.find(selector);
                            // Update the node
                            $node.removeClass('flip');
                            $node.find('.curr').text(data.curr[label]);
                            $node.find('.next').text(data.next[label]);
                            // Wait for a repaint to then flip
                            _.delay(function($node) {
                                $node.addClass('flip');
                            }, 50, $node);
                        });
                    }
                });
            });
    </script>
    <div id="page-title">
        <h1 class="page-header text-overflow"><?php echo translate('dashboard'); ?></h1>
    </div>
    <div class="col-md-12 mt-20px mb-10px">
    
        <div class="col-md-6">
            <table id="customers" class="vendor-dash-table purple">
              <tr>
                <th class="bg-purple"><?php echo "OMGee total number of consumers"; ?></th>
              </tr>
              <tr>
                <td class="d-flex justify-center border-purple bg-white">
                    <span class="mr-2 d-flex mr-5px bg-purple"><?php echo currency('', 'def'); ?></span>
                    <span class="d-flex bg-purple"><?php echo $consumers_count = count($this->db->get('user')->result_array()); ?></span>
                </td>
              </tr>
            </table>
        </div>
        
        <div class="col-md-6">
            <table id="customers" class="vendor-dash-table green">
              <tr>
                <th class="bg-green"><?php echo "OMGee Total sales per country";?></th>
              </tr>
              <tr>
                  <?php
                    $country_count = $this->db->get('sale')->result_array();
                    $au = 0; $hk = 0; $jp = 0; $sg = 0;
                    foreach ($country_count as  $row) 
                    {
                        if($row['shipping_address'])
                        {
                            $country_count = json_decode($row['shipping_address']);
                            if($country_count->country == 'AU' || $country_count->delivery_country == 'AU')
                            {
                                $au++;
                            }
                            else if($country_count->country == 'HK' || $country_count->delivery_country == 'HK')
                            {
                                $hk++;
                            }
                            else if($country_count->country == 'JP' || $country_count->delivery_country == 'JP')
                            {
                                $jp++;
                            }
                            else if($country_count->country == 'SG' || $country_count->delivery_country == 'SG')
                            {
                                $sg++;
                            }
                        }
                        
                    }
                    $arr = array(
                                array('id'=>$au,'name'=>'Austraila'),
                                array('id'=>$hk,'name'=>'HongKong'),
                                array('id'=>$jp,'name'=>'Japan'),
                                array('id'=>$sg,'name'=>'Singapore')
                            );
                    rsort($arr);
                    ?>   
                <?php
                    foreach ($arr as $arr1) {
                         
                        ?>
                <td class="d-flex justify-center border-green bg-white">
                    <span class="mr-2 d-flex mr-5px bg-green"><?php echo $arr1['name']; ?></span>
                    <span class="d-flex bg-green"><?php echo $arr1['id']; ?>%</span>
                </td>
                <?php
                    }
                    ?>
              </tr>
            </table>
         </div>

    </div>
    
    <div class="col-md-12  mt-20px mb-10px">
        <div class="col-md-12 table-responsive">
        
            <table class="vendor-dash-table table table-striped m-0"><caption class="bg-blue color-white">OMGee Top 5 Product sales volume (quentity) per Country</caption>
                <tbody class="border-green color-black pd-15 bg-white d-block">
                    <tr class="d-flex">   
                        <td class="d-inlineflex justify-center width-50">Name</td>
                        <td class="d-inlineflex justify-center width-50"></td>
                    </tr>                               
                    <tr class="d-flex">                                
                        <td class="d-inlineflex justify-center bg-white width-50">Membership Expiration</td>
                        <td class="d-inlineflex justify-center bg-white width-50">1 Jan, 1970</td>
                    </tr>                               
                    <tr class="d-flex">                                
                        <td class="d-inlineflex justify-center width-50">Maximum Products</td>
                        <td class="d-inlineflex justify-center width-50"></td>
                    </tr>                               
                    <tr class="d-flex">                                
                        <td class="d-inlineflex justify-center bg-white width-50">Total Uploaded Products</td>
                        <td class="d-inlineflex justify-center bg-white width-50">3</td>
                    </tr>                               
                    <tr class="d-flex">                                
                        <td class="d-inlineflex justify-center width-50">Uploaded Published Products</td>
                        <td class="d-inlineflex justify-center width-50">3</td>
                    </tr>
                </tbody>
            </table>
        
        </div>
    </div>
    
    
    <div class="col-md-12 mb-10px">
    
        <div class="col-md-4">
            <table id="customers" class="vendor-dash-table">
              <tr>
                <th class="bg-dblue">Total sales volume</th>
              </tr>
              <tr>
                <td class="d-flex justify-center border-dblue bg-white">
                    <span class="mr-2 d-flex mr-5px bg-dblue">$</span>
                    <span class="d-flex bg-dblue">0</span>
                </td>
              </tr>
            </table>
        </div>
        
        <div class="col-md-4">
            <table id="customers" class="vendor-dash-table purple">
              <tr>
                <th class="bg-purple"><?php echo "Total sales revenue"; ?></th>
              </tr>
              <tr>
                <td class="d-flex justify-center border-purple bg-white">
                    <span class="mr-2 d-flex mr-5px bg-purple"><?php echo currency('', 'def'); ?></span>
                    <span class="d-flex bg-purple">$0</span>
                </td>
              </tr>
            </table>
        </div>
         
         <div class="col-md-4">
            <table id="customers" class="vendor-dash-table green">
              <tr>
                <th class="bg-green">Total sales volume per country</th>
              </tr>
              <tr>
                <td class="d-flex justify-center border-green bg-white">
                    <span class="mr-2 d-flex mr-5px bg-green"><?php echo 'Austraila'; ?></span>
                    <span class="d-flex bg-green"><?php echo $austotalQty; ?></span>
                </td>
                <td class="d-flex justify-center border-green bg-white">
                    <span class="mr-2 d-flex mr-5px bg-green"><?php echo 'HongKong'; ?></span>
                    <span class="d-flex bg-green"><?php echo $hktotalQty; ?></span>
                </td>
                <td class="d-flex justify-center border-green bg-white">
                    <span class="mr-2 d-flex mr-5px bg-green"><?php echo 'Japan'; ?></span>
                    <span class="d-flex bg-green"><?php echo $jptotalQty; ?></span>
                </td>
                <td class="d-flex justify-center border-green bg-white">
                    <span class="mr-2 d-flex mr-5px bg-green"><?php echo 'Singapore'; ?></span>
                    <span class="d-flex bg-green"><?php echo $sgtotalQty; ?></span>
                </td>
              </tr>
            </table>
         </div>

    </div>
    
    
    <div class="col-md-12 mt-10px mb-10px">
        
        <div class="col-md-4">
            <table id="customers" class="vendor-dash-table purple">
              <tr>
                <th class="bg-purple">Total sales revenue per country</th>
              </tr>
              <tr>
                <td class="d-flex justify-center border-purple bg-white">
                    <span class="mr-2 d-flex mr-5px bg-purple">$</span>
                    <span class="d-flex bg-purple">0</span>
                </td>
              </tr>
            </table>
        </div>
         
         <div class="col-md-8">
            <table id="customers" class="vendor-dash-table green">
              <tr>
                <th class="bg-green">Total 5 most purchase product volume</th>
              </tr>
              <tr>
                <td class="d-flex justify-center border-green bg-white">
                    <span class="mr-2 d-flex mr-5px bg-green">$</span>
                    <span class="d-flex bg-green">0</span>
                </td>
              </tr>
            </table>
         </div>

    </div>
    
     <div class="col-md-12 mt-10px mb-10px">
        
        <div class="col-md-6">
            <table id="customers" class="vendor-dash-table">
              <tr>
                <th class="bg-dblue">Total 5 most purchase product revenue</th>
              </tr>
              <tr>
                <td class="d-flex justify-center border-dblue bg-white">
                    <span class="mr-2 d-flex mr-5px bg-dblue">$</span>
                    <span class="d-flex bg-dblue">0</span>
                </td>
              </tr>
            </table>
        </div>
         

    </div>
    
</div>
<?php
    // $vendor_id = $this->session->userdata('vendor_id');
    // $cod_paid = $this->crud_model->vendor_share_total($vendor_id,'paid','cash_on_delivery');
    // $stock = $this->crud_model->vendor_share_total($vendor_id);
    // $stock = $stock['total'];
    // $sale = $this->crud_model->vendor_share_total($vendor_id,'paid');
    // $sale = $sale['total'];
    // $already_paid = $this->crud_model->paid_to_vendor($vendor_id);
    // $destroy = $sale-$already_paid-$cod_paid['total'];
    //echo $already_paid;
    ?>
<script>
    var base_url = '<?php echo base_url(); ?>';
    var stock = <?php if ($stock == 0) {
        echo .1;
        } else {
        echo $stock;
        } ?>;
    var stock_max = <?php echo ($stock * 3.5 / 3 + 100); ?>;
    var destroy = <?php if ($destroy == 0) {
        echo .1;
        } else {
        echo $destroy;
        } ?>;
    var destroy_max = <?php echo ($destroy * 3.5 / 3 + 100); ?>;
    var sale = <?php if ($sale == 0) {
        echo .1;
        } else {
        echo $sale;
        } ?>;
    var sale_max = <?php echo ($sale * 3.5 / 3 + 100); ?>;
    var currency = '<?php echo currency('', 'def'); ?>';
    var cost_txt = '<?php echo translate('cost'); ?>(<?php echo currency('', 'def'); ?>)';
    var value_txt = '<?php echo translate('value'); ?>(<?php echo currency('', 'def'); ?>)';
    var loss_txt = '<?php echo translate('loss'); ?>(<?php echo currency('', 'def'); ?>)';
    var pl_txt = '<?php echo translate('profit'); ?>/<?php echo translate('loss'); ?>(<?php echo currency('', 'def'); ?>)';
    
    var sale_details = [];
    
    var sale_details1 = [];
    
    var chartData1 = [];
    
    var chartData2 = [];
    
    var chartData3 = [];
    
    var chartData4 = [
        <?php
        $categories = $this->db->get('category')->result_array();
        foreach ($categories as $row) {
            if ($this->crud_model->is_category_of_vendor($row['category_id'], $vendor_id)) {
                $fin = ($this->crud_model->month_total('sale', 'category', $row['category_id'])) - ($this->crud_model->month_total('stock', 'category', $row['category_id'], 'type', 'add'));
        ?> {
                    "country": "<?php echo $row['category_name']; ?>",
                    "visits": <?php echo $fin; ?>,
                    "color": "#458fd2"
                },
        <?php
        }
        }
        ?>
    ];
    
    var chartData5 = [];
</script>
<script src="<?php echo base_url(); ?>template/back/js/custom/dashboard.js"></script>
<style>
    #map-container {
    padding: 6px;
    border-width: 1px;
    border-style: solid;
    border-color: #ccc #ccc #999 #ccc;
    -webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
    -moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
    box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
    width: 100%;
    }
    #map {
    width: 100%;
    height: 400px;
    }
    #map1 {
    width: 100%;
    height: 400px;
    }
    #actions {
    list-style: none;
    padding: 0;
    }
    #inline-actions {
    padding-top: 10px;
    }
    .item {
    margin-left: 20px;
    }
</style>