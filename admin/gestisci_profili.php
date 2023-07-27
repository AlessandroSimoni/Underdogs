<!DOCTYPE html>
<html lang="it">

<head>
    <title>Gestisci profili</title>
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['delete_pl'])) {
            $email_pl = isset($_POST['emails']) ? $_POST['emails'] : array();
            if (count($email_pl) == 0) {
                alert('Seleziona almeno un calciatore');
            } else {

                include('../connection.php');

                if ($conn->connect_error)
                    die("Connessione fallita: " . $conn->connect_error);

                foreach ($email_pl as $email) {
                    $sql = "DELETE FROM calciatore WHERE email = '$email'";

                    if ($conn->query($sql) !== TRUE)
                        echo "Errore di cancellazione per il profilo $email: " . $conn->error . "\n";

                    $sql2 = "DELETE FROM annunci WHERE email= '$email'";

                    if ($conn->query($sql2) !== TRUE)
                        echo "Errore di cancellazione per l'annuncio del profilo $email: " . $conn->error . "\n";
                }

                alert('Cancellazione avvenuta con successo');
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['delete_sq'])) {

            $email_sq = isset($_POST['emails']) ? $_POST['emails'] : array();
            if (count($email_sq) == 0) {
                alert('Seleziona almeno una squadra');
            } else {
                include('../connection.php');

                if ($conn->connect_error)
                    die("Connessione fallita: " . $conn->connect_error);

                foreach ($email_sq as $email) {
                    $sql = "DELETE FROM squadra WHERE email = '$email'";

                    if ($conn->query($sql) !== TRUE)
                        echo "Errore di cancellazione per il profilo $email: " . $conn->error . "\n";

                    $sql2 = "DELETE FROM annunci WHERE email= '$email'";

                    if ($conn->query($sql2) !== TRUE)
                        echo "Errore di cancellazione per l'annuncio del profilo $email: " . $conn->error . "\n";
                }

                alert('Cancellazione avvenuta con successo');
            }
        }
    }

    ?>

    <body>
        <div class="logopng" style="z-index: 1"><a href="../home/home.php">
                <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
            </a>
        </div>

        <div class="box_title" style="cursor: default">
            <p class="txt_title" style="font-size: 30px; padding: 16px 16px">GESTIONE PROFILI</p>
        </div>

        <div class="container">
            <div class="mid_container">

                <div class="small_container">
                    <table class="tabella">
                        <thead>
                            <header>
                                <p style="float: left">PROFILI CALCIATORI</p>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input class="form-control mr-sm-2" type="text" name="search_pl" placeholder="Ricerca"
                                        style="margin-left: auto; width: 200px">
                                </form>
                            </header>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <tr>
                                    <th style="text-align: center"><input type="checkbox" id="selezionaTuttipl"></th>
                                    <th>Email</th>
                                    <th>Nome</th>
                                    <th>Cognome</th>
                                    <th>Sex</th>
                                    <th>Nascita</th>
                                    <th>Prov</th>
                                    <th><img src="../FOTO/newsletter.png" alt="newsletter_png" width="30" height="30">
                                    </th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../connection.php");

                            $stmt1 = "SELECT * FROM calciatore";

                            if (isset($_POST['search_pl'])) {
                                $result_search_pl = trim($_POST['search_pl']);
                                $result_search_pl = htmlspecialchars($result_search_pl);
                                $stmt1 = "SELECT * FROM calciatore HAVING firstname LIKE '%$result_search_pl%'
                                                                            OR lastname LIKE '%$result_search_pl%'
                                                                            OR email LIKE '%$result_search_pl%'
                                                                            OR prov LIKE '%$result_search_pl%'
                                                                            OR newsletter LIKE '%$result_search_pl%'
                                                                            ORDER BY nascita DESC";
                            }

                            $prepare1 = mysqli_prepare($conn, $stmt1);

                            if (!$prepare1) {
                                $mess = mysqli_connect_error();
                                alert("Impossibile completare l'operazione richiesta");
                            }

                            if (!mysqli_stmt_execute($prepare1)) {
                                alert("Errore nell'esecuzione della richiesta");
                                mysqli_stmt_close($prepare1);
                                mysqli_close($conn);
                            }

                            if ($res = mysqli_stmt_get_result($prepare1)) {
                                if (mysqli_num_rows($res) >= 1) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center"><input type="checkbox" class="checkbox_pl" name="emails[]"
                                                    value="<?php echo $row['email']; ?>"></td>
                                            <td class="checkbox_pl">
                                                <?php echo $row['email']; ?>
                                            </td>
                                            <td class="checkbox_pl">
                                                <?php echo $row['firstname']; ?>
                                            </td>
                                            <td class="checkbox_pl">
                                                <?php echo $row['lastname']; ?>
                                            </td>
                                            <td class="checkbox_pl" width="5%" style="text-align:center">
                                                <?php
                                                if ($row['sesso'] == "Maschio") {
                                                    echo "M";
                                                } else {
                                                    echo "F";
                                                }
                                                ?>
                                            </td>
                                            <td class="checkbox_pl" width="12%" style="text-align:center">
                                                <?php echo $row['nascita']; ?>
                                            </td>
                                            <td class="checkbox_pl" width="5%" style="text-align:center">
                                                <?php
                                                if ($row['prov'] == "Genova") {
                                                    echo "GE";
                                                } else if ($row['prov'] == "Savona") {
                                                    echo "SV";
                                                } else if ($row['prov'] == "La Spezia") {
                                                    echo "SP";
                                                } else {
                                                    echo "IM";
                                                }
                                                ?>
                                            </td>
                                            <td class="checkbox_pl" width="5%" style="text-align:center">
                                                <?php
                                                if ($row['newsletter'] == 1) {
                                                    echo "Si";
                                                } else {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="box">
                                        Non ci sono profili
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <button class="button button_delete" name="delete_pl"
                        onclick="return confirm('Sei sicuro di voler eliminare?');">Cancella calciatori
                        selezionati</button>
                </form>
                </form>

                <div class="small_container" style="margin-top: 2%">
                    <table class="tabella">
                        <thead>
                            <header>
                                <p style="float: left">PROFILI SQUADRA</p>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input class="form-control mr-sm-2" type="text" name="search_sq" placeholder="Ricerca"
                                        style="margin-left: auto; width: 200px">
                                </form>
                            </header>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <tr>
                                    <th style="text-align: center"><input type="checkbox" id="selezionaTuttisq"></th>
                                    <th>Email</th>
                                    <th>Nome</th>
                                    <th>Telefono</th>
                                    <th>Sede</th>
                                    <th>Prov</th>
                                    <th><img src="../FOTO/newsletter.png" alt="newsletter_png" width="30" height="30">
                                    </th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../connection.php");

                            $stmt2 = "SELECT * FROM squadra";

                            if (isset($_POST['search_sq'])) {
                                $result_search_sq = trim($_POST['search_sq']);
                                $result_search_sq = htmlspecialchars($result_search_sq);
                                $stmt2 = "SELECT * FROM squadra HAVING club_name LIKE '%$result_search_sq%'
                                                                            OR email LIKE '%$result_search_sq%'
                                                                            OR sede LIKE '%$result_search_sq%'
                                                                            OR newsletter LIKE '%$result_search_sq%'";
                            }

                            $prepare2 = mysqli_prepare($conn, $stmt2);

                            if (!$prepare2) {
                                $mess = mysqli_connect_error();
                                alert("Impossibile completare l'operazione richiesta");
                            }

                            if (!mysqli_stmt_execute($prepare2)) {
                                alert("Errore nell'esecuzione della richiesta");
                                mysqli_stmt_close($prepare2);
                                mysqli_close($conn);
                            }

                            if ($res = mysqli_stmt_get_result($prepare2)) {
                                if (mysqli_num_rows($res) >= 1) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                        <tr>
                                            <td style="text-align: center"><input type="checkbox" class="checkbox_sq" name="emails[]"
                                                    value="<?php echo $row['email']; ?>"></td>
                                            <td class="checkbox_sq">
                                                <?php echo $row['email']; ?>
                                            </td>
                                            <td class="checkbox_sq">
                                                <?php echo $row['club_name']; ?>
                                            </td>
                                            <td class="checkbox_sq">
                                                <?php echo $row['telefono']; ?>
                                            </td>
                                            <td class="checkbox_sq">
                                                <?php echo $row['sede']; ?>
                                            </td>
                                            <td class="checkbox_sq" style="text-align:center">
                                                <?php
                                                if ($row['prov'] == "Genova") {
                                                    echo "GE";
                                                } else if ($row['prov'] == "Savona") {
                                                    echo "SV";
                                                } else if ($row['prov'] == "La Spezia") {
                                                    echo "SP";
                                                } else {
                                                    echo "IM";
                                                }
                                                ?>
                                            </td>
                                            <td class="checkbox_sq" width="5%" style="text-align:center">
                                                <?php
                                                if ($row['newsletter'] == 1) {
                                                    echo "Si";
                                                } else {
                                                    echo "No";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="box"></div>
                                    Non ci sono profili
                        </div>
                        <?php
                                }
                            }
                            ?>
                </tbody>
                </table>
            </div>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <button class="button button_delete" name="delete_sq"
                    onclick="return confirm('Sei sicuro di voler eliminare?');">Cancella squadre
                    selezionate</button>
            </form>
            </form>
        </div>
    </body>

    <script>
            var selezionaTuttipl = document.getElementById("selezionaTuttipl");
            var selezionaTuttisq = document.getElementById("selezionaTuttisq");

            var selezionabili_pl = document.getElementsByClassName("checkbox_pl");
            var selezionabili_sq = document.getElementsByClassName("checkbox_sq");

            selezionaTuttipl.addEventListener("click", function () {
                if (selezionaTuttipl.checked) {
                    for (var i = 0; i < selezionabili_pl.length; i++) {
                        selezionabili_pl[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < selezionabili_pl.length; i++) {
                        selezionabili_pl[i].checked = false;
                    }
                }
            });

            selezionaTuttisq.addEventListener("click", function () {
                if (selezionaTuttisq.checked) {
                    for (var i = 0; i < selezionabili_sq.length; i++) {
                        selezionabili_sq[i].checked = true;
                    }
                } else {
                    for (var i = 0; i < selezionabili_sq.length; i++) {
                 selezionabili_sq[i].checked = false;
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