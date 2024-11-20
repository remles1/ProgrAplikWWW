<?php
    $login = 'admin';
    $pass = 'adminpass';

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza ='moja_strona_169328';

    $link = mysqli_connect($dbhost,$dbuser,$dbpass);
    mysqli_set_charset($link,'utf8mb4');
    if(!$link) echo '<b>przerwano polaczenie</b>';
    if(!mysqli_select_db($link,$baza)) echo 'nie wybrano bazy';
    
?>