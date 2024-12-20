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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Edit Profile</span></h4>
					</div>
				</div>
				<!--End Page header-->
				
				<!-- Profile Page-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title">Edit Profile</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/profile" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							<div class="card-body" >
								<form method="POST" action="#" enctype="multipart/form-data">
									<div class="row">
										<div class="col-sm-6 col-md-6">
											<div class="form-group">
												<label class="form-label">First Name</label>
												<input type="text" class="form-control" name="admin_first_name" value="<?php echo set_value('admin_first_name', $this->form_data->admin_first_name); ?>">  <br/>
                          						<?php echo form_error('admin_first_name'); ?>
											</div>
										</div>
										<div class="col-sm-6 col-md-6">
											<div class="form-group">
												<label class="form-label">Last Name</label>
												<input type="text" class="form-control" name="admin_last_name" value="<?php echo set_value('admin_last_name', $this->form_data->admin_last_name); ?>">  <br/>
                          						<?php echo form_error('admin_last_name'); ?>
											</div>
										</div>
										<div class="col-sm-6 col-md-6">
											<div class="form-group">
												<label class="form-label">Email</label>
												<input type="email" class="form-control" Value="<?php echo set_value('admin_email', $this->form_data->admin_email); ?>" disabled readonly>
											</div>
										</div>
										
										<div class="col-sm-6 col-md-6">
											<div class="form-group">
												<label class="form-label">Phone</label>
												<input type="text" class="form-control" name="admin_phone"  value="<?php echo set_value('admin_phone', $this->form_data->admin_phone); ?>">  <br/>
                          						<?php echo form_error('admin_phone'); ?>
											</div>
										</div>
										
										<div class="col-sm-6 col-md-6">
											<div class="form-group">
												<label class="form-label">Phone 2</label>
												<input type="text" class="form-control" name="admin_alt_phone"  value="<?php echo set_value('admin_alt_phone', $this->form_data->admin_alt_phone); ?>">  <br/>
                          						<?php echo form_error('admin_alt_phone'); ?>
											</div>
										</div>										
										<div class="col-sm-6 col-md-6">
											<div class="form-group">
												<label class="form-label">Upload Image</label>
												<div class="input-group file-browser">
													<input class="form-control" name="admin_photo" type="file">
												</div>
												<small class="text-muted"><i>The file size should not be more than 1MB</i></small>
												<?php echo form_error('admin_photo'); ?>
											</div>
										</div>
										<div class="col-md-12 card-footer ">
											<div class="form-group float-end mb-0">
												<input type="submit" name="editprofile" class="btn btn-primary" value="Update Profile">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>		