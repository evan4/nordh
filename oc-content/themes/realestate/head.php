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
osc_register_script('maps', '//api-maps.yandex.ru/2.1/?load=package.full&amp;lang=ru-RU');
osc_register_script('magnific', osc_current_web_theme_js_url('libs/magnific-full.js'), array('jquery'));
osc_register_script('selectize', osc_current_web_theme_js_url('libs/selectize.min.js'), array('jquery'));
osc_register_script('script', osc_current_web_theme_js_url('script.js'), array('jquery'));


osc_enqueue_script('maps');
osc_enqueue_script('magnific');
osc_enqueue_script('selectize');
osc_enqueue_script('script'); ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,500" rel="stylesheet">
<?php osc_enqueue_style('style', osc_current_web_theme_styles_url('style.css'));
?>
<meta charset="utf-8" >
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo meta_title() ; ?></title>
<meta name="title" content="<?php echo meta_title() ; ?>" />
<meta name="description" content="<?php echo meta_description() ; ?>" />
<meta Http-Equiv="Cache-Control" Content="no-cache">
    <meta Http-Equiv="Pragma" Content="no-cache">
    <meta http-equiv="Expires" content="Fri, Jan 01 1970 00:00:00 GMT" />
    <script type="text/javascript">
        var fileDefaultText = '<?php echo osc_esc_js( __('No file selected', 'realestate') ) ; ?>';
        var fileBtnText     = '<?php echo osc_esc_js( __('Choose File', 'realestate') ) ; ?>';

        //here we hold some usefull info for easy access
        var mySite = window.mySite || {};
        mySite.base_url = '<?php echo osc_base_url(true); ?>';
        mySite.csrf_token = '<?php echo osc_csrf_token_url(); ?>';
    </script>
<?php osc_run_hook('header') ; ?>