<?php
if (basename($_SERVER['PHP_SELF']) == 'sendGoodbyeEmail.php') {
    header("Location: ../login/login.php");
}


require("../PHPMailer/src/SMTP.php");
require("../PHPMailer/src/PHPMailer.php");
require("../PHPMailer/src/Exception.php");

$email = $_SESSION['email'];

$mail = new PHPMailer\PHPMailer\PHPMailer(true);
$mail->Host = "smtp.office365.com";
$mail->IsSMTP();
$mail->Port = 587;
$mail->IsHTML(true);
$mail->SMTPAuth = true;
$mail->Password = 'eunacosaseria1';
$mail->Username = 'underdogs@outlook.it';
$mail->SMTPSecure = 'tls';
$mail->SetFrom("underdogs@outlook.it");
$mail->Subject = "Saluti da Underdogs!";
$mail->AddAddress("$email");
$mail->Body = " <img src='https://saw21.dibris.unige.it/~S4942412/FOTO/logo_rimpicciolito_a.png' alt='Logo del sito' style='display: block; margin-left: auto; margin-right: auto; width: 23%; height: 23%'>
    <h2 style='text-align: center'>Ti sei appena disiscritto dalla newsletter!</h2>
    <p style='text-align: center'>Da ora non riceverai tutte le nostre news!</p>
    <p style='text-align: center'>Se vuoi iscriverti dalla newsletter, clicca <a href='https://saw21.dibris.unige.it/~S4942412/home/home.php'> qui </a> e poi clicca il pulsante Iscriviti dalla newsletter in modo
    che tu possa rimanere aggiornato su tutte le nostra novita' e possibili manuntenzioni del sito.</p>
    <br><br>
    <p style='text-align: center'>Un grazie speciale dal team di Underdogs e viva il football</p>";

if ($mail->send()) {
    alert("Ti sei disiscritto dalla newsletter");
    exit();
} else {
    alert("Errore durante la disiscrizione alla newsletter");
}
?>