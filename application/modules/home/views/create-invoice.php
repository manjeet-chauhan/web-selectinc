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

							<h4>Create Invoice</h4>

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

								<div class="InputBox">

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

															<div class="form-group">

																<select name="cars" class="custom-select">

																	<option selected>0%</option>

																	<option value="volvo">5%</option>

																	<option value="fiat">15%</option>

																	<option value="audi">25%</option>

																</select>

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

													<div class="form-group mb-0">

														<label for="usr">Kleinunternehmer with VAT or not</label>

													</div>

													<div class="row">

														<div class="col-md-6">

															<div class="custom-control custom-radio">

																<input type="radio" class="custom-control-input" id="customRadio" name="example1">

																<label class="custom-control-label" for="customRadio">Yes</label>

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

												<div class="col-md-6">

													<div class="form-group">

														<label for="comment">Comment:</label>

														<textarea class="form-control" rows="5" cols="12" id="comment"></textarea>

													</div> 

												</div>

											</div>

										</div>

									</form>

								</div>

							</div>			

						</div>

					</div>

					<div class="OpenTicket Box Boxtwo">

						<div class="row">

							<div class="col-md-6">

								<div class="InputBox">

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

														<input type="date" class="form-control" value="">

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

						<div class="Table RefundTable">

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

											<input type="checkbox" class="custom-control-input" id="vat1" name="example1">

											<label class="custom-control-label" for="vat1">VAT included</label>

										</div>

									</td>

									<td>

										<div class="custom-control custom-checkbox">

											<input type="checkbox" class="custom-control-input" id="vat2" name="example1">

											<label class="custom-control-label" for="vat2">VAT excluded</label>

										</div>

									</td>

									<td>

										<div class="input-group">

											<input type="text" class="form-control PercentInput" value="10" placeholder="" aria-label="" aria-describedby="basic-addon2">

											<div class="input-group-append AppendBox">

												<span class="input-group-text" id="basic-addon2">%</span>

											</div>

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

											<input type="text" class="form-control PercentInput" value="16" placeholder="" aria-label="" aria-describedby="basic-addon2">

											<div class="input-group-append AppendBox">

												<span class="input-group-text" id="basic-addon2">%</span>

											</div>

										</div>

									</td>

									<td></td>

									<td></td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="4,00" /></td>

								</tr>

								<tr>

									<td>  

										<div class="custom-control custom-checkbox">

											<input type="checkbox" class="custom-control-input" id="SeviceFee" name="example1">

											<label class="custom-control-label mr-5" for="SeviceFee">Deductions</label>

											<input type="checkbox" class="custom-control-input" id="SpecialFee" name="example1">

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

											<input type="text" class="form-control PercentInput" value="10" placeholder="" aria-label="" aria-describedby="basic-addon2">

											<div class="input-group-append AppendBox">

												<span class="input-group-text" id="basic-addon2">%</span>

											</div>

										</div>

									</td>

									<td></td>

									<td></td>

									<td class="text-right"><i class="fa fa-eur" aria-hidden="true"></i><input type="text" class="InputField text-right" value="8,64" /></td>

								</tr>

								<tr>

									<td>

										<div class="custom-control custom-checkbox">

											<input type="checkbox" class="custom-control-input" id="Deductions" name="example1">

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

											<input type="text" class="form-control PercentInput" value="16" placeholder="" aria-label="" aria-describedby="basic-addon2">

											<div class="input-group-append AppendBox">

												<span class="input-group-text" id="basic-addon2">%</span>

											</div>

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

						<a href="generate-ref-preview.php"><button type="button" class="btn cancel">Preview</button></a>

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



