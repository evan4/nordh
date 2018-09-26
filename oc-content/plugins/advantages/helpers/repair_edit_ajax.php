<?php
$upload_path = osc_content_path() . 'uploads/advantages';
// get request parameters
$id = htmlspecialchars(Params::getParam('id'));

$title = htmlspecialchars(Params::getParam('title'));
$description = Params::getParam('description');
$orderliness = intval(Params::getParam('orderliness'));
if (!empty($title) && $id > 0) {


    $response['title'] = $title;
    $response['description'] = $description;
    $response['orderliness'] = $orderliness;

    $fileBase = basename($_FILES['photo']['name'][0]);
    $fileName = pathinfo($fileBase, PATHINFO_FILENAME);
    $fileExt = pathinfo($fileBase, PATHINFO_EXTENSION);
    $fileTmp = $_FILES['photo']['tmp_name'][0];
    if ($fileBase !== '') {
        // Construct destination path
        $fileDst = $upload_path . '/' . $id . '.' . $fileExt;

        // Move the file
        if (move_uploaded_file($fileTmp, $fileDst)) {

            $response['avatar'] = $id . '.' . $fileExt;
            Models_Advantages::newInstance()->updateItem(
                [
                    'title' =>  $title,
                    'description' => $description,
                    'orderliness' => $orderliness,
                    'avatar' =>  $response['avatar']
                ],
                $id
            );
        }
    }else{
        Models_Advantages::newInstance()->updateItem(
            [
                'title' =>  $title,
                'description' => $description,
                'orderliness' => $orderliness
            ],
            $id
        );
    }

    $response['id'] = $id;
    $response['status'] = true;


    // return json response
    header('Content-Type: application/json');
    $jsonstring = json_encode($response);
    die($jsonstring);
}

