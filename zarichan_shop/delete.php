<?php
require_once 'products.php';

$idParam = "id";

if (isset($_POST["id"])) {
    try {
        $stmt = $server->prepare("
                DELETE 
                FROM $tb_products 
                WHERE id = :$idParam
        ");
        $stmt->execute(array($idParam => $_POST["id"]));

        header("Location: index.php");
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}