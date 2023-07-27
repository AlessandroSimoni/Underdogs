<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="shortcut icon" href="../FOTO/logo_a.png">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../scrollbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>

    <div class="logo">
        <img src="FOTO/logo_rimpicciolito_a.png" alt="Logo del sito">
    </div>

    <div class="column_container">
        <div class="column">
            <div id="myCarousel" class="carousel slide" data-ride="carousel" style="height: 400px">
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active" style="background-color: #254BE1">
                    </li>
                    <li data-target="#myCarousel" data-slide-to="1" style="background-color: #254BE1"></li>
                    <li data-target="#myCarousel" data-slide-to="2" style="background-color: #254BE1"></li>
                </ol>

                <div class="carousel-inner">
                    <div class="item active">
                        <div class="header">
                            IDEA
                        </div>

                        <p style="text-align: center; margin-top: 5%; width: 50%; margin-left: 25%">
                            L'obiettivo di questo sito è aiutare i giocatori svincolati a trovare una squadra, o
                            permettere alle squadre di cercare nuovi membri.
                            <br>
                            Tutto questo è possibile grazie alla pubblicazione di annunci.
                            <br>
                            Che tu sia una squadra o un calciatore, ti consigliamo di aggiornare frequentemente il tuo
                            profilo, in modo che gli utenti possano vedere le tue informazioni precise.
                        </p>
                    </div>

                    <div class="item">
                        <div class="header">
                            CHI SIAMO
                        </div>

                        <div class="character1">
                            <img class="character-img1" src="FOTO/ale_palla.png" width="230em" height="240em">
                        </div>


                        <div class="info1">
                            <p class="inf-txt1">
                                Alessandro
                                <br>
                                Simoni
                                <br>
                                2000
                            </p>
                        </div>

                        <p class="all_info">Siamo due
                            studenti universitari
                            <br>
                            al terzo anno di informatica.
                            <br>
                            Posizionati o premi sulle nostre icone per saperne di più!
                        </p>

                        <div class="character2">
                            <img class="character-img2" src="FOTO/fede_palla.png" width="230em" height="240em">
                        </div>

                        <div class="info2">
                            <p class="inf-txt2">
                                Federica
                                <br>
                                Tamerisco
                                <br>
                                2001
                            </p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="header">
                            SI PARTE
                        </div>

                        <div class="button_container">
                            <a href="login/login.php" class="button">
                                LOG IN
                            </a>

                            <a href="visitatore.php" class="button">
                                VISITA
                            </a>
                        </div>
                    </div>
                </div>

                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" style="top: 41%"></span>
                    <span class="sr-only">Previous</span>
                </a>

                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" style="top: 41%"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</body>

</html>