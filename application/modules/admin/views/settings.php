<?php 
// print_r($users);
$searchtext = '';
if(!empty($_GET['search'])){
  $searchtext = $_GET['search'];
}
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
  .mytitle{
    color: #f00;
    border-bottom: 1px solid #ccc;
  }
</style>

<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-uppercase"> 
            SETTINGS
          </h1>
        </div>
        <!-- <div class="col-md-4">
           <form>
             <input type="text" class="form-control input-sm" name="search" id="search" placeholder="Search..." value="<?php echo $searchtext; ?>">
           </form>
        </div> -->
        <?php 
          $settings = get_pabe_settings();
          // print_r($settings); 
        ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <form id="formSettings" name="formSettings">
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group mytitle">
                      <label for="email">Experties:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Applications:</label>
                      <input type="text" class="form-control" id="applications" name="applications" value="<?php if(!empty($settings)){echo $settings->title1; } ?>" />
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Industy Experience:</label>
                      <input type="text" class="form-control" id="industry" name="industry" value="<?php if(!empty($settings)){echo $settings->title2; } ?>"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Simulations experience:</label>
                      <input type="text" class="form-control" id="simulations" name="simulations" value="<?php if(!empty($settings)){echo $settings->title3; } ?>"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Software experience:</label>
                      <input type="text" class="form-control" id="software" name="software" value="<?php if(!empty($settings)){echo $settings->title4; } ?>"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Research and development experience :</label>
                      <input type="text" class="form-control" id="research" name="research" value="<?php if(!empty($settings)){echo $settings->title5; } ?>"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Physics experience:</label>
                      <input type="text" class="form-control" id="physics" name="physics" value="<?php if(!empty($settings)){echo $settings->title6; } ?>"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                      <label for="email">Soft Skill:</label>
                      <input type="text" class="form-control" id="skill" name="skill" value="<?php if(!empty($settings)){echo $settings->title7; } ?>"/>
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
               <div class="col-md-12">
                    <div class="form-group mytitle">
                      <label for="email">Service Fee:</label>
                    </div>
                </div>
                <?php 
                $ser_fee = get_service_fee();
                ?>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Service Fee INR:</label>
                       <input type="number" step="any" class="form-control" id="txtservicefeeinr" name="txtservicefeeinr" value="<?php if(!empty($ser_fee)){echo $ser_fee->service_fee; } ?>" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Service Fee USD:</label>
                      <input type="number" step="any" class="form-control" id="txtservicefeeusd" name="txtservicefeeusd" value="<?php if(!empty($ser_fee)){echo $ser_fee->service_fee_other; } ?>" />
                    </div>
                </div>
                <div class="clearfix"></div>
                <br>
                <div class="col-md-12">
                    <div class="form-group mytitle">
                      <label for="email">Other:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Logo:</label>
                      <input type="file" class="form-control" id="txtimage" name="txtimage"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Exchange Rate:</label>
                      <input type="number" step="any" class="form-control" id="txtinrrate" name="txtinrrate" value="<?php if(!empty($settings)){echo $settings->exchange_rate; } ?>" />
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div id="enblemsg"></div>
                <div>
                  <center><button class="btn btn-primary ">SAVE SETTINGS</button></center>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

 <script type="text/javascript">
 
    $('#formSettings').on('submit', function(e){       
        e.preventDefault();

        $('#enblemsg').removeClass(' alert alert-info');
        $('#enblemsg').removeClass(' alert alert-success');
        $('#enblemsg').removeClass(' alert alert-danger');


        $('#enblemsg').html('Please wait');
        $('#enblemsg').show().delay(5000).fadeOut();
        $('#enblemsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/save-project-setings'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#enblemsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#enblemsg').html('Change successfully.');
                    $('#enblemsg').show().delay(5000).fadeOut();
                    $('#enblemsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }
                if(data == "error"){
                  $('#enblemsg').html('Error to change, retry');
                  $('#enblemsg').show().delay(5000).fadeOut();
                  $('#enblemsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#enblemsg').html(data);
                $('#enblemsg').show().delay(5000).fadeOut();
                $('#enblemsg').addClass(' alert alert-danger');
            }
        });
    });
    
</script>
         
 
 

      
    