<?php
session_start();
require_once "connect.php";


if (isset($_POST['add'])) {
    $product = $server->query("SELECT * FROM products WHERE id LIKE {$_POST['id']}")->fetch();

    $amount = $_SESSION['cart'][$_POST['id']];
    $amount++;
    $amount = min($amount, $product['quantity']);
    $_SESSION['cart'][$_POST['id']] = $amount;
}
if (isset($_POST['reduce'])) {
    $amount = $_SESSION['cart'][$_POST['id']];
    $amount--;
    $_SESSION['cart'][$_POST['id']] = $amount;

    if ($amount <= 0) $_POST['remove'] = true;
}

if (isset($_POST['remove'])) unset($_SESSION['cart'][$_POST['id']]);

unset($_POST['remove']);
unset($_POST['add']);
unset($_POST['reduce']);
unset($_POST['id']);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    unset($_POST);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Shop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
          crossorigin="anonymous">
</head>
<body>
<main class="container">
    <div class="py-5 d-flex flex-column gap-3">
        <form action="page_main.php" class="m-0">
            <button type="submit" class="btn btn-primary">
                < Back
            </button>
        </form>

        <?php
        $in = "";
        foreach ($_SESSION['cart'] as $id => $value) $in .= $id . ",";
        $in = substr($in, 0, -1);
        if ($in != '') {
            $products = $server->query("SELECT * FROM products WHERE id IN ($in)");
            ?>
            <table class="table text-center" style="table-layout:fixed;">
                <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($products as $product) {
                    $id = $product['id'];

                    $card_id = "product_$id";
                    $card_id_description = "{$card_id}_description";
                    $card_id_modal = "{$card_id}_modal";
                    $card_id_modal_label = "{$card_id_modal}_label";
                    ?>
                    <tr>
                        <td>
                            <img class="card-img"
                                 style="width: 50px; height: 50px;"
                                 src="images/<?= $product["image"] ?>.jpg" alt="">
                        </td>
                        <td><?= $product["name"] ?></td>
                        <td>
                            <form class="border rounded row align-items-center m-0" method="post">
                                <button class="col btn"
                                        type="submit"
                                        name="reduce">
                                    -
                                </button>
                                <input class="visually-hidden"
                                       type="number"
                                       name="id"
                                       value="<?= $id ?>">
                                <input class="visually-hidden"
                                       type="number"
                                       name="quantity"
                                       value="<?= $_SESSION['cart'][$id] ?>">
                                <span class="col border-start border-end">
                                    <?= $_SESSION['cart'][$id] ?>
                                </span>
                                <button class="col btn"
                                        type="submit"
                                        name="add">
                                    +
                                </button>
                            </form>
                        </td>
                        <td>
                            <form class="m-0" method="post">
                                <input class="d-none"
                                       type="number"
                                       name="id"
                                       value="<?= $id ?>">
                                <button type="submit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#<?= $card_id_modal ?>"
                                        class="btn btn-danger"
                                        name="remove">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            Empty Cart
        <?php } ?>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>