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
          <i class="fa fa-key"></i> Change Password 
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <div class="row">
              <div class=" col-md-12">
                  <form method="POST" id="adminprofile" name="adminprofile" enctype="multipart/form-data">
  
                    <div class="form-group">
                      <label for="email">Old Password:</label>
                      <input type="password" class="form-control" id="txtoldpassword"  name="txtoldpassword">
                      <input type="hidden" class="form-control" id="txtid"  name="txtid"
                      value="<?php echo $id;  ?>">
                    </div>

                    <div class="form-group">
                      <label for="email">New Password:</label>
                      <input type="password" class="form-control" id="txtnewpassword"  name="txtnewpassword" >
                    </div>

                    <div class="form-group">
                      <label for="email">Confirm Password:</label>
                      <input type="password" class="form-control" id="txtconfirmpassword"  name="txtconfirmpassword">
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
                url: '<?php echo base_url('admin/update-password'); ?>',
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                async: true,
                success: function (data) { 

                    $('#retmsg').removeClass(' alert alert-info');
                    if(data == "success"){
                        $('#retmsg').html('Password changed successfully.');
                        $('#retmsg').show().delay(5000).fadeOut();
                        $('#retmsg').addClass(' alert alert-success');
                         location.reload();
                        return true;
                    }

                    if(data == "oldpass"){
                      $('#retmsg').html('Error to validate old password');
                      $('#retmsg').show().delay(5000).fadeOut();
                      $('#retmsg').addClass(' alert alert-danger');
                      return false;
                    }
                    if(data == "mismatch"){
                      $('#retmsg').html('New password and Confirm password not matched');
                      $('#retmsg').show().delay(5000).fadeOut();
                      $('#retmsg').addClass(' alert alert-danger');
                      return false;
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
         
 
 

      
    