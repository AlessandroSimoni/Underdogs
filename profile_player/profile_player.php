<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['email']) || $_SESSION['tipo'] == 'visitatore') {
    header("Location: ../login/login.php");
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title>Pagina profilo calciatore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <link rel="stylesheet" href="profile_player.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php
    include('../alert.php');

    if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
        include("../footer_navbar/navbar_mob.php");
    } else {
        include("../footer_navbar/navbar_desk.php");
    }

    if (isset($_POST['submit']))
        header("Location: change_player.php");
    ?>

    <div class="logopng" style="z-index: 1">
        <a href="../home/home.php">
            <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
        </a>
    </div>

    <div class="box_title" style="cursor: default">
        <p class="txt_title">PROFILO GIOCATORE</p>
    </div>

    <?php
    include('../connection.php');
    $email = $_SESSION['email'];


    $stmt = mysqli_prepare($conn, "SELECT * FROM calciatore WHERE email=?");
    if (!$stmt) {
        alert("Richiesta fallita");
    }

    if (!mysqli_stmt_bind_param($stmt, "s", $email)) {
        alert("Impossibile completare l'operazione richiesta");
        exit();
    }

    if (!mysqli_stmt_execute($stmt)) {
        alert("Errore nell'esecuzione della richiesta");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            ?>

            <div class="box_profile" style="cursor: default">
                <div class="details_anag">
                    <h4 style="margin-top: 30px">Email:
                        <?= $row['email'] ?>
                    </h4>
                    <h2>Dettagli anagrafici</h2>
                    <h4>Nome:
                        <?= $row['firstname'] ?>
                    </h4>
                    <h4>Cognome:
                        <?= $row['lastname'] ?>
                    </h4>
                    <h4>Sesso:
                        <?= $row['sesso'] ?>
                    </h4>
                    <h4>Data di nascita:
                        <?= $row['nascita'] ?>
                    </h4>
                    <h4>Provinca di residenza:
                        <?= $row['prov'] ?>
                    </h4>
                </div>

                <div class="details_player">
                    <h2>Dettagli giocatore</h2>
                    <h4>Posizione in campo:
                        <?= $row['posizione'] ?>
                    </h4>
                    <h4>Piede:
                        <?= $row['piede'] ?>
                    </h4>
                    <h4>Altezza (cm):
                        <?= $row['altezza'] ?>
                    </h4>
                    <h4>Peso (kg):
                        <?= $row['peso'] ?>
                    </h4>
                    <h4>Stato:
                        <?= $row['stato'] ?>
                    </h4>
                </div>

            <?php }
    } ?>

        <form method="post" class="form">
            <button class="button button_change" name="submit">Modifica profilo</button>
        </form>
    </div>
</body>

</html>