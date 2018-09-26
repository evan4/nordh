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

$i = 1;
while (osc_has_items()) {
    $i++; ?>
    <li class="items-list-vertical__item">
        <div class="frame">
            <a href="<?php echo osc_item_url(); ?>" class="items-list-vertical__img">
            <?php if (osc_images_enabled_at_items()) { ?>
                    <?php if (osc_count_item_resources()) { ?>
                        <img src="<?php echo osc_resource_thumbnail_url(); ?>"
                             title="<?php echo osc_esc_html(osc_item_title()); ?>"
                             alt="<?php echo osc_esc_html(osc_item_title()); ?>"/>
                    <?php } else { ?>
                        <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="" title=""/>
                    <?php } ?>
                <?php } else { ?>
                    <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="" title=""/>
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
                <?php $attrs = get_realestate_attributes(); ?>
                <ul class="items-list__data items-list__data_last">

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
        </div>

    </li>

    <?php if ($i == 5) search_ads_listing_medium_fn(); ?>
<?php } ?>