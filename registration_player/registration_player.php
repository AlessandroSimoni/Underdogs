<!DOCTYPE html>
<html lang="it">

<head>
    <title>Registrazione calciatore</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registration_player.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>

<body>

    <a href="../index.php"><img src="../FOTO/logo_completo_a.png" class="form_logo" alt="Logo site"></a>
    <div class="hero">
        <div class="form_box">
            <h1 class="form_title">Registrazione calciatore</h1>
            <h4 class="form_subtitle">Inserisci i tuoi dati nei campi sottostanti</h4>

            <form action="registration_player.php" method="POST">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="form_error" id="error">
                        <?php echo $_GET['error']; ?>
                    </p>
                <?php } ?>

                <input type="text" id="firstname" name="firstname" class="form_nome" autofocus placeholder="Nome">

                <input type="text" name="lastname" class="form_cognome" placeholder="Cognome">

                <input type="email" id="email" name="email" class="form_email" placeholder="Email">
                <select id="sesso" name="sesso" class="form_type">
                    <option selected value="" disabled>Sesso</option>
                    <option value="Maschio">Maschio</option>
                    <option value="Femmina">Femmina</option>
                </select><br>

                <div class="b_day">Data di nascita:</div>
                <input type="date" name="nascita" class="calendar" value="gg-mm-aaaa" min="13-10-1970" max="22-11-2006">

                <select name="prov" class="form_prov">
                    <option selected value="" disabled>Provincia</option>
                    <option value="Genova">Genova</option>
                    <option value="Imperia">Imperia</option>
                    <option value="Savona">Savona</option>
                    <option value="La Spezia">La Spezia</option>
                </select>

                <input type="password" id="pass" name="pass" class="form_pass" placeholder="Password">

                <input type="password" id="confirm" name="confirm" class="form_conf_pass" placeholder="Conferma password">

                <input type="checkbox" id="check_privacy" name="check_privacy" class="check_privacy">
                <label for="privacy" class="form_privacy">Acconsento al trattamento dei dati personali *</label><br>

                <button class="form_regis" name="submit" type="submit" onclick="allInput()">Registrati</button>
            </form>

            <div class="form_link_group">
                <a href="../registration_club/registration_club.php" class="form_link form_team">Sei una squadra di
                    calcio? Registrati qui!</a><br>

                <a href="../login/login.php" class="form_link form_login">Hai già un account? Esegui l'accesso qui!</a>
            </div>
        </div>
    </div>
</body>

</html>

<?php
    if (isset($_POST['submit'])) {

        session_start();

        if (empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) ||empty($_POST['pass']) || empty($_POST['confirm'])) {
            header("Location: registration_player.php?error=Tutti i campi devono essere compilati");
            exit();
        }

        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: registration_player.php?error=$email non è una e-mail valida");
            exit();
        }
        $pass = trim($_POST['pass']);
        $confirm = trim($_POST['confirm']);

        $sesso = (isset($_POST['sesso'])) ? trim($_POST['sesso']) : 'Maschio';
        $nascita = (isset($_POST['nascita'])) ? trim($_POST['nascita']) : '2000-01-01';
        $prov = (isset($_POST['prov'])) ? trim($_POST['prov']) : 'Genova';
        $pos = 'Qualsiasi';
        $piede = 'Ambidestro';
        $alt = 0;
        $peso = 0;
        $stato = 'Svincolato';
        $newsletter = 0;
        $_SESSION['tipo'] = "calciatore";
        $_SESSION['email'] = $email;
        $_SESSION['newsletter'] = $newsletter;


        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $pass)){
            header("Location: registration_player.php?error=La password deve contenere almeno 8 caratteri, una lettera maiuscola e una minuscola");
            exit();
        }

        if ($pass != $confirm) {
            header("Location: registration_player.php?error=Le password non corrispondono");
            exit();
        }

        include('../connection.php');

        if (mysqli_connect_errno()) {
            header("Location: registration_player.php?error=Errore di connessione");
            exit();
        }

        $cryptedpwd = password_hash($pass, PASSWORD_DEFAULT);
        $firstname = htmlspecialchars($firstname, ENT_QUOTES);
        $lastname = htmlspecialchars($lastname, ENT_QUOTES);
        $email = htmlspecialchars($email, ENT_QUOTES);

        $stmt = mysqli_prepare($conn, "INSERT INTO calciatore (email, tipo, firstname, lastname, sesso, nascita, prov, posizione, piede, altezza, peso, stato, newsletter, pass, conf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            header("Location: registration_player.php?error=Richiesta fallita");
            exit();
        }

        if (!mysqli_stmt_bind_param($stmt, 'sssssssssssssss', $email, $_SESSION['tipo'], $firstname, $lastname, $sesso, $nascita, $prov, $pos, $piede, $alt, $peso, $stato, $newsletter, $cryptedpwd, $cryptedpwd)) {
            header("Location: registration_player.php?error=Impossibile elaborare la richiesta");
            exit();
        }

        if (!mysqli_stmt_execute($stmt)) {
            $mess = mysqli_stmt_error($stmt);
            header("Location: registration_player.php?error=L'utente è già registrato");
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        } else {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            include('../emails/sendPrivacyEmail.php');
            header("Location: ../home/home.php");
        }
    }
    ?>