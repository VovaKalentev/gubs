<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>curator</title>
</head>
<body>
<?php 
    if($_SESSION["user"] == "curator"){
        $login = $_SESSION["login"];
        $selectThisCurator = "SELECT `kurator`.`group-kurator`, `spetiality`.`code-spetiality`,`kurator`.`kurator`,`kurator`.`email-kurator`,`kurator`.`tel-kurator`,`kurator`.`address-kurator`, `kurator`.`INN-kurator`,`kurator`.`reiting-kurator` FROM `kurator`,`spetiality` WHERE `kurator`.`id-kurator` = 1 AND `spetiality`.`id-spetiality` = `kurator`.`specialty-code-speciality` AND `kurator`.`login-kurator` = '$login'";
        $queryForThisCurator = mysqli_query($link, $selectThisCurator);
        if(mysqli_num_rows($queryForThisCurator) > 0){
            $row = mysqli_fetch_assoc($queryForThisCurator);
            ?>
            <table border="1">
                <tr>
                    <th>Группа</th>
                    <th>Код специальности</th>
                    <th>Имя</th>
                    <th>Почта</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>ИНН</th>
                    <th>Рейтинг</th>
                </tr>
                <tr>
                    <td><?php echo $row["group-kurator"]; ?></td>
                    <td><?php echo $row["code-spetiality"]; ?></td>
                    <td><?php echo $row["kurator"]; ?></td>
                    <td><?php echo $row["email-kurator"]; ?></td>
                    <td><?php echo $row["tel-kurator"]; ?></td>
                    <td><?php echo $row["address-kurator"]; ?></td>
                    <td><?php echo $row["INN-kurator"]; ?></td>
                    <td><?php echo $row["reiting-kurator"]; ?></td>
                </tr>
            </table>
            <form action="" method="get">
                <fieldset>
                    <legend>Хотите что нибудь изменить?</legend>
                    <input type="text" name="groupCurator" value="<?php echo $row["group-kurator"]; ?>">
                    <input type="text" name="codeSpeciality" value="<?php echo $row["code-spetiality"]; ?>">
                    <input type="text" name="nameCurator" value="<?php echo $row["kurator"]; ?>">
                    <input type="text" name="emailCurator" value="<?php echo $row["email-kurator"]; ?>">
                    <input type="text" name="telCurator" value="<?php echo $row["tel-kurator"]; ?>">
                    <input type="text" name="adressCurator" value="<?php echo $row["address-kurator"]; ?>">
                    <input type="text" name="innCurator" value="<?php echo $row["INN-kurator"]; ?>">
                    <input type="text" name="reitCurator" value="<?php echo $row["reiting-kurator"]; ?>">
                    <input type="submit" value="Поменять">
                </fieldset>
            </form>
    <?php 
        }else{
            echo "Проблемка(";
        }
    }?>

    <a href="exit.php">Выйти из аккаунта</a>
</body>
</html>