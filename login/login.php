<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Sign in</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../FOTO/logo_a.png">
        <link rel="stylesheet" href="login.css">
        <link rel="stylesheet" href="../scrollbar.css">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    </head>

    <body>
        <a href="../index.php"><img src="../FOTO/logo_completo_a.png" alt="Logo site" class="form_logo"></a>

        <form class="form" id="login" action="login.php" method="POST">
            <div class="container">
                <h1 class="form_title">Sign-in</h1>

                <?php if(isset($_GET['error'])){ ?>
                        <p class="form_error"><?php echo $_GET['error']; ?></p>
                <?php } ?>
                
                <input type="email" id="email " name="email" class="form_email" autofocus placeholder="Email">

                <input type="password" id="pass" name="pass" class="form_pass" placeholder="Password" style="margin-top: 5%">

                <label class="form_select">Scegli il tuo tipo utente:</label>
                <select class="form_type" id="type" name="type">
                    <option selected value="">Tipo di account</option>
                    <option value="calciatore">Calciatore</option>
                    <option value="squadra">Squadra</option>
                </select>

                <button class="form_button" id="submit" name="submit" type="submit">Accedi</button>

                <div class="form_link_group">
                    <br><a href="pass_dimenticata.php" class="form_link form_forgot">Password dimenticata?</a><br>

                    <a href="../registration_player/registration_player.php" class="form_link form_create">Sei un calciatore ma non hai un account? Crealo!</a><br>
                    <a href="../registration_club/registration_club.php" class="form_link form_create">Sei una squadra ma non hai un account? Crealo!</a>
                </div>
            </div>

        </form>
    </body>
</html>

<?php
    include('../alert.php');

    session_start();

    if (isset($_POST['submit'])) {
        if(empty($_POST['email']) || empty($_POST['pass'])){
            header("Location: login.php?error=Tutti i campi devono essere compilati");
            exit();
        }

        $email = trim($_POST['email']);
        $pass = trim($_POST['pass']);
        $type = isset($_POST['type']) ? $_POST['type'] : 'calciatore';

        include('../connection.php');

        if (mysqli_connect_errno()) {
            $mess = mysqli_connect_error();
            header("Location: login.php?error=$mess");
            exit();
        }

        $email = mysqli_real_escape_string($conn, $email);
        $pass = mysqli_real_escape_string($conn, $pass);

        if($type == 'calciatore'){
            include('execute_calc.php');
        }
        else{
            include('execute_squa.php');
        }
        
        mysqli_close($conn);
    }
?>