<?php
require_once "products.php";

$filter_enabled = isset($_POST["filter_submit"]) && !empty($_POST["filter"]);
$filter = $filter_enabled ? $_POST["filter"] : '';
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
<div class="container p-5">
    <div class="d-flex justify-content-between">
        <h1 class="feature-title"> Products: </h1>
        <form method="post" class="input-group w-auto">
            <input name="filter" type="text" class="form-control">
            <button name="filter_submit" type="submit" class="btn btn-primary">filter</button>
        </form>
    </div>

    <div class="d-flex flex-column align-items-stretch gap-3 my-5">
        <?php
        $query = "
            SELECT * 
            FROM $tb_products
        ";

        if ($filter_enabled) $query .= " WHERE tag like '%$filter%'";
        $products_filtered = $server->query($query);
        foreach ($products_filtered as $product) {
            ?>
            <div class="d-flex align-items-stretch gap-3 border rounded">
                <img class="img-fluid" style="width: 150px" src="./images/<?= $product["image"] ?>"
                     alt="<?= $product["image"] ?>">
                <div class="col">
                    <h3 class="feature-title"><?= $product["name"] ?></h3>
                    <p class="flex-grow-1"><?= $product["description"] ?></p>
                    <p class="fw-light fst-italic">Tags: <?= $product["tag"] ?></p>
                </div>
                <div class="d-flex align-items-center gap-2 p-4">
                    <form action='updateForm.php' method='post'>
                        <input type='hidden' name='id' value="<?= $product["id"] ?>"/>
                        <button type="submit" class="btn btn-primary w-100" value='Delete'>Upd</button>
                    </form>
                    <form action='delete.php' method='post'>
                        <input type='hidden' name='id' value="<?= $product["id"] ?>"/>
                        <button type="submit" class="btn btn-danger w-100" value='Delete'>DEL</button>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <div class="d-flex">
        <form action='addForm.php' method='post'>
            <button type="submit" class="btn btn-success btn-lg">Add</button>
        </form>
    </div>
</div>
</body>
</html>