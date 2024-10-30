<?php
    $nr_indeksu = '169328';
    $nrGrupy = '2';

    echo 'Remigiusz Leś '.$nr_indeksu.' grupa '.$nrGrupy.'<br /><br />';

    echo 'Zastosowanie metody include() <br/>';

    include 'zmienne.php';
    echo 'zmienna x = '.$x.'<br><br>';

    echo 'Zastosowanie metody require_once() <br/>';

    require_once 'zmienne.php';
    echo 'zmienna y = '.$y.'<br><br>';


    echo 'Zastosowanie if, else if, else<br>';

    if($x < $y){
        echo 'y jest wieksze od x';
    }
    else if ($x == $y){
        echo 'x jest równe y';
    }
    else {
        echo 'x jest wieksze od y';
    }

    echo '<br><br>Zastosowanie switch()<br>';

    switch($x < $y){
        case true:
            echo 'y jest wieksze od x';
            break;
        case false:
            echo 'x jest wieksze od y';
            break;
    }

    echo '<br><br>Zastosowanie while()<br>';

    while($y < $x){
        echo $y;
        $y++;
    }

    echo '<br><br>Zastosowanie for()<br>';

    for($i = 0; $i < $y;$i++){
        echo $i.'<br>';
    }

    
    echo '<br>Typy zmiennych $_GET, $_POST, $_SESSION<br>';

    //http://localhost/lab4/labor_169328_2.php?test=test
    echo '<br>$_GET';
    echo '<br>test = '.htmlspecialchars($_GET['test']);

    echo '<br><br>$_POST';
    echo '<form method="POST" action="labor_169328_2.php">
  Name: <input type="text" name="fname">
  <input type="submit">
</form>';
    echo '<br>test = '.htmlspecialchars($_POST['fname']);

    echo '<br><br>$_SESSION';
    $_SESSION['z'] = 5;;
    echo '<br>z = '.$_SESSION['z'];
?>

