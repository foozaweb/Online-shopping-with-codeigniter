<?php $this->load->view('template/header') ?>
<?php $this->load->view('template/nav2'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->

<!-- Category Area -->
<section class="category">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="product-box">
                    <div class="cat-box d-flex justify-content-between">
                        <!-- Nav tabs -->
                        <div class="view">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#grid"><i class="fa fa-th-large"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#list"><i class="fa fa-th-list"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="sortby">
                            <span>Sort By</span>
                            <select class="sort-box" name="sortShop">
                                <option value="date_created" <?php if ($this->session->userdata('sortShop') == 'date_created') {
                                                                    echo 'selected disabled';
                                                                } ?>>Date
                                </option>
                                <option value="product_name" <?php if ($this->session->userdata('sortShop') == 'product_name') {
                                                                    echo 'selected disabled';
                                                                } ?>>Name
                                </option>
                                <option value="<?php $this->session->userdata('price_variable') ?>" <?php if ($this->session->userdata('sortShop') == $this->session->userdata('price_variable')) {
                                                                                                        echo 'selected disabled';
                                                                                                    } ?>>Price
                                </option>
                                <option value="rating" <?php if ($this->session->userdata('sortShop') == 'rating') {
                                                            echo 'selected disabled';
                                                        } ?>>Rating
                                </option>
                            </select>
                        </div>
                        <div class="show-item">
                            <span>Show</span>
                            <select class="show-box" name="perPage">
                                <option value="12" <?php if ($this->session->userdata('perPage') == '12') {
                                                        echo 'selected disabled';
                                                    } ?>>12</option>
                                <option value="24" <?php if ($this->session->userdata('perPage') == '24') {
                                                        echo 'selected disabled';
                                                    } ?>>24</option>
                                <option value="36" <?php if ($this->session->userdata('perPage') == '36') {
                                                        echo 'selected disabled';
                                                    } ?>>36</option>
                                <option value="48" <?php if ($this->session->userdata('perPage') == '48') {
                                                        echo 'selected disabled';
                                                    } ?>>48</option>
                                <option value="60" <?php if ($this->session->userdata('perPage') == '60') {
                                                        echo 'selected disabled';
                                                    } ?>>60</option>
                            </select>
                        </div>
                        <div class="page">
                            <p>Page <?php echo count($shops) ?> of <?php echo shortNumber($totalRows); ?></p>
                        </div>
                    </div>






                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active myOrderSettings" id="grid" role="tabpanel">
                            <div class="row">



                                <!-- GRID -->
                                <?php
                                foreach ($shops as $shop) { ?>
                                    <div class="col-lg-3 col-6">
                                        <div class="tab-item">
                                            <div class="tab-img">
                                                <a href="<?php echo base_url() ?>product/<?php echo $shop['productId'] ?>"><img class="main-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $shop['main_photo'] ?>" alt=""></a>
                                                <?php
                                                $secImg = '';
                                                $slices = explode(',', $shop['productImages']);
                                                if (@$slices[0] == $shop['main_photo'] && @$slices[1] != "") {
                                                    $secImg = str_replace(' ', '', @$slices[1]);
                                                } else {
                                                    $secImg = str_replace(' ', '', @$slices[0]);
                                                }
                                                ?>
                                                <a href="<?php echo base_url() ?>product/<?php echo $shop['productId'] ?>"><img class="sec-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $secImg ?>" alt=""></a>
                                                <div class="layer-box">
                                                    <a href="<?php echo base_url() ?>compare/<?php echo $shop['productId'] ?>" class="it-comp" data-toggle="tooltip" data-placement="left" title="Compare"><img src="<?php echo base_url() ?>images/it-comp.png" alt=""></a>

                                                    <a href="javascript:void(0);" data-id="<?php echo $shop['productId'] ?>" class="addToWishlist it-fav" data-toggle="tooltip" data-placement="left" title="Favorite"><img src="<?php echo base_url() ?>images/it-fav.png" alt=""></a>
                                                </div>
                                            </div>
                                            <div class="tab-heading">
                                                <p><a href="<?php echo base_url() ?>product/<?php echo $shop['productId'] ?>"><?php echo word_limiter($shop['product_name'], 3) ?> </a></p>
                                            </div>
                                            <div class="img-content d-flex justify-content-between">
                                                <div>
                                                    <ul class="list-unstyled list-inline fav">
                                                        <?php
                                                        viewRating($shop['rating']);
                                                        ?>
                                                    </ul>
                                                    
                                                    <ul class="list-unstyled list-inline price">
                                                        <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($shop[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</li>
                                                        <li class="list-inline-item"></li>
                                                    </ul>
                                                </div>
                                                <div>
                                                    <?php if ($shop['quantity'] > 0) { ?>
                                                        <a href="javascript:void(0);" data-id="<?php echo $shop['productId'] ?>" class="addToCart" data-toggle="tooltip" data-placement="top" title="Add to Cart"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                    <?php } else { ?>
                                                        <a href="javascript:void(0);" class="" data-toggle="tooltip" data-placement="top" title="This Item is out of Stock"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- ./GRID -->

                            </div>
                        </div>










                        <div class="tab-pane fade myOrderSettings" id="list" role="tabpanel">
                            <div class="row">

                                <!-- LIST -->
                                <?php
                                foreach ($shops as $shop) { ?>
                                    <div class="col-lg-12 col-md-6">
                                        <div class="tab-item2">
                                            <div class="row">
                                                <div class="col-lg-4 col-md-12">
                                                    <div class="tab-img">
                                                        <img class="main-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $shop['main_photo'] ?>" alt="">
                                                        <?php
                                                        $secImg = '';
                                                        $slices = explode(',', $shop['productImages']);
                                                        if (@$slices[0] == $shop['main_photo'] && @$slices[1] != "") {
                                                            $secImg = str_replace(' ', '', @$slices[1]);
                                                        } else {
                                                            $secImg = str_replace(' ', '', @$slices[0]);
                                                        }
                                                        ?>
                                                        <img class="sec-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $secImg ?>" alt="">
                                                        <?php if ($shop['discount']) {
                                                            echo '<span class="sale">-' . $shop['discount'] . '% 
                                                            </span>';
                                                        } ?>

                                                    </div>
                                                </div>
                                                <div class="col-lg-8 col-md-12">
                                                    <div class="item-heading d-flex justify-content-between">
                                                        <div class="item-top">
                                                            <ul class="list-unstyled list-inline cate">
                                                                <li class="list-inline-item"><a href="<?php echo base_url() ?>brand/<?php echo $shop['productBrand']; ?>"><?php echo str_replace('-', ' ', $shop['productBrand']) ?>,</a></li>
                                                                <li class="list-inline-item"><a href="<?php echo base_url() ?>ct/<?php echo $shop['category'] ?>"><?php echo str_replace('-', ' ', $shop['category']); ?></a></li>
                                                            </ul>
                                                            <p><a href="<?php echo base_url() ?>product/<?php echo $shop['productId'] ?>"><?php echo word_limiter($shop['product_name'], 3) ?> </a></p>
                                                            <ul class="list-unstyled list-inline fav">
                                                                <?php
                                                                viewRating($shop['rating']);
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="item-price">
                                                            <ul class="list-unstyled list-inline price">
                                                                <li class="list-inline-item"> <?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($shop[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</li>
                                                                <li class="list-inline-item"></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="item-content">
                                                        <p><?php echo word_limiter($shop['productDesc'], 30) ?></p>

                                                        <a href="javascript:void(0);" data-id="<?php echo $shop['productId'] ?>" class="it-cart addToCart"><span class="it-img"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></span><span class="it-title">Add To Cart</span></a>


                                                        <a href="javascript:void(0);" data-id="<?php echo $shop['productId'] ?>" class="addToWishlist it-fav" data-toggle="tooltip" data-placement="top" title="Favorite"><img src="<?php echo base_url() ?>images/it-fav.png" alt=""></a>

                                                        <a href="<?php echo base_url() ?>compare/<?php echo $shop['productId'] ?>" class="it-comp" data-toggle="tooltip" data-placement="top" title="Compare"><img src="<?php echo base_url() ?>images/it-comp.png" alt=""></a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>


                                <!-- ./LIST -->






                            </div>
                        </div>
                    </div>
                    <div class="pagination-box text-center">
                        <?php echo $pages; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category Area -->


<!-- Footer Area -->
<?php $this->load->view('template/footer') ?>