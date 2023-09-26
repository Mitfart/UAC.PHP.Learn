<?php
$server="localhost";
$port="3306";
$user="root";
$pass="";
$db="zarichan_shop";

$server = new PDO(
    "mysql:host=$server;
    port=$port;
    charset=utf8;",
    $user,
    $pass
);
$server->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$server->query("use $db");