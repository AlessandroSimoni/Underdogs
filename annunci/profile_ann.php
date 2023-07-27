<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if ($_SESSION['tipo'] == 'visitatore' || !isset($_SESSION['email']))
    header("Location: ../login/login.php");
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <title>Profilo inserzionista</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile_ann.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="box_title" style="cursor: default">
        <p class="txt_title" style="font-size: 30px; padding: 16px 16px">PROFILO INSERZIONISTA</p>
    </div>

    <?php
    include("../alert.php");

    if (isset($_SESSION['email'])) {
        include('../connection.php');
        $annunci_id = $_GET['id'];
        $stmt = mysqli_prepare($conn, "SELECT * FROM annunci WHERE id=?");
        if (!$stmt) {
            $mess = mysqli_connect_error();
            alert("Richiesta fallita");
        }

        if (!mysqli_stmt_bind_param($stmt, "i", $annunci_id)) {
            alert("Impossibile completare l'operazione richiesta");
            exit();
        }

        if (!mysqli_stmt_execute($stmt)) {
            alert("Errore nell'esecuzione della richiesta");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }

        $res = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($res) == 0) {
            alert("Errore");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }

        while ($row = mysqli_fetch_assoc($res)) {
            $email = $row['email'];
            $type_ann = $row['type_ann'];
        }
        ?>
        <div class="box_profile" style="cursor: default">
            <div class="details" style="font-weight: bold">
                <?php
                if ($type_ann == 'calciatore') {
                    $stmt2 = mysqli_prepare($conn, "SELECT * FROM calciatore WHERE email=?");
                    if (!$stmt2) {
                        alert("Richiesta fallita");
                    }

                    if (!mysqli_stmt_bind_param($stmt2, "s", $email)) {
                        alert("Impossibile completare l'operazione richiesta");
                        exit();
                    }

                    if (!mysqli_stmt_execute($stmt2)) {
                        alert("Errore nell'esecuzione della richiesta");
                        mysqli_stmt_close($stmt2);
                        mysqli_close($conn);
                    }

                    $res2 = mysqli_stmt_get_result($stmt2);

                    if (mysqli_num_rows($res2) == 0) {
                        alert("Errore");
                        mysqli_stmt_close($stmt2);
                        mysqli_close($conn);
                    }


                    while ($row = mysqli_fetch_assoc($res2)) { ?>
                        <h4>Inserzionista:
                            <?= $row['firstname'] ?>

                            <?= $row['lastname'] ?>
                        </h4>
                        <h4>Provincia:
                            <?= $row['prov'] ?>
                        </h4>
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
                        <h4>
                            <a href="mailto:<?= $email ?>">Contatta</a>
                        </h4>
                    </div>
                    <?php
                    }
                } else {

                    $stmt2 = mysqli_prepare($conn, "SELECT * FROM squadra WHERE email=?");
                    if (!$stmt2) {
                        $mess = mysqli_connect_error();
                        alert("Richiesta fallita");
                    }

                    if (!mysqli_stmt_bind_param($stmt2, "s", $email)) {
                        alert("Impossibile completare l'operazione richiesta");
                        exit();
                    }

                    if (!mysqli_stmt_execute($stmt2)) {
                        alert("Errore nell'esecuzione della richiesta");
                        mysqli_stmt_close($stmt2);
                        mysqli_close($conn);
                    }

                    $res2 = mysqli_stmt_get_result($stmt2);

                    if (mysqli_num_rows($res2) == 0) {
                        alert("Errore");
                        mysqli_stmt_close($stmt2);
                        mysqli_close($conn);
                    }


                    while ($row = mysqli_fetch_assoc($res2)) { ?>
                    <h4>Inserzionista:
                        <?= $row['club_name'] ?>
                    </h4>
                    <h4>Provincia:
                        <?= $row['prov'] ?>
                    </h4>
                    <h4>Telefono:
                        <?= $row['telefono'] ?>
                    </h4>
                    <h4>Sede:
                        <?= $row['sede'] ?>
                    </h4>
                    <h4>Facebook:
                        <a href="<?= $row['facebook'] ?>" target="_blank"><?= $row['facebook'] ?></a>
                    </h4>
                    <h4>Instagram:
                        <a href="<?= $row['instagram'] ?>" target="_blank"><?= $row['instagram'] ?></a>
                    </h4>
                    <h4>
                        <a href="mailto:<?= $email ?>">Contatta</a>
                    </h4>
                    <?php
                    }
                }
                ?>
    </body>

    <?php
    } else {
        header("Location: ../login/login.php");
    }
    ?>

</html>