<?php 
$sessionprofile = $this->session->userdata('user');
$profile = [];
if(!empty($sessionprofile)){
	$profile = user_profile($sessionprofile->id);
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Select Inc.</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>css/style.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>css/responsive.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/frontend/'); ?>plugin/bootstrap.min.css">
	<link rel="icon" href="<?php echo base_url('assets/frontend'); ?> assets/images/fav-icon.png" type="image/png" sizes="16x16"> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="<?php echo base_url('assets/frontend/'); ?>plugin/jquery.min.js"></script>
	<script src="<?php echo base_url('assets/frontend/'); ?>plugin/popper.min.js"></script>
	<script src="<?php echo base_url('assets/frontend/'); ?>plugin/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>



	<style type="text/css">
		.select2-container--default .select2-selection--single .select2-selection__rendered {
	margin-top: -14px;
}

 
.select2-container--default .select2-selection--single {
    padding: 20px 2px;
    border: 1px solid #ced4da;

}


		.HeaderOption ul.usermenu{
			display: none;
    padding-inline-start: 0px;
    position: absolute;
    background-color: #fff;
    z-index: 9;
    margin-top: 142px;
    width: 110px;
    right: -22px;
		}
		.HeaderOption ul.usermenu li {
		    margin-left: 0px;
		    display: block;
		}

		.HeaderOption ul.usermenu li a{
		    padding: 5px 10px;
		    border-bottom: 1px solid #e1e1e1;
		    display: block;
		}
		.HeaderOption ul.usermenu li a:hover{
		    background-color: #ccc;
		    color: #000;
		}


		.usermemucont:hover > .usermenu {
			display: block;
		}

		#displaymsg{
			    z-index: 99;
    bottom: 0px;
    right: 30px;
    position: fixed;
    overflow-y: scroll;
    max-height: 200px;
		}
		.usermenu i{
			    font-size: 15px !important;
    margin-right: 4px;
		}
		.UserImage img {
    width: 48px;
    height: 45px;
}
b.checkCountry {
    position: relative;
    bottom: 18px;
    /*left: 1px;*/
}

.table td, .table th {
    /* padding: .75rem; */
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
    padding: 5px;
    cursor: pointer;
}

input[name="search"]{
	height: 36px;
    border-radius: 5px;
    border: 1px solid #007bff;
    padding: 5px 8px;
    width: 38%;
}

</style>

</head> 
<body>

	<div class="displaymsg" id="displaymsg"></div>

	<!-- Start Header -->
	<section class="Header">
		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<div class="Logo">
						<?php 
						$logo = base_url('assets/frontend/images/logo.png');
						$setting = get_settings();
						if(!empty($setting) && !empty($setting->logo)){
							$logo = base_url('assets/frontend/images/').$setting->logo;
						}
						?>
						<a href="<?php echo base_url(); ?>"><img src="<?php echo $logo; ?>" alt="Logo" /></a>
					</div>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-4">
					<div class="SearchInput">
						<form>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search" />
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
								</div>
							</div>
						</form> 
					</div>
				</div>
				<div class="col-md-2"></div>
				<div class="col-md-2">
					<div class="HeaderOption">
						<ul>
							<li class="Notification"><a href="javascript:void(0)"data-toggle="collapse" data-target="#Setting"><i class="fa fa-cog" aria-hidden="true"></i></a>
								<div id="Setting" class="collapse HeaderCollapse"><div class="InnerNavigation">
									<div class="DashboardNavigation">
										<ul>
											<li><a href="javascript:void(0"><img src="<?php echo base_url('assets/frontend/'); ?>images/utilities.svg" alt="Icon"> Invoice </a></li>
											<li><a href="javascript:void(0"><img src="<?php echo base_url('assets/frontend/'); ?>images/money-back.svg" alt="Icon"> Refunds </a></li>
											<li><a href="javascript:void(0"><img src="<?php echo base_url('assets/frontend/'); ?>images/minus.svg" alt="Icon"> Deductions </a></li>
											<li><a href="javascript:void(0"><img src="<?php echo base_url('assets/frontend/'); ?>images/business-report.svg" alt="Icon"> Reports </a></li>
											<li><a href="javascript:void(0"><img src="<?php echo base_url('assets/frontend/'); ?>images/manager.svg" alt="Icon"> Administration </a></li>
										</ul>
									</div>
								</div>
								</div>
							</li>
							<li class="Notification"><a href="javascript:void(0)"data-toggle="collapse" data-target="#Notification"><i class="fa fa-bell" aria-hidden="true"></i> <span class="NotificationCount">+9</span></a>
								<div id="Notification" class="collapse HeaderCollapse">
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" /> 
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" />
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" />
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" />
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" />
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" />
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" />
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="SingleNotification">
										<div class="row">
											<div class="col-3">
												<div class="NotificationImage">
													<img src="<?php echo base_url('assets/frontend/'); ?>images/2.jpg" alt="Notification Image" />
												</div>
											</div>
											<div class="col-9">
												<div class="NotificationAletText">
													<h6>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do</h6>
													<p>1:00 AM <span>30/9/2020</span></p>
												</div>
											</div>
										</div>
									</div>
									<div class="MarkAsRead">
										<a href="javascript:void(0)">Mark all as Read</a>
									</div>
								</div>
							</li>
							<li class="UserImage usermemucont">
								<a href="javascript:void(0)" class="">  
									
									<?php
							 		$profile_img = base_url('assets/frontend/images/2.jpg');
							 		if(!empty($profile->image)) {
							 			$profile_img = base_url('assets/upload/images/').$profile->image;
							 		}
							 		?>  
									<img src="<?php echo  $profile_img; ?>" alt="User Image" /> <span></span>
								</a>
								<ul class="usermenu">
									<li><a href="<?php echo base_url('profile') ?>"><i class="fa fa-user text-primary"></i>  Profile</a></li>
									<li><a href="<?php echo base_url('settings') ?>"><i class="fa fa-cog text-primary"></i> Settings</a></li>
									<li><a href="<?php echo base_url('logout') ?>"><i class="fa fa-sign-out text-primary"></i> Logout</a></li>
								</ul>
							</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
<!-- End Header -->
