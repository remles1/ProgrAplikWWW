<?php
include 'cfg.php';

function PokazPodstrone($alias){
    global $link;
    $alias_clear = htmlspecialchars($alias);
    
    $query = "SELECT * FROM page_list WHERE alias='$alias_clear' LIMIT 1";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_array($result);

    if(empty($row['alias'])){
        $web = '[nie_znaleziono_strony]';
    }
    else{
        $web = $row['page_content'];
    }
    return $web;
}

?>