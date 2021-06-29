<?php 

$sessionprofile = $this->session->userdata('user');
$profile = [];
if(!empty($sessionprofile)){
	 
	$user_access = get_user_access($sessionprofile->redmine_assignee);
	// print_r($user_access);
}

?>


<style type="text/css">
	.DashboardNavigation ul li img {
	    width: 20px;
	    margin-right: 15px;
	}

	.DashboardNavigation ul li {
	    font-size: 12px;
	}

	.Table.invoice {
	    height: auto !important;
	}

</style>
<div class="DashboardNavigation Scroll">

	<ul>

		<?php 
		if($user_access->access == 1){ //all access
		?>

		<li><a href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/speedometer.svg" alt="Icon" /> Dashboard</a></li>
		
		<li><a href="<?php echo base_url('client-management') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/customer.svg" alt="Icon" /> Client Management </a></li> 

		<li><a href="<?php echo base_url('model-management') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/3d-modeling.svg" alt="Icon" />Models Management </a></li> 

		<li><a href="<?php echo base_url('mwm-agency-management') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/agent.svg" alt="Icon" />  MWM Agency management</a></li> 

		<li><a href="<?php echo base_url('invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/utilities.svg" alt="Icon" /> Invoice</a></li>

		<li><a href="<?php echo base_url('invoice-for-approval') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/utilities.svg" alt="Icon" /> Invoice For Approval</a></li>

		<li><a href="<?php echo base_url('changes-request-invoice-lists-for-approval') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/utilities.svg" alt="Icon" /> Invoice Request Change </a></li> 

		 <li><a href="<?php echo base_url('refund-overview') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/money-back.svg" alt="Icon" /> Refunds</a> </li>  

		<!-- <li><a href="<?php echo base_url('edit-refund-invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/money-back.svg" alt="Icon" /> Refunds</a> </li> -->



		<li><a href="<?php echo base_url('refund-for-approval') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/money-back.svg" alt="Icon" /> Refunds For Approval</a> </li>

		<!-- <li><a href="<?php echo base_url('general-invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/money-back.svg" alt="Icon" /> General Invoice </a> </li> --> 

		<li><a href="<?php echo base_url('generate-new-general-invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/business-report.svg" alt="Icon" /> Partner Invoice</a></li> 

		<li><a href="<?php echo base_url('client-list-invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/business-report.svg" alt="Icon" /> List Invoice</a></li>
		
		<li><a href="<?php echo base_url('collective-invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/business-report.svg" alt="Icon" /> Collective Invoice</a></li>

		<li><a href="<?php echo base_url('invoice-correction') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/business-report.svg" alt="Icon" /> Invoice Correction </a></li>
		
		<!-- <li><a href="<?php echo base_url('edit-invoice-correction') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/business-report.svg" alt="Icon" /> Invoice Correction </a></li> -->

		<li><a href="<?php echo base_url('accepted-invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/business-report.svg" alt="Icon" /> Accepted Invoice </a></li> 

		<li><a href="<?php echo base_url('deductions') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/minus.svg" alt="Icon" /> Deductions</a></li>

		<li><a href="<?php echo base_url('reports-overview') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/business-report.svg" alt="Icon" /> Reports</a></li>
		
		<li><a href="<?php echo base_url('administration') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/manager.svg" alt="Icon" /> Administration </a></li> 

		<?php 
		}
		else if($user_access->access == 2){ //only access to Deductions
		?>

		<li><a href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/speedometer.svg" alt="Icon" /> Dashboard</a></li>

		<li><a href="<?php echo base_url('deductions') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/minus.svg" alt="Icon" /> Deductions</a></li>

		<?php 
		}
		else if($user_access->access == 3){ //Create Invoices - Create refundes - change deductions 
		?>

		<li><a href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/speedometer.svg" alt="Icon" /> Dashboard</a></li>

		<li><a href="<?php echo base_url('invoice') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/utilities.svg" alt="Icon" /> Invoice</a></li>
		<li><a href="<?php echo base_url('invoice-for-approval') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/utilities.svg" alt="Icon" /> Invoice For Approval</a></li>

		<li><a href="<?php echo base_url('refund-overview') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/money-back.svg" alt="Icon" /> Refunds</a> </li>
		<li><a href="<?php echo base_url('refund-for-approval') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/money-back.svg" alt="Icon" /> Refunds For Approval</a> </li>

		<li><a href="<?php echo base_url('deductions') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/minus.svg" alt="Icon" /> Deductions</a></li>

		<?php 
		}
		else if($user_access->access == 4){ //Export Liste only
		?>


		<?php 
		}
		?>

		<li class="Logout"><a href="<?php echo base_url('logout') ?>"><img src="<?php echo base_url('assets/frontend/');?>/images/exit.svg" alt="Icon" /> Logout</a></li>



	</ul>



</div>