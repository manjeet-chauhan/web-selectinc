<?php 

// $user_session = $this->session->userdata('user');
$user_profie = user_profile($user_id);
// print_r($user_profie);

$issues = [];
$records = 0;
$offset = 0;
$records_on_page = 10;
$page = 0;

if (!empty($_GET['page'])) {
	$page = $_GET['page'];
	$offset = $page * $records_on_page;
}


$data = [];
$attachments = [];
$journals = [];

$token = 0;

if (!empty($_GET['token'])) {
	$token = $_GET['token'];
}


$filter_data = '';

$search_status = '';
if (!empty($_GET['status_id'])) {
	$search_status = $_GET['status_id'];
	$filter_data .= '&status_id='.$search_status;
}

$search_priority = ''; 
if (!empty($_GET['priority_id'])) {
	$search_priority = $_GET['priority_id'];
	$filter_data .= '&priority_id='.$search_priority;
}

$search_assignee = '';
if (!empty($_GET['assigned_to_id'])) {
	$search_assignee = $_GET['assigned_to_id'];
	$filter_data .= '&assigned_to_id='.$search_assignee;
}
else{
	$search_assignee = $user_profie->redmine_assignee;
	$filter_data .= '&assigned_to_id='.$search_assignee;
} 


if(!empty($user_profie)){

	$service_url = "https://tickets.mostwantedmodels.com/projects/jobs/issues.json?offset=".$offset."&limit=".$records_on_page.$filter_data;
	$curl = curl_init($service_url);
	$autho = $user_profie->redmine_username.':'.$user_profie->redmine_password;
	$request_headers = array(
		"Authorization:Basic ".base64_encode($autho),
	);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($curl_response, true);

	if(!empty($response['issues'])){
		$issues = $response['issues'];
		$records = $response['total_count'];
	}

	// print_r($response);

	$service_url = "https://tickets.mostwantedmodels.com/issues/".$token.".json?include=attachments,journals";
	$curl = curl_init($service_url);
	$autho = $user_profie->redmine_username.':'.$user_profie->redmine_password;

	$request_headers = array(
		"Authorization:Basic ".base64_encode($autho),
	);

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
	$curl_response = curl_exec($curl);
	curl_close($curl);
	$response = json_decode($curl_response, true);

	if(!empty($response['issue'])){
		$data = $response['issue'];
		$attachments = $response['issue']['attachments'];
		$journals = $response['issue']['journals'];
	}
}

// print_r($journals);

?>

<!-- End Header -->

<style type="text/css">
	.select2-container--default .select2-selection--single .select2-selection__rendered {
		margin-top: -14px;
	}


	.select2-container--default .select2-selection--single {
		padding: 20px 2px;
		border: 1px solid #ced4da;

	}



	ul.journals{

		margin-bottom: 0px;

	}

	ul.journals li{

		border-bottom: 1px solid #ccc;

		padding-top: 5px;

		padding-bottom: 5px;

		list-style: square;

	}

	ul.journals li:last-child{

		border-bottom: none;

		padding-top: 5px;

		padding-bottom: 0px;

		list-style: square;

	}

	ul.journals li::marker {

		color: #c3083c;

	}



	#model_budget, #model_total_agreed, .Modelfee input[type="number"]{

		width: 110px;

		height: 28px;

	}

	/*.singlemodelpriceSeparater input{
		width: 110px;

		height: 28px;
	}*/

	.Modelfee.Icon.text-right::before {

		content: " ";

	}
	#form_filter div small b{
		color: #169;
		margin-bottom: 8px;
		/*font-weight: bold;
		border-bottom: 1px dotted #169;*/
	}

	.editbtn {
		text-align: center;
		font-weight: bold;
		/*text-transform: uppercase;*/

	}
	.editbtn a{
		font-size: 12px !important;
		color: #169 !important;
	}

	.chargespercent{
		float: right;
    width: 75px;
	}

	#newModelTotalFee input, #additional_modal_price{
		max-width: 100%;
	}
	.OpenTicket input[type="number"], .modeladdmoredata input[type="number"]{
		max-width: 100%;
	}


.HeightInitial label{
	font-weight: bold;
	font-size: 12px;
}
.myhr{
	width: 100%;
    border-bottom: 1px solid #ced4da;
    margin-bottom: 15px;
}

.single-row{
	margin-bottom: 8px;
}
.single-row .title{
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

						<div class="BoxHeading generate">

							<h4>Generate Partner Invoice</h4>

						</div>

					</div>


					 

 
 


			<form id="formInvoice" name="formInvoice">

				<div class="OpenTicket Box Boxtwo NoRadius ModelMgmt" >

					<div class="modelDetails" id="modelDetails"> </div>

					<div class="row HeightInitial">

						<div class="col-md-4">
							<label for="email">Select Client</label>
							<?php
							$clients = get_clients($user_id);
							?>

							<select class="custom-select myselect" id="save_clients" name="save_clients" 
							onchange="bind_client();">
							<option value="" selected disabled > Select Client</option>
							<?php 
							if(!empty($clients)){
								foreach ($clients as $client){
							?>
								<option 
								value="<?php echo $client->id; ?>"
								value_code="<?php echo $client->unique_code; ?>"
								data-fee="<?php echo $client->client_fee; ?>"
								data-kvat="<?php echo $client->kvat; ?>"
								data-kvat_percent="<?php echo $client->kvat_percent; ?>"
								><?php echo ucwords(strtolower($client->company_name)); ?></option>
							<?php
								}
							}
							?> 
							</select>
							<!-- <div class="editbtn"> 
								<a href="" data-toggle="modal" data-target="#modelEditClient" onclick="editClient();">Edit Client</a>
							</div> -->
						</div> 


						<div class="col-md-4">					
							 
							<label for="email">Select Model</label>
							<?php
							$models = get_models($user_id);
							?>

							<select class="custom-select myselect" id="save_model" name="save_model" 
								onchange="bind_model();">
								<option value="" selected disabled > Select Model</option>
								<?php 
								if(!empty($models)){
									foreach ($models as $model){
								?>

								<option 
								value="<?php echo $model->id; ?>"
								value_code="<?php echo $model->unique_code; ?>"
								data-fee="<?php echo $model->service_fee; ?>"
								data-kvat="<?php echo $model->kvat; ?>"
								data-kvat_percent="<?php echo $model->kvat_percent; ?>"
								><?php echo ucwords(strtolower($model->name))."(". ucwords(strtolower($model->model_name)) .")"; ?></option>
								<?php
									}
								}
								?> 
							</select>
							<!-- <div class="editbtn"><a href="" data-toggle="modal" data-target="#modalEditModel" onclick="editModel();">Edit Model</a></div> -->
 
						</div>
						<div class="col-md-4"></div>

						<div class="myhr"></div>


						<hr>

						<div class="col-md-4">
							<div class="form-group">
							    <label for="email">Token Id</label>
							    <input type="text" class="form-control" placeholder="Issue id" id="issue_id" name="issue_id"  value="">
							 </div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
							    <label for="email">Invoice number</label>
							    <input type="text" class="form-control" placeholder="Invoice Number" id="invoice_number" name="invoice_number"  value="<?php echo get_invoice_no();?>">
									
								<div id="iN" class="alert alert-danger" style="display: none;" role="alert">
									This Invoice Number is Already Exists. 
								</div>
							 </div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
							    <label for="email">Date:</label>
							    <input type="text" class="form-control dateSelector" name="date" id="date">
							 </div>
						</div>



					</div>



					<div class="myhr"></div>


					<div class="moreinfodata">
						<div class="row single-row">
							<div class="col-md-2"><div class="title">Customer</div></div>
							<div class="col-md-10"><div class="details" id="customerdetail"></div></div>
						</div>

						<div class="row single-row">
							<div class="col-md-2"><div class="title">TID </div></div>
							<div class="col-md-10"><input type="text" name="customertin" id="customertin"></div>
						</div>

						<div class="row single-row">
							<div class="col-md-2"><div class="title">Booking Date </div></div>
							<div class="col-md-3"><input type="text" class="dateSelector" name="booking_date" id="booking_date"></div>
						</div>
						<input type="hidden" name="client_name" id="client_name" value="">
						<input type="hidden" name="address1" id="address1" value="">
						<input type="hidden" name="address2" id="address2" value="">
						<input type="hidden" name="address3" id="address3" value="">
						<input type="hidden" name="address4" id="address4" value="">
						 
						<input type="hidden" name="addtitlecount" id="addtitlecount" value="0">
						<div id="moretitle"></div>
						<div><button type="button" class="btn btn-sm btn-primary" onclick="addmoretitle();"> Add More </button></div>

					</div>



				</div>

		 

		 
 

		<div class="OpenTicket Box Boxtwo NoRadiusForm">

			<div class="BorderRow ">
				<div class="row">
					<div class="col-md-3">
						<div class="Modelfee">
							<h6><label>Total Invoice Amount </label></h6>
							<select id="invoice_currency" name="invoice_currency">
								<option value="0">Select Currency </option>
								<?php 
							$m_curr = get_currency_list();
							foreach ($m_curr as $data) {
								$selected = '';
								if($data->auto == 1){
									$selected = 'selected';
								}
							?>
							<option <?php echo $selected; ?> data-value='<?php echo $data->symbol; ?>' value="<?php echo $data->code; ?>"><?php echo $data->name ."(". $data->symbol .")"; ?></option>
							<?php
							}
							?>
								 
							</select>
						</div>
					</div>

					<div class="col-md-2">
						<label><small><b>Currency Amount</b></small></label>
						<input type="number" name="currency_amount" id="currency_amount" min="0" step="any" value="<?php echo getAmountConverter(); ?>">
					</div>
					<div class="col-md-2">
						<label><small><b>Percentage(%)</b></small></label>
						<input type="number" name="model_percentage" id="model_percentage" min="0" step="any" value="10">
					</div>
					<div class="col-md-2"></div>
					<div class="col-md-3">
						<div class="Modelfee text-right">
							<label class="text-left"><small><b>Total</b></small></label>
							<h6><i class="fa fa-eur" aria-hidden="true"></i>  <input type="number" step="any" name="model_budget" id="model_budget" min="0" value="0"></h6>
						</div>
					</div>
				</div>
			</div>

			 
			<div class="NewInvoice">  
					<div id="newModelTotalFee"> </div> 
					<input type="hidden" name="txtmodalIncreaseValue" id="txtmodalIncreaseValue" value="0">					
					<div><button type="button" class="btn btn-warning btn-sm" onclick="moreModelData();">ADD INVOICE </button></div> 
					<br> 
				</div>

			</div>
  

			<div class="OpenTicket Box Boxtwo NoRadius"> 
				<div class="Divpdf">  
					<div class="BtnBox" >
						<!-- contenteditable="false" -->
						<button type="save" class="btn cancel">Save & Preview</button>
						<!-- <button type="save" class="btn cancel">Preview</button> -->
						<!-- </a> --> 
					</div> 
				</div> 
			</div>
			 
		</form>
	</div>
</div>
</div>
</div>
</section>

<!-- End Dashboard -->


 


 


<div id="demododelincData" style="display: none;">	
	<div id="singlemodelpriceSeparater@incdiv@"> 
		<div class="row">
			<div class="col-md-3">
				<div class="modeladdmoredata">
				<button type="button" class="btn btn-sm btn-danger" onclick="delModelAddedRow('singlemodelpriceSeparater@delete@', @delete2@)"><i class="fa fa-trash"></i></button>
				<input type="hidden" name="modelTextdel@delrow@" id="modelTextdel@delrowid@" value="0">
				<input type="text" name="modelTextName@name1@" placeholder="Name">
				</div>
			</div>

			<div class="col-md-2">
				<div class="modeladdmoredata">
				<input type="text" name="modelText1Name@name2@" placeholder="Text 1">
				</div>
			</div>
			<div class="col-md-2">
				<div class="modeladdmoredata">
				<input type="text" name="modelText2Name@name3@" placeholder="Text 2">
				</div>
			</div>

			<div class="col-md-2">
				<div class="modeladdmoredata">
				<input type="number" onkeyup="calculateAddedRow(this)" onchange="calculateAddedRow(this)" placeholder="amount" name="modelPriceValue@name@"  id="modelPriceValue@id@"  step="any">
				</div>
			</div>
			<div class="col-md-2">
				<div class="modeladdmoredata">
				<input type="number"  min="0" value="0" placeholder="amount" name="modelPricePercent@percent1@" readonly  id="modelPricePercent@percent2@"  step="any">
				</div>
			</div>

		</div>
		<hr>
	</div>
	
</div>



<div id="moretitledemo" style="display: none;">
	<div class="invoice-cont" id="moreaddheader@_titlerow@">
		<div class="row">
			<div class="col-md-2">
				<div class="InvoiceData">
					<input type="hidden" name="delheaderid@_titlerow@" id="delheaderid@_titlerow@"  value="0">
					<p><input type="text"  class="titleheader" name="titleheader@_titlerow@" id="titleheader@_titlerow@"></p>
				</div>
			</div>
			<div class="col-md-10">
				<div class="InvoiceData">
					<p><input type="text" class="descheader" name="descheader@_titlerow@" id="descheader@_titlerow@">
						<button type="button" onclick="delHeaderAddedRow(@_titlerow@)" class="btn btn-danger btn-sm hdelbtn" id="deleteInvoiceRow@_titlerow@" value="0"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">


	function addmoretitle() {

		var title_id = $('#addtitlecount').val();
		var title_data = $('#moretitledemo').html();

		var incdata = parseInt(title_id) + 1;
		title_data = title_data.replaceAll('@_titlerow@', incdata);
		$('#moretitle').append(title_data);
		$('#addtitlecount').val(incdata);

	}


	function delHeaderAddedRow(del_id){

		var confirm = window.confirm("Are you sure, you want to delete this row!");
		var confirm_text = 'Cancelled successfully';

		if (confirm == true) {
		   	$('#moreaddheader' + del_id).css('display', 'none');
			$('#delheaderid' + del_id).val(1);

			confirm_text = "Delete successfully";
		} 
		else {
		  confirm_text = "Cancelled successfully";
		}
		alert(confirm_text);		
	}

	function calculateAddedRow(thisObj){
		manageaddedModelRowCalculation();
	}

 

	function manageaddedModelRowCalculation(){

		var added_row = $('#txtmodalIncreaseValue').val();
		var t_percent = $('#model_percentage').val();

		var total_cal_amount = 0;

		 var percent = 0;
		 if(t_percent != '' || t_percent !== undefined){
		 	percent = parseFloat(t_percent);
		 }


		if(added_row != ''){
			added_row = parseInt(added_row);

			for (var i = 1; i <= added_row; i++) {
				
				var delRow = $('#modelTextdel'+i).val();
				if(delRow == 0){

					var t_row_amt = $('#modelPriceValue'+i).val();
					var row_amount = 0;

					if(t_row_amt != ''){
						row_amount = parseFloat(t_row_amt); 
					}

					if(percent > 0){
						var percent_amt = (row_amount * percent)/100;
						$('#modelPricePercent'+i).val(percent_amt);
						row_amount = row_amount - percent_amt;
					}

					total_cal_amount = total_cal_amount + row_amount;
				}				
			}
		}
		 
		$('#model_budget').val(total_cal_amount);
	}



	function delModelAddedRow(remove_id, del_id){

		var confirm = window.confirm("Are you sure, you want to delete this row!");
		var confirm_text = 'Cancelled successfully';

		if (confirm == true) {
		   	$('#' + remove_id).css('display', 'none');
			$('#modelTextdel'+del_id).val(1);

			confirm_text = "Delete successfully";
		} 
		else {
		  confirm_text = "Cancelled successfully";
		}
		manageaddedModelRowCalculation();
		alert(confirm_text);		
	}
 

</script>
 

 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 

<script type="text/javascript">

	$( function() {
	    $( '.dateSelector' ).datepicker();
	 });
 
 	function bind_client(){ 

		var client_id = $('#save_clients option:selected').attr('value_code');
		if(client_id == ''){
			alert('No Client Selected.');
			return false;
		}

		$.ajax({

			url: '<?php echo base_url('clients-for-invoice'); ?>',
			type: "POST",
			data: {
				client_id : client_id
			},

			success: function (data) { 

				var _parse_data = JSON.parse(data);
        	
        		if(_parse_data['error'] == 'success'){

        			$('#customerdetail').html(_parse_data['data'].company_name);
        			$('#customertin').html(_parse_data['data'].vat_tin_number);

        			$('#client_name').val(_parse_data['data'].company_name);
				}
			}
		});
	}



	function bind_model(){
		var model_id = $('#save_model option:selected').attr('value_code');
		if(model_id == ''){
			alert('No Model Selected.');
			return false;
		}

		$.ajax({
			url: '<?php echo base_url('models-for-invoice'); ?>',
			type: "POST",
			data: {
				model_id : model_id
			},

			success: function (data) { 
				var _parse_data = JSON.parse(data);

				if(_parse_data['error'] == 'success'){
					// console.log(_parse_data);

					var name = _parse_data['data'].name.toUpperCase() + ' (' + _parse_data['data'].model_name.toUpperCase() + ')';

					var data_stra = '<div><div>'+ name + '</div> <div> ' + _parse_data['data'].address_line1 + ', ' + _parse_data['data'].address_line2 + ' </div> <div> ' + _parse_data['data'].city + ' - ' + _parse_data['data'].pincode + ' </div> <div><b> ' + _parse_data['data'].country.toUpperCase() + ' </b></div></div><br/>';

					$('#address1').val(name);
					$('#address2').val(_parse_data['data'].address_line1 + ', ' + _parse_data['data'].address_line2);
					$('#address3').val(_parse_data['data'].city + ' - ' + _parse_data['data'].pincode);
					$('#address4').val( _parse_data['data'].country.toUpperCase());

					$('#modelDetails').html(data_stra);
				}
			}
		});
	}

$(function(){
	$('span.select2-results').click(function(){
		$(this).css('display', 'none');
	})
})


	$("#invoice_number").blur(function(){
		var checkinvoic = $('#invoice_number').val();
		$.ajax({
			url: '<?php echo base_url('invoice-no-info'); ?>',
			type: "POST",
			data: {
				invoice_number : checkinvoic
			},
			success: function (data) { 

				var _parse_data = JSON.parse(data);
				console.log(_parse_data);
				if(_parse_data['error'] == 'error'){
					$('#iN').fadeIn('slow').delay(2000).fadeOut('slow');
				}
			}
		});
	});



	$(function(){
		$('.token-data input[type="checkbox"]').click(function(){
			// $('token-data input[type="checkbox"]').prop('checked', false);
			var page = <?php echo $page ?>;
			var record = $(this).attr('value');
			var url = "<?php echo base_url('generate-new-general-invoice/?page='); ?>";
			url = url + page + '&token='+record;
			window.location.href = url;
		})
	});



	$(function(){

		$('#formInvoice').submit(function(e){ 
			e.preventDefault();

			$('#displaymsg').removeClass(' alert alert-info');
			$('#displaymsg').removeClass(' alert alert-success');
			$('#displaymsg').removeClass(' alert alert-danger');

			$('#displaymsg').html('Please wait');
			$('#displaymsg').show().delay(5000).fadeOut();
			$('#displaymsg').addClass(' alert alert-info');

			// var checkLen=$('.checked-issue:checked').length;
			// if(checkLen==0){
			// 	$('#displaymsg').html('No issue selected.');
			// 	$('#displaymsg').show().delay(5000).fadeOut();
			// 	$('#displaymsg').addClass(' alert alert-danger');	
			// 	return false;			
			// }

            // $('#myloader').show();

            $.ajax({

            	url: '<?php echo base_url('save-new-general-invoice'); ?>',
            	type: "POST",
            	data: new FormData(this),
            	contentType: false,
            	cache: false,
            	processData: false,
            	async: true,
            	success: function (data) { 

            		$('#displaymsg').removeClass(' alert alert-info');
            		if(data == "success"){
            			$('#displaymsg').html('Invoice created Success');
            			$('#displaymsg').show().delay(5000).fadeOut();
            			$('#displaymsg').addClass(' alert alert-success');
            			window.location.href = "<?php echo base_url('invoice'); ?>";
            			// location.reload();
            			return true;
            		} 

            		if(data == "error"){
            			$('#displaymsg').html('Error to create invoice, retry');
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
	})


function moreModelData(){

	var increasedata = $('#txtmodalIncreaseValue').val();
	var modeladdmoreRow = $('#demododelincData').html();

	increasedata = parseInt(increasedata) + 1; 

	modeladdmoreRow = modeladdmoreRow.replace('@incdiv@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@name1@', increasedata);

	modeladdmoreRow = modeladdmoreRow.replace('@name2@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@name3@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@name@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@id@', increasedata);
	modeladdmoreRow = modeladdmoreRow.replace('@totalshowid@', increasedata);

	modeladdmoreRow = modeladdmoreRow.replace('@delrow@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@delrowid@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@delete@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@delete2@', increasedata); 

	modeladdmoreRow = modeladdmoreRow.replace('@percent1@', increasedata); 
	modeladdmoreRow = modeladdmoreRow.replace('@percent2@', increasedata); 

	$('#newModelTotalFee').append(modeladdmoreRow);
	$('#txtmodalIncreaseValue').val(increasedata);
}

</script>



