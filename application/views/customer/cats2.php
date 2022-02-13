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
                    $this->db->where('catName', $target);
                    $this->db->order_by('sub_cat', 'a');
                    // $this->db->where('level', '1');
                    $cats = $this->db->get('chb_sub_category')->result_array();
                    if ($cats) {
                        foreach ($cats as $cat) {
                            $icon = $this->db->get_where('chb_category', array('cat_slug' => $target))->row_array();
                            $this->session->set_userdata(array('catLevel' => $icon['level']));  ?>
                            <?php $catArray = array('current' => $target, 'category' => $cat['sub_cat_slug']) ?>
                            <div class="col-lg-3 col-6 text-center mb-4">
                                <div class="card text-center">
                                    <a href="<?php echo base_url() . 'auth/category/' . $catArray['current'] . '_' . $catArray['category'] ?>" class="catLink card-body text-center pinkBg text-white changeColor">
                                        <?php
                                        if ($icon['icon'] == '') {
                                        ?>
                                            <h1 class="category-circle text-center mb-4 mt-2">
                                                <strong class="strong strongStyle">
                                                    <?php echo ucfirst(substr(str_replace(' ', '', $cat['sub_cat']), 0, 1)) ?>
                                                </strong>
                                            </h1>
                                        <?php
                                        } else { ?>
                                            <h1 class="mb-4">
                                                <img src="<?php echo $icon['icon'] ?>" style="width: 60px; height: 60px;">
                                            </h1>
                                        <?php }  ?>
                                        <h6><?php echo ucfirst($cat['sub_cat']) ?></h6><br>
                                    </a>
                                    <div class="card-footer pinkBg changeColor">
                                        <a class="text-white catLink" href="<?php echo base_url() ?>ct/<?php echo $cat['sub_cat_slug'] ?>"><i class="fa fa-paperclip"> </i> View all Products in Category</a>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="col-md-12 text-center mt-5">
                            <div class="card-body">
                                <div class="">
                                    <h1>No Category found under <?php echo $target ?></h1>
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
<?php $this->load->view('template/footer') ?>

<script>
    $(function() {
        var level = '<?php echo $this->session->userdata('catLevel') ?>';
        if (level == '1') {
            $('.changeColor').removeClass('pinkBg');
            $('.strongStyle').removeClass('strong');
            $('.changeColor').addClass('blueBg');
            $('.strongStyle').addClass('blueText');
        }
        if (level == '3') {
            $('.changeColor').removeClass('pinkBg');
            $('.strongStyle').removeClass('strong');
            $('.changeColor').addClass('purpleBg');
            $('.strongStyle').addClass('purpleText');
        }
        if (level == '4') {
            $('.changeColor').removeClass('pinkBg');
            $('.strongStyle').removeClass('strong');
            $('.changeColor').addClass('darkBg');
            $('.strongStyle').addClass('darkText');
        }
        if (level == '5') {
            $('.changeColor').removeClass('pinkBg');
            $('.strongStyle').removeClass('strong');
            $('.changeColor').addClass('orangeBg');
            $('.strongStyle').addClass('orangeText');
        }
        if (level == '6') {
            $('.changeColor').removeClass('greenBg');
            $('.strongStyle').removeClass('strong');
            $('.changeColor').addClass('greenBg');
            $('.strongStyle').addClass('greenText');
        }
    });
</script>