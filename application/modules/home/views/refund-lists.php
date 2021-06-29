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
							<h4><?php echo $page; ?> Refund List  </h4>				 

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

										<th>Refund</th>
										<!-- <th>Edit</th> -->

									</tr>

								</thead>

								<tbody>

									<?php

									foreach ($invoices as $invoice) {
										$invoice_url = base_url('invoive-refund-details/').$invoice->invoice_number;
										$edit_url = base_url('edit-refund-invoice?invoive=').$invoice->invoice_number; 
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
										<td><a href="<?php echo $invoice_url; ?>" class="btn btn-sm btn-primary" >REFUND</a></td>
										<!-- <td><a href="<?php echo $edit_url; ?>" class="btn btn-sm btn-primary" >EDIT</a></td> -->

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

<!-- End Dashboard -->





