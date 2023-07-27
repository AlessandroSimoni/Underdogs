<?php
if (basename($_SERVER['PHP_SELF']) == 'navbar_mob.php') {
    header("Location: ../login/login.php");
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../footer_navbar/navbar_mob.css">

<nav class="nav_menu navbar-fixed-top navbar-default" style="z-index: 0">
    <div class="container-fluid" style="width: 100%">
        <a href="../home/home.php"><img src="../FOTO/logo_a.png" alt="Logo del sito"
                style="margin-left: 10%; margin-top: -0.75em; width: 3em; height: 3em"><a>

                <?php
                if (basename($_SERVER['PHP_SELF']) == 'annunci.php') { ?>
                    <form class="form-inline" action="annunci.php" method="POST">
                        <input class="form-control mr-sm-2" type="text" name="search" placeholder="Ricerca"
                            style="width: 10em">
                    </form>
                <?php } ?>

                <?php
                if (isset($_POST['search'])) {
                    $result_search = trim($_POST['search']);
                    $result_search = htmlspecialchars($result_search);
                    $_SESSION['result_search'] = $result_search;
                } ?>

                <ul class="nav navbar-nav"
                    style="display: flex; flex-wrap: wrap; justify-content: flex-end; width: 2%; margin-top: -7%; margin-left: 2%">
                    <li class="dropdown2"><a class="dropdown-toggle" style="color: #000000" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-menu-hamburger"></span></a>
                        <ul class="dropdown-menu" style="margin-left: 8em; margin-top:-3em">
                            <?php
                            if ($_SESSION['tipo'] != 'visitatore') { 
                                if ($_SESSION['tipo'] == 'admin') { ?>
                                    <li><a href="#" style="font-weight: bold">Home:</a></li>
                                    <li><a href="../admin/gestisci_classifica.php" style="font-weight: bold">* Gestisci classifica</a></li>
                                    <li><a href="../admin/gestisci_notizie.php" style="font-weight: bold">* Gestisci notizie</a></li>
                                    <li><a href="../admin/visualizza_recensioni.php" style="font-weight: bold">* Visualizza recensioni</a></li>


                                    <li><a href="#" style="font-weight: bold">Annunci:</a></li>
                                    <li><a href="../annunci/annunci.php" style="font-weight: bold">* Visualizza</a></li>
                                    <li><a href="../admin/gestisci_annunci.php" style="font-weight: bold">* Gestisci</a></li>

                                    <li><a href="#" style="font-weight: bold">Profilo:</a></li>
                                    <li><a href="../admin/gestisci_profili.php" style="font-weight: bold">* Gestisci</a></li>
                                    <li><a href="../index.php" style="font-weight: bold">* Logout</a></li>
                                <?php } else if ($_SESSION['tipo'] == 'calciatore') { ?>

                                        <li><a href="#" style="font-weight: bold">Annunci:</a></li>
                                        <li><a href="../annunci/annunci.php" style="font-weight: bold">* Visualizza</a></li>
                                        <li><a href="../annunci/inser_annunci_play.php" style="font-weight: bold">* Inserisci</a>
                                        </li>

                                        <li><a href="#" style="font-weight: bold">Profilo:</a></li>
                                        <li><a href="../profile_player/profile_player.php" style="font-weight: bold">*
                                                Interfaccia</a></li>
                                        <li><a href="../index.php" style="font-weight: bold">* Logout</a></li>

                                    <?php
                                } else { ?>
                                        <li><a href="#" style="font-weight: bold">Annunci:</a></li>
                                        <li><a href="../annunci/annunci.php" style="font-weight: bold">* Visualizza</a></li>
                                        <li><a href="../annunci/inser_annunci_club.php" style="font-weight: bold">* Inserisci</a>
                                        </li>

                                        <li><a href="#" style="font-weight: bold">Profilo:</a></li>
                                        <li><a href="../profile_club/profile_club.php" style="font-weight: bold">* Interfaccia</a>
                                        </li>
                                        <li><a href="../index.php" style="font-weight: bold">* Logout</a></li>
                                    <?php
                                }
                            } else if($_SESSION['tipo'] == 'visitatore'){ ?>
                                <li><a href="#" style="font-weight: bold">Annunci:</a></li>
                                <li><a href="../annunci/annunci.php" style="font-weight: bold">* Visualizza</a></li>

                                <li><a href="#" style="font-weight: bold">Profilo:</a></li>
                                <li><a href="../login/login.php" style="font-weight: bold">* Login</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
    </div>
</nav>