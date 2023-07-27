<?php

include("../alert.php");

if (basename($_SERVER['PHP_SELF']) == 'sendCode.php') {
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
$mail->Subject = "Reset password Underdogs";
$mail->AddAddress("$email");
$mail->Body = " <img src='https://saw21.dibris.unige.it/~S4942412/FOTO/logo_rimpicciolito_a.png' alt='Logo del sito' style='display: block; margin-left: auto; margin-right: auto; width: 23%; height: 23%'>
                    <h2 style='text-align: center'>Questa e' la mail per il cambio della password. Inserisci questo codice nel form sul sito: $randomNumber .</h2>
                    <p style='text-align: center'>Se non sei stato tu a richiedere questa mail, ignorala.</p>
                    <br><br>
                    <p style='text-align: center'>Un grazie speciale dal team di Underdogs e viva il football.</p>";

if ($mail->send()) {
    echo "<script>
        alert('Ti sei disiscritto alla newsletter');
        window.location.href='home.php';
        </script>";
} else {
    echo "<script>
        alert('Errore durante la disiscrizione alla newsletter');
        window.location.href='home.php';
        </script>";
}
?>