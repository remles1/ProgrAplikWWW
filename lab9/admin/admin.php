<style>
    .form-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        /* Space between form items */
        justify-content: center;
        /* Center-align the forms */
        align-items: flex-start;
        /* Align items to the top */
    }
</style>



<?php
include '../cfg.php';

session_start();
//przypisuja autoryzacje do sesji
if (!isset($_SESSION['auth'])) {
    $_SESSION['auth'] = false;
}

FormularzLogowania();
ListaPodstron();
EdytujPodstrone();
DodajNowaPodstrone();
UsunPodstrone();

function ListaPodstron()
{
    global $link;
    $query = "SELECT * FROM page_list";
    $result = mysqli_query($link, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($link));
        echo ":(";
    }
    echo '<div class="form-container">';
    while ($row = mysqli_fetch_array($result)) {
        echo $row['id'] . ' ' . $row['page_title'] . ' <br/ >';
    }
    echo '</div>';
}

function EdytujPodstrone()
{
    $form = '
        <div class="form-container">
        EDYTUJ PODSTRONĘ
        <form method="post" name="EditForm" enctype="multipart/form-data" action="admin.php">
            <label for="id">id(do znalezienia): </label>
            <input type="text" id="id" name="id"/><br><br>
            <label for="page_title">Tytuł: </label>
            <input type="text" id="page_title" name="page_title"/><br><br>
            <label for="page_content">Treść: </label>
            <input type="textbox" id="page_content" name="page_content"/><br><br>
            <label for="alias">Alias:</label>
            <input type="text" id="alias" name="alias"/><br><br>
            <label for="active">Aktywna?</label>
            <input type="checkbox" id="active" name="active" value="yes"/><br><br>
            <input type="submit" name="submit_edit" value="Submit">
            
        </form>
        </div>
        ';
    echo $form;

    if (isset($_POST['submit_edit'])) {
        if ($_SESSION['auth'] !== true) {
            echo "zaloguj sie!";
            return;
        }
        global $link;
        $id = $_POST['id'];
        $page_title = $_POST['page_title'];
        $page_content = $_POST['page_content'];
        $alias = $_POST['alias'];
        $active = $_POST['active'];
        if ($active === "yes") $active = 1;
        else $active = 0;
        $query = "UPDATE page_list SET page_title='$page_title', page_content='$page_content', alias='$alias', status='$active' WHERE id='$id' LIMIT 1";
        if (mysqli_query($link, $query)) {
            echo "git";
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
}

function DodajNowaPodstrone()
{
    $form = '
        <div class="form-container">
        DODAJ NOWĄ PODSTRONĘ
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="admin.php">
            <label for="page_title">Tytuł: </label>
            <input type="text" id="page_title" name="page_title"/><br><br>
            <label for="page_content">Treść strony: </label>
            <input type="textbox" id="page_content" name="page_content"/><br><br>
            <label for="alias">Alias: </label>
            <input type="text" id="alias" name="alias"/><br><br>
            <input type="submit" name="submit_add" value="Submit">
        </form>
        </div>
        ';
    echo $form;


    if (isset($_POST['submit_add'])) {
        if ($_SESSION['auth'] !== true) {
            echo "zaloguj sie!";
            return;
        }
        global $link;
        $page_title = $_POST['page_title'];
        $page_content = $_POST['page_content'];
        $alias = $_POST['alias'];
        $query = "INSERT INTO page_list (page_title,page_content,alias) VALUES ('$page_title','$page_content','$alias');";
        if (mysqli_query($link, $query)) {
            echo "git";
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
}

function UsunPodstrone()
{
    $form = '
        <div class="form-container">
        <p>USUŃ PODSTRONĘ<br></p>
        <form method="post" name="CreateForm" enctype="multipart/form-data" action="admin.php">
            <label for="id">id: </label>
            <input type="text" id="id" name="id"/><br><br>
            <label for="alias">Alias: </label>
            <input type="text" id="alias" name="alias"/><br><br>
            <input type="submit" name="submit_delete" value="Submit">
        </form>
        </div>
        ';
    echo $form;

    if (isset($_POST['submit_delete'])) {
        if ($_SESSION['auth'] !== true) {
            echo "zaloguj sie!";
            return;
        }
        global $link;
        $id = $_POST['id'];
        $alias = $_POST['alias'];
        $query = "DELETE FROM page_list WHERE id='$id' AND alias='$alias';";
        if (mysqli_query($link, $query)) {
            echo "git";
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
}

function FormularzLogowania()
{
    $form = '
        <div class="logowanie">
            <h1 class ="heading">Panel CMS:</h1>
            <div class="logowanie">
                <div class="form-container">
                <form method="post" name="LoginForm" enctype="multipart/form-data" action="admin.php">
                    <table class="logowanie">
                        <tr><td class ="log4_t">[email] </td> <td> <input type="text" name="login_email" class="logowanie" /> </td></tr>
                        <tr><td class ="log4_t">[haslo] </td> <td> <input type="password" name="login_pass" class="logowanie" /> </td></tr>
                        <tr><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
                    </table>
                </form>
                </div>
            </div>
        </div>
        ';

    echo $form;


    if (isset($_POST['x1_submit'])) {
        global $login, $pass;
        $post_login = $_POST['login_email'];
        $post_pass = $_POST['login_pass'];

        if ($post_login === $login and $post_pass === $pass) {
            $_SESSION['auth'] = true;
            echo "zalogowany";
        }
    }
}
?>
