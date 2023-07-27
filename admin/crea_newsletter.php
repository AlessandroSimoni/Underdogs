<!DOCTYPE html>
<html lang="it">

<head>
    <title>Crea newsletter</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="newsletter.css">
    <link rel="stylesheet" href="../navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php
    session_start();

    if (isset($_SESSION['email']) && $_SESSION['tipo'] == 'admin') {
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
            include("../footer_navbar/navbar_mob.php");
        } else {
            include("../footer_navbar/navbar_desk.php");
        }

        include("../alert.php");
        ?>

        <div class="logopng" style="z-index: 1">
            <a href="../home/home.php">
                <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
            </a>
        </div>

        <div class="box_title" style="cursor: default">
            <p class="txt_title" style="font-size: 30px; padding: 16px 16px">CREAZIONE NEWSLETTER</p>
        </div>

        <div class="box_email">
            <div class="text">
                <form action="crea_newsletter.php" method="POST">
                    <div class="personal_data">
                        <div class="form_input-group">
                            <textarea type="text" name="oggetto" class="form_fill"
                                placeholder="Oggetto (max 255 caratteri)"></textarea>
                        </div>
                        <div class="form_input-group">
                            <textarea type="text" name="messaggio" class="form_fill" placeholder="Messaggio"
                                style="height: 180px"></textarea>
                        </div>
                    </div>
            </div>

            <button class="button button_send" name="send">Invia</button>
        </div>
    </body>
    <?php
    } else {
        header("Location: ../login/login.php");
    }
    ?>

</html>

<?php

if (isset($_POST['send'])) {
    $emails_error[] = array();
    $check_send = true;
    if (empty($_POST['oggetto']) || empty($_POST['messaggio']))
        alert('Compila tutti i campi!');
    else {
        include('../connection.php');

        $oggetto = trim($_POST['oggetto']);
        $messaggio = trim($_POST['messaggio']);

        $check_emails_calc = "SELECT COUNT(*) FROM calciatore";
        $result_check_emails_calc = mysqli_query($conn, $check_emails_calc);
        $row_calc = mysqli_fetch_array($result_check_emails_calc);
        $count_calc = $row_calc[0];
        $check_emails_squa = "SELECT COUNT(*) FROM squadra";
        $result_check_emails_squa = mysqli_query($conn, $check_emails_squa);
        $row_squa = mysqli_fetch_array($result_check_emails_squa);
        $count_squa = $row_squa[0];
        if ($count_calc == 0 && $count_squa == 0)
            alert('Non ci sono utenti registrati!');
        else {
            $check_pl = "SELECT COUNT(*) FROM calciatore WHERE newsletter = 1";
            $result_check_pl = mysqli_query($conn, $check_pl);
            $row_pl = mysqli_fetch_array($result_check_pl);
            $count_pl = $row_pl[0];

            if ($count_pl == 0 && $count_sq == 0)
                alert('Non ci sono utenti registrati alla newsletter!');
            else {
                require("../PHPMailer/src/SMTP.php");
                require("../PHPMailer/src/PHPMailer.php");
                require("../PHPMailer/src/Exception.php");

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
                $mail->Subject = mb_encode_mimeheader($oggetto, 'UTF-8', 'Q');

                $emails = array();

                $query_calciatori = "SELECT email FROM calciatore WHERE newsletter = 1";
                $result_calciatori = mysqli_query($conn, $query_calciatori);

                while ($row_calciatore = mysqli_fetch_assoc($result_calciatori)) {
                    $emails[] = $row_calciatore['email'];
                }

                $query_squadre = "SELECT email FROM squadra WHERE newsletter = 1";
                $result_squadre = mysqli_query($conn, $query_squadre);

                while ($row_squadra = mysqli_fetch_assoc($result_squadre)) {
                    $emails[] = $row_squadra['email'];
                }

                foreach ($emails as $email) {
                    $mail->AddAddress($email);

                    $mail->Body = " <img src='https://saw21.dibris.unige.it/~S4942412/FOTO/logo_rimpicciolito_a.png' alt='Logo del sito' style='display: block; margin-left: auto; margin-right: auto; width: 23%; height: 23%'>
                                <h2 style='text-align: center'>Ecco gli aggiornamenti di oggi!</h2>
                                <p style='text-align: center'>$messaggio</p>
                                <p style='text-align: center'>Se vuoi disiscriverti dalla newsletter, clicca <a href='https://saw21.dibris.unige.it/~S4942412/home/home.php'> qui </a> e poi clicca il pulsante Disiscriviti dalla newsletter.</p>
                                <br><br>
                                <p style='text-align: center'>Un grazie speciale dal team di Underdogs e viva il football</p>";

                    if (!$mail->send()) {
                        $check_send = false;
                        $emails_error[] = $email;
                    }


                    $mail->ClearAddresses();
                }

                if (!$check_send) {
                    foreach ($emails_error as $email_error) {
                        $message_error = $email_error + " ";
                    }
                    alert("Errore nell'invio della mail a: " + $message_error);
                } else {
                    echo "<script>
            alert('Mail inviata con successo');
            window.location.href='../home/home.php';
            </script>";
                }
            }
        }
    }
}
?>