<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js'></script>

<!-- Start Dashboard -->
<style type="text/css">
	.hdelbtn{
		padding: 2px 5px;
		margin-top: -2px;
	}
	.secondDiv{
		margin-top: 8px;
	}

	.table td, .table th {
    padding: 5px;
    
}
</style>
<section class="Dashboard">

	<div class="container">

		<div class="row">

			<div class="col-md-2">

				<?php include 'sidebar.php' ?>

			</div>

			<div class="col-md-10" id="pdf">

				<div class="DashboardContent">

					<div class="OpenTicket Box">

						<div class="BoxHeading generate">

							<h4>Invoice</h4>

						</div>

					</div>

					<div class="OpenTicket Box Boxtwo">

						<div class="InvoiceLogo">

							<img src="<?php echo base_url('assets/frontend/images/logo.png') ?>" alt="Logo" />

						</div>

						<hr>

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
							<hr>

						</div>

						<div class="InvoiceTitle">

							<h3>Invoice</h3>
							<div class="text-center"><a href="<?php echo base_url('generate-invoice-pdf/').$invoice_no;?>" target="blank" class="  " style=""> <i class="fa fa-download"></i> Download Invoice</a></div>

						</div>

						<div class="Table RefundTable">

							<table class="table table-striped table-condensed">

								<thead>

									<tr>

										<th>Ticket ID</th>

										<th>Invoice Number</th>

										<th>Date</th>

									</tr>

								</thead>

								<tbody>

									<tr>

										<td>

											#<?php echo $invoice->issue_id; ?>

										</td>

										<td>

											<?php echo $invoice->invoice_number; echo $invoice->correction == 1 ? '/C' : ''; ?>

										</td>

										<td>

											<?php echo date('d/m/Y', strtotime($invoice->invoice_date)); ?>

										</td>

									</tr>

								</tbody>

							</table>

						</div>

						<div class="ModelMgmt">

							<style type="text/css">

								.InvoiceData {

									font-weight: 600;

								}

							</style>

							<div class="row">

								<div class="col-md-3">

									<div class="InvoiceData">

										<p>Model</p>

									</div>

								</div>

								<div class="col-md-9">

									<div class="InvoiceData">

										<p><?php echo $invoice->m_model_name.', '.$invoice->m_name. ', '.$invoice->m_address_line1. ' - '.$invoice->m_pincode. ', '.$invoice->m_city. ', '.$invoice->m_country  ?></p>

									</div>

								</div>

							</div>

							<div class="row">

								<div class="col-md-3">

									<div class="InvoiceData">

										<p>TIN</p>

									</div>

								</div>

								<div class="col-md-9">

									<div class="InvoiceData">

										<p><?php echo $invoice->m_vat_tin_number ?></p>

									</div>

								</div>

							</div>

							<div class="row">

								<div class="col-md-3">

									<div class="InvoiceData">

										<p>Provided by Trademark</p>

									</div>

								</div>

								<div class="col-md-9">

									<div class="InvoiceData">

										<p>Most Wanted Model <i class="fa fa-registered"></i></p>

									</div>

								</div>

							</div>

							<div class="row">

								<div class="col-md-3">

									<div class="InvoiceData">

										<p>Customer</p>

									</div>

								</div>

								<div class="col-md-9">

									<div class="InvoiceData">

										<p><?php echo $invoice->i_company_name; ?></p>

									</div>

								</div>

							</div>

							<div class="row">

								<div class="col-md-3">

									<div class="InvoiceData">

										<p>Booking Date</p>

									</div>

								</div>

								<div class="col-md-9">

									<div class="InvoiceData">

											<p><?php echo date('d/m/Y', strtotime($invoice->job_date))."-".date('d/m/Y', strtotime($invoice->job_date_till)); ?></p>

									</div>

								</div>

							</div>

							<div class="row">
								<div class="col-md-3">

									<div class="InvoiceData">

										<p>Uses</p>

									</div>

								</div>

								<div class="col-md-9">

									<div class="InvoiceData">

										<p><?php echo  $invoice->uses; ?></p>

									</div>

								</div>

							</div>



							<div id="moretitle">

								<?php

								$count = 1;

								if(!empty($headers)){

									$count = count($headers) + 1;

									 $disabled = 'disabled';

									if($user_id == $invoice->user_id){
										if($invoice->approve == 0 || $invoice->approve == 3){
											 $disabled = '';
										}
									}
																 


									for ($i=0; $i < count($headers); $i++) { 

									?>



										<div class="invoice-cont rowCount<?php echo ($i+1) ?>">

											<div class="row">

												<div class="col-md-3">
													<div class="InvoiceData">
														<input type="hidden"  class="binvoiceid" name="binvoiceid<?php echo ($i+1) ?>" id="binvoiceid<?php echo ($i+1) ?>"  value="<?php echo $headers[$i]->id ?>">

														<p><input type="text"  <?php echo $disabled; ?> class="binvoicetitle" name="invoicetitle<?php echo ($i+1) ?>" id="invoicetitle<?php echo ($i+1) ?>" value="<?php echo $headers[$i]->invoive_title ?>" onblur="manageinvoicedata(this)"></p>

													</div>

												</div>


												<div class="col-md-9">

													<div class="InvoiceData"> 
														<p>

															

															<input type="text" <?php echo $disabled; ?> class="invoivevalue" name="invoivevalue<?php echo ($i+1) ?>" id="invoivevalue<?php echo ($i+1) ?>" value="<?php echo $headers[$i]->invoive_value ?>" onblur="manageinvoicedata(this)">

															 <?php

															if($user_id == $invoice->user_id){
																if($invoice->approve == 0 || $invoice->approve == 3){
																?>
															<button type="button" onclick="deletetitle(this)" class="btn btn-danger btn-sm hdelbtn" id="deleteInvoiceRow<?php echo ($i+1) ?>" value="0"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>

														<?php }} ?>

														</p>

														</div>

													</div>



												</div>

											</div>

											<?php

										}

									}

									?>

								</div>

								<?php

								if($user_id == $invoice->user_id){
									if($invoice->approve == 0 || $invoice->approve == 3){
									?>
									<div><button type="button" class="btn btn-sm btn-primary" onclick="addmoretitle();"> Add More </button></div>
									<?php
									}
								}
								?>

								<div class="Invoicing mt-2"> 

								<div class="Table Invoice">

									<table class="table table-striped Invoice table-condensed" >

										<tbody>

											<tr>
												<th colspan="6">
													<h5 class="text-center">Invoicing on behalf of the model</h5>
													<div class="text-center"><a href="<?php echo base_url('model-invoice-pdf/').$invoice_no;?>" target="blank" class="  " style=""> <i class="fa fa-download"></i> Download </a> &nbsp; &nbsp; 
													<a href="<?php echo base_url('model-invoice-expenses-pdf/').$invoice_no;?>" target="blank" class="  " style=""> <i class="fa fa-download"></i> Download Expenses </a>
												</div>
												</th>
											</tr>

											<?php 
											$ingermany = $invoice->m_ingermany;
											if($invoice->model_budget > 0){
												// if($invoice->apply_model_fee == 1){
											?>
											 
												<tr>
													<th>
														<?php echo $invoice->modelnametext1 ?>
													</th>
													<th> </th>
													<th> </th>
													<th class="text-right"> <?php echo (float)$invoice->model_budget; ?>€  </th>
													<td>
														<?php 
															if(empty($model_data)){
																if($invoice->m_vat_percent <= 0 || $invoice->m_ingermany != 1){
																	echo $invoice->model_budget."€";
																}
															}												 
														?>
													</td>
												</tr> 
													 

											<?php 
												// }
											}
											?>
											<tr>
												<th><?php echo $invoice->modelnametext2 ?>
												<p><small><b><?php echo $invoice->modelothertext ?></b></small></p>
												</th>
												<th> <?php echo $invoice->additional_modal_text ?></th>
												<th> </th>
												<th class="text-right"> <?php echo $invoice->additional_modal_price; ?>€  </th>
												<td>
													<?php 
														if(empty($model_data)){
															if($invoice->m_vat_percent <= 0 || $invoice->m_ingermany != 1){
																echo $invoice->model_total_agreed."€";
															}
														}												 
													?>
												</td>
											</tr> 

											<?php 

											$total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->additional_modal_price;

											// if($invoice->reverse_invoice == 1){
											// 	$total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->additional_modal_price : $invoice->model_budget;
											// }

											if(!empty($model_data)){

												$i = 0;
												$len = count($model_data);

												foreach ($model_data as $modeldata) {
													$total_agreed_amount = $total_agreed_amount + $modeldata->amount;
											?>
												<tr>
													<th><?php echo $modeldata->name; ?></th>
													<th><?php echo $modeldata->title_1; ?></th>
													<th><?php echo $modeldata->title_2; ?></th>
													<th class="text-right"><?php echo $modeldata->amount."€"; ?></th>
													<th class="text-right">
														<?php 
														if($invoice->m_vat_percent <= 0 || $ingermany != 1){
															if ($i == $len - 1) {
														 		echo $total_agreed_amount."€";
															}
														}
														?>
													</th>
												</tr>

											<?php
												$i++;
												}
											}
											
											// echo $total_agreed_amount;
											
											// print_r($invoice);
											$total_modal_exp = 0;
											$total_modal_agreed_exp = $total_agreed_amount;
											// $total_modal_agreed_exp = $invoice->apply_model_fee = 1 ? $invoice->model_budget : $invoice->model_total_agreed;
											$vat_price = 0;
											 //checkForGermany($invoice->model_id);
											if(!empty($ingermany)&&($ingermany==1)){ 
												if($invoice->m_vat_percent > 0){
											?>

												<tr>

													<th> + Vat</th>
													<th class="text-right"> <?php echo $invoice->m_vat_percent ?>%</th>

													<th></th> 

													<th class="text-right"> 
														<?php 
														$vat_price = 0;
														if($invoice->m_vat_percent > 0){
															$vat_price = ($total_agreed_amount*$invoice->m_vat_percent)/100;
														}
														echo $vat_price; 
														$total_modal_agreed_exp = $total_modal_agreed_exp + $vat_price; 
														?>€ 
													</th>

													<td> <b><?php echo ($total_agreed_amount + $vat_price); ?>€ </b></td> 

												</tr>
												<?php 
												}
											}

											if(!empty($expenses)){
												
												$i = 0;
												$view_total = 0;
												foreach ($expenses as $expense) {

													$total_modal_agreed_exp_loc =  $expense->model_exp_amount;
													$vat_exp_price = 0;
													 
													if($expense->vat_include == 1 && $ingermany==1){ 
														if($expense->vat_percent > 0){
															$vat_exp_price = ($expense->model_exp_amount*$expense->vat_percent)/100;
															$total_modal_agreed_exp_loc = $total_modal_agreed_exp_loc + $vat_exp_price;
														}
													}
													 
													$total_modal_agreed_exp = $total_modal_agreed_exp + $total_modal_agreed_exp_loc; 

													$view_total = $view_total + $total_modal_agreed_exp_loc
													?>
													<tr class="text-right">
														<td class="text-left"> 
															<div><?php echo $expense->model_expense; ?></div>

															<?php 
															if($expense->vat_include == 1 && $ingermany==1){
															?>
															<div class="secondDiv"> Plus VAT</div>

															<?php 
															}
															?>

														</td>
														<td>   
															<div>&nbsp;</div>
															<?php 
																if($expense->vat_include == 1 && $ingermany==1){
															?>
															<div class="secondDiv"> <?php echo (int)$expense->vat_percent; ?>%</div>
															<?php 
																}
															?>
														</td>
														<td> 
															
															
														</td>
														<td>  
															
															<div> 

															<?php 
															if($expense->vat_include == 1 && $ingermany==1){
															?>
															<div > <?php echo $expense->model_exp_amount;  ?>€</div>
															
															<?php
															 echo '<div class="secondDiv">'.$vat_exp_price . "€ </div>"; 
															}
															?> 
															 
														</td> 
														<td> 
														
														<?php 
														if ($expense->vat_include == 1 && $ingermany==1) {

														 echo '<div>&nbsp;</div> <div class="secondDiv">'.$total_modal_agreed_exp_loc."€ </div>";  
														}
														else{
														?>
														<div> <?php echo $expense->model_exp_amount;  ?>€</div>
														<?php
														}
														?>
														  
														</td> 
													</tr> 
													<?php 
												}
											} 
											?> 
 
											<tr>
												<th colspan="5">
													<h5 class="text-center">Invoicing on behalf of most wanted models agency Germany Erika-Mann-Strasse-21,8000 Munich</h5>
													<div class="text-center"><a href="<?php echo base_url('mwm-invoice-pdf/').$invoice_no;?>" target="blank" class="  " style=""> <i class="fa fa-download"></i> Download </a></div>

												</th>
											</tr>

											<?php 

											$reverse_amount = 0;

											// $agency_commission = get_agency_comission();
											$commisssion  = $invoice->model_agency_comission; //$agency_commission->serivice_comission;
											$com_price_agree = ((($invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->additional_modal_price) * $commisssion)/100);

											// $total_agreed_amount = $invoice->apply_model_fee == 1 ? $invoice->model_budget : $invoice->additional_modal_price;
											$total_modal_agreed_exp = $total_modal_agreed_exp + $com_price_agree; 
											?>

											<tr>

												<th>
												Agency commission
												<p><small><b><?php echo $invoice->acommissionothertext ?></b></small></p>
											</th>
												<th class="text-right"><?php echo $commisssion; ?>%</th>
												<th>  </th>
												<td class="text-right"> 
													<?php 
													if($ingermany==1 ){
														echo $com_price_agree.'€'; 
													}
													?> 
												</td>
												<th class="text-right">  
													<?php 
													if( $ingermany!= 1 ){
														echo $com_price_agree.'€'; 
													}
													?> 
												</th>
											</tr>

											<?php  

											if(!empty($invoice->mwm_reverse_data)){
												$r_array = json_decode($invoice->mwm_reverse_data);

												$r_count = count($r_array);
												$rc_count = 0;
												foreach($r_array as $reverse){
													$reverse_amount = $reverse_amount + $reverse->amount;
											?>

											<tr>

												<th>								
													<?php 
													if(!empty($reverse->name)){  
													 echo $reverse->name;
													} ?>
												</th>
												<th class="text-right">&nbsp;</th>
												<th> <?php  echo $reverse->title; ?> </th>
												<td class="text-right"> <?php  echo $reverse->amount.'€'; ?> </td>
												<th  class="text-right"> &nbsp;
													<?php 
													++$rc_count;
													if($r_count == $rc_count){
														// if(($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1)){
														// 	$com_price_agree_vat = (($com_price_agree * $invoice->vat_price)/100);
															// if ($com_price_agree_vat <= 0) {
														 		echo  ($com_price_agree + $reverse_amount).'€';  		
														// 	}  													 
														// }
													}
													?> 
												</th>
											</tr>


											<?php
												}
											}

											$com_price_agree_vat = 0;
											if(($invoice->vat_price > 0)&&!empty($ingermany)&&($ingermany==1)){
												
												$com_price_agree_vat = (($com_price_agree * $invoice->vat_price)/100);
												$total_modal_agreed_exp = $total_modal_agreed_exp + $com_price_agree_vat;
											?> 

												<tr>
													<td> + VAT </td>
													<td  class="text-right"><?php echo $invoice->vat_price ?>%</td>
													<td>  </td>
													<td  class="text-right"><?php echo  $com_price_agree_vat  ?>€ </td> 
													<td  class="text-right"><b><?php echo  ($com_price_agree + $com_price_agree_vat);  ?>€ </b></td> 
												</tr>

												<?php

											}

											?> 
 
 	
											<?php 
											if(!empty($services)){
											?>
											<tr>
												<th colspan="5"><h5 class="text-center">Invoicing on behalf of Select Partners Inc.</h5>
													<div class="text-center"><a href="<?php echo base_url('partners-invoice-pdf/').$invoice_no;?>" target="blank" class="  " style=""> <i class="fa fa-download"></i> Download </a></div> 

												</th>
											</tr>
											<?php
											}
											if(!empty($services)){
												
												$i = 0;
												$view_total = 0;
												foreach ($services as $service) {

													$total_modal_agreed_ser_loc =  $service->model_ser_amount;
													$vat_ser_price = 0;
													 
													if($service->vat_include == 1 && $ingermany==1){ 
														if($service->vat_percent > 0){
															$vat_ser_price = ($service->model_ser_amount*$service->vat_percent)/100;
															$total_modal_agreed_ser_loc = $total_modal_agreed_ser_loc + $vat_ser_price;
														}
													}
													 
													$total_modal_agreed_exp = $total_modal_agreed_exp + $total_modal_agreed_ser_loc; 

													$view_total = $view_total + $total_modal_agreed_ser_loc
													?>
													<tr class="text-right">
														<td class="text-left"> 
															<div><?php echo $service->model_service; ?></div>

															<?php 
															if($service->vat_include == 1 && $ingermany==1){
															?>
															<div class="secondDiv"> Plus VAT</div>

															<?php 
															}
															?>

														</td>
														<td>   
															<div>&nbsp;</div>
															<?php 
																if($service->vat_include == 1 && $ingermany==1){
															?>
															<div class="secondDiv"> <?php echo (int)$service->vat_percent; ?>%</div>
															<?php 
																}
															?>
														</td>
														
														<td>  </td>

														<td>  
															
															<div> 

															<?php 
															if($service->vat_include == 1  && $ingermany==1){
															?>
															<div > <?php echo $service->model_ser_amount;  ?>€</div>
															
															<?php
															 echo '<div class="secondDiv">'.$vat_ser_price . "€ </div>"; 
															}
															?> 
															 
														</td> 
														<td> 
														
														<?php 
														if ($service->vat_include == 1 && $ingermany==1) {

														 echo '<div>&nbsp;</div> <div class="secondDiv">'.$total_modal_agreed_ser_loc."€ </div>";  
														}
														else{
														?>
														<div> <?php echo $service->model_ser_amount;  ?>€</div>
														<?php
														}
														?>
														  
														</td> 
													</tr> 
													<?php 
												}
											}

											
											?>

											<tr class="Total">

												<td>Total</td>

												<td></td>

												<td></td>
												<td></td>

												<td><?php echo $total_modal_agreed_exp; ?> <i class="fa fa-eur" aria-hidden="true"></i> </td></td></td>

											</tr> 
										</tbody>

									</table>

								</div> 
								<div id="displaymsg"></div>

								<?php 

								$edit_url = base_url('edit-invoive?invoive=').$invoice_no;
								
								if($invoice->reverse_invoice){
									$edit_url = base_url('edit-reverse-charge-invoice?invoive=').$invoice_no;
								}

								if(!empty( $invoice)){
									if($user_id == $invoice->user_id){
									 
										if($invoice->approve == 0){
								?>
								<div class="Invoicing">
									<div class="Issue">
										<div class="BtnBox text-right mt-4 mb-4">
											<div class="row">
												<div class="col-md-3">&#160;</div>
												<div class="col-md-4">
													<a href="<?php echo $edit_url; ?>"><button type="button " class="btn cancel btn-info" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Edit / Back</button></a> 
												</div>
												
												<div class="col-md-5">
													<form class="formSendApproval" id="formSendApproval">
														<select class="custom-select" style="height: 50px;" name="assignee" id="assignee" required>
															<option value="" selected disabled>  Select Redmine Assignee  </option>

															<?php 
															if(!empty($_clients)){
																$assignee_role = get_issue_type();
																foreach ($_clients as $client) {

																	$assignee = $client->name." (". $assignee_role[$client->redmine_assignee].") ";
															?>

															<option value="<?php echo $client->id; ?>"> <?php echo $assignee; ?> </option>

															<?php
																}
															}
															?>
														
														</select>

														<input type="hidden" name="sendapprovalinvoice"  id="sendapprovalinvoice" value="<?php echo $invoice_no ?>">
														<button type="submit" class="btn cancel" data-toggle="modal" data-target="#" style="margin-top: 4px; width: 100%;"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Forward for approval </button> 
													</form>
												</div> 

												

											</div>
										</div> 
									</div>
								</div>	

								<?php 
									}

								else if($invoice->approve == 2){
								?>
								<div class="row">
									<div class="col-md-4">&#160;</div>
									<div class="col-md-4">
										<button type="button " class="btn cancel btn-danger" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Sent For Approval</button>  
									</div>
								</div>

								<?php
								
								}
								else if($invoice->approve == 1){
								?>
								<div class="row">
									<div class="col-md-4">&#160;</div>
									<div class="col-md-4">
										<button type="button " class="btn cancel btn-success" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Approved </button> 
									</div>
								</div>

								<?php
								
									}
									else if($invoice->approve == 3){
									?>
									<div class="row">
										<div class="col-md-3">&#160;</div>
										<div class="col-md-4">
											<a href="<?php echo $edit_url; ?>"><button type="button " class="btn cancel btn-warning" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Request For Change </button></a> 
										</div>

										<div class="col-md-5">
											<form class="formSendApproval" id="formSendApproval">
												<select class="custom-select" style="height: 50px;" name="assignee" id="assignee" required>
													<option value="" selected disabled>  Select Redmine Assignee  </option>

													<?php 
													if(!empty($_clients)){
														$assignee_role = get_issue_type();
														foreach ($_clients as $client) {
															$assignee = $client->name." (". $assignee_role[$client->redmine_assignee].") ";

															$selected = '';
															if($client->id == $invoice->assignee_to){
																$selected = 'selected';
															}
													?>

													<option <?php echo $selected; ?> value="<?php echo $client->id; ?>"> <?php echo $assignee; ?> </option>

													<?php
														}
													}
													?>
												
												</select>

												<input type="hidden" name="sendapprovalinvoice"  id="sendapprovalinvoice" value="<?php echo $invoice_no ?>">
												<button type="submit" class="btn cancel" data-toggle="modal" data-target="#" style="margin-top: 4px; width: 100%; background-color: #00a963;"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Forward for approval </button> 
											</form>
										</div>

									</div>

									<?php
									
										}
									}

								else if($user_id == $invoice->assignee_to){
									if($invoice->approve == 2){
								?>
								<div class="row">
									<div class="col-md-4">&#160;</div>
									<div class="col-md-4">
										<button data-toggle="modal" data-target="#approveInvoice" data-invoice="<?php echo $invoice_no; ?>"  type="button " class="btn cancel btn-warning" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Approve </button>  
									</div>
								</div>

								<?php
									}
									else if($invoice->approve == 1){
								?>
								<div class="row">
									<div class="col-md-4">&#160;</div>
									<div class="col-md-4">
										<button type="button " class="btn cancel btn-success" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Approved </button> 
									</div>
								</div>

								<?php
								
									}
								}
							}
								?>

							</div>

						</div>




					</div>

				</div>

			</div>

		</div>

	</section>

	<input type="hidden" name="addtitlecount" id="addtitlecount" value="<?php echo $count; ?>">
	<div id="moretitledemo" style="display: none;">
		<div class="invoice-cont rowCount@count@">
			<div class="row">

				<div class="col-md-3">

					<div class="InvoiceData">
						<input type="hidden"  class="binvoiceid" name="binvoiceid@invid@" id="binvoiceid@invid@"  value="0">
						<p><input type="text"  class="binvoicetitle" name="invoicetitle@title@" id="invoicetitle@titleid@" onblur="manageinvoicedata(this)"></p>
					</div>
				</div>
				<div class="col-md-9">
					<div class="InvoiceData">
						<p><input type="text" class="invoivevalue" name="invoivevalue@titleval@" id="invoivevalue@titlevalid@" onblur="manageinvoicedata(this)">
							<button type="button" onclick="deletetitle(this)" class="btn btn-danger btn-sm hdelbtn" id="deleteInvoiceRow@deleteval@" value="0"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
						</p>
					</div>
				</div>
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

	<iframe id="my_iframe" style="display:none;"> Hello Manjeet How are u?</iframe>
	<script>

		$(function(){

			$('#formSendApproval').submit(function(e){


				e.preventDefault();

				$('#displaymsg').removeClass(' alert alert-info');
				$('#displaymsg').removeClass(' alert alert-success');
				$('#displaymsg').removeClass(' alert alert-danger');

				$('#displaymsg').html('Please wait');
				$('#displaymsg').show().delay(5000).fadeOut();
				$('#displaymsg').addClass(' alert alert-info'); 

				$.ajax({

					url: '<?php echo base_url('forward-invoice-approval'); ?>',
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData: false,
					async: true,
					success: function (data) { 

						$('#displaymsg').removeClass(' alert alert-info');
						if(data == "success"){

							$('#displaymsg').html('Forward to assistant for approval successfully');
							$('#displaymsg').show().delay(5000).fadeOut();
							$('#displaymsg').addClass(' alert alert-success');
							window.location.href = "<?php echo base_url(); ?>";
            			// location.reload();
            			return true; 
            		} 
            		if(data == "error"){

            			$('#displaymsg').html('Error to forward to assistant for approval, retry');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-danger');
            			return false;
            		}

            		$('#displaymsg').html(data);
            		$('#displaymsg').show().delay(5000).fadeOut();
            		$('#displaymsg').addClass(' alert alert-danger');
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
		})
	




		function Download() {
			var url = window.location.href;
			document.getElementById('my_iframe').src = url;
		}
// $(function(){
// 	Download(window.location.href);
// })

</script>


<!-- End Dashboard -->

<script type="text/javascript">

	function addmoretitle() {



		var title_id = $('#addtitlecount').val();

		var title_data = $('#moretitledemo').html();



		title_data = title_data.replace('@count@', title_id);

		title_data = title_data.replace('@invid@', title_id);

		title_data = title_data.replace('@invid@', title_id);



		title_data = title_data.replace('@title@', title_id);

		title_data = title_data.replace('@titleid@', title_id);



		title_data = title_data.replace('@titleval@', title_id);

		title_data = title_data.replace('@titlevalid@', title_id);


		title_data = title_data.replace('@deleteval@', title_id);

		

		$('#moretitle').append(title_data);

		$('#addtitlecount').val(parseInt(title_id) + 1);

	}


	function deletetitle(thisDel) {

		var result = confirm("Are you sure, you Want to delete?");
		if (result) { 
	    	// var title_id = $('#addtitlecount').val();
	    	var index = $(thisDel).attr('id').replace('deleteInvoiceRow','');
	    	var remove = 'rowCount'+index;
	    	var rowId = $('#binvoiceid'+index).val();

	    	if(rowId!=0){
	    		

	    		$.ajax({

	    			url: '<?php echo base_url('delete-invoice-headers'); ?>',

	    			type: "POST",

	    			data: {

	    				inv_id : rowId

	    			},

	    			success: function (data) {

	    				var response = JSON.parse(data);

	    				if(response['error'] == 'success'){
	    					console.log('Deleted!');

	    				}else{
	    					console.log('error in deleting');
	    				}

	    			}

	    		});

	    	}
	    	$('.'+remove).remove(); 

	        // $('#addtitlecount').val(parseInt(title_id) - 1);
	    }

	}



	function manageinvoicedata(thisObj){

		var _inv_id = $(thisObj).closest('.invoice-cont').find('input[type="hidden"].binvoiceid').val(); 

		var _inv_title = $(thisObj).closest('.invoice-cont').find('input[type="text"].binvoicetitle').val();

		var _inv_value = $(thisObj).closest('.invoice-cont').find('input[type="text"].invoivevalue').val();

		if(_inv_title != '' && _inv_value != ''){

			$.ajax({

				url: '<?php echo base_url('generate-invoice-headers'); ?>',

				type: "POST",

				data: {

					inv_number : '<?php echo $invoice->invoice_number; ?>',

					inv_id : _inv_id,

					inv_title : _inv_title,

					inv_value : _inv_value

				},

				success: function (data) {

					var response = JSON.parse(data);

					if(response['error'] == 'success'){

						$(thisObj).closest('.invoice-cont').find('input[type="hidden"].binvoiceid').val(response['data']);

					}

				}

			});

		}

		// alert(_inv_title + "------" + _inv_value);

	}







</script>



