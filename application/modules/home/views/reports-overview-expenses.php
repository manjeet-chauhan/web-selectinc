<!--Reports overview Start -->

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

							<h4> Reporting Expense Overview </h4>

						</div>

					</div>

					<div class="SmallBox" style="background-color: #fff;"> 
						<div class="col-md-12">
							<br>
							<div class="table-responsive">
								<?php
								if(!empty($invoices)){
								?>
									<table class="table">

									<tr>
										<th>Invoice Number</th>
										<td><?php echo $invoices[0]->invoice_number; ?></td>
									</tr>
									<tr>
										<th>Company Name</th>
										<td><?php echo $invoices[0]->i_company_name; ?></td>
									</tr>
									<tr>
										<th>Model Name</th>
										<td><?php echo $invoices[0]->i_company_name; ?></td>
									</tr>
									<tr>
										<th>Model Budget</th>
										<td><?php echo $invoices[0]->model_budget; ?>€</td>
									</tr>
									<tr>
										<th>Model Total Agreed</th>
										<td><?php echo $invoices[0]->model_total_agreed; ?>€</td>
									</tr>

									<tr style="color: #1f9bb5;">
										<th>#</th>
										<th>Name</th>
										<th>Amount</th>
										<th>Vat</th>
										<th>Amount</th>
									</tr>

									<?php 
									$count = 0;
									$inv_total = 0;
									foreach ($invoices as $invoice) {
										$total = $invoice->model_exp_amount;
										$inv_total += $total;
									?>

									<tr >
										<td><?php echo ++$count; ?></td>
										<td><?php echo $invoice->model_expense ?></td>
										<td><?php echo $invoice->model_exp_amount ?>€</td>
										<td>
											<?php 
											if($invoice->vat_include == 1){
												$vat = (($invoice->model_exp_amount*$invoice->vat_percent)/100);
												echo $vat.'€ <small><b>('.$invoice->vat_percent.'%)</b></small>';
												$total += $vat;
												$inv_total += $vat;
											}
											?>
										</td>
										<td><?php echo $total; ?>€</td>
									</tr>

									<?php
									}
									?>

									<tr>
										<th colspan="4" class="text-right">Total</th>
										<th><?php echo $inv_total; ?>€</th>
									</tr>
								</table>
								<?php
								} 
								else{
								?>
								<div class="alert alert-danger"> No Records available.</div>

								<?php

							 	}
								?>
							</div>
						</div>

					</div>


				</div>

			</div>

		</div>

	</div>

</section>

<!-- Reports overview End