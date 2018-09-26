<?php

// get request parameters
$name = htmlspecialchars(Params::getParam('name'));

if (!empty($name)) {
    $response['name'] = $name;
    // do some logic here ex: check if user is logged in
    if (Models_Advantages::newInstance()->deleteImage($name)) {

        $response['status'] = true;
    } else {
        $response['status'] = false;
    }

    // return json response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

