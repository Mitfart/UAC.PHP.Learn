<?php

$server = new PDO(
    "mysql:host=localhost;
    port=3306",
    "root",
    ""
);
$server->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);