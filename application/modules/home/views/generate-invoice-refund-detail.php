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

              .invoiceHeader{

                  text-align: center;

                  font-size: 18px;
                  font-weight: bold;

                  color: #000; 

                   
                  padding-bottom: 5px; 

              }

              .headerData{

                margin-top: 10px;

              }

              .singleHRecordTitle{

                font-weight:400;

                width:33.33%;

                float:left;

                color: #000;               

              }

              .singleHRecordDesc{

                width:66.66%;

                float:left; 

                color: #000;                 

              }

              .addressHRecord{
 

                padding-bottom: 5px; 


              }

              .singleHRecordCompany{

                color: #000;

              }

              .fontbold{

               font-weight:bold;

              }

              .font-sm{

                font-size: 13px;

              }

              .invoiceHInfo{

 

              }

              .invoiceHInfo .invoiceHInfoSingle{

                 width: 33.33%;

                 float: left;



              }

              .invoiceHInfoTitle{

                color : #000;

              }

              .alter1{

                background-color:#fff;

                padding: 8px 5px;

              }

              .alter2{

                background-color:#f1f1f1;

                padding: 5px;

              }

              .displaymodelBudget{

                // background-color: #333;

                padding: 5px;

                

              }



              .displaymodelBudget .singleHRecordTitle, .displaymodelBudget .singleHRecordDesc{

                color: #fff !important;

              }

              .behalyOfModel{

                font-style: italic;

                margin-top: 15px;

                padding-bottom:5px;

                border-bottom: 2px solid #e1e1e1;

                color: #000;

              }

              .rightText{

                text-align: right;

              }



              .model5Coloumn{

                width: 100%;

              }

              .invoiceHInfoSingleLarge{

                width:30%;

                float:left;

                color: #000;

              }

              .invoiceHInfoSingleSmall{

                width:17%;

                float:left;

                color: #000;

              }

              .colorwhite .invoiceHInfoSingleSmall .invoiceHInfoDescriptionsm, .colorwhite .invoiceHInfoSingleLarge .invoiceHInfoTitleLarge {
                color: #fff !important;
              }
              .secondDiv{
                margin-top: 5px;
              }

              .modelDetails{
                padding-top:55px;
              }

              .borderCredit{
                border-top:1px solid #666;
                border-bottom:1px solid #666;
                padding: 4px 20px;
                text-align:right;
                font-size: 16px !important;
              }

              .borderMdldetail{
                background-color: #e1e1e1;
                padding: 5px;
                box-shadow: 5px 5px #000;
              }

              .r4cont{ 
                width:100%;
                padding: 2px;
                border-bottom:1px solid #666;
              }
             .r4{
                float:left;
                width:24.9%;
                
              }
              .r34{
                float:right;
                width:75%;
              }
              .mdesc{
                background-color: #ccc;
              }

              .refundInvoice{
                background-color: #e1e1e1;
                padding: 5px;
                box-shadow: 5px 5px #000;
              }


              .irow{ 
                width:100%;
                padding: 2px;
                border-bottom:1px solid #666;
                 
              }
             .one3rd{
                float:left;
                width:75%; 
              }
              .one4th{
                float:right;
                width:24.9%;
              }

              .idesc{
                background-color: #ccc;
                text-align:right;
              }

              .splrow{
                width: 100%;
              }

              .w40{
                float:left;
                width:39%;
              }
              .w60{
                float:right;
                width:60%;
                background-color: #ccc;
                margin-top:5px;
              }

              .fleft{
                float:left;
                width:59%;
              }
              .fright{
                float:right;
                width:40%;
                text-align:right;
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

							<h4>Refund</h4>

						</div>

					</div>

					<div class="OpenTicket Box Boxtwo">

						<div class="InvoiceLogo">

							<img src="<?php echo base_url('assets/frontend/images/logo.png') ?>" alt="Logo" />

						</div>
 

						<div class="ModelMgmt">								
							<div class="Invoicing mt-2"> 
								<div class="Table Invoice">

									<?php 
				$vat_price = 0;
    $ingermany = $invoice_info->m_ingermany;
    $correction = $invoice_info->correction == 1 ? '/C' : '';
    $model_budget = $invoice_info->apply_model_fee == 2 ? $invoice_info->model_total_agreed : $invoice_info->model_budget;

    $vat_price = 0;
    if(!empty($ingermany)&&($ingermany==1 && $invoice_info->m_vat_percent > 0)){
      if($invoice_info->m_vat_percent > 0){
        $vat_price = ($model_budget*$invoice_info->m_vat_percent)/100;
      }
   }

    $m_sfee = 0;

   if($invoice_info->m_service_fee > 0){
      $m_sfee = ($model_budget * $invoice_info->m_service_fee)/100;
   }

	$specialcharges = 0;
   	$travelcost = $invoice_info->VatmodelExp + $invoice_info->modelExp;
   	$total_sum = $model_budget + $vat_price - $m_sfee - $specialcharges + $travelcost;


	$max = 0;
	$min = 0;
	$total_d = 0;

	$block_edit = '';
	
	
	if($invoice_info->refund == 1){
		if($invoice_info->deduction_amout > 0){
			$max =  $invoice_info->deduction_amout;
			$min = $max;
			$block_edit = 'disabled';
		}
	}
	else if(!empty($deduction_info->wallet)){
		$total_d =  $deduction_info->wallet;
		if($deduction_info->wallet < $total_d){			
			$max = $total_d;
		}
		else{
			$max = $total_sum;
		}
	}

	$travalcost = $invoice_info->refund == 1 ? $invoice_info->travel_cost_amount : $invoice_info->modelExp;
	$travalcost_vat = $invoice_info->refund == 1 ? $invoice_info->travel_cost_vat : $invoice_info->VatmodelExp;

	?>

	
		<div class="OpenTicket Box Boxtwo NoRadiusForm">

			

			<div class="Invoicing">
				<div class="InputBox Search brbottom">
					<div><h3>Refund</h3></div> 
				</div>
			</div>
			<div class="text-center"><a href="<?php echo base_url('refund-invoice-pdf/').$invoice_no;?>" target="blank" class="  " style=""> <i class="fa fa-download"></i> Download Refund</a></div>

			<div class="NewInvoice">


			<div class="modelDetails">
              <div><?php echo $model->name; ?></div>
              <div><?php echo $model->address_line1; ?></div>
              <div><?php echo $model->city; ?>, <?php echo $model->pincode; ?></div>
              <div><?php echo $model->country; ?><br/> <br/></div> 
            </div>

            <div class="borderMdldetail">
              <div class="borderCredit"> credit note &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $invoice_info->credit_note; ?> </div>

              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Modelname</div></div>
                <div class="r4"><div class="mdesc"><?php echo $invoice_info->m_model_name ; ?></div></div>
                <div class="r4"><div class="mtitle">&nbsp;&nbsp;Date of job</div></div>
                <div class="r4"><div class="mdesc"><?php echo date('d/m/Y', strtotime($invoice_info->job_date)).'-'.date('d/m/Y', strtotime($invoice_info->job_date_till)) ; ?></div></div>
                <div class="clearfix"></div>
              </div>


              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Taxnumber</div></div>
                <div class="r4"><div class="mdesc"><?php echo $invoice_info->m_vat_tin_number ; ?></div></div>
                <div class="r4"><div class="mtitle">&nbsp;&nbsp;Job Nr</div></div>
                <div class="r4"><div class="mdesc"><?php echo $invoice_no ; ?></div></div>
                <div class="clearfix"></div>
              </div>


               <?php 
              // print_r($invoice_info);
              if(!empty($headers)){

                $hcount = count($headers);
                $loop = $hcount/2;

                if($loop >= 1){
                for ($i=0; $i < $loop; $i++) { 
              ?>

              <div class="r4cont"> 
                <div class="r4"><div class="mtitle"><?php echo $headers[$i]->invoive_title; ?></div></div>
                <div class="r4"><div class="mdesc"><?php echo $headers[$i]->invoive_value; $i++; ?></div></div>
                <div class="r4"><div class="mtitle"><?php echo $headers[$i]->invoive_title; ?></div></div>
                <div class="r4"><div class="mdesc"><?php echo $headers[$i]->invoive_value; ?></div></div>
                <div class="clearfix"></div>
              </div>

              <?php
                   
                }
              }

              if($hcount % 2 > 0){

                if($hcount <= 1){
                  $i = 0;
                }
              ?>
              <div class="r4cont"> 
                <div class="r4"><div class="mtitle"><?php echo $headers[$i]->invoive_title; ?></div></div>
                <div class="r34"><div class="mdesc"><?php echo $headers[$i]->invoive_value; ?></div></div>
                <div class="clearfix"></div>
              </div>
              <?php
              }
              }
              ?>


              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Client</div></div>
                <div class="r34"><div class="mdesc"><?php echo $invoice_info->i_company_name ; ?></div></div>
                <div class="clearfix"></div>
              </div>
            
              <div class="r4cont"> 
                <div class="r4"><div class="mtitle">Uses</div></div>
                <div class="r34 full"><div class="mdesc"><?php echo $invoice_info->uses ; ?></div></div>
                <div class="clearfix"></div>
              </div>
            </div>

            <div style="font-size: 13px; margin: 15px 0;"> We Invoiced as follows in your name: </div>
            

            <div class="refundInvoice">  
                <div class="irow">
                    <div class="one3rd"> Honorarium <?php echo $invoice_info->honorarium_text; ?> </div>
                    <div class="one4th"> <div class="idesc"><?php echo number_format($model_budget, 2) ; ?>€</div> </div>
                    <div class="clearfix"></div>
                    <div class="splrow">
                        <div class="w40">&nbsp;</div>
                        <div class="w60"><div class="fleft"> VAT &nbsp; &nbsp; <?php echo number_format($invoice_info->m_vat_percent, 1) ; ?>% </div> <div class="fright"> + <?php echo number_format($vat_price, 2) ; ?>€  </div> </div>
                        <div class="clearfix"></div>
                    </div> 
                </div> 

                <div class="irow">
                    <div class="one3rd"> Servicefee &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php echo number_format($invoice_info->m_service_fee, 2); ?>% 
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc"> - <?php echo number_format($m_sfee, 2) ; ?>€</div> </div>
                    <div class="clearfix"></div>
                </div> 

                 <div class="irow">
                    <div class="one3rd"> Specialcharge &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php echo number_format($invoice_info->special_charget_vat > 0 ? $invoice_info->special_charget_vat : 0, 2); ?>% 
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc"> - <?php echo number_format($invoice_info->special_charge_amount > 0 ? $invoice_info->special_charge_amount : 0, 2) ; ?>€</div> </div>
                    <div class="clearfix"></div>
                </div> 

                <div class="irow">
                    <div class="one3rd"> <?php echo $invoice_info->deduction_text != '' ? $invoice_info->deduction_text : 'Deduction' ?>
                    <div style="font-size: 11px; margin: 2px 0;"> VAT free, because placeof performance at the place of residence of the recipient </div>
                    </div> 
                    <div class="one4th"> <div class="idesc">  <?php echo $max ?> </div> </div>
                    <div class="clearfix"></div>
                </div> 

                <div class="irow">
                    <div class="one3rd"> SUBTOTAL </div> 
                    <div class="one4th"> <div class="idesc"><?php echo number_format(($model_budget + $vat_price - $m_sfee - $invoice_info->special_charge_amount - $invoice_info->deduction_amout) , 2) ; ?>€</div> </div>
                    <div class="clearfix"></div>
                </div>

                <div class="irow">
                    <div class="one3rd"> Travel costs </div> 
                    <div class="one4th"> <div class="idesc"> + <?php echo number_format($travalcost , 2) ; ?>€</div> </div>
                    <div class="clearfix"></div>
                    <div class="splrow">
                        <div class="w40">&nbsp;</div>
                        <div class="w60"><div class="fleft"> VAT &nbsp; &nbsp; <?php echo number_format($invoice_info->travelcost_percent, 1) ; ?>%  </div> <div class="fright"> + <span><?php echo $travalcost_vat; ?></span> €  </div> </div>
                        <div class="clearfix"></div>
                    </div>                     
                </div>

                <div class="irow">
                   <div class="splrow">
                        <div class="w40">CREDIT</div> 
                        <div class="w60"><div class="fleft"> includes VAT &nbsp; &nbsp; <?php echo number_format(0, 1) ; ?> </div> <div class="fright" id="fright"> <?php echo number_format(($model_budget + $vat_price - $m_sfee - $invoice_info->deduction_amout - $invoice_info->special_charge_amount + $travalcost + $travalcost_vat) , 2) ; ?>€  </div> </div>
                        <div class="clearfix"></div>
                    </div> 
                </div>

            </div> 
									 
								</div> 
								<div id="displaymsg"></div>

								<?php 
								if(!empty( $invoice_info)){
									if($user_id == $invoice_info->user_id){
									 
										if($invoice_info->approve_refund == 0){
								?>
								<div class="Invoicing">
									<div class="Issue">
										<div class="BtnBox text-right mt-4 mb-4">
											<div class="row">
												<div class="col-md-3">&#160;</div>


												<div class="col-md-4">
													<a href="<?php echo base_url('edit-refund-invoice?invoive=').$invoice_no ?>"><button type="button " class="btn cancel btn-info" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> <?php echo $invoice_info->refund == 1 ? ' Edit / Back' : 'Create Refund'  ?></button></a> 
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

								else if($invoice_info->approve_refund == 2){
								?>
								<div class="row">
									<div class="col-md-4">&#160;</div>
									<div class="col-md-4">
										<button type="button " class="btn cancel btn-danger" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Sent For Approval</button>  
									</div>
								</div>

								<?php
								
								}
								else if($invoice_info->approve_refund == 1){
								?>
								<div class="row">
									<div class="col-md-4">&#160;</div>
									<div class="col-md-4">
										<button type="button " class="btn cancel btn-success" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Approved </button> 
									</div>
								</div>

								<?php
								
									}
									else if($invoice_info->approve_refund == 3){
									?>
									<div class="row">
										<div class="col-md-3">&#160;</div>
										<div class="col-md-4">
											<a href="<?php echo base_url('edit-invoive?invoive=').$invoice_no ?>"><button type="button " class="btn cancel btn-warning" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Request For Change </button></a> 
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
															if($client->id == $invoice_info->assignee_to){
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

								else if($user_id == $invoice_info->assignee_to){
									if($invoice_info->approve == 2){
								?>
								<div class="row">
									<div class="col-md-4">&#160;</div>
									<div class="col-md-4">
										<button data-toggle="modal" data-target="#approveInvoice" data-invoice="<?php echo $invoice_no; ?>"  type="button " class="btn cancel btn-warning" style="margin-top: 54px; width: 100%;"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Approve </button>  
									</div>
								</div>

								<?php
									}
									else if($invoice_info->approve == 1){
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

	<!-- <input type="hidden" name="addtitlecount" id="addtitlecount" value="<?php echo $count; ?>"> -->
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

					inv_number : '<?php echo $invoice_info->invoice_number; ?>',

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



