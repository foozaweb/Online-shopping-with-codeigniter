<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $title; ?></title>

    <meta name="author" content="<?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?> - <?php echo $product['meta_title'] ?>">
    <meta name="keywords" content="<?php echo $product['meta_keyword'] ?>" />
    <meta name="description" content="<?php echo $product['meta_description'] ?>" />

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/bootstrap.min.css">

    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/font-awesome.min.css">

    <!-- Animate Css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/animate.css">

    <!-- Owl Slider -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/owl.carousel.min.css">

    <!-- Custom Style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/style.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/assets/responsive.css">

    <!-- Rate Box -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>rate/rate.css">
    <script src="<?php echo base_url() ?>rate/rate.js"></script>
    <!-- Rate Box -->


    <meta property="og:title" content="<?php echo $product['meta_title'] ?>" />
    <meta property="og:image" content="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" />
    <meta property="og:url" content="<?php echo base_url() ?>product/<?php echo $product['productId'] ?>" />
    <meta property="og:site_name" content="<?php echo $this->db->get('chb_settings')->row_array()['sitename']; ?>" />
    <meta property="og:description" content="<?php echo $product['meta_description'] ?>" />
    <meta name="twitter:title" content="<?php echo $product['meta_title'] ?>" />
    <meta name="twitter:image" content="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" />
    <meta name="twitter:url" content="<?php echo base_url() ?>product/<?php echo $product['productId'] ?>" />
    <meta name="twitter:card" content="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" />
</head>

<?php $this->load->view('template/nav2'); ?>
<?php $this->load->view('template/functions'); ?>

<!-- Breadcrumb Area -->
<section class="breadcrumb-area"> </section>
<!-- End Breadcrumb Area -->







<!-- Single Product Area -->
<section class="sg-product">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-5">
                        <div class="sg-img">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="sg9" role="tabpanel">
                                    <img src="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" alt="" class="img-fluid">
                                </div>
                                <?php
                                $tags = explode(',', $product['productImages']);
                                for ($i = 0; $i < count($tags); $i++) {
                                ?>
                                    <div class="tab-pane" id="sg<?php echo $i; ?>" role="tabpanel">
                                        <img src="<?php echo $admin_url ?>/assets/images/<?php echo str_replace(' ', '', $tags[$i]); ?>" alt="" class="img-fluid">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="nav d-flex justify-content-between">
                                <a class="nav-item nav-link active" data-toggle="tab" href="#sg9"><img src="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" alt=""></a>

                                <?php
                                $tags = explode(',', $product['productImages']);
                                for ($i = 0; $i < count($tags); $i++) {
                                ?>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#sg<?php echo $i; ?>"><img src="<?php echo $admin_url ?>/assets/images/<?php echo str_replace(' ', '', $tags[$i]); ?>" alt=""></a>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="sg-content">
                            <div class="pro-tag">
                                <ul class="list-unstyled list-inline">
                                    <li class="list-inline-item"><a href="<?php echo base_url() ?>brand/<?php echo $product['productBrand'] ?>"><?php echo $product['productBrand'] ?>,</a></li>
                                    <li class="list-inline-item"><a href="<?php echo base_url() ?>ct/<?php echo $product['category'] ?>"><?php echo $product['category'] ?></a></li>
                                </ul>
                            </div>
                            <div class="pro-name">
                                <p><?php echo $product['product_name'] ?></p>
                            </div>
                            <div class="pro-rating">
                                <?php
                                $this->db->select_sum('rating');
                                $sum_rating = $this->db->get_where('chb_rating', array('product_id' => $product['productId']))->row_array();

                                $tRaring = round($sum_rating['rating'] / 100 * 5);
                                ?>
                                <div id="generalRating"></div>
                                <script>
                                    $("#generalRating").rate({
                                        length: 5,
                                        value: <?php echo $tRaring ?>,
                                        readonly: true,
                                        size: '14px',
                                        selectClass: 'fxss_rate_select',
                                        incompleteClass: 'fxss_rate_no_all_select',
                                        customClass: 'custom_class',
                                        callback: function(object) {
                                            console.log(object.index);
                                        }
                                    });
                                </script>
                            </div>
                            <div class="pro-price">
                                <ul class="list-unstyled list-inline">
                                    <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($product[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</li>
                                    <li class="list-inline-item"></li>
                                </ul>
                                <p>Availability :
                                    <?php if ($product['quantity'] < 1) { ?>
                                        <span class="text-danger">Out of Stock</span>
                                    <?php } else { ?>
                                        <span class="text-success">In Stock</span>
                                    <?php } ?>

                                    <label>(<?php echo $product['quantity'] ?> Pieces Available)</label>
                                </p>
                            </div>
                            <div class="colo-siz">
                                <div class="color">
                                    <ul class="list-unstyled list-inline">
                                        <li>Color :</li>
                                        <span class="colorWrapper">
                                            <?php
                                            $tags = explode(',', $product['color']);
                                            for ($i = 0; $i < count($tags); $i++) {
                                            ?>
                                                <li class="list-inline-item">
                                                    <input class="singleColor" type="radio" id="color-<?php echo $i; ?>" name="color" value="<?php echo str_replace(' ', '', $tags[$i]); ?>">
                                                    <label for="color-<?php echo $i; ?>"><span style="background-color: <?php echo str_replace(' ', '', $tags[$i]); ?>;"><i class="fa fa-check"></i></span></label>
                                                </li>
                                            <?php } ?>
                                        </span>

                                    </ul>
                                </div>
                                <div class="size">
                                    <ul class="list-unstyled list-inline">
                                        <li>Size :</li>


                                        <?php
                                        $tags = explode(',', $product['product_size']);
                                        for ($i = 0; $i < count($tags); $i++) {
                                        ?>
                                            <li class="list-inline-item">
                                                <input class="singleSize" type="radio" id="size-<?php echo $i; ?>" name="size" value="<?php echo str_replace(' ', '', $tags[$i]); ?>">
                                                <label for="size-<?php echo $i; ?>"><?php echo str_replace(' ', '', $tags[$i]); ?></label>
                                            </li>
                                        <?php } ?>

                                    </ul>
                                </div>
                                <div class="qty-box">
                                    <ul class="list-unstyled list-inline">
                                        <li class="list-inline-item">Qty :</li>
                                        <li class="list-inline-item quantity buttons_added">
                                            <input type="button" value="-" class="minus">
                                            <input type="number" step="1" min="1" max="<?php echo $product['quantity'] ?>" value="1" class="qty text singleQty" size="4" readonly>
                                            <input type="button" value="+" class="plus">
                                        </li>
                                    </ul>
                                </div>


                                <div class="pro-btns myOrderSettings">
                                    <?php if (!is_null($this->session->userdata('chbUserAuth'))) { ?>
                                        <?php if ($product['quantity'] < 1) { ?>
                                            <a href="javascript:void(0);" title="This Product is out of stock" data-placement="top" data-toggle="tooltip" class="cart"><i class="fa fa-shopping-cart"></i> Out of Stock</a>
                                        <?php } else { ?>
                                            <a href="javascript:void(0);" data-id="<?php echo $product['productId'] ?>" class="addToCart cart"><i class="fa fa-shopping-cart"></i> Add To Cart</a>
                                        <?php } ?>


                                        <a href="javascript:void(0);" data-id="<?php echo $product['productId'] ?>" class="addToWishlist fav-com" data-toggle="tooltip" data-placement="top" title="Wishlist"><img src="<?php echo base_url() ?>images/it-fav.png" alt=""></a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url() ?>login" class="cart">Login to shop</a>
                                    <?php } ?>
                                    <a href="<?php echo base_url() ?>compare/<?php echo $product['productId'] ?>" class="fav-com" data-toggle="tooltip" data-placement="top" title="Compare"><img src="<?php echo base_url() ?>images/it-comp.png" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="sg-tab">

                            <?php
                            $rev = $this->db->get_where('chb_review', array('chb_review.product_id' => $product['productId']));
                            $reviews = $rev->result_array();
                            $totalReviews = $rev->num_rows();
                            ?>

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#pro-det">Product Details</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#rev">Reviews (<?php echo $totalReviews ?>)</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="pro-det" role="tabpanel">
                                    <?php echo $product['productDesc']; ?>
                                </div>
                                <div class="tab-pane fade" id="rev" role="tabpanel">


                                    <?php
                                    $index = 0;
                                    foreach ($reviews as $review) {
                                        $index++; ?>
                                        <div class="review-box d-flex">
                                            <div class="rv-img">
                                                <img src="<?php echo base_url() ?>images/testimonial-1.jpg" alt="">
                                            </div>
                                            <div class="rv-content">
                                                <h6><?php echo $review['name'] ?> <span>(<?php echo $review['date'] ?>)</span></h6>
                                                <p><?php echo $review['review'] ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>




                                    <div class="review-form">
                                        <h6>Add Your Review</h6>
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="star-rating">
                                                        <label>Your Rating*</label>
                                                        <div id="rateBox"></div>
                                                        <script>
                                                            var cookieId = 'rate<?php echo $product['productId']; ?>';
                                                            var rateValue = '';
                                                            if (get_cookie(cookieId) != '') {
                                                                rateValue = get_cookie(cookieId);
                                                            } else {
                                                                rateValue = '3.5';
                                                            }
                                                            $("#rateBox").rate({
                                                                length: 5,
                                                                value: rateValue,
                                                                readonly: false,
                                                                size: '18px',
                                                                selectClass: 'fxss_rate_select',
                                                                incompleteClass: 'fxss_rate_no_all_select',
                                                                customClass: 'custom_class',
                                                                callback: function(object) {
                                                                    rateProduct(object.index);
                                                                }
                                                            });

                                                            function get_cookie(cname) {
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

                                                            function set_cookie(cname, cvalue, exdays) {
                                                                var d = new Date();
                                                                d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
                                                                var expires = "expires=" + d.toUTCString();
                                                                document.cookie = cname + "=" + cvalue + "; " + expires;
                                                            }
                                                        </script>
                                                        <input type="hidden" name="rateId" value="<?php echo $product['productId']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Your Name*</label>
                                                    <input type="text" name="rateName" required="">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Your Email*</label>
                                                    <input type="text" name="rateEmail" required="">
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Your Review*</label>
                                                    <textarea required="" name="rateReview"></textarea>
                                                    <button type="button" class="btnRate">Add Review</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>














                    <div class="col-md-12">
                        <div class="sim-pro">
                            <div class="sec-title">
                                <h5>Similar Product</h5>
                            </div>
                            <div class="sim-slider owl-carousel">
                                <?php foreach ($similar as $similar) { ?>
                                    <div class="sim-item">
                                        <div class="sim-img">
                                            <a href="<?php echo base_url() ?>product/<?php echo $similar['productId'] ?>"><img class="main-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $similar['main_photo'] ?>" alt=""></a>
                                            <?php
                                            $piece = '';
                                            $sImg = '';
                                            $piece = explode(',', $similar['productImages']);
                                            if (str_replace(' ', '', @$piece[0]) == $similar['main_photo'] && is_null(str_replace(' ', '', @$piece[1])) == false) {
                                                $sImg = str_replace(' ', '', @$piece[1]);
                                            } else {
                                                $sImg = str_replace(' ', '', @$piece[0]);
                                            }
                                            ?>
                                            <a href="<?php echo base_url() ?>product/<?php echo $similar['productId'] ?>"><img class="sec-img img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $sImg ?>" alt=""></a>
                                            <div class="layer-box">
                                                <a href="#" class="it-comp" data-toggle="tooltip" data-placement="left" title="Compare"><img src="<?php echo base_url() ?>images/it-comp.png" alt=""></a>
                                                <a href="#" class="it-fav" data-toggle="tooltip" data-placement="left" title="Favorite"><img src="<?php echo base_url() ?>images/it-fav.png" alt=""></a>
                                            </div>
                                        </div>
                                        <div class="sim-heading">
                                            <p><a href="<?php echo base_url() ?>product/<?php echo $similar['productId'] ?>"><?php echo word_limiter($similar['product_name'], 2); ?></a></p>
                                        </div>
                                        <div class="img-content d-flex justify-content-between">
                                            <div>
                                                <ul class="list-unstyled list-inline fav">
                                                    <?php
                                                    viewRating($similar['rating']);
                                                    ?>
                                                </ul>
                                                <ul class="list-unstyled list-inline price">
                                                    <li class="list-inline-item"><?php echo $this->session->userdata('ex_symbol') ?><?php echo number_format($similar[$this->session->userdata('price_variable')]/$this->session->userdata('ex_rate')); ?>.00</li>
                                                    <li class="list-inline-item"></li>
                                                </ul>
                                            </div>
                                            <div>
                                                <?php if ($similar['quantity'] < 1) { ?>
                                                    <a href="javascript:void(0);" title="This Product is out of stock" data-placement="top" data-toggle="tooltip" class="cart"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""></a>
                                                <?php } else { ?>
                                                    <a href="javascript:void(0);" data-id="<?php echo $similar['productId'] ?>" class="addToCart cart"><img src="<?php echo base_url() ?>images/it-cart.png" alt=""> </a>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
















            <div class="col-md-3">

                <?php $this->load->view('template/category'); ?>

                <div class="ht-offer">
                    <div class="sec-title">
                        <h6>Hot Offer</h6>
                    </div>
                    <div class="ht-body owl-carousel">

                        <?php
                        $this->db->join('chb_products', 'chb_products.productId = chb_promo.product_id', 'left');
                        $this->db->join('chb_rating', 'chb_rating.product_id = chb_promo.product_id', 'left');
                        $this->db->where('date >', date('d-m-Y'));
                        $promo = $this->db->get('chb_promo')->result_array();
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
                <div class="add-box">
                    <?php
                    $this->db->limit('1');
                    $this->db->order_by('id', 'random');
                    $this->db->where('display', '1');
                    $product = $this->db->get('chb_products')->row_array();
                    ?>
                    <a href="<?php echo base_url() ?>product/<?php echo $product['productId'] ?>">
                        <img class="img-fluid" src="<?php echo $admin_url ?>/assets/images/<?php echo $product['main_photo'] ?>" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Single Product Area -->

<!-- Footer Area -->
<?php $this->load->view('template/footer'); ?>


<script>
    function rateProduct(rate) {
        var id = $('[name="rateId"]').val();
        var rating = rate + 1;
        $.ajax({
            url: "<?php echo base_url() ?>cart/productRating",
            type: "post",
            dataType: "json",
            data: {
                rating: rating,
                id: id
            },
            success: function(data) {
                set_cookie('rate' + id, rating, 365)
                alertMe('Thank you', 5000);
            },
            error: function() {
                alertMe('Failed', 5000);
            }
        });
    }

    $('.btnRate').on('click', function() {
        var id = $('[name="rateId"]').val();
        var name = $('[name="rateName"]').val();
        var email = $('[name="rateEmail"]').val();
        var review = $('[name="rateReview"]').val();
        $.ajax({
            url: "<?php echo base_url() ?>cart/newUserReview",
            type: "post",
            dataType: "json",
            data: {
                name: name,
                email: email,
                review: review,
                id: id
            },
            success: function(data) {
                $('[name="rateName"]').val('');
                $('[name="rateEmail"]').val('');
                $('[name="rateReview"]').val('');
                alertMe('Thank you', 5000);
            },
            error: function() {
                alertMe('Failed', 5000);
            }
        });
    });
</script>