<style type="text/css">
  .blogtitle{
    line-height: 30px;
    font-weight: bold;
  }
  .imagecont img{
    border: 1px solid #ccc;
    padding: 2px;
  }
  .blogcontents{
    margin-top: 10px;
    margin-bottom: 10px;
  }
  .blogDesc{
    text-align: justify;
  }
</style>
<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <h1 class="text-uppercase"> 
           BLOG 
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <div class="row">
              <div class="col-md-12">
                <a class="btn btn-danger btn-sm" href="<?php echo base_url('admin/blog')  ?>">Back</a>
              </div>
              <div class=" col-md-offset-2 col-md-8">
                  <h4  class="blogtitle"><?php echo $blog->title ?></h4>
                  <div class="imagecont">
                    <img style="max-width: 100%;" src="<?php echo base_url('assets/upload/blog/').$blog->image; ?>">
                  </div>
                  <div class="blogcontents"><i class="fa fa-calendar"></i> <?php echo date('d M, Y', strtotime($blog->creation_date)); ?></div>
                  <div class="blogDesc">
                    <?php echo $blog->description ?>
                  </div>
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
         
 
 

      
    