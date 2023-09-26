<?php
require_once "products.php";

if (!isset($_POST["name"])) echo "Name is not set";
if (!isset($_POST["description"])) echo "Description is not set";

$isset = isset($_POST["name"])
    && isset($_POST["description"])
    && isset($_FILES["image"]);
$validImage = strpos($_FILES["image"]["type"], "image") === false;

if ($isset and $validImage) {
    $nameParam = ":name";
    $imageParam = ":image";
    $descriptionParam = ":description";

    $name = $_POST["name"];
    $description = $_POST["description"];
    $image_file = $_FILES["image"];

    try {
        $sql = "
            INSERT INTO $tb_products 
                (name, image, description) 
            VALUES 
                ($name, $image_file, $description)
        ";

        echo "Add: [ $nameParam: $name, $descriptionParam: $description, $imageParam: $image ]";

        $stmt = $server->prepare($sql);
        $stmt->bindValue($nameParam, $name);
        $stmt->bindValue($descriptionParam, $description);
        $stmt->bindValue($imageParam, $image);
        $addedProducts = $stmt->execute();

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
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
<div class="container">
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
                      name="description"></textarea>
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