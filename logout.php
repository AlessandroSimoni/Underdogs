<?php
    session_start();
    unset($_SESSION['tipo']);
    unset($_SESSION['email']);
    unset($_SESSION['newsletter']);
    header("Location: index.php");
    die();
?>