<?php
/*
Plugin Name: Ad Importer
Plugin URI: http://www.osclass.org/
Description: Import ads easily from other sources.
Version: 0.6.0
Author: Osclass
Author URI: http://www.osclass.org/
Short Name: ad_importer
Plugin update URI: ad-importer
*/
require_once __DIR__ . "/../user_photo/Profile.php";

function adimporter_admin_menu()
{

    osc_add_admin_submenu_page(
        'plugins',
        __('Ad Importer', 'adimporter'),
        osc_admin_render_plugin_url(osc_plugin_folder(__FILE__) . "importer.php"),
        'importer',
        'moderator'
    );

}

function adimporter_countads($file)
{
    $xml = new DOMDocument();
    $xml->load($file);
    $listings = $xml->getElementsByTagName('offer');

    return $listings->length;
}


function adimporter_readxml($file)
{

    $xml = new DOMDocument();
    $xml->load($file);

    $listings = $xml->getElementsByTagName('offer');

    $cat_info = array();
    $meta_info = array();

    $errormsg = '';
    foreach ($listings as $klisting => $listing) {

        list($success, $cat_info, $meta_info) = adimporter_ad($listing, $cat_info, $meta_info);

        if ($success != 2) { //2 is the success code for active ads & 1 for inactive
            $errormsg .= sprintf(__("%s (Item %d)", "adimporter"), $success, $klisting) . "<br/>";
        }

        $delete_images = glob(osc_content_path() . "downloads/adimporterimage_*");
        foreach ($delete_images as $img) {
            @unlink($img);
        }
    }

    if ($errormsg != '') {
        osc_add_flash_error_message($errormsg, 'admin');
    } else {
        osc_add_flash_ok_message(__('All ads were imported correctly', 'adimporter'), 'admin');
    }
}

function adimporter_adfromfile($file, $num_ad, $cat_info = array(), $meta_info = array())
{
    $xml = new DOMDocument();
    $xml->load($file);
    $listings = $xml->getElementsByTagName('offer');

    $id = $listings->item($num_ad)->getAttribute('internal-id');
    $res = adimporter_ad($listings->item($num_ad), $id, $cat_info, $meta_info);

    return $res;
}

function adimporter_ad($listing, $id, $cat_info, $meta_info)
{
    $mItems = new ItemActions(true);

    $start_date = date("Y-m-d\TH:i:sO");
    $mod_date = $listing->getElementsByTagName("last-update-date")->item(0)->nodeValue;

    $res_date = floor(abs(strtotime($start_date) - strtotime($mod_date))/3600);

    $area = $listing->getElementsByTagName("area")->item(0);
    $area_value = $area->getElementsByTagName("value")->item(0)->nodeValue;
    if( substr($area_value, -2) == '00'){
        $area_value = round( $area_value);
    }
    $title_real= '';

    switch ($listing->getElementsByTagName("category")->item(0)->nodeValue) {
        case 'квартира':
            $catId = '101';
            if($listing->getElementsByTagName("rooms")->item(0)->nodeValue === 'Студия'){
                $title_real =  'Квартира-студия';
                $catId = '121';
            }else{
                $title_real = $listing->getElementsByTagName("rooms")->item(0)->nodeValue . '-комнатная квартира';
            }
            break;
        case 'комната':
            $catId = '107';
            $title_real = 'Комната ' . $area_value . ' кв. м';
            break;
        case 'гараж':
            $catId = '115';
            $title_real = $area_value . ' кв. м, гараж';
            break;
        case 'участок':
            $catId = '116';
            $title_real = 'Участок, ' . $area_value . ' соток';
            break;
        case 'дом':
            $catId = '110';
            $title['RU'] = 'Дом, ' . $area_value . ' кв. м';
            break;
        default:
            $catId = '101';
            $title_real = $listing->getElementsByTagName("rooms")->item(0)->nodeValue . '-комнатная квартира, ' . $area_value . ' кв. м';
    }
    $agent = $listing->getElementsByTagName("sales-agent")->item(0);
    $name = $agent->getElementsByTagName("name")->item(0)->nodeValue;
    $profile = Models_User_Photo::newInstance()->getByName($name);

    $photo = $agent->getElementsByTagName("photo")->item(0)->nodeValue;
    $photo_name = explode("/", $photo);

    if ($profile) {
        if (!file_exists(osc_content_path() . "uploads/profile/" . $photo_name[3]) || ($profile[0]['pic_ext'] !== $photo_name[3])) {
            Models_User_Photo::newInstance()->edit($profile[0]['id'], $photo, $photo_name[3]);
        }
    } else {
        Models_User_Photo::newInstance()->add($name, $photo, $photo_name[3]);
    }

    $location = $listing->getElementsByTagName("location")->item(0);

    $price = $listing->getElementsByTagName("price")->item(0);

    $agency_type = $agent->getElementsByTagName("category")->item(0)->nodeValue;
    if ($agency_type === 'agency') {
        $agency = 'Агентство ' . $agent->getElementsByTagName("organization")->item(0)->nodeValue;
    } else {
        $agency = $agent->getElementsByTagName("category")->item(0)->nodeValue;
    }

    Params::setParam("telephone", $agent->getElementsByTagName("phone")->item(0)->nodeValue);
    Params::setParam("agency", $agency);
    Params::setParam("idItem", $id);
    Params::setParam("country", 'Russia');
    Params::setParam("countryId", 'RU');
    Params::setParam("region", NULL);
    Params::setParam("city", $location->getElementsByTagName("locality-name")->item(0)->nodeValue);
    Params::setParam("cityArea", NULL);
    Params::setParam("address", $location->getElementsByTagName("address")->item(0)->nodeValue);
    Params::setParam("price", $price->getElementsByTagName("value")->item(0)->nodeValue);
    Params::setParam("currency", 'RUB');
    Params::setParam("contactName", $name);
    Params::setParam("contactEmail", $agent->getElementsByTagName("email")->item(0)->nodeValue);
    Params::setParam("dt_pub_date", $listing->getElementsByTagName("creation-date")->item(0)->nodeValue);
    Params::setParam("dt_mod_date", $mod_date);
    Params::setParam("showEmail", 1);
    Params::setParam("catId", $catId);
    Params::setParam("d_coord_lat", $location->getElementsByTagName("latitude")->item(0)->nodeValue);
    Params::setParam("d_coord_long", $location->getElementsByTagName("longitude")->item(0)->nodeValue);

    $image_list = $listing->getElementsByTagName("image");
    $custom_list = $listing->getElementsByTagName("custom");

    $title = array();
    $title['ru_RU'] = $title_real;
    $content = array();
    $content['ru_RU'] =$listing->getElementsByTagName("description")->item(0)->nodeValue;
    $photos = [];

    $meta_array = array();
    $l = $custom_list->length;
    for ($k = 0; $k < $l; $k++) {
        if ($custom_list->item($k)->hasAttributes()) {
            $attrs = $custom_list->item($k)->attributes;

            foreach ($attrs as $a) {
                if ($a->name == 'name') {
                    $field_name = $a->value;
                    if (isset($meta_info[$field_name])) {
                        $meta_array[$meta_info[$field_name]] = $custom_list->item($k)->nodeValue;
                    } else {
                        $cfield = Field::newInstance()->findBySlug($field_name);
                        if ($cfield) {
                            $meta_info[$field_name] = $cfield['pk_i_id'];
                            $meta_array[$meta_info[$field_name]] = $custom_list->item($k)->nodeValue;
                        }
                    }
                    break;
                }
            }
        }
    }
    if (!empty($meta_array)) {
        Params::setParam("meta", $meta_array);
    }

    foreach ($image_list as $k => $image) {
        $tmp_name = "adimporterimage_" . $k . '_' . microtime(true);
        $image_ok = osc_downloadFile($image->nodeValue, $tmp_name);
        if ($image_ok) {
            $photos['error'][] = 0;
            $photos['size'][] = 100;
            $photos['type'][] = 'image/jpeg';
            $photos['tmp_name'][] = osc_content_path() . "downloads/" . $tmp_name;
        }
    }
    $_FILES['photos'] = $photos;

    Params::setParam("title", $title);
    Params::setParam("description", $content);

    //Params::_view();
    Params::setParam("squareMeters", $area_value);
    if($listing->getElementsByTagName("rooms")->item(0)->nodeValue === 'Студия'){
        Params::setParam("numRooms", null);
    }else{
        Params::setParam("numRooms", (int)$listing->getElementsByTagName("rooms")->item(0)->nodeValue);
    }
    Params::setParam("floorNumber", (int)$listing->getElementsByTagName("floor")->item(0)->nodeValue);

    if($listing->getElementsByTagName("floor_count")->item(0)->nodeValue){
        Params::setParam("numFloors", (int)$listing->getElementsByTagName("floor_count")->item(0)->nodeValue);
    }else{
        Params::setParam("numFloors", null);
    }

    $mItems->prepareData(true);

    $item = Item::newInstance()->findByPrimaryKey($id);

    Params::setParam("s_secret", $item['s_secret']);;

    if ($item) {
        //if($res_date < 3){
            ItemActions::deleteResourcesFromHD($id, true);
            ItemResource::newInstance()->deleteAllResourcesFromItem($id);
            $success = $mItems->edit();
        /*}else{
            $success = true;
        }*/
    } else {
        $success = $mItems->add();
    }

    return array($success, $cat_info, $meta_info);
}

osc_register_plugin(osc_plugin_path(__FILE__), '');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", '');
osc_add_hook('admin_header', 'adimporter_admin_menu');

function upload_ads()
{

    $file = file_get_contents('http://nh.m2-soft.ru/api/apartment/getXMLsite');
    file_put_contents(osc_content_path() . 'uploads/temp/adimporter_ads.xml', $file);

    // Каталог files

    $uploadfile = osc_content_path() . 'uploads/temp/adimporter_ads.xml';

    $len = adimporter_countads($uploadfile);

    for ($i = 0; $i < $len; $i++) {
        adimporter_adfromfile($uploadfile, $i, null, null);
    }
}

function ad_cron()
{
    $file = file_get_contents('http://nh.m2-soft.ru/api/apartment/getXMLsite');
    file_put_contents(osc_content_path() . 'uploads/temp/adimporter_ads.xml', $file);

    // Каталог files

    $uploadfile = osc_content_path() . 'uploads/temp/adimporter_ads.xml';

    $len = adimporter_countads($uploadfile);

    for ($i = 0; $i < $len; $i++) {
        adimporter_adfromfile($uploadfile, $i, null, null);
    }
    $delete_images = glob(osc_content_path() . "downloads/adimporterimage_*");
    foreach ($delete_images as $img) {
        try {
            if (file_exists($img) && is_writable($img)) {
                unlink($img);
            }
        } catch (Exception $exc) {
            echo $exc->getMessage();
            echo $exc->getTraceAsString();
        }
    }
}

osc_add_hook('cron_hourly', 'ad_cron');