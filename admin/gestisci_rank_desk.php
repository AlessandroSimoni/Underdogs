<?php
if (basename($_SERVER['PHP_SELF']) == 'gestisci_rank_desk.php') {
    header("Location: ../login/login.php");
}
?>

<div class="small_container" style="height: 400px">
    <table class="tabella" style="margin-top: 2%">
        <thead>
            <header>
                <p style="float: left">CLASSIFICA DI GENOVA</p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input class="form-control mr-sm-2" type="text" name="search_ge" placeholder="Ricerca"
                        style="margin-left: auto; width: 200px">
                </form>
            </header>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <tr>
                    <th style="text-align: center"><input type="checkbox" id="selezionaTuttige"></th>
                    <th>Squadra</th>
                    <th>Punti</th>
                    <th>Partite giocate</th>
                    <th>Vittorie</th>
                    <th>Sconfitte</th>
                    <th>Pareggi</th>
                </tr>
        </thead>
        <tbody>
            <?php
            include('../connection.php');

            $query1 = "SELECT * FROM classifica_ge ORDER BY punti DESC";
            if (isset($_POST['search_ge'])) {
                $result_search_ge = trim($_POST['search_ge']);
                $result_search_ge = htmlspecialchars($result_search_ge);
                $query1 = "SELECT * FROM classifica_ge HAVING squadra LIKE '%$result_search_ge%'
                                                                            OR punti LIKE '%$result_search_ge%'
                                                                            OR partite_giocate LIKE '%$result_search_ge%'
                                                                            OR vittorie LIKE '%$result_search_ge%'
                                                                            OR sconfitte LIKE '%$result_search_ge%'
                                                                            OR pareggi LIKE '%$result_search_ge%'";
            }
            $res = mysqli_query($conn, $query1);
            if ($res) {
                if (mysqli_num_rows($res) >= 1) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td style="text-align: center">
                                <input type="checkbox" class="checkbox_ge" name="squadra[]" value="<?php echo $row['id']; ?>">
                            </td>
                            <td class="checkbox_ge">
                                <?php echo $row['squadra']; ?>
                            </td>
                            <td class="checkbox_ge" width="5%" style="text-align:center">
                                <?php echo $row['punti']; ?>
                            </td>
                            <td class="checkbox_ge" width="15%" style="text-align:center">
                                <?php echo $row['partite_giocate']; ?>
                            </td>
                            <td class="checkbox_ge" width="5%" style="text-align:center">
                                <?php echo $row['vittorie']; ?>
                            </td>
                            <td class="checkbox_ge" width="5%" style="text-align:center">
                                <?php echo $row['sconfitte']; ?>
                            </td>
                            <td class="checkbox_ge" width="5%" style="text-align:center">
                                <?php echo $row['pareggi']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <div class="box">
                        Non ci sono squadre nella classifica di Genova
                    </div>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<button class="button button_insert" name="inserisci_ge">Inserisci</button>
<button class="button button_modify" name="modifica_ge">Modifica</button>
<button class="button button_delete" name="delete_ge" style="margin-left: 10%; width: 300px; float: left"
    onclick="return confirm('Sei sicuro di voler eliminare?');">Cancella posizioni selezionate</button>
</form>

<div class="small_container" style="margin-top: 18%; height: 400px">
    <table class="tabella" style="margin-top: 2%">
        <thead>
            <header>
                <p style="float: left">CLASSIFICA DI CHIAVARI</p>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input class="form-control mr-sm-2" type="text" name="search_ch" placeholder="Ricerca"
                        style="margin-left: auto; width: 200px">
                </form>
            </header>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <tr>
                    <th style="text-align: center"><input type="checkbox" id="selezionaTuttich"></th>
                    <th>Squadra</th>
                    <th>Punti</th>
                    <th>Partite giocate</th>
                    <th>Vittorie</th>
                    <th>Sconfitte</th>
                    <th>Pareggi</th>
                </tr>
        </thead>
        <tbody>
            <?php
            $query2 = "SELECT * FROM classifica_ch ORDER BY punti DESC";
            if (isset($_POST['search_ch'])) {
                $result_search_ch = trim($_POST['search_ch']);
                $result_search_ch = htmlspecialchars($result_search_ch);
                $query2 = "SELECT * FROM classifica_ch HAVING squadra LIKE '%$result_search_ch%'
                                                                        OR punti LIKE '%$result_search_ch%'
                                                                        OR partite_giocate LIKE '%$result_search_ch%'
                                                                        OR vittorie LIKE '%$result_search_ch%'
                                                                        OR sconfitte LIKE '%$result_search_ch%'
                                                                        OR pareggi LIKE '%$result_search_ch%'";
            }
            $res = mysqli_query($conn, $query2);
            if ($res) {
                if (mysqli_num_rows($res) >= 1) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td style="text-align: center">
                                <input type="checkbox" class="checkbox_ch" name="squadra[]" value="<?php echo $row['id']; ?>">
                            </td>
                            <td class="checkbox_ch">
                                <?php echo $row['squadra']; ?>
                            </td>
                            <td class="checkbox_ch" width="5%" style="text-align:center">
                                <?php echo $row['punti']; ?>
                            </td>
                            <td class="checkbox_ch" width="15%" style="text-align:center">
                                <?php echo $row['partite_giocate']; ?>
                            </td>
                            <td class="checkbox_ch" width="5%" style="text-align:center">
                                <?php echo $row['vittorie']; ?>
                            </td>
                            <td class="checkbox_ch" width="5%" style="text-align:center">
                                <?php echo $row['sconfitte']; ?>
                            </td>
                            <td class="checkbox_ch" width="5%" style="text-align:center">
                                <?php echo $row['pareggi']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <div class="box">
                        Non ci sono squadre nella classifica di Chiavari
                    </div>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
<button class="button button_insert" name="inserisci_ch">Inserisci</button>
<button class="button button_modify" name="modifica_ch">Modifica</button>
<button class="button button_delete" name="delete_ch" style="margin-left: 10%; width: 300px; float: left"
    onclick="return confirm('Sei sicuro di voler eliminare?');">Cancella posizioni selezionate</button>
</form>