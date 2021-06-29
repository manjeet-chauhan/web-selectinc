
<style type="text/css">
	.mwmRate{
		    padding: 10px;
    background-color: #ccc;
    margin-bottom: 34px;
    border-radius: 4px;
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

							<h4>Most Wanted Models@Agency Germany</h4>

							<h5>31.840,95</h5>

							<p>Comission Payment 20th of Month Total :</p>

						</div>

					</div>

					<div class="SmallBox">

						<div class="row">

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Collected Invoice Last Month With VAT</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($collected_last_month_vat as $invoice) {
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
									<a href="<?php echo base_url('collected-invoice-last-month-with-vat') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Collected Net</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($collected_net as $invoice) {
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
									<a href="<?php echo base_url('collected-net') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Collected Vat</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($collected_net as $invoice) {
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
									<a href="<?php echo base_url('collected-vat') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>

							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Collected Invoice Last No Vat</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($collected_invoice_last_no_vat as $invoice) {
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
									<a href="<?php echo base_url('collected-invoice-last-no-vat') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>


							<div class="col-lg-4 col-md-2">
								<div class="Invoice Box">
									<div class="BoxHeading">
										<h6>Advances On Behalf Of MWM</h6>
										<!-- <h5>&nbsp;</h5> -->
									</div>
									<?php 
									foreach ($collected_invoice_last_no_vat as $invoice) {
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
									<a href="<?php echo base_url('advances-on-behalf-of-mwm') ?>"><button type="button" class="btn btn-primary d-block m-auto">Show More</button></a>  
								</div>  
							</div>


						</div>

					</div>

					<div class="OpenTicket Box">

						<div class="BoxHeading">

							<h4>Overview All Months</p>

							</div>

						</div>

						<div class="InvoiceTable  m-0 border-0">	

							<?php 
							$vat = 0;
							$mwm_vat = get_agency_comission();
							if(!empty($mwm_vat)){
								$vat = $mwm_vat->vat_price;
							}
							?>

							<form id="clientManagement" name="clientManagement">
								<div class="mwmRate">
								 	<div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label for="usr">MWM Vat(%)</label>
												<input type="text" class="form-control" placeholder="MWM Vat" id="mwmvat" name="mwmvat" value="<?php echo $vat; ?>">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label for="usr">&nbsp;</label>
												 <button type="submit" class="btn  btn-info btn-block"> SAVE MWM VAT</button>
												
											</div>
										</div>
									</div>	 
							 	</div>

						 	</form>
						 	<div class="clearfix"></div>

						 	<div class="filterControls">
						 		
							<form id="formFilter" name="formFilter">  
							    <div class="row">
							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Months:</label>
								    		<select name="month" id="month" class="form-control">
								    			<option value="" selected>Select Month</option>
								    			<?php 
								    			$months = get_months();
								    			if(!empty($months)){
								    				foreach ($months as $key => $value) {
								    					$selected = '';
								    					if(!empty($month)){
								    						if($month == $key)
								    							$selected = 'selected';
								    					}
								    			?>
								    			<option <?php echo $selected; ?> value="<?php echo $key ?>" ><?php echo $value; ?></option>
								    			<?php
								    				}
								    			}
								    			?>
								    		</select>
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Years:</label>
								    		<select name="year" id="year" class="form-control">
								    			<option value="" selected>Select Year</option>
								    			<?php 
								    			$years = get_years();
								    			if(!empty($years)){
								    				foreach ($years as $value) {
								    					$selected = '';
								    					if(!empty($year)){
								    						if($year == $value)
								    							$selected = 'selected';
								    					}
								    			?>
								    			<option <?php echo $selected; ?>  value="<?php echo $value ?>" ><?php echo $value; ?></option>
								    			<?php
								    				}
								    			}
								    			?>
								    		</select>
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">MWM Vat:</label>
								    		<select name="vat" id="vat" class="form-control">
								    			<option value="" selected>Select Vat</option>
								    			<?php 
								    			$mwm_vat = get_mwm_vat();
								    			if(!empty($mwm_vat)){
								    				foreach ($mwm_vat as $value) {
								    					$selected = '';
								    					if(!empty($mvat)){
								    						if($mvat == $value->vat_price)
								    						$selected = 'selected';
								    					}
								    			?>
								    			<option <?php echo $selected; ?>  value="<?php echo $value->vat_price ?>" ><?php echo $value->vat_price; ?></option>
								    			<?php
								    				}
								    			}
								    			?>
								    		</select>
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Total Amount:</label>
								    		<input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="5600" value="<?php echo $total_amount; ?>">
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Others:</label>
								    		<input type="text" class="form-control" name="other" id="other" placeholder="search" value="<?php echo $other; ?> ">
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<!-- <label for="pwd">.&nbsp;</label> -->
								    		<button style="margin-top: 34px;" type="submit" class="btn btn-primary btn-sm">Filter</button>
								    		<button style="margin-top: 34px;" type="button" class="btn btn-info btn-sm" onclick="$('#formFilter').attr('action', '<?php echo base_url('download-mwm-pdf'); ?>'); $('#formFilter').submit();"><i class="fa fa-download"></i> PDF</button>
								    	</div>
							    	</div>
							    </div>

							    </form>
								 
						 	</div>
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
										<td><?= date('d-m-Y', strtotime($invoice->creation_date));?> </td>
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

            			window.location.reload();

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

