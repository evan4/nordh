<?php
$slides = Models_Repair::newInstance()->getSlides();

?>
<link rel="stylesheet" href="<?php echo osc_base_url(); ?>oc-content/plugins/repair/assets/css/libs/fotorama.css">
<link rel="stylesheet" href="<?php echo osc_base_url(); ?>oc-content/plugins/repair/assets/css/repair.css">
<div class="raboty__wrap">
    <div class="slick-repair">
    <?php foreach ($slides as $slide) { ?>
        <div class="item">
            <div class="fotorama"
                 data-allowfullscreen="true"
                 data-nav="thumbs"
                 data-ratio="800/600"
                 data-thumb-width="60"
                 data-thumb-height="45"
                 data-thumbmargin="10"
                 data-loop="true"
                 data-fit="cover"
            >
                <?php
                if($slide['image']) {
                    foreach ($slide['image'] as $item) { ?>
                        <a href="<?php echo '/oc-content/uploads/repair/' . $item; ?>"
                           data-thumb="<?php echo '/oc-content/uploads/repair/preview_' . $item; ?>">
                        </a>
                    <?php }
                }?>
            </div>
            <div class="slick-repair__data">
                <p class="slick-repair__caption"><?= $slide['title']; ?></p>
                <div class="slick-repair__text"><?= $slide['description']; ?></div>
            </div>
        </div>
    <?php } ?>
    </div>
</div>
<div class="slick-repair__arrows"></div>
<script src="<?= osc_current_web_theme_js_url('libs/slick.min.js'); ?>"></script>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/repair/assets/js/libs/fotorama.js"></script>
<script src="<?php echo osc_base_url(); ?>oc-content/plugins/repair/assets/js/repair.js"></script>