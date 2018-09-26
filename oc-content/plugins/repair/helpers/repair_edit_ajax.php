<?php
$upload_path = osc_content_path().'uploads/repair';
// get request parameters
$id = htmlspecialchars(Params::getParam('id'));

$title = htmlspecialchars(Params::getParam('title'));
$description = Params::getParam('description');
$orderliness = intval(Params::getParam('orderliness'));
if (!empty($title) && !empty($description) && $id > 0) {

    $response['id'] = $id;
    $response['title'] = $title;
    $response['description'] = $description;
    $response['orderliness'] = $orderliness;

    // do some logic here ex: check if user is logged in
    Models_Repair::newInstance()->updateItem($response);
    $response['status'] = true;
    // Result arrays
    $errors = $output = array();

    for ($i = 0; isset($_FILES['photo']['name'][$i]); $i++) {
        $fileName = $_FILES['photo']['name'][$i];
        $fileSize = $_FILES['photo']['size'][$i];
        $fileErr = $_FILES['photo']['error'][$i];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // File move loop
        for ($i = 0; isset($_FILES['photo']['name'][$i]); $i++) {

            // Get base info
            $fileBase = basename($_FILES['photo']['name'][$i]);
            $fileName = pathinfo($fileBase, PATHINFO_FILENAME);
            $fileExt = pathinfo($fileBase, PATHINFO_EXTENSION);
            $fileTmp = $_FILES['photo']['tmp_name'][$i];

            // Construct destination path
            $tmp = microtime(true);
            $name = $response['id'] . '_' . $tmp . '_' . basename($_FILES['photo']['name'][$i]);
            $fileDst = $upload_path . '/' . $name;
            for ($j = 0; file_exists($fileDst); $j++) {
                $fileDst = "$upload_path/$fileName-$j.$fileExt";
            }

            // Move the file
            if (move_uploaded_file($fileTmp, $fileDst)) {
                $output[$fileBase] = "Stored $fileBase OK";
                $arr = [
                    'id' => $response['id'],
                    'name' => $name
                ];
                $response['image'][] = $name;
                $path = $upload_path . '/preview_' . $response['id'] . '_' . $tmp . '_' . basename($_FILES['photo']['name'][$i]);
                ImageProcessing::fromFile($fileDst)->resizeTo('300px', '300px')->saveToFile($path);

                Models_Repair_Images::newInstance()->add($arr);
            }

        }
    }

    // return json response
    header('Content-Type: application/json');
    $jsonstring = json_encode($response);
    die($jsonstring);
}

