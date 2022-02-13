<div class="messengerWrapper row"> </div>
<script src="https://js.paystack.co/v1/inline.js"></script>
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <div class="col-md-12 padding-fix-l20 max_h180">
                    <div class="new-product">
                        <div class="new-slider owl-carousel">
                            <?php
                            $this->db->limit('8');
                            $this->db->order_by('chb_products.id', 'random');
                            $this->db->group_by('chb_products.productId');
                            $this->db->where('chb_products.display', '1');
                            $result = $this->db->get('chb_products')->result_array();
                            foreach ($result as $res) {  ?>
                                <div class="new-item">
                                    <div class="tab-heading">
                                        <p><a href="<?php echo base_url() ?>product/<?php echo $res['productId'] ?>"><?php echo $res['product_name'] ?></a></p>
                                    </div>

                                    <div class="new-img">
                                        <a href="<?php echo base_url() ?>product/<?php echo $res['productId'] ?>"><img class="main-img img-fluid" src="<?php echo $admin_url ?>assets/images/<?php echo $res['main_photo'] ?>" alt=""></a>
                                    </div>
                                </div>
                            <?php }  ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <img class="img-responsive note-logo max_h50" src="<?php echo base_url() ?>images/logo.jpg">
                <strong> Have you seen this latest product? Stay updated.</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="acceptBtn">Ok!</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="walletModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body text-center">
                <label>
                    <h4><strong>Enter Amount in Naira (₦)</strong></h4>
                </label><br>
                <h6 class="text-danger lowBalanceInWallet"></h6><br>
                <div class="overflow_auto flex-display table-responsive mb-3">
                    <button type="button" class="fundWallet-btn" onclick="$('#walletAmount').val('5000')">₦5,000.00</button>
                    <button type="button" class="fundWallet-btn" onclick="$('#walletAmount').val('20000')">₦20,000.00</button>
                    <button type="button" class="fundWallet-btn" onclick="$('#walletAmount').val('50000')">₦50,000.00</button>
                    <button type="button" class="fundWallet-btn" onclick="$('#walletAmount').val('100000')">₦100,000.00</button>
                    <button type="button" class="fundWallet-btn" onclick="$('#walletAmount').val('500000')">₦500,000.00</button>
                    <button type="button" class="fundWallet-btn" onclick="$('#walletAmount').val('1000000')">₦1,000,000.00</button>
                </div>

                <input type="number" name="walletAmount" id="walletAmount" class="input" placeholder="Enter other Amount">
                <div class="modal-footer">
                    <button type="button" class="ord-btn" id="creditWalletBtn"><i class="fa fa-credit-card-alt"></i> Fund Wallet Now</button>
                </div>
            </div>

        </div>
    </div>
</div>







<div class="modal fade" id="waitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body text-center">
                <img src="<?php echo base_url() ?>images/loader.gif" style="max-height:65px;">
                <h5>Calculating Estimate</h5>
            </div>

        </div>
    </div>
</div>











<script>
    var selectedColor = '';
    var selectedSize = '';
    var selectedQuantity = '';
    var productID = '';
    var indexCount;













    calculateWeight();
    setTimeout(() => {
        if (getCookie('shipping') == 'true') {
            $('.chq-out').fadeIn();
        }
    }, 2000);

    setInterval(() => {
        calculateWeight();
    }, 3000);














    function calculateWeight() {
        $('.cartWeightInput').val('0');
        var cartRows = $('.cartRows').length;
        for (indexCount = 1; indexCount <= cartRows; indexCount++) {
            productID = $('.myOrderSettings [name="productID' + indexCount + '"]').val();
            // alertMe(productID, 6000);
            $.ajax({
                url: "<?php echo base_url() ?>cart/calculateWeight",
                type: "post",
                dataType: "json",
                data: {
                    productID: productID
                },
                success: function(data) {
                    var newWeight = parseInt($('.cartWeightInput').val()) + parseInt(data.cart_weight * data.cart_quantity);
                    $('.cartWeightInput').val(newWeight);
                    $('.cartWeightHtml').html(newWeight + 'Kg.');
                    setCookie('cartWeight', newWeight, 3);
                }
            });
        }
    }






















    $('.fundWallet').on('click', function() {
        $('.lowBalanceInWallet').html($(this).data('message'));
        $('#walletModal').modal('show');
    });















    var base_url = "<?php echo base_url() ?>";
    var session = "<?php echo $this->session->userdata('chbUserAuth'); ?>";
    $('.myOrderSettings').on('click', '.addToWishlist', function() {
        var id = $(this).data('id');
        if (session) {
            $.ajax({
                url: "<?php echo base_url() ?>cart/addToWishlist",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                },
                success: function(data) {
                    $('.ViewUserWishlist').html(data);
                    alertMe("Item Added to Wishlist", 4000);
                    $('body').load(window.location.href);
                },
                error: function(data) {
                    alertMe("Failed due to some unknown error! Please Try again", 8000);
                },
            });
        } else {
            alertMe("Please login to start a session", 8000);
        }
    });


















    $('.myOrderSettings').on('click', '.addToCart', function() {
        var singleQty = '1';
        var singleColor = '#fff';
        var singleSize = '';
        if ($('.list-inline .singleColor:checked').val()) {
            singleColor = $('.list-inline .singleColor:checked').val();
        }
        if ($('.singleQty').val()) {
            singleQty = $('.singleQty').val();
        }
        if ($('.list-inline .singleSize:checked').val()) {
            singleSize = $('.list-inline .singleSize:checked').val();
        }
        var id = $(this).data('id');
        if (session) {
            $.ajax({
                url: "<?php echo base_url() ?>cart/addToCart",
                type: "post",
                dataType: "json",
                data: {
                    id: id,
                    singleQty: singleQty,
                    singleColor: singleColor,
                    singleSize: singleSize,
                },
                success: function(data) {
                    $('.ViewUserCartList').html(data);
                    alertMe("Item Added to Cart", 4000);
                    $('body').load(window.location.href);
                    return false;
                },
                error: function(data) {
                    alertMe("Failed due to some unknown error. Please Try again", 8000);
                },
            });
        } else {
            alertMe("Please login to start a session", 8000);
        }
    });



















    if (session) {
        $(function() {
            $.ajax({
                url: "<?php echo base_url() ?>cart/countUserCart",
                type: "post",
                dataType: "json",
                data: {
                    "id": "id"
                },
                beforeSend: function() {
                    console.log("Updating Cart");
                },
                success: function(data) {
                    $('.ViewUserCartList').html(data);
                }
            });
            // ################################################
            $.ajax({
                url: "<?php echo base_url() ?>cart/countUserWishlist",
                type: "post",
                dataType: "json",
                data: {
                    "id": "id"
                },
                beforeSend: function() {
                    console.log("Updating Cart");
                },
                success: function(data) {
                    $('.ViewUserWishlist').html(data);
                }
            });
        });
    }















    $('.cart-body').on('click', '.clearCart', function() {
        if (confirm("Are you Sure")) {
            window.location.href = $(this).data('url');
        }
    })















    $('.myOrderSettings').on('click', '.clearCart', function() {
        if (confirm("Are you Sure")) {
            window.location.href = $(this).data('url');
        }
    });












    $('.myOrderSettings').on('click', '.clearWish', function() {
        if (confirm("Are you Sure")) {
            window.location.href = $(this).data('url');
        }
    });

















    var alertCount = 0;

    function alertMe(msg, timeout) {
        alertCount++;
        var html =
            '<div class="messenger" id="clearMessage' +
            alertCount +
            '">' +
            msg +
            '<a class="clearMessenger close" href="javascript:void(0);" name="clearMessage' +
            alertCount +
            '"><i class="fa fa-times"></i></a> </div>';
        $(".messengerWrapper").append(html);
        $(".messengerWrapper").fadeIn("fast");
        setTimeout(function() {
            _clear("clearMessage" + alertCount);
        }, timeout);
    }

    function _clear(id) {
        $(".messengerWrapper").find($("#" + id).fadeOut("fast"));
    }
    $("body").on("click", ".clearMessenger", function() {
        var obj = $(this).attr("name");
        $(".messengerWrapper").find($("#" + obj).fadeOut("fast"));
    });



























    $('.up-cart').on('click', function() {
        var cartRows = $('.cartRows').length;
        for (indexCount = 1; indexCount <= cartRows; indexCount++) {
            selectedColor = $('.myOrderSettings [name="selectedColor' + indexCount + '"]:checked').map(function() {
                return this.value
            }).get().join(",");

            selectedSize = $('.myOrderSettings [name="selectedSize' + indexCount + '"]:checked').map(function() {
                return this.value
            }).get().join(",");

            if (selectedColor == '' || selectedSize == '') {
                alertMe('Please Select Colors and Sizes to update Order', 6000);
                return false;
            }

            $('.myOrderSettings [name="selectedQuantity' + indexCount + '"]').each(function() {
                if ($(this).val() < 1) {
                    selectedQuantity = '1';
                    alertMe("Your order quantity has been set to 1", 5000);
                }
                if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
                    selectedQuantity = $(this).attr('max');
                    alertMe("We have " + $(this).attr('max') + " of this product. Your order quantity has been set to " + $(this).attr('max'), 5000);
                } else {
                    selectedQuantity = $(this).val();
                }
            });

            productID = $('.myOrderSettings [name="productID' + indexCount + '"]').val();

            $.ajax({
                url: "<?php echo base_url() ?>cart/updateCart",
                type: "post",
                dataType: "json",
                async: false,
                data: {
                    selectedColor: selectedColor,
                    selectedSize: selectedSize,
                    selectedQuantity: selectedQuantity,
                    productID: productID
                },
                success: function(data) {
                    $('.chq-out').show();
                    $('.chq-out').prop('disabled', false);
                    $('.myOrderSettings .t-total' + indexCount).html(formatMoney(parseInt(data.cart_amount) / <?php echo $this->session->userdata('ex_rate') ?>));
                    // clear Shipping cookie
                    deleteCookie('shippingFee');
                    deleteCookie('shipping');
                    $('.applyShippingFee').hide('slow');
                    $('.getEstimate').show('slow');
                    $('.resetShipping').hide('slow');
                    // ./clear Shipping cookie  
                    $('.up-cart').html('<i class="fa fa-check"></i> Update Cart');
                }
            });
            calculateTotalAmount();
            selectedColor = "";
            selectedSize = "";
            selectedQuantity = "";
            productID = "";
        }
    });















    calculateTotalAmount();
    var grandTotal = '';

    function calculateTotalAmount() {
        if (getCookie('cartWeight') != "" && getCookie('shipping') == "true") {
            $('.chq-out').prop('disabled', false);
            $('.chq-out').attr('title', "");
        }
        $.ajax({
            url: "<?php echo base_url() ?>cart/calculateTotalAmount",
            type: "post",
            dataType: "json",
            data: {
                "": ""
            },
            success: function(data) {
                if (getCookie('shippingFee') != "" && getCookie('shipping') == 'true') {
                    grandTotal = parseInt(data.cart_amount) + parseInt(getCookie('shippingFee'));
                    $('.shippingFeeInput').val(parseInt(getCookie('shippingFee')));
                    $('.shippingFeeHtml').html(formatMoney(parseInt(getCookie('shippingFee')) / <?php echo $this->session->userdata('ex_rate') ?>));
                    $('.applyShippingFee').hide('slow');
                    $('.getEstimate').hide('slow');
                    $('.resetShipping').show('slow');
                } else {
                    grandTotal = parseInt(data.cart_amount);
                }

                $('.subtotalInput').val(parseInt(data.cart_amount));
                $('.GrandTotalInput').val(grandTotal);
                $('.subTotalHtml').html(formatMoney(parseInt(data.cart_amount) / <?php echo $this->session->userdata('ex_rate') ?>));
                $('.GrandTotalHtml').html(formatMoney(grandTotal / <?php echo $this->session->userdata('ex_rate') ?>));

                if (getCookie('coupon') != '') {
                    $('.viewCoupon').show('slow');
                    $('.couponInput').val(getCookie('coupon'));
                    $('.couponSize').html(getCookie('coupon') + '%');
                    var coupon = getCookie('coupon') / 100 * grandTotal;
                    $('.GrandTotalInput').val(grandTotal - coupon);
                    $('.GrandTotalHtml').html(formatMoney(grandTotal - coupon / <?php echo $this->session->userdata('ex_rate') ?>));
                    $('.couponDiv').html('<h6>Coupon Applied</h6>');
                } else {
                    $('.viewCoupon').hide('slow');
                    $('.GrandTotalInput').val(grandTotal);
                    $('.GrandTotalHtml').html(formatMoney(grandTotal / <?php echo $this->session->userdata('ex_rate') ?>));
                }
            }
        });
    }





















    $('.resetShipping').on('click', function() {
        if (confirm("Are you sure?")) {
            $('.shippingFeeInput').val('');
            $('.shippingFeeHtml').html(formatMoney(parseInt('0')));
            $('.applyShippingFee').show('slow');
            $('.getEstimate').show('slow');
            $('.resetShipping').hide('slow');
        }
        deleteCookie('shippingFee');
        deleteCookie('shipping');
        deleteCookie('shippingCountry');
        deleteCookie('shippingState');
        $('body').load(window.location.href);
    });
















    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(";");
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function deleteCookie(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }














    function checkout() {
        if (!getCookie('shipping') && $('#pickup').prop('checked') == false) {
            if (confirm("No shipping settings found or has been deleted due to change in product order. Do you still wish to continue without shipping setup? try calculating estimate and apply setting or refresh the page to begin shipping setup")) {
                window.location.href = '<?php echo base_url() ?>checkout';
            }
        } else {
            window.location.href = '<?php echo base_url() ?>checkout';
        }

    }














    function formatMoney(number) {
        return number.toLocaleString('en-US', {
            style: 'currency',
            currency: '<?php echo $this->session->userdata('currency') ?>'
        });
    }













    $('[name="sortShop"]').on('change', function() {
        window.location.href = "<?php echo base_url() ?>cart/sortShop/" + $('[name="sortShop"]').val();
    });
    $('[name="perPage"]').on('change', function() {
        window.location.href = "<?php echo base_url() ?>cart/setPage/" + $('[name="perPage"]').val();
    });














    $(function() {
        if (Notification.permission !== 'denied' && Notification.permission !== 'granted' && Notification.permission === "default") {
            $('#noteModal').modal('show');
            navigator.serviceWorker.register('<?php echo base_url() ?>sw.js');
        }
    });
    $('#acceptBtn').on('click', function() {
        $('#noteModal').modal('hide');
        Notification.requestPermission();
        navigator.serviceWorker.register('<?php echo base_url() ?>sw.js');
    });






























    $('#creditWalletBtn').on('click', function() {
        const public_key = '<?php echo $this->db->get('chb_settings')->row_array()['public_key']; ?>';
        const customerName = '<?php echo $user['firstname'] . ' ' . $user['lastname'] ?>';
        var site_name = '<?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?>';
        var pay_phone = "<?php echo $user['phone'] ?>";
        var Pay_Amount = $('[name="walletAmount"]').val().replace('₦', '');
        var payEmail = "<?php echo $user['email'] ?>";

        if (!Pay_Amount) {
            $('[name="walletAmount"]').focus();
            return false;
        }

        var handler = PaystackPop.setup({
            key: public_key,
            email: payEmail,
            amount: Pay_Amount * 100,
            ref: "wlt_" + Math.floor((Math.random() * 1000000000) + 1),
            metadata: {
                custom_fields: [{
                    display_name: customerName,
                    variable_name: pay_phone,
                    value: payEmail
                }]
            },
            callback: function(response) {
                $('#walletModal').modal('hide');
                alertMe("Please Wait...", 10000);
                creditWallet(response.reference);
            },
            onClose: function() {
                alert('transaction cancelled');
                return false;
            }
        });
        handler.openIframe();
    });


    function creditWallet(reference) {
        var amt = $('[name="walletAmount"]').val().replace('₦', '');
        $.ajax({
            url: "<?php echo base_url() ?>cart/creditWallet",
            type: "post",
            dataType: "json",
            data: {
                amt: amt,
                reference: reference
            },
            success: function(data) {
                $('[name="walletAmount"]').val('');
                alertMe(data, 10000);
                setTimeout(() => {
                    $('body').load(window.location.href);
                }, 4000);
            }
        });
    }

































    $('.couponBtn').on('click', function() {
        var coupon_code = $('[name="coupon_code"]').val();
        if (!coupon_code) {
            $('[name="coupon_code"]').focus();
            alertMe("Enter Code", 5000);
            return false;
        }
        $.ajax({
            url: "<?php echo base_url() ?>cart/applyCoupon",
            type: "post",
            dataType: "json",
            data: {
                coupon_code: coupon_code,
            },
            success: function(data) {
                setCookie('coupon', data.coupon_discount, data.coupon_expiry);
                alertMe(data.coupon_discount + "% " + data.coupon_name + " Coupon Applied", 7000);
                $('.couponDiv').html('<h6>' + data.coupon_discount + "% " + data.coupon_name + " Coupon Applied</h6>");
                calculateTotalAmount();
            },
            error: function(data) {
                alertMe('Invalid Coupon Code', 5000);
            }
        });
    });


































    var countFlag = 0;

    $('.getEstimate').on('click', function() {
        $('#waitModal').modal('show');
        const intervalFlag = setInterval(() => {
            countFlag++;
            if (countFlag >= 10) {
                clearInterval(intervalFlag);
                $('#waitModal').modal('hide');
            } else {
                estimateCalculator();
            }
        }, 1000);



        var cartRows = $('.cartRows').length;
        for (indexCount = 1; indexCount <= cartRows; indexCount++) {
            selectedColor = $('.myOrderSettings [name="selectedColor' + indexCount + '"]:checked').map(function() {
                return this.value
            }).get().join(",");

            selectedSize = $('.myOrderSettings [name="selectedSize' + indexCount + '"]:checked').map(function() {
                return this.value
            }).get().join(",");

            if (selectedColor == '' || selectedSize == '') {
                alertMe('Please Select Colors and Sizes to update Order', 6000);
                return false;
            }

            $('.myOrderSettings [name="selectedQuantity' + indexCount + '"]').each(function() {
                if ($(this).val() < 1) {
                    selectedQuantity = '1';
                    alertMe("Your order quantity has been set to 1", 5000);
                }
                if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
                    selectedQuantity = $(this).attr('max');
                    alertMe("We have " + $(this).attr('max') + " of this product. Your order quantity has been set to " + $(this).attr('max'), 5000);
                } else {
                    selectedQuantity = $(this).val();
                }
            });

            productID = $('.myOrderSettings [name="productID' + indexCount + '"]').val();

            $.ajax({
                url: "<?php echo base_url() ?>cart/updateCart",
                type: "post",
                dataType: "json",
                async: false,
                data: {
                    selectedColor: selectedColor,
                    selectedSize: selectedSize,
                    selectedQuantity: selectedQuantity,
                    productID: productID
                },
                success: function(data) {
                    $('.chq-out').show();
                    $('.chq-out').prop('disabled', false);
                    $('.myOrderSettings .t-total' + indexCount).html(formatMoney(parseInt(data.cart_amount) / <?php echo $this->session->userdata('ex_rate') ?>));
                    // clear Shipping cookie
                    deleteCookie('shippingFee');
                    deleteCookie('shipping');
                    $('.applyShippingFee').hide('slow');
                    $('.getEstimate').show('slow');
                    $('.resetShipping').hide('slow');
                    // ./clear Shipping cookie    
                    $('.up-cart').html('<i class="fa fa-check"></i> Update Cart');
                }
            });
            calculateTotalAmount();
            selectedColor = "";
            selectedSize = "";
            selectedQuantity = "";
            productID = "";
        }
    });




    function estimateCalculator() {
        var totalWeight = getCookie('cartWeight');
        var country = $('[name="shippingCountry"]').val();
        var state = $('[name="shippingState"]').val();
        if (totalWeight < 1) {
            return false;
        } else {

            $.ajax({
                url: "<?php echo base_url() ?>cart/shippingEstimate",
                type: "post",
                dataType: "json",
                data: {
                    country: country,
                    state: state
                },
                success: function(data) {
                    if (parseInt(data.price * totalWeight) > 0) {
                        var future = new Date(Date.now() + data.duration * 24 * 60 * 60 * 1000);
                        $('.chq-out').prop('disabled', false);
                        $('.viewEstimate').html('<p class="text-center"><strong>Price Estimate- ' + formatMoney(parseInt(data.price) * parseInt(totalWeight) / <?php echo $this->session->userdata('ex_rate') ?>) + '</strong></p><p class="text-center cartExpand">=> Price per kg * total weight</p><p>' + parseInt(data.duration - 2) + ' - ' + data.duration + ' Days - ' + future + '</p><hr>');
                        $('.viewEstimate').show('slow');
                        $('.applyShippingFee').show('slow');
                        setCookie('shippingFee', parseInt(data.price) * parseInt(totalWeight), 10);
                        setCookie('shippingCountry', country, 10);
                        setCookie('shippingState', state, 10);
                    } else {
                        alertMe("Network Failure! Please try again", 5000);
                        clearInterval(intervalFlag);
                        $('#waitModal').modal('hide');
                    }
                    calculateTotalAmount();
                },
                error: function() {
                    alertMe('We are not shipping to the selected location yet.', 10000);
                }
            });
        }
    }
















    $('.applyShippingFee').on('click', function() {
        setCookie('shipping', 'true', 10);
        if (getCookie('shippingFee') != "" && getCookie('shipping') == 'true' && parseInt(getCookie('shippingFee')) > 0) {
            if (confirm("Confirm shipping application")) {
                $('.shippingFeeInput').val(parseInt(getCookie('shippingFee')));
                $('.shippingFeeHtml').html(formatMoney(parseInt(getCookie('shippingFee')) / <?php echo $this->session->userdata('ex_rate') ?>));
                $('.GrandTotalHtml').html(formatMoney(parseInt($('.GrandTotalInput').val()) + parseInt(getCookie('shippingFee')) / <?php echo $this->session->userdata('ex_rate') ?>));
                $('.GrandTotalInput').val(parseInt($('.GrandTotalInput').val()) + parseInt(getCookie('shippingFee')));
                $('.applyShippingFee').hide('slow');
                $('.getEstimate').hide('slow');
                alertMe('Shipping Applied', 5000);
            }
        } else {
            alertMe("Invalid Shipping Fee. Try the Get Estimate process again!");
        }
        calculateTotalAmount();

    });





































    $('#pickup').on('click', function() {
        if ($('#pickup').prop('checked') == false) {
            $('.chbShipping').fadeIn();
        } else {
            // clear Shipping cookie
            deleteCookie('shippingFee');
            deleteCookie('shipping');
            $('.applyShippingFee').hide('slow');
            $('.getEstimate').show('slow');
            $('.resetShipping').hide('slow');
            // ./clear Shipping cookie  
            $('.chbShipping').fadeOut();
        }
    });
</script>