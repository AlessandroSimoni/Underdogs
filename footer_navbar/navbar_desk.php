<?php
if (basename($_SERVER['PHP_SELF']) == 'navbar_desk.php') {
    header("Location: ../login/login.php");
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../footer_navbar/navbar_desk.css">

<nav class="nav_menu navbar-fixed-top navbar-right" style="z-index: 0">
    <div class="container-fluid" style="width: 100%">
        <ul class="nav navbar-nav" style="display: flex; flex-wrap: wrap; justify-content: flex-end; width: 100%; margin: 0">
            <?php
            if (basename($_SERVER['PHP_SELF']) == 'annunci.php' || basename($_SERVER['PHP_SELF']) == 'visualizza_recensioni.php') { ?>
                <form class="form-inline" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" style="display: inline-block; margin-top: 1rem; margin-right: 2em">
                    <input class="form-control mr-sm-2" type="text" name="search" placeholder="Ricerca" style="width: 15em">
                </form>
            <?php } ?>

            <?php
            if (isset($_POST['search'])) {
                $result_search = trim($_POST['search']);
                $result_search = htmlspecialchars($result_search);
                $_SESSION['result_search'] = $result_search;
            } ?>

            <?php
            if ($_SESSION['tipo'] == "admin") {
            ?>
                <li class="dropdown1"><a class="dropdown-toggle" style="color: #000000" data-toggle="dropdown"><span class="glyphicon glyphicon-home"></span>Home<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../admin/gestisci_classifica.php" style="font-weight: bold">Gestisci classifica</a></li>
                        <li><a href="../admin/gestisci_notizie.php" style="font-weight: bold">Gestisci notizie</a></li>
                        <li><a href="../admin/visualizza_recensioni.php" style="font-weight: bold">Visualizza recensioni</a></li>
                    </ul>
                </li>
            <?php } ?>

            <li class="dropdown2"><a class="dropdown-toggle" style="color: #000000" data-toggle="dropdown"><span class="glyphicon glyphicon-list-alt"></span>Annunci<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="../annunci/annunci.php" style="font-weight: bold">Visualizza</a></li>
                    <li>

                        <?php
                        if ($_SESSION['tipo'] == 'calciatore') { ?>
                            <a href="../annunci/inser_annunci_play.php" style="font-weight: bold">Inserisci</a>
                        <?php } else if ($_SESSION['tipo'] == "squadra") { ?>
                            <a href="../annunci/inser_annunci_club.php" style="font-weight: bold">Inserisci</a>
                        <?php } else if($_SESSION['tipo'] == 'admin'){ ?>
                            <a href="../admin/gestisci_annunci.php" style="font-weight: bold">Gestisci</a>
                        <?php } ?>
                    </li>
                </ul>
            </li>
            <li class="dropdown3"><a class="dropdown-toggle" style="color: #000000" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>Profilo<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <?php
                        if ($_SESSION['tipo'] == 'visitatore') { ?>
                            <a href="../login/login.php" style="font-weight: bold">Login</a>
                        <?php } else if ($_SESSION['tipo'] == 'admin') { ?>
                            <a href="../admin/gestisci_profili.php" style="font-weight: bold">Gestisci</a>
                        <?php }else if ($_SESSION['tipo'] =='calciatore') { ?>
                            <a href="../profile_player/profile_player.php" style="font-weight: bold">Interfaccia
                                profilo</a>
                        <?php } else { ?>
                            <a href="../profile_club/profile_club.php" style="font-weight: bold">Interfaccia profilo</a>
                        <?php } ?>
                    </li>
                    <li>
                        <?php
                        if ($_SESSION['tipo'] != 'visitatore') { ?>
                            <a href="../logout.php" style="font-weight: bold">Logout</a>
                        <?php }
                        ?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>