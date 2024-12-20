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
										<h1 class="mb-1">Admin Login</h1>
										<p class="text-muted mb-0">Sign In to your account</p>
									</div>
								</div>
									 <?php 

				if($this->session->flashdata('message') != '')
				{ 

					echo $this->session->flashdata('message');

				}?>	
			 <form id="loginForm" class="loginfrm card-body pt-3" name="loginForm" method="post" action="">
									<div class="form-group">
										<label class="form-label">Email <span class="text-red">*</span></label>
										<input  class="form-control" type="email" name="admin_email" id="admin_email" value="<?php echo set_value('admin_email', $this->form_data->admin_email); ?>"  aria-label="admin_email" aria-describedby="basic-addon1" placeholder="Admin Email*"   />
						  			<p><?php echo form_error('admin_email'); ?> </p>
									</div>
									<div class="form-group">
										<label class="form-label">Password <span class="text-red">*</span></label>
										  <input  class="form-control" type="password" name="admin_password" id="admin_password" value="<?php echo set_value('admin_password',$this->form_data->admin_password); ?>" placeholder="Password*"  aria-label="password" aria-describedby="basic-addon2"/>  
                            <p><?php echo form_error('admin_password'); ?></p>
									</div>
									<!-- <div class="form-group">
										<label class="custom-control form-checkbox">
											<input type="checkbox" class="custom-control-input" name="remember" id="remember">
											<span class="custom-control-label">Remember me</span>
										</label>
									</div> -->
									<div class="submit">
										<input type="submit" name="submit" value="Login" id="submit" class="btn btn-primary btn-block"/>
									</div>
									<!--<div class="text-center mt-3">
										<p class="mb-2"><a href="<?php echo $actionForgot;?>">Forgot Password?</a></p>
									</div>-->

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
 <!-- Login -->
       
  <!-- Forgot -->
  
    	<!--<div class="sidebar-box" id="forgot">
        	<div class="col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-info" >
                <div class="panel-heading">
                	<div class="panel-title">Forgot Password?</div>
                </div>
                <div class="panel-body" >
                
                <?php /*
                
                if($this->session->flashdata('forgotmessage') != '')
                
                { 
                
                echo $this->session->flashdata('forgotmessage');
                
                }*/ ?>	
                
                <p>Enter your registered "E-mail", select appropriate user type and click on submit to receive your password in your E-mail.</p>
                
                <form id="forgotForm" name="forgotForm" method="post" action="<?php //echo $actionForgot;?>">						
                
                <p><label for="username"><b>E-Mail:</b></label><br />
                
                <input  class="textbox required email" type="text" name="email" id="email" /></p>
                
                
                <input type="submit" name="submit" value="submit" id="submit" class="button" /> <br />
                
                <p id="message-outcome"></p>
                
                
                
                </form>			
                </div>
            </div>
            </div>
        </div> -->
	
<?php $this->load->view('include/login-footer'); ?>