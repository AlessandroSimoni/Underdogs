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
    <link rel="stylesheet" href="change_player.css">
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
    if (mysqli_num_rows($res) == 0) {
        alert("Errore");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        $row = mysqli_fetch_assoc($res);
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $prov = $row['prov'];
        $pos = $row['posizione'];
        $piede = $row['piede'];
        $alt = $row['altezza'];
        $peso = $row['peso'];
        $stato = $row['stato'];
    }



    if (isset($_POST['back']))
        header("Location: profile_player.php");

    if (isset($_POST['submit'])) {
        include('../connection.php');
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $prov = isset($_POST['prov']) ? trim($_POST['prov']) : $prov;
        $pos = isset($_POST['pos']) ? trim($_POST['pos']) : $pos;
        $piede = isset($_POST['piede']) ? trim($_POST['piede']) : $piede;
        $alt = isset($_POST['alt']) ? trim($_POST['alt']) : $alt;
        $peso = isset($_POST['peso']) ? trim($_POST['peso']) : $peso;
        $stato = isset($_POST['stato']) ? trim($_POST['stato']) : $stato;

        if (mysqli_connect_errno()) {
            $mess = mysqli_connect_error();
            alert($mess);
            exit();
        }

        $stmt = mysqli_prepare($conn, "UPDATE calciatore SET firstname=?, lastname=?, prov=?, posizione=?, piede=?, altezza=?, peso=?, stato=? WHERE email=?");

        if (!$stmt) {
            alert("Richiesta fallita");
            exit();
        }

        mysqli_stmt_bind_param($stmt, 'sssssiiss', $firstname, $lastname, $prov, $pos, $piede, $alt, $peso, $stato, $email);

        if (!mysqli_stmt_execute($stmt)) {
            alert("Errore nell'esecuzione della richiesta");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo "<script>
            alert('I tuoi dati sono stati modificati');
            window.location.href='profile_player.php';
            </script>";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['delete'])) {

            include('../connection.php');

            if (mysqli_connect_errno()) {
                $mess = mysqli_connect_error();
                header("Location: change_player.php?error=$mess");
                exit();
            }

            $stmt = mysqli_prepare($conn, "DELETE FROM calciatore WHERE email=?");

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
                    alert("Richiesta fallita");
                    exit();
                }

                mysqli_stmt_bind_param($stmt2, 's', $email);

                if (!mysqli_stmt_execute($stmt2)) {
                    alert("Errore nell'esecuzione della richiesta");
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
            <form action="change_player.php" id="change_player.php" method="POST">
                <div class="personal_data">
                    <h2 style="cursor: default; margin-left: 3px">Modifica i tuoi dati</h2>
                    <div class="form_input-group">
                        <input type="text" name="firstname" class="form_nome" placeholder="Nome"
                            value="<?php echo $firstname; ?>">
                    </div>
                    <div class="form_input-group">
                        <input type="text" name="lastname" class="form_cognome" placeholder="Cognome"
                            value="<?php echo $lastname; ?>">
                    </div>
                    <select name="prov" class="form_prov">
                        <?php
                        if (!empty($prov))
                            echo "<option selected hidden value='$prov'>$prov</option>";
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

                    <select name="pos" class="form_pos">
                        <?php
                        if (!empty($pos))
                            echo "<option selected hidden value='$pos'>$pos</option>";
                        else {
                            ?>
                            <option selected value="" disabled>Posizione</option>
                            <?php
                        }
                        ?>
                        <option value="qualsiasi">Qualsiasi</option>
                        <option value="portiere">Portiere</option>
                        <option value="difensore">Difensore</option>
                        <option value="centrocampista">Centrocampista</option>
                        <option value="attaccante">Attaccante</option>
                    </select>

                    <select name="piede" class="form_piede">
                        <?php
                        if (!empty($piede))
                            echo "<option selected hidden value='$piede'>$piede</option>";
                        else {
                            ?>
                            <option selected value="" disabled>Piede</option>
                            <?php
                        }
                        ?>
                        <option value="ambidestro">Ambidestro</option>
                        <option value="destro">Destro</option>
                        <option value="sinistro">Sinistro</option>
                    </select>

                    <select name="stato" class="form_stato">
                        <?php
                        if (!empty($stato))
                            echo "<option selected hidden value='$stato'>$stato</option>";
                        else {
                            ?>
                            <option selected value="" disabled>Stato</option>
                            <?php
                        }
                        ?>
                        <option value="Tesserato">Tesserato</option>
                        <option value="Cercando squadra">Cercando squadra</option>
                        <option value="Svincolato">Svincolato</option>
                    </select>

                    <?php
                    if ($alt == '0') {
                        ?>
                        <input type="text" name="alt" class="form_alt" placeholder="<?php echo "Altezza (cm)"; ?>">
                        <?php
                        $alt = 0;
                    } else {
                        ?>
                        <input type="text" name="alt" class="form_alt" placeholder="Altezza (cm)"
                            value="<?php echo $alt; ?>">
                        <?php
                    }

                    if ($peso == '0') {
                        ?>
                        <input type="text" name="peso" class="form_peso" placeholder="<?php echo "Peso (kg)" ?>">
                        <?php
                        $peso = 0;
                    } else {
                        ?>
                        <input type="text" name="peso" class="form_peso" placeholder="Peso (kg)"
                            value="<?php echo $peso; ?>">
                        <?php
                    }
                    ?>
                </div>
        </div>

        <button class="button button_back" name="back">Torna indietro</button>
        <button class="button button_change" name="submit">Modifica</button>
        <button class="button button_delete" name="delete"
            onclick="return confirm('Sei sicuro di voler eliminare il profilo?');">Elimina profilo</button>
    </div>
    </form>
</body>

</html>