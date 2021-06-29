<?php 
// print_r($profile);
$searchtext = '';
if(!empty($_GET['search'])){
  $searchtext = $_GET['search'];
}
?>

<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> 
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>

<style type="text/css">
  .profileimgcont{
    margin-top: 5px;
  }
  .profileimgcont img{
    height: 90px;
    width: 100px;
    /*margin-top: 20px;*/
    border: 1px solid #ccc;
    padding: 2px;
  }

  .nicEdit-main  {
    min-height: 280px !important;
    overflow-y: auto;
  }
</style>

<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-uppercase"> 
              <i class="fa fa-home"></i> Home Page Contents
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
                  <form id="adminprofile" name="adminprofile" method="POST" action="<?php echo base_url('admin/save-home-page') ?>">
                    
                    <div class="row"> 

                      <div class="col-md-9">
                          <div class="form-group">
                            <label for="email">Title :</label>
                            <input type="text" class="form-control" id="txttitle" name="txttitle" value="<?php echo $home->title ?>">                            
                          </div>

                           <div class="form-group">
                            <label for="email">Image :</label>
                            <input type="file" class="form-control" id="aboutimage" name="aboutimage">
                          </div>
 
                      </div> 

                      <div class="col-md-3">
                        <img style="height: auto; width: 100%; margin-top: 20px;" src="<?php echo base_url('assets/upload/profileimage/').$home->image ?>">
                      </div>               
                    </div>

                    <div class="row">
                      <div class="col-md-12">

                          <div class="form-group">
                            <label for="email">Iframe :</label>
                             <input type="text" class="form-control" id="txtiframe" name="txtiframe" value='<?php echo $home->links ?>'>
                          </div>

                          <div class="form-group">
                              <label for="email">Description:</label>
                              <textarea class="form-control" id="homedescription" name="homedescription"><?php echo $home->description ?></textarea>
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
    
    $('#adminprofilesasa').on('submit', function(e){       
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
            url: '<?php echo base_url('admin/save-profile'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#retmsg').removeClass(' alert alert-info');

                if(data.indexOf("success#") >= 0){
                    $('#retmsg').html('Profile saved successfully.');
                    $('#retmsg').show().delay(5000).fadeOut();
                    $('#retmsg').addClass(' alert alert-success');                    
                    var redirect = "<?php echo base_url('admin/profile/') ?>"+ data.split('#')[1]+"/"+ $('#txtuniqueid').val();
                    window.location.href = redirect;
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
         
 
 

      
    