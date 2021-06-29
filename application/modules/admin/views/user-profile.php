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
              <i class="fa fa-user"></i> User Profile
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
                          <th colspan="3" style="background-color: #000; color: #fff;">Profile Detail</th>
                        </tr>
                        
                        <tr>
                          <th>Name</th>
                          <td ><?php echo $profile->name;  ?> </td>

                           <td rowspan="3">

                              <?php 
                                $profile_img = base_url('assets/expertsend/images/faces/1.jpg'); 
                                if(!empty($profile)){
                                  $profile_img = base_url('assets/upload/images/').$profile->image;
                                }
                                ?>
                              <div class="profileimgcont">
                               <center>
                                  <img  src="<?php echo $profile_img; ?>"/>
                               </center>
                              </div>
                          </td>
                        </tr>
 
                        <tr>
                          <?php 
                            $verify = "<span style='color:#f00'><i class='fa fa-unlock-alt'></i> </span>";
                            if($profile->verify_email == 1){
                              $verify = "<span style='color:green'> <i class='fa fa-lock'></i> </span>";
                            }
                          ?>
                          <th>Email Id</th>
                          <td  ><?php echo $verify. " ". $profile->email;  ?> </td>
                        </tr>

                         <tr>
                          <?php 
                            $verify = "<span style='color:#f00'><i class='fa fa-unlock-alt'></i> </span>";
                            if($profile->phone_verify == 1){
                              $verify = "<span style='color:green'> <i class='fa fa-lock'></i> </span>";
                            }
                          ?>
                          <th>Contact No</th>
                          <td >
                            <?php echo $verify . " ".  $profile->phone;  ?> 
                            <?php 
                              if(!empty($profile))
                                if($profile->phone_verify == 1){
                              ?>
                              <p><img src="<?php echo base_url('assets/expertsend/') ?>images/verified.png" alt="Verified Icon" /></p>
                              <?php 
                                }
                              ?>
                          </td>
                        </tr>
 
                        <tr>
                          <th>Address</th>
                          <td colspan="2"><?php echo $profile->address;  ?> </td>
                        </tr>
                      
                        <tr>
                          <th>City</th>
                          <td colspan="2"><?php echo $profile->city;  ?> </td>
                        </tr>
                        <tr>
                          <th>State</th>
                          <td colspan="2"><?php echo $profile->state;  ?> </td>
                        </tr>
                        <tr>
                          <th>Country</th>
                          <td colspan="2"> <?php echo $profile->country;?>
                          </td>
                        </tr>
                        <tr>
                          <th>Zipcode</th>
                          <td colspan="2"><?php echo $profile->zipcode;  ?> </td>
                        </tr>
                            
                        <tr>
                          <th>ACCOUNT</th>
                          <td colspan="2">
                            <?php 
                                
                              $status = "Deactive";
                              $sbcls = "btn btn-danger btn-sm";
                              $scls = "danger";
                              if($profile->status == 1){
                                $status = "&nbsp;&nbsp;Active&nbsp;&nbsp;";
                                $sbcls = "btn btn-info btn-sm";
                                $scls = "";
                              } 
                            ?>
                           
                             <button class=" <?php echo $sbcls; ?>"><?php echo $status  ?></button> 
                          </td>
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
         
 
 

      
    