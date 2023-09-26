<?php
require_once "connect.php";

$tb_products = "products";
$query = "SELECT * FROM $tb_products";
$products = $server->query($query);