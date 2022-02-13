<div class="category-box">
    <div class="sec-title">
        <h6>Quick Category</h6>
    </div>
    <!-- accordion -->
    <div id="accordion">


        <?php
        $index = 0;
        $this->db->where('level', '1');
        $this->db->limit(rand(10, 15));
        $this->db->order_by('cat_id', 'random');
        $category = $this->db->get('chb_category')->result_array();
        foreach ($category as $cat) {
            $index++; ?>
            <div class="card">
                <div class="card-header">
                    <a href="#" data-toggle="collapse" data-target="#collapse<?php echo $index ?>">
                        <span> <img src="<?php echo $cat['icon'] ?>" style="width: 20px; height: 20px;"> <?php echo $cat['cat'] ?></span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div id="collapse<?php echo $index ?>" class="collapse ml-2">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <?php
                            $cat_slug = $this->db->get_where('chb_sub_category', array('catName' => $cat['cat_slug']))->result_array();
                            $a = 0;
                            foreach ($cat_slug as $slug) {
                                $a++; ?>
                                <li>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex">
                                                <a href="<?php echo base_url() ?>ct/<?php echo $slug['sub_cat_slug'] ?>" class="mr-3">
                                                    <i class="fa fa-hand-pointer-o"></i>
                                                </a>

                                                <a href="#" data-toggle="collapse" data-target="#collapse_<?php echo $a ?>">
                                                    <span><?php echo $slug['sub_cat'] ?></span>
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="collapse_<?php echo $a ?>" class="collapse ml-2">
                                            <div class="card-body">
                                                <ul class="list-unstyled">
                                                    <?php
                                                    for ($i = 3; $i < 10; $i++) {
                                                        $children = $this->db->get_where('chb_category', array('cat_slug' => $slug['sub_cat_slug'], 'level' => $i))->result_array();
                                                        foreach ($children as $child) {
                                                            $child_subs = $this->db->get_where('chb_sub_category', array('catName' => $child['cat_slug']))->result_array();
                                                            $s = 400;
                                                            foreach ($child_subs as $cs) {
                                                                $s++; ?>
                                                                <!-- ############################### -->
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <div class="d-flex">
                                                                            <a href="<?php echo base_url() ?>ct/<?php echo $cs['sub_cat_slug'] ?>" class="mr-3">
                                                                                <i class="fa fa-hand-pointer-o"></i>
                                                                            </a>
                                                                            <a href="#" data-toggle="collapse" data-target="#collapse_<?php echo $s ?>">
                                                                                <span><?php echo $cs['sub_cat'] ?></span>
                                                                                <i class="fa fa-angle-down"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div id="collapse_<?php echo $s ?>" class="collapse ml-2">
                                                                        <div class="card-body">
                                                                            <ul class="list-unstyled">
                                                                                <?php
                                                                                $chs = $this->db->get_where('chb_sub_category', array('catName' => $cs['sub_cat_slug']))->result_array();
                                                                                $r = 220;
                                                                                foreach ($chs as $chs) {
                                                                                    $r++; ?>
                                                                                    <!-- ############################### -->
                                                                                    <div class="card">
                                                                                        <div class="card-header">
                                                                                            <div class="d-flex">
                                                                                                <a href="<?php echo base_url() ?>ct/<?php echo $chs['sub_cat_slug'] ?>" class="mr-3">
                                                                                                    <i class="fa fa-hand-pointer-o"></i>
                                                                                                </a>
                                                                                                <a href="#" data-toggle="collapse" data-target="#collapses-<?php echo $r ?>">
                                                                                                    <span><?php echo $chs['sub_cat'] ?></span>
                                                                                                    <i class="fa fa-angle-down"></i>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div id="collapses-<?php echo $r ?>" class="collapse ml-2">
                                                                                            <div class="card-body">
                                                                                                <ul class="list-unstyled">
                                                                                                    <?php
                                                                                                    $rss = $this->db->get_where('chb_sub_category', array('catName' => $chs['sub_cat_slug']))->result_array();
                                                                                                    $z = 675;
                                                                                                    foreach ($rss as $rs) {
                                                                                                        $z++; ?>

                                                                                                        <!-- ############################### -->
                                                                                                        <div class="card">
                                                                                                            <div class="card-header">
                                                                                                                <div class="d-flex">
                                                                                                                    <a href="<?php echo base_url() ?>ct/<?php echo $rs['sub_cat_slug'] ?>" class="mr-3">
                                                                                                                        <i class="fa fa-hand-pointer-o"></i>
                                                                                                                    </a>
                                                                                                                    <a href="#" data-toggle="collapse" data-target="#col_<?php echo $z ?>">
                                                                                                                        <span><?php echo $rs['sub_cat'] ?></span>
                                                                                                                        <i class="fa fa-angle-down"></i>
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div id="col_<?php echo $z ?>" class="collapse ml-2">
                                                                                                                <div class="card-body">
                                                                                                                    <ul class="list-unstyled">
                                                                                                                        <?php
                                                                                                                        $dbs = $this->db->get_where('chb_sub_category', array('catName' => $rs['sub_cat_slug']))->result_array();

                                                                                                                        foreach ($dbs as $db) {
                                                                                                                            echo '<li><a href="' . base_url() . 'ct/' . $db['sub_cat_slug'] . '"><i class="fa fa-angle-right"></i> ' . $db['sub_cat'] . '</a></li>';
                                                                                                                        }

                                                                                                                        ?>

                                                                                                                    </ul>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <!-- ############################### -->
                                                                                                    <?php } ?>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- ############################### -->
                                                                                <?php }

                                                                                ?>

                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- ############################### -->


                                                    <?php }
                                                        }
                                                    }

                                                    ?>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>



    </div>
</div>