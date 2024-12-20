<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>IVAS <?php echo ' | '.$title;?></title>
	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.png" type="image/x-icon"/>	
		<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.rtl.css" rel="stylesheet" />
		<!-- Bootstrap css -->
		<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />
		<!-- Style css -->
		<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/updatestyles.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/dark.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/skin-modes.css" rel="stylesheet" />
		<!-- Animate css -->
		<link href="<?php echo base_url(); ?>assets/css/animated.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/sidemenu.css" rel="stylesheet" />
		<!-- P-scroll bar css-->
		<link href="<?php echo base_url(); ?>assets/plugins/p-scrollbar/p-scrollbar.css" rel="stylesheet" />
		<!---Icons css-->
		<link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" />
		<!-- Select2 css -->
		<link href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/plugins/summernote/summernote.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/plugins/dropzone/dropzone.css" rel="stylesheet" />
		<!-- ADMIN INTERNAL Data table css -->
		<link href="<?php echo base_url(); ?>assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/plugins/datatable/responsive.bootstrap5.css" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/plugins/datatable/buttonbootstrap.min.css" rel="stylesheet" />
		<!-- ADMIN INTERNAL Sweet-Alert css -->
		<link href="<?php echo base_url(); ?>assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />	
		
	</head>
	<body class="app sidebar-mini">
	<?php  $cmp = $this->session->userdata('cmp');?>
