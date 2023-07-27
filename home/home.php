<!DOCTYPE html>
<html lang="it">

<head>
    <title>Home</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link rel="stylesheet" href="../footer_navbar/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>

    <?php
    session_start();

    if (isset($_SESSION['email'])) {
        if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
            include("../footer_navbar/navbar_mob.php");
        } else {
            include("../footer_navbar/navbar_desk.php");
        }
    ?>

        <div class="logo" style="z-index: 1">
            <a href="../home/home.php">
                <img src="../FOTO/logo_rimpicciolito_a.png" alt="Logo del sito">
            </a>
        </div>

        <div class="logopng" style="z-index: 1">
            <a href="../home/home.php">
                <img src="../FOTO/logo_a.png" alt="Logo png" width="220" height="220">
            </a>
        </div>

        <div class="container">
            <div class="small_container1">
                <?php
                if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false) {
                    include("classifica_mob.php");
                } else {
                    include('classifica_desk.php');
                }
                ?>

            </div>


            <div class="small_container2" id="small_container2">
                <table class="tabella-notizie" style="cursor: default">
                    <header class="header2" style="cursor: default">NOTIZIE</header>
                    <tbody>
                        <?php
                        include('../connection.php');
                        $sql3 = "SELECT * FROM news";
                        $result3 = $conn->query($sql3);
                        if ($result3->num_rows > 0) {
                            while ($row = $result3->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>";
                                echo "<a href=" . $row["link_titolo"] . " target='_blank'>" . $row["titolo"] . "</a>";
                                echo "<p>Fonte: <a href=" . $row["link_fonte"] . " target='_blank'>" . $row["nome_fonte"] . "</a></p>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "Non ci sono notizie da visualizzare.";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>

            <script>
                var scrolling = true;
                setInterval(function() {
                    if (scrolling) {
                        var div = document.getElementById('small_container2');
                        div.scrollTop += 1;
                        if (div.scrollTop >= div.scrollHeight - div.clientHeight) {
                            div.scrollTop = 0;
                        }
                    }
                }, 50);

                document.getElementById('small_container2').addEventListener('mouseover', function() {
                    scrolling = false;
                });

                document.getElementById('small_container2').addEventListener('mouseout', function() {
                    scrolling = true;
                });
            </script>
        </div>

        <div class="top_button" onclick="GoTop()">
            <a href="#head">
                <img src="../FOTO/uparrow.png" width="70" alt="Torna su">
            </a>
        </div>

        <?php include('../footer_navbar/footer.php'); ?>

        <script type="text/javascript" src="home.js"></script>

</body>

<?php
    } else {
        header("Location: ../login/login.php");
    }
?>

</html>