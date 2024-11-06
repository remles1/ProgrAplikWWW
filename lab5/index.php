
<!DOCTYPE html>
<html lang="en">
<head>
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
        /* po tym komentarzu będzie kod do dynamicznego ładowania stron */
        if($_GET['idp']=="") $strona='./html/glowna.html';
        if($_GET['idp']=="o_zolwiu") $strona='./html/o_zolwiu.html';
        if($_GET['idp']=="gdzie_kupic") $strona='./html/gdzie_kupic.html';
        if($_GET['idp']=="hodowla") $strona='./html/hodowla.html';
        if($_GET['idp']=="galeria") $strona='./html/galeria.html';
        if($_GET['idp']=="kontakt") $strona='./html/kontakt.html';
        if($_GET['idp']=="filmy") $strona='./html/filmy.html';
        if(file_exists($strona)) include $strona;
    ?>

    </div>

    

    <div class="footer">Remigiusz Leś ISI 2</div>

    <?php
        $nr_indeksu = '169328';
        $nrGrupy = '2';
        echo 'Autor: Remigiusz Leś '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
    ?>  
</body>
</html>

