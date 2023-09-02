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
    $sql = "SELECT * FROM $usersTableName";
    $result = $server->query($sql);

    echo "<table><tr><th>Имя</th><th>Возраст</th><th></th></tr>";
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["age"] . "</td>";
        echo "<td><form action='delete.php' method='post'>
                        <input type='hidden' name='id' value='" . $row["id"] . "' />
                        <input type='submit' value='Удалить'>
                    </form></td>";
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