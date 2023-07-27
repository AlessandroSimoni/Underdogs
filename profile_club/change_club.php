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
    <title>Cambia Profilo</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="change_club.css">
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
    include('../connection.php');

    if (mysqli_connect_errno()) {
        $mess = mysqli_connect_error();
        alert($mess);
        exit();
    }

    $email = $_SESSION['email'];

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
    $row = mysqli_fetch_array($res);

    $club_name = $row['club_name'];
    $colori = $row['colori'];
    $sede = $row['sede'];
    $prov = $row['prov'];
    $stadio = $row['stadio'];
    $telefono = $row['telefono'];
    $facebook = $row['facebook'];
    $instagram = $row['instagram'];

    mysqli_stmt_close($stmt);
    mysqli_close($conn);


    if (isset($_POST['back']))
        header("Location: profile_club.php");

    if (isset($_POST['change'])) {
        include('../connection.php');
        if (empty($_POST['club_name']) && empty($_POST['colori']) && empty($_POST['sede']) && empty($_POST['prov']) && empty($_POST['stadio']) && empty($_POST['telefono']) && empty($_POST['facebook'] && empty($_POST['instagram']))) {
            alert("Devi riempire almeno un campo");
            exit();
        }

        $club_name = trim($_POST['club_name']);
        $colori = trim($_POST['colori']);
        $sede = trim($_POST['sede']);
        $prov = trim($_POST['prov']);
        $stadio = trim($_POST['stadio']);
        $telefono = trim($_POST['telefono']);
        $facebook = trim($_POST['facebook']);
        $instagram = trim($_POST['instagram']);

        if (mysqli_connect_errno()) {
            $mess = mysqli_connect_error();
            alert($mess);
            exit();
        }
        $stmt = mysqli_prepare($conn, "UPDATE squadra SET club_name=?, colori=?, sede=?, prov=?, stadio=?, telefono=?, facebook=?, instagram=? WHERE email=?");

        if (!$stmt) {
            alert("Richiesta fallita");
            exit();
        }

        if (!mysqli_stmt_bind_param($stmt, 'sssssssss', $club_name, $colori, $sede, $prov, $stadio, $telefono, $facebook, $instagram, $email)) {
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
            alert('Modifiche effettuate');
            window.location.href='../profile_club/profile_club.php';
            </script>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {
            include('../connection.php');
            $stmt = mysqli_prepare($conn, "DELETE FROM squadra WHERE email=?");
            if (!$stmt) {
                alert("Richiesta fallita");
                exit();
            }

            if (!mysqli_stmt_bind_param($stmt, 's', $email)) {
                alert("Impossibile completare l'operazione richiesta");
                exit();
            }

            if (!mysqli_stmt_execute($stmt)) {
                alert("Errore nell'esecuzione della richiesta");
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            } else {
                mysqli_stmt_close($stmt);
                $stmt2 = mysqli_prepare($conn, "DELETE FROM annunci WHERE email=?");
                if (!$stmt2) {
                    $mess = mysqli_connect_error();
                    alert($mess);
                    exit();
                }

                mysqli_stmt_bind_param($stmt2, 's', $email);

                if (!mysqli_stmt_execute($stmt2)) {
                    alert("Error");
                    mysqli_stmt_close($stmt2);
                    mysqli_close($conn);
                } else {
                    mysqli_stmt_close($stmt2);
                    mysqli_close($conn);
                    echo "<script>
                        alert('Il tuo account è stato eliminato');
                        window.location.href='../index.php';
                        </script>";
                }
            }
        }
    }
    ?>

    <div class="box_change">
        <div class="text">
            <form action="change_club.php" method="POST">
                <div class="personal_data">
                    <h2 style="cursor: default">Dettagli profilo</h2>
                    <div class="form_input-group">
                        <input type="text" name="club_name" class="form_nome" autofocus placeholder="Nome squadra"
                            value="<?php echo $club_name ?>">
                    </div>
                    <div class="form_input-group">
                        <input type="text" name="colori" class="form_fill" autofocus
                            placeholder="Cambia/inserisci i colori della tua squadra" value="<?php echo $colori ?>">
                    </div>
                    <div class="form_input-group">
                        <input type="text" name="sede" class="form_fill2"
                            placeholder="Cambia/inserisci la città del tuo campo di allenamento"
                            value="<?php echo $sede ?>">
                    </div>
                    <select name="prov" class="form_prov">
                        <?php
                        if (!empty($prov))
                            echo "<option selected value='$prov'>$prov</option>";
                        else {
                            ?>
                            <option selected value="" disabled>Provincia</option>
                            <?php
                        }
                        ?>
                        <option value="Genova">Genova</option>
                        <option value="Imperia">Imperia</option>
                        <option value="Savona">Savona</option>
                        <option value="La Spezia">La Spezia</option>
                    </select>
                    <div class="form_input-group">
                        <input type="text" name="stadio" class="form_fill2"
                            placeholder="Cambia/inserisci il nome del tuo stadio" value="<?php echo $stadio ?>">
                    </div>
                    <div class="form_input-group">
                        <input type="text" name="telefono" class="form_fill2" placeholder="Cambia il tuo telefono"
                            value="<?php echo $telefono ?>">
                    </div>
                    <div class="form_input-group">
                        <input type="text" name="facebook" class="form_fill2"
                            placeholder="Cambia/inserisci il link del tuo account Facebook"
                            value="<?php echo $facebook ?>">
                    </div>
                    <div class="form_input-group">
                        <input type="text" name="instagram" class="form_fill2"
                            placeholder="Cambia/inserisci il link del tuo account Instagram"
                            value="<?php echo $instagram ?>">
                    </div>
                </div>
        </div>

        <button class="button button_change" name="change">Modifica</button>
        <button class="button button_back" name="back">Torna indietro</button>
        <button class="button button_delete" name="delete"
            onclick="return confirm('Sei sicuro di voler eliminare il profilo?');">Elimina profilo</button>
    </div>
    </form>
</body>

</html>