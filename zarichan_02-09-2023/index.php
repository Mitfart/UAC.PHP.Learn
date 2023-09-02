<?php
require_once 'connect.php';

$log = true;
$log_errors = false;
$logAllUsers = false;
$add_users = false;
$newBDName = "zarichan_db_1";
$usersTableName = "users";


try {
    $sql = "CREATE DATABASE $newBDName";
    $server->exec($sql);
    if ($log) echo "Database has been created \n";
} catch (PDOException $e) {
    echo "\n";
    if ($log and $log_errors) echo "Database error: " . $e->getMessage();
}


$server->query("use $newBDName");


try {
    $sql = "CREATE TABLE $usersTableName (
                id integer auto_increment primary key, 
                name varchar(30), 
                age integer
            );";
    $server->exec($sql);
    if ($log) echo "Table $usersTableName has been created \n";
} catch (PDOException $e) {
    echo "\n";
    if ($log and $log_errors) echo "Database error: " . $e->getMessage();
}


if ($add_users) {
    try {
        $affectedRowsNumber = 0;
        $sql = "INSERT INTO $usersTableName 
            (name, age) VALUES 
            ('Tom', 37)";
        $affectedRowsNumber += $server->exec($sql);

        $sql = "INSERT INTO $usersTableName 
            (name, age) VALUES 
            ('Sam', 41), 
            ('Bob', 29), 
            ('Alice', 32)";
        $affectedRowsNumber += $server->exec($sql);
        if ($log) echo "В таблицу Users добавлено строк: $affectedRowsNumber \n";
    } catch (PDOException $e) {
        echo "\n";
        if ($log and $log_errors) echo "Database error: " . $e->getMessage();
    }
}


if ($logAllUsers) {
    try {
        $sql = "SELECT * FROM $usersTableName";
        $result = $server->query($sql);

        echo "<table><tr><th>Id</th><th>Name</th><th>Age</th></tr>";
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["age"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        echo "\n";
        if ($log and $log_errors) echo "Database error: " . $e->getMessage();
    }
}