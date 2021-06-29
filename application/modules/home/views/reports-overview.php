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

							<h4>Overview all / Reporting </h4>

						</div>

					</div>

					<div class="SmallBox">

						<div class="row">

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Open Invoice (Send)</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($open_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('open-invoice') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Overview Refunds Models</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($open_refunds as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-refund-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo $invoice->m_model_name. " : <span>" . $invoice->invoice_number.'</span>'; ?><!--  <div><small>(<?php echo $invoice->m_model_name; ?>)</small></div> --></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('open-refund') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>
 
							 
							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Overview MWM Agency</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($mwm_invoices as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('invoive-details/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?><!--  <div><small>(<?php echo $invoice->m_model_name; ?>)</small></div> --></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('mwm-agency-management') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Overview Select Incomes</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($select_income as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('reports-select-income/').$invoice->invoice_number;

									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?><!--  <div><small>(<?php echo $invoice->m_model_name; ?>)</small></div> --></a> 
									</p>
									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('mwm-agency-management') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Expenses Overview</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($expenses as $invoice) {
										// $invoice->issue_id . 
										$detail_url = base_url('reports-expenses-overview/').$invoice->invoice_number;
									?>
									<p>
										<img src="<?php echo base_url('assets/frontend/images/utilities.svg');?>" alt="Icon">
										<a href="<?php echo $detail_url; ?>"><?php echo "INVOICE NO. : <span>" . $invoice->invoice_number.'</span>'; ?></a> 
									</p>

									<?php
									}
									?>  
									<hr /> 
									<a href="<?php echo base_url('reports-expenses-overview-list') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

 

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<!-- Reports overview End