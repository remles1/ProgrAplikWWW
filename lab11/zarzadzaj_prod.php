<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../cfg.php";

class ZarzadzajProduktami{
    private $dblink;
    public function __construct() {
        global $link;
        $this->dblink = $link;
    }

    function PokazProdukty(){
        $query = "SELECT * FROM produkty";
        $result = mysqli_query($this->dblink, $query);
        while ($row = mysqli_fetch_array($result)) {
            echo '<br />id: ' . $row['id'].
            '<br />tytul: ' . $row['tytul']. 
            '<br />opis: '. $row['opis'].
            '<br />data_utworzenia: '. $row['data_utworzenia'].
            '<br />data_modyfikacji: '. $row['data_modyfikacji'].
            '<br />data_wygasniecia: '. $row['data_wygasniecia'].
            '<br />cena_netto: '. $row['cena_netto'].
            '<br />podatek_vat: '. $row['podatek_vat'].
            '<br />ilosc_dost_sztuk: '. $row['ilosc_dost_sztuk'].
            '<br />status_dost: '. $row['status_dost'].
            '<br />kategoria: '. $row['kategoria'].
            '<br />gabaryt_prod: '. $row['gabaryt_prod'].
            '<br />zdjecie: <br />'. '<img src="data:image/png;base64,'.base64_encode($row['zdjecie']).'"/>'
            ;
        }
        
    }

    function DodajProdukt(){
        $form = '
        <div class="form-container">
        DODAJ NOWY PRODUKT
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="">
            <label for="prod_tytul_add">Tytuł: </label>
            <input type="text" id="prod_tytul_add" name="prod_tytul_add"/><br><br>
            <label for="prod_opis_add">Opis: </label>
            <input type="textbox" id="prod_opis_add" name="prod_opis_add"/><br><br>
            <label for="prod_data_utw_add">Data utworzenia: </label>
            <input type="date" id="prod_data_utw_add" name="prod_data_utw_add"/><br><br>
            <label for="prod_data_mod_add">Data modyfikacji: </label>
            <input type="date" id="prod_data_mod_add" name="prod_data_mod_add"/><br><br>
            <label for="prod_data_wyg_add">Data wygaśnięcia: </label>
            <input type="date" id="prod_data_wyg_add" name="prod_data_wyg_add"/><br><br>
            <label for="prod_cena_add">Cena netto: </label>
            <input type="text" id="prod_cena_add" name="prod_cena_add"/><br><br>
            <label for="prod_podatek_add">Podatek VAT%: </label>
            <input type="text" id="prod_podatek_add" name="prod_podatek_add"/><br><br>
            <label for="prod_ilosc_add">Ilość dostępnych sztuk: </label>
            <input type="text" id="prod_ilosc_add" name="prod_ilosc_add"/><br><br>
            <label for="prod_status_dost_add">Status dostępności: </label>
            <input type="text" id="prod_status_dost_add" name="prod_status_dost_add"/><br><br>
            <label for="prod_kat_add">Kategoria: </label>
            <input type="text" id="prod_kat_add" name="prod_kat_add"/><br><br>
            <label for="prod_gabaryt_add">Gabaryt: </label>
            <input type="text" id="prod_gabaryt_add" name="prod_gabaryt_add"/><br><br>
            <label for="prod_zdj_add">Zdjęcie upload: </label>
            <input type="file" id="prod_zdj_add" name="prod_zdj_add"/><br><br>

            <input type="submit" name="prod_submit_add" value="Submit">
        </form>
        </div>';
        echo $form;


        if (isset($_POST['prod_submit_add'])) {
            if ($_SESSION['auth'] !== true) {
                echo "zaloguj sie!";
                return;
            }
            global $link;
            $prod_tytul_add = $_POST["prod_tytul_add"];
            $prod_opis_add = $_POST["prod_opis_add"];
            $prod_data_utw_add = $_POST["prod_data_utw_add"];
            $prod_data_mod_add = $_POST["prod_data_mod_add"];
            $prod_data_wyg_add = $_POST["prod_data_wyg_add"];
            $prod_cena_add = $_POST["prod_cena_add"];
            $prod_podatek_add = $_POST["prod_podatek_add"];
            $prod_ilosc_add = $_POST["prod_ilosc_add"];
            $prod_status_dost_add = $_POST["prod_status_dost_add"];
            $prod_kat_add = $_POST["prod_kat_add"];
            $prod_gabaryt_add = $_POST["prod_gabaryt_add"];
            $prod_zdj_add = $_FILES["prod_zdj_add"];
            $prod_zdj_add = file_get_contents($prod_zdj_add["tmp_name"]);
            $prod_zdj_add = base64_encode($prod_zdj_add);

            $query = "INSERT INTO produkty (tytul,opis,data_utworzenia,data_modyfikacji,data_wygasniecia,cena_netto,podatek_vat,ilosc_dost_sztuk,status_dost,kategoria,gabaryt_prod,zdjecie) VALUES ('$prod_tytul_add', '$prod_opis_add', '$prod_data_utw_add', '$prod_data_mod_add', '$prod_data_wyg_add', '$prod_cena_add', '$prod_podatek_add', '$prod_ilosc_add', '$prod_status_dost_add', '$prod_kat_add', '$prod_gabaryt_add', '$prod_zdj_add');";
            if (mysqli_query($link, $query)) {
                echo "git";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
    }

    function EdytujProdukt(){
        $form = '
        <div class="form-container">
        EDYTUJ PRODUKT
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="">
            <label for="prod_id_edit">id (wybiera produkt który edytować): </label>
            <input type="text" id="prod_id_edit" name="prod_id_edit"/><br><br>
            <label for="prod_tytul_edit">Tytuł: </label>
            <input type="text" id="prod_tytul_edit" name="prod_tytul_edit"/><br><br>
            <label for="prod_opis_edit">Opis: </label>
            <input type="textbox" id="prod_opis_edit" name="prod_opis_edit"/><br><br>
            <label for="prod_data_utw_edit">Data utworzenia: </label>
            <input type="date" id="prod_data_utw_edit" name="prod_data_utw_edit"/><br><br>
            <label for="prod_data_mod_edit">Data modyfikacji: </label>
            <input type="date" id="prod_data_mod_edit" name="prod_data_mod_edit"/><br><br>
            <label for="prod_data_wyg_edit">Data wygaśnięcia: </label>
            <input type="date" id="prod_data_wyg_edit" name="prod_data_wyg_edit"/><br><br>
            <label for="prod_cena_edit">Cena netto: </label>
            <input type="text" id="prod_cena_edit" name="prod_cena_edit"/><br><br>
            <label for="prod_podatek_edit">Podatek VAT%: </label>
            <input type="text" id="prod_podatek_edit" name="prod_podatek_edit"/><br><br>
            <label for="prod_ilosc_edit">Ilość dostępnych sztuk: </label>
            <input type="text" id="prod_ilosc_edit" name="prod_ilosc_edit"/><br><br>
            <label for="prod_status_dost_edit">Status dostępności: </label>
            <input type="text" id="prod_status_dost_edit" name="prod_status_dost_edit"/><br><br>
            <label for="prod_kat_edit">Kategoria: </label>
            <input type="text" id="prod_kat_edit" name="prod_kat_edit"/><br><br>
            <label for="prod_gabaryt_edit">Gabaryt: </label>
            <input type="text" id="prod_gabaryt_edit" name="prod_gabaryt_edit"/><br><br>
            <label for="prod_zdj_edit">Zdjęcie upload: </label>
            <input type="file" id="prod_zdj_edit" name="prod_zdj_edit"/><br><br>

            <input type="submit" name="prod_submit_edit" value="Submit">
        </form>
        </div>';
        echo $form;

        if (isset($_POST['prod_submit_edit'])) {
            if ($_SESSION['auth'] !== true) {
                echo "zaloguj sie!";
                return;
            }
            global $link;
            $prod_id_edit = $_POST["prod_id_edit"];
            $prod_tytul_edit = $_POST["prod_tytul_edit"];
            $prod_opis_edit = $_POST["prod_opis_edit"];
            $prod_data_utw_edit = $_POST["prod_data_utw_edit"];
            $prod_data_mod_edit = $_POST["prod_data_mod_edit"];
            $prod_data_wyg_edit = $_POST["prod_data_wyg_edit"];
            $prod_cena_edit = $_POST["prod_cena_edit"];
            $prod_podatek_edit = $_POST["prod_podatek_edit"];
            $prod_ilosc_edit = $_POST["prod_ilosc_edit"];
            $prod_status_dost_edit = $_POST["prod_status_dost_edit"];
            $prod_kat_edit = $_POST["prod_kat_edit"];
            $prod_gabaryt_edit = $_POST["prod_gabaryt_edit"];
            $prod_zdj_edit = $_FILES["prod_zdj_edit"];
            $prod_zdj_edit = file_get_contents($prod_zdj_edit["tmp_name"]);
            $prod_zdj_edit = base64_encode($prod_zdj_edit);
            
            $query = "UPDATE produkty SET tytul='$prod_tytul_edit', opis='$prod_opis_edit', data_utworzenia='$prod_data_utw_edit', data_modyfikacji='$prod_data_mod_edit', data_wygasniecia='$prod_data_wyg_edit', cena_netto='$prod_cena_edit', podatek_vat='$prod_podatek_edit', ilosc_dost_sztuk='$prod_ilosc_edit', status_dost='$prod_status_dost_edit', kategoria='$prod_kat_edit', gabaryt_prod='$prod_gabaryt_edit', zdjecie='$prod_zdj_edit' WHERE id='$prod_id_edit';";
            
            if (mysqli_query($link, $query)) {
                echo "Product updated successfully.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
        
    }

    function UsunProdukt(){
        $form = '
        <div class="form-container">
        EDYTUJ PRODUKT
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="">
            <label for="prod_id_delete">id: </label>
            <input type="text" id="prod_id_delete" name="prod_id_delete"/><br><br>

            <input type="submit" name="prod_submit_delete" value="Submit">
        </form>
        </div>';
        echo $form;

        if (isset($_POST['prod_submit_delete'])) {
            if ($_SESSION['auth'] !== true) {
                echo "zaloguj sie!";
                return;
            }
            global $link;
            
            $prod_id_delete = $_POST["prod_id_delete"];

            $query = "UPDATE FROM produkty WHERE id='$prod_id_delete'";
            
            if (mysqli_query($link, $query)) {
                echo "Product updated successfully.";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
    }

}

?>