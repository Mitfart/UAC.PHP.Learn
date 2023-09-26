<?php
session_start();
require_once "connect.php";

// $_SESSION['cart'] = array();

if (isset($_POST['addToCart'])) $_SESSION['cart'][$_POST['id']] = $_POST['amount'];
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
    <div class="py-5 row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
        <?php
        $products = $server->query("SELECT * FROM products");
        foreach ($products as $product) {
            $id = $product['id'];
            $quantity = $product["quantity"];

            $card_id = "product_$id";
            $card_id_description = "{$card_id}_description";
            $card_id_modal = "{$card_id}_modal";
            $card_id_modal_label = "{$card_id_modal}_label";
            ?>
            <div class="col">
                <div class="card">
                    <div class="w-100 position-relative z-3" style="height: 150px">
                        <img class="w-100 h-100 card-img-top object-fit-cover position-absolute top-0 start-0 z-n1"
                             src="images/<?= $product["image"] ?>.jpg" alt="">
                        <div class="badge bg-primary ms-auto pe-4 position-absolute top-0 end-0 z-3"
                             style="translate: 10% 30%;">
                            <h3 class="mb-1">$<?= $product["price"] ?></h3>
                            <span class="visually-hidden"> product price </span>
                        </div>
                    </div>
                    <div class="accordion accordion-flush" id="<?= $card_id ?>">
                        <div class="accordion-item">
                            <header class="accordion-header">
                                <button class="accordion-button collapsed"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        aria-expanded="false"
                                        data-bs-target="#<?= $card_id_description ?>"
                                        aria-controls="<?= $card_id_description ?>">
                                    <?= $product["name"] ?>
                                </button>
                            </header>
                            <div id="<?= $card_id_description ?>"
                                 class="accordion-collapse collapse"
                                 data-bs-parent="#<?= $card_id ?>">
                                <div class="accordion-body">
                                    <?= $product["description"] ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?PHP if (!isset($_SESSION['cart'][$id])) { ?>
                        <button type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#<?= $card_id_modal ?>"
                                class="btn btn-primary">
                            Add
                        </button>

                        <div class="modal fade"
                             id="<?= $card_id_modal ?>"
                             data-bs-keyboard="false"
                             tabindex="-1"
                             aria-labelledby="<?= $card_id_modal_label ?>"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <form class="modal-content p-2 flex-row align-items-center gap-2"
                                      method="post">
                                    <h1 class="modal-title fs-5 flex-grow-1"
                                        id="<?= $card_id_modal_label ?>">
                                        <?= $product["name"] ?>
                                    </h1>
                                    <input class="d-none"
                                           type="number"
                                           name="id"
                                           value="<?= $id ?>">
                                    <input class="form-control w-25"
                                           type="number"
                                           name="amount"
                                           value="<?= min($quantity, 1) ?>"
                                           min="<?= min($quantity, 1) ?>"
                                           max="<?= $quantity ?>">
                                    <button type="submit"
                                            class="btn btn-primary"
                                            name="addToCart">
                                        Add
                                    </button>
                                    <button type="button"
                                            class="visually-hidden"
                                            data-bs-dismiss="modal"
                                            aria-label="Close">
                                        close
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?PHP } else { ?>
                        <form action="page_cart.php" class="m-0">
                            <input class="d-none"
                                   type="number"
                                   name="id"
                                   value="<?= $id ?>">
                            <button type="submit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#<?= $card_id_modal ?>"
                                    class="w-100 btn btn-success">
                                Cart >
                            </button>
                        </form>
                    <?PHP } ?>
                </div>
            </div>
        <?php } ?>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>