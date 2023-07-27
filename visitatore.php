<?php
session_start();

$_SESSION['tipo'] = "visitatore";
$_SESSION['email'] = "mailvisitatore";

header("Location: home/home.php");

?>