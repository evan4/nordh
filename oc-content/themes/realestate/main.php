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
?>
<?php osc_current_web_theme_path('header.php'); ?>
    <?php
    osc_get_premiums(5);
    if(osc_get_premiums(5) >= 5){
    $index = 0;
    ?>
    <section class="specials">
        <p class="caption">спец. предложения</p>

        <ul class="items-list">
            <?php while (osc_has_premiums()) { ?>
                <li class="items-list__item">
                    <a class="items-list__img" href="<?php echo osc_premium_url(); ?>">
                        <?php if (osc_images_enabled_at_items()) { ?>
                            <?php if (osc_count_premium_resources()) { ?>
                                <img src="<?php echo osc_resource_preview_url(); ?>"
                                     title="<?php echo osc_item_title(); ?>"
                                     alt="<?php echo osc_item_title(); ?>"/>
                            <?php } else { ?>
                                <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>"
                                     alt="фото">
                            <?php } ?>
                        <?php } else { ?>
                            <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>"
                                 alt="фото">
                        <?php } ?>
                    </a>
                    <h3 class="items-list__caption">
                        <?php if (strlen(osc_premium_title()) > 31) {
                            echo mb_substr(osc_premium_title(), 0, 28);
                        } else {
                            echo osc_premium_title();
                        } ?>
                    </h3>
                    <ul class="items-list__data clearfix">
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <span>г. <?= osc_premium_city(); ?>, <?= osc_premium_address(); ?></span>

                        </li>
                        <li>
                            <i class="fa icon-rules"></i>
                            <span>
                              <?php
                              $attrs = get_realestate_attributes(osc_premium_id());
                              echo $attrs['attributes']['square_meters']['value'];
                              ?> м<sup>2</sup>
                            </span>
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
                            <span>
                               <?php if (osc_price_enabled_at_items()) { ?>
                                   <spab class="price"><?php echo osc_premium_formated_price(); ?></spab>
                               <?php } ?>
                            </span>
                        </li>
                    </ul>
                    <a href="<?php echo osc_premium_url(); ?>"
                       class="button button_green items-list__more ">Подробнее</a>
                </li>
                <?php
                $index++;
                if ($index == 5) {
                    break;
                }
            }
            ?></ul>

        <?php View::newInstance()->_erase('items');
        ?>
    </section>
    <?php } ?>
    <section class="latest">
        <p class="caption">новые объекты</p>
        <div class="specials__wrap clearfix">
            <div class="specials__left">
                <?php if (osc_count_latest_items() == 0) { ?>
                    <p class="empty"><?php _e('No Latest Items', 'realestate'); ?></p>
                <?php } else {
                    $indexl = 0;
                    ?>
                    <ul class="items-list-vertical">
                        <?php while (osc_has_latest_items()) { ?>
                            <li class="items-list-vertical__item">
                                <a class="items-list-vertical__img" href="<?php echo osc_item_url(); ?>">
                                    <?php if (osc_images_enabled_at_items()) { ?>
                                        <?php if (osc_count_item_resources()) { ?>
                                            <img src="<?php echo osc_resource_thumbnail_url(); ?>"
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
                                <div class="items-list-vertical__center">
                                    <h3 class="items-list-vertical__caption">
                                        <?php if (strlen(osc_item_title()) > 31) {
                                            echo mb_substr(osc_item_title(), 0, 28);
                                        } else {
                                            echo osc_item_title();
                                        } ?>
                                    </h3>
                                    <ul class="items-list__data items-list__data_last">
                                        <?php $attrs = get_realestate_attributes(); ?>
                                        <li>
                                            <i class="fa fa-map-marker"></i>
                                            г. <?= osc_item_city(); ?>, <?=  osc_item_address(); ?>
                                        </li>
                                        <?php
                                        if($attrs['attributes']['square_meters']['value'] > 0) { ?>
                                        <li>
                                            <i class="fa icon-rules"></i>
                                            <?= $attrs['attributes']['square_meters']['value']; ?> м<sup>2</sup>
                                        </li>
                                        <?php } ?>
                                        <li>
                                            <i class="fa fa-rouble"></i>
                                            <?php if (osc_price_enabled_at_items()) { ?>
                                                <spab class="price"><?= osc_item_formated_price(); ?></spab>
                                            <?php } ?>
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
                                    </ul>
                                    <div class="author">
                                        <?php echo osc_item_city(); ?> (<?php echo osc_item_region(); ?>)
                                    </div>
                                </div>
                                <div class="items-list-vertical__right">
                                    <?php if (osc_users_enabled()) { ?>
                                        <?php if (osc_is_web_user_logged_in()) { ?>
                                    <a class="button button_small" href="#">
                                        <i class="fa fa-star"></i>Сохранить</a>
                                        <?php } ?>
                                    <?php } ?>
                                    <a class="button button_small" href="<?php echo osc_item_url(); ?>">
                                        <i class="fa fa-bars"></i>Подробнее</a>

                                </div>
                            </li>
                            <?php
                            $indexl++;
                            if ($indexl == 5) {
                                break;
                            }
                        }
                        ?>
                    </ul>
                    <?php View::newInstance()->_erase('items');
                } ?>
            </div>
            <div class="main-rec-right">
                <?php osc_show_widgets_by_description('баннер справа'); ?>
            </div>
        </div>

    </section>

<?php if (function_exists(categories_list)) {
    //echo categories_list();
} ?>
    <!-- <div class="main-rec-bottom">
        <div class="main-rec-bottom__block">
            <?php osc_show_widgets_by_description('рекламный блок на главной внизу'); ?>
        </div>
    </div> -->
    </div> <!-- wrap -->
    <section class="main-contact clearfix">

        <div class="main-contact__feedback">
            <div class="main-contact__wrap">
                <p class="caption">Оставьте заявку</p>
                <p class="main-contact__text">Мы свяжемся с вами в ближайшее время</p>
                <form action="" method="post" class="main-contact__form clearfix">
                    <input type="tel" name="tel"
                           id="ftel"
                           class="main-contact__input"
                           placeholder="Ваш телефон">
                    <input type="text" name="name"
                           id="fname"
                           class="main-contact__input"
                           placeholder="Ваше имя">
                    <textarea name="msg"
                              class="main-contact__textarea"
                              placeholder="Ваше сообщение"></textarea>
                    <input type="submit" class="button button_green button_border main-contact__submit"
                           value="Отправить">
                </form>
                <p class="popup__res"><i></i><span></span></p>
            </div>

        </div>
        <div class="main-contact__consult">
            <p class="caption-green">получите консультацию бесплатно!</p>
            <p class="main-contact__text">Позвоните нам</p>
            <a class="main-contact__tel" href="tel:8346771070">8 (3462) 77-10-77</a>
            <p class="main-contact__text main-contact__text_shink">или закажите звонок! Наш менеджер сам перезвонит
                Вам!</p>
            <a class="button button_wborder callback" href="#callback">Заказать звонок</a>
        </div>
    </section>

    <div class="wrap">
<?php osc_current_web_theme_path('footer.php'); ?>