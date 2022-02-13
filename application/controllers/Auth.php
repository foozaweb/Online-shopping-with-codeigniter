<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Africa/Lagos');
        $this->load->model('AuthModel');
    }


    function vE($id)
    {
        if ($this->AuthModel->vE($id)) {
            $this->session->set_flashdata('alert_success', 'Thank you! Your Email has been successfully verified.');
            redirect(base_url() . 'login');
        }
    }

    public function clearSession()
    {
        if ($this->AuthModel->thereIsAnActivity("Logged Out")) {
            $data['otp']   = $this->session->userdata('otp');
            $data['chbCusId']   = $this->session->userdata('chbCusId');
            $data['chbCusEmail']   = $this->session->userdata('chbCusEmail');
            $data['chbUserAuth']   = $this->session->userdata('chbUserAuth');
            if ($data['chbAuth'] == TRUE) {
                $array_items = array('chbCusId', 'chbCusEmail', 'chbUserAuth', 'otp');
                $this->session->unset_userdata($array_items);
                redirect(base_url());
            } else {
                session_destroy();
                redirect(base_url());
            }
        }
    }

    function cA()
    {
        $fname = $this->security->sanitize_filename($this->input->post('fname'));
        $lname = $this->security->sanitize_filename($this->input->post('lname'));
        $email = $this->security->sanitize_filename($this->input->post('email'));
        $phone = $this->security->sanitize_filename($this->input->post('phone'));
        $ns = $this->security->sanitize_filename($this->input->post('c-box'));
        $password = $this->security->sanitize_filename(md5($this->input->post('password')));
        if ($this->AuthModel->cA($fname, $lname, $email, $phone, $password, $ns)) {
            redirect(base_url() . 'login?AccountStatus=1|EmailStatus=0|user=' . $fname . ' ' . $lname);
        } else {
            redirect(base_url() . 'register');
        }
    }


    function access()
    {
        $loginId = $this->security->sanitize_filename($this->input->post('loginId'));
        $password = $this->security->sanitize_filename($this->input->post('password'));
        if ($this->AuthModel->access($loginId, $password)) {
            redirect(base_url() . '?LoginStatus=1');
        } else {
            redirect(base_url() . 'login?LoginFailed');
        }
    }

    function updateEmail()
    {
        $email = $this->security->sanitize_filename($this->input->post('email'));
        $token = $this->security->sanitize_filename($this->input->post('token'));
        if ($this->AuthModel->updateEmail($email, $token)) {
            $this->session->set_flashdata('alert_success', 'Your Email address has been successfully changed.');
            redirect(base_url() . 'auth/clearSession');
        } else {
            redirect(base_url() . 'cart/changeEmail');
        }
    }






    public function PhotoUpload()
    {
        if ($_FILES["profile_photo"]["name"] != '') {
            $output = '';
            $config["upload_path"] = 'assets/profile_photo';
            $config["allowed_types"] = '*';
            $config["overwrite"] = TRUE;
            $config["detect_mime"] = TRUE;
            $config["mod_mime_fix"] = TRUE;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            for ($count = 0; $count < count($_FILES["profile_photo"]["name"]); $count++) {
                $_FILES["file"]["name"] = $_FILES["profile_photo"]["name"][$count];
                $_FILES["file"]["type"] = $_FILES["profile_photo"]["type"][$count];
                $_FILES["file"]["tmp_name"] = $_FILES["profile_photo"]["tmp_name"][$count];
                $_FILES["file"]["error"] = $_FILES["profile_photo"]["error"][$count];
                $_FILES["file"]["size"] = $_FILES["profile_photo"]["size"][$count];
                if ($this->upload->do_upload('file')) {
                    $data = $this->upload->data();
                    $output .= $data['file_name'];
                    $this->AuthModel->PhotoUpload($output);
                }
            }
            echo $output;
        } else {
            return false;
        }
    }

    public function new_password()
    {
        if ($data = $this->AuthModel->new_password()) {
            echo json_encode($data);
        }
    }

    function profile()
    {
        $this->AuthModel->profile();
    }

    function otp()
    {
        if ($data = $this->AuthModel->otp()) {
            echo json_encode($data);
        }
    }


    function change_password()
    {
        if ($this->AuthModel->change_password()) {
            redirect(base_url() . 'login');
        } else {
            redirect(base_url() . 'forgot_password');
        }
    }


    function category($cat)
    {
        $site_admin_url = $this->db->get('chb_settings')->row_array()['site_admin_url'];
        $this->load->model('CartModel');
        $current = explode('_', $cat)[0];
        $category = explode('_', $cat)[1];
        $data['totalRows'] = $this->CartModel->count_shop();
        $data['brands'] = $this->CartModel->getBrands();
        $data['user'] = $this->CartModel->getUser();
        $data['admin_url'] = $site_admin_url;
        $data['chat_url'] = 'https://chat.chbluxury.com.ng/';
        $data['page'] = 'shop';
        $data['wishlist'] = $this->CartModel->getUserWishlist();
        $data['cartList'] = $this->CartModel->getUserCarList();
        $data['cartSum'] = $this->CartModel->sumUserCarList();
        $data['home_categories'] = $this->CartModel->home_categories();
        $data['title'] = "CHBLUXURY.COM || " . $current . ' || ' . $category;
        $data['target'] = $category;
        $data['current'] = $current;
        $this->load->view('customer/cats2', $data);
        $this->load->view('template/jsfunctions', $data);
    }


    function wCats($cat)
    {
        $site_admin_url = $this->db->get('chb_settings')->row_array()['site_admin_url'];
        $this->load->model('CartModel');
        $current = explode('_', $cat)[0];
        $category = explode('_', $cat)[1];
        $data['totalRows'] = $this->CartModel->count_shop();
        $data['brands'] = $this->CartModel->getBrands();
        $data['user'] = $this->CartModel->getUser();
        $data['admin_url'] = $site_admin_url;
        $data['chat_url'] = 'https://chat.chbluxury.com.ng/';
        $data['page'] = 'shop';
        $data['wishlist'] = $this->CartModel->getUserWishlist();
        $data['cartList'] = $this->CartModel->getUserCarList();
        $data['cartSum'] = $this->CartModel->sumUserCarList();
        $data['home_categories'] = $this->CartModel->home_categories();
        $data['title'] = "CHBLUXURY.COM || " . $current . ' || ' . $category;
        $data['target'] = $category;
        $data['current'] = $current;
        $this->load->view('wholesale/cats2', $data);
    }



    function verifyPayment()
    {
        $ref = $this->input->post('reference');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $ref,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $this->db->get('chb_settings')->row_array()['public_key'] . "",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response, true);
            if ($result['data']['status'] == 'success') {
                echo json_encode($result['data']['status']);
            } else {
                return false;
            }
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
