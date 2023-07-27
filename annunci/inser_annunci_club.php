<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['email']) && $_SESSION['tipo'] == 'squadra') {
?>

    <!DOCTYPE html>
    <html lang="it">

    <head>
        <title>Inserimento annuncio club</title>
        <link rel="shortcut icon" href="../FOTO/logo_a.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="inser_annunci_club.css">
        <link rel="stylesheet" href="../scrollbar.css">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    </head>

    <body>
        <?php
        include("../alert.php");

        if (isset($_POST['back'])) {
            header("Location: ../home/home.php");
        }

        if (isset($_POST['insert'])) {
            if (empty($_POST['titolo']) || empty($_POST['descr'])) {
                alert("Devi riempire tutti i campi obbligatori");
            } else {

                $email = $_SESSION['email'];
                $type_ann = $_SESSION['tipo'];
                $titolo = trim($_POST['titolo']);
                $descr = trim($_POST['descr']);
                if (isset($_POST['pos']))
                    $pos = trim($_POST['pos']);
                else
                    $pos = NULL;
                if (isset($_POST['piede']))
                    $piede = trim($_POST['piede']);
                else
                    $piede = NULL;
                $esp = NULL;
                $data_insert = date("Y-m-d");

                $l_titolo = strlen($titolo);
                $l_descr = strlen($descr);

                if ($l_titolo > 255 || $l_descr > 255) {
                    alert("Hai inserito troppi caratteri");
                }

                include('../connection.php');

                if (mysqli_connect_errno()) {
                    $mess = mysqli_connect_error();
                    alert($mess);
                    exit();
                }

                $stmt = mysqli_prepare($conn, "INSERT INTO annunci (email, type_ann, titolo, descr, posizione, piede, date_insert) VALUES (?, ?, ?, ?, ?, ?, ?)");

                if (!$stmt) {
                    $mess = mysqli_connect_error();
                    alert("Richiesta fallita");
                }

                if (!mysqli_stmt_bind_param($stmt, "sssssss", $email, $type_ann, $titolo, $descr, $pos, $piede, $data_insert)) {
                    alert("Impossibile completare l'operazione richiesta");
                    exit();
                }

                if (!mysqli_stmt_execute($stmt)) {
                    alert("Errore nell'esecuzione della richiesta");
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                } else {
                    echo "<script>
            alert('Annuncio inserito correttamente');
            window.location.href='../annunci/annunci.php';
            </script>";
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                }
            }
        }
        ?>

        <div class="box_title">
            <p class="txt_title">CREA IL TUO ANNUNCIO</p>
        </div>

        <div class="box_profile">
            <form action="inser_annunci_club.php" method="POST">
                <div class="data_input">
                    <textarea type="text" name="titolo" class="form_title" placeholder="Inserisci il titolo del tuo annuncio (max 255 caratteri) *"></textarea>
                    <textarea type="text" name="descr" class="form_descr" placeholder="Inserisci la descrizione del tuo annuncio (max 255 caratteri) *"></textarea>
                </div>

                <select name="pos" class="form_pos">
                    <option selected value="" disabled>Inserisci la posizione del calciatore che cerchi</option>
                    <option value="qualsiasi">Qualsiasi</option>
                    <option value="portiere">Portiere</option>
                    <option value="difensore">Difensore</option>
                    <option value="centrocampista">Centrocampista</option>
                    <option value="attaccante">Attaccante</option>
                </select>

                <select name="piede" class="form_piede">
                    <option selected value="" disabled>Inserisci il piede preferito del calciatore che cerchi</option>
                    <option value="ambidestro">Ambidestro</option>
                    <option value="destro">Destro</option>
                    <option value="sinistro">Sinistro</option>
                </select>

                <button class="button button_insert" name="insert">Inserisci annuncio</button>
                <button class="button button_back" name="back">Torna indietro</button>
            </form>
        </div>
    </body>

    </html>

<?php
} else {
    header("Location: ../login/login.php");
}
?>