<?php
//ustawia potrzebne zmienne
$login = 'admin';
$pass = 'adminpass';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = 'moja_strona_169328';

//tworzy polaczenie z baza danych
$link = mysqli_connect($dbhost, $dbuser, $dbpass);
//ustawia kodowanie znakow na utf8mb4
mysqli_set_charset($link, 'utf8mb4');
//sprawdza czy poprawnie polaczono z baza danych
if (!$link) echo '<b>przerwano polaczenie</b>';
//wybiera baze danych
if (!mysqli_select_db($link, $baza)) echo 'nie wybrano bazy';
