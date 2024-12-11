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
    <title>Вы житель</title>
</head>
<body>
<?php 
    if($_SESSION["user"] == "student"){
        $login = $_SESSION["login"];
        $selectThisStudent = "SELECT `student`.`id-student` ,`kurator`.`group-kurator`,`FIO-student`,`kurator`.`kurator` FROM `student`,`kurator` WHERE `student`.`group-student` = `kurator`.`id-kurator` AND `student`.`login-student` = '$login'";
        $queryForThisStudent = mysqli_query($link, $selectThisStudent);
        if(mysqli_num_rows($queryForThisStudent) > 0){
            $student = mysqli_fetch_assoc($queryForThisStudent);
            $id = $student["id-student"];
            $selectMarkThisStudent = "SELECT `estimation-mark` FROM `mark` WHERE `FIO-mark` = '$id'";
            $queryMarkThisStudent = mysqli_query($link, $selectMarkThisStudent);
            $summ = 0;
            $count = 0;
            while($row = mysqli_fetch_assoc($queryMarkThisStudent)){
                $count++;
                $summ += $row["estimation-mark"];
            }
            $srBal = round($summ/$count,1);
            if($srBal <= 2.99){
                $reit = 1;
            }else if($srBal >= 3 && $srBal <= 3.99){
                $reit = 2;
            }else if($srBal >= 4 && $srBal <= 5){
                $reit = 3;
            }else{
                $reit = "Вауу";
            }
            ?>
            <table border="1">
                <tr>
                    <th>Группа</th>
                    <th>Студент</th>
                    <th>Куратор</th>
                    <th>Средний бал</th>
                    <th>Рейтинг</th>
                </tr>
                <tr>
                    <td><?php echo $student["group-kurator"]; ?></td>
                    <td><?php echo $student["FIO-student"]; ?></td>
                    <td><?php echo $student["kurator"]; ?></td>
                    <td><?php echo $srBal ?></td>
                    <td><?php echo $reit; ?></td>
                </tr>
            </table>
    <?php 
        }else{
            echo "Проблемка(";
        }
    }?>
    <a href="exit.php">Выйти из аккаунта</a>
</body>
</html>