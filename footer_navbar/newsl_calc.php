<?php

if (basename($_SERVER['PHP_SELF']) == 'newsl_calc.php') {
    header("Location: login/login.php");
}

include('../connection.php');


$newsletter = 0;
$email = $_SESSION['email'];
$sql = mysqli_prepare($conn, "SELECT * FROM calciatore WHERE email = ?");

if (!$sql) {
    $mess = mysqli_connect_error();
    alert($mess);
}

if (!mysqli_stmt_bind_param($sql, "s", $email)) {
    alert("Impossibile completare l'operazione richiesta");
    exit();
}

if (!mysqli_stmt_execute($sql)) {
    alert("Errore nell'esecuzione della richiesta");
    mysqli_stmt_close($sql);
    mysqli_close($conn);
}

if ($result = mysqli_stmt_get_result($sql)) {
    if ($result->num_rows == 1) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC))
            $newsletter = $row["newsletter"];
    } else {
        alert("Error");
        exit();
    }

    $conn->close();
}

if ($newsletter == 0) { ?>
    <button class="button_newsletter" name="subscribe" style="font-weight: bold">
        Iscriviti alla newsletter
    </button>
<?php } else { ?>
    <button class="button_newsletter" name="Unsubscribe" style="font-weight: bold">
        Disiscriviti dalla newsletter
    </button>
<?php } ?>

<?php
if (isset($_POST['subscribe'])) {
    include('../connection.php');
    $newsletter = 1;
    $stmt = mysqli_prepare($conn, "UPDATE calciatore SET newsletter=? WHERE email=?");

    if (!$stmt) {
        $mess = mysqli_connect_error();
        alert($mess);
        exit();
    }

    if(!mysqli_stmt_bind_param($stmt, 'ss', $newsletter, $email)){
        alert("Impossibile completare l'operazione richiesta");
        exit();
    }

    if (!mysqli_stmt_execute($stmt)) {
        alert("Errore nell'esecuzione della richiesta");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        include('../emails/sendWelcomeEmail.php');
    }
}

if (isset($_POST['Unsubscribe'])) {
    include('../connection.php');
    $newsletter = 0;
    $stmt = mysqli_prepare($conn, "UPDATE calciatore SET newsletter=? WHERE email=?");

    if (!$stmt) {
        $mess = mysqli_connect_error();
        alert($mess);
        exit();
    }

    if(!mysqli_stmt_bind_param($stmt, 'ss', $newsletter, $email)){
        alert("Impossibile completare l'operazione richiesta");
        exit();
    }

    if (!mysqli_stmt_execute($stmt)) {
        alert("Errore nell'esecuzione della richiesta");
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        include('../emails/sendGoodbyeEmail.php');
    }
}

?>