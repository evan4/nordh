<ul class="similar">
    <?php while (osc_has_items()) { ?>
        <li class="similar__item">
            <a class="similar__link" href="<?php echo osc_item_url(); ?>"><?php if (osc_images_enabled_at_items()) { ?>
                    <?php if (osc_count_item_resources()) { ?>
                        <img src="<?php echo osc_resource_preview_url(); ?>"
                             class=""
                             title="<?php echo osc_item_title(); ?>" alt="<?php echo osc_item_title(); ?>"/>
                    <?php } else { ?>
                        <img class="img-responsive img-center" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="" title=""/>
                    <?php } ?>
                <?php } else { ?>
                    <img class="img-responsive" src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="" title=""/>
                <?php } ?>
            </a>
            <div>
                <h3 class="similar__caption">
                    <?php if (strlen(osc_item_title()) > 31) {
                            echo mb_substr(osc_item_title(), 0, 20);
                        } else {
                            echo osc_item_title();
                        } ?>
                </h3>
                <?php $attrs = get_realestate_attributes(); ?>
                <ul class="similar__sub">
                    <li>
                        г. <?= osc_item_city(); ?>, <?=  osc_item_address(); ?>
                    </li>
                    <?php
                    if($attrs['attributes']['year']['value'] > 0) { ?>
                        <li>Этаж
                            <?php echo $attrs['attributes']['year']['value'];
                            if ($attrs['attributes']['floors']['value'] > 0) {
                                echo '/' . $attrs['attributes']['floors']['value'];
                            } ?>
                        </li>
                    <?php } ?>
                </ul>
                <a class="button button_link items-list__more" href="<?php echo osc_item_url(); ?>">
                    Подробнее</a>
            </div>
        </li>
    <?php } ?>
</ul>
<?php
$url = osc_item_url();
$arr = explode('/', $url);
array_pop($arr);
$url = implode("/", $arr);
?>
<div class="clearfix">
    <a class="button button_green similar__more"
       href="<?php echo $url; ?>">показать все</a>
</div>
