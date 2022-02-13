<section class="top-bar2">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="top-left d-flex">
                    <div class="lang-box">
                        <span><img src="<?php echo base_url() ?>images/fl-eng.png" alt="">English<i class="fa fa-angle-down"></i></span>
                        <ul class="list-unstyled">
                            <li><img src="<?php echo base_url() ?>images/fl-eng.png" alt="">English</li>
                            <li><img src="<?php echo base_url() ?>images/fl-fra.png" alt="">French</li>
                            <li><img src="<?php echo base_url() ?>images/fl-ger.png" alt="">German</li>
                            <li><img src="<?php echo base_url() ?>images/fl-bra.png" alt="">Brazilian</li>
                        </ul>
                    </div>
                    <div class="mny-box">
                        <span>NGN<i class="fa fa-angle-down"></i></span>
                        <ul class="list-unstyled">
                            <li>NGN</li>
                            <li>USD</li>
                        </ul>
                    </div>
                    <div class="call-us mny-box">
                        <p><img src="<?php echo base_url() ?>images/phn.png" alt=""><a href="callto:+234 708 242 7348">+234 708 242 7348</a> </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="top-right text-right">
                    <ul class="list-unstyled list-inline">
                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <li class="list-inline-item"><a href="<?php echo base_url() ?>userAccount"><img src="<?php echo base_url() ?>images/user.png" alt=""><?php echo $user['firstname'] . ' ' . $user['lastname'] ?></a></li>
                            <li class="list-inline-item"><a href="<?php echo base_url() ?>wishlist"><img src="<?php echo base_url() ?>images/wishlist.png" alt="">Wishlist</a></li>
                        <?php } else { ?>
                            <li class="list-inline-item"><a href="#"><img src="<?php echo base_url() ?>images/wishlist.png" alt="">Wishlist</a></li>
                        <?php } ?>


                        <li class="list-inline-item"><a href="<?php echo base_url() ?>order_history"><img src="<?php echo base_url() ?>images/checkout.png" alt="">History</a></li>


                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <li class="list-inline-item"><a href="<?php echo base_url() ?>auth/clearSession"><img src="<?php echo base_url() ?>images/login.png" alt="">Logout</a></li>
                        <?php } else { ?>
                            <li class="list-inline-item"><a href="<?php echo base_url() ?>login"><img src="<?php echo base_url() ?>images/login.png" alt="">Login</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>