<!-- Mobile Menu -->
<section class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <a href="<?php echo base_url() ?>" class="ml-5 text-center"><img class="max_h50" src="<?php echo base_url()  ?>images/logo.jpg" alt=""></a>
                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <a href="<?php echo base_url() ?>auth/clearSession"><span>Sign Out</span></a>
                        <?php } else { ?>
                            <a href="<?php echo base_url() ?>login"><span>Sign In</span></a>
                        <?php } ?>

                        <ul class="list-unstyled">
                            <li><a href="#"><i class="fa fa-home"></i> Order</a>
                                <ul class="list-unstyled">
                                    <li><a href="<?php echo base_url() ?>cart/setState/retail">Retail</a></li>
                                    <?php
                                    if ($user['verified_business'] !== '0') {
                                        if ($user['wallet_balance']  > 100000) {
                                            if ($user['count'] > 0) {
                                                echo "<li><a href='" . base_url() . "cart/setState/wholesale'>Wholesale</a></li>";
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li><a href="<?php echo base_url() ?>shop"><i class="fa fa-shopping-cart"></i> Shop</a></li>
                            <li><a href="<?php echo base_url() ?>index"><i class="fa fa-home"></i> Buy Now</a></li>
                            <li>
                                <a title="Chat with Us" href="javascript:void(0);" onclick="window.open('<?php echo $chat_url ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');"><i class="fa fa-comments-o"></i> Chat with Us</a>
                            </li>
                            <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                                <li><a href="<?php echo base_url() ?>order_history"><i class="fa fa-history"></i> Order History</a></li>
                                <li><a href="<?php echo base_url() ?>track-order"><i class="fa fa-map-marker"></i> Track Order</a></li>
                            <?php } ?>
                            <li><a href="<?php echo base_url() ?>contact"><i class="fa fa-phone"></i> Contact</a></li>
                            <li class="d-flex text-right mt-4">
                                <a href="<?php echo base_url() ?>wishlist">
                                    <img src="<?php echo base_url() ?>images/heart.png" alt="favorite">
                                    <span class="ViewUserWishlist">0</span>
                                </a>

                                <a href="<?php echo base_url() ?>shopping-cart">
                                    <img src="<?php echo base_url() ?>images/cart.png" alt="cart">
                                    <span class="ViewUserCartList">0</span>
                                </a>
                            </li>
                            <li>
                                <div class="mr-4 ml-4 mt-4 padding-fix">
                                    <form action="<?php echo base_url() ?>cart/find" method="POST" class="search-bar d-flex">
                                        <input type="search" class="form-control" required autocomplete="off" name="search_bar" placeholder="I'm looking for...">
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Mobile Menu -->