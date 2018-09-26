<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $id = htmlspecialchars(Params::getParam('id'));

    $title = htmlspecialchars(Params::getParam('title'));
    $description = htmlspecialchars(Params::getParam('description'));
    $orderliness  = intval(Params::getParam('orderliness'));
    if (!empty($title) && !empty($description) && $id > 0) {

        $response['id'] = $id;
        $response['title'] = $title;
        $response['description'] = $description;
        $response['orderliness'] = $orderliness;

        // do some logic here ex: check if user is logged in
        if (Models_Vopros::newInstance()->updateMenu($response)) {
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
