<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
if(isset($_POST["fio"]) && isset($_POST["status"]) && isset($_POST["status"]) && isset($_POST["city"]) && isset($_POST["postName"])){
    $idVillager = $_POST["idVillager"];
    $fio = $_POST["fio"];
    $status = $_POST["status"];
    $city = $_POST["city"];
    $postName = $_POST["postName"];
    $selectThisVillager = "SELECT `status`.`id-status`,`post`.`id-post`,`ctities`.`id-city` FROM `villagers`,`status`,`post`,`ctities` WHERE `status`.`name-status` = '$status' AND `post`.`name-post` = '$postName' AND `ctities`.`name-city` = '$city' AND `id-villager` = '$idVillager'";
    $queryForThisVillager = mysqli_query($link, $selectThisVillager);
    $select = mysqli_fetch_assoc($queryForThisVillager);
    $status = $select["id-status"];
    $city = $select["id-city"];
    $postName = $select["id-post"];
    $updateVilager = mysqli_query($link,"UPDATE `villagers` SET `fio-villager`='$fio',`status--villager`='$status',`city-villager`='$city',`post-villager`='$postName' WHERE `id-villager`='$idVillager'");
    if($updateVilager){
        echo "Изменения прошли успешно!";
    }
}
if(isset($_POST["fioNew"]) && isset($_POST["statusNew"]) && isset($_POST["cityNew"]) && isset($_POST["postNew"]) && isset($_POST["loginNew"])){
    $fio = $_POST["fioNew"];
    $status = $_POST["statusNew"];
    $city = $_POST["cityNew"];
    $postName = $_POST["postNew"];
    $loginNew = $_POST["loginNew"];
    $insertNewVillager = "INSERT INTO `villagers`(`fio-villager`, `login-villager`, `status--villager`, `city-villager`, `post-villager`,`picture`) VALUES ('$fio','$loginNew','$status','$city','$postName','')";
    $queryForNewVillager = mysqli_query($link, $insertNewVillager);
    if($queryForNewVillager){
        echo "Вы успешно добавили жителя!";
        unset($_POST);
        header("Location:gubernator.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вы губернатор</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="exit.php">Выйти из аккаунта</a>
    <?php 
        ?>
        <form action="" method="post">
            <input type="text" name="fioNew" placeholder="Введите ФИО">
            <input type="text" name="loginNew" placeholder="Введите логин">
            <select name="statusNew">
                <option disabled selected>Выберите статус</option>
                <option value="1">Губернатор</option>
                <option value="2">Мэр</option>
                <option value="3">Житель</option>
            </select>
            <select name="cityNew">
                <option disabled selected>Выберите город</option>
                <option value="1">Калининград</option>
                <option value="2">Балтийск</option>
                <option value="3">Черняховск</option>
            </select>
            <select name="postNew">
                <option disabled selected>Выберите пост</option>
                <option value="1">Чиновник</option>
                <option value="2">Студент</option>
                <option value="3">Рабочий</option>
                <option value="4">Ученый</option>
            </select>
            <input type="submit" value="Добавить">
        </form>
        
    <?php if($_SESSION["user"] == "gub"){
        $selectAll = "SELECT `id-villager`,`login-villager` ,`fio-villager`, `status`.`name-status`, `ctities`.`name-city`, `post`.`name-post`,`picture`  FROM `villagers`,`status`,`post`,`ctities`WHERE `status`.`id-status` = `status--villager` AND `ctities`.`id-city` = `city-villager` AND `post`.`id-post` = `post-villager` AND `login-villager` NOT IN ('User1');";
        $queryForAll = mysqli_query($link, $selectAll);
        while($row = mysqli_fetch_assoc($queryForAll)){?>
        <form action="" method="post">
            <input type="text" name="idVillager" value="<?php echo $row["id-villager"]; ?>" hidden>
            <input type="text" name="fio" value="<?php echo $row["fio-villager"]; ?>">
            <input type="text" name="status" value="<?php echo $row["name-status"]; ?>">
            <input type="text" name="city" value="<?php echo $row["name-city"]; ?>">
            <input type="text" name="postName" value="<?php echo $row["name-post"]; ?>">
            <div width="50" height="50"><?php if(!empty($row["picture"])){ $pathImg = $row["picture"]; echo `<a href="#" class="link"><img width="50" height="50" src="images\\$pathImg" alt="У вас нет картинки"></a>`;}else{echo $row["picture"];} ?></div>
            <input type="submit" value="Изменить">
            <a href="delete.php?id=<?php echo $row["id-villager"]; ?>">Удалить</a>
        </form>
    <?php }}else{header("Location:index.php");} ?>
    <table border="1" id="table">
        <tr>
            <th>Город</th>
            <th>Статус</th>
        </tr>
        <?php  
        $selectAllCities = mysqli_query($link,"SELECT `id-city`, `name-city` FROM `ctities`");
        while($city = mysqli_fetch_assoc($selectAllCities)){
            $idCity = $city["id-city"];
            $selectAllVillagersThisCity = mysqli_query($link,"SELECT `id-villager`, `post-villager` FROM `villagers` WHERE `city-villager` = '$idCity';");
            $villagerCount = mysqli_num_rows($selectAllVillagersThisCity);
            $countStudent = 0;
            $countWorker = 0;
            $countScientist = 0;
            while($row = mysqli_fetch_assoc($selectAllVillagersThisCity)){
                if($row["post-villager"] == 2){
                    $countStudent++;
                }else if($row["post-villager"] == 3){
                    $countWorker++;
                }else if($row["post-villager"] == 4){
                    $countScientist++;
                }
            }
            $procStudent = round(($countStudent*100/$villagerCount),2);
            $procWorker = round(($countWorker*100/$villagerCount),2);
            $procScientist = round(($countScientist*100/$villagerCount),2);
            echo "Студенты: " . $procStudent . "<br>";
            echo "Рабочие: " . $procWorker . "<br>";
            echo "Ученые: " . $procScientist . "<br>";
            $cityStatus = "";
            if($procStudent > $procWorker && $procStudent > $procScientist){
                $cityStatus = "Студенческий";
            }
            if($procStudent == $procWorker && $procStudent > $procScientist){
                $cityStatus = "Студенческий & Рабочий";
            }
            if($procStudent > $procWorker && $procStudent == $procScientist){
                $cityStatus = "Студенческий & Научный";
            }
            if($procWorker > $procStudent && $procWorker > $procScientist){
                $cityStatus = "Рабочий";
            }
            if($procWorker > $procStudent && $procWorker == $procScientist){
                $cityStatus = "Рабочий & Научный";
            }
            if($procScientist > $procWorker && $procScientist > $procStudent){
                $cityStatus = "Научный";
            }
            if($procScientist == $procWorker && $procScientist == $procStudent){
                $cityStatus = "Общий";
            }
            ?>
            <tr>
                <td><?php echo $city["name-city"]; ?></td>
                <td><?php echo $cityStatus; ?></td>
            </tr>
        <?php }?>
        <dialog id="modal">
                <article  class="modalInside">
                    <a href="<?php echo $home; ?>.php" class="exit">X</a>
                    <img src="images\<?php echo $pathImg; $_SESSION["path"] = ""; ?>" alt="">
                </article>
            </dialog>
    </table>
    <script>
        let allLink =document.querySelectorAll(".link");
        let allExit =document.querySelectorAll(".exit");
        let modal = document.querySelector("#modal");
        allLink.forEach(link => {
            link.addEventListener('click',(e)=>{
                e.preventDefault();
                modal.showModal();
            });
        }); 
        allExit.forEach(exit => {
            exit.addEventListener('click',(e)=>{
                e.preventDefault();
                modal.close();
            });
        }); 
    </script>
    <style>form{margin-top: 10px;}#table{position:absolute;right:300px;top:100px;}</style>

</body>
</html>