<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <h1 class="text-uppercase"> 
          BLOG <a href="<?php echo base_url('admin/add-blog'); ?>" class="btn btn-sm btn-primary pull-right">ADD BLOG </a>
      </h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="contents">
            <div class="row">
              <div class="col-md-12">

               <div class="table-responsive">
                 <table class="table">
                   <thead>
                     <tr>
                       <th>SL</th>
                       <th>TITLE</th>
                       <th>DATE</th>
                       <th>VIEW</th>
                       <th>EDIT</th>
                       <th>DELETE</th>
                     </tr>
                   </thead>
                   <tbody>
                    <?php 
                    if(!empty($blogs)){
                      $count = 0;
                     foreach ($blogs as $blog) {
                      $redirect_view = base_url('admin/view-blog/').$blog->blog_id;
                      $redirect_edit = base_url('admin/edit-blog/').$blog->blog_id;
                    ?>
                    <tr>
                       <td><?php echo ++$count; ?></td>
                       <td><?php echo $blog->title; ?></td>
                       <td><?php echo date('d M, Y', strtotime($blog->creation_date)); ?></td>
                       <td><a href="<?php echo $redirect_view ?>" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a></td>
                       <td><a href="<?php echo $redirect_edit ?>" class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o"></i></a></td>
                       <td><button data-toggle="modal" data-target="#modalDeleteBlog" data-blog="<?php echo $blog->blog_id; ?>" class="btn btn-sm btn-danger" onclick="$('#txtblogid').val($(this).attr('data-blog'))"><i class="fa fa-trash"></i></button></td>
                     </tr>
                    <?php
                      }
                    }
                    ?>
                     
                   </tbody>
                 </table>
               </div>     

               
            </div>
            </div>  
        </div>
      </div>
    </div>
  </div>
</div>


<div id="modalDeleteBlog" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Blog</h4>
      </div>
      <form name="FormAddData" id="FormAddData">
        <div class="modal-body">
          
             <input type="hidden" name="txtblogid" id="txtblogid">
             <center><h3>Are you sure, you want to delete this blog?</h3><br> </center>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"> Delete Blog</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
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
            url: '<?php echo base_url('admin/delete-blog'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#retmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#retmsg').html('Deleted successfully.');
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
 
 

      
    