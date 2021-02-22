<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Admin Panel Arsip Surat</title>		
		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico');?>">
		<!-- Switchery css -->
		<link href="<?php echo base_url('assets/plugins/switchery/switchery.min.css');?>" rel="stylesheet" />		
		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url('assets/css/bootstrap.min.css');?>" rel="stylesheet" type="text/css" />	
		<!-- DATA TABLES -->
		<link href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet">	
		<!-- Font Awesome CSS -->
		<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet" type="text/css" />		
		<!-- Custom CSS -->
		<link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css'); ?>" >
    	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/datepicker/bootstrap-datetimepicker.min.css'); ?>" >
		<link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css');?>" rel="stylesheet" type="text/css"/>
		<link href="<?php echo base_url('assets/plugins/chart.js/chart.min.css');?>" rel="stylesheet" type="text/css">
		<!-- BEGIN CSS for this page -->

		<!-- END CSS for this page -->
				
</head>
<body class="adminbody">
<div id="main">

	<!-- top bar navigation -->
    <?= $this->include('layout/header') ?>
	<!-- End Navigation -->
 
	<!-- Left Sidebar -->
    <?= $this->include('layout/sidebar') ?>
	<!-- End Sidebar -->

    <div class="content-page">	
		<!-- Start content -->
        <?= $this->renderSection('content') ?> 
		<!-- END content -->
    </div>
	<!-- END content-page -->
    
	<footer class="footer">
		<span class="float-right">
			Powered by <a target="_blank" href="https://nexterweb.id"><b>Nexterweb.id</b></a>
		</span>
	</footer>

</div>
<!-- END main -->
<script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/modernizr.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/moment.min.js');?>"></script>

<script src="<?php echo base_url('assets/js/popper.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

<script src="<?php echo base_url('assets/js/detect.js');?>"></script>
<script src="<?php echo base_url('assets/js/fastclick.js');?>"></script>
<script src="<?php echo base_url('assets/js/jquery.blockUI.js');?>"></script>
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js');?>"></script>
<script src="<?php echo base_url('assets/js/jquery.scrollTo.min.js');?>"></script>

<!-- App js -->
<script src="<?php echo base_url('assets/js/pikeadmin.js');?>"></script>

<?= $this->renderSection('script') ?> 
</body>
</html>