<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <h1 class="text-uppercase"> 
          FOOTER  
          <!-- <a href="<?php echo base_url('admin/add-publication'); ?>" class="btn btn-sm btn-primary pull-right">ADD PUBLICATION </a> -->
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
                       <th>PAGES</th>
                       <th>ADD PAGE</th>
                       <!-- <th>VIEW PAGES</th> -->
                       <th>EDIT</th>
                       <!-- <th>DELETE</th> -->
                     </tr>
                   </thead>
                   <tbody>
                    <?php 
                    if(!empty($footers)){
                      $count = 0;
                     foreach ($footers as $footer) {
                      $redirect_add = base_url('admin/add-footer-page/').$footer->footer_id;
                      $redirect_edit = base_url('admin/edit-footer-page/').$footer->footer_id;
                    ?>
                    <tr>
                       <td><?php echo ++$count; ?></td>
                       <td><?php echo $footer->name; ?></td>
                       <td>
                        <?php
                        $pages = get_footer_navigate_pages($footer->id); 
                        // print_r($pages);
                        if(!empty($pages)){
                        ?>
                        <table class="table">
                          <tr>
                            <th>NAME</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                          </tr>
                        <?php
                          foreach ($pages as $page) {
                            $editpage = base_url('admin/edit-footer-page/').$page->page_id;
                          ?>
                          <tr>
                            <td><?php echo  $page->footer_link_name ?></td>
                            <td><a href="<?php echo $editpage; ?>" class="btn btn-sm btn-success">EDIT</a></td>
                            <td><button data-toggle="modal" data-target="#modalDeletePage" data-id="<?php echo $page->id ?>" onclick="$('#txtdelpageid').val($(this).attr('data-id'))">DELETE</button></td>
                          </tr>
                          <?php
                          }
                        ?>
                        </table>
                        <?php
                        }
                        ?>
                          
                        </td>
                       <td><a href="<?php echo $redirect_add ?>" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> ADD PAGE</a></td>

                       <td><a href="#" data-toggle="modal" data-target="#modalEditFooter" class="btn btn-sm btn-success" data-id="<?php echo $footer->id; ?>" data-name="<?php echo $footer->name; ?>" onclick="$('#txteditfooterid').val($(this).attr('data-id')); $('#txteditfootername').val($(this).attr('data-name'))" ><i class="fa fa-pencil-square-o"></i></a></td>

                       <!-- <td><button data-toggle="modal" data-target="#modalDeletepublication" data-publication="<?php echo $footer->footer_id; ?>" class="btn btn-sm btn-danger" onclick="$('#txtpublicationid').val($(this).attr('data-publication'))"><i class="fa fa-trash"></i></button></td> -->
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

<div id="modalEditFooter" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Footer Name</h4>
      </div>
      <form name="FormEditData" id="FormEditData">
        <div class="modal-body">
          <input type="hidden" name="txteditfooterid" id="txteditfooterid">
          <label>NAME</label>
          <input type="text" class="form-control" name="txteditfootername" id="txteditfootername">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"> SAVE </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">CLOSE</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div id="modalDeletePage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Page</h4>
      </div>
      <form name="FormDeletePage" id="FormDeletePage">
        <div class="modal-body">
          
             <input type="hidden" name="txtdelpageid" id="txtdelpageid">
             <center><h3>Are you sure, you want to delete this page?</h3><br> </center>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"> Delete </button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div id="modalDeletepublication" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete publication</h4>
      </div>
      <form name="FormAddData" id="FormAddData">
        <div class="modal-body">
          
             <input type="hidden" name="txtpublicationid" id="txtpublicationid">
             <center><h3>Are you sure, you want to delete this publication?</h3><br> </center>
          
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

  $('#FormEditData').on('submit', function(e){       
        e.preventDefault();

        $('#tlmsg').removeClass(' alert alert-info');
        $('#tlmsg').removeClass(' alert alert-success');
        $('#tlmsg').removeClass(' alert alert-danger');

        

        $('#tlmsg').html('Please wait');
        $('#tlmsg').show().delay(5000).fadeOut();
        $('#tlmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/save-footer-title'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#tlmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#tlmsg').html('Deleted successfully.');
                    $('#tlmsg').show().delay(5000).fadeOut();
                    $('#tlmsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }

                if(data == "imageerror"){
                  $('#tlmsg').html('Banner image cannot be empty');
                  $('#tlmsg').show().delay(5000).fadeOut();
                  $('#tlmsg').addClass(' alert alert-danger');
                  return false;
                }

                if(data == "error"){
                  $('#tlmsg').html('Error to add, retry');
                  $('#tlmsg').show().delay(5000).fadeOut();
                  $('#tlmsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#tlmsg').html(data);
                $('#tlmsg').show().delay(5000).fadeOut();
                $('#tlmsg').addClass(' alert alert-danger');
            }
        });
    });


   $('#FormDeletePage').on('submit', function(e){       
        e.preventDefault();

        $('#retmsg').removeClass(' alert alert-info');
        $('#retmsg').removeClass(' alert alert-success');
        $('#retmsg').removeClass(' alert alert-danger');

        

        $('#retmsg').html('Please wait');
        $('#retmsg').show().delay(5000).fadeOut();
        $('#retmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/delete-footer-page'); ?>',
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
 
 

      
    