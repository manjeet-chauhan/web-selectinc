<style type="text/css">

	.Overview a.btn{

		color: #fff !important;

	}

	.mbtn{
		margin-top: -35px;
    /* z-index: 999; */
    position: relative;
    right: 55px;
	}


.table td, .table th {
    padding: 4px 8px;
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
							<h4> <?php echo $model->model_name; ?> Deduction Details </h4>

							<a class="pull-right btn btn-primary mbtn"  href="#" data-toggle="modal" data-target="#addExpensesModel"> Add Expenses </a>				 

						</div>

					</div>

					<div class="OpenTicket Box">

						<div class="Table invoice Overview">

							<table class="table table-striped">

								<thead>

									<tr>
										<th>#</th>
										<th>Transaction Type</th>
										<th>Expense Date</th>
										
										<!-- <th>Model Name</th> -->
										<th>Expense Name</th>
										<th>Attachment</th>
										<th>Quantity</th>
										<th>Amount</th>
										<th>Sum Total</th>
										
										
										
										<!-- <th>Last Modified</th> -->
									</tr>

								</thead>

								<tbody>

									<?php 
									if(!empty($_model_expenses)){
										$slno = 0;
										$total_sum = 0;
										foreach ($_model_expenses as $expenses) {
											$color = $expenses->transaction_type == 'DR' ? '#bd0606' : 'green';

											$total_sum = $expenses->transaction_type == 'DR' ?  ($total_sum + $expenses->sum_amount) : ($total_sum - $expenses->sum_amount); ;
									?>

										<tr style="color: <?php echo $color; ?> !important;">
											<td>  <?php echo ++$slno;  ?> </td>
											<td>  <?php echo  $expenses->transaction_type   ?> </td>
											<td>  <?php echo date('d-m-Y', strtotime($expenses->expense_date))  ?> </td>
											<!-- <td> <div><?php echo $expenses->model_name  ?></div> -->
												<!-- <div style="margin-top: 2px;  color: #01667b"><small><b>(<?php echo $expenses->model_s_name  ?>)</b></small></div> --> </td>
											
											<td>  <?php echo $expenses->expense_name  ?> </td>
											<td> 
												<?php if(!empty($expenses->filename)){ ?>
												<a target="_blank" style="color: <?php echo $color; ?> !important" href="<?php echo base_url('assets/upload/images/').$expenses->attachment ?>"><i class="fa fa-file-o" aria-hidden="true"></i> <?php echo $expenses->filename;  ?> <i class="fa fa-download pull-right"></i></a>
											<?php } ?>
											</td>

											<td>  <?php echo $expenses->quantity  ?> </td>
											<td>  € <?php echo $expenses->amount  ?> </td>
											<td>  € <?php echo $expenses->sum_amount  ?> </td>
											
											
											
											<!-- <td>  <?php echo date('d-m-Y', strtotime($expenses->modification_date))  ?> </td> -->
										</tr>
										 

									<?php
										}
									?>

									<tr>
										<th colspan="7" class="text-right"> Total </th>
										<td colspan=""> €  <?php echo money_format($total_sum, 2); ?> </td>
									</tr>

									<?php
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

<!-- <div class="modal" id="modalApproveInvoives">
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
 -->


<div id="addExpensesModel" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Deduction Expenses</h4>
	      </div>

	     	 <form id="formDeductionExp" name="formDeductionExp">
		      	<div class="modal-body">
		      		<div class="form-group">
					    <label for="email">Expense Name:</label>
					    
					    <input type="hidden" class="form-control" id="deduction_model_id" name="deduction_model_id" value="<?php echo $model_id ?>">
					    <input type="text" class="form-control" id="d_expenses_name" name="d_expenses_name">
					</div>
					<div class="row">

						<div class="col-md-6">
							<div class="form-group">
							    <label for="email">Quantity:</label>
							    <input type="number" class="form-control" id="d_expenses_quantity" min="1" name="d_expenses_quantity">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="email">Amount:</label>
							    <input type="number"  step="any" class="form-control" id="d_expenses_amount" name="d_expenses_amount">
							</div>
						</div>  
					</div>

					<div class="row"> 
						<div class="col-md-6">
							<div class="form-group">
							    <label for="email">Attachment (if any):</label>
							    <input type="file" class="form-control" id="d_expenses_attachment" name="d_expenses_attachment">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
							    <label for="email">Date:</label>
							    <input type="date" class="form-control" id="d_expenses_date" name="d_expenses_date">
							</div>
						</div> 
					</div> 


					<div class="form-group">
					    <label for="email">Description:</label>
					    <textarea class="form-control" id="d_expenses_msg" name="d_expenses_msg"></textarea>
					</div>

					
				   
				  <div id="dispmsg"></div>
				  
		      	</div>
		      	<div class="modal-footer">
		        <button type="submit" class="btn btn-primary">Save</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		      	</div>			  
			</form>	      
	    </div>
	  </div>
	</div>

<!-- End Dashboard -->
<script type="text/javascript">
	  $('#formDeductionExp').on('submit', function(e){       
        e.preventDefault();

        $('#dispmsg').removeClass(' alert alert-info');
        $('#dispmsg').removeClass(' alert alert-success');
        $('#dispmsg').removeClass(' alert alert-danger');

        
        $('#dispmsg').html('Please wait');
        $('#dispmsg').show().delay(5000).fadeOut();
        $('#dispmsg').addClass(' alert alert-info');
        // $('#myloader').show();
        $.ajax({
            url: '<?php echo base_url('save-deduction-transaction'); ?>',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            async: true,
            success: function (data) { 

                $('#dispmsg').removeClass(' alert alert-info');
                if(data == "success"){
                    $('#dispmsg').html('Saved successfully.');
                    $('#dispmsg').show().delay(5000).fadeOut();
                    $('#dispmsg').addClass(' alert alert-success');
                     location.reload();
                    return true;
                }
                if(data == "error"){
                  $('#dispmsg').html('Error to save data, retry');
                  $('#dispmsg').show().delay(5000).fadeOut();
                  $('#dispmsg').addClass(' alert alert-danger');
                  return false;
                }

                $('#dispmsg').html(data);
                $('#dispmsg').show().delay(5000).fadeOut();
                $('#dispmsg').addClass(' alert alert-danger');
            }
        });
    });


	  // $('#formApproval').submit(function(e){
			// 	e.preventDefault();

			// 	$('#dispmsg').removeClass(' alert alert-info');
			// 	$('#dispmsg').removeClass(' alert alert-success');
			// 	$('#dispmsg').removeClass(' alert alert-danger');

			// 	$('#dispmsg').html('Please wait');
			// 	$('#dispmsg').show().delay(5000).fadeOut();
			// 	$('#dispmsg').addClass(' alert alert-info'); 

			// 	$.ajax({

			// 		url: '<?php echo base_url('invoice-approve-or-change-request'); ?>',
			// 		type: "POST",
			// 		data: new FormData(this),
			// 		contentType: false,
			// 		cache: false,
			// 		processData: false,
			// 		async: true,
			// 		success: function (data) { 

			// 				$('#dispmsg').removeClass(' alert alert-info');
			// 				if(data == "success"){

			// 					$('#dispmsg').html('Forward to assistant for approval successfully');
			// 					$('#dispmsg').show().delay(5000).fadeOut();
			// 					$('#dispmsg').addClass(' alert alert-success');
			// 					// window.location.href = "<?php echo base_url(); ?>";
	  //           			location.reload();
	  //           			return true; 
	  //           		} 
	  //           		if(data == "error"){

	  //           			$('#dispmsg').html('Error to forward to assistant for approval, retry');
	  //           			$('#dispmsg').show().delay(5000).fadeOut();
	  //           			$('#dispmsg').addClass(' alert alert-danger');
	  //           			return false;
	  //           		}

	  //           		$('#dispmsg').html(data);
	  //           		$('#dispmsg').show().delay(5000).fadeOut();
	  //           		$('#dispmsg').addClass(' alert alert-danger');
	  //           	}
   //          	});
			// })


</script>




