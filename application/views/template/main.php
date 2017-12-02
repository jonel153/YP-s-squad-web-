<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

	<!--Font Awesome Icons CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">


    <!--Animate.CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/animate.css">

    <!-- Simple Sidebar -->
    <link href="<?php echo base_url();?>assets/css/simple-sidebar.css" rel="stylesheet">

    <!--Main css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">

    <!--DataTables CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/1.10.16/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/1.10.16/css/fixedHeader.bootstrap4.min.css">


	<!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/admin.js"></script>
    <!--DataTables JS-->
    <script src="<?php echo base_url();?>assets/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/1.10.16/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url();?>assets/datatables/1.10.16/js/dataTables.fixedHeader.min.js"></script>

    
</head>

<body>

    <?php $this->load->view('admin/navbar_view')?>
    <input type="hidden" value="<?=base_url()?>" id="base_url"> 
    <div id="wrapper" class="toggled">