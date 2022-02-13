<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav'); ?>
<!-- Slider Area -->
<section class="slider-area">
    <div class="container-fluid">
        <div class="row">


            <div class="col-lg-3 col-md-0">
                <div class="menu-widget">
                    <p><i class="fa fa-bars"></i>All Categories</p>
                    <ul class="list-unstyled height468">
                        <?php
                        echo $home_categories;
                        ?>
                    </ul>
                </div>
            </div>




            <div class="col-lg-9 col-md-12 padding-fix-l20">
                <img src="<?php echo $this->db->get('chb_settings')->row_array()['banner'] ?>" class="img-fluid">
            </div>







            <?php if ($this->session->flashdata('alert_success')) :
                echo '<p class="alert alert-success" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_success') . '</p>'; ?>
            <?php endif; ?>

            <?php if ($this->session->flashdata('alert_danger')) :
                echo '<p class="alert alert-danger" style="text-align:center;"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $this->session->flashdata('alert_danger') . '</p>'; ?>
            <?php endif; ?>




        </div>
    </div>
</section>
<!-- End Slider Area -->














<!-- Product Area-->
<section class="product-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bt-deal">
                            <div class="sec-title">
                                <h6>Best Deals</h6>
                            </div>
                            <div class="bt-body owl-carousel">

                                <?php
                                $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                                $this->db->limit(rand(16, 20));
                                $this->db->where('chb_products.discount >', '0');
                                $this->db->where('chb_products.display >', '1');
                                $bestDeal = $this->db->get('chb_products')->result_array();
                                rsort($bestDeal);
                                foreach ($bestDeal as $tr) {  ?>
                                    <div class="bt-items">

                                        <?php
                                        $this->db->join('chb_products', 'chb_products.productId = chb_rating.product_id', 'left');
                                        $this->db->group_by('chb_rating.product_id');
                                        $this->db->limit('6');
                                        $this->db->where('chb_products.category', $tr['category']);
                                        $this->db->where('chb_products.discount >', '0');
                                        $sim = $this->db->get('chb_rating')->result_array();
                                        foreach ($sim as $sim) {  ?>

                                            <div class="bt-box d-flex">
                                                <div class="bt-img">
                                                    <a href="<?php echo base_url() ?>product/<?php echo $sim['productId'] ?>"><img class="main-img img-fluid max_h100" src="<?php echo $admin_url ?>/assets/images/<?php echo $sim['main_photo'] ?>" alt=""></a>
                                                </div>
                                                <div class="bt-content">
                                                    <p><a href="<?php echo base_url() ?>product/<?php echo $sim['productId'] ?>"><?php echo word_limiter($sim['product_name'], 3) ?> </a></p>
                                                    <ul class="list-unstyled list-inline fav">
                                                        <?php
                                                        viewRating($sim['rating']);
                                                        ?>
                                                    </ul>
                                                    <ul class="list-unstyled list-inline price">
                                                        <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($sim[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')) ?>.00</li>
                                                        <li class="list-inline-item"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>




                    <?php
                    $this->db->join('chb_products', 'chb_products.productId = chb_promo.product_id', 'left');
                    $this->db->join('chb_rating', 'chb_rating.product_id = chb_promo.product_id', 'left');
                    $this->db->where('chb_promo.date >', date('d-m-Y'));
                    $promo = $this->db->get('chb_promo')->result_array();
                    if ($promo) {
                    ?>
                        <div class="col-md-12">
                            <div class="ht-offer">
                                <div class="sec-title">
                                    <div id="getting-started"></div>
                                    <h6>Hot Offer</h6>
                                </div>
                                <div class="ht-body owl-carousel">

                                    <?php
                                    foreach ($promo as $p) { ?>
                                        <div class="ht-item">
                                            <div class="ht-img">
                                                <a href="<?php echo base_url() ?>product/<?php echo $p['productId'] ?>"><img class="img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $p['main_photo'] ?>" alt=""></a>
                                                <span>- <?php echo $p['discount'] ?>%</span>
                                                <ul class="list-unstyled list-inline counter-box myCounterBox" data-date="<?php echo $p['date'] ?>">
                                                </ul>
                                            </div>
                                            <div class="ht-content">
                                                <p><a href="<?php echo base_url() ?>product/<?php echo $p['productId'] ?>"><?php echo word_limiter($p['product_name'], 3) ?> </a></p>
                                                <ul class="list-unstyled list-inline fav">
                                                    <?php
                                                    viewRating($p['rating']);
                                                    ?>

                                                </ul>
                                                <ul class="list-unstyled list-inline price">
                                                    <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($p[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')) ?>.00</li>
                                                    <li class="list-inline-item"></li>
                                                </ul>
                                            </div>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>



                    <div class="col-md-12">
                        <div class="top-rtd">
                            <div class="sec-title">
                                <h6>Top Rated</h6>
                            </div>
                            <div class="rt-slider owl-carousel">
                                <?php
                                $this->db->join('chb_products', 'chb_products.productId = chb_rating.product_id', 'left');
                                $this->db->limit(rand(16, 20));
                                $this->db->group_by('chb_rating.product_id');
                                $topRated = $this->db->get('chb_rating')->result_array();
                                rsort($topRated);
                                $reduction = 6;
                                foreach ($topRated as $tr) {
                                    $reduction--; ?>
                                    <div class="rt-items">
                                        <?php
                                        $this->db->join('chb_products', 'chb_products.productId = chb_rating.product_id', 'left');
                                        $this->db->group_by('chb_rating.product_id');
                                        $this->db->limit('4');
                                        $this->db->where('chb_products.display', '1');
                                        $this->db->where(array('chb_rating.rating' => $reduction));
                                        $sim = $this->db->get('chb_rating')->result_array();
                                        foreach ($sim as $sim) {  ?>
                                            <div class="rt-box d-flex">
                                                <div class="rt-img">
                                                    <a href="<?php echo base_url() ?>product/<?php echo $sim['productId'] ?>"><img class="main-img img-fluid max_h100" src="<?php echo $admin_url ?>/assets/images/<?php echo $sim['main_photo'] ?>" alt=""></a>
                                                </div>
                                                <div class="rt-content">
                                                    <p><a href="<?php echo base_url() ?>product/<?php echo $sim['productId'] ?>"><?php echo word_limiter($sim['product_name'], 3) ?> </a></p>
                                                    <ul class="list-unstyled list-inline fav">
                                                        <?php
                                                        viewRating($sim['rating']);
                                                        ?>

                                                    </ul>
                                                    <ul class="list-unstyled list-inline price">
                                                        <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($sim[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')) ?>.00</li>
                                                        <li class="list-inline-item"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- End single product -->
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                                <!-- End grouped lists here -->

                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="nw-ltr">
                            <div class="sec-title">
                                <h6>Newsletter</h6>
                            </div>
                            <div class="nw-box">
                                <p>Sign Up And Get Latest News, Updates, Offers & Deals</p>
                                <form class="nw-form" action="#">
                                    <input type="text" name="email" placeholder="Email Here..." required>
                                    <button type="submit" name="button">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>












            <div class="col-lg-9 col-md-8">
                <div class="row">
                    <div class="col-md-12 padding-fix-l20">
                        <div class="ftr-product">
                            <div class="tab-box d-flex justify-content-between">
                                <div class="sec-title">
                                    <h5>Featured Product</h5>
                                </div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php
                                    $this->db->limit('5');
                                    $this->db->order_by('id', 'desc');
                                    $this->db->group_by('category');
                                    $this->db->where('display', '1');
                                    $catHeader = $this->db->get('chb_products')->result_array();
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#all">All</a>
                                    </li>
                                    <?php foreach ($catHeader as $ch) {
                                        $count = $this->db->get_where('chb_products', array('category' => $ch['category']))->num_rows();
                                    ?>
                                        <li class="nav-item">
                                            <a class="nav-link" title="<?php echo shortNumber($count); ?>+ Items" data-toggle="tab" href="#<?php echo $ch['category'] ?>"><?php echo str_replace('-', ' ', ucfirst($ch['category'])); ?></a>
                                        </li>
                                    <?php }  ?>

                                </ul>
                            </div>
                            <!-- Tab panes -->
                            <?php
                            $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                            $this->db->order_by('chb_products.id', 'random');
                            $this->db->group_by('chb_products.productId');
                            $this->db->where('chb_products.display', '1');
                            $result = $this->db->get('chb_products');
                            $all_prod = $result->result_array();
                            $cat_prod = $result->result_array();
                            ?>

                            <div class="tab-content myOrderSettings">
                                <div class="tab-pane fade show active" id="all" role="tabpanel">
                                    <div class="tab-slider owl-carousel">
                                        <?php
                                        $counter = rand(10, 30);
                                        $index = 0;
                                        foreach ($all_prod as $all_prod) {
                                            $index++; ?>
                                            <div class="tab-item">
                                                <div class="tab-heading">
                                                    <ul class="list-unstyled list-inline">
                                                        <li class="list-inline-item"><a href="<?php echo base_url() ?>brand/<?php echo $all_prod['productBrand']; ?>"><?php echo str_replace('-', ' ', $all_prod['productBrand']) ?>,</a></li>
                                                        <li class="list-inline-item"><a href="<?php echo base_url() ?>ct/<?php echo $all_prod['category'] ?>"><?php echo str_replace('-', ' ', $all_prod['category']); ?></a></li>
                                                    </ul>
                                                    <p>
                                                        <a href="<?php echo base_url() ?>product/<?php echo $all_prod['productId'] ?>">
                                                            <?php echo word_limiter($all_prod['product_name'], 3) ?> </a>
                                                    </p>
                                                </div>
                                                <div class="tab-img">
                                                    <a href="<?php echo base_url() ?>product/<?php echo $all_prod['productId'] ?>">
                                                        <img class="main-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $all_prod['main_photo'] ?>" alt="">
                                                    </a>
                                                    <?php
                                                    $secImg = '';
                                                    $slices = explode(',', $all_prod['productImages']);
                                                    if (@$slices[0] == $all_prod['main_photo'] && @$slices[1] != "") {
                                                        $secImg = str_replace(' ', '', @$slices[1]);
                                                    } else {
                                                        $secImg = str_replace(' ', '', @$slices[0]);
                                                    }
                                                    ?>
                                                    <a href="<?php echo base_url() ?>product/<?php echo $all_prod['productId'] ?>">
                                                        <img class="sec-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $secImg ?>" alt="">
                                                    </a>
                                                    <div class="layer-box">
                                                        <a href="<?php echo base_url() ?>compare/<?php echo $all_prod['productId'] ?>" class="it-comp" data-toggle="tooltip" data-placement="left" title="Compare"><img src="<?php echo base_url() ?>images/it-comp.png" alt=""></a>

                                                        <a href="javascript:void(0);" data-id="<?php echo $all_prod['productId'] ?>" class="addToWishlist it-fav" data-toggle="tooltip" data-placement="left" title="Favorite"><img src="<?php echo base_url() ?>images/it-fav.png" alt=""></a>
                                                    </div>
                                                </div>
                                                <div class="img-content d-flex justify-content-between">
                                                    <div>
                                                        <ul class="list-unstyled list-inline fav">
                                                            <?php
                                                            viewRating($all_prod['rating']);
                                                            ?>

                                                        </ul>
                                                        <ul class="list-unstyled list-inline price">
                                                            <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($all_prod[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</li>
                                                            <li class="list-inline-item"> </li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <?php if ($all_prod['quantity'] < 1) { ?>
                                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="This Product is out of stock"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                        <?php } else { ?>
                                                            <a href="javascript:void(0);" data-id="<?php echo $all_prod['productId'] ?>" class="addToCart" data-toggle="tooltip" data-placement="top" title="Add to Cart"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                        <?php } ?>


                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            if ($index == rand(10, 20)) {
                                                break;
                                            }
                                        } ?>
                                    </div>
                                </div>



                                <?php
                                $a = '';
                                foreach ($cat_prod as $cat_prod) {
                                    $a++; ?>
                                    <div class="tab-pane fade" id="<?php echo $cat_prod['category']; ?>" role="tabpanel">
                                        <div class="tab-slider owl-carousel">
                                            <?php
                                            $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                                            $thisCategory = $this->db->get_where('chb_products', array('category' => $cat_prod['category']))->result_array();
                                            foreach ($thisCategory as $ca) { ?>
                                                <div class="tab-item">
                                                    <div class="tab-heading">
                                                        <ul class="list-unstyled list-inline">
                                                            <li class="list-inline-item"><a href="<?php echo base_url() ?>brand/<?php echo $ca['productBrand'] ?>"><?php echo str_replace('-', ' ', $ca['productBrand']) ?>,</a></li>
                                                            <li class="list-inline-item"><a href="<?php echo base_url() ?>ct/<?php echo $ca['category'] ?>"><?php echo $ca['category'] ?></a></li>
                                                        </ul>
                                                        <p><a href="<?php echo base_url() ?>product/<?php echo $ca['productId'] ?>"><?php echo word_limiter(str_replace('-', ' ', $ca['product_name']), 2) ?></a></p>
                                                    </div>
                                                    <div class="tab-img">
                                                        <a href="<?php echo base_url() ?>product/<?php echo $ca['productId'] ?>">
                                                            <img class="main-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $ca['main_photo'] ?>" alt="">
                                                        </a>
                                                        <?php
                                                        $sImg = '';
                                                        $piece = explode(',', $ca['productImages']);
                                                        if (@$piece[0] == $ca['main_photo'] && @$piece[1] != "") {
                                                            $sImg = str_replace(' ', '', @$piece[1]);
                                                        } else {
                                                            $sImg = str_replace(' ', '', @$piece[0]);
                                                        }
                                                        ?>
                                                        <a href="<?php echo base_url() ?>product/<?php echo $ca['productId'] ?>">
                                                            <img class="sec-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $sImg ?>" alt="">
                                                        </a>
                                                        <div class="layer-box">
                                                            <a href="<?php echo base_url() ?>compare/<?php echo $ca['productId'] ?>" class="it-comp" data-toggle="tooltip" data-placement="left" title="Compare"><img src="<?php echo base_url() ?>images/it-comp.png" alt=""></a>

                                                            <a href="javascript:void(0);" data-id="<?php echo $ca['productId'] ?>" class="addToWishlist it-fav" data-toggle="tooltip" data-placement="left" title="Favorite"><img src="<?php echo base_url() ?>images/it-fav.png" alt=""></a>
                                                        </div>
                                                    </div>
                                                    <div class="img-content d-flex justify-content-between">
                                                        <div>
                                                            <ul class="list-unstyled list-inline fav">
                                                                <?php
                                                                viewRating($ca['rating']);
                                                                ?>
                                                            </ul>
                                                            <ul class="list-unstyled list-inline price">
                                                                <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($ca[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</li>
                                                                <li class="list-inline-item"> </li>
                                                            </ul>
                                                        </div>
                                                        <div>
                                                            <?php if ($ca['quantity'] < 1) { ?>
                                                                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="This Product is out of stock."><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                            <?php } else { ?>
                                                                <a href="javascript:void(0);" data-id="<?php echo $ca['productId'] ?>" class="addToCart" data-toggle="tooltip" data-placement="top" title="Add to Cart"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                            <?php } ?>


                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                if ($a == rand(10, 20)) {
                                                    break;
                                                }
                                            }  ?>
                                        </div>
                                    </div>
                                <?php } ?>




                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-12 padding-fix-l20">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="banner">
                                    <a href="#"><img src="<?php //echo base_url() 
                                                            ?>images/banner-1.png" alt="" class="img-fluid"></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="banner">
                                    <a href="#"><img src="<?php //echo base_url() 
                                                            ?>images/banner-2.png" alt="" class="img-fluid"></a>
                                </div>
                            </div>
                        </div>
                    </div> -->















                    <div class="col-md-12 padding-fix-l20">
                        <div class="new-product">
                            <div class="sec-title">
                                <h5>New Product</h5>
                            </div>
                            <div class="new-slider owl-carousel myOrderSettings">

                                <?php
                                $counts = '';
                                $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                                $this->db->order_by('chb_products.id', 'desc');
                                $this->db->group_by('chb_products.productId');
                                $this->db->where('chb_products.display', '1');
                                $result = $this->db->get('chb_products')->result_array();
                                foreach ($result as $res) {
                                    $counts++; ?>
                                    <div class="new-item">

                                        <div class="tab-heading">
                                            <ul class="list-unstyled list-inline">
                                                <li class="list-inline-item"><a href="<?php echo base_url() ?>brand/<?php echo $res['productBrand'] ?>"><?php echo str_replace('-', ' ', $res['productBrand']) ?>,</a></li>
                                                <li class="list-inline-item"><a href="<?php echo base_url() ?>ct/<?php echo $res['category'] ?>"><?php echo str_replace('-', ' ', $res['category']) ?></a></li>
                                            </ul>
                                            <p><a href="<?php echo base_url() ?>product/<?php echo $res['productId'] ?>"><?php echo word_limiter($res['product_name'], 3) ?></a></p>
                                        </div>

                                        <div class="new-img">
                                            <a href="<?php echo base_url() ?>product/<?php echo $res['productId'] ?>">
                                                <img class="main-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $res['main_photo'] ?>" alt="">
                                            </a>
                                            <?php
                                            $piece = '';
                                            $sImg = '';
                                            $piece = explode(',', $res['productImages']);
                                            if (str_replace(' ', '', @$piece[0]) == $res['main_photo'] &&  is_null(str_replace(' ', '', @$piece[1])) == false) {
                                                $sImg = str_replace(' ', '', @$piece[1]);
                                            } else {
                                                $sImg = str_replace(' ', '', @$piece[0]);
                                            }
                                            ?>
                                            <a href="<?php echo base_url() ?>product/<?php echo $res['productId'] ?>">
                                                <img class="sec-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $sImg ?>" alt="">
                                            </a>
                                            <div class="layer-box">
                                                <a href="<?php echo base_url() ?>compare/<?php echo $res['productId'] ?>" class="it-comp" data-toggle="tooltip" data-placement="left" title="Compare"><img src="<?php echo base_url() ?>images/it-comp.png" alt=""></a>

                                                <a href="javascript:void(0);" data-id="<?php echo $res['productId'] ?>" class="addToWishlist it-fav" data-toggle="tooltip" data-placement="left" title="Favorite"><img src="<?php echo base_url() ?>images/it-fav.png" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="img-content d-flex justify-content-between">
                                            <div>
                                                <ul class="list-unstyled list-inline fav">
                                                    <?php
                                                    viewRating($res['rating']);
                                                    ?>

                                                </ul>
                                                <ul class="list-unstyled list-inline price">
                                                    <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($res[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</li>
                                                    <li class="list-inline-item"> </li>
                                                </ul>
                                            </div>
                                            <div>
                                                <?php if ($res['quantity'] < 1) { ?>
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="This Product is out of stock."><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0);" data-id="<?php echo $res['productId'] ?>" class="addToCart" data-toggle="tooltip" data-placement="top" title="Add to Cart"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>


                                <?php
                                    if ($counts == rand(10, 30)) {
                                        break;
                                    }
                                }  ?>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-12 padding-fix-l20">
                        <div class="banner-two">
                            <a href="#"><img src="<?php //echo base_url() 
                                                    ?>images/banner-3.png" alt="" class="img-fluid"></a>
                        </div>
                    </div> -->
                    <div class="col-md-12 padding-fix-l20">
                        <div class="top-slr">
                            <div class="sec-title">
                                <h5>Top Seller</h5>
                            </div>
                            <div class="slr-slider owl-carousel">


                                <?php
                                $this->db->join('chb_products', 'chb_products.productId = chb_order_count.product_id', 'left');
                                $this->db->limit(rand(20, 32));
                                $orders = $this->db->get('chb_order_count')->result_array();
                                rsort($orders);
                                foreach ($orders as $order) { ?>
                                    <div class="slr-items">
                                        <?php
                                        $this->db->join('chb_rating', 'chb_rating.product_id = chb_products.productId', 'left');
                                        $this->db->limit('16');
                                        $this->db->group_by('chb_products.productId');
                                        $this->db->where('chb_products.productBrand', $order['productBrand']);
                                        $this->db->where('chb_products.display', '1');
                                        $orderings = $this->db->get('chb_products')->result_array();
                                        foreach ($orderings as $ordering) {  ?>
                                            <div class="slr-box d-flex">
                                                <div class="slr-img">
                                                    <a href="<?php echo base_url() ?>product/<?php echo $ordering['productId'] ?>"><img class="main-img img-fluid max_h100" src="<?php echo $admin_url ?>/assets/images/<?php echo $ordering['main_photo'] ?>" alt=""></a>
                                                </div>
                                                <div class="slr-content">
                                                    <p><a href="<?php echo base_url() ?>product/<?php echo $ordering['productId'] ?>"><?php echo word_limiter($ordering['product_name'], 3) ?> </a></p>
                                                    <ul class="list-unstyled list-inline fav">
                                                        <?php
                                                        viewRating($ordering['rating']);
                                                        ?>

                                                    </ul>
                                                    <ul class="list-unstyled list-inline price">
                                                        <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($ordering[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')) ?>.00</li>
                                                        <li class="list-inline-item"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>








                    <!-- <div class="col-md-12 padding-fix-l20">
                        <div class="hm-blog">
                            <div class="sec-title">
                                <h5>Latest News</h5>
                            </div>
                            <div class="blog-slider owl-carousel">
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <a href="#"><img src="<?php //echo base_url() 
                                                                ?>images/news-1.jpg" alt="" class="img-fluid"></a>
                                    </div>
                                    <div class="blog-content">
                                        <h6><a href="#">Sint eius inventore magni quod.</a></h6>
                                        <ul class="list-unstyled list-inline">
                                            <li class="list-inline-item"><i class="fa fa-user-o"></i><a href="#">John</a></li>
                                            <li class="list-inline-item"><i class="fa fa-calendar"></i>12 Feb, 2020</li>
                                        </ul>
                                        <p>Lorem ipsum dolor sit amet, consectet adipisicing elit. Delectus, expedita dolorum tenetur soluta...</p>
                                    </div>
                                </div>
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <a href="#"><img src="<?php //echo base_url() 
                                                                ?>images/news-2.jpg" alt="" class="img-fluid"></a>
                                    </div>
                                    <div class="blog-content">
                                        <h6><a href="#">Sint eius inventore magni quod.</a></h6>
                                        <ul class="list-unstyled list-inline">
                                            <li class="list-inline-item"><i class="fa fa-user-o"></i><a href="#">John</a></li>
                                            <li class="list-inline-item"><i class="fa fa-calendar"></i>12 Mar, 2020</li>
                                        </ul>
                                        <p>Lorem ipsum dolor sit amet, consectet adipisicing elit. Delectus, expedita dolorum tenetur soluta...</p>
                                    </div>
                                </div>
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <a href="#"><img src="<?php //echo base_url() 
                                                                ?>images/news-3.jpg" alt="" class="img-fluid"></a>
                                    </div>
                                    <div class="blog-content">
                                        <h6><a href="#">Sint eius inventore magni quod.</a></h6>
                                        <ul class="list-unstyled list-inline">
                                            <li class="list-inline-item"><i class="fa fa-user-o"></i><a href="#">John</a></li>
                                            <li class="list-inline-item"><i class="fa fa-calendar"></i>12 Jan, 2020</li>
                                        </ul>
                                        <p>Lorem ipsum dolor sit amet, consectet adipisicing elit. Delectus, expedita dolorum tenetur soluta...</p>
                                    </div>
                                </div>
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <a href="#"><img src="<?php //echo base_url() 
                                                                ?>images/news-4.jpg" alt="" class="img-fluid"></a>
                                    </div>
                                    <div class="blog-content">
                                        <h6><a href="#">Sint eius inventore magni quod.</a></h6>
                                        <ul class="list-unstyled list-inline">
                                            <li class="list-inline-item"><i class="fa fa-user-o"></i><a href="#">John</a></li>
                                            <li class="list-inline-item"><i class="fa fa-calendar"></i>12 Feb, 2020</li>
                                        </ul>
                                        <p>Lorem ipsum dolor sit amet, consectet adipisicing elit. Delectus, expedita dolorum tenetur soluta...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Product Area -->


<?php
$this->load->view('template/footer');
$this->load->view('template/updateSitemap');
?>