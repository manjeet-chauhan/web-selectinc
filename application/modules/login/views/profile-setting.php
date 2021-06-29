<?php 
// print_r($profile);
?>

<style type="text/css">
  .profileimgcont{
    margin-top: 25px;
  }
  .profileimgcont img{
    border: 1px solid #e1e1e1;
    padding: 2px;
    max-height: 125px;
  }
</style>

<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <h1 class="text-uppercase"> 
          <i class="fa fa-cog"></i> Profile Setup
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <div class="row">
              <div class="col-md-12">
                  <form method="POST" id="adminprofile" name="adminprofile" enctype="multipart/form-data">

                    <div class="row">                      
                      <div class="col-md-8 col-xs-8">
                          <div class="form-group">
                            <label for="email">First Name:</label>
                            <input type="text" class="form-control" id="txtfname" name="txtfname" 
                            value="<?php echo $profile->fname;  ?>">
                            <input type="hidden" class="form-control" id="txtid" name="txtid" 
                            value="<?php echo $profile->id;  ?>">
                          </div>

                          <div class="form-group">
                            <label for="email">Last Name:</label>
                            <input type="text" class="form-control" id="txtlname" name="txtlname"
                            value="<?php echo $profile->lname;  ?>">
                          </div>
                      </div>
                      <div class="col-md-4 col-xs-4">
                        <?php 

                        $profile_img = base_url('assets/admin/images/admin-profile.png');
                        if($profile->image != ""){
                          $profile_img = base_url('assets/admin/images/').$profile->image;
                        }

                        ?>
                        <div class="profileimgcont">
                          <img style="max-width: 100%; height: auto;" src="<?php echo $profile_img; ?>">
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="email">Profile Image:</label>
                      <input type="file" class="form-control" id="profileimag" name="profileimag">
                    </div>

                    <div class="form-group">
                      <label for="email">Contact No:</label>
                      <input type="text" class="form-control" id="txtcontactno"  name="txtcontactno"
                      value="<?php echo $profile->phone;  ?>">
                    </div>

                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="txtemail"  name="txtemail"
                      value="<?php echo $profile->email;  ?>">
                    </div>


                      <div id="retmsg"></div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">SAVE PROFILE</button>
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

            if($('#txtemail').val() == "" || $('#txtpassword').val() == "" ){
              $('#retmsg').html('Enter a valid Email and password');
              $('#retmsg').show().delay(3000).slideUp(1000);
              $('#retmsg').addClass(' alert alert-danger');
              return false;
            }

            $('#retmsg').html('Please wait');
            $('#retmsg').show().delay(5000).fadeOut();
            $('#retmsg').addClass(' alert alert-info');
            // $('#myloader').show();
            $.ajax({
                url: '<?php echo base_url('admin/update-profile'); ?>',
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                async: true,
                success: function (data) { 

                    $('#retmsg').removeClass(' alert alert-info');
                    if(data == "success"){
                        $('#retmsg').html('Profile saved successfully.');
                        $('#retmsg').show().delay(5000).fadeOut();
                        $('#retmsg').addClass(' alert alert-success');
                         location.reload();
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
         
 
 

      
    