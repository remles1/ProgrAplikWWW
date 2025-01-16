<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


//w cfg definiujemy $link - połączenie z bazą dancyh
include 'cfg.php';
//moduł pobierający stronę z bazy danych
include 'showpage.php';

include 'koszyk.php';
session_start();


if (!isset($_SESSION['koszyk'])){
    $_SESSION['koszyk'] = new Koszyk();
}


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
        <div class="products">
            <?php
                function PokazProdukty(){
                    global $link;
                    $query = "SELECT * FROM produkty WHERE status_dost=1;";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<div class='product'>";
                        echo '<br /><h3>' . $row['tytul'] . '</h3></br>'.
                        '<br /><p>'. $row['opis']. '</p></br>'.
                        '<br /><span class="price">'. (double)$row['cena_netto']/100 * (1 + (double) $row['podatek_vat']/100). 'zł</span></br>'.
                        '<br /><br />'. '<img style="max-width: 200px; height: auto;" src="data:image/png;base64,'.base64_encode($row['zdjecie']).'"/>'
                        ;
                        echo '<form method="post">
                         <input type="hidden" id="id_produktu" name="id_produktu" value="' . $row['id'] . ' ">
                         <input type="number" id="ilosc_produktu" name="ilosc_produktu">
                         <button type="submit" name="submit_btn">Dodaj do koszyka</button>
                          </form>';
                        echo "</div>";
                    }
                }
                PokazProdukty();
                if (isset($_POST['submit_btn'])) {
                    $_SESSION['koszyk']->changeIloscProduktu($_POST['id_produktu'],$_POST['ilosc_produktu']);
                }
            ?>
        </div>

    </div>



    <div class="footer">Remigiusz Leś ISI 2, indeks: 169328, grupa: 2</div>
</body>

</html>