<style type="text/css">

	.Overview a.btn{

		color: #fff !important;

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
							<h4> Invoices For Approval </h4>				 

						</div>

					</div>

					<div class="OpenTicket Box">

						<div class="Table invoice Overview">

							<table class="table table-striped">

								<thead>

									<tr>

										<th>Date</th>

										<th>Job Date</th>

										<th>Invoice No.</th>

										<th>Client</th>

										<th>Model</th>

										<th>Amount Accepted</th>

										<th>Accepted Model</th>

										<th>VAT Model</th>

										<th>Agency Comission</th>

										<th>VAT (AC)</th>

										<th>Select </th>

										<th>Total</th>

										<!-- <th>Invoice</th> -->
										<th>Action</th>

									</tr>

								</thead>

								<tbody>

									<?php

									foreach ($invoices as $invoice) {
										$invoice_url = base_url('generate-invoice/').$invoice->invoice_number;
										$edit_url = base_url('edit-invoive?invoive=').$invoice->invoice_number; 
									?>

									<tr>
										<td><?= $invoice->creation_date?> </td>
										<td><?= $invoice->job_date ?> </td>
										<td><?= $invoice->invoice_number?> </td>
										<td><?= $invoice->i_company_name?> </td>
										<td><?= $invoice->m_model_name?> </td>
										<td><?= $invoice->model_budget?> </td>
										<td><?= $invoice->model_total_agreed?> </td>
										<td><?= $invoice->m_vat_percent?>% </td>
										<td><?= $invoice->model_agency_comission?>% </td>
										<td><?= $invoice->vat_price?>% </td>
										<td><?php echo $invoice->selectInc; ?></td>
										<td>1400.00</td>
										<td>
											 <a href="<?php echo $invoice_url; ?>" class="btn btn-sm btn-primary btn-block" >VIEW</a> 
											 <div style="margin-top: 5px;"><button data-invoice="<?php echo $invoice->invoice_number; ?>" data-toggle="modal" data-target="#approveInvoice"  class="btn btn-warning btn-sm btn-block" onclick="$('#invoive_id, #approve_invoice_id').val($(this).attr('data-invoice'));">  APPROVE</button></div>
										</td>
										 

									</tr>

									<?php

								}

									?>

									<!-- <tr>

										<td>

									<?php print_r($invoices);?>

								</td></tr> -->

								</tbody>

							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

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



<div id="approveInvoice" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title">Approve/Request to Change Invoice</h4>
	      </div>

	     	 <form id="formApproval" name="formApproval">
		      	<div class="modal-body">
		      		<div class="form-group">
				    <label for="email">Message:</label>
				    
				    <input type="hidden" class="form-control" id="approve_invoice_id" name="approve_invoice_id">
				    <textarea class="form-control" id="approve_message" name="approve_message"></textarea>
				  </div>
				  <div class="form-group mb-0">
				    <label for="approve_status1"> <input checked type="radio" class="custom-radio" id="approve_status1" name="approve_status" value="1"> &nbsp; Approve Invoice</label>
				    
				  </div>
				   <div class="form-group mb-0">
				    <label for="approve_status2"> <input type="radio" class="custom-radio" id="approve_status2" name="approve_status" value="3"> &nbsp; Request for Change</label>
				    
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
            url: '<?php echo base_url('approve-user-invoice'); ?>',
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


	  $('#formApproval').submit(function(e){
				e.preventDefault();

				$('#dispmsg').removeClass(' alert alert-info');
				$('#dispmsg').removeClass(' alert alert-success');
				$('#dispmsg').removeClass(' alert alert-danger');

				$('#dispmsg').html('Please wait');
				$('#dispmsg').show().delay(5000).fadeOut();
				$('#dispmsg').addClass(' alert alert-info'); 

				$.ajax({

					url: '<?php echo base_url('invoice-approve-or-change-request'); ?>',
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					async: true,
					success: function (data) { 

							$('#dispmsg').removeClass(' alert alert-info');
							if(data == "success"){

								$('#dispmsg').html('Forward to assistant for approval successfully');
								$('#dispmsg').show().delay(5000).fadeOut();
								$('#dispmsg').addClass(' alert alert-success');
								// window.location.href = "<?php echo base_url(); ?>";
	            			location.reload();
	            			return true; 
	            		} 
	            		if(data == "error"){

	            			$('#dispmsg').html('Error to forward to assistant for approval, retry');
	            			$('#dispmsg').show().delay(5000).fadeOut();
	            			$('#dispmsg').addClass(' alert alert-danger');
	            			return false;
	            		}

	            		$('#dispmsg').html(data);
	            		$('#dispmsg').show().delay(5000).fadeOut();
	            		$('#dispmsg').addClass(' alert alert-danger');
	            	}
            	});
			})


</script>




