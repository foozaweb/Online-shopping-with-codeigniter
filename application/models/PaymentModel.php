<?php
class PaymentModel extends CI_Model
{
	public function sendMail($msg, $email, $subject, $sign_out)
	{

		$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
		$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
		$site_email = $this->db->get('chb_settings')->row_array()['email'];
		$site_logo = $this->db->get('chb_settings')->row_array()['logo'];

		$localhost = array('::1', '127.0.0.1', 'localhost');
		$protocol = 'mail';
		if (in_array($_SERVER['REMOTE_ADDR'], $localhost)) {
			$protocol = 'smtp';
		}
		// ##############################################################
		// parameters
		// ##############################################################
		$mailToSend = ' 
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
						<a class="nav-link nav-index" href="' . $site_url . '"><img src="' . $site_logo . '" alt="logo" style="max-height:90px;"></a>
					</div>   
					<hr><br>

					<section class="skills-section section">
						<div class="container"> 
							<div class="section-intro mx-auto text-center text-secondary">' . $msg . '</div>  
						</div>  
					</section>  
					<footer class="footer text-light text-center"> 
						' . $sign_out . ' 
						<small class="copyright"> Copyright &copy;' . date('Y') . $site_url . ' </small>
					</footer> 
                </body>
            	</html>';
		// ##############################################################
		$config = array(
			'protocol' => 'mail', //sendmail or smtp
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => '465',
			'smtp_user' => 'chbluxuryikeja@gmail.com',
			'smtp_pass' => 'CHBLuxury@Ikeja12345',
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


		// 		$config = array(
		// 			'protocol' => $protocol,
		// 			'smtp_host' => 'ssl://smtp.googlemail.com',
		// 			'smtp_port' => 465,
		// 			'smtp_user' => 'chbluxuryikeja@gmail.com',
		// 			'smtp_pass' => 'CHBLuxury@Ikeja12345',
		// 			'smtp_timeout' => 10,
		// 			'mailtype' => 'html',
		// 			'starttls'  => true,
		// 			'newline'   => "\r\n",
		// 		);
		// 		$this->load->library('email');
		// 		$this->email->initialize($config);
		// 		$this->email->from("CHB LUXURY");
		// 		$this->email->to($email);
		// 		$this->email->subject($subject);
		// 		$this->email->message($mailToSend);
		// 		$flag = $this->email->send();
		// 		if ($flag) {
		// 			return $flag;
		// 		} else {
		// 			return false;
		// 		}
	}


	function placeOrder2_0()
	{

		$grandTotal =  $this->input->post('grandTotal');
		$customer_id = $this->session->userdata('chbCusId');
		$reference = $this->input->post('reference');
		$paymentMethod = $this->input->post('paymentMethod');

		$wallet = $this->db->get_where('chb_wallet', array('customer_id' => $customer_id))->row_array();
		$balance = $wallet['wallet_balance'];
		if ($balance < $grandTotal && $paymentMethod == "Wallet") {
			return false;
		}

		$order = $this->db->get_where('chb_orders', array('reference' => $reference))->row_array();
		$Subtotal = $order['sub_total'];
		$CartWeight = $order['weight'];
		$ShippingFee = $order['shippingFee'];
		$GrandTotal = $order['grandTotal'];
		$Coupon = $order['coupon'];
		$VatFee = $order['vat'];
		// ################ SEND ORDER MAIL ####################
		if ($this->sendOrderMail($customer_id, $reference, $Subtotal, $CartWeight, $ShippingFee, $GrandTotal, $Coupon, $paymentMethod, $VatFee) === true) {
			// ################ UPDATE PAYMENT TO PAID  ################
			if ($this->updatePayment($reference, $paymentMethod, $GrandTotal, $customer_id, $balance) === true) {

				// ################ Update Wallet if user paid with Wallet ################
				if ($paymentMethod === 'Wallet') {
					$this->db->where(array('customer_id' => $customer_id));
					$this->db->update('chb_wallet', array('wallet_balance' => $balance - $GrandTotal));
				}
				// ################ Update Wallet if user paid with Wallet ################

				return true;
			}
			// ################ ./UPDATE PAYMENT TO PAID  ################

		}
		// ################ ./SEND ORDER MAIL ####################
	}

	function placeOrder()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$company = $this->input->post('companyName');
		$Address = $this->input->post('deliveryAddress');
		$Country = $this->input->post('shippingCountry');
		$State = $this->input->post('shippingState');
		$City = $this->input->post('deliveryCity');
		$postalCode = $this->input->post('postalCode');
		$reference = $this->input->post('reference');
		$paymentMethod = $this->input->post('paymentMethod');
		$orderNote = $this->input->post('orderNote');
		$Subtotal = $this->input->post('Subtotal');
		$CartWeight = $this->input->post('CartWeight');
		$GrandTotal = $this->input->post('GrandTotal');
		$ShippingFee = $this->input->post('ShippingFee');
		$Coupon = $this->input->post('Coupon');
		$VatFee = $this->input->post('VatFee');


		// ################## Get user Wallet balance #####################
		$wallet = $this->db->get_where('chb_wallet', array('customer_id' => $customer_id))->row_array();
		$balance = $wallet['wallet_balance'];
		if ($balance < $GrandTotal && $paymentMethod == "Wallet") {
			return false;
		}
		// ################## ./Get user Wallet balance #####################

		// ################ Save Address if user requested ################
		if ($this->input->post('saveAddress') != '') {
			$this->saveAddress($customer_id, $company, $Address, $Country, $State, $City, $postalCode);
		}
		// ################ ./Save Address if user requested ################

		// ################ SEND ORDER MAIL ####################
		if ($this->sendOrderMail($customer_id, $reference, $Subtotal, $CartWeight, $ShippingFee, $GrandTotal, $Coupon, $paymentMethod, $VatFee) === true) {
			// ################ UPDATE PAYMENT TO PAID  ################
			if ($this->updatePayment($reference, $paymentMethod, $GrandTotal, $customer_id, $balance) === true) {

				// ################ Update Wallet if user paid with Wallet ################
				if ($paymentMethod === 'Wallet') {
					$this->db->where(array('customer_id' => $customer_id));
					$this->db->update('chb_wallet', array('wallet_balance' => $balance - $GrandTotal));
				}
				// ################ Update Wallet if user paid with Wallet ################

				return true;
			}
			// ################ ./UPDATE PAYMENT TO PAID  ################

		}
		// ################ ./SEND ORDER MAIL #################### 
	}


	function updatePayment($reference, $paymentMethod, $GrandTotal, $customer_id, $balance)
	{
		// ################ store order Items ################ 
		$carts = $this->db->get_where('chb_cart', array('customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')))->result_array();
		foreach ($carts as $cart) {
			$orderItems = array('reference' => $reference, 'product_id' => $cart['product_id'], 'quantity' => $cart['cart_quantity'], 'color' => $cart['cart_color'], 'amount' => $cart['cart_amount'], 'size' => $cart['cart_size'], 'weight' => $cart['cart_weight']);
			$itemResult = $this->db->get_where('chb_order_items', $orderItems)->num_rows();
			if ($itemResult > 0) {
				$this->db->where($orderItems);
				$this->db->update('chb_order_items', $orderItems);
			} else {
				$this->db->insert('chb_order_items', $orderItems);
			}

			// ################# UPDATE PRODUCT QUANTITY ##################
			$prod = $this->db->get_where('chb_products', array('productId' => $cart['product_id']))->row_array();
			$pQ = $prod['quantity'] - $cart['cart_quantity'];
			$this->db->where(array('productId' => $cart['product_id']));
			$this->db->update('chb_products', array('quantity' => $pQ));
			// ################# ./UPDATE PRODUCT QUANTITY ##################

			// ################# INCREASE ORDER COUNT ##################
			$oc = $this->db->get_where('chb_order_count', array('product_id' => $cart['product_id']))->row_array();
			if ($oc < 1) {
				$this->db->insert('chb_order_count', array('count' => '1', 'product_id' => $cart['product_id']));
			} else {
				$counts = $oc['count'] + 1;
				$this->db->where(array('product_id' => $cart['product_id']));
				$this->db->update('chb_order_count', array('count' => $counts));
			}
			// ################# ./INCREASE ORDER COUNT ##################
		}

		// ################ ./store order Items ################

		//################ Clear Cart ################ 
		$this->db->where(array('customer_id' => $customer_id));
		$this->db->delete('chb_cart');      
		//################ ./Clear Cart ################


		$this->db->where('reference', $reference);
		return $this->db->update('chb_orders', array('payment_status' => '1', 'payment_method' => $paymentMethod));
	}

  


	function saveOrder()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$company = $this->input->post('companyName');
		$Address = $this->input->post('deliveryAddress');
		$Country = $this->input->post('shippingCountry');
		$State = $this->input->post('shippingState');
		$City = $this->input->post('deliveryCity');
		$postalCode = $this->input->post('postalCode');
		$reference = $this->input->post('reference');
		$paymentMethod = $this->input->post('paymentMethod');
		$orderNote = $this->input->post('orderNote');
		$Subtotal = $this->input->post('Subtotal');
		$CartWeight = $this->input->post('CartWeight');
		$GrandTotal = $this->input->post('GrandTotal');
		$ShippingFee = $this->input->post('ShippingFee');
		$Coupon = $this->input->post('Coupon');
		$VatFee = $this->input->post('VatFee');

		$this->thereIsAnActivity("Placed a new Order with Ref Number: " . $reference);

		$data = array('reference' => $reference, 'order_date' => date('D d M Y H:i:s a'), 'customer_id' => $customer_id, 'shipping_address' => $Address, 'company_name' => $company, 'country' => $Country,	'state' => $State,	'town' => $City, 'postal_code' => $postalCode,	'order_note' => $orderNote,	'sub_total' => $Subtotal, 'weight' => $CartWeight, 'shippingFee' => $ShippingFee, 'grandTotal' => $GrandTotal, 'coupon' => $Coupon,	'vat' => $VatFee, 'payment_status' => '0', 'order_status' => '0', 'order_type' => $this->session->userdata('user_state'), 'delivery_date' => date('M d, Y'), 'order_month' => date('m'), 'order_year' => date('Y'));
		$valid = array('reference' => $reference);

		$row = $this->db->get_where('chb_orders', $valid);
		if ($row->num_rows() > 0) {
			$this->db->where($valid);
			$this->db->update('chb_orders', $data);
			return true;
		} else {
			$this->db->insert('chb_orders', $data);
			return true;
		}
	}


	function saveAddress($customer_id, $company, $Address, $Country, $State, $City, $postalCode)
	{
		$data = array('customer_id' => $customer_id, 'company' => $company, 'address' => $Address, 'country' => $Country, 'state' => $State, 'town' => $City, 'postalCode' => $postalCode);
		$rows = $this->db->get_where('chb_addresses', $data)->num_rows();
		if ($rows > 0) {
			$this->db->where($data);
			$this->db->update('chb_addresses', $data);
		} else {
			$this->db->insert('chb_addresses', $data);
		}
	}





	function sendOrderMail($customer_id, $reference, $Subtotal, $CartWeight, $ShippingFee, $GrandTotal, $Coupon, $paymentMethod, $VatFee)
	{
		$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
		$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
		$site_email = $this->db->get('chb_settings')->row_array()['email'];
		$site_admin_url = $this->db->get('chb_settings')->row_array()['site_admin_url'];

		$purchase_msg = $this->db->get('chb_settings')->row_array()['purchase_msg'];
		$admin_url = 'https://localhost/chbadmin/';
		$cartBody = '';
		$cartColor = '';
		$cartSize = '';
		$totalBody = '';
		$this->db->join('chb_wallet', 'chb_wallet.customer_id = chb_customers.customer_id', 'left');
		$user = $this->db->get_where('chb_customers', array('chb_customers.customer_id' => $customer_id))->row_array();

		$this->db->join('chb_products', 'chb_products.productId = chb_cart.product_id', 'left');
		$carts = $this->db->get_where('chb_cart', array('chb_cart.customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')))->result_array();

		foreach ($carts as $row) {
			$color = explode(',', $row['cart_color']);
			$size = explode(',', $row['cart_size']);

			for ($i = 0; $i < count($color); $i++) {
				$cartColor .= '<span style="background-color:' . str_replace(' ', '', $color[$i]) . '; width:20px; height:20px;"></span>';
			}
			for ($i = 0; $i < count($size); $i++) {
				$cartSize .= '<span> ' . str_replace(' ', '', $size[$i]) . ' </span>,';
			}
			$cartBody .= ' 
				<tr>
					<td><img src="' . $site_admin_url . '/assets/images/' . $row['main_photo'] . '" alt="photo"  width="40" height="40"></td>
					<td>' . $row['product_name'] . '</td>
					<td>' . $row['cart_quantity'] . '</td>
					<td>' . number_format($row['discount']) . '%</td>
					<td>' . $row['cart_weight'] . 'Kg.</td>  
					<td>'.$this->session->userdata('currency').'' . number_format($row['cart_amount']/$this->session->userdata('ex_rate')) . '.00</td>
					<td>' . $row['date_in'] . '</td>
				</tr>';
		}

		$totalBody = '
				<tr>
					<td> <strong>Ref ID:</strong> </td>
					<td><b>' . $reference . '</b></td>
				</tr>
				<tr>
					<td> <strong>Total Weight:</strong> </td>
					<td><b>' . $CartWeight . 'Kg.</b></td>
				</tr>
				<tr>
					<td> <strong>Shipping Fee:</strong> </td>
					<td><b>'.$this->session->userdata('currency').'' . number_format($ShippingFee/$this->session->userdata('ex_rate')) . '.00</b></td>
				</tr>
				<tr>
					<td> <strong>Coupon:</strong> </td>
					<td><b>' . $Coupon . '%</b></td>
				</tr>
				<tr>
					<td> <strong>VAT:</strong> </td>
					<td><b>'.$this->session->userdata('currency').'' . number_format($VatFee/$this->session->userdata('ex_rate')) . '.00</b></td>
				</tr>
				<tr>
					<td> <strong>Sub Total:</strong> </td>
					<td><b>'.$this->session->userdata('currency').'' . number_format($Subtotal/$this->session->userdata('ex_rate')) . '.00</b></td>
				</tr> ';
		$msg = '<p><h4><b>Dear ' . $user['firstname'] . ' ' . $user['lastname'] . ',</b></h4></p>
						' . $purchase_msg . '
						<p style="background: #d7117e; color:#fff; padding:10px;"><strong>ORDER SUMMARY</strong></p>
						<hr><hr> 
						<div style="overflow:auto;" class="card">
							<table class="table table-hover table-primary">
								<thead>
									<tr>
										<th></th>
										<th>Product Name</th>
										<th>Quantity</th>
										<th>Discount</th>
										<th>Total Weight</th> 
										<th>Total Amount</th>
										<th>Date</th> 
									</tr>
								</thead>
								<tbody>
									' . $cartBody . ' 
								</tbody>
							</table> 
						</div>
						<div style="overflow:auto;" class="card">
							<table class="table table-hover table-secondary">  
								' . $totalBody . '  
							</table> 
						</div>

						<div style="overflow:auto;" class="card">
							<table class="table table-hover table-info">  
								<tr>
									<td><strong>Payment Method:</strong> </td>
									<td><b>' . $paymentMethod . '</b></td>
								</tr>  
							</table> 
						</div> 
						<div style="overflow:auto;" class="card">
							' . $cartColor . '
						</div>
						<div style="overflow:auto;" class="card">
							' . $cartSize . '
						</div> 
						<div>  
							<strong> 
							<h1><b class="blink_me">Grand Total: '.$this->session->userdata('currency').'' . number_format($GrandTotal/$this->session->userdata('ex_rate')) . '.00</b></h1>
							</strong>
						</div>';
		$email = $user['email'];
		$subject = 'Your order Receipt';
		$sign_out = '<div class="card-white">
			<div class="card-body">
				<h2><a href="'.base_url().'trackorder?order_id='.$reference.'">Click here to track order</a></h2>
				For further enquiries, please visit our <a href="' . $site_url . '">website</a> or send a mail to <b>' . $site_email . '</b><br>
				<small>This mail was sent to ' . $user['email'] . ' from ' . $sitename . '.
			</div>
		</div>';
		if ($this->sendMail($msg, $email, $subject, $sign_out)) {
			return true;
		}
	}




	function creditWallet()
	{
		$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
		$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
		$site_email = $this->db->get('chb_settings')->row_array()['email'];
		$site_admin_url = $this->db->get('chb_settings')->row_array()['site_admin_url'];

		$pc = '';
		$amt = $this->input->post('amt');
		$ref = $this->input->post('reference');
		$customer_id = $this->session->userdata('chbCusId');
		$wResult = $this->db->get_where('chb_wallet', array('customer_id' => $customer_id));
		$user = $this->db->get_where('chb_customers', array('customer_id' => $customer_id))->row_array();
		$email = $user['email'];

		$credit = $wResult->row_array();
		if ($credit['wallet_balance'] > 700000) {
			$pc = '5';
		} else if ($amt >=  100 && $amt <= 200000) {
			$pc = '1';
		} else if ($amt >  200000 && $amt <= 500000) {
			$pc = '3';
		} else if ($amt >=  500000 && $amt <= 800000) {
			$pc = '4';
		} else if ($amt >  800000) {
			$pc = '5';
		}

		// Flag Activity
		$this->thereIsAnActivity("Credited wallet with ".$this->session->userdata('currency')."" . number_format($amt/$this->session->userdata('ex_rate')) . ".00 Ref Number: " . $ref);

		if ($wResult->num_rows() > 0) {
			$amount = $credit['wallet_balance'];
			$this->db->where(array('customer_id' => $customer_id));
			// Update Wallet
			$this->db->update('chb_wallet', array('wallet_balance' => $amount + $amt));
			// flag wallet credit activity
			$this->db->insert('chb_wallet_activity', array('reference' => $ref, 'customer_id' => $customer_id, 'date_in' => date('D d M Y H:i:s a'), 'amount' => $amt));
			// send mail return success message


			$subject = "Your wallet has been credited";
			$msg = '<div class="card"><div class="card-body"> Your Wallet has been successfully credited with '.$this->session->userdata('currency').'' . number_format($amt/$this->session->userdata('ex_rate')) . ' Your New Balance is '.$this->session->userdata('currency').'' . number_format($amount + $amt/$this->session->userdata('ex_rate')) . '</div><div>';
			$sign_out = '<div class="card-white">
			<div class="card-body">
				For further enquiries, please visit our <a href="' . $site_url . '">website</a> or send a mail to <b>' . $site_email . '</b>
				<br>
				<p><i><small>This mail was sent to ' . $email . ' from ' . $sitename . '.</p>
			</div>
		</div>';

			// Update purchase count
			$count = $this->db->get_where('chb_purchase_count', array('customer_id' => $customer_id));
			if ($count->num_rows() > 0) {
				if ($count->row_array()['count'] > 4) {
					$this->db->where(array('customer_id' => $customer_id));
					$this->db->update('chb_purchase_count', array('count' => '5'));
				} else {
					$this->db->where(array('customer_id' => $customer_id));
					$this->db->update('chb_purchase_count', array('count' => $pc));
				}
			} else {
				$this->db->insert('chb_purchase_count', array('count' => $pc, 'customer_id' => $customer_id));
			}
			// Update purchase count


			$this->sendMail($msg, $email, $subject, $sign_out);

			return 'Your Wallet has been successfully credited with '.$this->session->userdata('currency').'' . number_format($amt/$this->session->userdata('ex_rate')) . ' Your New Balance is '.$this->session->userdata('currency').'' . number_format($amount + $amt);
		} else {
			// return error message
			return 'No Wallet Address Found!';
		}
	}


	function thereIsAnActivity($activity)
	{
		$customer_id = $this->session->userdata('chbCusId');
		$row = $this->db->get_where('chb_customers', array('customer_id' => $customer_id))->row_array();
		$name = $row['firstname'];
		return $this->db->insert('chb_c_activity', array('activity' => $name . ' ' . $activity, 'customer_id' => $customer_id, 'act_date' => date('d M Y H:i:s a')));
	}

	function checkReference()
	{
		$ref = $this->input->post('reference');
		if ($this->db->get_where('chb_orders', array('reference' => $ref))->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}
