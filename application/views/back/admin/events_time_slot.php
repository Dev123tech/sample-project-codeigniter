<div id="content-container">
    <div id="page-title">
        <center>
            <h1 class="page-header text-overflow">
                <?php echo translate('time_slot')?>
            </h1>
        </center>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="panel panel-bordered panel-dark">
                    <div class="panel-heading">
                        <center>
                            <h3 class="panel-title"><?php echo translate('time_slot')?></h3>
                        </center>
                    </div>
                    <div class="panel-body">  
                        <?php
                            echo form_open(base_url() . 'admin/events/events_time_slot_update', array(
                                'class' => 'form-horizontal',
                                'method' => 'post',
                                'enctype' => 'multipart/form-data'
                            ));

                            $result = $this->db->get_where('event_time_slot')->row();
                            $time_slot1 = json_decode($result->slot_1);
                            $time_slot2 = json_decode($result->slot_2);
                            $time_slot3 = json_decode($result->slot_3);
                        ?>                                  
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Slot 1</label>
                                <div class="col-sm-9">
                                    <label class="col-sm-2 control-label">Start Time </label>
                                    <div class="col-sm-2">
                                        <div class="input-group">    
                                            <input type="time" name="start_time1"  class="form-control required" value="<?php echo $time_slot1->start_time; ?>" >
                                        </div>
                                    </div>
                                    <label class="col-sm-2 control-label">End Time </label>
                                    <div class="col-sm-2">
                                        <div class="input-group">    
                                            <input type="time" name="end_time1" value="<?php echo $time_slot1->end_time; ?>"  class="form-control required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Slot 2</label>
                                <div class="col-sm-9">
                                    <label class="col-sm-2 control-label">Start Time </label>
                                    <div class="col-sm-2">
                                        <div class="input-group">    
                                            <input type="time" name="start_time2" value="<?php echo $time_slot2->start_time; ?>"  class="form-control required">
                                        </div>
                                    </div>
                                    <label class="col-sm-2 control-label">End Time </label>
                                    <div class="col-sm-2">
                                        <div class="input-group">    
                                            <input type="time" name="end_time2" value="<?php echo $time_slot2->end_time; ?>"  class="form-control required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Slot 3</label>
                                <div class="col-sm-9">
                                    <label class="col-sm-2 control-label">Start Time </label>
                                    <div class="col-sm-2">
                                        <div class="input-group">    
                                            <input type="time" name="start_time3" value="<?php echo $time_slot3->start_time; ?>"  class="form-control required">
                                        </div>
                                    </div>
                                    <label class="col-sm-2 control-label">End Time </label>
                                    <div class="col-sm-2">
                                        <div class="input-group">    
                                            <input type="time" name="end_time3" value="<?php echo $time_slot3->end_time; ?>"  class="form-control required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group float-right">    
                                <div class="col-sm-6">  
                                    <span class="btn btn-success btn-md btn-labeled fa fa-upload pull-right saver" data-ing="<?php echo translate('saving'); ?>.."><?php echo translate('save');?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.bg-white{
    background:#ffffff !important;
    color:#000 !important;
}
</style>
<script>
$(document).ready(function(e) {
    $("body").on('click','.saver',function(){
        var here = $(this); // alert div for show alert message
        var text = here.html(); // alert div for show alert message
        var form = here.closest('form');
        var submitting = here.data('ing');
        //var form = $(this);
        var formdata = false;
        if (window.FormData){
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: form.attr('action'), // form action url
            type: 'POST', // form submit method get/post
            dataType: 'html', // request type html/json/xml
            data: formdata ? formdata : form.serialize(), // serialize form data 
            cache       : false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                here.addClass('disabled');
                here.html(submitting); // change submit button text
            },
            success: function(data) {
                here.fadeIn();
                here.html(text);
                here.removeClass('disabled');
                var loc = location.href;
                location.replace(loc);
            },
            error: function(e) {
                console.log(e)
            }
        });
    });
});


$(document).ready(function(){

});
</script>
