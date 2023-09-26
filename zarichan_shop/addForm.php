<?php
require_once "products.php";


$images_dir = 'images';

$isset = isset($_POST["name"])
    && isset($_POST["description"]);
$validImage = isset($_FILES["image"]) and strpos($_FILES["image"]["type"], "image") === false;

if ($isset and $validImage) {
    $nameParam = "name";
    $imageParam = "image";
    $descriptionParam = "description";

    $name = $_POST["name"];
    $description = $_POST["description"];
    $img_file = diverse_array($_FILES["image"]);
    $img_error = $img_file["error"];
    $img_name = $img_file["name"];

    try {
        if ($img_error == UPLOAD_ERR_OK) {
            $tmp_name = $img_file["tmp_name"];
            $name = basename($img_file["name"]);
            move_uploaded_file($tmp_name, "$images_dir/$name");
        }

        $stmt = $server->prepare("
            INSERT INTO $tb_products 
                (name, image, description, tag) 
            VALUES 
                (:$nameParam, :$imageParam, :$descriptionParam, :tagParam)
        ");
        $addedProducts = $stmt->execute(array(
            $nameParam => $name,
            $imageParam => $img_name,
            $descriptionParam => $description
        ));

        header("Location: index.php");
    } catch
    (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}


function diverse_array($infoArr)
{
    $result = array();
    foreach ($infoArr as $key => $valueArr) {
        if (is_array($valueArr)) {
            foreach ($valueArr as $i => $value) $result[$i][$key] = $value;
        } else {
            $result = $infoArr;
            break;
        }
    }
    return $result;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
          crossorigin="anonymous">

    <title>Images</title>
</head>
<body>
<div class="container py-5">
    <h3> Add Product </h3>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name"
                   class="form-label">
                Name
            </label>
            <input id="name"
                   type="text"
                   class="form-control"
                   name="name">
        </div>
        <div class="mb-3">
            <label for="description"
                   class="form-label">
                Description
            </label>
            <textarea id="description"
                      class="form-control"
                      name="description"
            ></textarea>
        </div>
        <div class="mb-3">
            <label for="tag"
                   class="form-label">
                Tags
            </label>
            <input id="tag"
                   type="text"
                   class="form-control"
                   name="tag"
            >
        </div>
        <div class="mb-3">
            <label for="image"
                   class="form-label">
                Image
            </label>
            <input id="image"
                   type="file"
                   class="form-control"
                   name="image">

            <?php if (!$validImage) echo "Enter image!" ?>
        </div>
        <button type="submit"
                class="btn btn-primary">
            Add
        </button>
    </form>
</div>
</body>
</html>