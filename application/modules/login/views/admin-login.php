<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link rel="icon" href="<?php echo  base_url('assets/frontend/images/logo.png'); ?>" type="image/x-icon">-->
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/css/main2.css'); ?>">
    <title> SelectInc </title>

    <style type="text/css">
      .pgbackground {

          background-image: url('<?php echo base_url('assets/admin/images/bg2login.jpg'); ?>');
          background-size: cover;
          width: 100%;
          height: 100%;
          position: absolute;
      }

      .imgcont{
        /*background-color: #e8e8e8;*/
        padding: 5px;
        /*border-radius: 4px;*/
        margin-bottom: 15px;
        /*border-top: 2px solid #b3b3b3;*/
        /*margin: 15px 0;*/
        padding-bottom: 15px;
        border-bottom: 2px solid #000;
      }

      .registercont{
        box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.3);
        margin-top: 30%;
      }

      .hotel-title{
            font-size: 18px;
        font-weight: bold;
        margin: 8px 0;
        text-transform: uppercase;
        letter-spacing: 1px;
      }

      .login-content {
        display: -ms-flexbox;
        display: contents;
      }

      .signup{
        font-weight: bold;
      }

      .textlogo {
    color: #5e35a8;
    font-weight: bold;
    font-size: 20px;
}

div.overlay{
  background-color: #b7ecf782; /* #009080ed*/
  height: 100%;
  width: 100%;

}

    </style>
  </head>
  <body>

    <div class="pgbackground">      
      <div class="overlay">
        <section class="login-content">
          <div class="containera">
              <div class="col-md-offset-4 col-md-4">
                  <div class="registercont card">
                    <form class="login-form" id="formLogin" name="formLogin">
                      <div class="imgcont text-center">
                        <img src="<?php echo  base_url('assets/frontend/images/logo.png'); ?>" style="height: 25px; max-width: 100% " alt="logo">
                        <div class="hotel-title">ADMIN LOGIN</div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">USERNAME</label>
                        <div class="lblmsg">
                           <input class="form-control" type="text" id="txtemail" name="txtemail" placeholder="Email" autofocus>
                           <div class="lbltxtmsg"><small>Enter registered Email (Ex: example@gmail.com)</small></div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label">PASSWORD</label>
                        <div class="lblmsg">
                        <input class="form-control" type="password" id="txtpassword" name="txtpassword" placeholder="Password">
                        <div class="lbltxtmsg"><small>Enter a valid Password</small></div>
                        </div>
                      </div>

                      <div class="">
                          <div class="col-md-8">
                           <!-- <div class="signup" >  Haven't <a href="#signup"> <b>Register</b> </a> here </div>  -->
                          </div>
                          <div class="col-md-4">
                            <div class="form-group btn-container text-center">
                              <button class="btn btn-warning">SIGN IN <i class="fa fa-sign-in fa-lg"></i></button>
                            </div>
                          </div>
                          <div class="clearfix"></div>
                      </div>
                      <div id="loginMessage"></div>
                    </form>
                  </div>
              </div>
          </div>
        </section>
      </div>
    </div>
  </body>
  <script src="<?php echo base_url('assets/admin/js/jquery-2.1.4.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/admin/js/bootstrap.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/admin/js/plugins/pace.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/admin/js/main.js'); ?>"></script>



  <script type="text/javascript">

        $('#formLogin').on('submit', function(e){       
            e.preventDefault();

            $('#loginMessage').removeClass(' alert alert-info');
            $('#loginMessage').removeClass(' alert alert-success');
            $('#loginMessage').removeClass(' alert alert-danger');

            if($('#txtemail').val() == "" || $('#txtpassword').val() == "" ){
              $('#loginMessage').html('Enter a valid Email and password');
              $('#loginMessage').show().delay(3000).slideUp(1000);
              $('#loginMessage').addClass(' alert alert-danger');
              return false;
            }

            $('#loginMessage').html('Please wait');
            $('#loginMessage').show().delay(5000).fadeOut();
            $('#loginMessage').addClass(' alert alert-info');
            // $('#myloader').show();
            $.ajax({
                url: '<?php echo base_url('admin/login-admin'); ?>',
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                async: true,
                success: function (data) { 

                    $('#loginMessage').removeClass(' alert alert-info');
                    if(data == "success"){
                        $('#loginMessage').html('Login Success');
                        $('#loginMessage').show().delay(5000).fadeOut();
                        $('#loginMessage').addClass(' alert alert-success');
                        window.location.href = "<?php echo base_url('admin/dashboard'); ?>";
                        return true;
                    }
                    if(data == "error"){
                      $('#loginMessage').html('Login Error, retry');
                      $('#loginMessage').show().delay(5000).fadeOut();
                      $('#loginMessage').addClass(' alert alert-danger');
                      return false;
                    }

                    $('#loginMessage').html(data);
                    $('#loginMessage').show().delay(5000).fadeOut();
                    $('#loginMessage').addClass(' alert alert-danger');
                }
            });
        });
        
      </script>
</html>