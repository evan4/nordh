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
<?php osc_current_web_theme_path('header.php');
$orderby = $_GET['orderby'] ? filter_input(INPUT_GET, 'orderby', FILTER_SANITIZE_SPECIAL_CHARS) : 'dt_pub_date';
$dir = $_GET['dir'] ? filter_input(INPUT_GET, 'dir', FILTER_SANITIZE_SPECIAL_CHARS) : 'DESC';
$sort = $orderby.'-'.$dir;
$arr = [
  'dt_pub_date-desc' => 'сначала новые',
    'dt_pub_date-asc' => 'сначала старые',
    'i_price-asc' => 'По цене (сначала недорогие)',
    'i_price-desc' => 'По цене (сначала дорогие)'
];
?>
    <div class="page">
        <h1 class="caption caption_page"><?php echo osc_static_page_title(); ?></h1>
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

        <section class="latest clearfix">
            <div class="specials__wrap clearfix">
                <div class="specials__left">
                    <?php
                    $page = 1;
                    $page_get = 0;

                    if (!empty($_GET['iPage'])) {
                        $page_get = intval($_GET['iPage']);
                        $page = intval($_GET['iPage']);
                        if (false === $page) {
                            $page = 1;
                            $page_get = 0;
                        }else{
                            $page_get = intval($_GET['iPage']) -1;
                        }
                    }
                    $total = osc_total_active_items();
                    $pag = 9;
                    $offset = ($page - 1) * $pag;
                    $latest = Item::newInstance()->listLatestPagintionC($pag, $offset, $orderby, strtoupper ($dir));
                    ?>
                    <ul class="items-list-vertical" style="font-size: 20px">
                        <?php foreach ($latest as $item) {

                            $img = Item::newInstance()->findResourcesByID($item['pk_i_id']);

                            ?>
                            <li class="items-list-vertical__item">
                                <a href="<?php echo osc_item_url_from_item($item); ?>"
                                   class="items-list-vertical__img">
                                <?php
                                $img_url =  osc_resource_path() . $img[0]['s_path'] . $img[0]['pk_i_id'] . '_thumbnail.' . $img[0]['s_extension'];
                                if ($img[0]['pk_i_id']) { ?>
                                    <img src="<?= $img_url; ?>"
                                         alt="фото">
                                <?php } else { ?>
                                    <img src="<?php echo osc_current_web_theme_url('images/no_photo.gif'); ?>" alt="фото">
                                <?php } ?>
                                </a>
                                <div class="items-list-vertical__center">
                                    <h3 class="items-list-vertical__caption">
                                        <?php if (strlen($item['s_title']) > 31) {
                                            echo mb_substr($item['s_title'], 0, 28);
                                        } else {
                                            echo $item['s_title'];
                                        } ?>
                                    </h3>
                                    <ul class="items-list__data items-list__data_last">
                                        <?php $attrs = get_realestate_attributes($item['pk_i_id']); ?>
                                        <li>
                                            <i class="fa fa-map-marker"></i>
                                            г. <?= $item['s_city']; ?>, <?= $item['s_address']; ?>
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
                                                <spab class="price"><?= osc_format_price($item['i_price']); ?></spab>
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
                                    <a class="button button_small" href="<?php echo osc_item_url_from_item($item); ?>">
                                        <i class="fa fa-bars"></i>Подробнее</a>

                                </div>
                            </li>
                        <?php }
                        //var_dump(osc_item_url_from_item($item));
                        ?>
                    </ul>
                    <div class="paginate clearfix">
                        <?php
                        $params = array(
                            'selected' => $page_get,
                            'total' => ceil(osc_total_active_items() / $pag),
                            'url' => '/catalog-p30?' . 'iPage={PAGE}',
                            'list_class' => 'paginate__list'
                        );
                        if ($params['total'] > 1){
                            echo osc_pagination($params);
                        }
                         ?>
                    </div>
                </div>
                <?php
                osc_current_web_theme_path('search_sidebar.php');
                ?>
            </div>

        </section>
        <?php if (function_exists(categories_list)) {
            //echo categories_list();
        } ?>
    </div>

<?php osc_current_web_theme_path('footer.php'); ?>

<script src="<?= osc_current_web_theme_js_url('catalog.js'); ?>"></script>
