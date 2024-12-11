<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
if(isset($_POST["login"]) && !empty($_POST["login"])){
    $username = $_POST["login"];
    mysqli_real_escape_string($link,$username);
    $selectThisVillager = "SELECT `id-villager`,`login-villager`, `status`.`name-status` FROM `villagers`,`status` WHERE `login-villager` = '$username' AND `status`.`id-status` = `status--villager`;";
    $queryForThisVillager = mysqli_query($link,$selectThisVillager);
    $_SESSION["login"] = $username;
    if(mysqli_num_rows($queryForThisVillager) > 0){
        $row = mysqli_fetch_assoc($queryForThisVillager);
        if($row["name-status"] == "Губернатор"){
            $_SESSION["user"] = "gub";
            header("Location:gubernator.php");
        }else if($row["name-status"] == "Мэр"){
            $_SESSION["user"] = "mer";
            header("Location:mer.php");
        }else if($row["name-status"] == "Житель"){
            $_SESSION["user"] = "git";
            header("Location:villager.php");
        }
    }else{
        echo "Вы не зарегистрированы(";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
</head>
<body>
<form action="" method="post">
    <input type="text" name="login" placeholder="Введите логин">
    <input type="submit" value="Авторизоваться" id="button">
</form>
</body>
</html>