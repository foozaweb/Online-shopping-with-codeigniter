 <?php $this->load->view('template/header') ?>
 <?php $this->load->view('template/nav2'); ?>
 <script src="https://js.paystack.co/v1/inline.js"></script>
 


 <!-- Breadcrumb Area -->
 <section class="breadcrumb-area"> </section>
 <!-- End Breadcrumb Area -->

 <!-- Wishlist -->
 <section class="shopping-cart">
     <div class="container">
         <div class="row" id="printable">


             <div class="mb-5 col-12">
                 <div class="row">
                     <div class="col-md-4">
                         <div class="text-left text-capitalize">
                             <h3><strong>Order Info.</strong></h3>
                             <hr>
                             <p>Order ID: <?php echo $invoice['reference'] ?></p>
                             <p>Order Date: <?php echo $invoice['order_date'] ?></p>
                             <p>Payment Method: <?php echo $invoice['payment_method'] ?></p>
                             <p>Order Status:
                                 <?php if ($invoice['order_status'] == "0") {
                                        echo '<b class="small-alert alert-warning">Pending</b>';
                                    } elseif ($invoice['order_status'] == "1") {
                                        echo '<b class="small-alert alert-success">Completed</b>';
                                    } elseif ($invoice['order_status'] == "2") {
                                        echo '<b class="small-alert alert-info">Processing</b>';
                                    } else {
                                        echo '<b class="small-alert alert-danger">Unknown</b>';
                                    }
                                    ?>
                             </p>
                             <p>Payment Status:
                                 <?php if ($invoice['payment_status'] == "0") {
                                        echo '<b class="small-alert alert-warning">Pending</b>';
                                    } elseif ($invoice['payment_status'] == "1") {
                                        echo '<b class="small-alert alert-success">Paid</b>';
                                    } elseif ($invoice['payment_status'] == "2") {
                                        echo '<b class="small-alert alert-danger"> Refunded</b>';
                                    } else {
                                        echo '<b class="small-alert alert-danger">Not Found</b>';
                                    }  ?>

                             </p>
                             <p> Current Location: <?php echo $invoice['current_location'] ?> </p>
                         </div>
                     </div>

                     <div class="col-md-3"> </div>

                     <div class="col-md-5">
                         <div class="text-right">
                             <h3><strong>Shipping Info.</strong></h3>
                             <hr>
                             <p>Company Name: <?php echo $invoice['company_name'] ?></p>
                             <p>Shipping Address: <?php echo $invoice['shipping_address'] ?></p>
                             <p>Country: <?php echo $invoice['country'] ?></p>
                             <p>State: <?php echo $invoice['state'] ?></p>
                             <p>Town: <?php echo $invoice['town'] ?></p>
                             <p>Postal Code: <?php echo $invoice['postal_code'] ?></p>
                         </div>
                     </div>
                 </div>
             </div>


             <div class="col-md-12">
                 <div class="table-responsive">
                     <table class="table">
                         <thead>
                             <tr>
                                 <th></th>
                                 <th></th>
                                 <th>Product Name</th>
                                 <th>Total</th>
                                 <th>Quantity</th>
                                 <th>Color`s</th>
                                 <th>Size`s</th>
                                 <th>Weight</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php
                                $this->db->join('chb_orders', 'chb_orders.reference = chb_order_items.reference', 'left');
                                $this->db->where('chb_order_items.reference', $invoice['reference']);
                                $this->db->order_by('chb_order_items.item_id', 'desc');
                                $items = $this->db->get('chb_order_items')->result_array();
                                $index = '';
                                foreach ($items as $item) {
                                    $index++; ?>
                                 <tr>
                                     <td><?php echo $index; ?></td>
                                     <td>
                                         <div class="t-img">
                                             <a href="<?php echo base_url() . 'product/' . $item['product_id'] ?>"><img src="<?php echo $admin_url ?>/assets/images/<?php echo $this->db->get_where('chb_products', array('productId' => $item['product_id']))->row_array()['main_photo'] ?>" alt=""></a>
                                         </div>
                                     </td>
                                     <td>
                                         <?php
                                            echo $this->db->get_where('chb_products', array('productId' => $item['product_id']))->row_array()['product_name'];
                                            ?>
                                     </td>
                                     <td> <?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($item['amount']/$this->session->userdata('ex_rate')) ?>.00 </td>
                                     <td> <?php echo $item['quantity'] ?> </td>
                                     <td> <span class="wColorWrapper">
                                             <?php
                                                $tags = explode(',', $item['color']);
                                                for ($i = 0; $i < count($tags); $i++) {
                                                ?> <span class="colorCircle" style="background-color: <?php echo str_replace(' ', '', $tags[$i]); ?>;"></span>
                                             <?php } ?>
                                         </span>
                                     </td>
                                     <td> <?php
                                            $tags = explode(',', $item['size']);
                                            for ($i = 0; $i < count($tags); $i++) {
                                            ?>
                                             <span><?php echo str_replace(' ', '', $tags[$i]); ?></span>,
                                         <?php } ?>
                                     </td>
                                     <td> <?php echo $this->db->get_where('chb_products', array('productId' => $item['product_id']))->row_array()['weight'] ?>Kg. </td>
                                 </tr>
                             <?php } ?>
                         </tbody>
                     </table>

                 </div>
             </div>

             <div class="col-md-8"></div>
             <div class="col-md-4 bg-grey">
                 <div class="card-body">
                     <div class="order-review">
                         <h3><strong>Order Overview</strong></h3>
                         <hr>
                         <div class="review-box">
                             <ul class="list-unstyled">
                                 <li>Subtotal
                                     <span class="pull-right"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($invoice['sub_total']/$this->session->userdata('ex_rate')); ?>.00</span>
                                 </li>
                                 <li>VAT-
                                     <span class="pull-right"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($invoice['vat']/$this->session->userdata('ex_rate')) ?>.00 </span>
                                 </li>
                                 <li>Total Weight
                                     <span class="pull-right"><?php echo $invoice['weight'] ?>Kg.</span>
                                 </li>
                                 <li>Shipping
                                     <span class="pull-right"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($invoice['shippingFee']/$this->session->userdata('ex_rate')) ?>.00</span>
                                 </li>
                                 <li>Coupon Applied
                                     <span class="pull-right"><?php echo $invoice['coupon'] ?>%</span>
                                 </li>
                                 <hr>
                                 <li class="summaryClass">Grand Total
                                     <span class="pull-right"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($invoice['grandTotal']/$this->session->userdata('ex_rate')) ?>.00</span>
                                 </li>
                             </ul>
                         </div>

                         <?php if ($invoice['payment_status'] === '0') {
                                $set = $this->db->get('chb_settings')->row_array();
                            ?>

                             <div class="pay-meth mt-5">
                                 <input type="hidden" class="form-control" name="invoiceReference" value="<?php echo $invoice['reference'] ?>">

                                 <input type="hidden" class="form-control" class="checkoutSubtotalInput" name="checkoutSubtotalInput" value="<?php echo round($invoice['sub_total']) ?>">
                                 <input type="hidden" class="form-control" value="<?php echo $invoice['weight'] ?>" class="checkoutCartWeightInput" name="checkoutCartWeightInput">

                                 <input type="hidden" class="form-control" value="<?php echo $invoice['grandTotal'] ?>" class="checkoutGrandTotalInput" name="checkoutGrandTotalInput">

                                 <input type="hidden" class="form-control" value="<?php echo round($invoice['shippingFee']) ?>" class="checkoutShippingFeeInput" name="checkoutShippingFeeInput">

                                 <input type="hidden" class="form-control" value="<?php echo round($invoice['coupon']) ?>" class="checkoutCouponInput" name="checkoutCouponInput">

                                 <input type="hidden" class="form-control" value="<?php echo round($invoice['vat']) ?>" class="VatFee" name="VatFee">


                                 <h6>Make Payment now</h6>
                                 <hr>
                                 <div class="pay-box">
                                     <ul class="list-unstyled">
                                         <li>
                                             <?php
                                                $wResult = $this->db->get_where('chb_wallet', array('customer_id' => $user['customer_id']));
                                                if ($wResult->num_rows() < 1) {
                                                    echo '<input type="radio" id="walletPay" name="payment" value="walletPay" disabled>
                                        <label for="walletPay"><span><i class="fa fa-google-wallet"></i></span>Pay with Wallet</label> <span><a href="' . base_url() . 'cart/createWallet" class="cartExpand"> <i class="fa fa-google-wallet"></i>Create Wallet</a></span>';
                                                }

                                                if ($wResult->num_rows() > 0 && intval($user['wallet_balance']) < intval($invoice['grandTotal'])) {
                                                    echo '<input type="radio" id="walletPay" name="payment" value="walletPay" disabled>
                                        <label for="walletPay"><span><i class="fa fa-google-wallet"></i></span>Pay with Wallet</label> <span><a href="javascript:void(0);" class="fundWallet cartExpand" title="'.$this->session->userdata('ex_symbol').'' . number_format($user['wallet_balance']/$this->session->userdata('ex_rate')) . '.00" data-toggle="tooltip" data-placement="right">  <i class="fa fa-plus"></i>Fund Wallet</a></span>';
                                                }
                                                if ($wResult->num_rows() > 0 && intval($user['wallet_balance']) >= intval($invoice['grandTotal'])) {
                                                    echo '<input type="radio" id="walletPay" name="payment" value="walletPay" >
                                        <label for="walletPay" title="'.$this->session->userdata('ex_symbol').'' . number_format($user['wallet_balance']/$this->session->userdata('ex_rate')) . '.00"><span><i class="fa fa-google-wallet"></i></span>Pay with Wallet</label></span>';
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
                             <button type="button" name="button" class="ord-btn beginPaymentBtn no-display">Pay <?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($invoice['grandTotal']/$this->session->userdata('ex_rate')) ?>.00 Now</button>
                         <?php } ?>
                     </div>
                 </div>
             </div>
         </div>
         <div class="col-md-12">
             <a href="javascript:void(0);" class="dtBtn print"> <i class="fa fa-print"></i> Print Invoice</a>
         </div>
     </div>
 </section>
 <!-- End Wishlist -->



 <!-- Footer Area -->
 <?php $this->load->view('template/footer') ?>



 <script src="<?php echo base_url() ?>js/jQuery.print.min.js"></script>



 <script>
     const prependThis = '<div class="text-center p10"><?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?><br/> 58, Obafemi Awolowo way, Ikeja Lagos  <br>+234 708 242 7348</div> <br><br> <h3><strong>SALES INVOICE</strong></h3> <br> <div class="text-uppercase p10">BRANCH: <span class="pull-right">: IKEJA </span></div>';
     const appendThis = '<div class="text-uppercase p10"> <div class="text-center">...Thank you</div></div>';

     $('.print').on('click', function() {
         $("#printable").print({
             globalStyles: true,
             mediaPrint: true,
             stylesheet: "http://fonts.googleapis.com/css?family=Inconsolata",
             iframe: false,
             noPrintSelector: ".avoid-this",
             prepend: prependThis,
             append: appendThis,
             deferred: $.Deferred().done(function() {
                 console.log('Printing done', arguments);
             })
         });
     });





















     const gTotal = '<?php echo $invoice['grandTotal'] ?>';


     $('.beginPaymentBtn').on('click', function() {
         var reference = $('[name="invoiceReference"]').val();
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

     function payWithPayStack(reference) {
         const public_key = '<?php echo $this->db->get('chb_settings')->row_array()['public_key']; ?>';
         const customerName = '<?php echo $user['firstname'] . ' ' . $user['lastname'] ?>';
         var site_name = '<?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?>';
         var pay_phone = '<?php echo $user['phone'] ?>';
         var Pay_Amount = parseInt(gTotal);
         var payemail = '<?php echo $user['email'] ?>';

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
                 cardPay(reference);
             },
             onClose: function() {
                 alertMe('transaction cancelled', 6000);
                 return false;
             }
         });
         handler.openIframe();
     }




     var paymentMethod = "";
 

     function cardPay(reference) {
         var paymentMethod = "Card";
         $.ajax({
             url: "<?php echo base_url() ?>cart/placeOrder2_0",
             type: "post",
             dataType: "json",
             data: {
                 reference: reference,
                 paymentMethod: paymentMethod,
                 grandTotal: gTotal
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

                 deleteCookie2('shippingFee');
                 deleteCookie2('shipping');
                 deleteCookie2('pm');
                 deleteCookie2('cartWeight');
                 deleteCookie2('shippingCountry');
                 deleteCookie2('shippingState');
                 deleteCookie2('coupon');
                 deleteCookie2('payFallBack');
                 deleteCookie2('reference');
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
         var paymentMethod = "Wallet";
         $.ajax({
             url: "<?php echo base_url() ?>cart/placeOrder2_0",
             type: "post",
             dataType: "json",
             data: {
                 reference: reference,
                 paymentMethod: paymentMethod,
                 grandTotal: gTotal
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

                 deleteCookie2('shippingFee');
                 deleteCookie2('shipping');
                 deleteCookie2('pm');
                 deleteCookie2('cartWeight');
                 deleteCookie2('shippingCountry');
                 deleteCookie2('shippingState');
                 deleteCookie2('coupon');
                 deleteCookie2('payFallBack');
                 deleteCookie2('reference');
                 setTimeout(function() {
                     window.location.href = '<?php echo base_url() ?>order_history';
                 }, 4000);
             },
             error: function(data) {
                 //  setCookie('payFallBack', 'true', 10);
                 alertMe("Failed to Register. Please try again", 5000);
                 $('.beginPaymentBtn').html('Failed! Try again');
             }
         });
     }

     function altWalletPay(reference) {
         var paymentMethod = getCookie('pm');
         $.ajax({
             url: "<?php echo base_url() ?>cart/placeOrder2_0",
             type: "post",
             dataType: "json",
             data: {
                 reference: reference,
                 paymentMethod: paymentMethod,
                 grandTotal: gTotal
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

                 deleteCookie2('shippingFee');
                 deleteCookie2('shipping');
                 deleteCookie2('pm');
                 deleteCookie2('cartWeight');
                 deleteCookie2('shippingCountry');
                 deleteCookie2('shippingState');
                 deleteCookie2('coupon');
                 deleteCookie2('payFallBack');
                 deleteCookie2('reference');
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
         document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/chbcustomer;";
     }

     function deleteCookie2(name) {
         document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/chbcustomer/wholesale;";
     }

     function setCookie(cname, cvalue, exdays) {
         var d = new Date();
         d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
         var expires = "expires=" + d.toUTCString();
         document.cookie = cname + "=" + cvalue + "; " + expires;
     }
 </script>