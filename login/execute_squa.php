<?php
if (basename($_SERVER['PHP_SELF']) == 'execute_squa.php') {
    header("Location: ../login/login.php");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM squadra WHERE email = ?");

if (!$stmt) {
    alert("Richiesta fallita");
    exit();
}

if (!mysqli_stmt_bind_param($stmt, "s", $email)) {
    alert("Impossibile completare l'operazione richiesta");
    exit();
}

if (!mysqli_stmt_execute($stmt)) {
    alert("Errore nell'esecuzione della richiesta");
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) == 1) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if (password_verify($pass, $row['pass'])) {

        $_SESSION['tipo'] = $type;
        $_SESSION['email'] = $row['email'];
        $_SESSION['newsletter'] = $row['newsletter'];

        header("Location: ../home/home.php");
    } else {
        mysqli_close($conn);
        header("Location: login.php?error=La password non è corretta");
        exit();
    }
} else {
    mysqli_close($conn);
    header("Location: login.php?error=Account non trovato");
    exit();
}
?>