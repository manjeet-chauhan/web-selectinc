<?php include 'header.php' ?>
<!-- End Header -->

<!-- Start Dashboard -->
<section class="Dashboard">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="DashboardNavigation Scroll">
					<ul>
						<li><a class="collapsed" data-toggle="collapse" data-target="#demo" href="javascript:void(0)"><img src="assets/images/speedometer.svg" alt="Icon" /> Dashboard <i class="fa fa-angle-up" aria-hidden="true"></i></a>
							<div id="demo" class="collapse">
								<div class="InnerNavigation">
									<div class="DashboardNavigation">
										<ul>
											<li><a href="client-management.php"><img src="assets/images/customer.svg" alt="Icon" /> Client Management </a></li>
											<li><a href="model-management.php"><img src="assets/images/3d-modeling.svg" alt="Icon" />Models Management </a></li>
											<li><a href="mwm-agency-management.php"><img src="assets/images/agent.svg" alt="Icon" />  MWM Agency management</a></li>
										</ul>
									</div>
								</div>
							</div>
						</li>
						<li><a href="invoice.php"><img src="assets/images/utilities.svg" alt="Icon" /> Invoice</i></a>
						<li><a href="javascript:void(0)"><img src="assets/images/money-back.svg" alt="Icon" /> Refunds</i></a>
						</li>
						<li><a href="javascript:void(0)"><img src="assets/images/minus.svg" alt="Icon" /> Deductions</a></li>
						<li><a href="javascript:void(0)"><img src="assets/images/business-report.svg" alt="Icon" /> Reports</a></li>
						<li><a href="administration.php"><img src="assets/images/manager.svg" alt="Icon" /> Administration</a></li>
						<li class="Logout"><a href="javascript:void(0)"><img src="assets/images/exit.svg" alt="Icon" /> Logout</a></li>
					</ul>
				</div>
			</div>
			<div class="col-md-9">
				<div class="DashboardContent">
					<div class="OpenTicket Box">
						<div class="BoxHeading">
							<h4>My Open Ticket Overview Sylvia <button type="button" class="btn btn-primary">Show More</button></h4>
						</div>
						<div class="Table">
							<table class="table table-striped">
								<thead>
									<tr>
										<th></th>
										<th>Sr.</th>
										<th>Purpose</th>
										<th>Type</th>
										<th>Descripition</th>
										<th>Location</th>
										<th>Degination</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
												<label class="custom-control-label" for="customCheck"></label>
											</div>
										</td>
										<td>1</td>
										<td>Job</td>
										<td>New</td>
										<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua</td>
										<td>Caroline</td>
										<td>Accounting</td>
									</tr>
									<tr>
										<td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheck2" name="example1">
												<label class="custom-control-label" for="customCheck2"></label>
											</div>
										</td>
										<td>2</td>
										<td>Job</td>
										<td>New</td>
										<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua</td>
										<td>Caroline</td>
										<td>Accounting</td>
									</tr>
									<tr>
										<td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="customCheck3" name="example1">
												<label class="custom-control-label" for="customCheck3"></label>
											</div>
										</td>
										<td>3</td>
										<td>Job</td>
										<td>New</td>
										<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
										tempor incididunt ut labore et dolore magna aliqua</td>
										<td>Caroline</td>
										<td>Accounting</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="SmallBox">
						<div class="row">
							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Open Invoice (Send)</h6>
										<h5>&#8364; 123,572</h5>
									</div>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
								</div>
							</div>
							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Reminders</h6>
										<h5>&#8364; 123,572</h5>
									</div>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
									<p><img src="assets/images/utilities.svg" alt="Icon" /> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>
								</div>
							</div>
							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Refund Prepared</h6>
										<h5>&#160;	</h5>
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
<!-- End Dashboard -->

<!-- Start Footer -->
<?php include 'footer.php' ?>

