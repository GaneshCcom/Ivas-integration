
 <?php //$this->load->view('../include/header'); ?>
	
 <?php   /*$members = $this->session->userdata('members');
					//print_r($members);
					if($members['loggedin'] == 1)

					{
						$welcome_name = $members['fname'];
						$loggedin = true;

					}

					else

					{

						$loggedin = false;	
						$welcome_name = '';

					}

					if($loggedin == true)

					{

						//echo anchor('login/logout', 'Logout', 'title="Logout"');
						echo '<li>'.anchor('login/logout', 'Logout', 'title="Logout"').'</li>';
						
					}

					else

					{

						echo '<li>'.anchor('login/logout', 'Signup Now', 'title="Logout"').'</li>';
						echo '<li class="last">'.anchor('login', 'Login', 'title="Login"').'</li>';
					
					}

		  echo $welcome_name; */ ?>
<div class="container">
	<h1>Welcome to CodeIgniter134!</h1>

	<div id="body">
		<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p>If you would like to edit this page you'll find it located at:</p>
		<code>application/views/welcome_message.php</code>

		<p>The corresponding controller for this page is found at:</p>
		<code>application/controllers/Welcome.php</code>

		<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

<?php //$this->load->view('../include/footer'); ?>