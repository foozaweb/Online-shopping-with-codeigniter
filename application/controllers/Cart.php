<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
// error_reporting(E_ERROR | E_PARSE);


class Cart extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('CartModel');
		date_default_timezone_set('Africa/Lagos'); 
		if (!$this->session->userdata('user_state') || $this->session->userdata('user_state') == "" || is_null($this->session->userdata('user_state'))) {
			$state = array('user_state' => 'retail', 'price_variable' => 'consumer_price');
			$this->session->set_userdata($state);
		} 

		if (!$this->session->userdata('currency') || $this->session->userdata('currency') == "" || is_null($this->session->userdata('currency'))) {
			$array = array('currency' => 'NGN', 'ex_rate' => '1', 'ex_symbol'=>'₦');
			$this->session->set_userdata($array);
		} 
		
		if ($this->session->userdata('currency') == 'USD' && $this->session->userdata('ex_rate') != $this->db->get('chb_settings')->row_array()['ex_rate']) {
			$array = array('currency' => 'USD', 'ex_rate' => $this->db->get('chb_settings')->row_array()['ex_rate'], 'ex_symbol'=>'$');
			$this->session->set_userdata($array);
		}
	}

	function setCurrency($curr){
		$array = '';
		if ($curr == 'USD') {
			$array = array('currency' => 'USD', 'ex_rate' => $this->db->get('chb_settings')->row_array()['ex_rate'], 'ex_symbol'=>'$');
			$this->session->set_userdata($array);
		} else if ($curr == 'NGN') {
			$array = array('currency' => 'NGN', 'ex_rate' => '1', 'ex_symbol'=>'₦');
			$this->session->set_userdata($array);
		}
		$this->goBack();
	}


	function setState($state)
	{
		$array = '';
		if ($state == 'retail') {
			$array = array('user_state' => 'retail', 'price_variable' => 'consumer_price');
			$this->session->set_userdata($array);
		} else if ($state == 'wholesale') {
			$array = array('user_state' => 'wholesale', 'price_variable' => 'wholesale_price');
			$this->session->set_userdata($array);
		}
		$this->goBack();
	}

	function sortShop($val)
	{
		$this->session->set_userdata(array('sortShop' => $val));
		$this->goBack();
	}

	function setPage($val)
	{
		$this->session->set_userdata(array('perPage' => $val));
		$this->goBack();
	}

	function saveThisUrl($url)
	{
		if ($this->db->get_where('chb_urls', array('url' => $url))->row_array() > 0) {
			$this->db->where(array('url', $url));
			return false;
		} else {
			return $this->db->insert('chb_urls', array('url' => $url));
		}
	}

	public function chb($page = 'cats')
	{
		if (!file_exists(APPPATH . 'views/customer/' . $page . '.php')) {
			redirect(base_url() . '404');
		}
		$this->saveThisUrl(base_url() . $page);
		$sortShop = '';
		if (!$this->session->userdata('sortShop') || $this->session->userdata('sortShop') == "") {
			$sortShop = 'product_name';
		} else {
			$sortShop = $this->session->userdata('sortShop');
		}


		$perPage = '';
		if (!$this->session->userdata('perPage') || $this->session->userdata('perPage') == "") {
			$perPage = 24;
		} else {
			$perPage = $this->session->userdata('perPage');
		}
		$config = array();
		$offset = $this->uri->segment(4);
		$config['base_url'] = base_url() . 'Cart/chb/shop';
		$config['total_rows'] = $this->CartModel->count_shop();
		$config['per_page'] = $perPage;
		$config['first_link'] = '<li class="list-inline-item">First</li>';
		$config['full_tag_open'] = '<ul class="list-unstyled list-inline">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = true;
		$config['last_link'] = true;
		$config['first_tag_open'] = '<li class="list-inline-item">';
		$config['first_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="list-inline-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="list-inline-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active list-inline-item"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="list-inline-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['next_link'] = '&raquo';
		$config['use_page_numbers'] = true;
		$config['prev_tag_open'] = '<li class="list-inline-item">';
		$config['prev_tag_close'] = '</li>';
		$config["num_links"] = 15;
		$this->pagination->initialize($config);
		$this->pagination->cur_page = $offset;
		$data['pages'] = $this->pagination->create_links() . '</p>';
		$data['per_page']   = $config['per_page'];
		$data['offset']     = $offset;
		$data['shops'] = $this->CartModel->get_shops($sortShop, $data['offset'], $data['per_page']);
		// **************************************************************************

		$data['totalRows'] = $this->CartModel->count_shop();
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['page'] = $page;
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['title'] = "chbluxury.com.ng";
		$this->load->view('customer/' . $page, $data);
		$this->load->view('template/jsfunctions', $data);
	}

	function shop()
	{
		if (!file_exists(APPPATH . 'views/customer/shop.php')) {
			redirect(base_url() . '404');
		}
		$this->saveThisUrl(base_url() . 'Cart/shop');
		$sortShop = '';
		if (!$this->session->userdata('sortShop') || $this->session->userdata('sortShop') == "") {
			$sortShop = 'product_name';
		} else {
			$sortShop = $this->session->userdata('sortShop');
		}


		$perPage = '';
		if (!$this->session->userdata('perPage') || $this->session->userdata('perPage') == "") {
			$perPage = 24;
		} else {
			$perPage = $this->session->userdata('perPage');
		}
		$config = array();
		$offset = $this->uri->segment(3);
		$config['base_url'] = base_url() . 'Cart/shop';
		$config['total_rows'] = $this->CartModel->countShopFilter();
		$config['per_page'] = $perPage;
		$config['first_link'] = '<li class="list-inline-item">First</li>';
		$config['full_tag_open'] = '<ul class="list-unstyled list-inline">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = true;
		$config['last_link'] = true;
		$config['first_tag_open'] = '<li class="list-inline-item">';
		$config['first_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="list-inline-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="list-inline-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active list-inline-item"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="list-inline-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['next_link'] = '&raquo';
		$config['use_page_numbers'] = true;
		$config['prev_tag_open'] = '<li class="list-inline-item">';
		$config['prev_tag_close'] = '</li>';
		$config["num_links"] = 15;
		$this->pagination->initialize($config);
		$this->pagination->cur_page = $offset;
		$data['pages'] = $this->pagination->create_links() . '</p>';
		$data['per_page']   = $config['per_page'];
		$data['offset']     = $offset;
		$data['shops'] = $this->CartModel->shopFilter($sortShop, $data['offset'], $data['per_page']);
		// **************************************************************************

		$flags = '';
		if (!empty($this->input->post('brand'))) {
			foreach ($this->input->post('brand') as $value) {
				$flags .= $value['brand'] . ',';
			}
		}

		$filterShopAmount = str_replace('₦', '', $this->input->post('filterShopAmount'));
		$amount = explode('-', $filterShopAmount);
		$filter1 = str_replace(' ', '', $amount[0]);
		$filter2 = str_replace(' ', '', $amount[1]);

		$data['totalRows'] = $this->CartModel->count_shop();
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['page'] = 'shop';
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['title'] = "chbluxury.com.ng || Filter: " . $filter1 . ' - ' . $filter2 . ', ' . $flags;
		$this->load->view('customer/shop', $data);
		$this->load->view('template/jsfunctions', $data);
	}

	function product($id)
	{
		if (!file_exists(APPPATH . 'views/customer/single_product.php')) {
			redirect(base_url() . '404');
		}

		$this->saveThisUrl(base_url() . 'Cart/product/' . $id);
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['page'] = 'single_product';
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['product'] = $this->CartModel->get_product($id);
		$data['similar'] = $this->CartModel->get_similar_products($id);
		$data['title'] = $data['product']['product_name'];
		$this->load->view('customer/single_product', $data);
		$this->load->view('template/jsfunctions', $data);
	}

	function brand($brand)
	{
		if (!file_exists(APPPATH . 'views/customer/brand.php')) {
			redirect(base_url() . '404');
		}
		$this->saveThisUrl(base_url() . 'Cart/brand/' . $brand);
		$sortShop = '';
		if (!$this->session->userdata('sortShop') || $this->session->userdata('sortShop') == "") {
			$sortShop = 'product_name';
		} else {
			$sortShop = $this->session->userdata('sortShop');
		}


		$perPage = '';
		if (!$this->session->userdata('perPage') || $this->session->userdata('perPage') == "") {
			$perPage = '24';
		} else {
			$perPage = $this->session->userdata('perPage');
		}
		$config = array();
		$offset = $this->uri->segment(4);
		$config['base_url'] = base_url() . 'Cart/brand/' . $brand;
		$config['total_rows'] = $this->CartModel->count_brand($brand);
		$config['per_page'] = $perPage;
		$config['first_link'] = '<li class="list-inline-item">First</li>';
		$config['full_tag_open'] = '<ul class="list-unstyled list-inline">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="list-inline-item">';
		$config['first_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="list-inline-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="list-inline-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active list-inline-item"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="list-inline-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['next_link'] = '&raquo';
		$config['use_page_numbers'] = FALSE;
		$config['prev_tag_open'] = '<li class="list-inline-item">';
		$config['prev_tag_close'] = '</li>';
		$config["num_links"] = 15;
		$this->pagination->initialize($config);
		$this->pagination->cur_page = $offset;
		$data['pages'] = $this->pagination->create_links() . '</p>';
		$data['per_page']   = $config['per_page'];
		$data['offset']     = $offset;
		$data['shops'] = $this->CartModel->get_brands($brand, $data['offset'], $data['per_page'], $sortShop);
		// **************************************************************************

		$data['totalRows'] = $this->CartModel->count_shop();
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['page'] = 'brand';
		$data['brand'] = $brand;
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['title'] = 'CHBLUXURY || Brand || ' . $brand;
		$this->load->view('customer/brand', $data);
		$this->load->view('template/jsfunctions', $data);
	}


	function ct($category)
	{
		if (!file_exists(APPPATH . 'views/customer/category.php')) {
			redirect(base_url() . '404');
		}
		$this->saveThisUrl(base_url() . 'Cart/ct/' . $category);

		$sortShop = '';
		if (!$this->session->userdata('sortShop') || $this->session->userdata('sortShop') == "") {
			$sortShop = 'product_name';
		} else {
			$sortShop = $this->session->userdata('sortShop');
		}


		$perPage = '';
		if (!$this->session->userdata('perPage') || $this->session->userdata('perPage') == "") {
			$perPage = '24';
		} else {
			$perPage = $this->session->userdata('perPage');
		}
		$config = array();
		$offset = $this->uri->segment(4);
		$config['base_url'] = base_url() . 'Cart/ct/' . $category;
		$config['total_rows'] = $this->CartModel->count_category($category);
		$config['per_page'] = $perPage;
		$config['first_link'] = '<li class="list-inline-item">First</li>';
		$config['full_tag_open'] = '<ul class="list-unstyled list-inline">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="list-inline-item">';
		$config['first_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="list-inline-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="list-inline-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active list-inline-item"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="list-inline-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['next_link'] = '&raquo';
		$config['use_page_numbers'] = FALSE;
		$config['prev_tag_open'] = '<li class="list-inline-item">';
		$config['prev_tag_close'] = '</li>';
		$config["num_links"] = 15;
		$this->pagination->initialize($config);
		$this->pagination->cur_page = $offset;
		$data['pages'] = $this->pagination->create_links() . '</p>';
		$data['per_page']   = $config['per_page'];
		$data['offset']     = $offset;
		$data['shops'] = $this->CartModel->get_category($category, $data['offset'], $data['per_page'], $sortShop);
		// **************************************************************************

		$data['totalRows'] = $this->CartModel->count_shop();
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['page'] = 'brand';
		$data['category'] = $category;
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['title'] = 'CHBLUXURY || Category || ' . $category;
		$this->load->view('customer/category', $data);
		$this->load->view('template/jsfunctions', $data);
	}


	function invoice($reference)
	{
		if (!file_exists(APPPATH . 'views/customer/invoice.php')) {
			redirect(base_url() . '404');
		}

		$data['invoice'] = $this->CartModel->getInvoice($reference);
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['page'] = 'invoice';
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['title'] = 'CHBLUXURY || INVOICE || ' . $data['invoice']['reference'];
		$this->load->view('customer/invoice', $data);
		$this->load->view('template/jsfunctions', $data);
	}

	function changeEmail()
	{
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['page'] = 'change_email';
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['title'] = 'Update Email Address';
		$this->load->view('customer/change_email', $data);
		$this->load->view('template/jsfunctions', $data);
	}

	function requestToken()
	{
		if ($this->CartModel->sendOtp()) {
			$this->session->set_flashdata('alert_success', 'A token has been sent to your existing email address.');
			redirect(base_url() . 'cart/changeEmail');
		} else {
			$this->session->set_flashdata('alert_danger', 'We could not send OTP. <a href="' . base_url() . 'cart/requestToken">click here to request new token</a>');
			redirect(base_url() . 'cart/changeEmail');
		}
	}


	function find()
	{
		if (!file_exists(APPPATH . 'views/customer/find.php')) {
			redirect(base_url() . '404');
		}
		$config['base_url'] = base_url() . 'Cart/find';
		$sortShop = '';
		if (!$this->session->userdata('sortShop') || $this->session->userdata('sortShop') == "") {
			$sortShop = 'product_name';
		} else {
			$sortShop = $this->session->userdata('sortShop');
		}


		$perPage = '';
		if (!$this->session->userdata('perPage') || $this->session->userdata('perPage') == "") {
			$perPage = '24';
		} else {
			$perPage = $this->session->userdata('perPage');
		}
		$config = array();
		$offset = $this->uri->segment(3);
		$config['base_url'] = base_url() . 'Cart/find';
		$config['total_rows'] = $this->CartModel->count_find();
		$config['per_page'] = $perPage;
		$config['first_link'] = '<li class="list-inline-item">First</li>';
		$config['full_tag_open'] = '<ul class="list-unstyled list-inline">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="list-inline-item">';
		$config['first_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li class="list-inline-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="list-inline-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active list-inline-item"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="list-inline-item">';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['next_link'] = '&raquo';
		$config['use_page_numbers'] = FALSE;
		$config['prev_tag_open'] = '<li class="list-inline-item">';
		$config['prev_tag_close'] = '</li>';
		$config["num_links"] = 15;
		$this->pagination->initialize($config);
		$this->pagination->cur_page = $offset;
		$data['pages'] = $this->pagination->create_links() . '</p>';
		$data['per_page']   = $config['per_page'];
		$data['offset']     = $offset;
		$data['shops'] = $this->CartModel->get_find($data['offset'], $data['per_page'], $sortShop);
		// **************************************************************************

		$data['totalRows'] = $this->CartModel->count_shop();
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['page'] = 'brand';
		$data['find'] = $this->input->post('search_bar');
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['title'] = 'CHBLUXURY || Search || ' . $this->input->post('search_bar');
		$this->load->view('customer/find', $data);
		$this->load->view('template/jsfunctions', $data);
	}


	function ajaxFind()
	{
		if ($data = $this->CartModel->ajaxFind()) {
			echo json_encode($data);
		}
	} 

	function compare($id)
	{
		if (!file_exists(APPPATH . 'views/customer/compare.php')) {
			redirect(base_url() . '404');
		}
		$config['base_url'] = base_url() . 'Cart/compare/' . $id;
		$data['brands'] = $this->CartModel->getBrands();
		$data['user'] = $this->CartModel->getUser();
		$data['admin_url'] = $this->db->get('chb_settings')->row_array()['site_admin_url'];
		$data['chat_url'] = 'https://chat.chbluxury.com.ng/';
		$data['home_categories'] = $this->CartModel->home_categories();
		$data['page'] = 'compare';
		$data['wishlist'] = $this->CartModel->getUserWishlist();
		$data['cartList'] = $this->CartModel->getUserCarList();
		$data['cartSum'] = $this->CartModel->sumUserCarList();
		$data['product'] = $this->CartModel->get_product($id);
		$data['compare'] = $this->CartModel->compare_product($id);
		$data['title'] = 'Compare ' . $data['product']['product_name'];
		$this->load->view('customer/compare', $data);
		$this->load->view('template/jsfunctions', $data);
	}

	function addToWishlist()
	{
		if ($data = $this->CartModel->addToWishlist()) {
			echo json_encode($data);
		}
	}

	function trashWish($id)
	{
		if ($data = $this->CartModel->trashWish($id)) {
			$this->goBack();
		}
	}

	function countUserWishlist()
	{
		if ($data = $this->CartModel->countUserWishlist()) {
			echo json_encode($data);
		}
	}

	function addToCart()
	{
		if ($data = $this->CartModel->addToCart()) {
			echo json_encode($data);
		}
	}
	function countUserCart()
	{
		if ($data = $this->CartModel->countUserCart()) {
			echo json_encode($data);
		}
	}

	function trashCart($id)
	{
		if ($this->CartModel->trashCart($id)) {
			$this->goBack();
		}
	}

	function updateCart()
	{
		if ($data = $this->CartModel->updateCart()) {
			echo json_encode($data);
		}
	}

	function calculateTotalAmount()
	{
		if ($data = $this->CartModel->calculateTotalAmount()) {
			echo json_encode($data);
		}
	}

	function creditWallet()
	{
		$this->load->model('PaymentModel');
		if ($data = $this->PaymentModel->creditWallet()) {
			echo json_encode($data);
		}
	}

	function createWallet()
	{
		if ($data = $this->CartModel->createWallet()) {
			$this->goBack();
		}
	}

	function track_order()
	{
		if ($data = $this->CartModel->track_order()) {
			redirect(base_url().'track-order');
		} else {
			$this->goBack();
		}
	}

	function TrashOrder($ref)
	{
		if ($data = $this->CartModel->TrashOrder($ref)) {
			redirect(base_url() . 'order_history');
		} else {
			$this->goBack();
		}
	}

	function shippingEstimate()
	{
		if ($data = $this->CartModel->shippingEstimate()) {
			echo json_encode($data);
		}
	}

	function applyCoupon()
	{
		if ($data = $this->CartModel->applyCoupon()) {
			echo json_encode($data);
		}
	}

	function placeOrder()
	{
		$this->load->model('PaymentModel');
		if ($data = $this->PaymentModel->placeOrder()) {
			echo json_encode($data);
		}
	}

	function calculateWeight()
	{
		if ($data = $this->CartModel->calculateWeight()) {
			echo json_encode($data);
		}
	}


	function productRating()
	{
		if ($data = $this->CartModel->productRating()) {
			echo json_encode($data);
		}
	}


	function newUserReview()
	{
		if ($data = $this->CartModel->newUserReview()) {
			echo json_encode($data);
		}
	}



	function saveOrder()
	{
		$this->load->model('PaymentModel');
		if ($data = $this->PaymentModel->saveOrder()) {
			echo json_encode($data);
		}
	}

	function checkReference()
	{
		$this->load->model('PaymentModel');
		if ($data = $this->PaymentModel->checkReference()) {
			echo json_encode($data);
		}
	}

	function placeOrder2_0()
	{
		$this->load->model('PaymentModel');
		if ($data = $this->PaymentModel->placeOrder2_0()) {
			echo json_encode($data);
		}
	}









	function goBack()
	{
?>
		<script>
			window.history.back();
		</script>
<?php
	}
}
