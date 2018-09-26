<?php
/*
 *      Osclass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2013 Osclass
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


function itemCustomHead()
{
    if (osc_item_is_expired()) {
        $echo = "<meta name=\"robots\" content=\"noindex, nofollow\" /><meta name=\"googlebot\" content=\"noindex, nofollow\" />";
    } else {
        $echo = "<meta name=\"robots\" content=\"index, follow\" /><meta name=\"googlebot\" content=\"index, follow\" />";
    }
}

osc_add_hook('header', 'itemCustomHead');
?>
<?php osc_current_web_theme_path('header.php');
$res = osc_get_item_resources();

?>
<div class="ticket clearfix">
    <div class="specials__left specials__left_item">
        <div class="ticket__top clearfix">
            <h1 class="caption caption_page caption_item"><?php echo osc_item_title(); ?></h1>
            <?php if (osc_users_enabled()) { ?>
                <?php if (osc_is_web_user_logged_in()) { ?>
                    <a class="ticket__favorite" href="#">
                        <i class="fa fa-star"></i>Сохранить
                    </a>
                <?php }
            } ?>
        </div>
        <div class="ticket__wrap">
            <div class="ticket__carousels clearfix">
                <?php if (osc_count_item_resources() > 1) { ?>
                    <div class="ticket__carousel">
                        <?php if (osc_images_enabled_at_items()) {
                            if (osc_count_item_resources() > 0) { ?>
                                <script>
                                    var img_total = '<?php echo count($res); ?>';
                                </script>
                                <?php

                                foreach ($res as $img) {
                                $data = getimagesize($img['s_path'] . $img['pk_i_id'] . '_original.' . $img['s_extension']);
                                $width = $data[0];
                                $height = $data[1];
                                    ?>
                                    <div class="slick-slider-item">
                                        <img alt="фото" class="img-responsive img-center"
                                             data-lazy="/<?= $img['s_path'] . $img['pk_i_id'] . '_original.' . $img['s_extension']; ?>"
                                        >
                                    </div>
                                <?php }
                            }
                        }
                        ?>
                    </div>
                    <div class="ticket__vertical">
                        <?php
                        if (osc_images_enabled_at_items()) {

                            if (osc_count_item_resources() > 0) { ?>
                                <?php
                                foreach ($res as $img) {
                                    ?>
                                    <div class="slick-slider-item">
                                        <img alt="фото"
                                             src="/<?= $img['s_path'] . $img['pk_i_id'] . '_thumbnail.' . $img['s_extension']; ?>">
                                    </div>
                                <?php }
                            }
                        }
                        ?>
                    </div>
                <?php } elseif (osc_count_item_resources() === 1) { ?>
                    <div class="ticket__container">
                        <img alt="фото" class="img-responsive"
                             src="/<?= $res[0]['s_path'] . $res[0]['pk_i_id'] . '_original.' . $res[0]['s_extension']; ?>">
                    </div>
                <?php } ?>
            </div>

            <p class="ticket__sub"><?php _e('Description', 'realestate'); ?></p>
            <ul class="items-list__data">
                <?php $attrs = get_realestate_attributes(); ?>
                <li>
                    <i class="fa fa-map-marker"></i>
                    г. <?= osc_item_city() . ', ' . osc_item_address(); ?>,
                </li>
                <li>
                    <i class="fa icon-rules"></i>
                    <?php
                    $area = $attrs['attributes']['square_meters']['value'];

                    if (substr($area, -2) === '00') {
                        $area = round($area);
                    }
                    echo $area;
                    ?> м<sup>2</sup>
                </li>
                <li>
                    <i class="fa fa-rouble"></i>
                    <?php if (osc_price_enabled_at_items()) { ?>
                        <span class="price"><?= osc_item_formated_price(); ?></span>
                    <?php } ?>
                </li>
                <li>
                    <i class="fa fa-building-o"></i> Этаж
                    <?php echo $attrs['attributes']['year']['value'];
                    if($attrs['attributes']['floors']['value'] > 0){
                     echo '/'.$attrs['attributes']['floors']['value'];
                    } ?>
                </li>
            </ul>

            <p class="ticket__sub">Дополнительная информация</p>
            <div class="ticket__desc"><?php echo osc_item_description(); ?></div>
            <p class="ticket__sub">Карта</p>
            <?php osc_run_hook('location'); ?>
        </div>

        <?php
        related_listings(); ?>
        <?php if (osc_count_items() > 0) { ?>
            <div class="similar_ads">
                <p class="ticket__sub">Похожие объекты</p>
                <?php
                View::newInstance()->_exportVariableToView("listType", 'items');
                osc_current_web_theme_path('list_similar.php');
                ?>
            </div>
        <?php } ?>
    </div>
    <div class="main-rec-right main-rec-right_premium">
        <div class="main-rec-right__author">
            <p class="ticket__sub">Контакты</p>
            <p class="ticket__tel">
                <?php if (function_exists('osc_telephone_number')) {
                    osc_telephone_number();
                } ?>
            </p>
            <div class="ticket-user">
                <div class="ticket-user__image">
                    <?php
                    $profile = Models_User_Photo::newInstance()->getByName(osc_item_contact_name());
                    if ($profile) { ?>
                        <img class="img-responsive img-center"
                             src="<?= "/oc-content/uploads/profile/" . $profile[0]['pic_ext']; ?>" alt="фото">
                    <?php } else { ?>
                        <i class="fa fa-user"></i>
                    <?php } ?>
                </div>
                <ul class="ticket-user__list">
                    <li>
                        <i class="fa fa-user"></i>
                        <a href="/search/?User=<?= osc_item_contact_name(); ?>">
                            <?php echo osc_item_contact_name(); ?>
                        </a>
                    </li>
                    <li>
                        <i class="fa fa-check"></i>
                        <?= $attrs['attributes']['agency']['value']; ?>
                    </li>
                    <li>
                        <i class="fa fa-at"></i>
                        <?php if (osc_item_show_email()) { ?>
                            <a href="mailto:<?php echo osc_item_contact_email(); ?>"><?php echo osc_item_contact_email(); ?></a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
        <?php osc_show_widgets_by_description('баннер справа'); ?>
    </div>
</div>

<?php osc_current_web_theme_path('footer.php'); ?>
<script src="<?= osc_current_web_theme_js_url('libs/slick.min.js'); ?>"></script>
<script src="<?= osc_current_web_theme_js_url('item.js'); ?>"></script>
