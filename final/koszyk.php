<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include './cfg.php' ;


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

    
    function showCart($dblink){
        $cena_koszyka = 0;
        echo '<div class="products">';
        foreach($this->lista_prod as $produkt_id => $ilosc_prod){
            $query = "SELECT * FROM produkty WHERE id='$produkt_id' LIMIT 1;";
            $result = mysqli_query($dblink, $query);
            $row = mysqli_fetch_array($result);
            
            $cena_prod_w_groszach =  (double)$row['cena_netto']* (1 + (double) $row['podatek_vat']/100);
            $cena_koszyka += $cena_prod_w_groszach * $ilosc_prod;
            echo '<div class="product">';
            echo '<br /><h3>' . $row['tytul']. '</h3>' .  
            '<br /><p>'. $row['opis']. '</p>' .
            
            '<br /><br />'. '<img src="data:image/png;base64,'.base64_encode($row['zdjecie']).'"/>'
            ;

            echo '<br /><h3>ilość w koszyku: '. $ilosc_prod . '</h3>';
            $uri = $_SERVER['REQUEST_URI'];
            echo '<form action="' . $uri . '" method="post" style="display: inline-block; margin-right: 10px;">';
            echo '<input type="hidden" name="produkt_id" value="' . $produkt_id . '">';
            echo '<br /><span class="price">' . $cena_prod_w_groszach * $ilosc_prod/100 .'zł</span></br>';
            echo '<input type="number" id="ilosc_produktu" name="ilosc_produktu">';
            echo '<button type="submit" name="change_ilosc_produktu">Zmień ilość w koszyku</button>';
            echo '</form>';

            
            echo '</div>';
        }
        
        echo '</div>';
        echo 'Cena koszyka: ' . $cena_koszyka/100 . 'zl';
    }
}

?>