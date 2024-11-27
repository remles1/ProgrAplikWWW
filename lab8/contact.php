<?php

PokazKontakt();
PrzypomnijHaslo();

function PokazKontakt() {
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


    if (isset($_POST['wyslij'])) {
        WyslijMailKontakt($_POST['email']);
    }
    
}

function WyslijMailKontakt($odbiorca) {
    
    

    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[nie_wypelniles_pola]';
        return;
    }

    $mail['subject'] = $_POST['temat'];
    $mail['body'] = $_POST['tresc'];
    $mail['sender'] = $_POST['email'];
    $mail['reciptient'] = $odbiorca;

    $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "Content-Transfer-Encoding: 8bit\n";
    $header .= "X-Sender: <" . $mail['sender'] . ">\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <" . $mail['sender'] . ">\n";

    mail($mail['reciptient'], $mail['subject'], $mail['body'], $header);

    echo '[wiadomosc_wyslana]';
    
}

function PrzypomnijHaslo() {
    echo "Przypomnij hasło:";
    $form = '
<form method="POST" action="">
        <label for="email_przypomnij" class="visually-hidden">Email:</label>
        <input type="text" name="email_przypomnij" id="email_przypomnij" required class="form-input">
        <button type="submit" name="przypomnij">Wyślij</button>
</form>
';
    echo $form;

    if(isset($_POST['przypomnij'])){
        $_POST['temat'] = "Przypomnienie hasla";
        $_POST['tresc'] = "haslo";
        $_POST['email'] = "admin@strona.pl";
        $odbiorca = $_POST['email_przypomnij'];
        WyslijMailKontakt($odbiorca);
    }
}

?>
