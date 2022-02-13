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
                <div class="row">
                    <?php
                    $this->db->order_by('cat', 'a');
                    $this->db->where('level', '1');
                    $cats = $this->db->get('chb_category')->result_array();
                    foreach ($cats as $cat) {  ?>
                        <?php $catArray = array('current' => 'Categories', 'category' => $cat['cat_slug']) ?>
                        <div class="col-lg-3 col-6 text-center mb-4">
                            <div class="card">
                                <a href="<?php echo base_url() . 'auth/category/' . $catArray['current'] . '_' . $catArray['category'] ?>" class="catLink card-body text-center pinkBg text-white">
                                    <h1 class="mb-4">
                                        <img src="<?php echo $cat['icon'] ?>" style="width: 60px; height: 60px;">
                                    </h1>
                                    <h6 style="overflow: auto;  text-overflow: ellipsis; height: 40px;"><?php echo ucfirst($cat['cat']) ?></h6><br>
                                </a>
                                <div class="card-footer pinkBg">
                                    <a class="text-white catLink" href="<?php echo base_url() ?>ct/<?php echo $cat['cat_slug'] ?>"><i class="fa fa-paperclip"> </i> View all Products in Category</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Category Area -->


<!-- Footer Area -->
<?php
$this->load->view('template/footer');
$this->load->view('template/updateSitemap');
?>