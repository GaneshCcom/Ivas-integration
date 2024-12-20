<?php $this->load->view('include/login-header'); ?>

<div class="page login-bg1">
      <div class="page-single">
        <div class="container">
          <div class="row justify-content-center align-items-center">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 p-md-0">
              <div class="card p-5 login-frmCvr">
                <div class="p-5 pt-0 d-flex align-items-center login-frminfo">
                  <img src="<?php echo base_url(); ?>assets/images/logo.png" class="header-brand-img custom-logo-dark" alt="Tea Post">
                    <div class="form-info">
                    <h1 class="mb-1">Forgot Password?</h1>
                    <p class="text-muted mb-0">Forgot Password of your account</p>
                  </div>
                </div>
                   <?php 

                if($this->session->flashdata('message') != '')
                { 

                  echo $this->session->flashdata('message');

                }?> 
              <?php 
                
                if($this->session->flashdata('forgotmessage') != '')
                
                { 
                
                echo $this->session->flashdata('forgotmessage');
                
                } ?>  
                
                <p>Enter your registered "E-mail", select appropriate user type and click on submit to receive your password in your E-mail.</p>
                
                <form id="forgotForm" name="forgotForm" method="post" action="<?php //echo $actionForgot;?>">           

                  <div class="form-group">
                    <label class="form-label">Email <span class="text-red">*</span></label>
                    <input  class="form-control" type="email" name="admin_email" id="admin_email" value="<?php echo set_value('admin_email', $this->form_data->admin_email); ?>"  aria-label="admin_email" aria-describedby="basic-addon1" placeholder="Admin Email*"   />
                    <p><?php echo form_error('admin_email'); ?> </p>
                  </div>
                
                  <div class="submit">
                    <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-primary btn-block"/>
                  </div>
                  <div class="text-center mt-3">
                    <p class="mb-2">Back to <a href="<?php echo base_url(); ?>admin/login">Log In</a></p>
                  </div>                
                </form> 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 <!-- Login -->

  
<?php $this->load->view('include/login-footer'); ?>