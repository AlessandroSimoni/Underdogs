<!DOCTYPE html>
<html lang="it">

<head>
    <title>Modifica classifica</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modifica_classifica.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>

    <?php
    session_start();
    include("../alert.php");

    if (isset($_SESSION['email']) && $_SESSION['tipo'] == 'admin') {

        if (isset($_POST['back']))
            header("Location: gestisci_classifica.php");

        $id = $_SESSION['id'];
        $sq = $_SESSION['sq'];
        
    ?>


        <div class="box_title" style="cursor: default">
            <p class="txt_title" style="font-size: 30px; padding: 16px 16px">MODIFICA GLI ELEMENTI IN CLASSIFICA</p>
        </div>

        <div class="container">
            <div class="mid_container">
                <table class="tabella" style="margin-top: auto">
                    <thead>
                        <tr>
                            <th style="width:17%">Squadra</th>
                            <th style="width:0%">Punti</th>
                            <th style="width:4%; text-align:center">Partite giocate</th>
                            <th style="width:0%">Vittorie</th>
                            <th style="width:0%">Sconfitte</th>
                            <th style="width:0%">Pareggi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../connection.php');

                        if ($id == "ge") {
                            $query = "SELECT * FROM classifica_ge WHERE id IN ('" . implode("','", $sq) . "')";
                        } else {
                            $query = "SELECT * FROM classifica_ch WHERE id IN ('" . implode("','", $sq) . "')";
                        }

                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            if (mysqli_num_rows($res) >= 1) { ?>
                                <form action="modifica_classifica.php" method="POST">
                                    <?php
                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="squadra[]" class="change_squadra" placeholder="Nome squadra" value="<?php echo $row['squadra']; ?>" readonly>
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="punti[]" class="change_punti" placeholder="Punti" value="<?php echo $row['punti']; ?>">
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="p_giocate[]" class="change_partite" placeholder="Partite giocate" value="<?php echo $row['partite_giocate']; ?>">
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="vittorie[]" class="change_vittorie" placeholder="Vittorie" value="<?php echo $row['vittorie']; ?>">
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="sconfitte[]" class="change_sconfitte" placeholder="Sconfitte" value="<?php echo $row['sconfitte']; ?>">
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="pareggi[]" class="change_pareggi" placeholder="Pareggi" value="<?php echo $row['pareggi']; ?>">
                                            </td>
                                        </tr>

                            <?php
                                    }
                                }
                            }
                            ?>
                    </tbody>
                </table>
                <button class="button button_back" name="back">Torna indietro</button>
                <button class="button button_change" name="change">Modifica</button>
                </form>
            </div>
        </div>
</body>

<?php
    } else {
        header("Location: ../login/login.php");
    } ?>

</html>

<?php
if (isset($_POST['change'])) {

    if (empty($_POST['squadra']) || empty($_POST['punti']) || empty($_POST['p_giocate']) || empty($_POST['vittorie']) || empty($_POST['sconfitte']) || empty($_POST['pareggi'])) {
        alert("Compila tutti i campi");
        exit();
    }

    $squadra = $_POST['squadra'];
    $punti = $_POST['punti'];
    $p_giocate = $_POST['p_giocate'];
    $vittorie = $_POST['vittorie'];
    $sconfitte = $_POST['sconfitte'];
    $pareggi = $_POST['pareggi'];

    include('../connection.php');

    if ($id == "ge")
        $query = "UPDATE classifica_ge SET punti = ?, partite_giocate = ?, vittorie = ?, sconfitte = ?, pareggi = ? WHERE squadra = ?";
    else
        $query = "UPDATE classifica_ch SET punti = ?, partite_giocate = ?, vittorie = ?, sconfitte = ?, pareggi = ? WHERE squadra = ?";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        alert("Impossibile completare l'operazione richiesta");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        exit();
    }

    $count = 0;
    foreach ($sq as $s) {
        $current_squadra = $squadra[$count];
        $current_punti = $punti[$count];
        $current_p_giocate = $p_giocate[$count];
        $current_vittorie = $vittorie[$count];
        $current_sconfitte = $sconfitte[$count];
        $current_pareggi = $pareggi[$count];

        mysqli_stmt_bind_param($stmt, "iiiiis", $current_punti, $current_p_giocate, $current_vittorie, $current_sconfitte, $current_pareggi, $current_squadra);

        if (!mysqli_stmt_execute($stmt)) {
            alert("Errore nell'esecuzione della richiesta");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit();
        }

        $count++;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    echo "<script>
            alert('Modifiche effettuate con successo');
            window.location.href='../admin/gestisci_classifica.php';
            </script>";
}
?>