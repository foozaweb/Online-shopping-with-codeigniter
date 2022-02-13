<!-- Brand area 2 -->
<!-- <section class="brand2 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tp-bnd owl-carousel">
                    <div class="bnd-items">
                        <a href="#"><img src="<?php //echo base_url() 
                                                ?>images/brand-01.png" alt="" class="img-fluid"></a>
                    </div>
                    <div class="bnd-items">
                        <a href="#"><img src="<?php //echo base_url() 
                                                ?>images/brand-02.png" alt="" class="img-fluid"></a>
                    </div>
                    <div class="bnd-items">
                        <a href="#"><img src="<?php //echo base_url() 
                                                ?>images/brand-03.png" alt="" class="img-fluid"></a>
                    </div>
                    <div class="bnd-items">
                        <a href="#"><img src="<?php //echo base_url() 
                                                ?>images/brand-04.png" alt="" class="img-fluid"></a>
                    </div>
                    <div class="bnd-items">
                        <a href="#"><img src="<?php //echo base_url() 
                                                ?>images/brand-05.png" alt="" class="img-fluid"></a>
                    </div>
                    <div class="bnd-items">
                        <a href="#"><img src="<?php //echo base_url() 
                                                ?>images/brand-06.png" alt="" class="img-fluid"></a>
                    </div>
                    <div class="bnd-items">
                        <a href="#"><img src="<?php //echo base_url() 
                                                ?>images/brand-07.png" alt="" class="img-fluid"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- End Brand area 2 -->




<a class="categoryViewer-btn" href="#"><i class="fa fa-list-alt"></i></a>
<a class="footerDrawer-btn" href="#"><i class="fa fa-toggle-up"></i></a>
<!-- Footer Area -->
<section class="footer-top footerDrawer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="f-contact">
                    <h5>Contact Info</h5>
                    <div class="f-add">
                        <i class="fa fa-map-marker"></i>
                        <span>Address :</span>
                        <p>
                            <?php
                            echo $this->db->get('chb_settings')->row_array()['address'];
                            ?>
                        </p>
                    </div>
                    <div class="f-email">
                        <i class="fa fa-envelope"></i>
                        <span>Email :</span>
                        <p>
                            <a href="mailto:<?php echo $this->db->get('chb_settings')->row_array()['email']; ?>">
                                <?php echo $this->db->get('chb_settings')->row_array()['email']; ?>
                            </a>
                        </p>
                    </div>
                    <div class="f-phn">
                        <i class="fa fa-phone"></i>
                        <span>Phone :</span>
                        <p><?php echo $this->db->get('chb_settings')->row_array()['phone']; ?></p>
                    </div>
                    <div class="f-social">
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item"><a href="<?php echo $this->db->get('chb_settings')->row_array()['facebook']; ?>"><i class="fa fa-facebook"></i></a></li>
                            <li class="list-inline-item"><a href="<?php echo $this->db->get('chb_settings')->row_array()['twitter']; ?>"><i class="fa fa-twitter"></i></a></li>
                            <li class="list-inline-item">
                                <a href="<?php echo $this->db->get('chb_settings')->row_array()['linkedin']; ?>"><i class="fa fa-linkedin"></i></a>
                            </li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="f-cat">
                    <h5>Categories</h5>
                    <ul class="list-unstyled">
                        <?php
                        $this->db->order_by('cat', 'random');
                        $this->db->limit(8);
                        $category = $this->db->get('chb_category')->result_array();
                        foreach ($category as $cat) { ?>
                            <li><a href="<?php echo base_url() ?>ct/<?php echo $cat['cat_slug'] ?>"><i class="fa fa-angle-right"></i><?php echo ucfirst(str_replace('-', ' ', $cat['cat'])) ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="f-link">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo base_url() ?>userAccount"><i class="fa fa-angle-right"></i>My Account</a></li>
                        <li><a href="<?php echo base_url() ?>shopping-cart"><i class="fa fa-angle-right"></i>Shopping Cart</a></li>
                        <li><a href="<?php echo base_url() ?>wishlist"><i class="fa fa-angle-right"></i>My Wishlist</a></li>
                        <li><a href="<?php echo base_url() ?>checkout"><i class="fa fa-angle-right"></i>Checkout</a></li>
                        <li><a href="<?php echo base_url() ?>history"><i class="fa fa-angle-right"></i>Order History</a></li>
                        <li>
                            <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                                <a href="<?php echo base_url() ?>auth/clearSession"><i class="fa fa-angle-right"></i>Sign Out</a>
                            <?php } else { ?>
                                <a href="<?php echo base_url() ?>login"><i class="fa fa-angle-right"></i>Sign In</a>
                            <?php } ?>
                        </li>
                        <li><a href="<?php echo base_url() ?>locations"><i class="fa fa-angle-right"></i>Our Locations</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="f-sup">
                    <h5>Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo base_url() ?>about-us"><i class="fa fa-angle-right"></i>About Us</a></li>
                        <li><a href="<?php echo base_url() ?>contact"><i class="fa fa-angle-right"></i>Contact Us</a></li>
                        <li><a href="<?php echo base_url() ?>payment-policy"><i class="fa fa-angle-right"></i>Payment Policy</a></li>
                        <li><a href="<?php echo base_url() ?>return-policy"><i class="fa fa-angle-right"></i>Return Policy</a></li>
                        <li><a href="<?php echo base_url() ?>privacy-policy"><i class="fa fa-angle-right"></i>Privacy Policy</a></li>
                        <li><a href="<?php echo base_url() ?>faq"><i class="fa fa-angle-right"></i>Frequently asked questions</a></li>
                        <li><a href="<?php echo base_url() ?>terms-condition"><i class="fa fa-angle-right"></i>Terms & Condition</a></li>
                        <li><a href="<?php echo base_url() ?>delivery-info"><i class="fa fa-angle-right"></i>Delivery Info</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="spacer"></div>

<section class="footer-btm2">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>Copyright &copy; <?php echo date('Y') ?> <?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?>
                    <!-- | Designed Team: <a href="https://foozawebtech.com" target="_blank">FoozawebTech</a> -->
                </p>
            </div>
            <div class="col-md-6 text-right">
                <img src="<?php echo base_url() ?>images/payment.png" alt="" class="img-fluid">
            </div>
        </div>
    </div>
    <div class="back-to-top text-center">
        <img src="<?php echo base_url() ?>images/backtotop.png" alt="" class="img-fluid">
    </div>
</section>


<section class="footer-btm text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url() ?>shopping-cart" title="Shop" class="col-lg-2 col-12">
                    <i class="fa fa-shopping-cart cart-handler"><span class="ViewUserCartList">0</span></i>
                </a>
                <a href="<?php echo base_url() ?>shop" title="New Products" class="col-lg-2 col-12">
                    <i><img src="<?php echo base_url() ?>images/new.png" style="height: 12px;"></i>
                </a>
                <span class="dropup col-lg-2 col-12" title="Home">
                    <span data-toggle="dropdown"><i class="fa fa-home"></i></span>
                    <ul class="dropdown-menu pl-4">
                        <li><a href="<?php echo base_url() ?>cart/setState/retail">Retail</a></li>
                        <?php
                        if ($user['verified_business'] !== '0') {
                            if ($user['wallet_balance']  > 100000) {
                                if ($user['count'] > 0) {
                                    echo "<li><a href='" . base_url() . "cart/setState/wholesale'>Wholesale</a></li>";
                                } else {
                                    echo "<li><a data-message='Your wallet balance is either less than 100k, your business is unverified or you have shopped up to five times since your last recharge. You need to credit your wallet to continue shopping wholesale' href='javascript:void(0)' class='fundWallet'>Wholesale</a></li>";
                                }
                            } else {
                                echo "<li><a data-message='Your wallet balance is either less than 100k, your business is unverified or you have shopped up to five times since your last recharge. You need to credit your wallet to continue shopping wholesale' href='javascript:void(0)' class='fundWallet'>Wholesale</a></li>";
                            }
                        } else {
                            echo "<li><a data-message='Your wallet balance is either less than 100k, your business is unverified or you have shopped up to five times since your last recharge. You need to credit your wallet to continue shopping wholesale' href='javascript:void(0)' class='fundWallet'>Wholesale</a></li>";
                        }
                        ?>
                    </ul>
                </span>

                <a href="<?php echo base_url() ?>search" title="Search" class="col-lg-2 col-12">
                    <i class="fa fa-search"></i>
                </a>
                <a title="Chat with Us" href="javascript:void(0);" onclick="window.open('<?php echo $chat_url ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');" class="col-lg-2 col-12">
                    <i class="fa fa-comments-o"></i>
                </a>
                <span class="dropup col-lg-2 col-12" title="More">
                    <span data-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></span>
                    <ul class="dropdown-menu pl-4">
                        <li><a href="<?php echo base_url() ?>index" class="text-danger">Hot</a></li>
                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <li><a href="<?php echo base_url() ?>order_history">Order History</a></li>
                            <li><a href="<?php echo base_url() ?>track-order">Track Order</a></li>
                        <?php } ?>
                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <li><a href="<?php echo base_url() ?>userAccount">Profile</a></li>
                            <li><a href="<?php echo base_url() ?>wishlist" class="cart-handler">Wishlist <span class="ViewUserWishlist">0</span></a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo base_url() ?>wishlist">Wishlist</a></li>
                        <?php } ?>

                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <li><a href="<?php echo base_url() ?>auth/clearSession">Logout</a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo base_url() ?>login">Sign In</a></li>
                        <?php } ?>
                    </ul>
                </span>
            </div>

        </div>
    </div>
    <!-- <div class="back-to-top text-center">
        <img src="<?php //echo base_url() 
                    ?>images/backtotop.png" alt="" class="img-fluid">
    </div> -->
</section>
<!-- End Footer Area -->

<!-- jQuery JS -->
<script src="<?php echo base_url() ?>js/assets/vendor/jquery-1.12.4.min.js"></script> 
<script src="<?php echo base_url() ?>js/assets/popper.min.js"></script>
<script src="<?php echo base_url() ?>js/assets/bootstrap.min.js"></script>
<?php include('./js/assets/vendor/lic.php') ?>
<script src="<?php echo base_url() ?>js/assets/owl.carousel.min.js"></script> 
<script src="<?php echo base_url() ?>js/assets/wow.min.js"></script> 
<script src="<?php echo base_url() ?>js/assets/price-filter.js"></script> 
<script src="<?php echo base_url() ?>js/assets/jquery.meanmenu.min.js"></script>  
<script src="<?php echo base_url() ?>js/plugins.js"></script>
<script src="<?php echo base_url() ?>js/custom.js"></script>
<script src="<?php echo base_url() ?>js/ntc.js"></script>
<script src="<?php echo base_url() ?>js/jquery.countdown.js"></script>
<script src="<?php echo base_url() ?>js/jquery.countdown.min.js"></script>
</body>


<script type="text/javascript">
    $(".myCounterBox").countdown($(".myCounterBox").data('date'), function(event) {
        $(this).html(
            event.strftime('<li class="list-inline-item">%D <p>days</p></li>   <li class="list-inline-item">%H <p>Hours</p></li> <li class="list-inline-item">%M <p>Mins</p></li>     <li class="list-inline-item">%S <p>Secs</p></li>')
        );
    });
</script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en'
        }, 'google_translate_element');
    }

    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script> 
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

















<script>
    $('[name="search_bar"]').on('change', function() {
        searches($(this).val());
    });

    $('[name="search_bar"]').on('keyup', function() {
        searches($(this).val());
    });





    function searches(search) {
        if (search) {
            $.ajax({
                url: "<?php echo base_url() ?>cart/ajaxFind",
                type: "POST",
                dataType: "JSON",
                data: {
                    search_bar: search,
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<p><a class="pid" href="<?php echo base_url() ?>product/' + data[i].productId + '">' + data[i].product_name + ' | ' + ' (' + data[i].quantity + ' Pieces Available)</a></p><br>';
                    }
                    $('.showResult').html(html);
                    $('.showResult').show();
                },
                error: function(data) {
                    $('.showResult').html("No Matching Product '" + search + "' Found");
                }
            });
        } else {
            $('.showResult').html('');
            $('.showResult').hide();
        }
    }
</script>

</html>