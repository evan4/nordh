<?php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $title = htmlspecialchars(Params::getParam('title'));
    $description = htmlspecialchars(Params::getParam('description'));
    $description_list = htmlspecialchars(Params::getParam('description_list'));
    $orderliness = intval(Params::getParam('orderliness'));
    if (!empty($title) && !empty($description) && $orderliness > 0) {

        $response['title'] = $title;
        $response['description'] = $description;
        $response['description_list'] = $description_list;
        $response['orderliness'] = $orderliness;
        $res = Models_Types_Repair::newInstance()->add($response);
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
