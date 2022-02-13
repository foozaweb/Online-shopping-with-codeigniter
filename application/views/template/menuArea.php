<!-- Menu Area -->
<section class="menu-area foozaweb-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main-menu">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item"><a>ORDER <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown list-unstyled">
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
                        </li>
                        <li class="list-inline-item mega-menu"><a>MENU <i class="fa fa-angle-down"></i></a>
                            <div class="mega-box">
                                <div class="row">
                                    <?php
                                    $output = '';
                                    $this->db->limit('3');
                                    $this->db->order_by('sub_cat_id', 'random');
                                    $query = $this->db->get('chb_sub_category')->result_array();
                                    foreach ($query as $queryResult) {
                                        $output .= '<div class="col-md-3"><div class="clt-area">
                                            <h6>' . $queryResult['sub_cat'] . '</h6><div class="link-box">';
                                        $this->db->limit(rand(10, 20));
                                        $this->db->order_by('id', 'random');
                                        $this->db->group_by('productBrand');
                                        $this->db->where('subCategory', $queryResult['sub_cat_slug']);
                                        $types = $this->db->get_where('chb_products')->result_array();
                                        foreach ($types as $type) {
                                            $output .= '<a href="' . base_url() . 'brand/' . $type['productBrand'] . '">- ' . str_replace('-', ' ', $type['productBrand']) . '</a>';
                                        }
                                        $output .= ' </div> </div>  </div>';
                                    }
                                    echo $output;
                                    ?>

                                    <div class="col-md-3">
                                        <div class="m-slider owl-carousel">
                                            <?php
                                            $this->db->where('discount !=', '');
                                            $this->db->limit(rand(5, 10));
                                            $que = $this->db->get('chb_products')->result_array();
                                            foreach ($que as $q) { ?>
                                                <div class="slider-item">
                                                    <img src="<?php echo $admin_url ?>/assets/images/<?php echo $q['main_photo']; ?>" alt="" class="img-fluid">
                                                    <span>-<?php echo $q['discount']; ?>%</span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mega-bnr">
                                            <div class="row">
                                                <?php
                                                $this->db->order_by('id', 'random');
                                                $this->db->limit('4');
                                                $result = $this->db->get('chb_products')->result_array();
                                                foreach ($result as $res) { ?>
                                                    <div class="col-md-3">
                                                        <a href="<?php echo base_url() ?>product/<?php echo $res['productId'] ?>" class="bnr-box text-center">
                                                            <img src="<?php echo $admin_url ?>/assets/images/<?php echo $res['main_photo'] ?>" alt="">
                                                            <!-- <span><?php //echo $res['product_name'] 
                                                                        ?></span> -->
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item"><a href="<?php echo base_url() ?>">SHOP</a></li>
                        <li class="list-inline-item"><a href="<?php echo base_url() ?>shop">BUY NOW</a></li>
                        <li class="list-inline-item"><small class="text-danger">Brands <i class="fa fa-angle-double-right"></i></small></li>
                        <?php
                        $limit = '4';
                        if (is_null($this->session->userdata('chbUserAuth'))) {
                            $limit = '6';
                        }
                        $this->db->limit($limit);
                        $this->db->order_by('id', 'random');
                        $bds = $this->db->get('chb_product_brand')->result_array();
                        foreach ($bds as $b) {
                            echo '<li class="list-inline-item text-uppercase"><a href="' . base_url() . 'brand/' . $b['p_brand_slug'] . '">' . $b['p_brand_name'] . '</a></li>';
                        }
                        if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                            <li class="list-inline-item trac-btn">
                                <a href="<?php echo base_url() ?>track-order">Track Your Order</a>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php
                    if ($this->session->userdata('user_state') == 'wholesale') {
                        echo '<Marquee direction="left">You are browsing shop as a wholesale user. Prices are cheaper here. </Marquee>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Menu Area -->