<!-- Top Bar -->
<section class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-4">
                <div class="top-left d-flex">
                    <div class="lang-box">
                        <span><img src="<?php echo base_url() ?>images/fl-eng.png" alt="">Language<i class="fa fa-angle-down"></i></span>
                        <ul class="list-unstyled">
                            <li id="google_translate_element"></li>
                            <!-- <li><img src="<?php //echo base_url() 
                                                ?>images/fl-eng.png" alt="">English</li>
                            <li><img src="<?php //echo base_url() 
                                            ?>images/fl-fra.png" alt="">French</li>
                            <li><img src="<?php //echo base_url() 
                                            ?>images/fl-ger.png" alt="">German</li>
                            <li><img src="<?php //echo base_url() 
                                            ?>images/fl-bra.png" alt="">Brazilian</li> -->
                        </ul>
                    </div>
                    <div class="mny-box">
                        <span><?php echo $this->session->userdata('currency') ?><i class="fa fa-angle-down"></i></span>
                        <ul class="list-unstyled">
                            <li><a href="<?php echo base_url()?>cart/setCurrency/NGN"> NGN</a></li>
                            <li><a href="<?php echo base_url()?>cart/setCurrency/USD"> USD</a></li>
                        </ul>
                    </div>
                    <div class="call-us mny-box">
                        <p><img src="<?php echo base_url() ?>images/phn.png" alt=""><a href="callto:<?php echo $this->db->get('chb_settings')->row_array()['phone']; ?>"><?php echo $this->db->get('chb_settings')->row_array()['phone']; ?></a> </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-8">
                <div class="top-right text-right">
                    <ul class="list-unstyled list-inline">

                        <li class="list-inline-item pinkBg">
                            <a title="Chat with Us" href="javascript:void(0);" onclick="window.open('<?php echo $chat_url ?>', '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');"><i class="fa fa-comments-o"></i></a>
                        </li>


                        <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <li class="list-inline-item"><a href="<?php echo base_url() ?>userAccount"><img src="<?php echo base_url() ?>images/user.png" alt=""><?php echo $user['firstname'] . ' ' . $user['lastname'] ?></a></li>
                            <li class="list-inline-item"><a href="<?php echo base_url() ?>wishlist"><img src="<?php echo base_url() ?>images/wishlist.png" alt="">Wishlist</a></li>
                        <?php } else { ?>
                            <li class="list-inline-item"><a href="<?php echo base_url() ?>wishlist"><img src=" <?php echo base_url() ?>images/wishlist.png" alt="">Wishlist</a></li>
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
<!-- End Top Bar -->