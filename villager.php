<?php 
error_reporting(E_ALL);
require_once("config.php");
session_start();
$path = 'images/';
$_SESSION["imagesNameArray"] = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (!@copy($_FILES['picture']['tmp_name'], $path . $_FILES['picture']['name'])){
		echo 'Что-то пошло не так';
    }else{
		echo 'Загрузка удачна';
        $namePicture = $_FILES['picture']['name'];
        $login = $_SESSION["login"];
        $updatePicture = mysqli_query($link,"UPDATE `villagers` SET `picture`='$namePicture' WHERE `login-villager` = '$login'");
        unset($_POST);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вы житель</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php 
    if($_SESSION["user"] == "villager"){
        $login = $_SESSION["login"];
        $queryForThisVillager = mysqli_query($link, "SELECT `id-villager`, `fio-villager`, `login-villager`, `status`.`name-status`, `ctities`.`name-city`, `post`.`name-post`,`picture` FROM `villagers`,`status`, `ctities`, `post` WHERE `status`.`id-status` = `villagers`.`status--villager` AND `ctities`.`id-city` = `villagers`.`city-villager` AND `post`.`id-post` = `villagers`.`post-villager` AND `login-villager` = '$login'");
        if(mysqli_num_rows($queryForThisVillager) > 0){
            $villager = mysqli_fetch_assoc($queryForThisVillager);
            $_SESSION["idPic"] = $villager["login-villager"];
            $id = $villager["id-villager"];
            $pathImg = "";
            ?>
            <table border="1">
                <tr>
                    <th>Имя</th>
                    <th>Статус</th>
                    <th>Город</th>
                    <th>Пост</th>
                    <th>Фото</th>
                </tr>
                <tr>
                    <td><?php echo $villager["fio-villager"]; ?></td>
                    <td><?php echo $villager["name-status"]; ?></td>
                    <td><?php echo $villager["name-city"]; ?></td>
                    <td><?php echo $villager["name-post"]; ?></td>
                    <td><a class="link" href="#"><img width="50" height="50" src="<?php if(!empty($villager["picture"])){ $pathImg = $villager["picture"]; $_SESSION["path"] = $pathImg;echo "images\\$pathImg";} ?>" alt="У вас нет картинки"></a></td></tr>
            </table>
            <dialog id="modal">
                <article  class="modalInside">
                    <a href="<?php echo $home; ?>.php" class="exit">X</a>
                    <img src="images\<?php echo $pathImg; $_SESSION["path"] = ""; ?>" alt="">
                </article>
            </dialog>
    <?php 
        }else{
            echo "Проблемка(";
        }
        ?>
        <form enctype="multipart/form-data" method="post"> 
            <input name="picture" type="file" />
            <input type="submit" value="Загрузить" />
        </form>
<?php
    }else{
        header("Location: index.php");
    }
        ?>
    <a href="exit.php">Выйти из аккаунта</a>
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
</body>
</html>