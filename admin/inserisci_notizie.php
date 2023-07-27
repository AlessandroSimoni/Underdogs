<!DOCTYPE html>
<html lang="it">

<head>
    <title>Inserisci notizie</title>
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
    ?>

        <div class="box_news">
            <div class="text">
                <form action="inserisci_notizie.php" method="POST">
                    <div class="news_data">
                        <h2 style="cursor: default; margin-left: 40px">Dettagli notizia</h2>
                        <div class="form_input-group">
                            <input type="text" name="titolo" class="form_fill" autofocus placeholder="Inserisci il titolo della notizia">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="link_titolo" class="form_fill" placeholder="Inserisci il link della notizia">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="nome_fonte" class="form_fill2" placeholder="Inserisci la fonte">
                        </div>
                        <div class="form_input-group">
                            <input type="text" name="link_fonte" class="form_fill2" placeholder="Inserisci il link della fonte">
                        </div>
                    </div>
            </div>

            <button class="button button_change" name="insert" style="margin-top: 6%; margin-left: 20%">Inserisci</button>
            <button class="button button_back" name="back" style="margin-top: 6%">Torna indietro</button>
        </div>
        </form>
</body>

<?php
    } else {
        header("Location: ../login/login.php");
    }
?>

</html>

<?php
if (isset($_POST['back'])) {
    header("Location: gestisci_notizie.php");
}

if (isset($_POST['insert'])) {
    if (empty($_POST['titolo']) || empty($_POST['link_titolo']) || empty($_POST['nome_fonte']) || empty($_POST['link_fonte'])) {
        alert('Compila tutti i campi');
        exit();
    }

    $titolo = $_POST['titolo'];
    $link_titolo = $_POST['link_titolo'];
    $nome_fonte = $_POST['nome_fonte'];
    $link_fonte = $_POST['link_fonte'];

    include('../connection.php');

    if (mysqli_connect_errno()) {
        $mess = mysqli_connect_error();
        alert($mess);
        exit();
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO news (titolo, link_titolo, nome_fonte, link_fonte) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        alert("Impossibile completare l'operazione richiesta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $titolo, $link_titolo, $nome_fonte, $link_fonte);

    if (!mysqli_stmt_execute($stmt)) {
        alert("Errore nell'esecuzione della richiesta");
        exit();
    } else {
        echo "<script>
            alert('Notizia inserita con successo');
            window.location.href='../admin/gestisci_notizie.php';
            </script>";
    }
}
?>