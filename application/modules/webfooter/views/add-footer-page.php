<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <h1 class="text-uppercase"> 
          ADD FOOTER PAGE 
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <div class="row">
              <div class="col-md-12">
                  <form id="FormAddData" name="FormAddData">                    
                    <div class="form-group">
                      <label for="email">Page Title:</label>
                      <input type="text" name="txttitle" id="txttitle" class="form-control">
                      <input type="hidden" name="txtfooterpageid" id="txtfooterpageid" value="<?php echo $footer->id ?>">
                    </div>

                    <div class="form-group">
                      <label for="email"> Footer Link Name:</label>
                      <input type="text" name="txtfootername" id="txtfootername" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="email">Redirect to Other Link:</label>
                      <input type="text" name="txtotherlink" id="txtotherlink" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="email">Description:</label>
                      <textarea cols="10" rows="10" class=" form-control summernote" id="txtdescription" name="txtdescription"></textarea>
                    </div>
 
                    <div id="retmsg"></div>
                    <div class="form-group text-center">
                      <button id="submit" name="submit" type="submit" class="btn btn-primary"> SUBMIT </button>
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
   $('#FormAddData').on('submit', function(e){       
        e.preventDefault();

        $('#retmsg').removeClass(' alert alert-info');
        $('#retmsg').removeClass(' alert alert-success');
        $('#retmsg').removeClass(' alert alert-danger');

        $('#retmsg').html('Please wait');
        $('#retmsg').show().delay(5000).fadeOut();
        $('#retmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/save-footer-page'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#retmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#retmsg').html('Added successfully.');
                    $('#retmsg').show().delay(5000).fadeOut();
                    $('#retmsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }

                if(data == "imageerror"){
                  $('#retmsg').html('Banner image cannot be empty');
                  $('#retmsg').show().delay(5000).fadeOut();
                  $('#retmsg').addClass(' alert alert-danger');
                  return false;
                }

                if(data == "error"){
                  $('#retmsg').html('Error to add, retry');
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
         
 
 

      
    