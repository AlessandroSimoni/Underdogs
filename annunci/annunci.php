<!DOCTYPE html>
<html lang="it">

<head>
    <title>Annunci</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <link rel="stylesheet" href="annunci.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php
    include("../alert.php");

    session_start();

    if (isset($_SESSION['email'])) {
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
            include("../footer_navbar/navbar_mob.php");
        } else {
            include("../footer_navbar/navbar_desk.php");
        }


        include("../connection.php");
        $query = "SELECT * FROM annunci ORDER BY date_insert DESC LIMIT 20";
        $result = mysqli_query($conn, $query);

        if (isset($_POST['delete_my_ann'])) {
            $id = $_POST['my_ann'];
            $delete_query = "DELETE FROM annunci WHERE id = '$id'";

            if ($conn->query($delete_query) === TRUE) {
                alert("Annuncio eliminato");
            } else {
                alert("Errore nella cancellazione dell'annuncio");
            }
        }
    ?>

        <div class="logopng" style="z-index: 1">
            <a href="../home/home.php">
                <img src="../FOTO/logo_a.png" alt="Logo png" width="110" height="110">
            </a>
        </div>

        <div class="container">
            <div class="small_container">
                <table class="tabella">
                    <thead>
                        <header>BACHECA ANNUNCI</header>
                        <th>
                            <div class="button_container">
                                <form action="annunci.php" method="POST">
                                    <button class="button_filter1" name="all" style="font-weight: bold; margin-right: 3%">
                                        Tutti
                                    </button>
                                    <button class="button_filter2" name="play" style="font-weight: bold; margin-right: 3%">
                                        Squadra
                                    </button>
                                    <button class="button_filter2" name="club" style="font-weight: bold">
                                        Calciatore
                                    </button>
                                </form>

                                <?php
                                if (isset($_POST['all']))
                                    $query = "SELECT * FROM annunci ORDER BY date_insert DESC LIMIT 20";
                                if (isset($_POST['play']))
                                    $query = "SELECT * FROM annunci HAVING type_ann = 'squadra' ORDER BY date_insert DESC LIMIT 20";
                                if (isset($_POST['club']))
                                    $query = "SELECT * FROM annunci HAVING type_ann = 'calciatore' ORDER BY date_insert DESC LIMIT 20";
                                if (isset($_POST['search'])) {
                                    $result_search = $_SESSION['result_search'];
                                    $query = "SELECT * FROM annunci HAVING type_ann LIKE '%$result_search%'
                                                                    OR email LIKE '%$result_search%'
                                                                    OR titolo LIKE '%$result_search%'
                                                                    OR descr LIKE '%$result_search%'
                                                                    OR esp LIKE '%$result_search%'
                                                                    OR posizione LIKE '%$result_search%'
                                                                    OR piede LIKE '%$result_search%'
                                                                    ORDER BY date_insert DESC LIMIT 20";
                                }

                                $res = mysqli_query($conn, $query);
                                if ($res) {
                                    if (mysqli_num_rows($res) >= 1) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $id = $row['id'];
                                ?>

                                            <div class="box" style="cursor: default">
                                                <div class="text">
                                                    Tipo annuncio:
                                                    <?= $row['type_ann'] ?><br>
                                                    Titolo:
                                                    <?= $row['titolo'] ?><br>
                                                    Descrizione:
                                                    <?= $row['descr'] ?><br>
                                                    <?php
                                                    if ($row['esp'] != NULL) { ?>
                                                        Esperienze:
                                                        <?= $row['esp'] ?><br>
                                                        <?php }
                                                    if ($row['posizione'] != NULL) {
                                                        if ($row['type_ann'] == 'squadra') { ?>
                                                            Posizione cercata:
                                                        <?php } else { ?>
                                                            Posizione:
                                                            <?php } ?><?= $row['posizione'] ?><br>
                                                            <?php }
                                                        if ($row['piede'] != NULL) {
                                                            if ($row['type_ann'] == 'squadra') { ?>
                                                                Piede cercato:
                                                                <?= $row['piede'] ?><br>
                                                            <?php } else { ?>
                                                                Piede:
                                                                <?= $row['piede'] ?><br>
                                                            <?php }
                                                        }

                                                        if (!isset($_SESSION['tipo'])) { ?>
                                                            <a href="../login/login.php">Visualizza profilo inserzionista</a>
                                                        <?php } else { ?>
                                                            <a class="inserzionista" href="profile_ann.php?id=<?= $id ?>" target="_blank">Visualizza profilo inserzionista</a>
                                                            <?php }
                                                        if (isset($_SESSION['tipo'])) {
                                                            if ($_SESSION['email'] == $row['email']) { ?>
                                                                <form action="annunci.php" method="POST">
                                                                    <input type="hidden" name="my_ann" value="<?= $id ?>">
                                                                    <button class="button_delete" name="delete_my_ann" style="font-weight: bold">Cancella</button>
                                                                </form>
                                                        <?php }
                                                        }
                                                        ?>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="box">
                                            Non ci sono annunci
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </th>
                    </thead>
                </table>
            </div>
        </div>
</body>
<?php
    } else {
        header("Location: ../login/login.php");
    }
?>

</html>