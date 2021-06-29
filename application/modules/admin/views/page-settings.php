 
 
<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-uppercase"> 
              <i class="fa fa-cog"></i> Page Settings
          </h1>
        </div>
        
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <div class="row">
              <div class="col-md-12">
                  <form id="adminprofile" name="adminprofile">
                    
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="email">Address :</label>
                            <input type="text" class="form-control" id="txtaddress" name="txtaddress" value="<?php echo $settings->address ?>">
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="email">Contact No : </label>
                            <input type="text" class="form-control" id="txtcontact" name="txtcontact" value="<?php echo $settings->contact ?>">
                          </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-9">
                          <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="text" class="form-control" id="txtemail" name="txtemail" value="<?php echo $settings->email ?>">
                          </div>
                          <div class="form-group">
                            <label for="email">Logo :</label>
                            <input type="file" class="form-control" id="txtlogo" name="txtlogo">
                          </div>
                      </div>

                      <div class="col-md-3">
                          <img style="height: 120px; width: 150px; margin-top: 20px;"  src="<?php echo base_url('assets/upload/profileimage/').$settings->logo ?>">
                      </div> 
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="email">Facebook Link :</label>
                            <input type="text" class="form-control" id="txtfacebook" name="txtfacebook" value="<?php echo $settings->facebook ?>">
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="email">Twitter Link :</label>
                            <input type="text" class="form-control" id="txttwitetr" name="txttwitetr" value="<?php echo $settings->twitter ?>">
                          </div>
                      </div> 
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="email">Linkedin Link :</label>
                            <input type="text" class="form-control" id="txtlinkedin" name="txtlinkedin" value="<?php echo $settings->linkedin ?>">
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group">
                            <label for="email">Instagram Link :</label>
                            <input type="text" class="form-control" id="txtinstagram" name="txtinstagram" value="<?php echo $settings->instagram ?>">
                          </div>
                      </div> 

                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="email">Copyright :</label>
                            <input type="text" class="form-control" id="txtcopyright" name="txtcopyright" value="<?php echo $settings->copyright ?>">
                          </div>
                      </div>  
                      
                    </div>
                   
                    <div class="row">
                      <div class="col-md-offset-3 col-md-6">
                          <div class="form-group">
                          <div id="retmsg"></div>
                          </div>
                      </div> 
                      <div class="clearfix"></div>
                      <div class="col-md-offset-3 col-md-6">
                          <div class="form-group">
                           <button type="submit" class="btn btn-primary btn-block">Save</button>
                          </div>
                      </div> 
                      <div class="clearfix"></div>
                    </div>
                    
                  </form>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>





 <script type="text/javascript">
    
    $('#adminprofile').on('submit', function(e){       
        e.preventDefault();

        $('#retmsg').removeClass(' alert alert-info');
        $('#retmsg').removeClass(' alert alert-success');
        $('#retmsg').removeClass(' alert alert-danger');


        $('#retmsg').html('Please wait');
        $('#retmsg').show().delay(5000).fadeOut();
        $('#retmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/save-page-settings'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#retmsg').removeClass(' alert alert-info');

                if(data == "success"){
                    $('#retmsg').html('Saved successfully.');
                    $('#retmsg').show().delay(5000).fadeOut();
                    $('#retmsg').addClass(' alert alert-success');                    
                    // var redirect = "<?php echo base_url('admin/profile/') ?>"+ data.split('#')[1]+"/"+ $('#txtuniqueid').val();
                     window.location.reload();
                    return true;
                }
                if(data == "error"){
                  $('#retmsg').html('Error to save data, retry');
                  $('#retmsg').show().delay(5000).fadeOut();
                  $('#retmsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#retmsg').html(data);
                $('#retmsg').show().delay(5000).fadeOut();
                $('#retmsg').addClass(' alert alert-danger');
            }
        });
    });
    
</script>
         
 
 

      
    