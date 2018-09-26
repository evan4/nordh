<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $name = htmlspecialchars(Params::getParam('name'));
    $id = intval(Params::getParam('id'));

    if (!empty($name) && $id > 0) {

        $response['name'] = $name;

        $response['id'] = $id;

        // do some logic here ex: check if user is logged in
        if (Models_Districts::newInstance()->updateDistrict($response)) {
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
