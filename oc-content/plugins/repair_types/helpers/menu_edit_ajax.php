<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $id = htmlspecialchars(Params::getParam('id'));

    $title = htmlspecialchars(Params::getParam('title'));
    $description = htmlspecialchars(Params::getParam('description'));
    $description_list = htmlspecialchars(Params::getParam('description_list'));
    $orderliness  = intval(Params::getParam('orderliness'));
    if (!empty($title) && !empty($description) && $id > 0) {

        $response['id'] = $id;
        $response['title'] = $title;
        $response['description'] = $description;
        $response['description_list'] = $description_list;
        $response['orderliness'] = $orderliness;

        // do some logic here ex: check if user is logged in
        if (Models_Types_Repair::newInstance()->updateMenu($response)) {
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
