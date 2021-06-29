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
							<h4> Partner Invoice</h4>				 
						</div>
					</div>



					<div class="OpenTicket Box">

						  
						<div class="Table invoice Overview">
 
							<table class="table table-striped">
								<thead>
									<tr> 
										<th>Invoice Number</th>
										<th>Token Id</th>
										<th>Invoice Date</th>
										<th>Booking Date</th>
										<th>Customer</th>
										<th>Model</th>
										<!-- <th>Currency</th> -->
										<th>Currency Amount</th>
										<th>Commission</th>
										<th>Total</th>
									</tr>
								</thead>

								<?php 

								$currency_array = get_currency_list();
								if(!empty($invoices)){
									foreach ($invoices as $invoice) {
										$urldetail = base_url('general-invoive-details/').$invoice->invoice_number;
								?>

									<tr onclick="window.location.href='<?php echo $urldetail; ?>'"> 
										<td><?php echo $invoice->invoice_number ?></td>
										<td><?php echo $invoice->issue_id ?></td>
										<td><?php echo $invoice->i_date ?></td>
										<td><?php echo $invoice->booking_date ?></td>
										<td><?php echo $invoice->client ?></td>
										<td><?php echo $invoice->address1 ?></td>
										<?php
										$currency = '';
										foreach($currency_array as $my_c){
											if($my_c->code == $invoice->currency) {
												// $currency = $my_c->code."(".$my_c->symbol.")";
												$currency = $my_c->symbol;
											}
										}
										?>
										<!-- <td><?php echo $currency ?></td> -->
										<td><?php echo $currency.$invoice->currency_amount ?></td>
										<td><?php echo $invoice->vat_percentage ?>%</td>
										<td><?php echo $invoice->total_amount ?></td>
									</tr>
								 

								<?php
							}

								}
								?>
								 
							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>
 

 




