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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Product Attributes</span></h4>

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
								<h4 class="card-title">Product Attributes</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/product" class="btn btn-primary me-3"><i class="feather feather-corner-up-left"></i> Back</a>
								</div>
							</div>
							 <form class="add-dept" name="add-attribute" method="post" action="<?php //echo $action; ?>" enctype="multipart/form-data">
								<div class="card-body" >
									<?php foreach($attributeLists as $key => $attribute){ ?>
									<div class="row">
										<div class="col-sm-12 col-md-12">
											<div class="form-group">
												<div class="row">
													<div class="col-sm-12 col-md-12">
														<div class="switch-selectall">
															<label class="form-label">List of <?php echo $attribute->attr_name; ?> Attribute</label>
														</div>
														<hr>
													</div>
												</div>
												<div class="issueLists">
												<div class="row">
														<?php 
												 		if($proattributeLists->pro_attributes_list != null)
												 		{
														$proattributeListsary = explode(',', $proattributeLists->pro_attributes_list);
														}
														?>
														<?php foreach($attributevalueLists as $key => $attributevalue){ 
															if($attribute->attr_id == $attributevalue->attr_id){
															?>
														<div class="col-xl-3">
															<div class="switch_section">
																<div class="switch-toggle d-flex mt-4">
																	<a class="onoffswitch2">
																		<input type="checkbox" name="attributes[]" id="myonoffswitch<?php echo $attributevalue->attr_val_id; ?>" class="toggle-class onoffswitch2-checkbox rolecheck rolecheck-<?php //echo $deptname; ?>" Value="<?php echo $attributevalue->attr_val_id; ?>" <?php  if($proattributeLists->pro_attributes_list != null)
												 		{ if(in_array($attributevalue->attr_val_id, $proattributeListsary)) { echo "checked"; } }  ?>>
																		<label for="myonoffswitch<?php echo $attributevalue->attr_val_id; ?>" class="toggle-class onoffswitch2-label" ></label>
																	</a>
																	<label class="form-label ps-3">	<?php echo $attributevalue->attr_val_name; ?></label>
																</div>
															</div>
														</div>
													<?php	} } ?>
													</div>	
												</div>	
											</div>
										</div>
										
									</div>
									<?php	} ?>
								</div>
								<div class="col-md-12 card-footer">
									<div class="form-group float-end">
										<input type="submit"  name="updateattribute"  class="btn btn-primary" value="Save">
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
