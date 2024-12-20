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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Profile</span></h4>
					</div>
				</div>
					
				<!-- Profile Page-->
				<div class="row">
					<div class="col-12">
						<div class="flash-message mb-5">
							 <?php 

								if($this->session->flashdata('message') != '')
								{ 

									echo $this->session->flashdata('message');

								}?>	
						</div>
					</div>
					<div class="col-xl-3 col-lg-4 col-md-12">
						<div class="card user-pro-list overflow-hidden">
							<div class="card-body">
								<div class="user-pic text-center">
									<span class="avatar avatar-xxl brround" style="background-image: url(<?php echo base_url(); ?>assets/images/user-profile.png)">
										<span class="avatar-status bg-green"></span>
									</span>
									<div class="pro-user mt-3">
										<h5 class="pro-user-username text-dark mb-1 fs-16"><?php echo $adminInfo->admin_first_name.' '.$adminInfo->admin_last_name; ?></h5>
										<h6 class="pro-user-desc text-muted fs-12"><?php echo $adminInfo->admin_email; ?></h6>
										<div class="btn-list">
											<a href="<?php echo base_url() ?>admin/profile/edit" class="btn btn-primary mt-3">Edit</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-header border-0">
								<h4 class="card-title">Personal Details</h4>
							</div>
							<div class="card-body px-0 pb-0">

								<div class="table-responsive tr-lastchild">
									<table class="table mb-0 table-information">
										<tbody>
											
											<tr>
												<td class="py-2">
													<span class="font-weight-semibold w-50">Name</span>
												</td>
												<td class="py-2 ps-4"><?php echo $adminInfo->admin_first_name.' '.$adminInfo->admin_last_name; ?></td>
											</tr>
											<tr>
												<td class="py-2">
													<span class="font-weight-semibold w-50">Role</span>
												</td>
												<td class="py-2 ps-4">Admin</td>
											</tr>
											<tr>
												<td class="py-2">
													<span class="font-weight-semibold w-50">Email</span>
												</td>
												<td class="py-2 ps-4"><?php echo $adminInfo->admin_email; ?></td>
											</tr>
											<tr>
												<td class="py-2">
													<span class="font-weight-semibold w-50"> Phone </span>
												</td>
												<td class="py-2 ps-4"><?php echo $adminInfo->admin_phone; ?></td>
											</tr>
											<tr>
												<td class="py-2">
													<span class="font-weight-semibold w-50"> Phone 2</span>
												</td>
												<td class="py-2 ps-4"><?php echo $adminInfo->admin_alt_phone; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-9 col-lg-8 col-md-12">
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title"> Profile details</h4>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label"> Firstname</label>
											<input type="text" class="form-control" name="firstname" value="<?php echo $adminInfo->admin_first_name; ?>" disabled>
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label"> Lastname</label>
											<input type="text" class="form-control" name="lastname" value="<?php echo $adminInfo->admin_last_name; ?>" disabled>
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label"> Email</label>
											<input type="email" class="form-control" Value="<?php echo $adminInfo->admin_email; ?>" disabled>
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label"> Phone</label>
											<input type="text" class="form-control " name="phone" value="<?php echo $adminInfo->admin_phone; ?>" disabled>
										</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="form-group">
											<label class="form-label"> Phone 2</label>
											<input type="text" class="form-control " name="alt_phone" value="<?php echo $adminInfo->admin_alt_phone; ?>" disabled>
										</div>
									</div>
								</div>
							</div>
						</div>
						 <div class="card">
						 		<div class="card-header border-0">
                                    <h4 class="card-title">Change Password</h4>
                                </div>
								<form method="POST" action="#">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Old Password<span class="text-red">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" placeholder="Password" value="" name="current_password" autocomplete="current_password">
                                                    <p><?php echo form_error('current_password'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">New Password<span class="text-red">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" placeholder="Password" value=""name="new_password" autocomplete="password">
                                                    <p><?php echo form_error('new_password'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2">Confirm Password<span class="text-red">*</span></label>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control" placeholder="Confirm password" value=""name="password_confirmation" autocomplete="password_confirmation">
                                                    <p><?php echo form_error('password_confirmation'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-end">
										<input type="submit" name="btnSubmit" value="Change Password" id="submit" class="btn btn-primary"/>
                                    </div>
                                </form>
							</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>		