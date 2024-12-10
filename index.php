<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
if(isset($_POST["login"]) && isset($_POST["password"]) && !empty($_POST["login"]) && !empty($_POST["password"])){
    $username = $_POST["login"];
    $password = $_POST["password"];
    mysqli_real_escape_string($link,$username);
    mysqli_real_escape_string($link,$password);
    $_SESSION["login"] = $username;
    if($username == "admin"|| $password == "admin"){
        $_SESSION["user"] = "admin";
        header("Location:admin.php");
    }else if(substr($username, 0, 1) == "s"){
        $selectThisStudent = "SELECT * FROM `student` WHERE `login-student` = '$username' AND `password-student` = '$password'";
        $queryForThisStudent = mysqli_query($link,$selectThisStudent);
        if(mysqli_num_rows($queryForThisStudent) == 1){
            $_SESSION["user"] = "student";
            $_SESSION["login"] = $username;
            header("Location:student.php");
        }
    }else if(substr($username, 0, 1) == "p"){
        $selectThisCurator = "SELECT * FROM `kurator` WHERE `kurator`.`login-kurator` = '$username' AND `kurator`.`password-kurator` = '$password'";
        $queryForThisCurator = mysqli_query($link,$selectThisCurator);
        $row = mysqli_fetch_assoc($queryForThisCurator);
        if(mysqli_num_rows($queryForThisCurator) == 1){
            $_SESSION["user"] = "curator";
            $_SESSION["login"] = $username;
            $_SESSION["idcurator"] = $row["id-kurator"];
            header("Location:curator.php");
        }
    }else{
        echo "Вы не зарегистрированы(";
    }
}else{
    echo `<p>Заполните все поля</p>`;
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
    <input type="password" name="password" placeholder="Введите пароль">
    <input type="submit" value="Авторизоваться" id="button">
</form>
</body>
</html>