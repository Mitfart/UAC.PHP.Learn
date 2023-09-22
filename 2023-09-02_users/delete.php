<?php
require_once 'index.php';

$userIdParam = ":userid";

if (isset($_POST["id"])) {
    try {
        $sql = "DELETE 
                FROM $usersTableName 
                WHERE id = $userIdParam";
        $stmt = $server->prepare($sql);
        $stmt->bindValue($userIdParam, $_POST["id"]);
        $stmt->execute();

        header("Location: delete_users.php");
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}