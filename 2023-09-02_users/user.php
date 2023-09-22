<!DOCTYPE html>
<html>
<head>
    <title>METANIT.COM</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php
require_once 'index.php';

$userIdParam = ":userid";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    try {
        $sql = "SELECT * 
                FROM $usersTableName 
                WHERE id = $userIdParam";
        $stmt = $server->prepare($sql);
        $stmt->bindValue($userIdParam, $id);
        $effectedRows = $stmt->execute();

        if ($effectedRows) {
            foreach ($stmt as $row) {
                $userName = $row["name"];
                $userAge = $row["age"];

                echo "<div>
                    <h3>Информация о пользователе</h3>
                    <p>Имя: $userName</p>
                    <p>Возраст: $userAge</p>
                </div>";
            }
        } else {
            echo "\n";
            if ($log) echo "Пользователь не найден";
        }
    } catch (PDOException $e) {
        echo "\n";
        if ($log and $log_errors) echo "Database error: " . $e->getMessage();
    }
}
?>
</body>
</html>