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
    <title>Pagina profilo club</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile_club.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
        </script>

    <?php
    include('../alert.php');

    if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
        include("../footer_navbar/navbar_mob.php");
    } else {
        include("../footer_navbar/navbar_desk.php");
    }

    if (isset($_POST['change']))
        header("Location: change_club.php");
    ?>

    <div class="logopng" style="z-index: 1"><a href="../home/home.php">
            <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
        </a>
    </div>

    <div class="box_title" style="cursor: default">
        <p class="txt_title" style="font-size: 30px; padding: 16px 16px;">PROFILO SQUADRA</p>
    </div>

    <?php
    $email = $_SESSION['email'];
    include('../connection.php');

    $stmt = mysqli_prepare($conn, "SELECT * FROM squadra WHERE email=?");
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
    if (!$res) {
        alert("Errore");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }

    if (mysqli_num_rows($res) > 0) {
        while ($row = mysqli_fetch_assoc($res)) {
            ?>

            <div class="box_profile" style="cursor: default">
                <div class="details_club">
                    <h4>Email:
                        <?= $row['email'] ?>
                    </h4>
                    <h2>Dettagli anagrafici</h2>
                    <h4>Nome completo:
                        <?= $row['club_name'] ?>
                    </h4>
                    <h4>Colori:
                        <?= $row['colori'] ?>
                    </h4>
                    <h4>Sede:
                        <?= $row['sede'] ?>
                    </h4>
                    <h4>Provincia:
                        <?= $row['prov'] ?>
                    </h4>
                    <h4>Stadio:
                        <?= $row['stadio'] ?>
                    </h4>
                    <h4>Telefono:
                        <?= $row['telefono'] ?>
                    </h4>
                    <h4>Email:
                        <?= $email ?>
                    </h4>
                    <?php
                    $facebook = $row['facebook'];
                    $instagram = $row['instagram'];
                    if (!empty($facebook)) {
                        ?>
                        <h4>Facebook: <a href="<?php echo $facebook; ?>" target="_blank">Account Facebook</a></h4>
                        <?php
                    } else {
                        ?>
                        <h4>Facebook:</h4>
                        <?php
                    }
                    if (!empty($instagram)) {
                        ?>
                        <h4>Instagram: <a href="<?php echo $instagram; ?>" target="_blank">Account Instagram</a></h4>
                        <?php
                    } else {
                        ?>
                        <h4>Instagram:</h4>
                        <?php
                    }
                    ?>
                </div>

            <?php }
    }
    ?>

        <form method="post" class="form">
            <button class="button button_change" name="change">Modifica profilo</button>
        </form>
    </div>
</body>

</html>