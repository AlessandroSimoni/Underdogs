<!DOCTYPE html>
<html lang="it">

<head>
    <title>Registrazione squadra</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registration_club.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_POST['submit'])) {
        session_start();

        if (empty($_POST['club_name']) || empty($_POST['tel']) || empty($_POST['email']) || empty($_POST['prov']) || empty($_POST['pass']) || empty($_POST['conf']) || $_POST['check_privacy'] != 'on') {
            header("Location: registration_club.php?error=Tutti i campi devono essere compilati");
            exit();
        }

        $club_name = $_POST['club_name'];
        $telefono = $_POST['tel'];
        $email = $_POST['email'];
        $prov = $_POST['prov'];
        $pass = $_POST['pass'];
        $conf = $_POST['conf'];
        $newsletter = 0;


        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $pass)){
            header("Location: registration_club.php?error=La password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola");
            exit();
        }

        if ($pass != $conf) {
            header("Location: registration_club.php?error=Le password non corrispondono");
            exit();
        }

        include('../connection.php');

        if (mysqli_connect_errno()) {
            $mess = mysqli_connect_error();
            header("Location: registration_club.php?error=$mess");
            exit();
        }

        $cryptedpwd = password_hash($pass, PASSWORD_DEFAULT);
        $club_name = htmlspecialchars($club_name, ENT_QUOTES);
        $email = htmlspecialchars($email, ENT_QUOTES);
        $_SESSION['tipo'] = "squadra";
        $_SESSION['email'] = $email;
        $_SESSION['newsletter'] = $newsletter;

        $stmt = mysqli_prepare($conn, "INSERT INTO squadra (email, club_name, telefono, prov, pass, conf, newsletter) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            $mess = mysqli_connect_error();
            header("Location: registration_club.php?error=Richiesta fallita");
            exit();
        }

        if (!mysqli_stmt_bind_param($stmt, 'sssssss', $email, $club_name, $telefono, $prov, $cryptedpwd, $cryptedpwd, $newsletter)) {
            header("Location: registration_club.php?error=Impossibile completare l'operazione richiesta");
            exit();
        }

        if (!mysqli_stmt_execute($stmt)) {
            $mess = mysqli_stmt_error($stmt);
            header("Location: registration_club.php?error=L'utente è già registrato");
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
    <a href="../index.php"><img src="../FOTO/logo_completo_a.png" alt="Logo site" class="form_logo"></a>
    <div class="hero">
        <div class="form_box">
            <h1 class="form_title">Registrazione squadra</h1>
            <h4 class="form_subtitle">Inserisci i tuoi dati nei campi sottostanti</h4>
            <form action="registration_club.php" method="POST">
                <?php if (isset($_GET['error'])) { ?>
                    <p class="form_error"><?php echo $_GET['error']; ?></p>
                <?php } ?>

                <input type="text" class="form_nome" name="club_name" autofocus placeholder="Nome della Squadra">

                <input type="int" class="form_tel" name="tel" placeholder="Telefono (No prefisso)">

                <input type="email" class="form_email" name="email" placeholder="Email">


                <select name="prov" class="form_prov">
                    <option selected value="" disabled>Provincia</option>
                    <option value="Genova">Genova</option>
                    <option value="Imperia">Imperia</option>
                    <option value="Savona">Savona</option>
                    <option value="La Spezia">La Spezia</option>
                </select>

                <input type="password" class="form_pass" name="pass" placeholder="Password">

                <input type="password" class="form_conf_pass" name="conf" placeholder="Conferma password">

                <input type="checkbox" id="check_privacy" name="check_privacy" class="check_privacy">
                <label for="privacy" class="form_privacy">Acconsento al trattamento dei dati personali *</label><br>

                <button class="form_regis" name="submit" type="submit">Registrati</button>

                <div class="form_link_group">
                    <a href="../registration_player/registration_player.php" class="form_link form_team">Sei un calciatore? Registrati qui!</a><br>

                    <a href="../login/login.php" class="form_link form_login">Hai già un account? Esegui l'accesso qui!</a>
                </div>
        </div>
    </div>
</body>

</html>