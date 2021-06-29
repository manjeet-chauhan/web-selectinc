<!-- Share Modal -->
<section class="Modal">
	<div class="modal" id="Share">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title"><img src="assets/images/share.svg" align="Icon" /> Share to</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="ShareImage">
								<img src="assets/images/pdf.svg" align="Icon">
								<p>Download as PDF</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="ShareImage"  data-toggle="modal" data-target="#Mail" data-dismiss="modal">
								<img src="assets/images/email.svg" align="Icon">
								<p>Sent as e-mail</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="Mail">
		<div class="modal-dialog">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title"><img src="assets/images/share.svg" align="Icon" /> Share to</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="usr">Email:</label>
								<input type="text" class="form-control" value="beingprakashdubey@gmail.com" />
								<button type="submit" class="btn btn-primary mt-3"> <i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

</section>
<!-- Share Modal -->
<script type="text/javascript">
	$(function(){
		$(".myselect").select2();
	})
</script>
</body>
</html> 