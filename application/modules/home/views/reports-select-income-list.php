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
							<h4><?php echo $page; ?>  </h4>				 

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

										<th>Invoice</th>
										<!-- <th>Edit</th> -->

									</tr>

								</thead>

								<tbody>

									<?php

									foreach ($invoices as $invoice) {

										$invoice_url = base_url('reports-select-income/').$invoice->invoice_number;
										if($invoice->etype == 2){
											$invoice_url = base_url('reports-expenses-overview/').$invoice->invoice_number;
										}


										$edit_url = base_url('edit-invoive?invoive=').$invoice->invoice_number; 

										$total_amt = $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->model_total_agreed;

										if($invoice->m_vat_percent > 0){
											$total_amt = $total_amt + (($total_amt * $invoice->m_vat_percent)/100);
										}

										if($invoice->model_agency_comission > 0){
											$mwmcom = (($total_amt * $invoice->model_agency_comission)/100);
											$total_amt = $total_amt + $mwmcom;
											if($invoice->m_ingermany == 1 && $invoice->vat_price > 0){
												$mwmcom_vat = (($mwmcom * $invoice->vat_price)/100);
												$total_amt = $total_amt + $mwmcom_vat;
											}
										}
										$total_amt = $total_amt + $invoice->selectInc;

										
									?>

									<tr>
										<td><?= date('d-m-Y', strtotime($invoice->creation_date))  ?> </td>
										<td><?= date('d-m-Y', strtotime($invoice->job_date)); ?> </td>
										<td><?= $invoice->invoice_number?> </td>
										<td><?= $invoice->i_company_name?> </td>
										<td><?= $invoice->m_model_name?> </td>
										<td><?= $invoice->model_budget?> </td>
										<td><?= $invoice->model_total_agreed?> </td>
										<td><?= $invoice->m_vat_percent?>% </td>
										<td><?= $invoice->model_agency_comission?>% </td>
										<td><?= $invoice->vat_price?>% </td>
										<td><?php echo $invoice->selectInc; ?></td>
										<td><?php echo $total_amt; ?></td>
										<td><a href="<?php echo $invoice_url; ?>" class="btn btn-sm btn-primary" ><i class="fa fa-eye"></i></a></td>
										<!-- <td><a href="<?php echo $edit_url; ?>" class="btn btn-sm btn-primary" ><i class="fa fa-pencil-square-o"></i></a></td> -->

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





