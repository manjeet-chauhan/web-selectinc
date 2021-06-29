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
          <i class="fa fa-image"></i> Banner 
          <button data-toggle="modal" data-target="#modalAddBanner" class="btn btn-sm btn-primary pull-right"> ADD BANNER</button>
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <div class="row">
              <div class=" col-md-12">
                 <div class="table-responsive">
                   <table class="table">
                      <thead>
                         <tr>
                           <th>#</th>
                           <th>BANNER</th>
                           <th>TITLE/SUBTITLE </th>
                           <th>EDIT</th>
                           <th>DELETE</th>
                         </tr>
                      </thead>
                      <?php 
                    if(!empty($banners)){
                      $count = 0;
                      foreach ($banners as $banner) {
                    ?>
                      <tr>
                        <td> <?php echo ++$count; ?></td>
                        <td><img style="height: 50px; width: auto;"  src="<?php echo base_url('assets/upload/banner/').$banner->image ?>" alt="profile image" class="card-img-top"></td>
                        <td>
                          <div><b>Title:</b> <?php echo strip_tags($banner->title)  ?></div>
                          <div><b>Subtitle:</b> <small><?php echo strip_tags($banner->sub_title); ?></small></div>
                        </td>

                        
                        <td>
                          <button  type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#modalEditBanner' 
                          data-id="<?php echo $banner->id; ?>"  
                          data-title="<?php echo base64_encode($banner->title); ?>"  
                          data-subtitle="<?php echo base64_encode($banner->sub_title); ?>"
                          onclick="
                          $('#txeditid').val($(this).attr('data-id')); 
                          $('#txeditttitle').val(atob($(this).attr('data-title'))); 
                          $('#txteditsubtitle').val(atob($(this).attr('data-subtitle'))); 
                          "><i class="fa fa-pencil-square-o"></i> EDIT</button>
                        </td>
                        <td> 
                        <button  type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modalDeleteBanner' data-id="<?php echo $banner->id; ?>"  onclick="$('#txtdelid').val($(this).attr('data-id'))"  ><i class="fa fa-trash"></i> DELETE</button></td>
                      </tr>
                    <?php
                      }
                    }else{
                    ?>
                      
                    <?php
                    }
                    ?>
                   </table>
                 </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div id="modalAddBanner" class="modal fade" role="dialog">
  <div class="modal-dialog">
 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Banner</h4>
      </div>
      <div class="modal-body">
         <form method="POST" id="FormAddBanner" name="FormAddBanner" enctype="multipart/form-data" >
            <div class="form-group">
              <label for="email">Title:</label>
              <input type="text" class="form-control" id="txttitle" name="txttitle" >
            </div>

            <div class="form-group">
              <label for="email">Subtitle:</label>
              <input type="text" class="form-control" id="txtsubtitle" name="txtsubtitle" >
            </div>

            <div class="form-group">
              <label for="email">Banner Image:</label>
              <input type="file" class="form-control" id="bannerimage" name="bannerimage">
            </div> 

              <div id="retmsg"></div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">SUBMIT</button>
              </div>
          </form>
      </div>
  
    </div>

  </div>
</div>


<div id="modalEditBanner" class="modal fade" role="dialog">
  <div class="modal-dialog">
 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Banner</h4>
      </div>
      <div class="modal-body">
         <form method="POST" id="FormEditBanner" name="FormEditBanner" enctype="multipart/form-data">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="hidden" class="form-control" id="txeditid" name="txeditid" >
              <input type="text" class="form-control" id="txeditttitle" name="txeditttitle" >
            </div>

            <div class="form-group">
              <label for="subtitle">Subtitle:</label>
              <input type="text" class="form-control" id="txteditsubtitle" name="txteditsubtitle" >
            </div>

            <div class="form-group">
              <label for="image">Banner Image:</label>
              <input type="file" class="form-control" id="bannereditimage" name="bannereditimage">
            </div>
 
              <div id="reteditmsg"></div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">SAVE BANNER</button>
              </div>
          </form>
      </div>
    </div>
  </div>
</div>

 <div id="modalDeleteBanner" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="FormDeleteBanner" name="FormDeleteBanner">
        <div class="modal-body">
          <div class="create-new">
               <div class="col-md-12">
                  <h3 class="text-center"> Are you sure, you want to delete this Banner? </h3>
                  <input type="hidden" name="txtdelid" id="txtdelid">
               </div>
               <div class="clearfix"></div>
           </div>
            <div id="retdeletemsg"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"  id="save_btn">Delete</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>

  </div>
</div>

 <script type="text/javascript"> 
    $('#FormAddBanner').on('submit', function(e){       
        e.preventDefault();

        $('#retmsg').removeClass(' alert alert-info');
        $('#retmsg').removeClass(' alert alert-success');
        $('#retmsg').removeClass(' alert alert-danger');

        

        $('#retmsg').html('Please wait');
        $('#retmsg').show().delay(5000).fadeOut();
        $('#retmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/add-banner'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#retmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#retmsg').html('Banner added successfully.');
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
                  $('#retmsg').html('Error to add banner, retry');
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


    $('#FormEditBanner').on('submit', function(e){       
        e.preventDefault();

        $('#reteditmsg').removeClass(' alert alert-info');
        $('#reteditmsg').removeClass(' alert alert-success');
        $('#reteditmsg').removeClass(' alert alert-danger');
 
        $('#reteditmsg').html('Please wait');
        $('#reteditmsg').show().delay(5000).fadeOut();
        $('#reteditmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/update-banner'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#reteditmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#reteditmsg').html('Banner saved successfully.');
                    $('#reteditmsg').show().delay(5000).fadeOut();
                    $('#reteditmsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }
 
                if(data == "error"){
                  $('#reteditmsg').html('Error to save banner, retry');
                  $('#reteditmsg').show().delay(5000).fadeOut();
                  $('#reteditmsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#reteditmsg').html(data);
                $('#reteditmsg').show().delay(5000).fadeOut();
                $('#reteditmsg').addClass(' alert alert-danger');
            }
        });
    });


    $('#FormDeleteBanner').on('submit', function(e){       
      e.preventDefault();

      $('#retdeletemsg').removeClass(' alert alert-info');
      $('#retdeletemsg').removeClass(' alert alert-success');
      $('#retdeletemsg').removeClass(' alert alert-danger');

      $('#retdeletemsg').html('Please wait');
      $('#retdeletemsg').show().delay(5000).fadeOut();
      $('#retdeletemsg').addClass(' alert alert-info');
      // $('#myloader').show();
      $.ajax({
          url: '<?php echo base_url('admin/delete-banner'); ?>',
          type: "POST",
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          async: true,
          success: function (data) { 

              $('#retdeletemsg').removeClass(' alert alert-info');
              if(data == "success"){
                  $('#retdeletemsg').html('Banner deleted successfully.');
                  $('#retdeletemsg').show().delay(5000).fadeOut();
                  $('#retdeletemsg').addClass(' alert alert-success');
                   location.reload();
                  return true;
              }

              if(data == "error"){
                $('#retdeletemsg').html('Error to delete banner, retry');
                $('#retdeletemsg').show().delay(5000).fadeOut();
                $('#retdeletemsg').addClass(' alert alert-danger');
                return false;
              }
              
              $('#retdeletemsg').html(data);
              $('#retdeletemsg').show().delay(5000).fadeOut();
              $('#retdeletemsg').addClass(' alert alert-danger');
          }
      });
  });


    
  </script>
         
 
 

      
