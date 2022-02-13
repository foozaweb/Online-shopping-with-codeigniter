<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>
<?php
$set = $this->db->get('chb_settings')->row_array();
?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Checkout -->
<section class="checkout mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <form action="#">
                    <h5>Billing Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>First Name*</label>
                            <input type="text" name="name" readonly value="<?php echo $user['firstname'] ?>" placeholder="Your first name">
                        </div>
                        <div class="col-md-6">
                            <label>Last Name*</label>
                            <input type="text" class="validate" name="name" readonly value="<?php echo $user['lastname'] ?>" placeholder="Your last name">
                        </div>
                        <div class="col-md-6">
                            <label>Email Address*</label>
                            <input type="text" class="validate" name="checkout_email" readonly value="<?php echo $user['email'] ?>" placeholder="Your email address">
                        </div>
                        <div class="col-md-6">
                            <label>Phone*</label>
                            <input type="text" class="validate" name="checkout_phone" readonly value="<?php echo $user['phone'] ?>" placeholder="Your phone number">
                        </div>
                        <div class="col-md-12">
                            <label>Company Name</label>
                            <input type="text" name="companyName" value="" placeholder="Your company name (optional)">
                        </div>
                        <div class="col-md-12">
                            <label>Address*</label>
                            <input type="text" class="validate" name="deliveryAddress" value="" placeholder="Address line 1">
                        </div>
                        <div class="col-md-6 contry">
                            <label>Country*</label>
                            <select class="checkoutCountry validate" id="country-code" name="shippingCountry">
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>State/Province*</label>
                            <span id="state-code" class="contry"><input class="input" class="validate" name="shippingState" type="text" id="state"></span>
                        </div>

                        <div class="col-md-6">
                            <label>Town/City*</label>
                            <input type="text" class="validate" name="deliveryCity" value="" placeholder="Your town or city name">
                        </div>

                        <div class="col-md-6">
                            <label>Postal/Zip Code</label>
                            <input type="text" name="postalCode" value="" placeholder="Your postal or zip code">
                        </div>
                        <div class="col-md-12">
                            <label>Order Note</label>
                            <textarea name="orderNote" placeholder="Note for your order (optional). Example- special notes for delivery"></textarea>
                        </div>

                    </div>
                </form>
            </div>


            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="order-review">
                            <h5>Order Review</h5>
                            <div class="review-box">
                                <ul class="list-unstyled">
                                    <li>Product <span>Total</span></li>

                                    <?php if ($cartList) { ?>

                                        <?php
                                        $index = 0;
                                        foreach ($cartList as $cart) {
                                            $index++; ?>
                                            <li class="d-flex justify-content-between">
                                                <div class="pro">
                                                    <a href="<?php echo base_url() . 'product/' . $cart['productId'] ?>"><img src="<?php echo $admin_url ?>/assets/images/<?php echo $cart['main_photo'] ?>" alt=""></a>
                                                    <p><a href="<?php echo base_url() . 'product/' . $cart['productId'] ?>"><?php echo $cart['product_name'] ?></a></p>
                                                    <span><?php echo $cart['cart_quantity'] ?> X <?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cart[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')) . '.00'; ?>
                                                        <?php
                                                        if ($cart['discount'] > 0) {
                                                            echo ' <a href="#" class="cartExpand" title="' . $cart['discount'] . '% Discount Applied" data-placement="top" data-toggle="tooltip">(-' . $cart['discount'] . '%)</a>';
                                                        } ?></span>
                                                </div>
                                                <div class="prc">
                                                    <p><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cart['cart_amount']/$this->session->userdata('ex_rate')); ?>.00</p>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <hr>


                                        <input type="hidden" class="checkoutSubtotalInput" name="checkoutSubtotalInput" value="<?php echo $cartSum['cart_amount'] ?>">
                                        <input type="hidden" value="0" class="checkoutCartWeightInput" name="checkoutCartWeightInput">
                                        <input type="hidden" value="0" class="checkoutGrandTotalInput" name="checkoutGrandTotalInput">
                                        <input type="hidden" value="0" class="checkoutShippingFeeInput" name="checkoutShippingFeeInput">
                                        <input type="hidden" value="0" class="checkoutCouponInput" name="checkoutCouponInput">
                                        <input type="hidden" value="<?php echo $set['vat'] / 100 * $cartSum['cart_amount']; ?>" class="VatFee" name="VatFee">

                                        <li class="summaryClass">Subtotal <span class="checkoutSubTotalHtml"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cartSum['cart_amount']/$this->session->userdata('ex_rate')); ?>.00</span></li>
                                        <li class="summaryClass" data-toggle="tooltip" data-placement="left" title="<?php echo $set['vat'] ?>% Value Added Tax Applied">VAT- <span class="vatFeeHtml"><?php echo $this->session->userdata('ex_symbol') ?><?php echo $set['vat'] / 100 * $cartSum['cart_amount']/$this->session->userdata('ex_rate')?>.00 </span></li>
                                        <li class="summaryClass" data-toggle="tooltip" data-placement="left" title="Total Weight of each Items with * quantity">Total Weight <span class="checkoutCartWeightHtml">0Kg.</span></li>
                                        <li class="summaryClass">Shipping <span class="checkoutShippingFeeHtml"><?php echo $this->session->userdata('ex_symbol') ?>00.00</span></li>
                                        <li class="summaryClass viewCoupon no-display">Coupon Applied<span class="checkoutCouponSize">00</span></li>
                                        <li>Grand Total <span class="checkoutGrandTotalHtml"><?php echo $this->session->userdata('ex_symbol') ?>00.00</span></li>

                                    <?php } else { ?>
                                        <center class="mb-5 mt-5">
                                            <h1 class="card">
                                                <div class="card-body">
                                                    <small>You have No Item on your Cart.</small> <br><u><a href="<?php echo base_url() ?>shop"><i class="fa fa-hand-o-right"></i> click to Start Shopping <i class="fa fa-hand-o-left"></i></u></a>
                                                </div>
                                            </h1>
                                        </center>
                                    <?php } ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?php if ($this->session->flashdata('alert_success')) :
                            echo '<p class="alert alert-success" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_success') . '</p>'; ?>
                        <?php endif; ?>

                        <?php if ($this->session->flashdata('alert_danger')) :
                            echo '<p class="alert alert-danger" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_danger') . '</p>'; ?>
                        <?php endif; ?>

                        <div class="pay-meth">
                            <h5>Payment Method</h5>
                            <div class="pay-box">
                                <ul class="list-unstyled">
                                    <li>
                                        <?php
                                        $vat = $set['vat'] / 100 * $cartSum['cart_amount'];
                                        $totalPay = intval($cartSum['cart_amount']) + intval($vat);
                                        $wResult = $this->db->get_where('chb_wallet', array('customer_id' => $user['customer_id']));

                                        if ($wResult->num_rows() < 1) {
                                            echo '<input type="radio" id="walletPay" name="payment" value="walletPay" disabled>
                                        <label for="walletPay"><span><i class="fa fa-google-wallet"></i></span>Pay with Wallet</label> <span><a href="' . base_url() . 'cart/createWallet" class="cartExpand"> <i class="fa fa-google-wallet"></i>Create Wallet</a></span>';
                                        }

                                        if ($wResult->num_rows() > 0 && intval($user['wallet_balance']) < intval($totalPay)) {
                                            echo '<input type="radio" id="walletPay" name="payment" value="walletPay" disabled>
                                        <label for="walletPay"><span><i class="fa fa-google-wallet"></i></span>Pay with Wallet</label> <span><a href="javascript:void(0);" class="fundWallet cartExpand" title="'.$this->session->userdata('ex_symbol').'' . number_format($user['wallet_balance']/$this->session->userdata('ex_rate')) . '.00" data-toggle="tooltip" data-placement="right">  <i class="fa fa-plus"></i>Fund Wallet</a></span>';
                                        }
                                        if ($wResult->num_rows() > 0 && intval($user['wallet_balance']) >= intval($totalPay)) {
                                            echo '<input type="radio" id="walletPay" name="payment" value="walletPay" >
                                        <label for="walletPay" title="'.$this->session->userdata('ex_symbol') .'' . number_format($user['wallet_balance']/$this->session->userdata('ex_rate')) . '.00"><span><i class="fa fa-google-wallet"></i></span>Pay with Wallet</label></span>';
                                        }
                                        ?>
                                    </li>
                                    <li>
                                        <input type="radio" id="cardPay" name="payment" value="cardPay">
                                        <label for="cardPay"><span><i class="fa fa-credit-card"></i></span>Pay with Card</label>
                                    </li>

                                    <li><span class="chkInputWrapper"><input class="regular-checkbox" type="checkbox" id="termsShipping" name="terms"></span> <label for="termsShipping"> I Agree to <?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?><a href="<?php echo base_url() ?>terms-condition" class="cartExpand" target="_blank"> Terms of service</a></label></li>
                                    <li><span class="chkInputWrapper"><input checked class="regular-checkbox" type="checkbox" id="saveAddress" value="yes" name="saveAddress"></span> <label for="saveAddress"> Save Address to use for later times</label></li>
                                </ul>
                            </div>
                        </div>
                        <button type="button" name="button" class="ord-btn processOrderBtn"><i class="fa fa-reorder"></i> Place Order</button>
                        <button type="button" name="button" class="ord-btn beginPaymentBtn no-display">Pay Now</button>
                        <br><br>
                        <a href="javascript:void(0);" onclick="$('.processOrderBtn').html('Update Order'); $('.processOrderBtn').show(); $('.beginPaymentBtn').hide(); $(this).hide(); " class="updateOrderBtn no-display">
                            <h6 class="text-center">Or Update this Order</h6>
                        </a>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->load->view('template/footer') ?>
<?php $this->load->view('template/payJs') ?>
<script src="<?php echo base_url() ?>js/country-states.js"></script>
<script>
    let user_country_code = "NG";

    (function() {
        let country_list = country_and_states['country'];
        let states_list = country_and_states['states'];

        let option = '';
        option += '<option>select country</option>';
        for (let country_code in country_list) {
            // set selected option user country
            let selected = (country_code == user_country_code) ? ' selected' : '';
            option += '<option value="' + country_code + '"' + selected + '>' + country_list[country_code] + '</option>';
        }
        document.getElementById('country-code').innerHTML = option;

        // creating states name drop-down
        let text_box = '<input type="text" placeholder="Enter State" class="input-text chb-form-control" id="state" name="state">';
        let state_code_id = document.getElementById("state-code");

        function create_states_dropdown() {
            // get selected country code
            let country_code = document.getElementById("country-code").value;
            let states = states_list[country_code];
            // invalid country code or no states add textbox
            if (!states) {
                state_code_id.innerHTML = text_box;
                return;
            }
            let option = '';
            if (states.length > 0) {
                option = '<select id="state" name="shippingState" class="validate">\n';
                for (let i = 0; i < states.length; i++) {
                    option += '<option value="' + states[i].name + '">' + states[i].name + '</option>';
                }
                option += '</select>';
            } else {
                // create input textbox if no states 
                option = text_box
            }
            state_code_id.innerHTML = option;
        }

        // country select change event
        const country_select = document.getElementById("country-code");
        country_select.addEventListener('change', create_states_dropdown);

        create_states_dropdown();
    })();
</script>
<!-- End Checkout -->