<?php
if (basename($_SERVER['PHP_SELF']) == 'footer.php') {
    header("Location: ../login/login.php");
}
?>


<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="footer">
    <div class="container">
        <div class="character" style="float: left">
            <a href="mailto:f.tamerisco@gmail.com"><img src="../FOTO/fede_posta.png" width="240px" height="240px"></a>
        </div>

        <p class="contacts">
            Contattaci qui:
            <br>
            <br>

            <a href="mailto:f.tamerisco@gmail.com" class="mail">
                f.tamerisco@gmail.com
            </a>
            <br>
            <a href="mailto:alesimoni2000@gmail.com" class="mail">
                alesimoni2000@gmail.com
            </a>
        </p>

        <div class="character" style="float: right">
            <a href="mailto:alesimoni2000@gmail.com"><img src="../FOTO/ale_posta.png" width="240px" height="240px"></a>
        </div>
    </div>
    <form action="home.php" method="POST">
        <div class="button_container">
            <?php
            include('../alert.php');

            if ($_SESSION['tipo'] == 'visitatore') {
            ?>
                <a href="../login/login.php" class="button_newsletter" style="font-weight: bold">
                    Iscriviti alla newsletter
                </a>
            <?php
            } else if ($_SESSION['tipo'] == 'admin') {
            ?>
                <a href="../admin/crea_newsletter.php" class="button_newsletter" style="font-weight: bold">
                    Crea newsletter
                </a>
            <?php
            } else if ($_SESSION['tipo'] == 'calciatore') {
                include('newsl_calc.php');
            ?>
                <a href="../footer_navbar/recensione.php" class="button_newsletter" style="font-weight: bold">
                    Lasciaci una recensione
                </a>
            <?php
            } else {
                include('newsl_squa.php');
            ?>
                <a href="../footer_navbar/recensione.php" class="button_newsletter" style="font-weight: bold">
                    Lasciaci una recensione
                </a>
            <?php
            }
            ?>
        </div>
    </form>
</div>