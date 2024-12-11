<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
if($_SESSION["user"] != "gub"){
    header("Location:index.php");
}
if(isset($_POST["codeSpeciality"]) && isset($_POST["speciality"]) && isset($_POST["groupCurator"]) && isset($_POST["nameStudent"]) && isset($_POST["recBook"]) && isset($_POST["srBal"]) && isset($_POST["reit"]) && isset($_POST["nameCurator"]) && isset($_POST["emailCurator"])){
    $idVillager = $_POST["idVillager"];
    $fio = $_POST["fio"];
    $status = $_POST["status"];
    $city = $_POST["city"];
    $postName = $_POST["postName"];
    $selectAll = "SELECT `id-villager`, `fio-villager`, `status`.`name-status`, `ctities`.`name-city`, `post`.`name-post` FROM `villagers`,`status`,`post`,`ctities` WHERE `status`.`id-status` = `status--villager` AND `ctities`.`id-city` = `city-villager` AND `post`.`id-post` = `post-villager`;";
    $queryForAll = mysqli_query($link, $selectAll);
    if(mysqli_num_rows($queryForAll) > 0){
        $all = mysqli_fetch_assoc($queryForAll);
        $selectCodeSpeciality = mysqli_fetch_assoc(mysqli_query($link,"SELECT `id-spetiality` FROM `spetiality` WHERE `code-spetiality` = '$codeSpeciality'"));
        $codeSpeciality = $selectCodeSpeciality["id-spetiality"];
        echo $idCurator;
        $updateCodeSpeciality = mysqli_query($link,"UPDATE `kurator` SET `specialty-code-speciality`='$codeSpeciality' WHERE `id-kurator` ='$idCurator'");
        if($updateCodeSpeciality){
            echo "Изменено code-spetiality";
        }
    }
    
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вы губернатор</title>
</head>
<body>
<a href="exit.php">Выйти из аккаунта</a>
    <?php 
    if($_SESSION["user"] == "gub"){
        $selectAll = "SELECT `id-villager`,`login-villager` ,`fio-villager`, `status`.`name-status`, `ctities`.`name-city`, `post`.`name-post` FROM `villagers`,`status`,`post`,`ctities` WHERE `status`.`id-status` = `status--villager` AND `ctities`.`id-city` = `city-villager` AND `post`.`id-post` = `post-villager` AND `login-villager` NOT IN ('User1');";
        $queryForAll = mysqli_query($link, $selectAll);
        while($row = mysqli_fetch_assoc($queryForAll)){
            ?>
        <form action="" method="get">
            <input type="text" name="fio" value="<?php echo $row["fio-villager"]; ?>">
            <input type="text" name="status" value="<?php echo $row["name-status"]; ?>">
            <input type="text" name="city" value="<?php echo $row["name-city"]; ?>">
            <input type="text" name="postName" value="<?php echo $row["name-post"]; ?>">
            <input type="submit" value="Изменить">
            <a href="delete.php?id=<?php echo $row["id-villager"]; ?>">Удалить</a>
        </form>
    <?php }} ?>
    <style>form{margin-top: 10px;}</style>

</body>
</html>