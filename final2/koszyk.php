<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './cfg.php';

class Koszyk{
    private $dblink;
    public $lista_prod;

    public function __construct() {
        global $link;
        $this->dblink = $link;
        $this->lista_prod = [];
    }

    public function changeIloscProduktu($id_prod, $ile_sztuk){
        $this->lista_prod[$id_prod] = $ile_sztuk;
        
        if($this->lista_prod[$id_prod] <= 0){
            unset($this->lista_prod[$id_prod]);
        }
    }

    function showCart($dblink) {
        $cena_koszyka = 0;
        echo '<div class="container mt-4">';
        echo '<h2 class="mb-4">Twój koszyk</h2>';
    
        if (empty($this->lista_prod)) {
            echo '<div class="alert alert-info" role="alert">Koszyk jest pusty.</div>';
        } else {
            echo '<div class="row">';
            foreach($this->lista_prod as $produkt_id => $ilosc_prod) {
                $query = "SELECT * FROM produkty WHERE id='$produkt_id' LIMIT 1;";
                $result = mysqli_query($dblink, $query);
                $row = mysqli_fetch_array($result);
                
                $cena_prod_w_groszach = (double)$row['cena_netto'] * (1 + (double)$row['podatek_vat']/100);
                $cena_koszyka += $cena_prod_w_groszach * $ilosc_prod;
    
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="card h-100">';
                echo '<img src="data:image/png;base64,'.base64_encode($row['zdjecie']).'" class="card-img-top" alt="'.$row['tytul'].'" style="max-height: 200px; object-fit: cover;">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['tytul'] . '</h5>';
                echo '<p class="card-text">' . $row['opis'] . '</p>';
                echo '<div style="display: flex; flex:1; flex-direction: column; justify-content:flex-end">';
                echo '<p class="card-text"><strong>Cena: ' . number_format($cena_prod_w_groszach * $ilosc_prod/100, 2) . ' zł</strong></p>';
                echo '</div>';
                echo '<form action="" method="post" class="d-flex align-items-center">';
                echo '<input type="hidden" name="produkt_id" value="' . $produkt_id . '">';
                
                $selectId = "quantity-select-" . $produkt_id;
                $inputId = "quantity-input-" . $produkt_id;
                echo '<div style="display: flex; flex: 1; justify-content:space-between">';
                echo '<div class="quantity-container">';
                echo '<select class="quantity-input" name="ilosc_produktu" required id="'.$selectId.'">';
                for ($i = 1; $i <= 9; $i++) {
                    $selected = ($i == $ilosc_prod) ? ' selected' : '';
                    echo "<option value=\"$i\"$selected>$i</option>";
                }
                $customSelected = ($ilosc_prod >= 10) ? ' selected' : '';
                echo '<option value="custom"'.$customSelected.'>+10</option>';
                echo '</select>';
    
                echo '<input type="number" 
                            class="quantity-input" 
                            name="ilosc_produktu" 
                            value="'.($ilosc_prod >= 10 ? $ilosc_prod : '').'"
                            min="1"
                            style="'.($ilosc_prod >= 10 ? 'display:inline-block;' : 'display:none;').'"
                            '.($ilosc_prod >= 10 ? '' : 'disabled').'
                            required 
                            id="'.$inputId.'">';
                echo '</div>';
    
                echo '<script>
                (function() {
                    const select = document.getElementById("'.$selectId.'");
                    const input = document.getElementById("'.$inputId.'");
                    
                    if(select.value === "custom") {
                        select.style.display = "none";
                        input.style.display = "inline-block";
                        input.disabled = false;
                        select.disabled = true;
                    }
    
                    select.addEventListener("change", function() {
                        if (this.value === "custom") {
                            this.style.display = "none";
                            this.disabled = true;
                            input.style.display = "inline-block";
                            input.disabled = false;
                            input.focus();
                            this.removeAttribute("required");
                            input.setAttribute("required", "");
                        }
                    });
    
                    input.addEventListener("blur", function() {
                        if (this.value < 0) {
                            alert("Liczba produktów musi być większa niż 0");
                            this.value = "'.($ilosc_prod >= 10 ? $ilosc_prod : '').'";
                        }
                    });
                })();
                </script>';
                
                echo '<button type="submit" name="change_ilosc_produktu" class="btn btn-primary btn-sm me-2">Aktualizuj</button>';
                echo '<button type="submit" name="delete_product" class="btn btn-danger btn-sm">Usuń</button>';
                echo '</div>';
                echo '</form>';
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
    
            echo '<div class="mt-4 p-3 bg-light rounded">';
            echo '<h4>Podsumowanie koszyka</h4>';
            echo '<p><strong>Łączna cena: ' . number_format($cena_koszyka/100, 2) . ' zł</strong></p>';
            echo '<button class="btn btn-success btn-lg">Złóż zamówienie</button>';
            echo '</div>';
        }
        echo '<script>
        (function() {
            const select = document.getElementById("' . $selectId . '");
            const input = document.getElementById("' . $inputId . '");
            const form = select.closest("form");
            const deleteButton = form.querySelector("[name=\'delete_product\']");
            
            if (select.value === "custom") {
                select.style.display = "none";
                input.style.display = "inline-block";
                input.disabled = false;
                select.disabled = true;
            }

            select.addEventListener("change", function() {
                if (this.value === "custom") {
                    this.style.display = "none";
                    this.disabled = true;
                    input.style.display = "inline-block";
                    input.disabled = false;
                    input.focus();
                    this.removeAttribute("required");
                    input.setAttribute("required", "");
                }
            });

            deleteButton.addEventListener("click", function(event) {
                select.value = "1";
                select.style.display = "inline-block";
                select.disabled = false;
                select.setAttribute("required", "");
                input.style.display = "none";
                input.disabled = true;
                input.value = "";
            });
        })();
        </script>';

        echo '</div>';
    }
}
?>