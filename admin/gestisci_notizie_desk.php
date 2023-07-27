<?php
if (basename($_SERVER['PHP_SELF']) == 'gestisci_notizie_desk.php') {
    header("Location: ../login/login.php");
}
?>

<div class="mid_container" style="margin-top: 10%; height: 700px">
    <div class="small_container" style="height: 500px">
        <table class="tabella" style="margin-top: 4%">
            <thead>
                <header>
                    <p style="float: left">GESTIONE NOTIZIE</p>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input class="form-control mr-sm-2" type="text" name="search" placeholder="Ricerca"
                            style="margin-left: auto; width: 200px">
                    </form>
                </header>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <tr>
                        <th width="5%" style="text-align: center"><input type="checkbox" id="selezionaTutti"></th>
                        <th width="30%">Titolo</th>
                        <th width="13%">Link news</th>
                        <th style="text-align: center">Fonte</th>
                        <th width="13%">Link fonte</th>
                    </tr>
            </thead>
            <tbody>
                <?php
                include("../connection.php");
                $query = "SELECT * FROM news";
                if (isset($_POST['search'])) {
                    $result_search = trim($_POST['search']);
                    $result_search = htmlspecialchars($result_search);
                    $query = "SELECT * FROM news HAVING titolo LIKE '%$result_search%'
                                                                            OR nome_fonte LIKE '%$result_search%'";
                }
                $res = mysqli_query($conn, $query);
                if ($res) {
                    if (mysqli_num_rows($res) >= 1) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            ?>
                            <tr>
                                <td style="text-align: center"><input type="checkbox" class="checkbox_n" name="id_n[]"
                                        value="<?php echo $row['id']; ?>"></td>
                                <td class="checkbox_n">
                                    <?php echo $row['titolo']; ?>
                                </td>
                                <td class="checkbox_n" width="5%" style="text-align:center">
                                    <a href="<?php echo $row['link_titolo']; ?>" target="_blank">
                                        <img src="../FOTO/link.png" alt="link_titolo" width="20" height="20">
                                    </a>
                                </td>
                                <td class="checkbox_n" width="15%" style="text-align:center">
                                    <?php echo $row['nome_fonte']; ?>
                                </td>
                                <td class="checkbox_n" width="5%" style="text-align:center">
                                    <a href="<?php echo $row['link_fonte']; ?>" target="_blank">
                                        <img src="../FOTO/link.png" alt="link_fonte" width="20" height="20">
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="box">
                            Non ci sono notizie
                        </div>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <button class="button button_insert" name="inserisci">Inserisci</button>
    <button class="button button_modify" name="modifica">Modifica</button>
    <button class="button button_delete" name="delete" style="margin-left: 10%; width: 300px; float: left"
        onclick="return confirm('Sei sicuro di voler eliminare?');">Cancella notizie selezionate</button>
    </form>
</div>