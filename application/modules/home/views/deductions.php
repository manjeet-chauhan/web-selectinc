

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

							<h4>DEDUCTIONS- EXPENSES Models</h4>

							<h5>&#8364; 32.460,50 </h5>

							<p>Open/not deducted yet from incomes</p>

						</div>

					</div>

					<div class="OpenTicket Box mt-4" style="border-radius: 0px;">

						<div class="Expence">

								<!-- Nav tabs -->

								<div class=""> 
									
									<div class="col-md-12">
										<div class="filterControls">
						 		
							<form id="formFilter" name="formFilter">  
							    <div class="row">
							    	<!-- <div class="col-md-2">
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
							    	</div> -->

							    	<!-- <div class="col-md-2">
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
							    	</div> -->

							    	<!-- <div class="col-md-2">
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
							    	</div> -->

							    	<!-- <div class="col-md-2">
							    		<div class="form-group">
									    	<label for="pwd">Total Amount:</label>
								    		<input type="number" class="form-control" name="total_amount" id="total_amount" placeholder="5600" value="<?php echo $total_amount; ?>">
								    	</div>
							    	</div> -->

							    	<div class="col-md-10">
							    		<div class="form-group">
									    	<label for="pwd">Others:</label>
								    		<input style="width:100%" type="text" class="form-control" name="search" id="search" placeholder="search" value="<?php echo $search; ?> ">
								    	</div>
							    	</div>

							    	<div class="col-md-2">
							    		<div class="form-group">
									    	<!-- <label for="pwd">.&nbsp;</label> -->
								    		<button style="margin-top: 34px;" type="submit" class="btn btn-primary btn-sm btn-primary btn-block">Filter</button>
								    	
								    	</div>
							    	</div>
							    </div>

							    </form>
								 
						 	</div>
									
									</div>

								</div>

								

							<!-- Tab panes -->

							<div class="tab-content">

								<div class="Table">

							<table class="table table-striped">

								<thead>
									<tr>
										<th>Model Name</th>
										<th>Full Name</th>
										<th>Date</th>
										<!-- <th>Service Fee</th> -->
										<th style="width: 10%;">Expenses</th>
										<!-- <th style="width: 10%;">View</th>
										<th style="width: 10%;">Edit</th> -->
									</tr>
								</thead>

								<tbody>

									<?php 

									if(!empty($models)){
										foreach ($models as $model) { 
											$redirect_deduction = base_url('create-deduction-transaction/').$model->unique_code;
											// $redirect_view = base_url('model-management-detail/').$model->unique_code;
											// $redirect_edit = base_url('edit-model-management/').$model->unique_code;
									?>

									<tr>

										<td><?php echo $model->model_name;  ?></td>
										<td><?php echo $model->name; ?></td>
										<!-- <td><?php echo $model->address_line1; ?></td>
										<td><?php echo $model->service_fee; ?>%  </td> -->
										<td><?php echo date('d-m-Y', strtotime($model->creation_date)); ?></td>

										<td><a href="<?php echo $redirect_deduction; ?>"><button type="button" class="btn btn-primary btn-sm"> Expenses</button></a></td>
										<!-- <td><a href="<?php echo $redirect_view; ?>"><button type="button" class="btn"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a></td>
										<td><a href="<?php echo $redirect_edit; ?>"><button type="button" class="btn"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</button></a></td> -->

									</tr>



									<?php

										}

									}

									?>

									 

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

</section>

<!-- End Dashboard -->

