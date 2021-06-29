<style type="text/css">

	.Overview a.btn{

		color: #fff !important;

	}

.invoicedata label{
	font-weight: bold;
	/*font-size: 14px;*/
	margin-bottom: 0;
}

.invoicedata .title{
	background-color: #e1e1e1;
	padding: 3px;

}
.invoicedata{
	margin: 15px;
	text-align: center;
}

.nopadding{
	padding: 0;
}

.moreinfodata .single-row{
	margin-bottom: 8px;
	}
.moreinfodata  .title{
	font-weight: bold;
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
							<h4> Partner Invoice Detail [<?php echo $invoive_id; ?>] </h4>				 
						</div>
					</div>



					<div class="OpenTicket Box">

						<div class="modelDetails">
							<div class="address1"> <?php echo $invoice[0]->address1 ?> </div>
							<div class="address2"> <?php echo $invoice[0]->address2 ?> </div>
							<div class="address3"> <?php echo $invoice[0]->address3 ?> </div>
							<div class="address4"> <b><?php echo $invoice[0]->address4 ?> </b></div>
						</div>

						 <h4 class="text-center"> INVOICE </h4>
						 <div class="text-center"><a href="<?php echo base_url('download-general-invoice-pdf/').$invoive_id; ?>"><i class="fa fa-download"></i> Download Pdf</a></div>
						 <br>

						 <div class="invoicedata">
						 	<div class="row">
						 		<div class="col-md-4 nopadding">
									<div class="form-group">
									    <div class="title"><label for="email">Token Id</label></div>
									    <div class="info"><?php echo $invoice[0]->issue_id ?></div>
									 </div>
								</div>

								<div class="col-md-4 nopadding">
									<div class="form-group">
									    <div class="title"><label for="email">Invoice number</label></div>
									    <div class="info"><?php echo $invoice[0]->invoice_number ?></div>
									 </div>
								</div>

								<div class="col-md-4 nopadding">
									<div class="form-group">
									    <div class="title"><label for="email">Date:</label></div>
									   <div class="info"> <?php echo $invoice[0]->i_date ?></div>
									 </div>
								</div>
						 	</div>
						 </div>
						 <br>
						 <br>
						 <div class="moreinfodata">
							<div class="row single-row">
								<div class="col-md-2"><div class="title">Customer : </div></div>
								<div class="info"> <?php echo $invoice[0]->client ?></div>
							</div>

							<div class="row single-row">
								<div class="col-md-2"><div class="title">TID : </div></div>
								<div class="info"> <?php echo $invoice[0]->tin ?></div>
							</div>

							<div class="row single-row">
								<div class="col-md-2"><div class="title">Booking Date : </div></div>
								<div class="info"> <?php echo $invoice[0]->booking_date ?></div>
							</div>

							<?php 
							if(!empty($invoice[0]->headers)){
								$headers = json_decode($invoice[0]->headers);
								foreach($headers as $header){
							?>

							<div class="row single-row">
								<div class="col-md-2"><div class="title"><?php echo $header->title ?> : </div></div>
								<div class="info"> <?php echo $header->details ?> </div>
							</div>


							<?php
								}
							}
							?>
							 

						</div>

						<div class="Table  Overview">


							
 
							<table class="table table-striped">

								<?php 

								$currency_array = get_currency_list();

								if(!empty($invoice)){

									$currency = '€';
									if(!empty($currency_array)){
										foreach($currency_array as $curr){

											if($curr->code == $invoice[0]->currency){
												$currency = $curr->symbol ;
											}
											
										}
									}


								?>

						
								<?php

								}
								?>
								

								 
									

									<?php

									$count = 0;
									$total = 0;
									foreach ($invoice as $data) {
										// $invoice_url = base_url('generate-invoice/').$invoice->invoice_number;
										// $edit_url = base_url('edit-invoive?invoive=').$invoice->invoice_number; 
									?>

									<tr>
										 <td><?php echo $data->name ?></td>
										 <td><?php echo $data->title_1 ?></td>
										 <td><?php echo $data->title_2 ?></td>
										 <td><?php echo $currency.$data->amount ?></td>
										 <td><?php echo $currency.$data->percentage ?></td>
										 <td><?php echo  $currency.($data->amount - $data->percentage); ?></td>

									</tr>

									<?php
									$total = $total + $data->amount - $data->percentage;

								}

									?>

								 <tr style="border-top:2px solid #ccc; border-bottom:2px solid #ccc">
										 <th colspan="5"> Total/Gross</th>
										  
										 <th class="text-right"><?php echo  $currency.$total; ?></th>

									</tr>

								 

							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>
 

 




