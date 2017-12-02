<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CushyCheck</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">

	<!--Font Awesome Icons CSS-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css">


    <!--Animate.CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/animate.css">

    <!-- Simple Sidebar -->
    <link href="<?php echo base_url();?>assets/css/simple-sidebar.css" rel="stylesheet">

    <!--Main css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/landingPage.css">

	<!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url();?>assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

</head>

<body>

<!-- navbar -->
<nav class="navbar navbar-expand-lg" style="z-index: 200">
  <!-- <a class="navbar-brand" href="#">Cushy/Check</a> -->
  <h3 class="text-primary">Cushy/Check</h3>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
      </li> -->
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> -->
      <a href="<?=base_url('login')?>" class="btn btn-outline-primary my-2 my-sm-0" type="submit">Login</a>
    </form>
  </div>
</nav>
<!--parallax-->
<div class="row">
  <div class="col-12" style="height: 650px;">
    <div class="parallax-1">
    	<div class="row">
    		<div class="col-md-6" style="top: 100px;"">
    			<img class="rounded mx-auto d-block animated fadeIn" src="<?php echo base_url();?>assets/img/logo_web.png">
    		</div>
    		<div class="col-md-6 my-auto" style="top: 100px; left: -50px">
    			<h1 class="display-1 align-middle text-light animated fadeIn" style="font-family: Century Gothic;">Cushy/Check</h1>
    		</div>
    	</div>
    </div>
  </div>
</div>

<!-- logo content -->

<!-- parallax -->

<!-- page 1 -->
<div class="row">
	<div class="col">
		<img src="<?php echo base_url();?>assets/img/page1.png">
	</div>
</div>
<!-- parallax -->
<div class="row">
  <div class="col-12">
    <div class="parallax-2"></div>
  </div>
</div>
<!-- page 2 -->
<div class="row">
	<div class="col">
		<img src="<?php echo base_url();?>assets/img/page2.png">
	</div>
</div>
<!-- parallax -->
<div class="row">
  <div class="col-12">
    <div class="parallax-3"></div>
  </div>
</div>
<!-- page 3 footer?-->
<div class="row">
	<div class="col">
		<img src="<?php echo base_url();?>assets/img/page3.png">
	</div>
</div>


</body>

</html>