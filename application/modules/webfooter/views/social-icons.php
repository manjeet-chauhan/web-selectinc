<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <h1 class="text-uppercase"> 
          SOCIAL ICONS  
          <a href="#" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#modalAddIcon">ADD SOCIAL ICON </a>
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
                       <th>NAME</th>
                       <th>ICON</th>
                       <th>LINK</th>
                       <th>EDIT</th>
                       <th>DELETE</th>
                     </tr>
                   </thead>
                   <tbody>
                    <?php 
                    if(!empty($icons)){
                      $count = 0;
                     foreach ($icons as $icon) {
                    ?>
                    <tr>
                       <td><?php echo ++$count; ?></td>
                       <td><?php echo $icon->name; ?></td>
                       <td><?php echo $icon->icon; ?></td>
                       <td><?php echo $icon->link; ?></td>
                           
                       <td><a href="#" 
                        data-toggle="modal" 
                        data-target="#modalEditIcon" 
                        class="btn btn-sm btn-success" 
                        data-id="<?php echo $icon->id; ?>" 
                        data-name="<?php echo $icon->name; ?>" 
                        data-icon="<?php echo base64_encode($icon->icon); ?>" 
                        data-link="<?php echo  base64_encode($icon->link); ?>" 
                        onclick="
                        $('#txticonid').val($(this).attr('data-id')); 
                        $('#etxtname').val($(this).attr('data-name'))
                        $('#etxticon').val(atob($(this).attr('data-icon')));
                        $('#etxtlink').val(atob($(this).attr('data-link')));
                        " ><i class="fa fa-pencil-square-o"></i></a></td>

                       <td><button data-toggle="modal" data-target="#modalDeleteSocialicon" data-publication="<?php echo $icon->id; ?>" class="btn btn-sm btn-danger" onclick="$('#txtsocialicon').val($(this).attr('data-publication'))"><i class="fa fa-trash"></i></button></td>
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

<div id="modalAddIcon" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Icon</h4>
      </div>
      <form name="FormAddData" id="FormAddData">
        <div class="modal-body">
          <div class="form-group">
            <label for="email">Name</label>
            <input type="text" class="form-control" id="txtname" name="txtname">
          </div>
        
          <div class="form-group">
            <label for="email">Icon </label>
            <input type="text" class="form-control" id="txticon" name="txticon">
          </div>
  
          <div class="form-group">
            <label for="email">Link</label>
            <input type="text" class="form-control" id="txtlink" name="txtlink">
          </div>
          <div id="adddiv"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"> SAVE </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="modalEditIcon" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Icon</h4>
      </div>
      <form name="FormEditData" id="FormEditData">
        <div class="modal-body">
          <div class="form-group">
            <label for="email">Name</label> 
            <input type="hidden" class="form-control" id="txticonid" name="txticonid">
            <input type="text" class="form-control" id="etxtname" name="etxtname">
          </div>
        
          <div class="form-group">
            <label for="email">Icon </label>
            <input type="text" class="form-control" id="etxticon" name="etxticon">
          </div>
  
          <div class="form-group">
            <label for="email">Link</label>
            <input type="text" class="form-control" id="etxtlink" name="etxtlink">
          </div>
          <div id="editdiv"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"> SAVE </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modalDeleteSocialicon" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Social Icon</h4>
      </div>
      <form name="FormDeleteIcon" id="FormDeleteIcon">
        <div class="modal-body">          
            <input type="hidden" name="txtsocialicon" id="txtsocialicon">
            <center><h3>Are you sure, you want to delete this icon?</h3><br> </center>
            <div id="deldiv"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"> Delete </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

  $('#FormAddData').on('submit', function(e){       
        e.preventDefault();

        $('#adddiv').removeClass(' alert alert-info');
        $('#adddiv').removeClass(' alert alert-success');
        $('#adddiv').removeClass(' alert alert-danger');

        

        $('#adddiv').html('Please wait');
        $('#adddiv').show().delay(5000).fadeOut();
        $('#adddiv').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/add-social-icon'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#adddiv').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#adddiv').html('Saved successfully.');
                    $('#adddiv').show().delay(5000).fadeOut();
                    $('#adddiv').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }

                if(data == "error"){
                  $('#adddiv').html('Error to add, retry');
                  $('#adddiv').show().delay(5000).fadeOut();
                  $('#adddiv').addClass(' alert alert-danger');
                  return false;
                }

                $('#adddiv').html(data);
                $('#adddiv').show().delay(5000).fadeOut();
                $('#adddiv').addClass(' alert alert-danger');
            }
        });
    });


  $('#FormEditData').on('submit', function(e){       
        e.preventDefault();

        $('#editdiv').removeClass(' alert alert-info');
        $('#editdiv').removeClass(' alert alert-success');
        $('#editdiv').removeClass(' alert alert-danger');

        

        $('#editdiv').html('Please wait');
        $('#editdiv').show().delay(5000).fadeOut();
        $('#editdiv').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/save-social-icon'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#editdiv').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#editdiv').html('Saved successfully.');
                    $('#editdiv').show().delay(5000).fadeOut();
                    $('#editdiv').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }

                if(data == "error"){
                  $('#editdiv').html('Error to add, retry');
                  $('#editdiv').show().delay(5000).fadeOut();
                  $('#editdiv').addClass(' alert alert-danger');
                  return false;
                }

                $('#editdiv').html(data);
                $('#editdiv').show().delay(5000).fadeOut();
                $('#editdiv').addClass(' alert alert-danger');
            }
        });
    });


   $('#FormDeleteIcon').on('submit', function(e){       
        e.preventDefault();

        $('#deldiv').removeClass(' alert alert-info');
        $('#deldiv').removeClass(' alert alert-success');
        $('#deldiv').removeClass(' alert alert-danger');

        

        $('#deldiv').html('Please wait');
        $('#deldiv').show().delay(5000).fadeOut();
        $('#deldiv').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/delete-social-icon'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#deldiv').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#deldiv').html('Deleted successfully.');
                    $('#deldiv').show().delay(5000).fadeOut();
                    $('#deldiv').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }

                if(data == "error"){
                  $('#deldiv').html('Error to add, retry');
                  $('#deldiv').show().delay(5000).fadeOut();
                  $('#deldiv').addClass(' alert alert-danger');
                  return false;
                }

                $('#deldiv').html(data);
                $('#deldiv').show().delay(5000).fadeOut();
                $('#deldiv').addClass(' alert alert-danger');
            }
        });
    });
</script>
 
 

      
    