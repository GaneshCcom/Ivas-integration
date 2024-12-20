<?php $this->load->view('include/header');  ?>
<div class="page">
	<div class="page-main">
		<!--aside open-->
		<?php $this->load->view('include/admin-sidebar');  ?>
		<!--aside closed-->
		<div class="app-content main-content">
			<div class="side-app">
				<!--app header-->
				 <?php $this->load->view('include/app-header');  ?>
				<!--/app header-->	
				<div class="page-header d-xl-flex d-block">
					<div class="page-leftheader">
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Dashboard</span></h4>
					</div>
					<div class="page-rightheader">
						<div class="d-flex align-items-end flex-wrap my-auto end-content breadcrumb-end">
							<div class="d-flex breadcrumb-res">
								<div class="header-datepicker me-3">
									<div class="input-group">
										<div class="input-group-text">
												<i class="feather feather-calendar"></i>
										</div><input class="form-control fc-datepicker pb-0 pt-0" value="<?php echo date('d M, Y'); ?>" type="text" disabled>
									</div>
								</div>
								<div class="header-datepicker picker2 me-3">
									<div class="input-group">
										<div class="input-group-text">
												<i class="feather feather-clock"></i>
										</div><!-- input-group-text -->
										<input id="tpBasic " type="text" placeholder="<?php echo date('g:i a'); ?>" class="form-control input-small pb-0 pt-0" disabled>
									</div>
								</div><!-- wd-150 -->
							</div>
						</div>
					</div>
				</div>	
				<!--Dashboard List-->
				<div class="row">
					<div class="col-12">
						 <?php if($this->session->flashdata('message') != ''){ echo $this->session->flashdata('message');} ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xl-12 col-md-12 col-lg-12">
						<div class="row">
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/product" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Products</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allProducts_count->allproductscount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> <!--<i class="las la-box"></i>--> 
													<svg class="dashboardicon" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 114.58"><title>product</title><path d="M118.13,9.54a3.25,3.25,0,0,1,2.2.41,3.28,3.28,0,0,1,2,3l.57,78.83a3.29,3.29,0,0,1-1.59,3L89.12,113.93a3.29,3.29,0,0,1-2,.65,3.07,3.07,0,0,1-.53,0L3.11,105.25A3.28,3.28,0,0,1,0,102V21.78H0A3.28,3.28,0,0,1,2,18.7L43.89.27h0A3.19,3.19,0,0,1,45.63,0l72.5,9.51Zm-37.26,1.7-24.67,14,30.38,3.88,22.5-14.18-28.21-3.7Zm-29,20L50.75,64.62,38.23,56.09,25.72,63.17l2.53-34.91L6.55,25.49V99.05l77.33,8.6V35.36l-32-4.09Zm-19.7-9.09L56.12,8,45.7,6.62,15.24,20l16.95,2.17ZM90.44,34.41v71.12l25.9-15.44-.52-71.68-25.38,16Z"/></svg>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/category" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Category</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allCategory_count->allcategorycount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> <svg class="dashboardicon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 100.16" style="enable-background:new 0 0 122.88 100.16" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M98.74,78.39h6.32V62.24c0-0.31-0.13-0.6-0.34-0.81c-0.21-0.21-0.5-0.34-0.81-0.34l-38.58,0v17.3h6.31 c2,0,3.63,1.63,3.63,3.63v14.52c0,2-1.63,3.63-3.63,3.63l-20.51,0c-2,0-3.63-1.63-3.63-3.63V82.02c0-2,1.63-3.63,3.63-3.63l6.31,0 v-17.3H18.87c-0.31,0-0.6,0.13-0.81,0.34c-0.21,0.21-0.34,0.5-0.34,0.81v16.15h6.42c2,0,3.63,1.63,3.63,3.63v14.52 c0,2-1.63,3.63-3.63,3.63l-20.51,0c-2,0-3.63-1.63-3.63-3.63V82.02c0-2,1.63-3.63,3.63-3.63l6.23,0V62.24 c0-2.48,1.01-4.74,2.64-6.37c1.63-1.63,3.88-2.64,6.37-2.64h38.58V21.78h-6.31c-2,0-3.63-1.63-3.63-3.63V3.63 c0-2,1.63-3.63,3.63-3.63l20.51,0c2,0,3.63,1.63,3.63,3.63v14.52c0,2-1.63,3.63-3.63,3.63l-6.31,0v31.45h38.58 c2.48,0,4.74,1.01,6.37,2.64c1.63,1.63,2.64,3.89,2.64,6.37v16.15h6.33c2,0,3.63,1.63,3.63,3.63v14.52c0,2-1.63,3.63-3.63,3.63 l-20.51,0c-2,0-3.63-1.63-3.63-3.63V82.02C95.11,80.02,96.75,78.39,98.74,78.39L98.74,78.39L98.74,78.39z"/></g></svg> 
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/category/subcates" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Sub Category</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allSubategory_count->allsubcategorycount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> <svg class="dashboardicon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 100.16" style="enable-background:new 0 0 122.88 100.16" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M98.74,78.39h6.32V62.24c0-0.31-0.13-0.6-0.34-0.81c-0.21-0.21-0.5-0.34-0.81-0.34l-38.58,0v17.3h6.31 c2,0,3.63,1.63,3.63,3.63v14.52c0,2-1.63,3.63-3.63,3.63l-20.51,0c-2,0-3.63-1.63-3.63-3.63V82.02c0-2,1.63-3.63,3.63-3.63l6.31,0 v-17.3H18.87c-0.31,0-0.6,0.13-0.81,0.34c-0.21,0.21-0.34,0.5-0.34,0.81v16.15h6.42c2,0,3.63,1.63,3.63,3.63v14.52 c0,2-1.63,3.63-3.63,3.63l-20.51,0c-2,0-3.63-1.63-3.63-3.63V82.02c0-2,1.63-3.63,3.63-3.63l6.23,0V62.24 c0-2.48,1.01-4.74,2.64-6.37c1.63-1.63,3.88-2.64,6.37-2.64h38.58V21.78h-6.31c-2,0-3.63-1.63-3.63-3.63V3.63 c0-2,1.63-3.63,3.63-3.63l20.51,0c2,0,3.63,1.63,3.63,3.63v14.52c0,2-1.63,3.63-3.63,3.63l-6.31,0v31.45h38.58 c2.48,0,4.74,1.01,6.37,2.64c1.63,1.63,2.64,3.89,2.64,6.37v16.15h6.33c2,0,3.63,1.63,3.63,3.63v14.52c0,2-1.63,3.63-3.63,3.63 l-20.51,0c-2,0-3.63-1.63-3.63-3.63V82.02C95.11,80.02,96.75,78.39,98.74,78.39L98.74,78.39L98.74,78.39z"/></g></svg> 
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/faqs" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Faq's</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allFaq_count->allfaqcount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> <svg class="dashboardicon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 122.88 97.85" style="enable-background:new 0 0 122.88 97.85" xml:space="preserve"><g><path d="M45.44,0H15.95c-4.4,0-8.17,1.55-11.3,4.65C1.51,7.75,0,11.52,0,15.95v28c0,4.44,1.55,8.21,4.65,11.3 c3.1,3.1,6.87,4.65,11.3,4.65h13.11c-0.92,3.52-2.04,6.87-3.45,10c-1.37,3.17-3.73,6.2-6.97,9.09c6.23-1.62,11.76-4.05,16.66-7.25 c4.86-3.17,9.09-7.15,12.57-11.83h10.56c4.4,0,8.17-1.58,11.3-4.65c3.13-3.1,4.65-6.87,4.65-11.3v-28c0-4.4-1.55-8.17-4.65-11.3 C66.64,1.51,62.87,0,58.43,0H45.44L45.44,0z M98.04,56.71h-9.34l-1.34,4.16h-8.41l10.04-25.22h9.02l9.99,25.22h-8.63L98.04,56.71 L98.04,56.71z M96.3,51.25l-2.91-9.06l-2.92,9.06H96.3L96.3,51.25z M48.41,37.7c1.09,0.72,1.81,1.18,2.14,1.36 c0.5,0.27,1.18,0.58,2.02,0.94l-2.43,4.65c-1.22-0.56-2.44-1.23-3.64-2c-1.2-0.78-2.04-1.36-2.52-1.74 c-1.94,0.79-4.37,1.19-7.29,1.19c-4.32,0-7.73-1.06-10.22-3.19c-2.95-2.51-4.42-6.05-4.42-10.6c0-4.42,1.29-7.86,3.87-10.31 c2.58-2.45,6.18-3.67,10.81-3.67c4.72,0,8.35,1.19,10.92,3.59c2.57,2.39,3.85,5.82,3.85,10.27C51.5,32.14,50.47,35.31,48.41,37.7 L48.41,37.7z M41.68,33.44c0.7-1.18,1.05-2.95,1.05-5.31c0-2.71-0.54-4.64-1.6-5.8c-1.07-1.16-2.54-1.74-4.42-1.74 c-1.75,0-3.17,0.59-4.25,1.78c-1.09,1.18-1.63,3.03-1.63,5.55c0,2.93,0.53,4.99,1.59,6.17c1.06,1.18,2.52,1.78,4.37,1.78 c0.6,0,1.16-0.06,1.69-0.16c-0.74-0.68-1.9-1.31-3.5-1.91l1.38-2.98c0.78,0.13,1.39,0.3,1.82,0.49c0.44,0.19,1.28,0.71,2.55,1.54 C41.01,33.03,41.33,33.23,41.68,33.44L41.68,33.44z M122.88,32.15v28c0,2.54-0.46,4.93-1.37,7.15c-0.92,2.22-2.25,4.23-4.09,6.02 c-0.77,0.77-1.62,1.48-2.46,2.08c-0.88,0.63-1.8,1.16-2.71,1.62c-0.04,0.04-0.11,0.04-0.14,0.07c-1.2,0.56-2.43,0.95-3.7,1.23 c-1.34,0.28-2.71,0.42-4.12,0.42H90.79c0.18,0.56,0.35,1.13,0.56,1.69c0.53,1.55,1.16,3.1,1.83,4.61v0.04 c0.6,1.41,1.44,2.75,2.47,4.09c1.06,1.37,2.32,2.71,3.84,4.09c1.09,0.95,1.2,2.61,0.21,3.7c-0.67,0.77-1.69,1.06-2.61,0.81 c-3.24-0.85-6.34-1.9-9.23-3.17c-2.89-1.27-5.63-2.75-8.21-4.44c-2.54-1.66-4.93-3.56-7.15-5.63c-1.87-1.76-3.63-3.7-5.28-5.74 h-9.23c-1.73,0-3.42-0.21-5-0.63c-1.58-0.42-3.1-1.09-4.54-1.97c-1.23-0.74-1.62-2.36-0.88-3.59c0.74-1.23,2.36-1.62,3.59-0.88 c0.99,0.6,2.04,1.06,3.2,1.37c1.13,0.32,2.36,0.46,3.63,0.46h10.53c0.81,0,1.58,0.35,2.11,1.06c1.66,2.22,3.49,4.26,5.49,6.13 c1.97,1.87,4.12,3.56,6.44,5.07c2.22,1.44,4.58,2.75,7.08,3.87c-0.49-0.81-0.88-1.62-1.27-2.43c-0.7-1.62-1.37-3.28-1.97-5.04 c-0.56-1.66-1.09-3.38-1.55-5.11c-0.11-0.28-0.14-0.6-0.14-0.92c0-1.44,1.16-2.64,2.64-2.64h16.94c1.06,0,2.04-0.11,2.99-0.32 c0.92-0.21,1.76-0.49,2.57-0.85c0.04-0.04,0.07-0.04,0.11-0.07c0.67-0.32,1.34-0.7,1.94-1.13c0.63-0.46,1.23-0.95,1.8-1.55 c1.3-1.3,2.29-2.75,2.92-4.3c0.63-1.55,0.95-3.28,0.95-5.14v-28c0-1.87-0.32-3.59-0.95-5.14c-0.63-1.55-1.62-2.99-2.92-4.3 c-1.3-1.3-2.75-2.29-4.3-2.92c-1.55-0.63-3.28-0.95-5.14-0.95H86.57c-1.44,0-2.64-1.16-2.64-2.64c0-1.44,1.16-2.64,2.64-2.64h17.72 c2.54,0,4.9,0.46,7.11,1.37c2.22,0.92,4.19,2.25,6.02,4.05c1.8,1.8,3.17,3.8,4.05,6.02c0.92,2.22,1.37,4.58,1.37,7.11H122.88 L122.88,32.15z"/></g></svg>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/testimonials" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Testimonials</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allTestimonials_count->alltestimonialscount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> <svg class="dashboardicon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 118.1 122.88" style="enable-background:new 0 0 118.1 122.88" xml:space="preserve"><g><path d="M69.41,20.71c10.95,0,14.33,0.09,25.28,0.09c1.25,0,2.45,0.11,3.61,0.33c1.15,0.22,2.26,0.54,3.29,0.98 c1.04,0.44,2.05,0.99,3.02,1.64c0.96,0.65,1.87,1.41,2.73,2.26c0.86,0.86,1.62,1.78,2.26,2.73c0.66,0.97,1.21,1.98,1.64,3.02 c0.43,1.04,0.76,2.14,0.98,3.29c0.22,1.16,0.33,2.36,0.33,3.61v36.24c0,1.25-0.11,2.45-0.33,3.61c-0.22,1.16-0.55,2.26-0.98,3.29 c-0.44,1.05-0.99,2.06-1.64,3.02c-0.65,0.96-1.41,1.87-2.26,2.73l-0.01,0.01c-0.89,0.87-1.82,1.63-2.78,2.27 c-0.96,0.65-1.97,1.19-3.01,1.63c-1.04,0.43-2.13,0.76-3.28,0.98c-1.14,0.22-2.34,0.33-3.58,0.33H81c-0.43,0-0.85,0.1-1.24,0.29 c-0.36,0.18-0.69,0.44-0.94,0.78l-0.02,0.02c-1.08,1.43-2.21,2.82-3.4,4.16c-1.19,1.33-2.43,2.62-3.76,3.84 c-1.29,1.2-2.65,2.35-4.06,3.46c-1.41,1.11-2.87,2.15-4.36,3.13c-1.43,0.94-2.94,1.84-4.51,2.69c-1.55,0.84-3.14,1.62-4.76,2.34 c-0.18,0.08-0.38,0.07-0.56-0.03c-0.3-0.17-0.41-0.56-0.24-0.86c0.29-0.51,0.57-1.02,0.85-1.56c0.27-0.5,0.51-1.01,0.75-1.55l0,0 c0.46-1.03,0.9-2.08,1.32-3.16c0.43-1.09,0.83-2.18,1.22-3.31c0.37-1.05,0.71-2.14,1.04-3.24c0.33-1.1,0.64-2.21,0.94-3.32 c0.08-0.33,0.16-0.66,0.16-1c0-0.74-0.3-1.43-0.79-1.92l-0.03-0.03c-0.5-0.5-1.2-0.82-1.95-0.82H40.76c-1.25,0-2.44-0.11-3.58-0.33 c-1.13-0.22-2.21-0.54-3.24-0.97l-0.02-0.01c-1.02-0.4-2.01-0.94-2.96-1.58c-0.98-0.66-1.93-1.45-2.84-2.33l-0.01-0.01 c-0.86-0.86-1.62-1.77-2.27-2.73c-0.66-0.97-1.2-1.97-1.64-3.02c-0.43-1.04-0.76-2.14-0.98-3.29c-0.22-1.16-0.33-2.36-0.33-3.61 v-7.37c0-3.7-4.79-3.73-5.59-1.09v8.41c0,1.58,0.15,3.12,0.43,4.6c0.29,1.51,0.72,2.97,1.29,4.39c0.56,1.37,1.27,2.69,2.13,3.96 c0.86,1.26,1.86,2.47,3,3.61c1.13,1.14,2.34,2.14,3.61,3c1.25,0.85,2.57,1.56,3.94,2.12l0.02,0.01c1.41,0.57,2.88,1,4.38,1.29 c1.48,0.28,3.02,0.43,4.6,0.43l11.43,0c0.07,0,0.15,0.01,0.22,0.03c0.33,0.11,0.51,0.46,0.41,0.79l-0.01,0.02 c-0.22,0.7-0.44,1.4-0.69,2.15l-0.01,0.04c-0.35,1.01-0.74,2.04-1.15,3.07c-0.39,0.97-0.79,1.93-1.21,2.85 c-0.01,0.05-0.02,0.09-0.04,0.14c-0.41,0.93-0.88,1.85-1.43,2.76c-0.54,0.91-1.15,1.8-1.81,2.68c-0.68,0.88-1.44,1.77-2.28,2.67 l-0.03,0.04c-0.85,0.9-1.77,1.79-2.76,2.65c-0.57,0.51-0.88,1.21-0.92,1.91c-0.04,0.7,0.19,1.42,0.7,1.99 c0.36,0.4,0.8,0.67,1.28,0.81c0.48,0.14,1,0.16,1.49,0.02c2.08-0.56,4.12-1.17,6.1-1.85c1.98-0.68,3.9-1.42,5.74-2.22 c1.86-0.8,3.68-1.68,5.44-2.63c1.75-0.94,3.45-1.96,5.09-3.04l0,0c1.63-1.06,3.21-2.19,4.74-3.39c1.53-1.2,3-2.46,4.41-3.77 l0.03-0.03c1.19-1.12,2.34-2.3,3.46-3.52c1.13-1.24,2.22-2.52,3.24-3.82c0.11-0.17,0.31-0.29,0.53-0.29h12.02 c1.61,0,3.15-0.15,4.64-0.43c1.5-0.29,2.94-0.72,4.32-1.28l0.02-0.01c1.39-0.59,2.71-1.31,3.98-2.16c1.26-0.85,2.46-1.83,3.6-2.97 c1.14-1.14,2.14-2.35,3-3.61c0.85-1.26,1.57-2.59,2.13-3.96c0.57-1.39,1-2.84,1.29-4.35c0.28-1.48,0.43-3.03,0.43-4.64l0-36.24 c0-1.61-0.15-3.16-0.43-4.64c-0.29-1.51-0.72-2.96-1.29-4.34c-0.56-1.37-1.28-2.7-2.13-3.96c-0.86-1.27-1.86-2.48-2.99-3.61 c-1.14-1.14-2.34-2.14-3.61-3c-1.25-0.85-2.57-1.56-3.94-2.12l-0.02-0.01c-1.42-0.57-2.88-1-4.39-1.29 c-1.48-0.28-3.02-0.43-4.6-0.43c-11.38,0-15.19-0.05-26.57-0.05C65.42,15.91,65.24,20.71,69.41,20.71L69.41,20.71z M47.02,76.55 c-1.45,0.02-2.63-1.14-2.65-2.59c-0.02-1.45,1.14-2.63,2.59-2.65l27.78-0.42l5.32-0.34c1.45-0.09,2.69,1.01,2.78,2.45 c0.09,1.45-1.01,2.69-2.45,2.78l-5.32,0.34C75.07,76.12,49.36,76.51,47.02,76.55L47.02,76.55z M55.34,60.09 c-1.45,0-2.63-1.18-2.63-2.63c0-1.45,1.18-2.63,2.63-2.63h37.52c1.45,0,2.63,1.18,2.63,2.63c0,1.45-1.18,2.63-2.63,2.63H55.34 L55.34,60.09z M67.02,44.39c-1.45,0-2.63-1.18-2.63-2.63c0-1.45,1.18-2.63,2.63-2.63h25.84c1.45,0,2.63,1.18,2.63,2.63 c0,1.45-1.18,2.63-2.63,2.63H67.02L67.02,44.39z M28.3,0.52l7.15,17.46l18.82,1.4c0.46,0.03,0.81,0.43,0.78,0.9 c-0.02,0.24-0.14,0.45-0.31,0.6L40.35,33.06l4.48,18.34c0.11,0.45-0.17,0.9-0.62,1.01c-0.24,0.06-0.47,0.01-0.66-0.12l-16.03-9.92 l-16.05,9.93c-0.39,0.24-0.91,0.12-1.15-0.27c-0.12-0.2-0.15-0.43-0.1-0.64l4.48-18.34L0.3,20.87c-0.35-0.3-0.4-0.83-0.1-1.18 c0.15-0.18,0.36-0.28,0.58-0.3l18.82-1.4l7.15-17.46c0.17-0.43,0.66-0.63,1.09-0.46C28.06,0.15,28.22,0.32,28.3,0.52L28.3,0.52z"/></g></svg> 
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/blogs" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Blogs</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allBlogs_count->allblogscount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> 	<svg class="dashboardicon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 121.24 122.88" style="enable-background:new 0 0 121.24 122.88" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><g><path class="st0" d="M10.05,96.6C6.38,105.51,1.42,113.97,0,122.88l5.13-0.44c8.1-23.56,15.4-39.4,31.23-59.21 C48.24,48.39,61.13,36.58,77.66,27.2c8.8-5,20.07-10.47,30.21-11.85c2.77-0.38,5.58-0.49,8.46-0.24 c-31.4,7.19-56.26,23.84-76.12,48.8C32.1,74.09,25.05,85.4,18.57,97.32l11.94,2.18l-4.97-2.47l17.78-2.83 c-6.6-2.33-13.12-1.55-15.21-4.06c18.3-0.83,33.34-4.78,43.9-12.45c-3.93-0.55-8.46-1.04-10.82-2.17 c17.69-5.98,27.92-16.73,40.9-26.27c-16.87,3.54-32.48,2.96-37-0.25c29.77,2.21,49-6.02,55.59-26.77c0.57-2.24,0.73-4.5,0.37-6.78 C118.74,0.62,92.49-4.39,83.95,7.77c-1.71,2.43-4.12,4.66-6.11,7.48L85.97,0c-21.88,7.39-23.68,15.54-35,40.09 c0.9-7.47,2.97-14.24,5.66-20.63c-27.34,10.55-36.45,37.11-37.91,59.7c-0.79-7.88,0.67-17.78,3.49-28.9 c-7.98,8-13.41,17.39-11.47,30.79l-3.65-1.63l1.92,7.19l-5.46-2.59L10.05,96.6L10.05,96.6z"/></g></svg>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/inquiry/product" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Products Inquiry</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allProducts_inq_count->allproductsinqcount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> <i class="las la-mail-bulk"></i> </div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-3 col-lg-6 col-md-12">
								<div class="card">
									<a href="<?php echo base_url() ?>admin/inquiry/genral" class="admintickets"></a>
									<div class="card-body">
										<div class="row">
											<div class="col-8">
												<div class="mt-0 text-start"><span class="fs-14 font-weight-semibold">Total Genral Inquiry</span>
													<h3 class="mb-0 mt-1 mb-2"><?php echo $allGenral_inq_count->allgenralinqcount; ?></h3>
												</div>
											</div>
											<div class="col-4">
												<div class="icon1 bg-primary my-auto float-end"> <i class="las la-mail-bulk"></i> </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card ">
							<div class="card-header border-0 d-sm-max-flex">
								<h4 class="card-title">Recent Product Inquiry List</h4>
							</div>
							<div class="card-body" >
								<div class="table-responsive spruko-delete">
									<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="sts-table">
										<thead>
											<tr>
												<th width="10">#</th>
												<th >Product Name</th>
												<th >Name</th>
												<th >Email</th>
												<th >Phone No</th>
												<th >Message</th>
												<th >Created date</th>
											</tr>
										</thead>
										<tbody>
											<?php if( count($inquiryLists) > 0 ) {
													$i = 0; 
													foreach($inquiryLists as $key => $inquiry): 
													$i++; 
											?>
											<tr>
												<td><?php  echo $i; ?></td>
												<td><?php echo $inquiry->pro_name; ?></td>
												<td><?php echo $inquiry->inq_name; ?></td>
												<td><?php echo $inquiry->inq_email; ?></td>
												<td><?php echo $inquiry->inq_phone; ?></td>
												<td><?php echo $inquiry->inq_message; ?></td>
												<td><?php echo date('d M, Y', strtotime($inquiry->inq_created)); ?></td>
											</tr>
											 <?php endforeach; } else { ?>
						                    <tr>
						                      <td colspan="7" align="center">No records found.</td>
						                    </tr>
						                    <?php }  ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>	
				</div>
			</div>
		</div><!-- end app-content-->
	</div>
</div>
<?php $this->load->view('include/footer'); ?>