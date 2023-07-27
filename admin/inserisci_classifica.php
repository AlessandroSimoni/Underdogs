<!DOCTYPE html>
<html lang="it">

<head>
    <title>Inserisci classifica</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inserisci.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

    <?php
    include("../alert.php");

    session_start();

    if (isset($_SESSION['email']) && $_SESSION['tipo'] == 'admin') {

        $id = $_SESSION['id'];
    ?>

        <div class="box_change">
            <div class="text">
                <form action="inserisci_classifica.php" method="POST">
                    <div class="personal_data">
                        <h2 class="h2n" style="cursor: default">Dettagli classifica</h2>
                        <div class="form_input-group">
                            <input type="text" name="nome_squadra" class="form_fill" autofocus placeholder="Inserisci il nome dalla squadra">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="punti" class="form_fill2" placeholder="Inserisci i punti in classifica">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="partite_giocate" class="form_fill2" placeholder="Inserisci le partite giocate">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="vittorie" class="form_fill2" placeholder="Inserisci le vittorie">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="pareggi" class="form_fill2" placeholder="Inserisci i pareggi">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="sconfitte" class="form_fill2" placeholder="Inserisci le sconfitte">
                        </div>
                    </div>
            </div>

            <button class="button button_change" name="insert">Inserisci</button>
            <button class="button button_back" name="back">Torna indietro</button>
        </div>
        </form>
</body>

<?php
    } else {
        header("Location: ../login/login.php");
    } ?>

</html>

<?php

if (isset($_POST['back'])) {
    unset($_SESSION['id']);
    header("Location: gestisci_classifica.php");
}

if (isset($_POST['insert'])) {
    if (
        (!isset($_POST['nome_squadra']) && ($_POST['nome_squadra']) == '') || (!isset($_POST['punti']) && ($_POST['punti']) == '') || (!isset($_POST['partite_giocate']) && ($_POST['partite_giocate']) == '')
        || (!isset($_POST['vittorie']) && ($_POST['vittorie']) == '') || (!isset($_POST['pareggi']) && ($_POST['pareggi']) == '') || (!isset($_POST['sconfitte']) && ($_POST['sconfitte']) == '')
    ) {
        alert("Compila tutti i campi");
        exit();
    }

    if (is_numeric($_POST['punti']) && is_numeric($_POST['partite_giocate']) && is_numeric($_POST['vittorie']) && is_numeric($_POST['pareggi']) && is_numeric($_POST['sconfitte'])) {
        $nome_squadra = trim($_POST['nome_squadra']);
        $punti = trim($_POST['punti']);
        $partite_giocate = trim($_POST['partite_giocate']);
        $vittorie = trim($_POST['vittorie']);
        $pareggi = trim($_POST['pareggi']);
        $sconfitte = trim($_POST['sconfitte']);

        if ($punti < 0 || $partite_giocate < 0 || $vittorie < 0 || $pareggi < 0 || $sconfitte < 0) {
            alert("I valori inseriti non possono essere negativi");
            exit();
        }

        $tot_punti = $vittorie * 3 + $pareggi;
        $tot_partite = $vittorie + $pareggi + $sconfitte;

        if ($punti != $tot_punti || $partite_giocate != $tot_partite) {
            alert("I valori inseriti non sono corretti");
            exit();
        }


        include('../connection.php');

        if (mysqli_connect_errno()) {
            $mess = mysqli_connect_error();
            alert($mess);
            exit();
        }
        if ($id == 'ge') {
            $stmt = mysqli_prepare($conn, "INSERT INTO classifica_ge (squadra, punti, partite_giocate, vittorie, sconfitte, pareggi) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                alert("Richiesta fallita");
                exit();
            }

            if (!mysqli_stmt_bind_param($stmt, 'ssssss', $nome_squadra, $punti, $partite_giocate, $vittorie, $pareggi, $sconfitte)) {
                alert("Impossibile completare l'operazione richiesta");
                exit();
            }

            if (!mysqli_stmt_execute($stmt)) {
                alert("Errore nell'esecuzione della richiesta");
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            } else {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                echo "<script>
            alert('Inserimento avvenuto con successo');
            window.location.href='../admin/gestisci_classifica.php';
            </script>";
            }
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO classifica_ch (squadra, punti, partite_giocate, vittorie, sconfitte, pareggi) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                $mess = mysqli_connect_error();
                alert($mess);
                exit();
            }

            if (!mysqli_stmt_bind_param($stmt, 'ssssss', $nome_squadra, $punti, $partite_giocate, $vittorie, $pareggi, $sconfitte)) {
                alert("Impossibile completare l'operazione richiesta");
                exit();
            }

            if (!mysqli_stmt_execute($stmt)) {
                alert("Errore nell'esecuzione della richiesta");
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            } else {
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                echo "<script>
            alert('Inserimento avvenuto con successo');
            window.location.href='../admin/gestisci_classifica.php';
            </script>";
            }
        }
    } else {
        alert("I valori inseriti non sono numerici");
        exit();
    }
}
?>