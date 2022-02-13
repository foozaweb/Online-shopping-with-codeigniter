<?php
class CartModel extends CI_Model
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
		$mailToSend =
			'  <html> 
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
						<small class="copyright"> Copyright &copy;' . date('Y') . $sitename . '</small>
					</footer> 
                </body>
            	</html> ';
		// ##############################################################
		$config = array(
			'protocol' => 'mail', //sendmail or smtp
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


	function sendOtp()
	{
		$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
		$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
		$site_email = $this->db->get('chb_settings')->row_array()['email'];

		$token = random_string('alnum', 6);
		$sessionArray = array('otp' => $token);
		$this->session->set_userdata($sessionArray);

		$customer_id = $this->session->userdata('chbCusId');
		$user = $this->db->get_where('chb_customers', array('chb_customers.customer_id' => $customer_id))->row_array();

		$msg = '<div style="overflow:auto;" class="card">
					<p>Please use this token to change your account email address</p>
					<div class="card-white">
						<div class="card-body bg-dark" style="text-align:center;">
							<h1>' . $this->session->userdata("otp") . '</h1>
						</div>
					</div>
				</div>';
		$email = $user['email'];
		$subject = 'Your Token';
		$sign_out = '<div class="card-white">
			<div class="card-body">
				For further enquiries, please visit our <a href="' . $site_url . '">website</a> or send a mail to <strong>' . $site_email . '</strong>
				<p><small>This mail was sent to ' . $user['email'] . ' from ' . $sitename . '.</p>
			</div>
		</div>';
		if ($this->sendMail($msg, $email, $subject, $sign_out)) {
			return true;
		} else {
			return false;
		}
	}

	function getUser()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->join('chb_wallet', 'chb_wallet.customer_id = chb_customers.customer_id', 'left');
		$this->db->join('chb_purchase_count', 'chb_purchase_count.customer_id = chb_customers.customer_id', 'left');
		return $this->db->get_where('chb_customers', array('chb_customers.customer_id' => $customer_id))->row_array();
	}


	function home_categories()
	{
		$output = '';
		$this->db->order_by('cat', 'a');
		$this->db->where('level', '1');
		$category = $this->db->get('chb_category')->result_array();
		foreach ($category as $cat) {
			$this->db->group_by('sub_cat_slug');
			$this->db->where('catName', $cat['cat_slug']);
			$query = $this->db->get('chb_sub_category');
			$queryResult = $query->result_array();
			if ($query->num_rows() > 0) {
				$output .= '<li><a href="' . base_url() . 'ct/' . $cat['cat_slug'] . '"><img src="' . $cat['icon'] . '" style="width:20px; height:20px;"> ' . ucfirst($cat['cat']) . '<i class="fa fa-angle-right"></i></a>';
				$output .= '<div class="mega-menu"> <div class="row">';
				foreach ($queryResult as $queryResult) {
					$output .= '<div class="col-md-4"><div class="' . $queryResult['sub_cat_slug'] . '"><h6>' . ucfirst($queryResult['sub_cat']) . '</h6>';
					$this->db->limit(rand(10, 20));
					$this->db->order_by('id', 'random');
					$this->db->group_by('productBrand');
					$this->db->where('subCategory', $queryResult['sub_cat_slug']);
					$types = $this->db->get('chb_products')->result_array();
					foreach ($types as $type) {
						$output .= '<a href="' . base_url() . 'brand/' . $type['productBrand'] . '">- ' . ucfirst(str_replace('-', ' ', $type['productBrand'])) . '</a>';
					}
					$output .= '</div></div>';
				}
				$output .= '
                                <div class="col-md-12">
                                    <div class="mg-bnr">
                                        <img src="' . base_url() . 'images/ipn.png" alt="">
                                        <div class="mg-content text-right">
                                            <h4>Iphone</h4>
                                            <span>Save upto 50% off</span>
                                        </div>
                                    </div>
                                </div>
                                ';
				$output .= '</div></div></li>';
			} else {
				$output .= '<li><a href="' . base_url() . 'ct/' . $cat['cat_slug'] . '"><img src="' . $cat['icon'] . '" style="width:20px; height:20px;">  ' . ucfirst($cat['cat']) . '</a></li>';
			}
		}
		return $output;
	}

	function get_product($id)
	{
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->where('productId', $id);
		return $this->db->get('chb_products')->row_array();
	}



	function get_similar_products($id)
	{
		$this->db->limit(rand(10, 15));
		$this->db->where('productId', $id);
		$product = $this->db->get('chb_products')->row_array();

		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->where('chb_products.category', $product['category']);
		$this->db->or_where('chb_products.subCategory', $product['category']);
		return $this->db->get('chb_products')->result_array();
	}

	function thereIsAnActivity($activity)
	{
		$customer_id = $this->session->userdata('chbCusId');
		$row = $this->db->get_where('chb_customers', array('customer_id' => $customer_id))->row_array();
		$name = $row['firstname'];
		return $this->db->insert('chb_c_activity', array('activity' => $name . ' ' . $activity, 'customer_id' => $customer_id, 'act_date' => date('d M Y H:i:s a')));
	}

	function compare_product($id)
	{
		$this->db->limit(2);
		$this->db->order_by('id', 'random');
		$this->db->where('productId', $id);
		$product = $this->db->get('chb_products')->row_array();
		$this->db->where('category', $product['category']);
		$this->db->or_where('subCategory', $product['category']);
		return $this->db->get('chb_products')->result_array();
	}

	function addToWishlist()
	{
		$id = $this->input->post('id');
		$customer_id = $this->session->userdata('chbCusId');
		$rows = $this->db->get_where('chb_wishlist', array('customer_id' => $customer_id, 'product_id' => $id));
		if ($rows->num_rows() > 0) {
			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $id));
			$this->db->update('chb_wishlist', array('customer_id' => $customer_id, 'product_id' => $id, 'status' => '01'));

			$this->db->where('status !=', '00');
			return $this->db->get_where('chb_wishlist', array('customer_id' => $customer_id, 'status' => '01'))->num_rows();
		} else {
			$this->db->insert('chb_wishlist', array('customer_id' => $customer_id, 'product_id' => $id, 'date_in' => date('d M Y H:i:s a'), 'status' => '01'));

			$this->db->where('status !=', '00');
			return $this->db->get_where('chb_wishlist', array('customer_id' => $customer_id, 'status' => '01'))->num_rows();
		}
	}

	function countUserWishlist()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->where(array('customer_id' => $customer_id, 'status' => '01'));
		return $this->db->get('chb_wishlist')->num_rows();
	}

	function getUserWishlist()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->join('chb_products', 'chb_products.productId = chb_wishlist.product_id', 'left');
		$this->db->where(array('customer_id' => $customer_id, 'status' => '01'));
		return $this->db->get('chb_wishlist')->result_array();
	}

	function trashWish($id)
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->where(array('customer_id' => $customer_id, 'product_id' => $id));
		return $this->db->delete('chb_wishlist');
	}


	function addToCart()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$type = '';
		$discountApplied = '';
		$id = $this->input->post('id');
		$singleQty = $this->input->post('singleQty');
		$singleColor = $this->input->post('singleColor');
		$singleSize = $this->input->post('singleSize');
		$q = $this->db->get_where('chb_products', array('productId' => $id))->row_array();
		if ($q['quantity'] < 1) {
			$type = 'Pre-Order';
		} else {
			$type = 'Active-Order';
		}

		if ($q['discount'] > 0) {
			$discountApplied =  $q[$this->session->userdata('price_variable')] - ($q[$this->session->userdata('price_variable')] * $q['discount'] / 100);
		} else {
			$discountApplied = $q[$this->session->userdata('price_variable')];
		}


		$cart = $this->db->get_where('chb_cart', array('customer_id' => $customer_id, 'product_id' => $id, 'cart_type' => $this->session->userdata('user_state')));
		$rows = $cart->num_rows();
		$res = $cart->row_array();
		if ($rows < 1) {
			$this->db->insert('chb_cart', array('customer_id' => $customer_id, 'product_id' => $id, 'date_in' => date('d M Y H:i:s a'), 'type' => $type, 'cart_amount' => $discountApplied * $singleQty, 'cart_quantity' => $singleQty, 'cart_weight' => $q['weight'], 'cart_color' => $singleColor, 'cart_size' => $singleSize, 'cart_type' => $this->session->userdata('user_state')));

			$this->db->group_by('product_id');
			return $this->db->get_where('chb_cart', array('customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')))->num_rows();
		}
		if ($rows > 0) {
			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $id, 'cart_type' => $this->session->userdata('user_state')));
			$this->db->update('chb_cart', array('customer_id' => $customer_id, 'product_id' => $id, 'date_in' => date('d M Y H:i:s a'), 'type' => $type, 'cart_amount' => $discountApplied * $singleQty, 'cart_quantity' => $singleQty, 'cart_weight' => $q['weight'], 'cart_color' => $singleColor, 'cart_size' => $singleSize, 'cart_type' => $this->session->userdata('user_state')));

			$this->db->group_by('product_id');
			return $this->db->get_where('chb_cart', array('customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')))->num_rows();
		}
	}

	function countUserCart()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->join('chb_products', 'chb_products.productId = chb_cart.product_id', 'left');
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->group_by('chb_cart.product_id');
		$this->db->where(array('chb_cart.customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')));
		return $this->db->get('chb_cart')->num_rows();
	}

	function getUserCarList()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->join('chb_products', 'chb_products.productId = chb_cart.product_id', 'left');
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->group_by('chb_products.productId');
		$this->db->where(array('chb_cart.customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')));
		return $this->db->get('chb_cart')->result_array();
	}

	function sumUserCarList()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->join('chb_products', 'chb_products.productId = chb_cart.product_id', 'left');
		$this->db->where(array('chb_cart.customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')));
		// $this->db->group_by('chb_products.productId');
		$this->db->select_sum('chb_cart.cart_amount');
		$this->db->select_sum('chb_cart.cart_weight');
		$this->db->select_sum('chb_cart.cart_quantity');
		return $this->db->get('chb_cart')->row_array();
	}

	function trashCart($id)
	{
		$customer_id = $this->session->userdata('chbCusId');
		$ct = $this->db->get_where('chb_cart', array('customer_id' => $customer_id, 'product_id' => $id))->row_array();
		$data = array(
			'product_id' => $ct['product_id'],
			'customer_id' => $ct['customer_id'],
			'date_in' => $ct['date_in'],
			'type' => $ct['type'],
			'cart_quantity' => $ct['cart_quantity'],
			'cart_amount' => $ct['cart_amount'],
			'cart_weight' => $ct['cart_weight'],
			'cart_color' => $ct['cart_color'],
			'cart_size' => $ct['cart_size'],
			'cart_type' => $ct['cart_type'],
		); 
		$counts = $this->db->get_where('chb_cart_deleted', array('customer_id' => $customer_id, 'product_id' => $id));
		if ($counts->num_rows() > 0) {
			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $id));
			if ($this->db->update('chb_cart_deleted', $data)) {
				$this->db->where(array('customer_id' => $customer_id, 'product_id' => $id));
				return $this->db->delete('chb_cart');
			}
		} else {
			if ($this->db->insert('chb_cart_deleted', $data)) {
				$this->db->where(array('customer_id' => $customer_id, 'product_id' => $id));
				return $this->db->delete('chb_cart');
			}
		}
	}



	function updateCart()
	{
		$discountApplied = '';
		$selectedColor = $this->input->post('selectedColor');
		$selectedSize = $this->input->post('selectedSize');
		$selectedQuantity = $this->input->post('selectedQuantity');
		$productID = $this->input->post('productID');
		$this->db->where('productId', $productID);
		$res = $this->db->get('chb_products')->row_array();
		$totalAmt = $res[$this->session->userdata('price_variable')] * $selectedQuantity;

		if ($res['discount'] > 0) {
			$discountApplied =  $totalAmt - ($totalAmt * $res['discount'] / 100);
		} else {
			$discountApplied = $totalAmt;
		}

		$data = array(
			"cart_quantity" => $selectedQuantity,
			"cart_amount" => $discountApplied,
			"cart_color" => $selectedColor,
			"cart_size" => $selectedSize,
		);
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->where(array('product_id' => $productID, 'customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')));
		$this->db->update('chb_cart', $data);

		$this->db->where(array('product_id' => $productID, 'customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')));
		return $this->db->get('chb_cart')->row_array();
	}


	function calculateWeight()
	{
		$productID = $this->input->post('productID');
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->where(array('product_id' => $productID, 'customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')));
		return $this->db->get('chb_cart')->row_array();
	}



	function calculateTotalAmount()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$this->db->where(array('chb_cart.customer_id' => $customer_id, 'cart_type' => $this->session->userdata('user_state')));
		$this->db->select_sum('chb_cart.cart_amount');
		return $this->db->get('chb_cart')->row_array();
	}

	function getBrands()
	{
		$this->db->order_by('p_brand_id', 'random');
		$this->db->limit(rand(10, 15));
		return $this->db->get('chb_product_brand')->result_array();
	}

	function count_shop()
	{
		$this->db->where('display', '1');
		return $this->db->get('chb_products')->num_rows();
	}

	public function get_shops($sortShop, $offset, $per_page)
	{
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->limit($per_page, $offset);
		$this->db->order_by($sortShop, 'desc');
		$this->db->group_by('chb_products.productId');
		$this->db->where('display', '1');
		return $this->db->get('chb_products')->result_array();
	}


	function countShopFilter()
	{
		$array = '';
		$filterShopAmount = str_replace('NGN', '', $this->input->post('filterShopAmount'));
		$amount = explode('-', $filterShopAmount);
		$filter1 = str_replace(' ', '', $amount[0]);
		$filter2 = str_replace(' ', '', $amount[1]);

		$this->db->where($this->session->userdata('price_variable') . ' >=', intval($filter1));
		$this->db->where($this->session->userdata('price_variable') . ' <=', intval($filter2));
		if (!empty($this->input->post('brand'))) {
			foreach ($this->input->post('brand') as $value) {
				$this->db->where('productBrand', $value['brand']);
			}
		}
		$this->db->where('display', '1');
		return $this->db->get('chb_products')->num_rows();
	}

	function shopFilter()
	{
		$array = '';
		$filterShopAmount = str_replace('NGN', '', $this->input->post('filterShopAmount'));
		$amount = explode('-', $filterShopAmount);
		$filter1 = str_replace(' ', '', $amount[0]);
		$filter2 = str_replace(' ', '', $amount[1]);

		if ($this->input->post('selectedBrand') != "") {
			$this->db->where('productBrand', $this->input->post('selectedBrand'));
		}

		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->group_by('chb_products.productId');
		$this->db->where($this->session->userdata('price_variable') . ' >=', intval($filter1));
		$this->db->where($this->session->userdata('price_variable') . ' <=', intval($filter2));
		if (!empty($this->input->post('brand'))) {
			foreach ($this->input->post('brand') as $value) {
				$this->db->where('productBrand', $value['brand']);
			}
		}
		$this->db->where('display', '1');
		return $this->db->get('chb_products')->result_array();
	}





	function count_brand($brand)
	{
		$this->db->where(array('display' => '1', 'productBrand' => $brand));
		return $this->db->get('chb_products')->num_rows();
	}

	public function get_brands($brand, $offset, $per_page, $sortShop)
	{
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->group_by('chb_products.productId');
		$this->db->limit($per_page, $offset);
		$this->db->order_by($sortShop, 'desc');
		$this->db->where(array('display' => '1', 'productBrand' => $brand));
		return $this->db->get('chb_products')->result_array();
	}


	function count_category($category)
	{
		$this->db->where(array('display' => '1', 'category' => $category));
		return $this->db->get('chb_products')->num_rows();
	}
 

	public function get_category($category, $offset, $per_page, $sortShop)
	{
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->group_by('chb_products.productId');
		$this->db->limit($per_page, $offset);
		$this->db->order_by($sortShop, 'desc');
		$this->db->where('display', '1');
		$this->db->where('category', $category);
		$this->db->or_where('subCategory', $category);
		$this->db->or_where('sub_category_level3', $category);
		$this->db->or_where('sub_category_level4', $category);
		$this->db->or_where('sub_category_level5', $category);
		$this->db->or_where('sub_category_level6', $category);
		return $this->db->get('chb_products')->result_array();
	}


	function count_find()
	{
		$search_bar = $this->input->post('search_bar');
		$search_cat = $this->input->post('search_cat');
		if ($search_cat != null && $search_cat != '') {
			$this->db->where('category', $search_cat);
		}
		$this->db->like('product_name', $search_bar);
		$this->db->or_like('category', $search_bar);
		$this->db->or_like('productBrand', $search_bar);
		$this->db->or_like('product_size', $search_bar);
		$this->db->or_like($this->session->userdata('price_variable'), $search_bar);
		$this->db->or_like('subCategory', $search_bar);
		$this->db->or_like('meta_keyword', $search_bar);
		$this->db->or_like('meta_title', $search_bar);
		$this->db->where(array('display' => '1'));
		return $this->db->get('chb_products')->num_rows();
	}

	public function get_find($offset, $per_page, $sortShop)
	{
		$this->db->limit($per_page, $offset);
		$this->db->order_by($sortShop, 'desc');
		$search_bar = $this->input->post('search_bar');
		$search_cat = $this->input->post('search_cat');
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->group_by('chb_products.productId');
		$this->db->like('product_name', $search_bar);
		$this->db->or_like('category', $search_bar);
		$this->db->or_like('productBrand', $search_bar);
		$this->db->or_like('product_size', $search_bar);
		$this->db->or_like($this->session->userdata('price_variable'), $search_bar);
		$this->db->or_like('subCategory', $search_bar);
		$this->db->or_like('meta_keyword', $search_bar);
		$this->db->or_like('meta_title', $search_bar);
		$this->db->where(array('display' => '1'));
		if ($search_cat != null && $search_cat != '') {
			$this->db->where('category', $search_cat);
		}
		return $this->db->get('chb_products')->result_array();
	}

	public function ajaxFind()
	{
		$search_bar = $this->input->post('search_bar');
		$this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
		$this->db->group_by('chb_products.productId');
		$this->db->like('product_name', $search_bar);
		$this->db->or_like('category', $search_bar);
		$this->db->or_like('productBrand', $search_bar);
		$this->db->or_like('product_size', $search_bar);
		$this->db->or_like($this->session->userdata('price_variable'), $search_bar);
		$this->db->or_like('subCategory', $search_bar);
		$this->db->or_like('meta_keyword', $search_bar);
		$this->db->or_like('meta_title', $search_bar);
		$this->db->where(array('display' => '1'));

		return $this->db->get('chb_products')->result_array();
	}

	function createWallet()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$wAddress = random_string('alnum', 10);
		$wResult = $this->db->get_where('chb_wallet', array('customer_id' => $customer_id));
		$data = array('wallet_address' => $wAddress,	'customer_id' => $customer_id,	'wallet_balance' => '0');
		if ($wResult->num_rows() > 0) {
			$this->session->set_flashdata('alert_danger', 'Wallet already created!');
			return false;
		} else {
			$this->session->set_flashdata('alert_success', 'Wallet successfully created! Your wallet address is: ' . $wAddress);
			return $this->db->insert('chb_wallet', $data);
		}
	}

	function shippingEstimate()
	{
		$country = $this->input->post('country');
		$state = $this->input->post('state');
		return $this->db->get_where('chb_logistics_fee', array('country' => $country, 'state' => $state))->row_array();
	}

	function applyCoupon()
	{
		$code = $this->input->post('coupon_code');
		$this->db->where(array('coupon_code' => $code, 'coupon_status' => '01'));
		$query = $this->db->get('chb_coupon');
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$this->db->where(array('coupon_code' => $code, 'coupon_status' => '01'));
			$this->db->update('chb_coupon', array('coupon_status' => 'used'));
			return $this->db->get_where('chb_coupon', array('coupon_code' => $code))->row_array();
		} else {
			return false;
		}
	}

	function productRating()
	{
		$customer_id = $this->session->userdata('chbCusId');
		$id = $this->input->post('id');
		$rating = $this->input->post('rating');
		$query = $this->db->get_where('chb_rating', array('product_id' => $id,	'customer_id' => $customer_id));
		$data = array('product_id' => $id,	'customer_id' => $customer_id,	'rating' => $rating);
		if ($query->num_rows() > 0) {
			$this->db->where(array('product_id' => $id,	'customer_id' => $customer_id));
			return $this->db->update('chb_rating', $data);
		} else {
			return $this->db->insert('chb_rating', $data);
		}
	}

	function newUserReview()
	{
		$customer_id = $this->session->userdata('chbCusId');
		if ($customer_id === '') {
			$customer_id = 'unknown';
		}
		$id = $this->security->sanitize_filename($this->input->post('id'));
		$name = $this->security->sanitize_filename($this->input->post('name'));
		$email = $this->security->sanitize_filename($this->input->post('email'));
		$review = $this->security->sanitize_filename($this->input->post('review'));

		$query = $this->db->get_where('chb_review', array('customer_id' => $customer_id, 'product_id' => $id, 'name' => $name, 'email' => $email, 'review' => $review));
		$data = array('customer_id' => $customer_id, 'name' => $name, 'email' => $email, 'review' => $review,	'product_id' => $id, 'date' => date('M d, Y'));
		if ($query->num_rows() > 0) {
			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $id, 'name' => $name, 'email' => $email, 'review' => $review));
			return $this->db->update('chb_review', $data);
		} else {
			return $this->db->insert('chb_review', $data);
		}
	}


	function getInvoice($reference)
	{
		$this->db->where('reference', $reference);
		return $this->db->get('chb_orders')->row_array();
	}

	function track_order()
	{

		$sitename = $this->db->get('chb_settings')->row_array()['sitename'];
		$site_url = $this->db->get('chb_settings')->row_array()['site_url'];
		$site_email = $this->db->get('chb_settings')->row_array()['email'];
		$invoice_msg = $this->db->get('chb_settings')->row_array()['invoice_msg'];
		$stats = '';
		$delDate = '';
		$pstats = '';
		$current_location = '';
		$ref = $this->input->post('order_id');
		$this->db->where('reference', $ref);
		$order = $this->db->get('chb_orders')->row_array();

		////////////////// check if Reference Exists ///////////////// 
		$exist = $this->db->get_where('chb_orders', array('reference' => $ref));
		////////////////// ./check if Reference Exists ///////////////// 


		////////////////// get logistics details /////////////////
		$log = $this->db->get_where('chb_logistics_fee', array('country' => $order['country'], 'state' => $order['state']))->row_array();
		////////////////// ./get logistics details /////////////////


		////////////////// Get user details ///////////////// 
		$user = $this->db->get_where('chb_customers', array('customer_id' => $order['customer_id']))->row_array();
		$email = $user['email'];
		$name = $user['firstname'] . ' ' . $user['lastname'];
		////////////////// .Get user details ///////////////// 


		////////////////// Convert delivery date to readble format ///////////////// 
		$date = $order['delivery_date'];
		$date = strtotime($date);
		$date = strtotime('+' . $log['duration'] . ' day', $date);
		if ($order['delivery_date'] != '' && $log['state'] != "" && $log['country'] != "") {
			$delDate = date('M d, Y', $date);
		} else {
			$delDate = "";
		}
		////////////////// ./Convert delivery date to readble format ///////////////// 

		if ($order['order_status'] == "0") {
			$stats = 'Pending';
		} elseif ($order['order_status'] == "1") {
			$stats = 'Completed';
		} elseif ($order['order_status'] == "2") {
			$stats = 'Processing';
		} elseif ($order['order_status'] == "3") {
			$stats = 'Cancelled';
		} else {
			$stats = 'Unknown';
		}

		if ($order['payment_status'] == "0") {
			$pstats = 'Pending';
		} elseif ($order['payment_status'] == "1") {
			$pstats = 'Completed';
		} elseif ($order['payment_status'] == "2") {
			$pstats = 'Cancelled';
		} else {
			$pstats = 'Not Found';
		}

		if ($order['current_location'] == "") {
			$current_location = '';
		} else if ($order['current_location'] != "") {
			$current_location = '<h3>Current Location: <strong>' . $order['current_location'] . '</strong></h3>';
		}

		////////////////// if id exists, send mail ///////////////// 

		if ($exist->num_rows() > 0) {
			$subject = "Your order Status";
			$msg = '
				Dear ' . $name . ', <br> ' . $invoice_msg . ' kindly find below your order details and current status  
				<h5>
					Order ID: <strong>' . $order['reference'] . '</strong><br>
					Order Date: <strong>' . $order['order_date'] . '</strong><br>
					Delivery Date: <strong>' . $delDate . '</strong><br>
					Shipping Address: <strong>' . $order['shipping_address'] . '</strong><br>  
					Payment Status: <strong>' . $pstats . '</strong><br>
					Payment Method: <strong>' . $order['payment_method'] . '</strong><br>
					Coupon: <strong>' . $order['coupon'] . '%</strong><br>
					Vat: <strong>NGN' . number_format($order['vat']) . '.00</strong><br>
					Weight: <strong>' . round($order['weight']) . 'Kg.</strong><br>
					Shipping Fee: <strong>NGN' . number_format($order['shippingFee']) . '.00</strong><br>
					Order Class: <strong>' . ucfirst($order['order_type']) . '</strong><br>
					' . $order['order_note'] . '
				</h5>
				' . $current_location . '
				<h2>Sub Total: <strong>NGN' . number_format($order['sub_total']) . '.00</strong><br>
				Grand Total: <strong>NGN' . number_format($order['grandTotal']) . '.00</strong></h2> 
				<hr>
				<h1>Order Status [' . $stats . ']</h1>             
				Thank you for shopping with ' . $sitename . '.';
			$sign_out = '<div class="card-white">
					<div class="card-body">
						For further enquiries, please visit our <a href="' . $site_url . '">website</a> or send a mail to <strong>' . $site_email . '</strong> 
						<p><i><small>This mail was sent to ' . $email . ' from ' . $sitename . '.</p>
					</div>
				</div>';
			if ($this->sendMail($msg, $email, $subject, $sign_out)) {
				$this->session->set_flashdata('alert_success', 'Thank you. Your order details has been sent to your verified email address');
				return true;
			} else {
				$this->session->set_flashdata('alert_danger', 'Unable to send mail. Please confirm your internet connection and try again');
				return false;
			}
		} else {
			$this->session->set_flashdata('alert_danger', 'Order ID not found! Please confirm details');
			return false;
		}
	}

	function TrashOrder($ref)
	{
		$this->db->where(array('reference' => $ref));
		$this->db->update('chb_orders', array('payment_status' => '2', 'order_status' => '3'));
		return $this->thereIsAnActivity('cancelled order with ref ID: ' . $ref);
	}
}
