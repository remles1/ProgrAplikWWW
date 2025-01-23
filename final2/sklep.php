<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'cfg.php';
include 'showpage.php';
include 'koszyk.php';
session_start();

if (!isset($_SESSION['koszyk'])) {
    $_SESSION['koszyk'] = new Koszyk();
}

function PokazKategorie() {
    global $link;

    echo '<div class="categories">
            <h3>Kategorie</h3>
            <ul>
            <li><a href="sklep.php">Wszystkie kategorie</a></li>';

    $matki_query = "SELECT * FROM kategorie WHERE matka=0";
    $matki_result = mysqli_query($link, $matki_query);

    PokazKategorieHelper($matki_result, 0);

    echo '</ul>
        </div>';
}

function PokazKategorieHelper($result, $level) {
    global $link;
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li>' . str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . '<a href="sklep.php?kategoria=' . $row['id'] . '">' . $row['nazwa'] . '</a></li>';
        $id = $row['id'];
        $dzieci_query = "SELECT * FROM kategorie WHERE matka=$id";
        $dzieci_result = mysqli_query($link, $dzieci_query);
        if (mysqli_num_rows($dzieci_result) > 0) {
            echo '<ul>';
            PokazKategorieHelper($dzieci_result, $level + 1);
            echo '</ul>';
        }
    }
}

function getSubcategoriesIds($categoryId) {
    global $link;
    $ids = array();

    $checkQuery = "SELECT id FROM kategorie WHERE id = $categoryId";
    $checkResult = mysqli_query($link, $checkQuery);
    if (mysqli_num_rows($checkResult) == 0) {
        return $ids;
    }

    $ids[] = $categoryId;

    $query = "SELECT id FROM kategorie WHERE matka = $categoryId";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $childIds = getSubcategoriesIds($row['id']);
        $ids = array_merge($ids, $childIds);
    }

    return $ids;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&display=swap" rel="stylesheet">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Remigiusz Leś" />
    <title>Hodowla żółwia wodnego</title>
    <link rel="stylesheet" href="./css/style.css">
    <script src="./js/kolorujtlo.js" type="text/javascript"></script>
    <script src="./js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./js/jquery.js" defer></script>
    <style>
        .categories {
            float: left;
            width: 20%;
            background-color: #f4f4f4;
            padding: 15px;
            margin-right: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .categories ul {
            list-style-type: none;
            padding: 0;
        }

        .categories ul li {
            margin: 10px 0;
        }

        .categories ul li a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .categories ul li a:hover {
            color: #007BFF;
        }

        .products {
            float: left;
            width: 75%;
        }

        .main {
            display: flex;
            gap: 20px;
        }

        .main::after {
            content: "";
            display: table;
            clear: both;
        }

    </style>
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
        <?php PokazKategorie(); ?>

        <div class="products">
            <?php
                function PokazProdukty($kategoria = null) {
                    global $link;                
                    echo '<div class="product-grid">';
                    
                    $query = "SELECT * FROM produkty WHERE status_dost=1";
                    if ($kategoria !== null) {
                        $subcategoriesIds = getSubcategoriesIds(intval($kategoria));
                        if (!empty($subcategoriesIds)) {
                            $query .= " AND kategoria IN (" . implode(',', $subcategoriesIds) . ")";
                        }
                    }
                    $result = mysqli_query($link, $query);
                    
                    if (mysqli_num_rows($result) === 0) {
                        echo "<p>Brak produktów w wybranej kategorii.</p>";
                    } else {
                        while ($row = mysqli_fetch_array($result)) {
                            $cena_brutto = (double)$row['cena_netto']/100 * (1 + (double)$row['podatek_vat']/100);
                            
                            echo "<div class='product-card'>";
                            echo '<img class="product-image" src="data:image/png;base64,'.base64_encode($row['zdjecie']).'"/>';
                            echo '<h3 class="product-title">' . htmlspecialchars($row['tytul']) . '</h3>';
                            echo '<p class="product-description">' . htmlspecialchars($row['opis']) . '</p>';
                            echo '<div class="product-price">' . number_format($cena_brutto, 2, ',', ' ') . ' zł</div>';
                            
                            echo '<form class="add-to-cart-form" method="post">';
                            echo '<input type="hidden" name="id_produktu" value="' . $row['id'] . '">';
                            

                            echo '<button type="submit" class="add-to-cart-btn" name="submit_btn">Do koszyka</button>';
                            echo '</form>';
                            
                            echo "</div>";
                        }
                    }
                    
                    echo '</div>';
                }
                $kategoria = isset($_GET['kategoria']) ? intval($_GET['kategoria']) : null;
                PokazProdukty($kategoria);

                if (isset($_POST['submit_btn'])) {
                    $_SESSION['koszyk']->changeIloscProduktu($_POST['id_produktu'],1);
                }
            ?>
        </div>

    </div>

    <div class="footer">Remigiusz Leś ISI 2, indeks: 169328, grupa: 2</div>
</body>

</html>