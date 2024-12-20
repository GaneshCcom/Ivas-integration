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
						<h4 class="page-title"><span class="font-weight-normal text-muted ms-2">Inquiry</span></h4>
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
								<h4 class="card-title">Product Inquiry List</h4>
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
		</div>
	</div>
</div>
<?php $this->load->view('include/footer'); ?>		