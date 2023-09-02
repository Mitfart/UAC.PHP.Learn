<!DOCTYPE html>
<html>
<head>
    <title>METANIT.COM</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php
require_once 'index.php';

$userIdParam = ":userId";
$userNameParam = ":userName";
$userAgeParam = ":userAge";

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * 
            FROM $usersTableName 
            WHERE id = $userIdParam";
    $stmt = $server->prepare($sql);
    $stmt->bindValue($userIdParam, $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $username = $row["name"];
        $userage = $row["age"];

        echo "<h3>Обновление пользователя</h3>
                <form method='post'>
                    <input type='hidden' name='id' value='$id' /> 
                    
                    <label>Имя: <input type='text' name='name' value='$username' /></label> <br>
                    <label>Возраст: <input type='number' name='age' value='$userage' /></label> <br>
                    <input type='submit' value='Сохранить' />
            </form>";
    } else {
        echo "Пользователь не найден";
    }
} elseif (isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["age"])) {
    $sql = "UPDATE $usersTableName 
            SET name = $userNameParam, 
                age = $userAgeParam
            WHERE id = $userIdParam";

    $stmt = $server->prepare($sql);
    $stmt->bindValue($userIdParam, $_POST["id"]);
    $stmt->bindValue($userNameParam, $_POST["name"]);
    $stmt->bindValue($userAgeParam, $_POST["age"]);
    $stmt->execute();

    header("Location: update_users.php");
} else {
    echo "Некорректные данные";
}
?>
</body>
</html>