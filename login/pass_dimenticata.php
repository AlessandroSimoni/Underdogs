<!DOCTYPE html>
<html lang="it">

<head>
    <title>Password dimenticata</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <link rel="stylesheet" href="pass_dimenticata.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    include("../alert.php")
    ?>

    <form class="form" id="pass_dimenticata" action="pass_dimenticata.php" method="POST">
        <div class="container">
            <h1 class="form_title">Password dimenticata</h1>

            <?php
            if (isset($_GET['okcode'])) { ?>
                <p class="form_error"><?php echo $_GET['okcode']; ?></p>
                <input type="password" id="newpass" name="newpass" class="form_newpass" autofocus placeholder="Inserisci la nuova password">

                <input type="password" id="newpass2" name="newpass2" class="form_newpass2" placeholder="Ripeti la nuova password">

                <button class="form_button" id="new" name="new" type="new">Aggiorna password</button>

                <?php } else {
                if (isset($_GET['okemail'])) { ?>
                    <p class="form_error"><?php echo $_GET['okemail']; ?></p>
                    <input type="number" id="codice" name="codice" class="form_codice" autofocus placeholder="Inserisci il codice ricevuto nella mail">

                    <button class="form_button2" id="check" name="check" type="check">Controlla il codice</button>

                <?php } else { 
                        if (isset($_GET['error'])){?>
                            <p class="form_error"><?php echo $_GET['error'];} ?></p>

                    <p class="text_email">Inserisci la mail che hai utilizzato per iscriverti al sito per il ripristino:</p>
                    <input type="email" id="email " name="email" class="form_email" autofocus placeholder="Email">

                    <button class="form_button3" id="submit" name="submit" type="submit">Invia</button>
            <?php }
            } ?>

            <div class="form_link_group">
                <a href="login.php" class="form_link form_back">Torna ad accedi</a><br>
            </div>
        </div>
    </form>
</body>

</html>

<?php
session_start();

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        header("Location: pass_dimenticata.php?error=Inserisci la mail che hai utilizzato per iscriverti al sito per il ripristino");
    }

    $email = $_POST['email'];
    $trovato = true;

    include("../connection.php");

    $stmt = mysqli_prepare($conn, "SELECT * FROM calciatore WHERE email=?");
    if (!$stmt) {
        alert("Richiesta fallita");
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

    if (mysqli_num_rows($result) === 1) {
        $randomNumber = rand(000000, 999999);
        $_SESSION['email'] = $email;
        $_SESSION['codice'] = $randomNumber;
        include("sendCode.php");
        $_SESSION['type'] = "calciatore";
        header("Location: pass_dimenticata.php?okemail");
    } else {
        $stmt = mysqli_prepare($conn, "SELECT * FROM squadra WHERE email=?");
        if (!$stmt) {
            alert("Richiesta fallita");
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

        if (mysqli_num_rows($result) === 1) {
            $randomNumber = rand(000000, 999999);
            $_SESSION['email'] = $email;
            $_SESSION['codice'] = $randomNumber;
            include("sendCode.php");
            $_SESSION['type'] = "squadra";
            header("Location: pass_dimenticata.php?okemail");
        } else {
            header("Location: pass_dimenticata.php?error=Email non trovata");
        }
    }
}

if (isset($_POST['check'])) {
    if (empty($_POST['codice'])) {
        header("Location: pass_dimenticata.php?okemail=Codice non inserito");
    }

    $codice_verifica = $_SESSION['codice'];
    $codice = $_POST['codice'];

    if ($codice == $codice_verifica) {
        header("Location: pass_dimenticata.php?okcode");
    } else {
        header("Location: pass_dimenticata.php?okemail=Codice errato");
    }
}

if (isset($_POST['new'])) {
    if (empty($_POST['newpass']) || empty($_POST['newpass2'])) {
        header("Location: pass_dimenticata.php?okcode=Tutti i campi devono essere compilati");
    } else {

        $newpass = $_POST['newpass'];
        $newpass2 = $_POST['newpass2'];

        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/', $newpass)) {
            header("Location: pass_dimenticata.php?okcode=La password deve contenere almeno <br>8 caratteri, una lettera maiuscola, una minuscola, <br>un numero e un carattere speciale");
        } else {

            if ($newpass != $newpass2) {
                header("Location: pass_dimenticata.php?okcode=Le password non coincidono");
            } else {

                $cryptedpwd = password_hash($newpass, PASSWORD_DEFAULT);
                $email = $_SESSION['email'];
                $type = $_SESSION['type'];

                include("../connection.php");

                if ($type == "calciatore") {
                    $stmt = mysqli_prepare($conn, "UPDATE calciatore SET pass = ?, conf = ? WHERE email = ?");
                    if (!$stmt) {
                        alert("Richiesta fallita");
                    }

                    if (!mysqli_stmt_bind_param($stmt, "sss", $cryptedpwd, $cryptedpwd, $email)) {
                        alert("Impossibile completare l'operazione richiesta");
                        exit();
                    }

                    if (!mysqli_stmt_execute($stmt)) {
                        alert("Errore nell'esecuzione della richiesta");
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                    }

                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header("Location: login.php?okcode=Password aggiornata con successo");
                    alert("Password aggiornata con successo");
                    exit();
                } else {
                    $stmt = mysqli_prepare($conn, "UPDATE squadra SET pass = ?, conf = ? WHERE email = ?");
                    if (!$stmt) {
                        alert("Richiesta fallita");
                    }

                    if (!mysqli_stmt_bind_param($stmt, "sss", $cryptedpwd, $cryptedpwd, $email)) {
                        alert("Impossibile completare l'operazione richiesta");
                        exit();
                    }

                    if (!mysqli_stmt_execute($stmt)) {
                        alert("Errore nell'esecuzione della richiesta");
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                    }

                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header("Location: login.php?okcode=Password aggiornata con successo");
                    alert("Password aggiornata con successo");
                    exit();
                }
            }
        }
    }
}

?>