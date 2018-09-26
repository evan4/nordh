<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $name = htmlspecialchars(Params::getParam('name'));
    $parent_id = intval(Params::getParam('parent'));

    if (!empty($name) && $parent_id > 0) {

        $response['parent'] = $parent_id;

        $response['name'] = $name;

        $res = Models_Residential::newInstance()->insertNewDistrict($response);
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
