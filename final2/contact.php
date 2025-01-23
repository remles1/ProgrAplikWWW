<?php

PokazKontakt();
PrzypomnijHaslo();

function PokazKontakt()
{
    $form = '
    <form method="POST" action="">
            <label for="email" class="visually-hidden">Email:</label>
            <input type="email" name="email" id="email" required class="form-input">
            <label for="temat" class="visually-hidden">Temat:</label>
            <input type="text" name="temat" id="temat" required class="form-input">
            <label for="tresc" class="visually-hidden">Treść wiadomości:</label>
            <textarea name="tresc" id="tresc" required class="form-input"></textarea>
            <button type="submit" name="wyslij">Wyślij</button>
    </form>
    ';

    echo $form;

    //jezeli kliknieto przycisk wyslij to dopiero wtedy wywoluje funkcje
    if (isset($_POST['wyslij'])) {
        WyslijMailKontakt(htmlspecialchars($_POST['email']));
    }
}

function WyslijMailKontakt($odbiorca)
{


    //sprawdza czy pola maila do wysłania nie są puste
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        return;
    }

    //ustawia pola maila
    $mail['subject'] = htmlspecialchars($_POST['temat']);
    $mail['body'] = htmlspecialchars($_POST['tresc']);
    $mail['sender'] = htmlspecialchars($_POST['email']);
    $mail['reciptient'] = $odbiorca;

    //tworzy nagłówek 
    $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "Content-Transfer-Encoding: 8bit\n";
    $header .= "X-Sender: <" . $mail['sender'] . ">\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <" . $mail['sender'] . ">\n";

    //wysyla maila
    mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);

    echo '[wiadomosc_wyslana]';
}

function PrzypomnijHaslo()
{

    echo "Przypomnij hasło:";
    //formularz w którym osoba podaje maila na który ma zostać wysłane przypomnienie hasla
    $form = '
<form method="POST" action="">
        <label for="email_przypomnij" class="visually-hidden">Email:</label>
        <input type="text" name="email_przypomnij" id="email_przypomnij" required class="form-input">
        <button type="submit" name="przypomnij">Wyślij</button>
</form>
';
    echo $form;

    //ustawia zmienne w globalnym arrayu POST, tak, żeby funkcja WyslijMailKontakt poprawnie ich użyla
    if (isset($_POST['przypomnij'])) {
        $_POST['temat'] = "Przypomnienie hasla";
        $_POST['tresc'] = "haslo";
        $_POST['email'] = "admin@strona.pl";

        //to jest adres na który ma zostac wysłany mail
        $odbiorca = $_POST['email_przypomnij'];
        WyslijMailKontakt($odbiorca);
    }
}
