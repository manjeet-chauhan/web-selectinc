<!-- <!DOCTYPE html> -->

<?php 

$active_page = $this->uri->segment(2);
// print_r($this->session->userdata('admin')['image']);   

$profile_img = base_url('assets/admin/images/admin-profile.png');
if($this->session->userdata('admin')['image'] != ""){
  $profile_img = base_url('assets/admin/images/').$this->session->userdata('admin')['image'];
}  

?>

<style type="text/css">
  .submenu a{
    color: #fff;
  }

  .submenu.active{
    display: block;
  }
  .submenu{
    display: none;
  }
  .sidebar .user-panel>.image>img {
    width: 50px !important;
    max-width: 89px;
    height: 45px !important;
}

</style>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href=" logo.png" type="image/x-icon">
    <!-- CSS-->

    <title>SELECT INC. | ADMIN </title>

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/css/main.css'); ?>">
    <script src="<?php echo base_url('assets/admin/js/jquery-2.1.4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/plugins/pace.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/main.js'); ?>"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  
    <style>
        .logoTitle{
            font-size: 25px;
            text-align: center;
        }
        .note-editor.note-frame.panel.panel-default button{
            /*margin-right: 8px;*/
            padding: 5px 10px;
        }
        .main-header .logo {
    background-color: #0a505f;
  }

   .btn-black {
    background-color: #000;
    color: #fff;
  }
    </style>
  </head>
  <body class="sidebar-mini fixed">
    <div class="wrapper">
    <header class="main-header hidden-print"><a class="logo text-uppercase" href="#"> SELECT INC.
   </a>
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button--><a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
    <!-- Navbar Right Menu-->
    <div class="navbar-custom-menu">
      <ul class="top-nav">
        <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu">
            <!-- <li><a href="page-user.html"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
            <li><a href="page-user.html"><i class="fa fa-user fa-lg"></i> Profile</a></li> -->
            <li><a href="admin/logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- Side-Nav-->
<aside class="main-sidebar hidden-print">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
          <img class="img-circle" src="<?php echo $profile_img; ?>" alt="User Image">
          <!--<div class="logoTitle">GEEV</div>-->
        </div>
      <div class="pull-left info">
        <p>SUPER ADMIN</p>
        <p class="designation text-uppercase" style="color:#f7a95c ">SELECT INC </p>
      </div>
    </div>
    <!-- Sidebar Menu-->
    <ul class="sidebar-menu">

      <li class="<?php if($active_page == "dashboard"){ echo 'active'; } ?>"><a href="<?php echo base_url('admin/dashboard') ?>">
        <i class="fa fa-dashboard"></i><span>Dashboard</span></a>
      </li>

      <li class="<?php if($active_page == "users"){ echo 'active'; } ?>"><a href="<?php echo base_url('admin/users') ?>"> 
        <i class="fa fa-gift"></i><span>Users</span></a>
      </li> 
 
      <li class="<?php if($active_page == "invoices-for-approval"){ echo 'active'; } ?>"><a href="<?php echo base_url('admin/invoices-for-approval') ?>">
        <i class="fa fa-pencil-square-o"></i><span>Invoices For Approval</span></a>
      </li>

       <li class="<?php if($active_page == "refund-for-approval"){ echo 'active'; } ?>"><a href="<?php echo base_url('admin/refund-for-approval') ?>">
        <i class="fa fa-retweet"></i><span>Refund For Approval</span></a>
      </li>

      <li class="<?php if($active_page == "profile"){ echo 'active'; } ?>"><a href="<?php echo base_url('admin/profile') ?>">
        <i class="fa fa-cog"></i><span>Profile Settings</span></a>
      </li>

      <li class="<?php if($active_page == "change-password"){ echo 'active'; } ?>"><a href="<?php echo base_url('admin/change-password') ?>">
        <i class="fa fa-key"></i><span>Change Password</span></a>
      </li>

      <li><a href="<?php echo base_url('admin/logout') ?>">
        <i class="fa fa-sign-out"></i><span>Logout</span></a>
      </li>
       
    </ul>
  </section> 
</aside>

<script type="text/javascript">
  $(function(){
      $('.mainmenu').click(function(){
          $('.submenu').removeClass(' active').slideUp();
          $(this).find('ul.submenu').addClass(' active').slideToggle();
      })
  })

</script>