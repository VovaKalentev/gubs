<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
if(isset($_POST["nameStudent"]) && isset($_POST["id"])){
    $name = $_POST["nameStudent"];
    $id = $_POST["id"];
    $thisStudent = mysqli_fetch_assoc(mysqli_query($link, "SELECT `FIO-student` FROM `student` WHERE `id-student` ='$id'"));
    if($thisStudent["FIO-student"] != $name){
        $idCurator = $_SESSION["idcurator"];
        $update = "UPDATE `student` SET `FIO-student`='$name' WHERE `id-student` ='$id'";
        $queryForUpdateNameStudent = mysqli_query($link, $update);
        if($queryForUpdateNameStudent){
            echo "Студент изменен";
        }
    }else{
        echo "Студент не изменен";
    }
}
if(isset($_POST["disc"]) && isset($_POST["mark"]) && isset($_POST["exam"])){
    $id = $_POST["id"];
    $disc = $_POST["disc"];
    $mark = $_POST["mark"];
    $exam = $_POST["exam"];
    if($exam != "none" && $mark != "none" && $exam != "none"){
        $queryForInsertMarkStudent = mysqli_query($link,"INSERT INTO `mark`(`FIO-mark`, `discipline-mark`,`estimation-mark`, `type-of-certification-mark`) VALUES ('$id','$disc','$mark','$exam')");
        echo "Оценка есть";
    }else{
        echo "Оценка не добавлена";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вы мэр</title>
</head>
<body>
<?php 
    if($_SESSION["user"] == "curator"){
        $login = $_SESSION["login"];
        $idCurator = $_SESSION["idcurator"];
        $selectGroupThisCurator = "SELECT `id-student`,`FIO-student` FROM `student` WHERE `student`.`group-student` = '$idCurator'";
        $queryForGroupThisCurator = mysqli_query($link, $selectGroupThisCurator);
        if(mysqli_num_rows($queryForGroupThisCurator) > 0){
            while($row = mysqli_fetch_assoc($queryForGroupThisCurator)){
                $id = $row["id-student"];
                $selectMarkThisStudent = "SELECT `estimation-mark` FROM `mark` WHERE `FIO-mark` = '$id'";
                $queryMarkThisStudent = mysqli_query($link, $selectMarkThisStudent);
                $summ = 0;
                $count = 0;
                while($mark = mysqli_fetch_assoc($queryMarkThisStudent)){
                    $summ += $mark["estimation-mark"];
                    $count++;
                }
                $srBal = round($summ/$count,2);
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
            <form action="" method="post">
                <input type="text" name="id" value="<?php echo $row["id-student"]; ?>" hidden>
                <input type="text" name="nameStudent" value="<?php echo $row["FIO-student"]; ?>">
                <input type="text" value="<?php echo "Средний бал: " . $srBal; ?>" readonly>
                <input type="text" value="<?php echo "Рейтинг: " . $reit; ?>" readonly>
                <label for="disc">Если хотите добавить отметку выберите здесь ->></label>
                <select name="disc">
                    <option label="Выберите дисциплину" value="none" disabled selected>
                    <option label="Русский язык" value="1">
                    <option label="Математика" value="2">
                    <option label="История" value="3">
                </select>
                <select name="mark">
                    <option label="Выберите отметку" value="none" disabled selected>
                    <option label="1" value="1">
                    <option label="2" value="2">
                    <option label="3" value="3">
                    <option label="4" value="4">
                    <option label="5" value="5">
                </select>
                <select name="exam">
                    <option label="Выберите вариант зачета" value="none" disabled selected>
                    <option label="Экзамен" value="1">
                    <option label="Зачет" value="2">
                </select>
                <input type="submit" value="Изменить">
            </form>
    <?php }
        }else{
            echo "Проблемка(";
        }
    }?>
    <a href="exit.php">Выйти из аккаунта</a>
</body>
</html>