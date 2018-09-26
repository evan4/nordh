<?php
$advantages = Models_Advantages::newInstance()->getSlides();

?>
<section class="preimushchestva" id="preimushchestva">
    <div class="wrap">
        <p class="caption caption_preimushchestva">Наши преимущества</p>
        <ul class="preimushchestva__list">
            <?php foreach ($advantages as $item) { ?>
                <li class="preimushchestva__item">
                    <?php
                    $title = explode("\n", $item['title']);
                    $img = '/oc-content/uploads/advantages/' . $item['avatar'];
                    $img_exists = file_exists(glob(osc_content_path() . "uploads/advantages/".$item['avatar'])[0]);
                    if ($item['description'] != '') {

                        if (count($title) > 1) { ?>
                            <a class="preimushchestva__link"
                               href="#service">
                                <div class="preimushchestva__photo">
                                    <?php if ($img_exists && $item['avatar'] != '') { ?>
                                        <img src="<?= $img; ?>"
                                             alt="<?= $title[0] . ' ' . $title[1]; ?>">
                                    <?php } ?>
                                </div>

                                <div class="preimushchestva__text"><?= $title[0]; ?><span><?= $title[1]; ?></span></div>
                            </a>
                            <div class="preimushchestva__content">
                                <div class="white-popup__inner">
                                    <p class="popup__caption popup__caption_services"><?= $title[0] . ' ' . $title[1]; ?> </p>
                                    <p class="popup__text"><?= $item['description']; ?></p>
                                    <a class="preimushchestva__close" href="#">x</a>
                                </div>
                            </div>
                        <?php } else { ?>
                            <a class="preimushchestva__link"
                               href="#service">
                                <div class="preimushchestva__photo">
                                    <?php if ($img_exists && $item['avatar'] != '') { ?>
                                        <img src="<?= $img; ?>"
                                             alt="<?= $title[0] . ' ' . $title[1]; ?>">
                                    <?php } ?>
                                </div>

                                <div class="preimushchestva__text"><?= $title[0]; ?></div>
                            </a>
                            <div class="preimushchestva__content">
                                <div class="white-popup__inner">
                                    <p class="popup__caption popup__caption_services"><?= $title[0]; ?> </p>
                                    <p class="popup__text"><?= $item['description']; ?></p>
                                    <a class="preimushchestva__close" href="#">x</a>
                                </div>
                            </div>
                        <?php } //end of if (count($title) ?>

                    <?php } else {
                        if (count($title) > 1) { ?>
                            <div class="preimushchestva__link">
                                <div class="preimushchestva__photo">
                                    <?php if ($img_exists && $item['avatar'] != '') { ?>
                                        <img src="<?= $img; ?>"
                                             alt="<?= $title[0] . ' ' . $title[1]; ?>">
                                    <?php } ?>
                                </div>

                                <div class="preimushchestva__text"><?= $title[0]; ?><span><?= $title[1]; ?></span></div>

                            </div>
                        <?php } else { ?>
                            <div class="preimushchestva__link">
                                <div class="preimushchestva__photo">
                                    <?php if ($img_exists && $item['avatar'] != '') { ?>
                                        <img src="<?= $img; ?>"
                                             alt="<?= $title[0] . ' ' . $title[1]; ?>">
                                    <?php } ?>
                                </div>

                                <div class="preimushchestva__text"><?= $title[0]; ?></div>

                            </div>
                        <?php } //end of if (count($title) ?>

                    <?php }//end of if ($item['description'] ?>
                </li>
            <?php } //end of foreach ?>
        </ul>
    </div>
</section>