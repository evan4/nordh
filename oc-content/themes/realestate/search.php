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
$arr = [
    'dt_pub_date-desc' => 'сначала новые',
    'dt_pub_date-asc' => 'сначала старые',
    'i_price-asc' => 'По цене (сначала недорогие)',
    'i_price-desc' => 'По цене (сначала дорогие)'
];
$sort = Params::getParam('sOrder').'-'.Params::getParam('iOrderType');

?>
<?php osc_current_web_theme_path('header.php'); ?>
<div class="page">
    <section class="latest">
        <h1 class="caption caption_page"><?php echo search_title(); ?></h1>
        <div class="page__select clearfix">
            <label for="select-sort">Сортировать</label>
            <select id="select-sort" class="page__sort">
                <?php foreach ($arr as $k=>$v){
                    if($k === $sort) { ?>
                        <option value="<?= $k; ?>" selected>><?= $v; ?></option>
                    <?php }else { ?>
                        <option value="<?= $k; ?>"><?= $v; ?></option>
                    <?php } ?>

                <?php } ?>
            </select>
        </div>
        <div class="ad_list">
            <div class="ui-actionbox">
                <?php $i = 0; ?>
                <?php $orders = osc_list_orders();
                foreach ($orders as $label => $params) {
                    $orderType = ($params['iOrderType'] == 'asc') ? '0' : '1'; ?>
                    <?php if (osc_search_order() == $params['sOrder'] && osc_search_order_type() == $orderType) { ?>
                        <a class="current" id="<?= $params['sOrder'].'-'.$params['iOrderType']; ?>"
                           href="<?php echo osc_update_search_url($params); ?>"><?php echo $label; ?></a>
                    <?php } else { ?>
                        <a id="<?= $params['sOrder'].'-'.$params['iOrderType']; ?>" href="<?php echo osc_update_search_url($params); ?>"><?php echo $label; ?></a>
                    <?php } ?>
                    <?php $i++; ?>
                <?php } ?>
            </div>

            <?php search_ads_listing_top_fn(); ?>

            <?php if (osc_count_items() == 0) { ?>
                <p class="empty"><?php printf(__('There are no results matching "%s"', 'realestate'), osc_search_pattern()); ?></p>
            <?php } else { ?>
                <div class="specials__wrap clearfix">
                    <div class="specials__left">
                        <ul class="items-list-vertical">
                            <?php require('search_gallery.php'); ?>
                        </ul>
                        <?php

                        if (osc_search_pagination() != '') { ?>
                            <div class="paginate clearfix">
                                <?php echo osc_search_pagination()?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    osc_current_web_theme_path('search_sidebar.php');
                    ?>
                </div>
            <?php } ?>

        </div>
    </section>

    <script type="text/javascript">
        $(function () {
            function log(message) {
                $("<div/>").text(message).prependTo("#log");
                $("#log").attr("scrollTop", 0);
            }


        });

        function checkEmptyCategories() {
            var n = $("input[id*=cat]:checked").length;
            if (n > 0) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</div>
<?php osc_current_web_theme_path('footer.php'); ?>
<script src="<?= osc_current_web_theme_js_url('search.js'); ?>"></script>