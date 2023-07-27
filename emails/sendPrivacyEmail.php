<?php
if (basename($_SERVER['PHP_SELF']) == 'sendPrivacyEmail.php') {
    header("Location: ../login/login.php");
}

require("../PHPMailer/src/SMTP.php");
require("../PHPMailer/src/PHPMailer.php");
require("../PHPMailer/src/Exception.php");

$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->Host = "smtp.office365.com";
$mail->IsSMTP();
$mail->Port = 587;
$mail->IsHTML(true);
$mail->SMTPAuth = true;
$mail->Password = 'eunacosaseria1';
$mail->Username = 'underdogs@outlook.it';
$mail->SMTPSecure = 'tls';
$mail->SetFrom("underdogs@outlook.it");
$mail->Subject = "Benvenuto in Underdogs";
$mail->AddAddress($email);
$mail->Body = "<img src='https://saw21.dibris.unige.it/~S4942412/FOTO/logo_rimpicciolito_a.png' alt='Logo del sito' style='display: block; margin-left: auto; margin-right: auto; width: 23%; height: 23%'>
    <h2 style='text-align: center'>Grazie di esserti iscritto al nostro sito</h2>
    <p style='text-align: center'>Ti diamo il benvenuto in Underdogs. Qui i calciatori e le squadre potranno comunicare tra di loro e potrai rimanere aggiornato sulle ultime notizie della terza categoria.<br>
    Ti ricordiamo che iscrivendoti al sito hai dato il consenso ad Underdogs di utilizzare alcuni tuoi dati personali (i tuoi dati sensibili non verranno divulgati in nessun modo).</p>
    <br><br>
    <p style='text-align: center'>Un grazie speciale dal team di Underdogs e viva il football</p>";

if (!$mail->send()) {
    echo "<script>alert('$mail->ErrorInfo')</script>";
}
?>