<div class="app-header header header-main">
	<div class="container-fluid">
		<div class="d-flex">
			<a class="header-brand" href="#">
				<img src="<?php echo base_url(); ?>assets/images/logo.png" class="header-brand-img dark-logo" alt="logo">
			
			</a>
			<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
				<a class="open-toggle" href="#">
					<i class="feather feather-menu"></i>
				</a>
				<a class="close-toggle" href="#">
					<i class="feather feather-x"></i>
				</a>
			</div>
			<div class="header-buttons-main">
				<!--<a class="btn btn-outline-light header-buttons text-center" href="<?php echo base_url() ?>admin/ticket/createticket"><i class="fa fa-paper-plane-o pe-lg-2"></i><span class="d-m-none">Create Ticket</span></a>-->
				<a class="btn btn-outline-light header-buttons text-center visitsite ms-2" href="<?php echo base_url() ?>admin/dashboard" target="_blank"><i class="fe fe-home pe-lg-2"></i><span class="d-m-none">Dashboard</span></a>
					
			</div><!-- SEARCH -->
			<div class="d-flex order-lg-2 my-auto ms-auto me-0 dropdown-container align-items-center">
				<div class="dropdown header-fullscreen">
					<a class="nav-link icon full-screen-link">
						<i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
						<i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
					</a>
				</div>
				<!--Notification Page-->
				<!-- <div class="dropdown header-message">
					<a class="nav-link icon" data-bs-toggle="dropdown">
						<i class="feather feather-bell header-icon"></i>
					
						<span class="badge badge-success badge-counter">5</span>
					</a>
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated p-0 notification-dropdown-container">
						<div class="header-dropdown-list message-menu" id="message-menu">
				

								<a class="dropdown-item border-bottom mark-as-read" href="$notification-link" data-id="notification-id">
									<div class="d-flex align-items-center">
										<div class="">
											<span class="bg-success-transparent brround fs-12 notifications"><i class="feather  feather-bell sidemenu_icon fs-20 text-success"></i></span>
										</div>
										<div class="d-flex">
											<div class="ps-3">
												<h6 class="mb-1">notification-title</h6>
												<p class="fs-13 mb-1 text-wrap">  A new ticket has been created = SP-1</p>
												<div class="small text-muted">
													9 Minutes Ago
												</div>
											</div>
										</div>
									</div>
								</a>
							


						<a class="dropdown-item border-bottom mark-as-read notification-dropdown" href="">
							<div class="d-flex justify-content-center">
								<div class="ps-3 text-center">
									<img src="<?php echo base_url(); ?>assets/images/nonotification.png" alt="">
									<p class="fs-13 mb-1 text-muted">xsdsd</p>
								</div>
							</div>
						</a>
							
						
					
						</div>
						<div class="text-center p-2">
							<a href="#" class="smark-all">See All Notification (4)</a>
						</div>
					</div>
				</div> -->
				<!--Notification Page-->
				<?php $adminSession = $this->session->userdata('adminSession');?>
				<div class="dropdown profile-dropdown">
					<a href="#" class="nav-link pe-1 ps-0 leading-none" data-bs-toggle="dropdown">
						<span>
							 <?php $photo =  $adminSession['admin_photo']; ?>
							<img src="<?php if(!empty($photo)){ echo base_url().'assets/admin-profile/'.$photo; } else { echo base_url().'assets/images/user-profile.png'; }?>" class="avatar avatar-md bradius rounded-circle" alt="<?php echo $adminSession['admin_name']; ?>">
						</span>
					</a>
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
						<div class="p-3 text-center border-bottom">
							<a href="#" class="text-center user pb-0 font-weight-bold"><?php echo $adminSession['admin_name']; ?></a>
							<p class="text-center user-semi-title">Admin</p>
						</div>
						<a class="dropdown-item d-flex" href="<?php echo base_url() ?>admin/profile">
							<i class="feather feather-user me-3 fs-16 my-auto"></i>
							<div class="mt-1">Profile</div>
						</a>
						<a class="dropdown-item d-flex" href="<?php echo base_url() ?>admin/login/logout">
							<i class="feather feather-power me-3 fs-16 my-auto"></i>
							<div class="mt-1" >Logout</div>
						</a>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>