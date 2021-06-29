
<style type="text/css">
	.mypagination{
    position: fixed;
    bottom: 5%;
    right: 5%;
}
</style>
<!-- Start Dashboard -->

<section class="Dashboard">

	<div class="container">

		<div class="row">

			<div class="col-md-2">

				<?php include 'sidebar.php' ?>

			</div>

			<div class="col-md-10">

				<div class="DashboardContent">



					<div class="OpenTicket Box">

						<div class="BoxHeading">

							<h4>Model Management </h4>

						</div>

						<div class="ClientManagement">

							<form>
							<a href="<?php echo base_url('all-model-management') ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/teamwork.svg') ?>" alt="Icon"> All Model</button></a>



							<!-- <button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/funnel.svg'); ?>" alt="Icon"> Search / Filter</button> -->



							<a href="<?php echo base_url('add-model-management') ?>"><button type="button" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/contact.svg'); ?>" alt="Icon"> Add Model</button></a>



							<button type="button"  data-toggle="modal" data-target="#ModelImport" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/import.svg'); ?>" alt="Icon"> Import Model</button>

								<input type="text" name="search" class="form-controls" id="search" value="<?php echo $searchtext ?>">
								<button type="submit" class="btn bg-white btn-outline-primary"><img src="<?php echo base_url('assets/frontend/images/funnel.svg'); ?>" alt="Icon"> Search / Filter</button>
							</form>

						</div>

						<div class="Table">

							<table class="table table-striped">

								<thead>

									<tr>

										<th>#</th>
										<th>Model Name</th>

										<th>Full Name</th>

										<th>Address</th>

										<th>Service Fee</th>

										<!-- <th style="width: 10%;">View</th>

										<th style="width: 10%;">Edit</th> -->

									</tr>

								</thead>

								<tbody>


									<?php 
									$totalcount = 0;
			                        if(!empty($models)){
			                          $totalcount = count($models);
			                        }
			                        ?>
			                        <input type="hidden" name="txtcounttotal" id="txtcounttotal" value="<?php echo $totalcount; ?>">


									<?php 

									if(!empty($models)){

										$count = 100*$page;

										foreach ($models as $model) {



											$redirect_view = base_url('model-management-detail/').$model->unique_code;

											$redirect_edit = base_url('edit-model-management/').$model->unique_code;

									?>



									<tr onclick="window.location.href='<?php echo $redirect_edit; ?>'">
 										<th><?php echo ++$count; ?></th>
										<td><?php echo $model->model_name;  ?></td>

										<td><?php echo $model->name; ?></td>

										<td><?php echo $model->address_line1; ?></td>

										<td><?php echo $model->service_fee; ?>%  </td>

										<!-- <td><a href="<?php echo $redirect_view; ?>"><button type="button" class="btn"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a></td>

										<td><a href="<?php echo $redirect_edit; ?>"><button type="button" class="btn"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></a></td> -->

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

</section>

<!-- End Dashboard -->



<div id="ModelImport" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Import CSV File</h4>
      </div>
	     <form name="formImport" method="POST" enctype="multipart/form-data" action="<?php echo base_url('upload-modal-csv-data') ?>">
     	 <div class="modal-body">
	       <div class="form-group">
		    <label for="email">Select File(.csv):</label>
		    <input type="file" accept=".csv" class="form-control" id="clientcsv" name="clientcsv">
		  </div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Import</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
     </form>
    </div>

  </div>
</div>

<div class="mypagination">
  <button id="prev_btn" data-click="1" class="btn btn-danger btn-sm"> <i class="fa fa-backward"></i> &nbsp; PREV</button>
  <button id="next_btn" data-click="2" class="btn btn-danger btn-sm"> NEXT <i class="fa fa-forward"> &nbsp; </i></button>
</div>
<script type="text/javascript">
	
// $(document).ready(function(){
//   $("#myInput").on("keyup", function() {
//     var value = $(this).val().toLowerCase();
//     $("#myTable tr").filter(function() {
//       $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
//     });
//   });
// });



        // $("#search").keyup(function () {
        //     var value = this.value.toLowerCase().trim();
        //     $("table tbody tr").each(function (index) {
        //         if (!index) return;
        //         $(this).find("td").each(function () {
        //             var id = $(this).text().toLowerCase().trim();
        //             var not_found = (id.indexOf(value) == -1);
        //             $(this).closest('tr').toggle(!not_found);
        //             return not_found;
        //         });
        //     });
        // });

        $(function(){
          var records = 100;
            var ret_data = $('#txtcounttotal').val();
            if(ret_data == ""){
              ret_data = 0;
            }
            ret_data = parseInt(ret_data);

            var pageno = getUrlVars()['page'];
            if(typeof(pageno) == "undefined"){
              pageno = 0;
            }

            pageno = parseInt(pageno);
            $('#prev_btn, #next_btn').attr('disabled', false);

            if(ret_data < 100){
              $('#next_btn').attr('disabled', true);
            }
            if(pageno <= 0){
              $('#prev_btn').attr('disabled', true);
            }            
        });

        $('.mypagination button').click(function(){

            var records = 100;
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
            $('#prev_btn, #next_btn').attr('disabled', false);

            if(ret_data < 100){
              $('#next_btn').attr('disabled', true);
            }
            if(pageno <= 0){
              $('#prev_btn').attr('disabled', true);
            }

           
            if(parseInt(dataClick) == 1){
              pageno = pageno - 1;
              if(pageno < 0){
                pageno = 0;                 
                return false;

              }
            }
            else if(parseInt(dataClick) == 2){
              pageno = pageno + 1;
              if(ret_data < records){
                return false;
              }
            }
            
            
            //  if(dataClick == 'p'){
            //   pageno = pageno - 1;
            //   if(pageno < 0){
            //     pageno = 0;
            //     return false;
            //   }
            // }
            // else if(dataClick == 'n'){
            //   pageno = pageno + 1;
            //   if(ret_data < records){
            //     return false;
            //   }
            // }else{
            //     pageno = parseInt(dataClick);
            // }
             
            
            var redirectUrl = '<?php echo base_url('all-model-management') ?>?search='+searchtext+"&page="+pageno;
            window.location.href = redirectUrl;
        });


    function getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,    
      function(m,key,value) {
        vars[key] = value;
      });
      return vars;
    }
</script>



