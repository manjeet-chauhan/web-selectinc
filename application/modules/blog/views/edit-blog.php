<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <h1 class="text-uppercase"> 
          EDIT BLOG 
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
                      <label for="email">Title:</label>
                      <input type="text" name="txttitle" id="txttitle" class="form-control" value="<?php echo $blog->title ?>">
                      
                      <input type="hidden" name="blog_id" id="blog_id" class="form-control" value="<?php echo $blog->blog_id ?>">

                    </div>

                    <div class="form-group">
                      <label for="email">Image:</label>
                      <input type="file" name="txtimage" id="txtimage" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="email">Description:</label>
                      <textarea class=" form-control summernote" id="txtprojectdescription" name="txtprojectdescription"><?php echo $blog->description ?></textarea>
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
            url: '<?php echo base_url('admin/save-edit-blog'); ?>',
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
         
 
 

      
    