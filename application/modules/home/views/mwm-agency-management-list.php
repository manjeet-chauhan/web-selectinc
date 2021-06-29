

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

							<h4>Most Wanted Models@Agency Germany</h4>
							<p>Overview <?php echo $page_title; ?></p>

						</div>

					</div>

	

					

						<div class="InvoiceTable  m-0 border-0">	

							
						 	<div class="clearfix"></div>

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
<!-- 
										<th>Invoice</th>
										<th>Edit</th> -->

									</tr>

								</thead>

								<tbody>

									<?php

									$total_commission = 0;
									foreach ($invoices as $invoice) {
										$invoice_url = base_url('generate-invoice/').$invoice->invoice_number;
										$edit_url = base_url('edit-invoive?invoive=').$invoice->invoice_number; 

										$total_commission = $total_commission + $invoice->model_comission;
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
										<td><?php echo $invoice->model_comission; ?></td>
										 
										<!-- <td><a href="<?php echo $invoice_url; ?>" class="btn btn-sm btn-primary" >INVOICE</a></td>
										<td><a href="<?php echo $edit_url; ?>" class="btn btn-sm btn-primary" >EDIT</a></td> -->

									</tr>

									<?php

									}

									?>

									 <tr>
									 	<th colspan="11"> Total </th>
									 	<th><?php echo $total_commission; ?></th>
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

	<!-- End Dashboard -->

	<script type="text/javascript">
		
			$(function(){

		$('#clientManagement').submit(function(e){

			e.preventDefault();

			$('#displaymsg').removeClass(' alert alert-info');

			$('#displaymsg').removeClass(' alert alert-success');

			$('#displaymsg').removeClass(' alert alert-danger');



			$('#displaymsg').html('Please wait');

			$('#displaymsg').show().delay(5000).fadeOut();

			$('#displaymsg').addClass(' alert alert-info');

            // $('#myloader').show();

            $.ajax({

            	url: '<?php echo base_url('save-mwm-agency-management'); ?>',

            	type: "POST",

            	data: new FormData(this),

            	contentType: false,

            	cache: false,

            	processData: false,

            	async: true,

            	success: function (data) { 



            		$('#displaymsg').removeClass(' alert alert-info');

            		if(data == "success"){

            			$('#displaymsg').html('Successfully saved');

            			$('#displaymsg').show().delay(5000).fadeOut();

            			$('#displaymsg').addClass(' alert alert-success');

            			window.location.href = "<?php echo base_url('client-management'); ?>";

            			return true;

            		}



            		if(data == "error"){

            			$('#displaymsg').html('Error to save, retry');

            			$('#displaymsg').show().delay(5000).fadeOut();

            			$('#displaymsg').addClass(' alert alert-danger');

            			return false;

            		}



            		$('#displaymsg').html(data);

            		$('#displaymsg').show().delay(5000).fadeOut();

            		$('#displaymsg').addClass(' alert alert-danger');

            	}

            });

        })

	})

	</script>

