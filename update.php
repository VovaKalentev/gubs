<?php 
error_reporting(E_ALL);
require_once("config.php");
$id = $_GET["id"];
// $delete = mysqli_query($link,"DELETE FROM `villagers` WHERE `id-villager` = '$id'");
header("Location:gubernator.php");
?>