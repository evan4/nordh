<div class="main-rec-right main-rec-right_premium">
    <?php
    osc_get_premiums(2);
    $index = 0;
    ?>
    <ul class="items-list items-list_one">
        <?php while (osc_has_premiums()) { ?>
            <li class="items-list__item">
                <a class="items-list__img items-list__img_side" href="<?php echo osc_premium_url(); ?>">
                    <?php if (osc_images_enabled_at_items()) { ?>
                        <?php if (osc_count_premium_resources()) { ?>
                            <img src="<?php echo osc_resource_preview_url(); ?>"
                                 title="<?php echo osc_item_title(); ?>"
                                 alt="<?php echo osc_item_title(); ?>"/>
                        <?php } else { ?>
                            <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>"
                                 alt="" title=""/>
                        <?php } ?>
                    <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>"
                             alt="" title=""/>
                    <?php } ?>
                </a>
                <h3 class="items-list__caption">
                    <?php if (strlen(osc_premium_title()) > 31) {
                        echo mb_substr(osc_premium_title(), 0, 28);
                    } else {
                        echo osc_premium_title();
                    } ?>
                </h3>
                <ul class="items-list__data">
                    <li>
                        <i class="fa fa-map-marker"></i>
                        <span>г. <?= osc_premium_city(); ?>, <?= osc_premium_address(); ?></span>
                    </li>
                    <li>
                        <i class="fa icon-rules"></i>
                        <span><?php
                        $attrs = get_realestate_attributes(osc_premium_id());
                        echo $attrs['attributes']['square_meters']['value'];
                        ?> м<sup>2</sup></span>
                    </li>
                    <?php
                    if($attrs['attributes']['year']['value'] > 0) { ?>
                    <li>
                        <i class="fa fa-building-o"></i>Этаж
                        <?php echo $attrs['attributes']['year']['value'];
                        if ($attrs['attributes']['floors']['value'] > 0) {
                            echo '/' . $attrs['attributes']['floors']['value'];
                        } ?>
                    </li>
                    <?php } ?>
                    <li>
                        <i class="fa fa-rouble"></i>
                        <span><?php if (osc_price_enabled_at_items()) { ?>
                            <spab class="price"><?php echo osc_premium_formated_price(); ?></spab>
                        <?php } ?></span>
                    </li>
                </ul>
                <a href="<?php echo osc_premium_url(); ?>"
                   class="button button_green items-list__more">Подробнее</a>
            </li>

            <?php
            $index++;
            if ($index == 4) {
                break;
            }
        }
        ?></ul>

    <?php View::newInstance()->_erase('items');
    ?>
</div>