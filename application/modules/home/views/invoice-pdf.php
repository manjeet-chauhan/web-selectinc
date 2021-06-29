

<!-- Start Dashboard -->

<section class="Dashboard">

	<div class="container">

		<div class="row">

			<div class="col-md-2">

				<?php include 'sidebar.php' ?>

			</div>

			<div class="col-md-10" id="pdf">

				<div class="DashboardContent">

					 

					<div class="OpenTicket Box Boxtwo">						 

						<div class="InvoiceTitle">

							<h2 align="center">INVOICE</h2>

						</div>

						<div style="border-bottom: 1px solid #e1e1e1; padding: 5px; margin-bottom: 12px;"></div>

						<div class="Address">

							<div>

								

								<div class="text-uppercase"><a href=""><b><?php echo $invoice->i_company_name; ?></b></a></div>

								<div>

									<?php echo $invoice->i_address_line1.', '.$invoice->i_address_line2 ?>

								</div>

								<div>

									<?php echo $invoice->i_city.', '.$invoice->i_pincode; ?>

								</div>

								<div>

									<b><?php echo ucwords($invoice->i_country);?></b>

								</div>

							</div>

							<!-- Fritz Drollinger GmbH & Co.KG <br>z.H. Sebastian Proft<br>Hainbuchenstrasse 12<br>D-83435 Bad Reichenhall<br>Germany -->



							<div style="border-bottom: 1px solid #e1e1e1; padding: 5px;"></div>

						</div>

						

						<div class="Table RefundTable">

							<table border="0" style="width: 100%;border-collapse: collapse;text-align: left;">

								<thead>

									<tr>

										<td><b>Ticket ID</b></td>

										<td><b>Invoice Number</b></td>

										<td><b>Date</b></td>

									</tr>

								</thead>

								<tbody>

									<tr>

										<td>

											#<?php echo $invoice->issue_id; ?>

										</td>

										<td>

											<?php echo $invoice->invoice_number; ?>

										</td>

										<td>

											<?php echo date('d/m/Y', strtotime($invoice->invoice_date)); ?>

										</td>

									</tr>

									

						

						</div>

						<div class="ModelMgmt">

							

							<tr>

							<td><b>Model</b></td>

							<td><?php echo $invoice->m_model_name ?></td>

									

							</tr>

							<tr>

							<td><b>TIN</b></td>

							<td><?php echo $invoice->m_vat_tin_number ?></td>

									

							</tr>

							<tr>

								<td><b>Provided by Trademark</b></td>

								<td>Most Wanted Model <i class="fa fa-registered"></i></td>

									

							</tr>

							<tr>

								<td><b>Customer</b></td>

								<td><?php echo $invoice->i_company_name; ?></td>

								

							</tr>

							<tr>

								<td><b>Booking Date</b></td>

								<td><?php echo date('d/m/Y', strtotime($invoice->creation_date)); ?></td>

								

							</tr>



							

							<?php

							$count = 1;

							if(!empty($headers)){

								$count = count($headers) + 1;

								for ($i=0; $i < count($headers); $i++) { 

							?>

							<tr>

									<td><b><?php echo $headers[$i]->invoive_title ?></b></td>

									<td><?php echo $headers[$i]->invoive_value ?></td>

									

							</tr>

							

							<?php

								}

							}

							?>

							

								

							<tr style="border-top: 1px solid black">

								<td><b>Amount agreed Upon</b></td>

								<td></td>

								<td><b><?php echo $invoice->model_budget; ?>  €</b> </td>

								

							</tr> 									 

									

								<tr style="border:1px solid black;"><td colspan="4"><h3 align="center">Invoicing on behalf of the model</h3></td></tr>

								

							

								

										<tr>

											<td><b>Amount agreed Upon</b></td>

											<td></td>

											<td><b><?php echo $invoice->model_budget; ?> €</b></td>

											<td><?php echo $invoice->model_total_agreed; ?> €</td>

										</tr>



										<?php

												$total_modal_exp = 0;

												$total_modal_agreed_exp = 0;



												$vat_price = 0;

												$ingermany = checkForGermany($invoice->model_id);



												if(!empty($ingermany->ingermany)&&($ingermany->ingermany==1)){

												

										?>

										<tr>

											<td><b> + Vat</b></td>

											<td><b> <?php echo $invoice->i_fee ?>%</b></td>

											<td><b>

												<?php 



												if($invoice->i_fee > 0){

													$vat_price = ($invoice->model_budget*$invoice->i_fee)/100;

												}

												echo $vat_price; 



												$total_modal_exp = $total_modal_exp + $vat_price;

												



												?> 

											 € </b></td>

											<td>

												<?php 

												$vat_price = 0;

												if($invoice->i_fee > 0){

													$vat_price = ($invoice->model_total_agreed*$invoice->i_fee)/100;

												}

												echo $vat_price; 

												$total_modal_agreed_exp = $total_modal_agreed_exp + $vat_price; 

												?> 

												 € 

											</td>

										</tr>

										<?php 

									}

										if(!empty($expenses)){

											foreach ($expenses as $expense) {

										?>

										<tr>

											<td> <?php echo $expense->model_expense; ?> </td>

											<td></td>

											<td> <?php echo $expense->model_exp_amount; ?> €</td>

											<td>  <?php echo $expense->model_exp_amount; ?> €</td> 

										</tr>

										<?php 

										$total_modal_exp = $total_modal_exp + $expense->model_exp_amount;

										$total_modal_agreed_exp = $total_modal_agreed_exp + $expense->model_exp_amount;



										if(($expense->vat_include == 1)&&!empty($ingermany->ingermany)&&($ingermany->ingermany==1)){

										?>



										<tr>

											<td><b> + Vat</b></td>

											<td><b> <?php echo $invoice->i_fee ?>%</b></td>

											<?php 

											$vat_exp_price = 0;

											if($invoice->i_fee > 0){

												$vat_exp_price = ($expense->model_exp_amount*$invoice->i_fee)/100;



												$total_modal_exp = $total_modal_exp + $vat_exp_price;

												$total_modal_agreed_exp = $total_modal_agreed_exp + $vat_exp_price;



											}

											?> 

											<td><b> <?php echo $vat_exp_price; ?> €</b></td>

											<td> <?php echo $vat_exp_price; ?> €</td>

										</tr>



										<?php

										}

										?>

										<?php 

											}

										}

										?> 

								

									<tr style="border:1px solid black;"><td colspan="4"><h3>Invoicing on behalf of most wanted models agency Germany Erika-Mann-Strasse-21,8000 Munich</h3></td></tr>



							

								

										<?php 

										$agency_commission = get_agency_comission();

										$commisssion  = $agency_commission->serivice_comission;



										$com_price = (($invoice->model_budget * $agency_commission->serivice_comission)/100);

										$com_price_agree = (($invoice->model_total_agreed * $agency_commission->serivice_comission)/100);



										$total_modal_exp = $total_modal_exp + $com_price;

										$total_modal_agreed_exp = $total_modal_agreed_exp + $com_price_agree; 

										?>

										<tr>

											<td><b>Agency commission</b></td>

											<td><b><?php echo $agency_commission->serivice_comission ?>%</b></td>

											<td><b> <?php echo $com_price ?> € </b></td>

											<td> <?php echo $com_price_agree ?> € </td>

										</tr>

										<?php 



										if(($agency_commission->vat_price > 0)&&!empty($ingermany->ingermany)&&($ingermany->ingermany==1)){

											$com_price_vat = (($com_price * $agency_commission->vat_price)/100);

											$com_price_agree_vat = (($com_price_agree * $agency_commission->vat_price)/100);



											$total_modal_exp = $total_modal_exp + $com_price_vat;

											$total_modal_agreed_exp = $total_modal_agreed_exp + $com_price_agree_vat;



										?>



										<tr>

											<td> + VAT </td>

											<td><?php echo $agency_commission->vat_price ?>%</td>

											<td><?php echo $com_price_vat; ?> € </td>

											<td><?php  

											echo $com_price_agree_vat ?>  €</td> 

										</tr>



										<?php

										}

										?> 

									

										<tr style="border:1px solid black;"><td colspan="4"><h3>Invoicing on behalf of Select Partners Inc.</h3></td></tr>

								

							<div class="Table Invoice">

								

										<?php 

										if(!empty($services)){

											foreach ($services as $services) {

										?>

										<tr>

											<td> <?php echo $services->model_service; ?> </td>

											<td></td>

											<td> <?php echo $services->model_ser_amount; ?> €</td>

											<td>  <?php echo $services->model_ser_amount; ?> €</td> 

										</tr>

										<?php 

										$total_modal_exp = $total_modal_exp + $services->model_ser_amount;

										$total_modal_agreed_exp = $total_modal_agreed_exp + $services->model_ser_amount;



										if(($services->vat_include == 1)&&!empty($ingermany->ingermany)&&($ingermany->ingermany==1)){

										?>



										<tr>

											<td><b> + Vat</b></td>

											<td><b> <?php echo $invoice->i_fee ?>%</b></td>

											<?php 

											$vat_exp_price = 0;

											if($invoice->i_fee > 0){

												$vat_exp_price = ($services->model_ser_amount*$invoice->i_fee)/100;



												$total_modal_exp = $total_modal_exp + $vat_exp_price;

												$total_modal_agreed_exp = $total_modal_agreed_exp + $vat_exp_price;



											}

											?> 

											<td><b> <?php echo $vat_exp_price; ?> €</b></td>

											<td> <?php echo $vat_exp_price; ?> € </td>

										</tr>



										<?php

										}

										?>

										<?php 

											}

										}

										?>

										<tr class="Total">

											<td><b>Total</b></td>

											<td></td>

											<td></td>

											<td><b><?php echo $total_modal_agreed_exp; ?> €</b></td></td></td>

										</tr>

									</tbody>

								</table>

							</div>

							<div class="Invoicing">

								<div class="Issue">

									<h3>Issue Date</h3>

									<p>

										Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

										tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

										quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

										consequat.

									</p>

								</div>

								<div class="ParaCenter">



								</div>

							</div>

						</div>		

					</div>

				</div>

				<div class="OpenTicket Box Boxtwo">

					<div class="Address">

						<p>

							Fritz Drollinger GmbH &amp; Co.KG <br>z.H. Sebastian Proft<br>Hainbuchenstrasse 12<br>D-83435 Bad Reichenhall<br>Germany

						</p>

						<hr>

					</div>

					<div class="row">

						<div class="col-md-6">

							<div class="InvoicePara">

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

							</div>

						</div>

						<div class="col-md-6">

							<div class="InvoicePara">

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

								<p>

									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,

									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo

									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse

									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non

									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

								</p>

							</div>

						</div>

					</div>

				</div>

				<div class="OpenTicket Box Boxtwo">

					<div class="row">

						<div class="col-md-12">

							<div class="MostWanted">

								<div class="Title">

									<div class="Date"  style="text-align: left;">

										<p>15.Mar.2020 19:00</p>

									</div>

									<div class="No"  style="text-align: right;">

										<p>12345 P.001 /002<br>JOB 43222-Paula Alonso</p>

									</div>

								</div>

								<div class="GenerateInvoice" style="text-align: center;">

									<h3>MOST WANTED</h3>

									<h6>MODELS</h6><br>

									<h3><strong>Munich and Hamburg</strong></h3>

									<h6><small>Munich phone: +123456789</small></h6>

									<h6><small>Fax: +123456789</small></h6>

									<h3><strong>BOOKING CONFIRMATION</strong></h3>

								</div>

								<div class="TableTitle">

									Customers

								</div>

								<div class="Table Invoice">

									<table class="table table-striped Generate">

										<tbody>

											<tr>

												<td>Name</td>

												<td colspan="3">Lorem ipsum dolor sit amet, consectetur</td>

											</tr>

											<tr>

												<td rowspan="">

													Address

												</td>

												<td colspan="3">Fritz Drollinger GmbH & Co.KG<br>z.H. Sebastian Proft<br>Hainbuchenstrasse 12<br>D-83435 Bad Reichenhall<br>Germany </td>

											</tr>

											<tr>

												<td>Name</td>

												<td colspan="3">Lorem ipsum dolor sit amet, consectetur</td>

											</tr>

											<tr>

												<td>Email</td>

												<td colspan="3">xyz@gmail.com</td>

											</tr>

											<tr>

												<td>Phone</td>

												<td colspan="3"></td>

											</tr>

										</tbody>

									</table>

									<table class="table table-striped Generate">

										<tbody>

											<tr>

												<td>Model Name</td>

												<td>Xyzzz</td>

												<td>Date</td>

												<td>29/10/2020 to 31/10/2020</td>

											</tr>

											<tr>

												<td rowspan="">

													Product

												</td>

												<td colspan="3"></td>

											</tr>

											<tr>

												<td rowspan="2">Day</td>

												<td>Date</td>

												<td>Address</td>

												<td>Amount</td>

											</tr>

											<tr>

												<td>29/10/2020</td>

												<td>Fritz Drollinger GmbH & Co.KG z.H. Sebastian Proft Hainbuchenstrasse 12 D-83435 Bad Reichenhall Germany </td>

												<td>1 800.00 EUR</td>

											</tr>

											<tr>

												<td>Service</td>

												<td colspan="3">15% per extra hour Day rate based on an 8 hours day, beginning with the model's</td>

											</tr>

											<tr>

												<td>Employee</td>

												<td colspan="3"></td>

											</tr>

											<tr>

												<td>Agency</td>

												<td colspan="3">300.00 EUR included</td>

											</tr>

										</tbody>

									</table>

									<div class="TableTitle">

										Buyouts

									</div>

									<table class="table table-striped Generate">

										<tbody>

											<tr>

												<td>Additional</td>

												<td colspan="3"></td>

											</tr>

											<tr>

												<td rowspan="">

													Additional Rights

												</td>

												<td colspan="3">

													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

												</td>

											</tr>

											<tr>

												<td rowspan="">

													Additional Rights

												</td>

												<td colspan="3">

													to

												</td>

											</tr>

											<tr>

												<td>Customer</td>

												<td>

													Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod

													tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam

												</td>

											</tr>

										</tbody>

									</table>

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





