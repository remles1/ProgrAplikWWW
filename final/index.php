<?php
session_start();

//w cfg definiujemy $link - połączenie z bazą dancyh
include 'cfg.php';
//moduł pobierający stronę z bazy danych
include 'showpage.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Remigiusz Leś" />
    <title>Hodowla żółwia wodnego</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/kolorujtlo.js" type="text/javascript"></script>
    <script src="./js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/jquery.js" defer></script>
</head>

<body onload="startclock()">
    <div class="top">
        <div style="width: 33vw"></div>
        <h1 style="width: 33vw; text-align: center;">Hodowla żółwia wodnego</h1>
        <div style="text-align: right; width: 33vw;">
            <div id="zegarek"></div>
            <div id="data"></div>
        </div>
    </div>

    <ul class="menu">
        <li>
            <a href="index.php">Strona Główna</a>
        </li>
        <li>
            <a href="sklep.php">Sklep</a>
        </li>
        <li>
            <a href="koszyk_strona.php">Koszyk</a>
        </li>
        <li>
            <a href="index.php?idp=o_zolwiu">O żółwiu wodnym</a>
        </li>
        <li>
            <a href="index.php?idp=gdzie_kupic">Gdzie kupic?</a>
        </li>
        <li>
            <a href="index.php?idp=hodowla">Hodowla</a>
        </li>
        <li>
            <a href="index.php?idp=galeria">Galeria</a>
        </li>
        <li>
            <a href="index.php?idp=filmy">Filmy</a>
        </li>
        <li>
            <a href="index.php?idp=kontakt">Kontakt</a>
        </li>
    </ul>

    <div class="main">
        <?php
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        //pobiera wartość idp przekazaną w URI, na jej podstawie pobiera treść z bazy danych
        $alias = $_GET['idp'];
        if ($alias == '') $alias = 'glowna';
        $strona = PokazPodstrone($alias);

        echo $strona;
        ?>

    </div>



    <div class="footer">Remigiusz Leś ISI 2, indeks: 169328, grupa: 2</div>

</body>

</html>