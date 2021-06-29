<?php include 'header.php' ?>

<!-- End Header -->



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

							<h4>Generate Refund Preview</h4>

						</div>

						<div class="ModelMgmt">

							<div class="InputBox">

								<form>

									<div class="row" style="height: initial;">

										<div class="col-md-6 pl-0">

											<div class="form-group">

												<input type="text" class="form-control" value="Add Invoice number">

											</div>

										</div>

										<div class="col-md-6 pr-0">

											<div class="form-group">

												<form class="search-container">

													<input type="text" id="search-bar" placeholder="Browse Older Invoices for Duplication">

													<a href="javascript:void(0)"><img class="search-icon" src="http://www.endlessicons.com/wp-content/uploads/2012/12/search-icon.png"></a>

												</form>

											</div>

										</div>

									</div>

								</form>

							</div>

							<div class="row">

								<div class="InputBox RefundPreview">

									<form>

										<div class="Form">

											<div class="row">

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Model Name</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Model Name" />

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Service Fee</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="input-group mb-3">

																<input type="text" class="form-control" value="16%" />

															</div>

														</div>														

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Name</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Name" />

															</div>

														</div>

														

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Surname</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Surname" />

															</div>

														</div>

														

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Address Line 1</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Address Line 1" />

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Post Code</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Post Code" />

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Vat Number/TIN</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Vat Number/TIN" />

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Email</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Email" />

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6">

													<div class="row">

														<div class="col-md-3">

															<div class="form-group">

																<label for="usr">Mobile No.</label>

															</div>

														</div>

														<div class="col-md-9">

															<div class="form-group">

																<input type="text" class="form-control" value="Mobile No." />

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6"></div>

												<div class="col-md-6">

													<div class="form-group">

														<label for="usr">Kleinunternehmer with VAT or not</label>

													</div>

													<div class="row">

														<div class="col-md-6">

															<div class="custom-control custom-radio">

																<input type="radio" class="custom-control-input"  id="coupon_question"  name="example1" checked="" />

																<label class="custom-control-label" for="coupon_question">Yes</label>

															</div>

														</div>

														<div class="col-md-6">

															<div class="custom-control custom-radio">

																<input type="radio" class="custom-control-input" id="customRadio2" name="example1">

																<label class="custom-control-label" for="customRadio2">No</label>

															</div>

														</div>

													</div>

												</div>

												<div class="col-md-6"></div>

												<div class="col-lg-2 col-md-3 mt-3">

													<div class="answer">

														<div class="input-group mb-3">

															<input type="text" class="form-control" value="16%">

														</div>

													</div>				

													<script type="text/javascript">

														$(function() {

															$("#coupon_question").on("click",function() {

																$(".answer").toggle(this.checked);

															});

														});

													</script>

												</div>

											</div>

										</div>

									</form>

								</div>

							</div>			

						</div>

					</div>

					<div class="OpenTicket Box Boxtwo ">

						<div class="row">

							<div class="col-md-6">

								<div class="InputBox RefundPreview">

									<form>

										<div class="Form">

											<div class="row">

												<div class="col-md-5">

													<div class="form-group">

														<label for="usr">Invoice Number</label>

													</div>

												</div>

												<div class="col-md-7">

													<div class="form-group">

														<input type="text" class="form-control" value="85451022120">

													</div>

												</div>

												<div class="col-md-5">

													<div class="form-group">

														<label for="usr">Job Date</label>

													</div>

												</div>

												<div class="col-md-7">

													<div class="form-group">

														<input type="date" class="form-control" value="2020-10-20" />

													</div>

												</div>

												<div class="col-md-5">

													<div class="form-group">

														<label for="usr">Usage</label>

													</div>

												</div>

												<div class="col-md-7">

													<div class="form-group">

														<input type="text" class="form-control" value="Usage">

													</div>

												</div>

											</div>

										</div>

									</form>

								</div>

							</div>

						</div>

						<div class="Table RefundTable RefundPreview">

							<table class="table table-striped">

								<tbody>

									<tr class="bgnone">

										<td>Model fee net</td>

										<td></td>

										<td></td>

										<td></td>

										<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="1,000,00" /></td>

									</tr>

									<!--<tr>

										<td>Or <br>Model fee total agreed</td>

								</tr> 

								<tr>

									<td>VAT automatically added if Yes above</td>

									<td></td>

									<td></td>

									<td></td>

									<td><i class="fa fa-eur" aria-hidden="true"></i>160,00</td>

								</tr> -->

								<tr>

									<td>Expences Model</td>

									<td></td>

									<td></td>

									<td></td>

									<td></td>

								</tr>

								<tr>

									<td>Travel fee</td>

									<td>

										<div class="custom-control custom-checkbox">

											<input type="checkbox" class="custom-control-input" id="vat1" name="example1" checked="" />

											<label class="custom-control-label" for="vat1">VAT included</label>

										</div>

									</td>

									<td>

										<div class="custom-control custom-checkbox">

											<input type="checkbox" class="custom-control-input" id="vat2" name="example1" checked="" />

											<label class="custom-control-label" for="vat2">VAT excluded</label>

										</div>

									</td>

									<td>

										<div class="input-group">

											<input type="text" class="form-control PercentInput" value="10%" placeholder="" aria-label="" aria-describedby="basic-addon2">

										</div>

									</td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="54,00" /></td>

								</tr>

								<tr>

									<td>If VAT excluded, Netprice shown</td>

									<td></td>

									<td></td>

									<td></td>

									<td></td>

								</tr>

								<tr>

									<td>VAT added expenses</td>

									<td>

										<div class="input-group">

											<input type="text" class="form-control PercentInput" value="16%" placeholder="" aria-label="" aria-describedby="basic-addon2">

										</div>

									</td>

									<td></td>

									<td></td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="4,00" /></td>

								</tr>

								<tr>

									<td>  

										<div class="custom-control custom-checkbox">

											<input type="checkbox" class="custom-control-input" id="SeviceFee" name="example1" checked="">

											<label class="custom-control-label mr-5" for="SeviceFee">Deductions</label>

											<input type="checkbox" class="custom-control-input" id="SpecialFee" name="example1" checked="">

											<label class="custom-control-label" for="SpecialFee">Special Fee</label>

										</div>

									</td>

									<td></td>

									<td></td>

									<td></td>

									<td></td>

								</tr>

								<tr>

									<td>Sevice Fee</td>

									<td></td>

									<td></td>

									<td></td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="8.64" /></td>

								</tr>

								<tr>

									<td>Special Fee</td>

									<td>

										<div class="input-group">

											<input type="text" class="form-control PercentInput" value="10%" placeholder="" aria-label="" aria-describedby="basic-addon2">

										</div>

									</td>

									<td></td>

									<td></td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="8,64" /></td>

								</tr>

								<tr>

									<td>

										<div class="custom-control custom-checkbox">

											<input type="checkbox" class="custom-control-input" id="Deductions" name="example1" checked="" />

											<label class="custom-control-label" for="Deductions">Deductions</label>

										</div>

									</td>

									<td>

									</td>

									<td>

									</td>

									<td>

									</td>

									<td>

									</td>

								</tr>

								<tr>

									<td>Deductions</td>

									<td>

										<div class="input-group">

											<input type="text" class="form-control PercentInput" value="16%" placeholder="" aria-label="" aria-describedby="basic-addon2">

										</div>

									</td>

									<td></td>

									<td></td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="2,64" /></td>

								</tr>

								<tr>

									<td>Total Payment</td>

									<td></td>

									<td></td>

									<td></td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="794,64" readonly="" /></td>

								</tr>

							</tbody>

						</table>

					</div>

					<div class="BtnBox">

						<button type="button" class="btn cancel" data-toggle="modal" data-target="#Share"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>

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



