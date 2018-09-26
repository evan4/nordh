<?php

$upload_path = osc_content_path() . 'uploads/advantages';

if (!is_dir($upload_path)) {
    mkdir($upload_path, 0777);
}
$title = htmlspecialchars(Params::getParam('title'));
$description = Params::getParam('description');
$orderliness = intval(Params::getParam('orderliness'));
if (!empty($title) && $orderliness > 0) {

    $response['title'] = $title;
    $response['description'] = $description;
    $response['orderliness'] = $orderliness;

    $res = Models_Advantages::newInstance()->add($response);
    // do some logic here ex: check if user is logged in
    // Get base info

    $fileBase = basename($_FILES['photo']['name'][0]);
    $fileName = pathinfo($fileBase, PATHINFO_FILENAME);
    $fileExt = pathinfo($fileBase, PATHINFO_EXTENSION);
    $fileTmp = $_FILES['photo']['tmp_name'][0];
    if($fileBase !== ''){
        // Construct destination path
        $fileDst = $upload_path . '/' . $res['id'].'.'.$fileExt;

        // Move the file
        if (move_uploaded_file($fileTmp, $fileDst)) {
            $response['avatar'] = $res['id'].'.'.$fileExt;
            Models_Advantages::newInstance()->updateItem(
                [
                    'avatar' =>  $response['avatar']
                ],
                $res['id']
            );
        }
    }

    $response['id'] = $res['id'];

    $response['status'] = true;

    // return json response
    header('Content-Type: application/json');
    $jsonstring = json_encode($response);
    die($jsonstring);
}

