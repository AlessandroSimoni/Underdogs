<!DOCTYPE html>
<html lang="it">

<head>
    <title>Scrivi recensione</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="recensione.css">
    <link rel="stylesheet" href="../navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_SESSION['email']) && $_SESSION['tipo'] != 'visitatore') {
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
            include("../footer_navbar/navbar_mob.php");
        } else {
            include("../footer_navbar/navbar_desk.php");
        }

        include("../alert.php");
    ?>

        <div class="logopng" style="z-index: 1">
            <a href="../home/home.php">
                <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
            </a>
        </div>

        <div class="box_title" style="cursor: default">
            <p class="txt_title" style="font-size: 30px; padding: 16px 16px">SCRIVI LA TUA RECENSIONE</p>
        </div>

        <div class="box_rec">
            <div class="text">
                <form action="recensione.php" method="POST">
                    <div class="data">
                        <div class="form_input-group">
                            <label class="rating">Valutazione:</label>
                            <span id="valueStar" class="valueStar">Seleziona una valutazione</span>
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" />
                                <label for="star5" title="Eccellente">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" />
                                <label for="star4" title="Buono">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" />
                                <label for="star3" title="Medio">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" />
                                <label for="star2" title="Scarso">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" />
                                <label for="star1" title="Pessimo">1 star</label>
                            </div>
                            <textarea type="text" name="titolo" class="form_fill" placeholder="Titolo (max 70 caratteri)"></textarea>
                        </div>
                        <div class="form_input-group">
                            <textarea type="text" name="messaggio" class="form_fill" placeholder="Messaggio (max 450 caratteri)" style="height: 180px"></textarea>
                        </div>
                    </div>
            </div>

            <button class="button button_send" name="send">Invia</button>
        </div>

        <script>
            const ratingText = document.getElementsByName('rating');
            const rating = document.querySelector('.rate');
            const stars = rating.querySelectorAll('input');
            const selectedStarTitle = document.getElementById('valueStar');

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    const label = rating.querySelector(`label[for="${star.id}"]`);
                    const title = label.getAttribute('title');
                    selectedStarTitle.textContent = title;
                });
            });
        </script>


        </script>
</body>
<?php
    } else {
        header("Location: ../login/login.php");
    }
?>

</html>

<?php
if (isset($_POST['send'])) {
    if (empty($_POST['titolo']) || empty($_POST['messaggio']) || empty($_POST['rate'])) {
        alert("Compila tutti i campi!");
        exit();
    }

    if (strlen($_POST['titolo']) > 70) {
        alert("Titolo troppo lungo!");
        exit();
    }

    if (strlen($_POST['messaggio']) > 450) {
        alert("Messaggio troppo lungo!");
        exit();
    }

    $titolo = trim($_POST['titolo']);
    $messaggio = trim($_POST['messaggio']);
    $rate = $_POST['rate'];
    $data_insert = date("Y-m-d H:i:s");

    include('../connection.php');

    $stmt = mysqli_prepare($conn, "INSERT INTO recensione (email, tipo_voto, voto, titolo, descr, data_insert) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        alert("Richiesta fallita");
        exit();
    }

    if (!mysqli_stmt_bind_param($stmt, "ssisss", $_SESSION['email'], $_SESSION['tipo'], $rate, $titolo, $messaggio, $data_insert)) {
        alert("Impossibile completare l'operazione richiesta");
        exit();
    }

    if (!mysqli_stmt_execute($stmt)) {
        alert("Errore nell'esecuzione la richiesta");
        exit();
    } else {
        alert("Recensione inviata con successo!");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: ../home/home.php");
        exit();
    }
}
?>