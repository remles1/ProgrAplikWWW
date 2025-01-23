<?php

//w cfg definiujemy $link - połączenie z bazą dancyh
include 'cfg.php';
//moduł pobierający stronę z bazy danych
include 'showpage.php';
include 'koszyk.php';
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        if (isset($_POST['change_ilosc_produktu'])) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            if (isset($_POST['produkt_id'], $_POST['ilosc_produktu'])) {
                $_SESSION['koszyk']->changeIloscProduktu(
                    $_POST['produkt_id'],
                    $_POST['ilosc_produktu']
                );
            }
            
            session_write_close();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
        
        elseif (isset($_POST['delete_product'])) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            
            if (isset($_POST['produkt_id'], $_POST['ilosc_produktu'])) {
                $_SESSION['koszyk']->changeIloscProduktu(
                    $_POST['produkt_id'],
                    0
                );
            }
            
            session_write_close();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['koszyk']) || sizeof($_SESSION['koszyk']->lista_prod) <= 0) {
            echo '<div class="empty-cart">
                <h2>Twój koszyk jest pusty</h2>
                <p>Odwiedź nasz sklep i dodaj produkty do koszyka.</p>
            </div>';
        } else {
            $_SESSION['koszyk']->showCart($link);
        }
    ?>
    </div>



    <div class="footer">Remigiusz Leś ISI 2, indeks: 169328, grupa: 2</div>
</body>

</html>