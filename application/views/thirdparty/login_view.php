<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Login</title>
		<!-- Bootstrap core CSS -->
		<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
		<!--Font Awesome Icons CSS-->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">
		<!--Animate.CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/animate.css">
		<!--Main css-->
<!-- 		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css"> -->
		<!--DataTables CSS-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/1.10.16/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/1.10.16/css/responsive.bootstrap4.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/1.10.16/css/fixedHeader.bootstrap4.min.css">
		<!-- Bootstrap core JavaScript -->
		<script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
		<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<style type="text/css">
			html, body {
			  width: 100%;
			  height: 100%;
			}

			#outer{
			  position: relative;
			  width: 100%;
			  height: 100%;
			}

			#inner{
			    background-color: rgba(238,238,238 ,0.3);
			    padding: 50px 30px;
			    width: 100%;
			    max-width: 300px;    
			    position: absolute;
			    transform: translate(-50%, -50%);
			    left: 50%;top: 50%;
			}

			#bg_login{
				position: fixed; 
			  	top: 0; 
			  	left: 0; 
				
			  	/* Preserve aspet ratio */
			  	min-width: 100%;
			  	min-height: 100%;

			  	z-index: -1;
			}
		</style>
	</head>
	<body>
		<!--login_page-->
		<img id="bg_login" src="<?php echo base_url();?>assets/img/login.jpg">

		<div id="outer" class="col-md-3 mx-auto align-middle" style="height: 100%">
			<div id="inner" class="align-middle animated fadeIn rounded">
				
				<h1 class="text-center">Admin Login</h1>

				<form class="form-row" action="<?=base_url('login/login-process')?>" method="POST">
				<label>Email</label>
				<input type="email" name="email" class="form-control" placeholder="Enter name..." required>
				<label>Password</label>
				<input type="password" name="password" class="form-control" placeholder="Enter password..." required>
				<button class="btn btn-primary mt-3" type="submit" value="Login" style="width: 100%;">Login</button>
				</form>
			</div>
		</div>
	</body>
</html>