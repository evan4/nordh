<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

// get request parameters
    $id = intval(Params::getParam('id'));

    if ($id > 0) {

        // do some logic here ex: check if user is logged in
        if (Models_Advantages::newInstance()->deleteByPrimaryKey($id)) {
            Models_Advantages::newInstance()->deleteImage($id);
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        // return json response
        header('Content-Type: application/json');
        $jsonstring = json_encode($response);
        die($jsonstring);
    }
}
