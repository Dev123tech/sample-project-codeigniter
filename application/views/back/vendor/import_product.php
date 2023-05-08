<div id="content-container">
    <div id="page-title">
        <h1 class="page-header text-overflow">Products Import</h1>
    </div>
    <div class="tab-base">
        <div class="tab-base tab-stacked-left">
            <div class="col-sm-12">
                <div class="panel panel-bordered-dark">
                    <?php
                        echo form_open(base_url() . 'vendor/import', array(
                            'class'     => 'form-horizontal importClass',
                            'method'    => 'post',
                            'enctype'   => 'multipart/form-data'
                        ));
                        ?>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="demo-hor-inputemail">
                            Product Csv File
                            </label>
                            <div class="col-sm-6">
                                <div class="col-sm-">
                                    <input type="file" class="form-control" name="csv_file" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center">
                        <button type="submit" id="import_csv_btn" class="btn btn-info">Import CSV</button>
                    </div>
                    <?php echo  form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('body').on('submit','.importClass',function(event)
    {
        var from = $(this); 
        event.preventDefault();
        $.ajax({
            url:from.attr('action'),
            method: from.attr('method'),
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            beforeSend:function()
            {
                $('#import_csv_btn').html('Importing...');
            },
            success:function(data)
            {
                $.activeitNoty({
                    type: 'success',
                    icon: 'fa fa-check',
                    message: 'Product Import Successfully',
                    container: 'floating',
                    timer: 3000
                });
                setTimeout(function()
                { 
                    location.href= base_url + 'vendor/product';   
                }, 3000);    
            }
        });
    });
</script>