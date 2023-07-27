<?php
if (basename($_SERVER['PHP_SELF']) == 'classifica_mob.php') {
    header("Location: ../login/login.php");
}
?>

<table class="tabella-classifica" style="cursor: default">
    <thead>
        <header class="header1" style="cursor: default">CLASSIFICA CAMPIONATO GENOVA</header>
        <tr>
            <th>Pos</th>
            <th>Squadra</th>
            <th>Pt</th>
            <th>Pg</th>
            <th>V</th>
            <th>S</th>
            <th>P</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            include('../connection.php');
            $sql1 = "SELECT * FROM classifica_ge ORDER BY punti DESC";
            $result1 = $conn->query($sql1);
            $posizione = 1;
            if ($result1->num_rows > 0) {
                while ($row = $result1->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $posizione . "</td>";
                    echo "<td>" . $row["squadra"] . "</td>";
                    echo "<td>" . $row["punti"] . "</td>";
                    echo "<td>" . $row["partite_giocate"] . "</td>";
                    echo "<td>" . $row["vittorie"] . "</td>";
                    echo "<td>" . $row["sconfitte"] . "</td>";
                    echo "<td>" . $row["pareggi"] . "</td>";
                    echo "</tr>";
                    $posizione++;
                }
            } else {
                echo "Nessun dato trovato nella tabella classifica.";
            }
            $conn->close();
            ?>
        </tr>
    </tbody>
</table>

<table class="tabella-classifica" style="cursor: default">
    <thead>
        <header class="header1" style="cursor: default;  margin-top: 5%">CLASSIFICA CAMPIONATO CHIAVARI</header>
        <tr>
            <th>Pos</th>
            <th>Squadra</th>
            <th>Pt</th>
            <th>Pg</th>
            <th>V</th>
            <th>S</th>
            <th>P</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php
            include('../connection.php');
            $sql2 = "SELECT * FROM classifica_ch ORDER BY punti DESC";
            $result2 = $conn->query($sql2);
            $posizione = 1;
            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $posizione . "</td>";
                    echo "<td>" . $row["squadra"] . "</td>";
                    echo "<td>" . $row["punti"] . "</td>";
                    echo "<td>" . $row["partite_giocate"] . "</td>";
                    echo "<td>" . $row["vittorie"] . "</td>";
                    echo "<td>" . $row["sconfitte"] . "</td>";
                    echo "<td>" . $row["pareggi"] . "</td>";
                    echo "</tr>";
                    $posizione++;
                }
            } else {
                echo "Nessun dato trovato nella tabella classifica.";
            }
            $conn->close();
            ?>
        </tr>
    </tbody>
</table>