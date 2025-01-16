<?php

include "./cfg.php";

class ZarzadzajKategoriami{
    private $dblink;
    public function __construct() {
        global $link;
        $this->dblink = $link;
    }


    function DodajKategorie(){
        $form = '
        <div class="panel-section">
        <h3>DODAJ NOWĄ KATEGORIĘ</h3>
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="">
            <label for="kat_matka_add">Matka: </label>
            <input type="text" id="kat_matka_add" name="kat_matka_add"/><br><br>
            <label for="kat_nazwa_add">Nazwa: </label>
            <input type="text" id="kat_nazwa_add" name="kat_nazwa_add"/><br><br>
            <input type="submit" name="kat_submit_add" value="Submit">
        </form>
        </div>';
        echo $form;


        if (isset($_POST['kat_submit_add'])) {
            if ($_SESSION['auth'] !== true) {
                echo "zaloguj sie!";
                return;
            }
            global $link;
            $kat_matka_add = $_POST['kat_matka_add'];
            $kat_nazwa_add = $_POST['kat_nazwa_add'];
            $query = "INSERT INTO kategorie (matka,nazwa) VALUES ('$kat_matka_add','$kat_nazwa_add');";
            if (mysqli_query($link, $query)) {
                echo "git";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }

    }

    function UsunKategorie(){
        $form = '
        <div class="panel-section">
        <h3>USUŃ KATEGORIĘ</h3>
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="">
            <label for="kat_matka_delete">Matka: </label>
            <input type="text" id="kat_matka_delete" name="kat_matka_delete"/><br><br>
            <label for="kat_nazwa_delete">Nazwa: </label>
            <input type="text" id="kat_nazwa_delete" name="kat_nazwa_delete"/><br><br>
            <input type="submit" name="kat_submit_delete" value="Submit">
        </form>
        </div>';
        echo $form;


        if (isset($_POST['kat_submit_delete'])) {
            if ($_SESSION['auth'] !== true) {
                echo "zaloguj sie!";
                return;
            }
            global $link;
            $kat_matka_delete = $_POST['kat_matka_delete'];
            $kat_nazwa_delete = $_POST['kat_nazwa_delete'];
            $query = "DELETE FROM kategorie WHERE matka='$kat_matka_delete' AND nazwa='$kat_nazwa_delete' LIMIT 1;";
            if (mysqli_query($link, $query)) {
                echo "git";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
    }

    function EdytujKategorie(){
        $form = '
        <div class="panel-section">
        <h3>EDYTUJ KATEGORIĘ<h3>
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="">
            <label for="kat_id_update">id: </label>
            <input type="text" id="kat_id_update" name="kat_id_update"/><br><br>
            <label for="kat_matka_update">Matka: </label>
            <input type="text" id="kat_matka_update" name="kat_matka_update"/><br><br>
            <label for="kat_nazwa_update">Nazwa: </label>
            <input type="text" id="kat_nazwa_update" name="kat_nazwa_update"/><br><br>
            <input type="submit" name="kat_submit_update" value="Submit">
        </form>
        </div>';
        echo $form;


        if (isset($_POST['kat_submit_update'])) {
            if ($_SESSION['auth'] !== true) {
                echo "zaloguj sie!";
                return;
            }
            global $link;
            $kat_id_update = $_POST['kat_id_update'];
            $kat_matka_update = $_POST['kat_matka_update'];
            $kat_nazwa_update = $_POST['kat_nazwa_update'];
            $query = "UPDATE kategorie SET matka='$kat_matka_update', nazwa='$kat_nazwa_update' WHERE id='$kat_id_update' LIMIT 1;";
            if (mysqli_query($link, $query)) {
                echo "git";
            } else {
                echo "Error: " . mysqli_error($link);
            }
        }
    }

    private function PokazKategorieHelper($result,$level){
        while ($row = mysqli_fetch_array($result)) {
            for($i = 0; $i < $level; $i++){
                echo '&nbsp&nbsp';
            }
            echo 'id: ' . $row['id'] . ', nazwa: ' . $row['nazwa'] . ', matka: '. $row['matka'] .'<br />';
            $id = $row['id'];
            $dzieci_query = "SELECT * FROM kategorie WHERE matka=$id";
            $dzieci_result = mysqli_query($this->dblink, $dzieci_query);
            $this->PokazKategorieHelper($dzieci_result,$level+1);
        }
        
    }

    function PokazKategorie(){
        $matki_query = "SELECT * FROM kategorie WHERE matka=0";
        $matki_result = mysqli_query($this->dblink, $matki_query);
        echo '<div class="panel-section">';
        $this->PokazKategorieHelper($matki_result,0);
        echo '</div>';
    }

    
}

// $test = new ZarzadzajKategoriami();
// $test -> DodajKategorie();
?>