<?php
if (basename($_SERVER['PHP_SELF']) == 'sendWelcomeEmail.php') {
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
$mail->Subject = "Ti sei iscritto alla nostra newsletter!";
$mail->AddAddress($email);
$mail->Body = " <img src='https://saw21.dibris.unige.it/~S4942412/FOTO/logo_rimpicciolito_a.png' alt='Logo del sito' style='display: block; margin-left: auto; margin-right: auto; width: 23%; height: 23%'>
                    <h2 style='text-align: center'>Grazie di esserti iscritto alla nostra newsletter</h2>
                    <p style='text-align: center'>Da ora riceverai tutte le nostre news!</p>
                    <p style='text-align: center'>Se vuoi disiscriverti dalla newsletter, clicca <a href='https://saw21.dibris.unige.it/~S4942412/home/home.php'> qui </a> e poi clicca il pulsante Disiscriviti dalla newsletter.</p>
                    <br><br>
                    <p style='text-align: center'>Un grazie speciale dal team di Underdogs e viva il football</p>";

if ($mail->send()) {
    alert("Ti sei iscritto alla newsletter");
    exit();
} else {
    alert("Errore durante l'iscrizione alla newsletter");
}
?>