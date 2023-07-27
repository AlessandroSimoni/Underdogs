<!DOCTYPE html>
<html lang="it">

<head>
    <title>Visualizza recensioni</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="visualizza_recensioni.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>
    <?php
    session_start();

    if (isset($_SESSION['email']) && $_SESSION['tipo'] == 'admin') {
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
            include("../footer_navbar/navbar_mob.php");
        } else {
            include("../footer_navbar/navbar_desk.php");
        }

        include("../alert.php");

        include("../connection.php");
        $query = "SELECT * FROM recensione ORDER BY data_insert DESC LIMIT 20";
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
                        <header>BACHECA RECENSIONI</header>
                        <th>
                            <div class="button_container">
                                <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST">
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
                                    $query = "SELECT * FROM recensione ORDER BY data_insert DESC LIMIT 20";
                                if (isset($_POST['play']))
                                    $query = "SELECT * FROM recensione HAVING tipo_voto = 'squadra' ORDER BY data_insert DESC LIMIT 20";
                                if (isset($_POST['club']))
                                    $query = "SELECT * FROM recensione HAVING tipo_voto = 'calciatore' ORDER BY data_insert DESC LIMIT 20";
                                if (isset($_POST['search'])) {
                                    $result_search = $_SESSION['result_search'];
                                    $query = "SELECT * FROM recensione HAVING tipo_voto LIKE '%$result_search%'
                                                                    OR email LIKE '%$result_search%'
                                                                    OR voto LIKE '%$result_search%'
                                                                    ORDER BY data_insert DESC LIMIT 20";
                                }

                                $res = mysqli_query($conn, $query);
                                if ($res) {
                                    if (mysqli_num_rows($res) >= 1) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $id = $row['id'];
                                ?>
                                            <div class="box" style="cursor: default">
                                                <div class="text">
                                                    Tipo voto: <?php echo $row['tipo_voto']; ?> <br>
                                                    Email: <?php echo $row['email']; ?> <br>
                                                    Voto: <?php echo $row['voto']; ?> <br>
                                                    Titolo: <?php echo $row['titolo']; ?> <br>
                                                    Descrizione: <?php echo $row['descr']; ?> <br>
                                                    Data inserimento: <?php echo substr($row['data_insert'], 0, 10); ?> <br>

                                                    <form action="visualizza_recensioni.php" method="POST">
                                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                        <button class="button_elimina" name="delete" style="font-weight: bold">
                                                            Elimina
                                                        </button>
                                                    </form>
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

        <div class="box_title" style="cursor: default">
            <header>DATI DELLE RECENSIONI</header>
        </div>
        <div class="interazioni">
            <div class="big_box">
                <img class="img1" src="../FOTO/recensione.png">

                <div class="box_interazioni box1">
                    <p class="txt_interazioni">Numero di recensioni</p>
                    <p class="num_interazioni">
                        <?php
                        $query = "SELECT COUNT(*) AS num FROM recensione";
                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            $row = mysqli_fetch_assoc($res);
                            echo $row['num'];
                        }
                        ?>
                    </p>
                </div>

                <div class="box_interazioni box4">
                    <p class="txt_interazioni">Media recensioni</p>
                    <p class="num_interazioni">
                        <?php
                        $query = "SELECT AVG(voto) AS media FROM recensione";
                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            $row = mysqli_fetch_assoc($res);
                            echo round($row['media'], 2);
                        }
                        ?>
                    </p>
                </div>

                <img class="img2" src="../FOTO/squadra.png">

                <div class="box_interazioni box2">
                    <p class="txt_interazioni">Numero di recensioni squadra</p>
                    <p class="num_interazioni">
                        <?php
                        $query = "SELECT COUNT(*) AS num FROM recensione WHERE tipo_voto = 'squadra'";
                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            $row = mysqli_fetch_assoc($res);
                            echo $row['num'];
                        }
                        ?>
                    </p>
                </div>

                <div class="box_interazioni box5">
                    <p class="txt_interazioni">Media recensioni squadra</p>
                    <p class="num_interazioni">
                        <?php
                        $query = "SELECT AVG(voto) AS media FROM recensione WHERE tipo_voto = 'squadra'";
                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            $row = mysqli_fetch_assoc($res);
                            echo round($row['media'], 2);
                        }
                        ?>
                    </p>
                </div>

                <img class="img3" src="../FOTO/calciatore.png">

                <div class="box_interazioni box3">
                    <p class="txt_interazioni">Numero di recensioni calciatore</p>
                    <p class="num_interazioni">
                        <?php
                        $query = "SELECT COUNT(*) AS num FROM recensione WHERE tipo_voto = 'calciatore'";
                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            $row = mysqli_fetch_assoc($res);
                            echo $row['num'];
                        }
                        ?>
                    </p>
                </div>

                <div class="box_interazioni box6">
                    <p class="txt_interazioni">Media recensioni calciatore</p>
                    <p class="num_interazioni">
                        <?php
                        $query = "SELECT AVG(voto) AS media FROM recensione WHERE tipo_voto = 'calciatore'";
                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            $row = mysqli_fetch_assoc($res);
                            echo round($row['media'], 2);
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    <?php
        mysqli_close($conn);

        if (isset($_POST['delete'])) {
            $id = $_POST['id'];

            include("../connection.php");
            $delete_query = "DELETE FROM recensione WHERE id = '$id'";

            if ($conn->query($delete_query) === TRUE) {
                alert("Recensione cancellata con successo");
                echo "<script>window.location.href='visualizza_recensioni.php';</script>";
            } else {
                alert("Errore nella cancellazione della recensione");
            }
        }
    } else {
        header("Location: ../login/login.php");
    }
    ?>
</body>

</html>