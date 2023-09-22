<!DOCTYPE html>
<html>
<head>
    <title>METANIT.COM</title>
    <meta charset="utf-8"/>
</head>
<body>
<?php
require_once 'index.php';
$server->query("use $newBDName");

if (isset($_POST["userName"]) && isset($_POST["userAge"])) {
    $userNameParam = ":userName";
    $userAgeParam = ":userAge";

    $userName = $_POST["userName"];
    $userAge = $_POST["userAge"];

    try {
        $sql = "INSERT INTO Users 
                (name, age) VALUES 
                ($userNameParam, $userAgeParam)
                ";

        $stmt = $server->prepare($sql);
        $affectedRowsNumber = $stmt->execute(array(
                $userName,
                $userAge)
        );

        if ($affectedRowsNumber && $log)
            echo "Data successfully added: name=$userName  age= $userAge \n";
    } catch (PDOException $e) {
        if ($log and $log_errors) echo "Database error: " . $e->getMessage();
    }
}
?>
<h3>Create a new User</h3>
<form method="post">
    <label>
        User Name: <input type="text" name="userName"/>
    </label>
    <br>
    <label>
        User Age: <input type="number" name="userAge"/>
    </label>
    <br>
    <input type="submit" value="Save">
</form>
</body>
</html>