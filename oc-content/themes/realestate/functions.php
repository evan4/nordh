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

//Preferences
if (!osc_get_preference('keyword_placeholder', 'realestate')) {
    osc_set_preference('keyword_placeholder', __('Luxury Villas', 'realestate'), 'realestate');
}
if (osc_get_preference('theme_version', 'realestate') == '') {
    osc_set_preference('theme_version', '0', 'realestate');
}
if (osc_get_preference('defaultLocationShowAs', 'realestate') == '') {
    osc_set_preference('defaultLocationShowAs', 'dropdown', 'realestate');
}

// update THEME_VERSION preference
if (osc_get_preference('theme_version', 'realestate') == '') {
    // Update logo destination, now is uploaded to oc-content/uploads/
    if (file_exists(WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg")) {
        rename(WebThemes::newInstance()->getCurrentThemePath() . "images/logo.jpg", osc_uploads_path() . "realestate-logo.jpg");
    }
    if (file_exists(WebThemes::newInstance()->getCurrentThemePath() . "images/logo-footer.jpg")) {
        rename(WebThemes::newInstance()->getCurrentThemePath() . "images/logo-footer.jpg", osc_uploads_path() . "realestate-logo-footer.jpg");
    }
    osc_set_preference('theme_version', 202, 'realestate');
}

function item_realestate_attributes()
{
    //get_realestate_attributes
    if (function_exists('get_realestate_attributes')) {
        $data = get_realestate_attributes();
        $print = array();
        if (isset($data['attributes']['property_type'])) {
            $print[] = $data['attributes']['property_type']['value'];
        }
        if (isset($data['attributes']['plot_area'])) {
            $print[] = $data['attributes']['plot_area']['value'] . ' m<sup>2</sup>';
        }
        if ($print) {
            echo join('<br />', $print);
        }
    }
    return false;
}

function multilanguage_form_input_text($locale, $field)
{
    $name = str_replace('%locale%', $locale['pk_c_code'], $field['name']);
    echo '<input id="' . $name . '" type="text" name="' . $name . '" value="' . osc_esc_html(htmlentities($field['value'][$locale['pk_c_code']], ENT_COMPAT, "UTF-8")) . '" ' . $field['args'] . ' />';
}

function multilanguage_form_input_textarea($locale, $field)
{
    $name = str_replace('%locale%', $locale['pk_c_code'], $field['name']);
    $txt = '';
    if (array_key_exists('value', $field)) {
        if (array_key_exists($locale['pk_c_code'], $field['value'])) {
            $txt = $field['value'][$locale['pk_c_code']];
        }
    }
    echo '<textarea id="' . $name . '" name="' . $name . '" ' . $field['args'] . '>' . $txt . '</textarea>';
}

function multilanguage_form_input_select($locale, $field)
{
    $name = str_replace('%locale%', $locale['pk_c_code'], $field['name']);
    echo '<select id="' . $name . '" name="' . $name . '" ' . $fields['args'] . '>';
    if ($field['options'][$locale['pk_c_code']]) {
        foreach ($field['options'][$locale['pk_c_code']] as $option) {
            echo '<option value="' . $option['value'] . '">' . $option['label'] . '</option>';
        }
    }
    echo '</select>';
}

function multilanguage_form_label($locale, $field)
{
    $required = '';
    if ($field['required']) {
        if ($field['required'] == true) {
            $required = '*';
        }
    }
    $name = str_replace('%locale%', $locale['pk_c_code'], $field['name']);
    echo '<label for="' . $name . ']">' . $field['label'] . $required . '</label>';
}

function multilanguage_form_create_field($locale, $field, $label = true)
{
    if (!isset($field['args'])) {
        $fields['args'] = '';
    }
    if (!isset($field['value'][$locale['pk_c_code']])) {
        $fields['value'][$locale['pk_c_code']] = '';
    }
    if ($label) {
        multilanguage_form_label($locale, $field);
    }
    call_user_func_array('multilanguage_form_input_' . $field['type'], array($locale, $field));
}

function multilanguage_form($fields)
{
    $locales = osc_get_locales();
    $item = osc_item();
    $num_locales = count($locales);

    foreach ($locales as $locale) {
        foreach ($fields as $field) {
            if ($num_locales > 1) {
                echo '<div class="switch-locale locale-' . $locale['pk_c_code'] . '">';
            }
            multilanguage_form_create_field($locale, $field);
            if ($num_locales > 1) {
                echo '</div>';
            }
        }
    }
}

if (!OC_ADMIN) {
    if (!function_exists('add_close_button_fm')) {
        function add_close_button_fm($message)
        {
            return $message . '<a class="close">×</a>';
        }

        if (osc_version() < 300) {
            osc_add_filter('flash_message_text', 'add_close_button_fm');
        }
    }
    if (!function_exists('add_close_button_action')) {
        function add_close_button_action()
        {
            echo '<script type="text/javascript">';
            echo '$(".FlashMessage .close, .flashmessage .ico-close").click(function(){';
            echo '$(this).parent().hide();';
            echo '});';
            echo '</script>';
        }

        osc_add_hook('footer', 'add_close_button_action');
    }
}

if (!function_exists('get_gravatar')) {
    function get_gravatar($email = null, $size = 65)
    {
        $email = md5(strtolower(trim($email)));
        $default = urlencode(osc_current_web_theme_url('images/avatar.png'));
        return "http://www.gravatar.com/avatar/$email?s=$size&d=$default";
    }
}
if (!function_exists('logo_header')) {
    function logo_header()
    {
        if (REL_WEB_URL === $_SERVER['REQUEST_URI']) {
            $html = '<img class="header__logo" alt="' . osc_page_title() . '" src="' . osc_base_url() . str_replace(ABS_PATH, '', osc_uploads_path()) . "realestate-logo.jpg" . '"></a>';
        } else {
            $html = '<a class="header__logo" href="' . osc_base_url() . '"><img alt="' . osc_page_title() . '" src="' . osc_base_url() . str_replace(ABS_PATH, '', osc_uploads_path()) . "realestate-logo.jpg" . '"></a>';
        }
        if (file_exists(osc_uploads_path() . "realestate-logo.jpg")) {
            return $html;
        } else {
            return '<a id="logo" class="logo-text" href="' . osc_base_url() . '">' . osc_page_title() . '</a>';
        }
    }
}
if (!function_exists('logo_footer')) {
    function logo_footer()
    {
        if (REL_WEB_URL === $_SERVER['REQUEST_URI']) {
            $html = '<img class="footer__logo" alt="' . osc_page_title() . '" src="' . osc_base_url() . str_replace(ABS_PATH, '', osc_uploads_path()) . "realestate-logo-footer.jpg" . '">';
        } else {
            $html = '<a class="footer__logo" href="' . osc_base_url() . '"><img alt="' . osc_page_title() . '" src="' . osc_base_url() . str_replace(ABS_PATH, '', osc_uploads_path()) . "realestate-logo-footer.jpg" . '" /></a>';
        }
        if (file_exists(osc_uploads_path() . "realestate-logo-footer.jpg")) {
            return $html;
        } else {
            if (REL_WEB_URL === $_SERVER['REQUEST_URI']) {
                return '<span class="footer__logo">' . osc_page_title() . '</p>';
            } else {
                return '<a class="footer__logo" href="' . osc_base_url() . '">' . osc_page_title() . '</a>';
            }
        }
    }
}

if (!function_exists('realestate_theme_admin_menu')) {
    osc_admin_menu_appearance(__('Header logo', 'realestate'), osc_admin_render_theme_url('oc-content/themes/realestate/admin/logo_settings.php'), 'header_realestate');
    osc_admin_menu_appearance(__('Theme settings', 'realestate'), osc_admin_render_theme_url('oc-content/themes/realestate/admin/admin_settings.php'), 'settings_realestate');
}

$sQuery = osc_get_preference('keyword_placeholder', 'realestate');
osc_add_hook('footer', 'fjs_search');
if (!function_exists('fjs_search')) {
    function fjs_search()
    {
        echo "\n";
        ?>
        <script type="text/javascript">
            var sQuery = '<?php echo osc_esc_js(osc_get_preference('keyword_placeholder', 'realestate')); ?>';
            $(document).ready(function () {
                var element = $('input[name="sPattern"]');
                element.focus(function () {
                    $(this).prev().hide();
                }).blur(function () {
                    if ($(this).val() == '') {
                        $(this).prev().show();
                    }
                }).prev().click(function () {
                    $(this).hide();
                    $(this).next().focus();
                });
                if (element.val() != '') {
                    element.prev().hide();
                }
                <?php if(osc_locale_thousands_sep() != '' || osc_locale_dec_point() != '') { ?>
                $("#price").blur(function (event) {
                    var price = $("#price").attr("value");
                    <?php if(osc_locale_thousands_sep() != '') { ?>
                    while (price.indexOf('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>') != -1) {
                        price = price.replace('<?php echo osc_esc_js(osc_locale_thousands_sep());  ?>', '');
                    }
                    <?php }; ?>
                    <?php if(osc_locale_dec_point() != '') { ?>
                    var tmp = price.split('<?php echo osc_esc_js(osc_locale_dec_point())?>');
                    if (tmp.length > 2) {
                        price = tmp[0] + '<?php echo osc_esc_js(osc_locale_dec_point())?>' + tmp[1];
                    }
                    <?php }; ?>
                    $("#price").attr("value", price);
                });
                <?php }; ?>
            });
            function doSearch() {
                var sPattern = $('input[name=sPattern]');
                var text = '<?php echo osc_esc_js(__('Your search must be at least three characters long', 'realestate')); ?>';
                if ((sPattern.hasClass('js-input-home') && sPattern.val() == '' && sPattern.val().length < 3) || (sPattern.val() != '' && sPattern.val().length < 3)) {
                    $('#message-seach').text(text).show();
                    return false;
                }
                return true;
            }
        </script>
        <?php
    }
}

// hacks to work with < 2.4 versions
if (!defined('OC_ADMIN')) {
    define('OC_ADMIN', false);
}

if (!function_exists('meta_title')) {
    function meta_title()
    {
        $location = Rewrite::newInstance()->get_location();
        $section = Rewrite::newInstance()->get_section();

        switch ($location) {
            case ('item'):
                switch ($section) {
                    case 'item_add':
                        $text = __('Publish an item', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case 'item_edit':
                        $text = __('Edit your item', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case 'send_friend':
                        $text = __('Send to a friend', 'realestate') . ' - ' . osc_item_title() . ' - ' . osc_page_title();
                        break;
                    case 'contact':
                        $text = __('Contact seller', 'realestate') . ' - ' . osc_item_title() . ' - ' . osc_page_title();
                        break;
                    default:
                        $text = osc_item_title() . ' - ' . osc_page_title();
                        break;
                }
                break;
            case('page'):
                $text = osc_static_page_title() . ' - ' . osc_page_title();
                break;
            case('error'):
                $text = __('Error', 'realestate') . ' - ' . osc_page_title();
                break;
            case('search'):
                $region = Params::getParam('sRegion');
                $city = Params::getParam('sCity');
                $pattern = Params::getParam('sPattern');
                $category = osc_search_category_id();
                $category = ((count($category) == 1) ? $category[0] : '');
                $s_page = '';
                $i_page = Params::getParam('iPage');

                if ($i_page != '' && $i_page > 0) {
                    $s_page = __('page', 'realestate') . ' ' . ($i_page + 1) . ' - ';
                }

                $b_show_all = ($region == '' && $city == '' & $pattern == '' && $category == '');
                $b_category = ($category != '');
                $b_pattern = ($pattern != '');
                $b_city = ($city != '');
                $b_region = ($region != '');

                if ($b_show_all) {
                    $text = __('Show all items', 'realestate') . ' - ' . $s_page . osc_page_title();
                }

                $result = '';
                if ($b_pattern) {
                    $result .= $pattern . ' &raquo; ';
                }

                if ($b_category) {
                    $list = array();
                    $aCategories = Category::newInstance()->toRootTree($category);
                    if (count($aCategories) > 0) {
                        foreach ($aCategories as $single) {
                            $list[] = $single['s_name'];
                        }
                        $result .= implode(' &raquo; ', $list) . ' &raquo; ';
                    }
                }

                if ($b_city) {
                    $result .= $city . ' &raquo; ';
                }

                if ($b_region) {
                    $result .= $region . ' &raquo; ';
                }

                $result = preg_replace('|\s?&raquo;\s$|', '', $result);

                if ($result == '') {
                    $result = __('Search', 'realestate');
                }

                $text = $result . ' - ' . $s_page . osc_page_title();
                break;
            case('login'):
                switch ($section) {
                    case('recover'):
                        $text = __('Recover your password', 'realestate') . ' - ' . osc_page_title();
                    default:
                        $text = __('Login', 'realestate') . ' - ' . osc_page_title();
                }
                break;
            case('register'):
                $text = __('Create a new account', 'realestate') . ' - ' . osc_page_title();
                break;
            case('user'):
                switch ($section) {
                    case('dashboard'):
                        $text = __('Dashboard', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case('items'):
                        $text = __('Manage my items', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case('alerts'):
                        $text = __('Manage my alerts', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case('profile'):
                        $text = __('Update my profile', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case('change_email'):
                        $text = __('Change my email', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case('change_password'):
                        $text = __('Change my password', 'realestate') . ' - ' . osc_page_title();
                        break;
                    case('forgot'):
                        $text = __('Recover my password', 'realestate') . ' - ' . osc_page_title();
                        break;
                    default:
                        $text = osc_page_title();
                        break;
                }
                break;
            case('contact'):
                $text = __('Contact', 'realestate') . ' - ' . osc_page_title();
                break;
            default:
                $text = osc_page_title();
                break;
        }

        $text = str_replace("\n", '', $text);
        $text = trim($text);
        $text = osc_esc_html($text);
        return (osc_apply_filter('meta_title_filter', $text));
    }
}

if (!function_exists('meta_description')) {
    function meta_description()
    {
        $location = Rewrite::newInstance()->get_location();
        $section = Rewrite::newInstance()->get_section();
        $text = '';

        switch ($location) {
            case ('item'):
                switch ($section) {
                    case 'item_add':
                        $text = '';
                        break;
                    case 'item_edit':
                        $text = '';
                        break;
                    case 'send_friend':
                        $text = '';
                        break;
                    case 'contact':
                        $text = '';
                        break;
                    default:
                        $text = osc_item_category() . ', ' . osc_highlight(strip_tags(osc_item_description()), 140) . '..., ' . osc_item_category();
                        break;
                }
                break;
            case('page'):
                $text = osc_highlight(strip_tags(osc_static_page_text()), 140, '', '');
                break;
            case('search'):
                $result = '';

                if (osc_count_items() == 0) {
                    $text = '';
                }

                if (osc_has_items()) {
                    $result = osc_item_category() . ', ' . osc_highlight(strip_tags(osc_item_description()), 140) . '..., ' . osc_item_category();
                }

                osc_reset_items();
                $text = $result;
                break;
            case(''): // home
                $result = '';
                if (osc_count_latest_items() == 0) {
                    $text = '';
                }

                if (osc_has_latest_items()) {
                    $result = osc_item_category() . ', ' . osc_highlight(strip_tags(osc_item_description()), 140) . '..., ' . osc_item_category();
                }

                osc_reset_latest_items();
                $text = $result;
                break;
        }

        $text = str_replace("\n", '', $text);
        $text = trim($text);
        $text = osc_esc_html($text);
        return (osc_apply_filter('meta_description_filter', $text));
    }
}

/* ads  SEARCH */
if (!function_exists('search_ads_listing_top_fn')) {
    function search_ads_listing_top_fn()
    {
        if (osc_get_preference('search-results-top-728x90', 'realestate') != '') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-top-728x90', 'realestate');
            echo '</div>' . PHP_EOL;
        }
    }
}
osc_add_hook('search_ads_listing_top', 'search_ads_listing_top_fn');

if (!function_exists('search_ads_listing_medium_fn')) {
    function search_ads_listing_medium_fn()
    {
        if (osc_get_preference('search-results-middle-728x90', 'realestate') != '') {
            echo '<div class="clear"></div>' . PHP_EOL;
            echo '<div class="ads_728">' . PHP_EOL;
            echo osc_get_preference('search-results-middle-728x90', 'realestate');
            echo '</div>' . PHP_EOL;
        }
    }
}
osc_add_hook('search_ads_listing_medium', 'search_ads_listing_medium_fn');

if (!function_exists('realestate_default_location_show_as')) {
    function realestate_default_location_show_as()
    {
        return osc_get_preference('defaultLocationShowAs', 'realestate');
    }
}

osc_register_script('jquery-validate-realestate', osc_current_web_theme_js_url('jquery.validate.min.js'), 'jquery');
function realestate_scripts()
{
    osc_enqueue_script('jquery-validate-realestate');
}

osc_add_hook('init', 'realestate_scripts');

function send_email($title, $body)
{

    $admin = '77-10-77@mail.ru';

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit";

    return mail($admin, $title,
        $body, $headers);

}

//order_call
$ajax_order_call = 'order_call';

osc_add_hook('ajax_' . $ajax_order_call, $ajax_order_call);

function order_call()
{
    osc_csrf_check();

    // get request parameters
    $name = htmlspecialchars(Params::getParam('name'));
    $tel = htmlspecialchars(Params::getParam('tel'));

    if (!empty($name) && !empty($tel)) {

        $title = 'Заказ обратного звонка';
        $body = '<p>Имя - ' . $name .'</p>';
        $body .= '<p>телефон - ' . $tel.'</p>';

        // do some logic here ex: check if user is logged in
        if (send_email($title, $body)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        // return json response
        header('Content-Type: application/json');
        echo json_encode($response);

    }else{
        echo false;
    }
    exit;
}

//order_call
$ajax_submit_application = 'submit_application';

osc_add_hook('ajax_' . $ajax_submit_application, $ajax_submit_application);

function submit_application()
{

    osc_csrf_check();

    // get request parameters
    $name = htmlspecialchars(Params::getParam('name'));
    $tel = htmlspecialchars(Params::getParam('tel'));
    $select = htmlspecialchars(Params::getParam('select'));
    $address = htmlspecialchars(Params::getParam('address'));
    $cost = intval(Params::getParam('cost'));
    $desc = htmlspecialchars(Params::getParam('desc'));
    $add = htmlspecialchars(Params::getParam('add'));

    if ( !empty($name)
        && !empty($tel)
        && !empty($select)
        && !empty($address)
        && !empty($cost)
        && !empty($desc)
        && !empty($add)
    ) {

        $title = 'Заявка';
        $body = '<p>Имя - ' . $name .'</p>';
        $body .= '<p>телефон - ' . $tel.'</p>';
        $body .= '<p>Категория - ' . $select.'</p>';
        $body .= '<p>Адрес - ' . $address.'</p>';
        $body .= '<p>Цена - ' . $cost.'</p>';
        $body .= '<p>Описание - ' . $desc.'</p>';
        $body .= '<p>Доп. информация - ' . $add.'</p>';

        // do some logic here ex: check if user is logged in
        if (send_email($title, $body)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        // return json response
        header('Content-Type: application/json');
        echo json_encode($response);

    }else{
        echo false;
    }
    exit;
}

//feedback
$ajax_feedback = 'feedback';

osc_add_hook('ajax_' . $ajax_feedback, $ajax_feedback);

function feedback()
{
    osc_csrf_check();

    // get request parameters

    $tel = htmlspecialchars(Params::getParam('tel'));
    $name = htmlspecialchars(Params::getParam('name'));
    $msg = htmlspecialchars(Params::getParam('msg'));

    if (!empty($tel) && !empty($name) && !empty($msg)) {

        $title = 'Заявка';
        $body = '<p>телефон - ' . $tel .'</p>';
        $body .= '<p>Имя - ' . $name .'</p>';
        $body .= '<p>Сообщение - ' . $msg .'</p>';

        // do some logic here ex: check if user is logged in
        if (send_email($title, $body)) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        // return json response
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

function getAllCities(){
    $arr =  City::newInstance()->listAll();

    return $arr;
}

//session get
$ajax_session_get = 'session_get';

osc_add_hook('ajax_' . $ajax_session_get, $ajax_session_get);

function session_get()
{
    $response['city'] = '';
    $response['cityId'] = '';

    $response['city'] = Session::newInstance()->_get('city');
    $response['cityId'] = Session::newInstance()->_get('cityId');
    if($response['city']){
        if(!$response['cityId']){
            $city = City::newInstance()->findByName($response['city']);
            $response['cityId'] = $city['pk_i_id'];
        }
    }
    // return json response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
//order_call
$ajax_session_set = 'session_set';

osc_add_hook('ajax_' . $ajax_session_set, $ajax_session_set);

function session_set()
{
    $response = [];
    // get request parameters
    $city = htmlspecialchars(Params::getParam('city'));
    if($city){
        Session::newInstance()->_set('city', $city);
        $response['city'] = $city;
        $citym = City::newInstance()->findByName($response['city']);
        $response['cityId'] = $citym['pk_i_id'];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;

}

if (!function_exists('categories_list')) {
    function categories_list()
    {
        $total_categories = osc_count_categories();
        $col1_max_cat = ceil($total_categories / 3);

        osc_goto_first_category();
        $i = 0; ?>
        <ul class="categories-list">
            <?php while (osc_has_categories()) { ?>
                <li class="categories-list__item">

                    <p class="categories-list__caption">
                        <?php
                        $_slug = osc_category_slug();
                        $_url = osc_search_category_url();
                        $_name = osc_category_name();
                        $_total_items = osc_category_total_items();

                        if ($_total_items > 0) { ?>
                            <a class="category <?php echo $_slug; ?>"
                               href="<?php echo $_url; ?>"><?php echo $_name; ?></a>
                        <?php } else { ?>
                            <span class="category <?php echo $_slug; ?>"><?php echo $_name; ?></span>

                        <?php } ?>
                    </p>
                    <?php if (osc_count_subcategories() > 0) { ?>
                        <ul class="categories-list__sub">
                            <?php while (osc_has_subcategories()) { ?>
                                <li>
                                    <?php if (osc_category_total_items() > 0) { ?>
                                        <a class="category sub-category <?php echo osc_category_slug(); ?>"
                                           href="<?php echo osc_search_category_url(); ?>"><?php echo osc_category_name(); ?></a>

                                    <?php } else { ?>
                                        <span class="category sub-category <?php echo osc_category_slug(); ?>"><?php echo osc_category_name(); ?></span>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                </li>
                <?php
                $i++;
            } ?>
        </ul>
    <?php
    }
}

function rs( $length = 8 ) { $chars = "abcdefghijklmnopqrstuvwxyz0123456789"; $rs = substr( str_shuffle( $chars ), 0, $length ); return $rs; }

function geturl(){
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    return $actual_link;
}

if( !function_exists('related_listings') ) {
    function related_listings() {
        View::newInstance()->_exportVariableToView('items', array());

        $mSearch = new Search();
        $mSearch->addCategory(osc_item_category_id());
        $mSearch->addRegion(osc_item_region());
        $mSearch->addItemConditions(sprintf("%st_item.pk_i_id < %s ", DB_TABLE_PREFIX, osc_item_id()));
        $mSearch->limit('0', '5');

        $aItems      = $mSearch->doSearch();
        $iTotalItems = count($aItems);
        if( $iTotalItems == 5 ) {
            View::newInstance()->_exportVariableToView('items', $aItems);
            return $iTotalItems;
        }
        unset($mSearch);

        $mSearch = new Search();
        $mSearch->addCategory(osc_item_category_id());
        $mSearch->addItemConditions(sprintf("%st_item.pk_i_id != %s ", DB_TABLE_PREFIX, osc_item_id()));
        $mSearch->limit('0', '5');

        $aItems = $mSearch->doSearch();
        $iTotalItems = count($aItems);
        if( $iTotalItems > 0 ) {
            View::newInstance()->_exportVariableToView('items', $aItems);
            return $iTotalItems;
        }
        unset($mSearch);

        return 0;
    }
}