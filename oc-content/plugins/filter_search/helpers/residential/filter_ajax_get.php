<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $parent_id = intval(Params::getParam('parent'));

    if ($parent_id > 0) {

        $response['res'] = Models_Residential::newInstance()->getByCityId($parent_id);
        // do some logic here ex: check if user is logged in
        if ($response['res']) {
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
