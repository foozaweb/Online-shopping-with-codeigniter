<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>


<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Shopping Cart -->
<section class="shopping-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <div class="cart-table table-responsive myOrderSettings">
                    <?php if ($cartList) { ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="t-pro">Product</th>
                                    <th class="t-price">Price</th>
                                    <th class="t-qty">Quantity</th>
                                    <th class="t-total">Total</th>
                                    <th class="t-rem"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0;
                                foreach ($cartList as $cart) {
                                    $index++; ?>
                                    <tr class="cartRows">
                                        <td class="t-pro d-flex">
                                            <div class="t-img">
                                                <a href="<?php echo base_url() . 'product/' . $cart['productId'] ?>"><img src="<?php echo $admin_url ?>/assets/images/<?php echo $cart['main_photo'] ?>" alt=""></a>
                                            </div>
                                            <div class="t-content">
                                                <p class="t-heading"><a href="<?php echo base_url() . 'product/' . $cart['productId'] ?>"><?php echo $cart['product_name'] ?></a>
                                                    <?php if ($cart['type'] == "Pre-Order") {
                                                        echo '<span class="text-warning">-Pre Order</span>';
                                                    } ?>
                                                </p>
                                                <ul class="list-unstyled list-inline rate">
                                                    <?php
                                                    viewRating($cart['rating']);
                                                    ?>
                                                </ul>
                                                <ul class="list-unstyled col-sz">
                                                    <li>
                                                        <p class="flex-display mr-3">Color :
                                                            <?php
                                                            $tags = explode(',', $cart['color']);
                                                            for ($i = 0; $i < count($tags); $i++) {
                                                            ?>
                                                                <label class="wColorWrapper2 ml-2" style="background-color: <?php echo str_replace(' ', '', $tags[$i]); ?>;">
                                                                    <input type="checkbox" name="selectedColor<?php echo $index; ?>" class="regular-checkbox" value="<?php echo str_replace(' ', '', $tags[$i]); ?>">
                                                                </label>
                                                            <?php } ?>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p class="flex-display mr-3">Size:
                                                            <?php
                                                            $tags = explode(',', $cart['product_size']);
                                                            for ($i = 0; $i < count($tags); $i++) {
                                                            ?>
                                                                <label class="wColorWrapper2 ml-2">
                                                                    <?php echo str_replace(' ', '', $tags[$i]); ?>
                                                                    <input class="regular-checkbox" type="checkbox" name="selectedSize<?php echo $index; ?>" name="color" value="<?php echo str_replace(' ', '', $tags[$i]); ?>">
                                                                </label>

                                                            <?php } ?>
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <input type="hidden" value="<?php echo $cart['productId'] ?>" name="productID<?php echo $index; ?>">
                                        </td>
                                        <td class="t-price">
                                            <div class="flex-display pr-2">
                                                <?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cart[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')) . '.00';
                                                    if ($cart['discount'] > 0) {
                                                        echo ' <a href="#" class="cartExpand mr-3" title="' . $cart['discount'] . '% Discount Applied" data-placement="top" data-toggle="tooltip">(-' . $cart['discount'] . '%)</a>';
                                                    }
                                                    ?>
                                            </div>
                                        </td>
                                        <td class="t-qty">
                                            <div class="qty-box">
                                                <div class="quantity buttons_added ml-2">
                                                    <input type="button" value="-" class="minus">

                                                    <?php
                                                    if (!$cart['cart_quantity']) { ?>
                                                        <input type="number" step="1" min="1" max="<?php echo $cart['quantity'] ?>" name="selectedQuantity<?php echo $index; ?>" value="1" class="qty text" size="4">
                                                        <input type="button" value="+" class="plus">
                                                    <?php } else { ?>
                                                        <input type="number" step="1" min="1" max="<?php echo $cart['quantity'] ?>" name="selectedQuantity<?php echo $index; ?>" value="<?php echo $cart['cart_quantity'] ?>" class="qty text" size="4">
                                                        <input type="button" value="+" class="plus">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </td>
                                        <?php
                                        if (!$cart['cart_quantity']) { ?>
                                            <td class="pr-2 t-total<?php echo $index; ?>"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cart[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</td>
                                        <?php } else { ?>
                                            <td class="pr-2 t-total<?php echo $index; ?>"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cart['cart_amount']/$this->session->userdata('ex_rate')); ?>.00</td>
                                        <?php } ?>
                                        <td class="t-rem"><a href="javascript:void(0)" class="clearCart pl-2" data-url="<?php echo base_url() ?>cart/trashCart/<?php echo $cart['productId'] ?>"><i class=" fa fa-trash-o"></i></a></td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    <?php } else { ?>
                        <center class="mb-5 mt-5">
                            <h1 class="card">
                                <div class="card-body">
                                    <small>You have No Item on your Cart.</small> <br><u><a href="<?php echo base_url() ?>cats"><i class="fa fa-hand-o-right"></i> click to Start Shopping <i class="fa fa-hand-o-left"></i></u></a>
                                </div>
                            </h1>
                        </center>
                    <?php } ?>
                </div>
            </div>


            <?php if ($cartList) { ?>
            <div class="col-md-4">
                <span class="chkInputWrapper"><input class="regular-checkbox" type="checkbox" id="pickup" name="pickup"> <label for="pickup" class=" pinkBg text-white pl-2 pt-2 pb-2 pr-2"> I want to pick up at store </label></span>
                <hr>

                <div class="shipping chbShipping">
                    <h6>Calculate Shipping and Tax</h6>
                    <p>Get our price estimate for shipping</p>
                    <form action="#">
                        <div class="country-box">
                            <select class="country" name="shippingCountry" id="country-code">
                                <option>Select Country</option>
                            </select>
                        </div>
                        <div class="state-box">
                            <div id="state-code"><input type="text" class="state" name="shippingState" id="state"></div>
                        </div>
                        <div class="post-box">
                            <input type="text" name="zip" value="" placeholder="Zip/Postal Code">
                            <div class="viewEstimate no-display text-center"></div>
                            <button type="button" class="getEstimate"><i class="fa fa-calculator"></i> Get Estimate</button>
                            <button type="button" class="applyShippingFee no-display"><i class="fa fa-ship"></i> Apply Fee</button>
                            <button type="button" class="resetShipping no-display"><i class="fa fa-fa-recycle"></i> Reset Shipping Settings</button>
                        </div>
                    </form>
                </div>
            </div>





            <div class="col-md-4">
                <div class="coupon couponDiv">
                    <h6>Discount Coupon</h6>
                    <p>Enter your coupon code if you have one</p>
                    <form action="#">
                        <input type="text" name="coupon_code" value="" placeholder="Your Coupon">
                        <button type="button" class="couponBtn">Apply Code</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="crt-sumry">
                    <h5>Cart Summary</h5>
                    <ul class="list-unstyled">
                        <input type="hidden" class="subtotalInput" value="<?php echo $cartSum['cart_amount'] ?>">
                        <input type="hidden" value="0" class="cartWeightInput">
                        <input type="hidden" value="0" class="GrandTotalInput">
                        <input type="hidden" value="0" class="shippingFeeInput">
                        <input type="hidden" value="0" class="couponInput">

                        <li>Subtotal <span class="subTotalHtml"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($cartSum['cart_amount']/$this->session->userdata('ex_rate')); ?>.00</span></li>
                        <li>Total Weight <span class="cartWeightHtml">0Kg.</span></li>
                        <li>Shipping <span class="shippingFeeHtml"><?php echo $this->session->userdata('ex_symbol') ?>00.00</span></li>
                        <li class="viewCoupon no-display">Coupon Applied<span class="couponSize">00</span></li>
                        <li>Grand Total <span class="GrandTotalHtml"><?php echo $this->session->userdata('ex_symbol') ?>00.00</span></li>
                    </ul>
                    <div class="cart-btns text-right">
                        <button type="button" class="up-cart">Update Cart</button>
                        <button type="button" class="chq-out no-display" data-placement="top" title="" data-toggle="tooltip" onclick="checkout()">Checkout</button>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</section>
<!-- End Shopping Cart -->





<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>
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







    // setTimeout(()=>{
    //  if (parseFloat(screen.width) > 767) {
    //          $('.myOrderSettings').addClass('t-qty');
    //          $('.cart-table').find($('.t-qty').fadeIn());
    //          $('.cart-table').find($('.plus').fadeIn());
    //          $('.cart-table').find($('.minus').fadeIn());
    //          $('.cart-table').find($('.qty').removeClass('form-control')); 
    //      } else {
    //          $('.myOrderSettings').removeClass('t-qty');
    //          // $('.cart-table').find($('.t-qty').fadeIn());
    //          $('.cart-table').find($('.plus').fadeOut());
    //          $('.cart-table').find($('.minus').fadeOut());
    //          $('.cart-table').find($('.qty').addClass('form-control'));
    //      }
    //  }, 2000);
</script>