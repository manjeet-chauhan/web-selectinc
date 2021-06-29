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
							<h4> Client Invoices  </h4>	
							<!-- <div><a href="<?php echo base_url('client-list-invoice') ?>">change with vat</a></div> -->
						</div>
					</div> 

					<div class="OpenTicket Box">

						<div class="filter-data">
							<form id="formfilter">
								<div class="row">

									<div class="col-md-2">
										<label><input type="radio" name="invoice_type" onchange="window.location.href='<?php echo base_url('client-list-invoice') ?>'"> With Vat</label>
									</div>
									<div class="col-md-3">
										<label><input type="radio" checked name="invoice_type"> Without Vat</label>
									</div>
									<div class="col-md-7"></div>
									<div class="clearfix"></div>
									
									<div class="col-md-3">
									<div class="Status Feedback mt-2 InputBox">
										<div><label><small><b>Client</b></small></label></div>

										<?php
 
										$clients = get_clients($user_id);
										?>
										<select class="custom-select myselect form-control" id="save_clients" name="save_clients">
										<option value="" selected disabled > Select Client</option>
										<?php 
										if(!empty($clients)){
											foreach ($clients as $client){
												$selected = '';
												if(!empty($client_id)){
													if($client->id == $client_id){
														$selected = 'selected';
													}
												}
										?>

												<option <?php echo $selected; ?> value="<?php echo $client->id; ?>" ><?php echo ucwords(strtolower($client->company_name)); ?></option>

										<?php
											}
										}
										?> 

										</select>
									</div>
								</div>

								<div class="col-md-3">
									<div class="Status Feedback mt-2 InputBox">
										<div><label><small><b>Date From</b></small></label></div>
										 <input type="date"  value="<?php echo $date_from ?>" name="date_from" class="custom-input form-control">
									</div>
								</div>
								<div class="col-md-3">
									<div class="Status Feedback mt-2 InputBox">
										<div><label><small><b>Date To</b></small></label></div>
										 <input type="date" value="<?php echo $date_to ?>" name="date_to" class="custom-input form-control">
									</div>
								</div>
								<div class="col-md-2">
									<div style="margin-top: 14px;"><label><small><b>&nbsp;<br></b></small></label></div>
									<button class="btn btn-primary btn-lg ">Submit</button></div>
								</div>
								<div class="clearfix"></div>
								</form>
								
								<form id="downloadForm" method="POST" action="<?php echo base_url('download-client-list-pdf-without-vat'); ?>">
									<input type="hidden" name="ddate_from" value="<?php echo $date_from ?>">
									<input type="hidden" name="ddate_to" value="<?php echo $date_to ?>">
									<input type="hidden" name="client_d_f" value="<?php echo $client_id; ?>">
									<button style="float: right; margin-top: -45px;" class="btn btn-primary btn-lg "><i class="fa fa-check-circle-o"  ></i>  <i class="fa fa-download"></i> </button>
									<!-- <button style="float: right; margin-top: -45px;" class="btn btn-primary btn-lg "><i class="fa fa-check-circle-o" ></i>  <i class="fa fa-download"></i> </button> -->
								</form>

							</div>

						<div class="Table invoice Overview">

							<table class="table table-striped">
								<thead>
									<tr>

										<th>#</th>
										<th>Date</th>
										<th>Invoice No.</th>
										<th>Model Name</th>
										<th>Model Fee</th>
										<!-- <th>Vat on Model</th> -->
										<th>MWM Commission</th>
										<!-- <th>Vat on Commission</th> -->
										<th>Total</th>
									</tr>
								</thead>

								<tbody>

									<?php

									// print_r($invoices);

									$count = 0;

									$mob_bud = 0;
									$mob_bud_vat = 0;
									$mob_mwm = 0;
									$mob_mwm_vat = 0;
									$mob_total = 0;

									$mob_total_mwm = 0;
									


									foreach ($invoices as $invoice) {
										$modal_vat = 0;
										// $invoice->m_vat_percent = 0;
										$invoice->vat_price = 0;

										if($invoice->m_vat_percent > 0){
											// $modal_vat = ($invoice->model_budget *$invoice->m_vat_percent)/100;
										}

										$modal_com = 0;
										$modal_com_vat= 0;

										if($invoice->model_agency_comission > 0){
											$modal_com = ($invoice->model_budget *$invoice->model_agency_comission)/100;
										}

										if($modal_com > 0 && $invoice->vat_price > 0){
											// $modal_com_vat = ($modal_com *$invoice->vat_price)/100;
										}

										$total_amt = ($invoice->model_budget + $modal_com); //$invoice->model_budget + $invoice->modelExp + $invoice->selectInc + $modal_com + $modal_com_vat;


										$mob_bud += $invoice->model_budget;
										// $mob_bud_vat += $modal_vat;
										$mob_mwm += $modal_com;
										// $mob_mwm_vat += $modal_com_vat;
										$mob_total += $total_amt;

										$mob_total_mwm += ($invoice->model_budget + $mob_mwm);

									?>

									<tr>
										<td><?= ++$count; ?> </td>
										<td><?= date('d-m-Y', strtotime($invoice->invoice_date))?> </td>
										<td><?= $invoice->invoice_number?> </td>
										<td><?= $invoice->m_model_name?> </td>
										<td class="text-right">€<?= $invoice->model_budget?> </td>
										<!-- <td class="text-right">€<?= $modal_vat?> </td> -->
										<td class="text-right">€<?= $modal_com ?> </td>
										<!-- <td class="text-right">€<?= $modal_com_vat; ?>  </td> -->
										<td class="text-right">€<?= $total_amt ?></td>
									</tr>

									<?php

									}

									?>

									<tr>
										<th>Total</th>
										<th></th>
										<th></th>
										<th></th>
										<td class="text-right">€<?= $mob_bud ?></td>
										<!-- <td class="text-right">€<?= $mob_bud_vat ?></td> -->
										<td class="text-right">€<?= $mob_mwm ?></td>
										<!-- <td class="text-right">€<?= $mob_mwm_vat ?></td> -->
										<td class="text-right">€<?= $mob_total ?></td>
										
									</tr>

									<tr>
										<th colspan="2">Gesamtabrechnung wie aufgelistel :</th>
										<th>netto</th>
										<th colspan="2" class="text-right">€<?= $mob_total_mwm; ?></th>
										<th class="">brutto</th>
										
										<th class="text-right">€<?= $mob_total ?></th>
										
									</tr>

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




