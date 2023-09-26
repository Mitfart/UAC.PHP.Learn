<?php
require_once "products.php";

$images_dir = 'images';

$idParam = "id";
$nameParam = "name";
$imageParam = "image";
$descriptionParam = "description";
$tagParam = "tag";

$id = $_POST["id"];

$stmt = $server->prepare("
             SELECT *
             FROM $tb_products 
             WHERE id = :$idParam
        ");
$products = $stmt->execute(array($idParam => $id));
$product = $stmt->fetch(PDO::FETCH_ASSOC);


if (isset($_POST["update"]))
    try {
        if (isset($_FILES["image"])) {
            $img_file = diverse_array($_FILES["image"]);
            $img_error = $img_file["error"];
            $img_name = $img_file["name"];

            if (strpos($_FILES["image"]["type"], "image") === false) {
                if ($img_error == UPLOAD_ERR_OK) {
                    $tmp_name = $img_file["tmp_name"];
                    $name = basename($img_file["name"]);
                    move_uploaded_file($tmp_name, "$images_dir/$name");

                    $stmt_change_image = $server->prepare("
                        UPDATE $tb_products 
                        SET image = :$imageParam
                        WHERE id = :$idParam
                    ")->execute(array(
                        $idParam => $id,
                        $imageParam => $img_name
                    ));
                }
            }
        }


        if (isset($_POST["name"])) {
            $server->prepare("
                UPDATE $tb_products 
                SET name = :$nameParam
                WHERE id = :$idParam
            ")->execute(array(
                $idParam => $id,
                $nameParam => $_POST["name"]
            ));
        }


        if (isset($_POST["description"])) {
            $server->prepare("
                UPDATE $tb_products 
                SET description = :$descriptionParam
                WHERE id = :$idParam
            ")->execute(array(
                $idParam => $id,
                $descriptionParam => $_POST["description"]
            ));
        }


        if (isset($_POST["tag"])) {
            $server->prepare("
                UPDATE $tb_products 
                SET tag = :$tagParam
                WHERE id = :$idParam
            ")->execute(array(
                $idParam => $id,
                $tagParam => $_POST["tag"]
            ));
        }

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
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
    <h3> Update Product </h3>

    <form method="post" enctype="multipart/form-data">
        <input type='hidden' name='id' value="<?= $id ?>"/>

        <div class="mb-3">
            <label for="name"
                   class="form-label">
                Name
            </label>
            <input id="name"
                   type="text"
                   class="form-control"
                   name="name"
                   value="<?= $product["name"] ?>"
            >
        </div>
        <div class="mb-3">
            <label for="description"
                   class="form-label">
                Description
            </label>
            <textarea id="description"
                      class="form-control"
                      name="description"
            ><?= $product["description"] ?></textarea>
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
                   value="<?= $product["tag"] ?>"
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
                   name="image"
                   value="<?= $image ?>"
            >
        </div>
        <div class="d-flex gap-2 mb-3">
            <img src="<?= "$images_dir/{$product['image']}" ?>"
                 alt="<?= $product["image"] ?>"
                 class="rounded"
                 style="width: 250px"
            >
            <?php
            if ($validImage) { ?>
                <img src="<?= "$images_dir/{$product['image']}" ?>"
                     alt="<?= $image ?>"
                     class="rounded"
                     style="width: 250px">
                <?php
            }
            ?>
        </div>

        <button type="submit"
                name="update"
                class="btn btn-primary">
            Update
        </button>
    </form>
</div>
</body>
</html>