<!DOCTYPE html>
<html lang="it">

<head>
    <title>Modifica notizie</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modifica_notizie.css">
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

        if (isset($_POST['back']))
            header("Location: gestisci_notizie.php");

        $ids = $_SESSION['id'];
    ?>

        <div class="box_title" style="cursor: default">
            <p class="txt_title" style="font-size: 30px; padding: 16px 16px">MODIFICA LE NOTIZIE</p>
        </div>

        <div class="container">
            <div class="mid_container">
                <table class="tabella" style="margin-top: auto">
                    <thead>
                        <tr>
                            <th style="width:8%; text-align:center">Titolo</th>
                            <th style="width:5%; text-align:center">Link titolo</th>
                            <th style="width:4%; text-align:center">Fonte</th>
                            <th style="width:5%; text-align:center">Link fonte</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('../connection.php');

                        $query = "SELECT * FROM news WHERE id IN ('" . implode("','", $ids) . "')";

                        $res = mysqli_query($conn, $query);
                        if ($res) {
                            if (mysqli_num_rows($res) >= 1) {
                        ?>
                                <form action="modifica_notizie.php" method="POST">

                                    <?php
                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <tr>
                                            <td>
                                                <input type="text" name="titolo[]" class="change_titolo" placeholder="Titolo notizia" value="<?php echo $row['titolo']; ?>">
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="link_titolo[]" class="change_link_titolo" placeholder="Link titolo" value="<?php echo $row['link_titolo']; ?>">
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="nome_fonte[]" class="change_fonte" placeholder="Fonte" value="<?php echo $row['nome_fonte']; ?>">
                                            </td>
                                            <td style="text-align:center">
                                                <input type="text" name="link_fonte[]" class="change_link_fonte" placeholder="Link fonte" value="<?php echo $row['link_fonte']; ?>">
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
    }
?>

</html>

<?php
if (isset($_POST['change'])) {
    $titolo = $_POST['titolo'];
    $link_titolo = $_POST['link_titolo'];
    $nome_fonte = $_POST['nome_fonte'];
    $link_fonte = $_POST['link_fonte'];

    include('../connection.php');

    $query = "UPDATE news SET titolo = ?, link_titolo = ?, nome_fonte = ?, link_fonte = ? WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        $mess = mysqli_error($conn);
        alert("Impossibile completare l'operazione richiesta");
        exit();
    }

    $count = 0;
    foreach ($ids as $id) {
        $titolo_val = $titolo[$count];
        $link_titolo_val = $link_titolo[$count];
        $nome_fonte_val = $nome_fonte[$count];
        $link_fonte_val = $link_fonte[$count];

        mysqli_stmt_bind_param($stmt, "sssss", $titolo_val, $link_titolo_val, $nome_fonte_val, $link_fonte_val, $id);

        if (!mysqli_stmt_execute($stmt)) {
            alert("Errore nell'esecuzione della richiesta");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            exit();
        }

        $count++;
    }
    echo "<script>
            alert('Modifiche avvenute con successo');
            window.location.href='../admin/gestisci_notizie.php';
            </script>";
}
?>