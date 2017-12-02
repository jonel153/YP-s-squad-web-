<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>



<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/bootstrap-4.0.0-beta.2-dist/css/bootstrap.min.css"> -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/admin_style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrapValidator.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker3.css">


<!-- <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url();?>assets/js/popper.min.js"></script> -->
<script src="<?php echo base_url();?>assets/js/jquery.js"></script>
<!-- <script src="<?php echo base_url();?>assets/bootstrap-4.0.0-beta.2-dist/js/bootstrap.min.js"></script> -->
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>assets/js/admin.js"></script>
<style type="text/css">



.colorgraph {
  height: 5px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}

#signup {
	margin-left: 70%;
}

#reg input{



}

#pic {
	padding-bottom: 125px;
}

#name{
padding-top: 25px;
padding-bottom: 125px;
}

#cat {
padding-bottom: 125px;

}

#front {
padding-bottom: 125px;
}

	
#addproduct {
	margin-left: 85%;
	margin-top : 50px;
	margin-bottom: 125px;
}

#info {
font-size: 1.8em;
text-shadow: 0px 2px gray;
}


</style>
</head>

<body>

<div id="admin_main_wrapper">
	<div class="menu">

	</div>
	<div id="sidebar" class="col-lg-2">
		<div id="profile">	
			<div id="pic" style="background-image: url('<?=base_url('assets/img/profile.jpg')?>'); background-size: cover; background-position: center; width:130px; border-radius: 50%;">
			</div>
			<div id="pic-name">
				<label>Juan Dela Cruz</label>
			</div>
			<div id="user-type">
				ADMIN
			</div>
		</div>
		<ul id="nav">	
			<!-- <li><a href="<?php echo base_url();?>admin/member"><img src="<?php echo base_url()?>images/admin_images/member.png">Member/Staff</a></li> -->
			<li>
				<a href="<?php echo base_url();?>admin/product"><img src="<?php echo base_url()?>assets/img/check.png" class="img-responsive" width="30px" style="display: inline;">&nbsp;&nbsp;Issue Check</a>
			</li>
			<li>
				<a href="<?php echo base_url();?>admin/product"><img src="<?php echo base_url()?>assets/img/3rd_party.png" class="img-responsive" width="30px" style="display: inline;">&nbsp;&nbsp;3rd Party</a>
			</li>
			<li>
				<a href="<?php echo base_url();?>admin/product"><img src="<?php echo base_url()?>assets/img/report.png" class="img-responsive" width="30px" style="display: inline;">&nbsp;&nbsp;History</a>
			</li>

			<li>
				<a href="<?php echo base_url();?>admin/product"><img src="<?php echo base_url()?>assets/img/logout.png" class="img-responsive" width="30px" style="display: inline;">&nbsp;&nbsp;Logout</a>
			</li>
		</ul>
	</div>

	<div id="receipt" class="col-xs-10">