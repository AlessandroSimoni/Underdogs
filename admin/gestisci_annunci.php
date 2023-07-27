<!DOCTYPE html>
<html lang="it">

<head>
    <title>Gestisci annunci</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="gestisci_annunci.css">
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


?>

    <body>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="container">
                <div class="small_container">
                    <table class="tabella">
                        <thead>
                            <header>BACHECA ANNUNCI</header>
                            <tr>
                                <th style="text-align: center"><input type="checkbox" id="selezionaTutti"></th>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Tipo annuncio</th>
                                <th>Titolo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../connection.php");
                            $query = "SELECT * FROM annunci";
                            $res = mysqli_query($conn, $query);
                            if ($res) {
                                if (mysqli_num_rows($res) >= 1) {
                                    while ($row = mysqli_fetch_assoc($res)) {
                            ?>
                                        <tr>
                                            <td><input type="checkbox" class="check" name="id[]" value="<?php echo $row['id']; ?>"></td>
                                            <td class="check">
                                                <?php echo $row['id']; ?>
                                            </td>
                                            <td class="check">
                                                <?php echo $row['email']; ?>
                                            </td>
                                            <td class="check">
                                                <?php echo $row['type_ann']; ?>
                                            </td>
                                            <td class="check">
                                                <?php echo $row['titolo']; ?>
                                            </td>
                                        </tr>
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
                        </tbody>
                    </table>
                    <form method="post" class="form">
                        <button class="button button_delete" name="delete">Cancella annunci selezionati</button>
                    </form>
                </div>
            </div>
        </form>
    </body>

    <script>
        var selezionaTutti = document.getElementById("selezionaTutti");
        var selezionabili = document.getElementsByClassName("check");

        selezionaTutti.addEventListener("click", function() {
            if (selezionaTutti.checked) {
                for (var i = 0; i < selezionabili.length; i++) {
                    selezionabili[i].checked = true;
                }
            } else {
                for (var i = 0; i < selezionabili.length; i++) {
                    selezionabili[i].checked = false;
                }
            }
        });
    </script>

<?php
} else {
    header("Location: ../login/login.php");
} ?>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $ids = isset($_POST['id']) ? $_POST['id'] : array();
        if (count($ids) == 0) {
            alert("Seleziona almeno un annuncio da eliminare");
        } else {
            foreach ($ids as $id) {
                $stmt = mysqli_prepare($conn, "DELETE FROM annunci WHERE id=?");
                if (!$stmt) {
                    $mess = mysqli_connect_error();
                    alert($mess);
                }
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            alert("Annunci eliminati con successo");
            exit();
        }
    }
}
?>