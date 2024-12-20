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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Product Feature</span></h4>

					</div>
				</div>
				<!--End Page header-->
				
				<!-- Profile Page-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="flash-message mb-5">
							 <?php 

								if($this->session->flashdata('message') != '')
								{ 

									echo $this->session->flashdata('message');

								}?>	
						</div>
						<div class="card ">
							<div class="card-header border-0">
								<h4 class="card-title">Product Feature</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/product" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="add-feature" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<div class="row">
													<div class="col-sm-12 col-md-12">
														<div class="switch-selectall">
															<label class="form-label">List of Features</label>
														</div>
														<hr>
													</div>
												</div>
												<div class="issueLists">
													<div class="row">
														<?php 
												 		if($profeatureLists->feature_list != null)
												 		{
														$profeatureListsary = explode(',', $profeatureLists->feature_list);
														}
														?>
														<?php foreach($featureLists as $key => $feature){ ?>
														<div class="col-xl-3">
															<div class="switch_section">
																<div class="switch-toggle d-flex mt-4">
																	<a class="onoffswitch2">
																		<input type="checkbox" name="features[]" id="myonoffswitch<?php echo $feature->feat_id; ?>" class="toggle-class onoffswitch2-checkbox rolecheck rolecheck-<?php //echo $deptname; ?>" Value="<?php echo $feature->feat_id; ?>" <?php  if($profeatureLists->feature_list != null)
												 		{ if(in_array($feature->feat_id, $profeatureListsary)) { echo "checked"; } }  ?>>
																		<label for="myonoffswitch<?php echo $feature->feat_id; ?>" class="toggle-class onoffswitch2-label" ></label>
																	</a>
																	<label class="form-label ps-3">	<?php echo $feature->feat_name; ?></label>
																</div>
															</div>
														</div>
													<?php	} ?>
													</div>	
												</div>	
											</div>
										</div>
										
									</div>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="updatefeature"  class="btn btn-primary" value="Save">
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


<?php $this->load->view('include/footer'); ?>		
