<?php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $name = htmlspecialchars(Params::getParam('name'));
    $url = htmlspecialchars(Params::getParam('url'));
    $orderliness = intval(Params::getParam('orderliness'));
    if (!empty($name) && !empty($url) && $orderliness > 0) {

        $response['name'] = $name;
        $response['url'] = $url;
        $response['orderliness'] = $orderliness;

        $res = Models_Menu::newInstance()->add($response);
        // do some logic here ex: check if user is logged in
        if ($res['res']) {
            $response['id'] = $res['id'];
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
