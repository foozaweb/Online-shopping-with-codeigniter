<script src="https://js.paystack.co/v1/inline.js"></script>

<script>
    var reference = '';
    if (getCookie('reference') == "") {
        reference = 'CHB_' + Math.floor((Math.random() * 1000000) + 1);
    } else {
        reference = getCookie('reference');
    }

    calculateCheckoutAmount();

    function calculateCheckoutAmount() {
        var vat = parseInt($('.VatFee').val());
        $.ajax({
            url: "<?php echo base_url() ?>cart/calculateTotalAmount",
            type: "post",
            dataType: "json",
            data: {
                "": ""
            },
            success: function(data) {
                if (getCookie('shippingFee') != "" && getCookie('shipping') == 'true') {
                    $('[name="shippingCountry"]').val(getCookie('shippingCountry'));
                    $('[name="shippingState"]').val(getCookie('shippingState'));
                    $('[name="shippingCountry"]').attr('disabled', true);
                    $('[name="shippingState"]').attr('disabled', true);

                    grandTotal = parseInt(data.cart_amount) + parseInt(getCookie('shippingFee')) + parseInt(vat);
                    $('.checkoutShippingFeeInput').val(parseInt(getCookie('shippingFee')));
                    $('.checkoutShippingFeeHtml').html(formatMoney(parseInt(getCookie('shippingFee'))/<?php echo $this->session->userdata('ex_rate')?>));
                    $('.applyShippingFee').hide('fast');
                    $('.getEstimate').hide('fast');
                    $('.resetShipping').show('fast');
                } else {
                    grandTotal = parseInt(data.cart_amount) + parseInt(vat);
                }

                $('.checkoutSubtotalInput').val(parseInt(data.cart_amount));
                $('.checkoutGrandTotalInput').val(grandTotal);
                $('.checkoutSubTotalHtml').html(formatMoney(parseInt(data.cart_amount/<?php echo $this->session->userdata('ex_rate')?>)));
                $('.checkoutGrandTotalHtml').html(formatMoney(grandTotal/<?php echo $this->session->userdata('ex_rate') ?>));

                $('.checkoutCartWeightInput').val(getCookie('cartWeight'));
                $('.checkoutCartWeightHtml').html(getCookie('cartWeight') + 'Kg.');
                $('.vatFeeHtml').html(formatMoney(vat/<?php echo $this->session->userdata('ex_rate') ?>));

                if (getCookie('coupon') != '') {
                    $('.viewCoupon').show('fast');
                    $('.checkoutCouponInput').val(getCookie('coupon'));
                    $('.checkoutCouponSize').html(getCookie('coupon') + '%');
                    var coupon = getCookie('coupon') / 100 * grandTotal;
                    $('.checkoutGrandTotalInput').val(grandTotal - coupon);
                    $('.checkoutGrandTotalHtml').html(formatMoney(grandTotal - coupon/<?php echo $this->session->userdata('ex_rate') ?>));
                    $('.couponDiv').html('<h6>Coupon Applied</h6>');
                } else {
                    $('.viewCoupon').hide('fast');
                    $('.checkoutGrandTotalInput').val(grandTotal);
                    $('.checkoutGrandTotalHtml').html(formatMoney(grandTotal/<?php echo $this->session->userdata('ex_rate') ?>));
                }
            }
        });
    }






    var err = "0";
    $('.processOrderBtn').on('click', function() {
        var err = "0";
        $('.validate').each(function() {
            if (!$(this).val()) {
                $('[name="' + $(this).attr('name') + '"]').focus();
                alertMe('Found empty field. This is a compulsory field', 5000);
                err = "1";
                return false;
            }
        });
        if (err === "1") {
            return false;
        }

        if ($('#termsShipping').prop('checked') == false) {
            alertMe("You need to Agree with our terms of service to continue", 8000);
            return false;
        }

        var type = $('[name="payment"]:checked').val();
        if (!type) {
            alertMe('Please Select Payment Method', 6000);
            return false;
        }

        saveOrder(reference);
    });


    $(function() {
        if (getCookie('payFallBack') == 'true') {
            $('.processOrderBtn').hide();
            $('.beginPaymentBtn').show();
        } else {
            $('.processOrderBtn').show();
            $('.beginPaymentBtn').hide();
        }
    })



    $('.beginPaymentBtn').on('click', function() {
        var type = $('[name="payment"]:checked').val();
        if (type != "" && type == "walletPay") {
            $(this).html('<i class="fa fa-google-wallet"></i> Pay Now');
            if (getCookie('payFallBack') == 'true' && getCookie('pm') == 'Wallet') {
                altWalletPay(reference);
            } else {
                walletPay(reference);
            }
        } else if (type != "" && type == "cardPay") {
            $(this).html('<i class="fa fa-credit-card"></i> Pay Now');
            if (getCookie('payFallBack') == 'true' && getCookie('pm') == 'Card') {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>auth/verifyPayment",
                    dataType: "JSON",
                    data: {
                        reference: reference
                    },
                    success: function(data) {
                        if (data === 'success') {
                            cardPay(reference);
                        }
                    },
                    error: function(data) {
                        alertMe("Could not verify payment automatically. Please send us a message via <?php echo $this->db->get('chb_settings')->row_array()['email'] ?> with your reference ID: " + reference, 15000);
                        return false;
                    }
                });
            } else {
                payWithPayStack(reference);
            }
        } else {
            alertMe('Please Select Payment Method', 6000);
        }
    });



    $(function() {
        if (getCookie('reference')) {
            checkReference();
        }
    })


    function checkReference() {
        var reference = getCookie('reference');
        $.ajax({
            type: "post",
            url: "<?php echo base_url() ?>cart/checkReference",
            dataType: "json",
            data: {
                reference: reference
            },
            success: function(data) {
                $('.processOrderBtn').hide();
                $('.beginPaymentBtn').show();
                $('.updateOrderBtn').show();
            },
            error: function(data) {
                $('.processOrderBtn').show();
                $('.beginPaymentBtn').hide();
                $('.updateOrderBtn').hiden();
            }
        });
    }


    var paymentMethod = "";

    function saveOrder(reference) {
        var type = $('[name="payment"]:checked').val();
        if (type == 'cardPay') {
            paymentMethod = "Card";
        } else {
            paymentMethod = "Wallet";
        }

        var companyName = $('[name="companyName"]').val();
        var deliveryAddress = $('[name="deliveryAddress"]').val();
        var shippingCountry = $('[name="shippingCountry"]').val();
        var shippingState = $('[name="shippingState"]').val();
        var deliveryCity = $('[name="deliveryCity"]').val();
        var postalCode = $('[name="postalCode"]').val();
        var orderNote = $('[name="orderNote"]').val();
        var Subtotal = $('[name="checkoutSubtotalInput"]').val();
        var CartWeight = $('[name="checkoutCartWeightInput"]').val();
        var GrandTotal = $('[name="checkoutGrandTotalInput"]').val();
        var ShippingFee = $('[name="checkoutShippingFeeInput"]').val();
        var Coupon = $('[name="checkoutCouponInput"]').val();
        var VatFee = $('[name="VatFee"]').val();
        var saveAddress = $('[name="saveAddress"]').val();
        $.ajax({
            url: "<?php echo base_url() ?>cart/saveOrder",
            type: "post",
            dataType: "json",
            data: {
                reference: reference,
                paymentMethod: paymentMethod,
                companyName: companyName,
                deliveryAddress: deliveryAddress,
                shippingCountry: shippingCountry,
                shippingState: shippingState,
                deliveryCity: deliveryCity,
                postalCode: postalCode,
                orderNote: orderNote,
                Subtotal: Subtotal,
                CartWeight: CartWeight,
                GrandTotal: GrandTotal,
                ShippingFee: ShippingFee,
                Coupon: Coupon,
                VatFee: VatFee,
                saveAddress: saveAddress,
            },
            async: false,
            beforeSend: function(data) {
                $('.processOrderBtn').html('<img src="' + base_url + 'images/loader.gif" style="max-height:35px;"> Processing Order');
            },
            success: function(data) {
                setCookie('reference', reference, 10);
                setCookie('pm', paymentMethod, 10);
                alertMe("You have successfully placed your order", 5000);
                $('.processOrderBtn').hide();
                $('.beginPaymentBtn').show();
                $('.updateOrderBtn').show();
            },
            error: function(data) {
                alertMe("Failed to process order. Please try again", 5000);
                $('.processOrderBtn').html('Failed! Try again');
            }
        });
    }








    function payWithPayStack(reference) {
        const customerName = '<?php echo $user['firstname'] . ' ' . $user['lastname'] ?>';
        const public_key = '<?php echo $this->db->get('chb_settings')->row_array()['public_key']; ?>';
        var site_name = 'chbluxury.com';
        var pay_phone = $('[name="checkout_phone"]').val();
        var Pay_Amount = $('.checkoutGrandTotalInput').val();
        var payemail = $('[name="checkout_email"]').val();

        var handler = PaystackPop.setup({
            key: public_key,
            email: payemail,
            amount: Pay_Amount * 100,
            ref: reference,
            metadata: {
                custom_fields: [{
                    display_name: customerName,
                    variable_name: pay_phone,
                    value: payemail
                }]
            },
            async: false,
            callback: function(response) {
                cardPay(response.reference);
            },
            onClose: function() {
                alertMe('transaction cancelled', 6000);
                return false;
            }
        });
        handler.openIframe();
    }


    function cardPay(reference) {
        var paymentMethod = "Card";
        var companyName = $('[name="companyName"]').val();
        var deliveryAddress = $('[name="deliveryAddress"]').val();
        var shippingCountry = $('[name="shippingCountry"]').val();
        var shippingState = $('[name="shippingState"]').val();
        var deliveryCity = $('[name="deliveryCity"]').val();
        var postalCode = $('[name="postalCode"]').val();
        var orderNote = $('[name="orderNote"]').val();
        var Subtotal = $('[name="checkoutSubtotalInput"]').val();
        var CartWeight = $('[name="checkoutCartWeightInput"]').val();
        var GrandTotal = $('[name="checkoutGrandTotalInput"]').val();
        var ShippingFee = $('[name="checkoutShippingFeeInput"]').val();
        var Coupon = $('[name="checkoutCouponInput"]').val();
        var VatFee = $('[name="VatFee"]').val();
        var saveAddress = $('[name="saveAddress"]').val();
        $.ajax({
            url: "<?php echo base_url() ?>cart/placeOrder",
            type: "post",
            dataType: "json",
            data: {
                reference: reference,
                paymentMethod: paymentMethod,
                companyName: companyName,
                deliveryAddress: deliveryAddress,
                shippingCountry: shippingCountry,
                shippingState: shippingState,
                deliveryCity: deliveryCity,
                postalCode: postalCode,
                orderNote: orderNote,
                Subtotal: Subtotal,
                CartWeight: CartWeight,
                GrandTotal: GrandTotal,
                ShippingFee: ShippingFee,
                Coupon: Coupon,
                VatFee: VatFee,
                saveAddress: saveAddress,
            },
            beforeSend: function() {
                $('.beginPaymentBtn').html('<img src="' + base_url + 'images/loader.gif" style="max-height:35px;"> Registering Payment');
            },
            success: function(data) {
                $('.beginPaymentBtn').html('<i class="fa fa-check-circle-o"></i> Payment Registered');
                alertMe("Payment successfully registered", 5000);
                alertMe("Please Wait...", 5000);
                deleteCookie('shippingFee');
                deleteCookie('shipping');
                deleteCookie('pm');
                deleteCookie('cartWeight');
                deleteCookie('shippingCountry');
                deleteCookie('shippingState');
                deleteCookie('coupon');
                deleteCookie('payFallBack');
                deleteCookie('reference');
                setTimeout(function() {
                    window.location.href = '<?php echo base_url() ?>order_history';
                }, 4000);
            },
            error: function(data) {
                setCookie('payFallBack', 'true', 10);
                alertMe("Failed to Register. Please try again", 5000);
                $('.beginPaymentBtn').html('Failed! Try again');
            }
        });
    }



    // ############# Payment Processing ############################
    // ###################### walletPay ############################

    function walletPay(reference) {
        var reference = reference;
        var paymentMethod = "Wallet";
        var companyName = $('[name="companyName"]').val();
        var deliveryAddress = $('[name="deliveryAddress"]').val();
        var shippingCountry = $('[name="shippingCountry"]').val();
        var shippingState = $('[name="shippingState"]').val();
        var deliveryCity = $('[name="deliveryCity"]').val();
        var postalCode = $('[name="postalCode"]').val();
        var orderNote = $('[name="orderNote"]').val();
        var Subtotal = $('[name="checkoutSubtotalInput"]').val();
        var CartWeight = $('[name="checkoutCartWeightInput"]').val();
        var GrandTotal = $('[name="checkoutGrandTotalInput"]').val();
        var ShippingFee = $('[name="checkoutShippingFeeInput"]').val();
        var Coupon = $('[name="checkoutCouponInput"]').val();
        var VatFee = $('[name="VatFee"]').val();
        var saveAddress = $('[name="saveAddress"]').val();
        $.ajax({
            url: "<?php echo base_url() ?>cart/placeOrder",
            type: "post",
            dataType: "json",
            data: {
                reference: reference,
                paymentMethod: paymentMethod,
                companyName: companyName,
                deliveryAddress: deliveryAddress,
                shippingCountry: shippingCountry,
                shippingState: shippingState,
                deliveryCity: deliveryCity,
                postalCode: postalCode,
                orderNote: orderNote,
                Subtotal: Subtotal,
                CartWeight: CartWeight,
                GrandTotal: GrandTotal,
                ShippingFee: ShippingFee,
                Coupon: Coupon,
                VatFee: VatFee,
                saveAddress: saveAddress,
            },
            beforeSend: function(data) {
                $('.beginPaymentBtn').html('<img src="' + base_url + 'images/loader.gif" style="max-height:35px;"> Registering Payment');
            },
            success: function(data) {
                $('.beginPaymentBtn').html('<i class="fa fa-check-circle-o"></i> Payment Registered');
                alertMe("Payment successfully registered", 5000);
                alertMe("Please Wait...", 5000);
                deleteCookie('shippingFee');
                deleteCookie('shipping');
                deleteCookie('pm');
                deleteCookie('cartWeight');
                deleteCookie('shippingCountry');
                deleteCookie('shippingState');
                deleteCookie('coupon');
                deleteCookie('payFallBack');
                deleteCookie('reference');
                setTimeout(function() {
                    window.location.href = '<?php echo base_url() ?>order_history';
                }, 4000);
            },
            error: function(data) {
                // setCookie('payFallBack', 'true', 10);
                alertMe("Failed to Register. Please try again", 5000);
                $('.beginPaymentBtn').html('Failed! Try again');
            }
        });
    }

    function altWalletPay(reference) {
        var reference = reference;
        var paymentMethod = getCookie('pm');
        var companyName = $('[name="companyName"]').val();
        var deliveryAddress = $('[name="deliveryAddress"]').val();
        var shippingCountry = $('[name="shippingCountry"]').val();
        var shippingState = $('[name="shippingState"]').val();
        var deliveryCity = $('[name="deliveryCity"]').val();
        var postalCode = $('[name="postalCode"]').val();
        var orderNote = $('[name="orderNote"]').val();
        var Subtotal = $('[name="checkoutSubtotalInput"]').val();
        var CartWeight = $('[name="checkoutCartWeightInput"]').val();
        var GrandTotal = $('[name="checkoutGrandTotalInput"]').val();
        var ShippingFee = $('[name="checkoutShippingFeeInput"]').val();
        var Coupon = $('[name="checkoutCouponInput"]').val();
        var VatFee = $('[name="VatFee"]').val();
        var saveAddress = $('[name="saveAddress"]').val();
        $.ajax({
            url: "<?php echo base_url() ?>cart/placeOrder",
            type: "post",
            dataType: "json",
            data: {
                reference: reference,
                paymentMethod: paymentMethod,
                companyName: companyName,
                deliveryAddress: deliveryAddress,
                shippingCountry: shippingCountry,
                shippingState: shippingState,
                deliveryCity: deliveryCity,
                postalCode: postalCode,
                orderNote: orderNote,
                Subtotal: Subtotal,
                CartWeight: CartWeight,
                GrandTotal: GrandTotal,
                ShippingFee: ShippingFee,
                Coupon: Coupon,
                VatFee: VatFee,
                saveAddress: saveAddress,
            },
            beforeSend: function(data) {
                $('.beginPaymentBtn').html('<img src="' + base_url + 'images/loader.gif" style="max-height:35px;"> Registering Payment');
            },
            success: function(data) {
                $('.beginPaymentBtn').html('<i class="fa fa-check-circle-o"></i> Payment Registered');
                alertMe("Payment successfully registered", 5000);
                alertMe("Please Wait...", 5000);
                deleteCookie('shippingFee');
                deleteCookie('shipping');
                deleteCookie('pm');
                deleteCookie('cartWeight');
                deleteCookie('shippingCountry');
                deleteCookie('shippingState');
                deleteCookie('coupon');
                deleteCookie('payFallBack');
                deleteCookie('reference');

                setTimeout(function() {
                    window.location.href = '<?php echo base_url() ?>order_history';
                }, 4000);
            },
            error: function(data) {
                // setCookie('payFallBack', 'true', 10);
                alertMe("Failed to Register. Please try again", 5000);
                $('.beginPaymentBtn').html('Failed! Try again');
            }
        });
    }































    function formatMoney(number) {
        return number.toLocaleString('en-US', {
            style: 'currency',
            currency: '<?php echo $this->session->userdata('currency')?>'
        });
    }


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
</script>