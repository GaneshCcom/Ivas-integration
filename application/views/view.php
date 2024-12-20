<?php $this->load->view('include/header');  ?>



<div class="content_cvr clearfix">

  <div class="sidebarCvr">

     <?php $this->load->view('include/sidebar');  ?>

  </div>

  <div class="col-md-10 col-sm-8 col-xs-12">

    <div class="page-title">

      <h2>View of Events</h2>

    </div>

    <div class="page_contents_cvr">

      <div class="page_contents">

        <div class="page-message">

          <?php 

						if($this->session->flashdata('message') != '')

						{ echo $this->session->flashdata('message');}

					?>

        </div>

        <div class="panel panel-default table-cvr"> 

          <!-- <div class="panel-heading">

					<h3 class="panel-title">Profile Pictures Needs to Be Approved</h3>

				  </div> -->

          <div class="panel-body ">

            <div id="buyerList_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

              <div class="row">

                <table id="eventList" class="table table-striped table-bordered table-testimonials dt-responsive " width="100%" cellspacing="0">

                  <thead>

                    <tr>

                      <th>#</th>

                      <th>User ID</th>
                      <th>Name</th>
                      <th>User/Member</th>
                      <th>Phone</th>
                      <th>Checkin</th>
                    </tr>

                  </thead>

                  <tbody>

                    <?php  if( count($allregLists) > 0 ) {

							$i = 0; 

							foreach($allregLists as $key => $event): 

							$i++; 

							$id = $event->id;

							$encodeId = base64_encode($id);

							$hexaId = bin2hex($encodeId);

					?>

                    <tr>

                      <td><?php  echo $i; ?></td>

                      <td><?php echo $event->user_id; ?></td>
                      <td><?php if(isset($event->name)){ echo $event->name;} else { echo $event->member_name;}  ?></td>
                      <td><?php if(isset($event->member_id) != ''){ echo $event->uname; } else { echo "User"; } ?></td>
                      <td><?php echo $event->phone; ?></td>
                      <td>checkin</td>
				      
                    

                    </tr>

                    <?php endforeach; } else { ?>

                    <tr>

                      <td colspan="7" align="center">No records found.</td>

                    </tr>

                    <?php } ?>

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

<?php $this->load->view('include/footer'); ?>

