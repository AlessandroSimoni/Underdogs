<!DOCTYPE html>
<html lang="it">

<head>
    <title>Gestisci notizie</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gestisci.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<?php
include("../alert.php");

session_start();

if (isset($_SESSION['email']) && $_SESSION['tipo'] == 'admin') {
    if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
        include("../footer_navbar/navbar_mob.php");
    } else {
        include("../footer_navbar/navbar_desk.php");
    }

    if (isset($_POST['inserisci'])) {
        header("Location: inserisci_notizie.php");
        exit();
    }

    if (isset($_POST['modifica'])) {
        $arr = isset($_POST['id_n']) ? $_POST['id_n'] : array();
        if (count($arr) != 0) {
            $_SESSION['id'] = $arr;
            header("Location: modifica_notizie.php");
            exit();
        } else {
            alert("Seleziona almeno una notizia");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['delete'])) {
            $ids = isset($_POST['id_n']) ? $_POST['id_n'] : array();
            if (count($ids) == 0) {
                alert("Seleziona almeno una notizia");
            } else {
                include("../connection.php");

                if (mysqli_connect_errno()) {
                    $mess = mysqli_connect_error();
                    header("Location: gestisci_notizie.php?error=$mess");
                    exit();
                }

                foreach ($ids as $id) {
                    $stmt = mysqli_prepare($conn, "DELETE FROM news WHERE id = ?");
                    if (!$stmt) {
                        $mess = mysqli_connect_error();
                        alert($mess);
                    }

                    mysqli_stmt_bind_param($stmt, "i", $id);

                    if (!mysqli_stmt_execute($stmt)) {
                        $mess = mysqli_stmt_error($stmt);
                        alert($mess);
                    }

                    mysqli_stmt_close($stmt);
                }

                mysqli_close($conn);

                alert("Notizie cancellate con successo");
            }
        }
    }
    ?>

    <body style="height: 1000px">
        <div class="logopng" style="z-index: 1"><a href="../home/home.php">
                <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
            </a>
        </div>

        <div class="container">
            <?php
            if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
                include("gestisci_notizie_mob.php");
            } else {
                include('gestisci_notizie_desk.php');
            }
            ?>
    </body>

    <script>
        var selezionaTutti = document.getElementById("selezionaTutti");

        var selezionabili = document.getElementsByClassName("checkbox_n");

        selezionaTutti.addEventListener("click", function () {
            if (selezionaTutti.checked) {
                for (var i = 0; i < selezionabili.length; i++) {
                    selezionabili[i].checked = true;
                }
            } else {
                for (var i = 0; i < selezionabili.length; i++) {
                    selezionabili[i].checked = false;
                }
            }
        });
    </script>

    <?php
} else {
    header("Location: ../login/login.php");
}
?>

</html>