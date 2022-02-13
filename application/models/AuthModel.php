<?php
class AuthModel extends CI_Model
{
	public function sendMail($msg, $email, $subject, $sign_out)
	{
		$localhost = array('::1', '127.0.0.1', 'localhost');
		$protocol = 'mail';
		if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
			$protocol = 'smtp';
		}
		// ##############################################################
		// parameters
		// ##############################################################
		$mailToSend =
			' 
				<html> 
				<head>    
					<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
				    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">  
					<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
				    <style>
				    	.theme-bg-primary-darken {
							background-color: none; 
						}
						.card{
							padding:10px;
							border:1px solid #333;
						}
						.card-white{
							padding:10px;
							border:1px solid #fff;
						}
						.card .card-body {
							padding: 10px;
						}
						.bg-dark{
							background-color:#333;
							color:#fff;
						}
						.container,
						.container-fluid,
						.container-xxl,
						.container-xl,
						.container-lg,
						.container-md,
						.container-sm {
							width: 100%;  
							background-color:#f5f5f5;
						} 
						.section-intro{
							padding:5px 10px 5px 10px;
						} 
					thead tr{
				    	font-weight:bolder;
				    	padding:10px;
				    	color:#000; 
				    }
				    tbody tr{
				    	background: #f5f5f5;
				    	padding:10px;
				    	color:#333;
				    	border:1px solid #333;
				    }
				    tbody tr:hover{
				    	background: #ffffff;
				    	padding:10px;
				    	color:#333;
				    }
					.blink_me { 
					  animation: blinker 1s linear infinite;
					}

					@keyframes blinker {
					  50% {
					    opacity: 0.5;
					  }
					}
						.footer {
							background: #000;
							padding:10px;
							text-align:center;
							color:#fff; 
						}
						.footer a{ 
							color:#d7117e; 
						}
						.py-5 {
							padding-top: 3rem !important;
							padding-bottom: 3rem !important;
						}
						.font-weight-bold {
							font-weight: 700 !important;
							text-align: center;
						}
						.mb-3 {
							margin-bottom: 1rem !important;
						}
						.mx-auto {
							margin-right: auto !important;
							margin-left: auto !important;
						}
						.mb-5 {
							margin-bottom: 3rem !important;
						}
						.text-secondary {
							color: #58677c !important;
						}
						 p{
						 	padding:15px;
						 }
				    </style>
				</head>

				<body>  
					<div class="container"> 
						<a class="nav-link nav-index" href="' . $this->db->get('chb_settings')->row_array()["site_url"] . '"><img src="' . $this->db->get('chb_settings')->row_array()["logo"] . '" alt="logo" style="max-height:90px;"></a>
					</div>   
					<hr><br>

					<section class="skills-section section">
						<div class="container"> 
							<div class="section-intro mx-auto text-center text-secondary">' . $msg . '</div>  
						</div>  
					</section>  
					<footer class="footer text-light text-center"> 
						' . $sign_out . ' 
						<small class="copyright"> Copyright &copy;' . date('Y') . $this->db->get('chb_settings')->row_array()["site_url"] . ' </small>
					</footer> 
                </body>
            	</html> ';
		// ##############################################################

		$config = array(
			'protocol' => 'mail', //sendmail
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => '465',
			'smtp_user' => 'your@gmail.com',
			'smtp_pass' => 'gmail_password',
			'smtp_timeout' => 50,
			'mailtype' => 'html',
			'starttls'  => true,
			'charset' => 'utf-8',
			'mailpath' => '/usr/sbin/sendmail',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE,
		);
		$this->load->library('email');
		$this->email->initialize($config);
		// 		$this->email->clear();
		$site_email = $this->db->get('chb_settings')->row_array()['email'];
		$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
		$this->email->set_header('X-Mailer', 'CodeIgniter');
		$this->email->set_header('X-Priority', '1');
		$this->email->set_header('Subject', $subject);
		$this->email->set_header('Mime-Version', '1.0');
		$this->email->set_header('Importance', 'High');
		$this->email->set_header('X-MSMail-Priority', 'High');

		$this->email->set_newline("\r\n");
		$this->email->from($site_email, $sitename);
		$this->email->to($email);
		$this->email->cc($site_email);
		$this->email->subject($subject);
		$this->email->message($mailToSend);
		$flag = $this->email->send();
		if ($flag) {
			return true;
		} else {
			return false;
		}
	}

	function getUser()
	{ 
		$customer_id = $this->session->userdata('chbCusId');
		return $this->db->get_where('chb_customers', array('customer_id' => $customer_id))->row_array();
	}

	function cA($fname, $lname, $email, $phone, $password, $ns)
	{
		$this->db->where(array('email' => $email));
		$sql = $this->db->get('chbadmin');
		if ($sql->num_rows() > 0) {
			$this->session->set_flashdata('alert_danger', 'Sorry, you cannot use this email. try registering with another email address'); 
			return false;
		}



		$rand = rand(4, 10);
		$customer_id = '';
		$customer_id = str_replace(' ', '', $rand . substr($phone, 4, 6));
		$this->db->where(array('customer_id' => $customer_id));
		$query = $this->db->get('chb_customers');
		if ($query->num_rows() > 0) {
			$customer_id = $rand . substr($phone, 5, -3);
		}

		$chat = array(
			'fname' => $fname,
			'lname' => $lname,
			'unique_id' => $customer_id,
			'email' => $email,
			'password' => $password,
			'status' => 'Offline now',
		);
		$this->db->where(array('email' => $email));
		$q = $this->db->get('users');
		if ($q->num_rows() > 0) {
			$this->db->where(array('email' => $email));
			$this->db->update('users', $chat);
		} else {
			$this->db->insert('users', $chat);
		}


		$data = array(
			'firstname' => $fname,
			'lastname' => $lname,
			'customer_id' => $customer_id,
			'email' => $email,
			'phone' => $phone,
			'password' => $password,
			'accountStatus' => '0',
			'newsletter' => $ns,
			'date_created' => date('d M Y H:i:s a'),
			'month_created' => date('m'),
			'year_created' => date('Y'),
		);
		$this->db->where(array('email' => $email));
		$this->db->or_where(array('phone' => $phone));
		$query = $this->db->get('chb_customers');
		if ($query->num_rows() > 0) {
			$this->session->set_flashdata('alert_danger', 'Either email or phone number has been registered. You can\'t create more than one account with the same email address/phone number. Please try registering a different email or phone.');
			$customer_id = '';
			return false;
		} else {
			$registration_msg = $this->db->get('chb_settings')->row_array()['registration_msg'];
			$subject = "Your account has been created";
			$msg = "<div class='card'><div class='card-body'><h1>Hello " . $fname . ", " . $registration_msg . " <br>This is the last step. Kindly verify your email address by clicking on the button below. <a href='" . base_url() . "auth/vE/" . $customer_id . "'>Verify Email address </a></h1></div><div>";

			$sign_out = $this->db->get('chb_settings')->row_array()['sitename'];

			$this->sendMail($msg, $email, $subject, $sign_out);

			$this->session->set_flashdata('alert_success', 'Congratulations! Your account has been successfully created. kindly check your mailbox for email verification');
			$this->db->insert('chb_customers', $data);
			$customer_id = '';

			// Create Wallet for User  
			$wAddress = random_string('alnum', 10);
			$wResult = $this->db->get_where('chb_wallet', array('customer_id' => $customer_id));
			$walletData = array('wallet_address' => $wAddress,	'customer_id' => $customer_id,	'wallet_balance' => '0');
			if ($wResult->num_rows() > 0) {
				echo '';
			} else {
				$this->db->insert('chb_wallet', $walletData);
			}
			// ./ Create Wallet for user 
			return true;
		}
	}


	function profile()
	{
		$data = '';
		$first_name = $this->input->post('profile_first_name');
		$last_name = $this->input->post('profile_last_name');
		$email = $this->input->post('profile_email');
		$phone = $this->input->post('profile_phone');
		$customer_id = $this->session->userdata('chbCusId');

		$b_name = $this->input->post('b_name');
		$b_email = $this->input->post('b_email');
		$b_phone = $this->input->post('b_phone');
		$b_address = $this->input->post('b_address');


		$chat = array(
			'fname' => $first_name,
			'lname' => $last_name,
		);
		$this->db->where(array('unique_id' => $customer_id));
		$q = $this->db->get('users');
		if ($q->num_rows() > 0) {
			$this->db->where(array('unique_id' => $customer_id));
			$this->db->update('users', $chat);
		} else {
			$this->db->insert('users', $chat);
		}

		if ($b_name != "") {
			$data = array(
				'firstname' => $first_name,
				'lastname' => $last_name,
				'phone' => $phone,
				'business_name' => $b_name,
				'business_email' => $b_email,
				'business_phone' => $b_phone,
				'business_address' => $b_address,
			);
		} else {
			$data = array(
				'firstname' => $first_name,
				'lastname' => $last_name,
				'phone' => $phone,
			);
		}

		$this->db->where(array('customer_id' => $customer_id));
		$this->db->update('chb_customers', $data);
		if ($b_name != "") {
			redirect(base_url() . 'userAccount');
		}
		if ($b_name == "") {
			redirect(base_url() . 'userAccount');
		} else {
			echo "Failed to update profile";
		}
	}

	function updateEmail($email, $token)
	{
		$customer_id = $this->session->userdata('chbCusId');
		$otp = $this->session->userdata('otp');

		$this->db->where('email', $email);
		$this->db->where('customer_id !=', $customer_id);
		$query = $this->db->get('chb_customers');

		if ($token != $otp) {
			$this->session->set_flashdata('alert_danger', 'Invalid Token Entered.');
			return false;
		} else if ($query->num_rows() > 0) {
			$this->session->set_flashdata('alert_danger', 'Email Address Already Exists. Please choose a different email address');
			return false;
		} else {
			$user = $this->db->get_where('chb_customers', array('chb_customers.customer_id' => $customer_id))->row_array();

			$msg = '<div style="overflow:auto;" class="card">
						<p></p>
						<div class="card-white">
							<div class="card-body" style="text-align:center;">
								<h1>Your email address has been successfully changed. we will now reach you via the email address (' . $email . ') you provided</h1>
							</div>
						</div>
					</div>';
			$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
			$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
			$site_email = $this->db->get('chb_settings')->row_array()['email'];
			$email = $user['email'];
			$subject = 'Your Email address has been changed';
			$sign_out = '<div class="card-white">
				<div class="card-body">
					For further enquiries, please visit our <a href="' . $site_url . '">website</a> or send a mail to <b>' . $site_email . '</b>
					<p><small>This mail was sent to ' . $user['email'] . ' from ' . $sitename . '.</p>
				</div>
			</div>';
			if ($this->sendMail($msg, $email, $subject, $sign_out)) {
				$this->db->where(array('unique_id' => $customer_id));
				$this->db->update('users', array('email' => $email));

				$this->db->where(array('customer_id' => $customer_id));
				$this->db->update('chb_customers', array('email' => $email));
				$this->thereIsAnActivity('Updated Email Address');
				return true;
			} else {
				return false;
			}
		}
	}


	function access($loginId, $password)
	{
		$sessionArray = '';
		$this->db->where(array('email' => $loginId, 'password' => md5($password)));
		// $this->db->or_where(array('phone' => $loginId, 'password' => md5($password)));
		$query  = $this->db->get('chb_customers');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$email = $row->email;
			$customer_id = $row->customer_id;
			$accountStatus = $row->accountStatus;

			if ($accountStatus == '0') {
				$sitename = $this->db->get('chb_settings')->row_array()['sitename'];;
				$subject = "Verify Your Email address";
				$msg = "<div class='card'><div class='card-body'><h1>Hello " . $row->firstname . ", You need to verify your email address to continue. Kindly verify your email address by clicking on the button below. <br> <a class='btnVerifyEmail' href='" . base_url() . "auth/vE/" . $customer_id . "'>Verify Email address </a></h1></div><div>";
				$sign_out = $sitename;
				$this->sendMail($msg, $email, $subject, $sign_out);

				$this->session->set_flashdata('alert_danger', 'Email Address haven\'t been verified. we have sent you a mail which contains verification link. kindly check your email and verify your email address.');
				return false;
			}

			if ($accountStatus == '1') {
				$this->db->where('customer_id', $customer_id);
				$this->db->update('chb_customers', array('lastLogin' => date('d M Y H:i:s a')));

				$this->db->insert('chb_c_activity', array('activity' => $row->firstname . ' logged in', 'customer_id' => $customer_id, 'act_date' => date('d M Y H:i:s a')));

				$sessionArray = array('chbCusId' => $customer_id, 'unique_id' => $customer_id, 'chb_chat_email' => $email, 'chbCusEmail' => $email, 'chbUserAuth' => true);
				$this->session->set_userdata($sessionArray);
				$setState = array('user_state' => 'retail', 'price_variable' => 'consumer_price');
				$this->session->set_userdata($setState);
				return true;
			}
		} else {
			$this->session->set_flashdata('alert_danger', 'Invalid Login details');
			return false;
		}
	}

	function vE($id)
	{
		$this->db->where('customer_id', $id);
		return $this->db->update('chb_customers', array('accountStatus' => '1'));
	}

	function thereIsAnActivity($activity)
	{
		$customer_id = $this->session->userdata('chbCusId');
		$row = $this->db->get_where('chb_customers', array('customer_id' => $customer_id))->row_array();
		$name = $row['firstname'];
		return $this->db->insert('chb_c_activity', array('activity' => $name . ' ' . $activity, 'customer_id' => $customer_id, 'act_date' => date('d M Y H:i:s a')));
	}

	function PhotoUpload($output)
	{
		$customer_id = $this->session->userdata('chbCusId'); 
		$chat = array('img' => base_url() . 'assets/profile_photo/' . $output);
		$this->db->where(array('unique_id' => $customer_id));
		$this->db->update('users', $chat);

		$this->db->where('customer_id', $customer_id);
		if ($this->db->update('chb_customers', array('photo' => base_url() . 'assets/profile_photo/' . $output))) {
			return "successful";
		} else {
			return false;
		}
	}

	function new_password()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$old_p = $this->input->post('old_p');
		$new_p = $this->input->post('new_p');
		$email = $this->session->userdata('chbCusEmail');
		$query  = $this->db->get_where('chb_customers', array('email' => $email, 'password' => md5($old_p)));
		if ($query->num_rows() > 0) {  
			$chat = array('password' => md5($new_p));
			$this->db->where(array('unique_id' => $customer_id));
			$this->db->update('users', $chat);

			$this->db->where('customer_id', $this->session->userdata('chbCusId'));
			$upd = $this->db->update('chb_customers', array('password' => md5($new_p)));

			$this->db->where('unique_id', $this->session->userdata('chbCusId'));
			$upd = $this->db->update('users', array('password' => md5($new_p)));
			if ($upd) {
				$this->thereIsAnActivity("Changed account password");
				return "successful";
			} else {
				return "Unknown error! Please try again";
			}
		} else {
			return "Current password is incorrect.";
		}
	}





	function otp()
	{
		$otp = random_string('alnum', 5);
		$email = $this->input->post('email');
		$query  = $this->db->get_where('chb_customers', array('email' => $email));
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$email = $row->email;
			$this->session->set_userdata(array('otp' => $otp));


			$msg = '<div style="overflow:auto;" class="card">
						<p></p>
						<div class="card-white">
							<div class="card-body" style="text-align:center;">
							Hello ' . $row->firstname . ' ' . $row->lastname . ', <br>
							Passwords are security measures to personalize your accounts with different platforms. Your password ensures your account privacy. Maintaining a password  ensures your privacy.
								<h1>You have requested a new password for your account, <br> kindly use the code below for authentication<br> (' . $otp . ') </h1>
							</div>
						</div>
					</div>';
			$site_email = $this->db->get('chb_settings')->row_array()['email'];
			$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
			$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
			$email = $row->email;
			$subject = 'Recover Password';
			$sign_out = '<div class="card-white">
				<div class="card-body">
					For further enquiries, please visit our <a href="' . $site_url . '">website</a> or send a mail to <b>' . $site_email . '</b>
					<p><small>This mail was sent to ' . $row->email . ' from ' . $sitename . '.</p>
				</div>
			</div>';
			$this->sendMail($msg, $email, $subject, $sign_out);
			return $otp;
		} else {
			return 'email_not_found';
		}
	}

	function change_password()
	{ 
		$site_email = $this->db->get('chb_settings')->row_array()['email'];
		$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
		$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));
		$query = $this->db->get_where('chb_customers', array('email' => $email));
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$this->db->where('email', $email);
			$this->db->update('chb_customers', array('password' => $password));

			$this->db->where('email', $email);
			$upd = $this->db->update('users', array('password' =>$password));

			$msg = '<div style="overflow:auto;" class="card">
						<p></p>
						<div class="card-white">
							<div class="card-body" style="text-align:center;">
								<h1>
									Hello, this is to inform you that your account password has been successfully changed.
								</h1>
							</div>
						</div>
					</div>';
			$subject = 'Recover Password';
			$sign_out = '<div class="card-white">
				<div class="card-body">
					For further enquiries, please visit our <a href="' . $site_url . '">website</a> or send a mail to <b>' . $site_email . '</b>
					<p><small>This mail was sent to ' . $email . ' from ' . $sitename . '.</p>
				</div>
			</div>';
			$this->sendMail($msg, $email, $subject, $sign_out);
			$this->session->set_flashdata('alert_success', 'Password Successfully Changed');
			return true;
		}
	}
}
