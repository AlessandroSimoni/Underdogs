<!DOCTYPE html>
<html lang="it">

<head>
    <title>Gestisci classifica</title>
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

    if (isset($_POST['inserisci_ge'])) {
        $id = 'ge';
        $_SESSION['id'] = $id;
        header("Location: inserisci_classifica.php");
        exit();
    }

    if (isset($_POST['inserisci_ch'])) {
        $id = 'ch';
        $_SESSION['id'] = $id;
        header("Location: inserisci_classifica.php");
        exit();
    }

    if (isset($_POST['modifica_ge'])) {
        $ge_arr = isset($_POST['squadra']) ? $_POST['squadra'] : array();
        if (count($ge_arr) != 0) {
            $id = 'ge';
            $_SESSION['id'] = $id;
            $sq = $ge_arr;
            $_SESSION['sq'] = $sq;
            header("Location: modifica_classifica.php");
            exit();
        } else {
            alert("Seleziona almeno una squadra di classifica");
        }
    }

    if (isset($_POST['modifica_ch'])) {
        $ch_arr = isset($_POST['squadra']) ? $_POST['squadra'] : array();
        if (count($ch_arr) != 0) {
            $id = 'ch';
            $_SESSION['id'] = $id;
            $sq = $ch_arr;
            $_SESSION['sq'] = $sq;
            header("Location: modifica_classifica.php");
            exit();
        } else {
            alert("Seleziona almeno una squadra di classifica");
        }
    }

    if ($_SERVER['REQUEST_METHOD']) {
        if (isset($_POST['delete_ge'])) {
            $ge_arr = isset($_POST['squadra']) ? $_POST['squadra'] : array();
            if (count($ge_arr) == 0) {
                alert("Seleziona almeno una squadra di classifica");
            } else {
                include("../connection.php");

                if (mysqli_connect_errno()) {
                    $mess = mysqli_connect_error();
                    header("Location: gestisci_classifica.php?error=$mess");
                    exit();
                }

                foreach ($ge_arr as $id) {
                    $stmt = mysqli_prepare($conn, "DELETE FROM classifica_ge WHERE id = ?");

                    mysqli_stmt_bind_param($stmt, "s", $id);

                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_errno($stmt))
                        echo "Errore di cancellazione per la squadra $id: " . mysqli_stmt_error($stmt) . "\n";

                    mysqli_stmt_close($stmt);
                }


                mysqli_close($conn);

                alert("Squadre della classifica cancellate con successo");
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['delete_ch'])) {
            $ch_arr = isset($_POST['squadra']) ? $_POST['squadra'] : array();
            if (count($ch_arr) == 0) {
                alert("Seleziona almeno una squadra di classifica");
            } else {
                include("../connection.php");

                if (mysqli_connect_errno()) {
                    $mess = mysqli_connect_error();
                    header("Location: gestisci_classifica.php?error=$mess");
                    exit();
                }

                foreach ($ch_arr as $id) {
                    $stmt = mysqli_prepare($conn, "DELETE FROM classifica_ch WHERE id = ?");

                    mysqli_stmt_bind_param($stmt, "s", $id);

                    mysqli_stmt_execute($stmt);

                    if (mysqli_stmt_errno($stmt))
                        echo "Errore di cancellazione per la squadra $id: " . mysqli_stmt_error($stmt) . "\n";

                    mysqli_stmt_close($stmt);
                }

                alert("Squadre della classifica cancellate con successo");
            }
        }
    }
?>

    <body style="height: 1500px">
        <div class="logopng" style="z-index: 1"><a href="../home/home.php">
                <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
            </a>
        </div>

        <div class="box_title" style="cursor: default">
            <p class="txt_title" style="font-size: 30px; padding: 16px 16px">GESTIONE CLASSIFICA</p>
        </div>
        <div class="container">
            <div class="mid_container" style="height: 1150px">
                <?php
                if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
                    include("gestisci_rank_mob.php");
                } else {
                    include('gestisci_rank_desk.php');
                }
                ?>
            </div>
        </div>
    </body>

    <script>
        var selezionaTuttige = document.getElementById("selezionaTuttige");
        var selezionaTuttich = document.getElementById("selezionaTuttich");

        var selezionabili_ge = document.getElementsByClassName("checkbox_ge");
        var selezionabili_ch = document.getElementsByClassName("checkbox_ch");

        selezionaTuttige.addEventListener("click", function() {
            if (selezionaTuttige.checked) {
                for (var i = 0; i < selezionabili_ge.length; i++) {
                    selezionabili_ge[i].checked = true;
                }
            } else {
                for (var i = 0; i < selezionabili_ge.length; i++) {
                    selezionabili_ge[i].checked = false;
                }
            }
        });

        selezionaTuttich.addEventListener("click", function() {
            if (selezionaTuttich.checked) {
                for (var i = 0; i < selezionabili_ch.length; i++) {
                    selezionabili_ch[i].checked = true;
                }
            } else {
                for (var i = 0; i < selezionabili_ch.length; i++) {
                    selezionabili_ch[i].checked = false;
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