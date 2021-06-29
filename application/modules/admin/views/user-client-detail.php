<?php 
// print_r($profile);
$searchtext = '';
if(!empty($_GET['search'])){
  $searchtext = $_GET['search'];
}

?>

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
  ul.home-cat{
    padding-inline-start:  20px;
  }
  .home-cat li{
    list-style: square;
  }
  projecttitle, .maintitle{
    font-size: 20px;
  }
</style>

<div class="content-wrapper">
  <div class="page-title">
    <div style="width: 100%">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-uppercase"> 
              <i class="fa fa-user"></i> User Client Detail
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
                  <div class="table-responsive">
                    <table id="userprofile" class="table table-striped">
                        <tr>
                          <th colspan="3" style="background-color: #000; color: #fff;">User Detail</th>
                        </tr>

                        <tr>                          
                          <th>User Name</th>
                          <td><?php echo $client->u_name.'(<small><b>'.$client->user_code.'</b></small>)';  ?> </td>
                        </tr>
                        <tr>                          
                          <th>User Email</th>
                          <td  ><?php echo $client->u_email;  ?> </td>
                        </tr>                        
                         <tr>
                          <th colspan="3" style="background-color: #000; color: #fff;">Client Detail</th>
                        </tr>
  
  <tr>                          
                          <th>Client Code</th>
                          <td  >#<?php echo $client->unique_code;  ?> </td>
                        </tr> 
                        <tr>                          
                          <th>Company Name</th>
                          <td  ><?php echo $client->company_name;  ?> </td>
                        </tr> 

                        <tr>                          
                          <th>Client Fee</th>
                          <td  ><?php echo $client->client_fee;  ?>% </td>
                        </tr>

                        <tr>                          
                          <th>Name</th>
                          <td><?php echo $client->name;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Surname</th>
                          <td  ><?php echo $client->surname;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Address Line-1</th>
                          <td  ><?php echo $client->address_line1;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Address Line-2</th>
                          <td  ><?php echo $client->address_line2;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Zipcode</th>
                          <td  ><?php echo $client->pincode;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>City</th>
                          <td  ><?php echo $client->city;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Country</th>
                          <td  ><?php echo $client->country;  ?> </td>
                        </tr>
                        <tr>                          
                          <th>Vat/Tin Number</th>
                          <td  ><?php echo $client->vat_tin_number;  ?> </td>
                        </tr>
                        <tr>                          
                          <th>Email</th>
                          <td  ><?php echo $client->email;  ?> </td>
                        </tr>
                       
                        <tr>                          
                          <th>Telephone</th>
                          <td  ><?php echo $client->telephone;  ?> </td>
                        </tr>
                        <tr>                          
                          <th>Mobile No</th>
                          <td  ><?php echo $client->mobile_no;  ?> </td>
                        </tr>
                        
                        <tr>                          
                          <th>Internal Notes</th>
                          <td  ><?php echo $client->internal_notes;  ?> </td>
                        </tr>
                        <tr>                          
                          <th>Kleinunternehmer Vat</th>
                          <td><?php echo $client->kvat ? 'Yes ('.$client->kvat_percent.'%)' : 'No';  ?> </td>
                        </tr>

                         <tr>
                          <th colspan="3" style="background-color: #000; color: #fff;">Shipping Detail</th>
                        </tr>

                        <tr>                          
                          <th>Company Name</th>
                          <td><?php echo $client->shipping_company_name;  ?> </td>
                        </tr> 
 
                        <tr>                          
                          <th>Name</th>
                          <td><?php echo $client->shipping_name;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Surname</th>
                          <td  ><?php echo $client->shipping_surname;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Address Line-1</th>
                          <td  ><?php echo $client->shipping_address_line1;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Address Line-2</th>
                          <td  ><?php echo $client->shipping_address_line2;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>Zipcode</th>
                          <td  ><?php echo $client->shipping_pincode;  ?> </td>
                        </tr>

                        <tr>                          
                          <th>City</th>
                          <td  ><?php echo $client->shipping_city;  ?> </td>
                        </tr>

                         
                        <tr>                          
                          <th>Date</th>
                          <td  ><?php echo date('d M, Y', strtotime($client->creation_date));  ?> </td>
                        </tr> 
                       
             
                    </table>
                 
                  </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalAccountActive">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title"><span id="enablesp"></span> Account</h4>
      </div> 
      <div class="modal-body">
        <form name="formAccountActive" id="formAccountActive">
          <div class="form-group">
            <h3 class="text-center">Are you sure, you want to <span id="acmsg"></span> this user account?</h3>
            <input type="hidden" class="form-control" id="accountactive" name="accountactive">
            <input type="hidden" class="form-control" id="accountactiveusrid" name="accountactiveusrid">
          </div> 
          <div id="enblemsg"></div>
          <center><button type="submit" class="btn btn-primary">Submit</button></center>
        </form>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalAccountStatus">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title"><span id="statussp"></span> Account</h4>
      </div> 
      <div class="modal-body">
        <form name="formAccountStatus" id="formAccountStatus">
          <div class="form-group">
            <h3 class="text-center">Are you sure, you want to <span id="statusmsg"></span> this user account?</h3>
            <input type="hidden" class="form-control" id="accountstatus" name="accountstatus">
            <input type="hidden" class="form-control" id="accountstatususrid" name="accountstatususrid">
          </div> 
          <div class="clearfix" id="rstatusmsg"></div>
          <center><button type="submit" class="btn btn-primary">Submit</button></center>
        </form>
      </div> 
      <div class="modal-footer">        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="modalDeleteAccount">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h4 class="modal-title">Delete Account</h4>
      </div> 
      <div class="modal-body">
        <form name="formAccountdelete" id="formAccountdelete">
          <div class="form-group">
            <h3 class="text-center" style="color: #f00;">Are you sure, you want to delete this user account?</h3>
            <input type="text" class="form-control" id="deleteusrid" name="deleteusrid">
          </div> 
          <div class="clearfix" id="rstatusmsg"></div>
          <center><button type="submit" class="btn btn-primary">Delete</button></center>
        </form>
      </div> 
      <div class="modal-footer">        
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  // shortdesc longdesc 

  function myProjectDescription(thisobj, data){

    if(data == "1"){
      $(thisobj).parent().hide();
      $(thisobj).parent().parent().find('.longdesc').show();
    }
    else if(data == "2"){
      $(thisobj).parent().parent().find('.shortdesc').show();
      $(thisobj).parent().hide();
    }
  }
</script>
 <script type="text/javascript">


 function printDiv() 
{

  var divToPrint=document.getElementById('userprofile');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}

    
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
         
 
 

      
    