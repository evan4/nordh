<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $id = htmlspecialchars(Params::getParam('id'));

    $name = htmlspecialchars(Params::getParam('name'));
    $url = htmlspecialchars(Params::getParam('url'));
    $orderliness  = intval(Params::getParam('orderliness'));
    if (!empty($name) && !empty($url) && $id > 0) {

        $response['id'] = $id;
        $response['name'] = $name;
        $response['url'] = $url;
        $response['orderliness'] = $orderliness;

        // do some logic here ex: check if user is logged in
        if (Models_Menu_Repair::newInstance()->updateMenu($response)) {
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
