  <!-- Sticky Menu -->
  <section class="sticky-menu">
      <div class="container">
          <div class="row">
              <div class="col-lg-2 col-md-3">
                  <div class="sticky-logo">
                      <a href="<?php echo base_url() ?>"><img class="max_h50" src="<?php echo $this->db->get('chb_settings')->row_array()['logo']; ?>" alt="" class="img-fluid"></a>
                  </div>
              </div>
              <div class="col-lg-6 col-md-7">
                  <div class="main-menu">
                      <ul class="list-unstyled list-inline">
                          <li class="list-inline-item"><a>HOME <i class="fa fa-angle-down"></i></a>
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
                                                      <img src="<?php echo $admin_url ?>assets/images/<?php echo $q['main_photo']; ?>" alt="" class="img-fluid">
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
                                                              <img src="<?php echo $admin_url ?>assets/images/<?php echo $res['main_photo'] ?>" alt="">
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
                          <!-- <li class="list-inline-item"><a href="<?php //echo base_url() 
                                                                        ?>wholesale">WHOLESALE</a></li> -->
                          <!-- <li class="list-inline-item"><a>BLOG <i class="fa fa-angle-down"></i></a>
                              <ul class="dropdown list-unstyled">
                                  <li><a href="16-blog-one.html">Blog Style 1</a></li>
                                  <li><a href="17-blog-two.html">Blog Style 2</a></li>
                                  <li><a href="18-blog-three.html">Blog Style 3</a></li>
                                  <li><a href="19-blog-details.html">Blog Details</a></li>
                              </ul>
                          </li> -->
                      </ul>
                  </div>
              </div>
              <div class="col-lg-4 col-md-2">
                  <div class="carts-area d-flex">
                      <div class="src-box">
                          <form action="<?php echo base_url() ?>cart/find" method="POST">
                              <input type="search" required autocomplete="off" name="search_bar" placeholder="Search Here">
                              <button type="submit" name="button"><i class="fa fa-search"></i></button>
                          </form>
                      </div>
                      <div class="wsh-box ml-auto">
                          <a href="<?php echo base_url() ?>wishlist" data-toggle="tooltip" data-placement="top" title="Wishlist">
                              <img src="<?php echo base_url() ?>images/heart.png" alt="favorite">
                              <span class="ViewUserWishlist">0</span>
                          </a>
                      </div>
                      <div class="cart-box ml-4">
                          <a href="#" data-toggle="tooltip" data-placement="top" title="Shopping Cart" class="cart-btn">
                              <img src="<?php echo base_url() ?>images/cart.png" alt="cart">
                              <span class="ViewUserCartList">0</span>
                          </a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
  <!-- End Sticky Menu -->