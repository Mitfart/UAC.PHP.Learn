<?php
$server = new PDO(
    "mysql:host=localhost;
    port=3307",
    "root",
    ""
);
$server->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$server->query("use zarichan_shop");