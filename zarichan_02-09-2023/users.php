<!DOCTYPE html>
<html>
<head>
    <title>METANIT.COM</title>
    <meta charset="utf-8"/>
</head>
<body>
<h2>Список пользователей</h2>
<?php
require_once 'index.php';

try {
    $sql = "SELECT id, name FROM $usersTableName";
    $result = $server->query($sql);

    echo "<table><tr><th>Имя</th><th></th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td><a href='user.php?id=" . $row["id"] . "'>Посмотреть</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "\n";
    if ($log and $log_errors) echo "Database error: " . $e->getMessage();
}
?>
</body>
</html>