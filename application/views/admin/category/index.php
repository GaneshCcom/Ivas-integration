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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Category</span></h4>
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
							<div class="card-header border-0 d-sm-max-flex">
								<h4 class="card-title">Category List</h4>
								<div class="card-options mt-sm-max-2">
									<a href="<?php echo base_url() ?>admin/category/add" class="btn btn-primary me-3"><i class="feather feather-plus-circle"></i> Add Category</a>
								</div>
							</div>
							<div class="card-body" >
								<div class="table-responsive spruko-delete">
									<table class="table table-vcenter text-nowrap table-bordered table-striped ticketdeleterow w-100" id="sts-table">
										<thead>
											<tr>
												<th width="10">#</th>
												<th >Category</th>
												<th >Parent Category</th>
												<th >Description</th>
												<th >Category Banner Img</th>
												<th >Category List Img</th>
												<th >Created date</th>
												<th >Status</th>
												<th >Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php if( count($cateLists) > 0 ) {
													$i = 0; 
													foreach($cateLists as $key => $cate): 
													$i++; 
													$encodeId = base64_encode($cate->cat_id);
													$hexaId = bin2hex($encodeId);
											?>
											<tr>
												<td><?php  echo $i; ?></td>
												<td><?php echo $cate->cat_name; ?></td>
												<td><?php echo $cate->par_cat_name; ?></td>
												<td><?php echo $cate->cat_desc; ?></td>
												<td><?php if ($cate->cat_back_img) { ?><img src="<?php echo base_url(); ?>assets/category-back-img/<?php echo $cate->cat_back_img; ?>" > <?php } ?></td>
												<td><?php if ($cate->cat_list_img) { ?><img src="<?php echo base_url(); ?>assets/category-list-img/<?php echo $cate->cat_list_img; ?>" > <?php } ?></td>
												<td><?php echo date('d M, Y', strtotime($cate->cat_created)); ?></td>
												<td><?php $status = $cate->cat_status; if($status == 0) { echo '<span class="badge badge-danger">Inactive</span>'; } elseif($status == 1 ){ echo '<span class="badge badge-primary">Active</span>'; } ?></td>
												<td>
													<div class = "d-flex">
													    <a href="<?php echo base_url() ?>admin/category/edit?cate=<?php echo $hexaId; ?>" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>
													   <?php echo anchor('/admin/category/deletecate/'.$hexaId,'<i class="feather feather-trash-2 text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i>',array('class'=>'action-btns1','onclick'=>"return confirm('Are you sure want to delete this Category?')"));?>
													</div>
												</td>
											</tr>
											 <?php endforeach; } else { ?>
						                    <tr>
						                      <td colspan="8" align="center">No records found.</td>
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
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>		