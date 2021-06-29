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
</style>

<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <div class="row">
        <div class="col-md-8">
          <h1 class="text-uppercase"> 
           Invoices For Approval
          </h1>
        </div>
        <div class="col-md-4">
           <form>
             <input type="text" class="form-control input-sm" name="search" id="search" placeholder="Search..." value="<?php echo $searchtext; ?>">
           </form>
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
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>ISSIE ID</th>
                          <th>INVOICE NO.</th>                         
                          <th>MODEL BUDGET</th>
                          <th>AGREED BUDGET</th>
                           <th>USER INFO</th> 
                          <th>CLIENT INFO</th>
                          <th>MODEL INFO</th>
                          <!-- <th>EMAIL</th>                          
                          <th>ADDRESS</th>  -->                         
                          <th class="text-center">ACTION</th> 
                        </tr>
                      </thead> 
                      <tbody>

                        <?php 
                        $totalcount = 0;
                        if(!empty($invoices)){
                          $totalcount = count($invoices);
                        }
                        ?>
                        <input type="hidden" name="txtcounttotal" id="txtcounttotal" value="<?php echo $totalcount; ?>">
                          <?php 
                          

                          if(!empty($invoices)){
                            $count = 0;
                            foreach ($invoices as $invoice) {
                              $redirectUrl = base_url('admin/invoice-details/').$invoice->invoice_number;
                          ?>

                            <tr >
                                <th><?php echo ++$count; ?></th>
                                <td> #<?php echo $invoice->issue_id; ?></td>
                                <td> <?php echo $invoice->invoice_number; ?></td>
                                <td> <?php echo $invoice->model_budget ? '€'.$invoice->model_budget : '-'; ?> </td>
                                <td> <?php echo $invoice->model_total_agreed ? '€'.$invoice->model_total_agreed : '-'; ?> </td>

                                 <td> 
                                  <strong><?php echo $invoice->user_name; ?></strong>
                                  <!-- <div><small><strong>Client Fee : <?php echo $invoice->client_fee; ?>% </strong></small></div> -->
                                  <div style="color:#259cf1;" ><small><b><i style=" font-size: 12px;" class="fa fa-envelope"></i> <?php echo $invoice->user_email ?></b></small></div>
                                </td>

                                <td> 
                                  <strong><?php echo $invoice->company_name; ?></strong>
                                  <div><small><strong>Client Fee : <?php echo $invoice->client_fee; ?>% </strong></small></div>
                                  <div style="color:#259cf1;" ><small><b>Name : <?php echo $invoice->client_name ?></b></small></div>
                                </td>
                                <td> 
                                  <strong><?php echo $invoice->model_name; ?></strong>
                                  <div><small><strong>Service Fee :  <?php echo $invoice->service_fee; ?>% </strong></small></div>                                  
                                </td>

                                <td>
                                  <button data-invoice="<?php echo $invoice->invoice_number; ?>" data-toggle="modal" data-target="#modalApproveInvoives"  class="btn btn-warning btn-sm btn-block" onclick="$('#invoive_id').val($(this).attr('data-invoice'));"><i class="fa fa-info"></i> APPROVE</button>
                                  <a href="<?php echo $redirectUrl; ?>" class="btn btn-info btn-sm btn-block"><i class="fa fa-info"></i> DETAILS</a>
                                </td>
                                  
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


<div class="modal" id="modalApproveInvoives">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title"> INVOICE APPROVAL</h4>
      </div> 
      <form name="formApproveInvoice" id="formApproveInvoice">
        <div class="modal-body">          
            <div class="form-group">
              <h3 class="text-center">Are you sure, you want to  approve this invoice?</h3>
              <input type="hidden" class="form-control" id="invoive_id" name="invoive_id">
            </div> 
            <div id="enblemsg"></div>
        </div> 
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal" id="modalAccountActive">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title"><span id="enablesp"></span> Account</h4>
      </div> 
      <form name="formAccountActive" id="formAccountActive">
        <div class="modal-body">          
            <div class="form-group">
              <h3 class="text-center">Are you sure, you want to <span id="acmsg"></span> this user account?</h3>
              <input type="hidden" class="form-control" id="accountactive" name="accountactive">
              <input type="hidden" class="form-control" id="accountactiveusrid" name="accountactiveusrid">
            </div> 
            <div id="enblemsg"></div>
        </div> 
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div class="modal" id="modalAccountStatus">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title"><span id="statussp"></span> Account</h4>
      </div>
      <form name="formAccountStatus" id="formAccountStatus"> 
        <div class="modal-body">
          
            <div class="form-group">
              <h3 class="text-center">Are you sure, you want to <span id="statusmsg"></span> this user account?</h3>
              <input type="hidden" class="form-control" id="accountstatus" name="accountstatus">
              <input type="hidden" class="form-control" id="accountstatususrid" name="accountstatususrid">
            </div> 
            <div class="clearfix" id="rstatusmsg"></div>
        </div> 
        <div class="modal-footer">   
        <button type="submit" class="btn btn-primary">Submit</button>     
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal" id="modalDeleteAccount">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title">Delete Account</h4>
      </div> 
      <form name="formAccountdelete" id="formAccountdelete">
        <div class="modal-body">
          
            <div class="form-group">
              <h3 class="text-center" style="color: #f00;">Are you sure, you want to delete this user account?</h3>
              <input type="hidden" class="form-control" id="deleteusrid" name="deleteusrid">
            </div> 
            <div class="clearfix" id="rstatusmsg"></div>
          
        </div> 
        <div class="modal-footer">  
        <button type="submit" class="btn btn-primary">Delete</button>      
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal" id="modalProfileApproveAccount">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title">APPROVE PROFILE</h4>
      </div> 
      <form name="formAccountapproval" id="formAccountapproval">
        <div class="modal-body">
          
            <div class="form-group">
              <h3 class="text-center">Are you sure, you want to approve this user account?</h3>
              <input type="hidden" class="form-control" id="approveusrid" name="approveusrid">
            </div> 
            <div class="clearfix" id="appstatusmsg"></div>
            
        </div> 
        <div class="modal-footer"> 
        <button type="submit" class="btn btn-primary">APPROVE</button>       
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal" id="modalTestUserPassed">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title">MARK TEST PASS</h4>
      </div> 
      <form name="formTestUserPass" id="formTestUserPass">
        <div class="modal-body">
          
            <div class="form-group">
              <h3 class="text-center">Are you sure, you want to mark this user to test passed?</h3>
              <input type="hidden" class="form-control" id="testuserid" name="testuserid">
            </div> 
            <div id="testpss"></div>
            
        </div> 
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="mypagination">
  <button href="" data-click="1" class="btn btn-danger btn-sm"> <i class="fa fa-backward"></i> &nbsp; PREV</button>
  <button href="" data-click="2" class="btn btn-danger btn-sm"> NEXT <i class="fa fa-forward"> &nbsp; </i></button>
</div>

 <script type="text/javascript">



   $('#formApproveInvoice').on('submit', function(e){       
        e.preventDefault();

        $('#retmsg').removeClass(' alert alert-info');
        $('#retmsg').removeClass(' alert alert-success');
        $('#retmsg').removeClass(' alert alert-danger');

        
        $('#retmsg').html('Please wait');
        $('#retmsg').show().delay(5000).fadeOut();
        $('#retmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/approve-user-invoice'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#retmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#retmsg').html('Profile saved successfully.');
                    $('#retmsg').show().delay(5000).fadeOut();
                    $('#retmsg').addClass(' alert alert-success');
                     location.reload();
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





    
    $('#adminprofile').on('submit', function(e){       
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
            url: '<?php echo base_url('admin/update-profile'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#retmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#retmsg').html('Profile saved successfully.');
                    $('#retmsg').show().delay(5000).fadeOut();
                    $('#retmsg').addClass(' alert alert-success');
                     location.reload();
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

 
    $('#formAccountActive').on('submit', function(e){       
        e.preventDefault();

        $('#enblemsg').removeClass(' alert alert-info');
        $('#enblemsg').removeClass(' alert alert-success');
        $('#enblemsg').removeClass(' alert alert-danger');


        $('#enblemsg').html('Please wait');
        $('#enblemsg').show().delay(5000).fadeOut();
        $('#enblemsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/users-enable'); ?>',
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

     $('#formAccountStatus').on('submit', function(e){       
        e.preventDefault();

        $('#rstatusmsg').removeClass(' alert alert-info');
        $('#rstatusmsg').removeClass(' alert alert-success');
        $('#rstatusmsg').removeClass(' alert alert-danger');


        $('#rstatusmsg').html('Please wait');
        $('#rstatusmsg').show().delay(5000).fadeOut();
        $('#rstatusmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/users-status'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#rstatusmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#rstatusmsg').html('Change successfully.');
                    $('#rstatusmsg').show().delay(5000).fadeOut();
                    $('#rstatusmsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }
                if(data == "error"){
                  $('#rstatusmsg').html('Error to change, retry');
                  $('#rstatusmsg').show().delay(5000).fadeOut();
                  $('#rstatusmsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#rstatusmsg').html(data);
                $('#rstatusmsg').show().delay(5000).fadeOut();
                $('#rstatusmsg').addClass(' alert alert-danger');
            }
        });
    });



    $('#formAccountdelete').on('submit', function(e){       
        e.preventDefault();

        $('#delmsg').removeClass(' alert alert-info');
        $('#delmsg').removeClass(' alert alert-success');
        $('#delmsg').removeClass(' alert alert-danger');


        $('#delmsg').html('Please wait');
        $('#delmsg').show().delay(5000).fadeOut();
        $('#delmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/users-delete-account'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#delmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#delmsg').html('Successfully deleted.');
                    $('#delmsg').show().delay(5000).fadeOut();
                    $('#delmsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }
                if(data == "error"){
                  $('#delmsg').html('Error to delete account, retry');
                  $('#delmsg').show().delay(5000).fadeOut();
                  $('#delmsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#delmsg').html(data);
                $('#delmsg').show().delay(5000).fadeOut();
                $('#delmsg').addClass(' alert alert-danger');
            }
        });
    });




    $('#formAccountapproval').on('submit', function(e){       
        e.preventDefault();

        $('#appstatusmsg').removeClass(' alert alert-info');
        $('#appstatusmsg').removeClass(' alert alert-success');
        $('#appstatusmsg').removeClass(' alert alert-danger');


        $('#appstatusmsg').html('Please wait');
        $('#appstatusmsg').show().delay(5000).fadeOut();
        $('#appstatusmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/users-approve-account'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#appstatusmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#appstatusmsg').html('Successfully Approved.');
                    $('#appstatusmsg').show().delay(5000).fadeOut();
                    $('#appstatusmsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }
                if(data == "error"){
                  $('#appstatusmsg').html('Error to approve account, retry');
                  $('#appstatusmsg').show().delay(5000).fadeOut();
                  $('#appstatusmsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#appstatusmsg').html(data);
                $('#appstatusmsg').show().delay(5000).fadeOut();
                $('#appstatusmsg').addClass(' alert alert-danger');
            }
        });
    });



     $('#formTestUserPass').on('submit', function(e){       
        e.preventDefault();

        $('#testpss').removeClass(' alert alert-info');
        $('#testpss').removeClass(' alert alert-success');
        $('#testpss').removeClass(' alert alert-danger');


        $('#testpss').html('Please wait');
        $('#testpss').show().delay(5000).fadeOut();
        $('#testpss').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('admin/paanduv-test-pass-mark'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#testpss').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#testpss').html('Successfully deleted.');
                    $('#testpss').show().delay(5000).fadeOut();
                    $('#testpss').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }
                if(data == "error"){
                  $('#testpss').html('Error to delete account, retry');
                  $('#testpss').show().delay(5000).fadeOut();
                  $('#testpss').addClass(' alert alert-danger');
                  return false;
                }

                $('#testpss').html(data);
                $('#testpss').show().delay(5000).fadeOut();
                $('#testpss').addClass(' alert alert-danger');
            }
        });
    });


    $(function(){
        $("#search").keyup(function () {
            var value = this.value.toLowerCase().trim();
            $("table tr").each(function (index) {
                if (!index) return;
                $(this).find("td").each(function () {
                    var id = $(this).text().toLowerCase().trim();
                    var not_found = (id.indexOf(value) == -1);
                    $(this).closest('tr').toggle(!not_found);
                    return not_found;
                });
            });
        });


        $('.mypagination button').click(function(){

            var records = 25;
            var ret_data = $('#txtcounttotal').val();
            if(ret_data == ""){
              ret_data = 0;
            }
            ret_data = parseInt(ret_data);

            var dataClick = $(this).attr('data-click');
            var searchtext = getUrlVars()['search'];
            if(typeof(searchtext) == "undefined"){
              searchtext = '';
            }

            var pageno = getUrlVars()['page'];
            if(typeof(pageno) == "undefined"){
              pageno = 0;
            }

            pageno = parseInt(pageno);
            if(parseInt(dataClick) == 1){
              pageno = pageno - 1;
              if(pageno < 0){
                pageno = 0;
              }
            }
            else if(parseInt(dataClick) == 2){
              pageno = pageno + 1;
              if(ret_data < records){
                return false;
              }
            }
             
            var redirectUrl = '<?php echo base_url('admin/users') ?>?search='+searchtext+"&page="+pageno;
            window.location.href = redirectUrl;
        });

        $('.accountbtn').click(function(){
            var ac_status = 1;
            var ac_activetext = " Enable ";
            var cr_ac_status = $(this).attr('data-active');
            if(cr_ac_status == 1){
              ac_status = 0;
              ac_activetext = " Disable ";
            }
            $('#accountactiveusrid').val($(this).attr('data-id'));
            $('#accountactive').val(ac_status);
            $('#acmsg').html(ac_activetext);
            $('#enablesp').html(ac_activetext); 
        });


         $('.accountstatbtn').click(function(){
            var ac_status = 1;
            var ac_activetext = " Active ";
            var cr_ac_status = $(this).attr('data-status');
            if(cr_ac_status == 1){
              ac_status = 0;
              ac_activetext = " Deactive ";
            }
            $('#accountstatususrid').val($(this).attr('data-id'));
            $('#accountstatus').val(ac_status);
            $('#statussp').html(ac_activetext);
            $('#statusmsg').html(ac_activetext);  
        })

    })

    function getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
      function(m,key,value) {
        vars[key] = value;
      });
      return vars;
    }
    
</script>
         
 
 

      
    