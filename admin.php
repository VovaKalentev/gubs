<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
if($_SESSION["user"] != "admin"){
    header("Location:index.php");
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin</title>
</head>
<body>
    <?php 
    if($_SESSION["user"] == "admin"){
        $selectAll = "SELECT `student`.`id-student`,`kurator`.`id-kurator`,`spetiality`.`id-spetiality`,`spetiality`.`code-spetiality`,`spetiality`.`spetiality`,`kurator`.`group-kurator`,`student`.`FIO-student`,`student`.`№-record-book-student`,`kurator`.`kurator`,`kurator`.`email-kurator` FROM `kurator`,`student`,`spetiality` WHERE `spetiality`.`id-spetiality` = `kurator`.`specialty-code-speciality` AND `student`.`group-student` = `kurator`.`id-kurator`";
        $queryForAll = mysqli_query($link, $selectAll);

        while($row = mysqli_fetch_assoc($queryForAll)){
            $id = $row["id-student"];
            $selectMarkThisStudent = "SELECT `estimation-mark` FROM `mark` WHERE `FIO-mark` = '$id'";
            $queryMarkThisStudent = mysqli_query($link, $selectMarkThisStudent);
            $summ = 0;
            $count = 0;
            while($mark = mysqli_fetch_assoc($queryMarkThisStudent)){
                $count++;
                $summ += $mark["estimation-mark"];
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
        <form action="" method="post">
            <input type="text" name="idStudent" value="<?php echo $row["id-student"]; ?>" hidden>
            <input type="text" name="idCurator" value="<?php echo $row["id-kurator"]; ?>" hidden>
            <input type="text" name="idSpeciality" value="<?php echo $row["id-spetiality"]; ?>" hidden>
            <input type="text" name="codeSpeciality" value="<?php echo $row["code-spetiality"]; ?>">
            <input type="text" name="speciality" value="<?php echo $row["spetiality"]; ?>">
            <input type="text" name="groupCurator" value="<?php echo $row["group-kurator"]; ?>">
            <input type="text" name="nameStudent" value="<?php echo $row["FIO-student"]; ?>">
            <input type="text" name="recBook" value="<?php echo $row["№-record-book-student"]; ?>">
            <input type="text" name="recBook" value="<?php echo "Средний бал: " . $srBal; ?>">
            <input type="text" name="recBook" value="<?php echo "Рейтинг: " . $reit; ?>">
            <input type="text" name="nameCurator" value="<?php echo $row["kurator"]; ?>">
            <input type="text" name="emailCurator" value="<?php echo $row["email-kurator"]; ?>">
            <input type="submit" value="Изменить">
        </form>
    <?php }} ?>
    <style>form{margin-top: 10px;}</style>

    <a href="exit.php">Выйти из аккаунта</a>
</body>
</html>