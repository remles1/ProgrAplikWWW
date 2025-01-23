<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../cfg.php';

class Admin {
    private $link;

    public function __construct($link) {
        $this->link = $link;
    }

    public function FormularzLogowania() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = $_POST['login_email'];
            $pass = $_POST['login_pass'];

            if ($login == $GLOBALS['login'] && $pass == $GLOBALS['pass']) {
                $_SESSION['auth'] = true;
                header('Location: admin.php');
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Błędny login lub hasło!</div>';
            }
        }

        echo '
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="h3 mb-0">Panel CMS:</h1>
                        </div>
                        <div class="card-body">
                            <form method="post" name="LoginForm" enctype="multipart/form-data" action="admin.php">
                                <div class="form-group">
                                    <label for="login_email">Email</label>
                                    <input type="text" name="login_email" class="form-control" id="login_email" required>
                                </div>
                                <div class="form-group">
                                    <label for="login_pass">Hasło</label>
                                    <input type="password" name="login_pass" class="form-control" id="login_pass" required>
                                </div>
                                <button type="submit" name="x1_submit" class="btn btn-primary">Zaloguj</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

    public function ListaPodstron() {
        if (!isset($_SESSION['auth'])) {
            return;
        }
    
        echo '<div class="container mt-5">
                <a href="admin.php?action=add" class="btn btn-success mb-3">Dodaj Nową Podstronę</a>
                <br><br>
                <h3>Lista Podstron</h3>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Alias</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        $query = "SELECT * FROM page_list ORDER BY id ASC";
        $result = mysqli_query($this->link, $query);
    
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['page_title'] . '</td>
                    <td>' . $row['alias'] . '</td>
                    <td>' . ($row['status'] ? 'Aktywna' : 'Nieaktywna') . '</td>
                    <td>
                        <a href="admin.php?action=edit&id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edytuj</a>
                        <a href="admin.php?action=delete&id=' . $row['id'] . '" class="btn btn-danger btn-sm">Usuń</a>
                    </td>
                  </tr>';
        }
    
        echo '</tbody></table></div>';
    }

    public function EdytujPodstrone($id) {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $page_title = mysqli_real_escape_string($this->link, $_POST['page_title']);
            $page_content = mysqli_real_escape_string($this->link, $_POST['page_content']);
            $alias = mysqli_real_escape_string($this->link, $_POST['alias']);
            $active = isset($_POST['active']) ? 1 : 0;
    
            $query = "UPDATE page_list SET page_title='$page_title', page_content='$page_content', alias='$alias', status='$active' WHERE id=$id LIMIT 1";
    
            if (mysqli_query($this->link, $query)) {
                echo '<div class="alert alert-success" role="alert">Podstrona została zaktualizowana!</div>';
                header('Location: admin.php');
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Błąd podczas aktualizacji podstrony: ' . mysqli_error($this->link) . '</div>';
            }
        }
    
        $query = "SELECT * FROM page_list WHERE id=$id LIMIT 1";
        $result = mysqli_query($this->link, $query);
    
        if (!$result) {
            echo '<div class="alert alert-danger" role="alert">Błąd podczas pobierania danych podstrony: ' . mysqli_error($this->link) . '</div>';
            return;
        }
    
        $row = mysqli_fetch_assoc($result);
    
        if (!$row) {
            echo '<div class="alert alert-danger" role="alert">Podstrona o podanym ID nie istnieje!</div>';
            return;
        }
    
        echo '
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>EDYTUJ PODSTRONĘ</h3>
                </div>
                <div class="card-body">
                    <form method="post" name="EditForm" enctype="multipart/form-data" action="admin.php?action=edit&id=' . $id . '">
                        <div class="form-group">
                            <label for="page_title">Tytuł:</label>
                            <input type="text" id="page_title" name="page_title" class="form-control" value="' . $row['page_title'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="page_content">Treść:</label>
                            <textarea id="page_content" name="page_content" class="form-control" required>' . $row['page_content'] . '</textarea>
                        </div>
                        <div class="form-group">
                            <label for="alias">Alias:</label>
                            <input type="text" id="alias" name="alias" class="form-control" value="' . $row['alias'] . '" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" id="active" name="active" class="form-check-input" value="yes" ' . ($row['status'] ? 'checked' : '') . '>
                            <label class="form-check-label" for="active">Aktywna?</label>
                        </div>
                        <button type="submit" name="submit_edit" class="btn btn-primary">Zapisz</button>
                    </form>
                </div>
            </div>
        </div>';
    }

    public function DodajNowaPodstrone() {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $page_title = mysqli_real_escape_string($this->link, $_POST['page_title']);
            $page_content = mysqli_real_escape_string($this->link, $_POST['page_content']);
            $alias = mysqli_real_escape_string($this->link, $_POST['alias']);
            $status = isset($_POST['status']) ? 1 : 0;
    
            $query = "INSERT INTO page_list (page_title, page_content, alias, status) 
                      VALUES ('$page_title', '$page_content', '$alias', '$status')";
    
            if (mysqli_query($this->link, $query)) {
                header('Location: admin.php');
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Błąd podczas dodawania podstrony: ' . mysqli_error($this->link) . '</div>';
            }
        }
    
        echo '
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>DODAJ NOWĄ PODSTRONĘ</h3>
                </div>
                <div class="card-body">
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="admin.php?action=add">
                        <div class="form-group">
                            <label for="page_title">Tytuł podstrony:</label>
                            <input type="text" id="page_title" name="page_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="page_content">Treść podstrony:</label>
                            <textarea id="page_content" name="page_content" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="alias">Alias:</label>
                            <input type="text" id="alias" name="alias" class="form-control" required>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" id="status" name="status" class="form-check-input" value="1">
                            <label class="form-check-label" for="status">Aktywna</label>
                        </div>
                        <button type="submit" name="submit_add" class="btn btn-primary">Dodaj Podstronę</button>
                    </form>
                </div>
            </div>
        </div>';
    }

    public function UsunPodstrone($id) {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }

        $query = "DELETE FROM page_list WHERE id=$id LIMIT 1";
        mysqli_query($this->link, $query);
        header('Location: admin.php');
        exit;
    }

    public function ListaProduktow() {
        if (!isset($_SESSION['auth'])) {
            return;
        }
    
        echo '<div class="container mt-5">
                <a href="admin.php?action=add_product" class="btn btn-success mb-3">Dodaj Nowy Produkt</a>
                <br><br>
                <h3>Lista Produktów</h3>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tytuł</th>
                            <th>Opis</th>
                            <th>Data Utworzenia</th>
                            <th>Data Modyfikacji</th>
                            <th>Data Wygaśnięcia</th>
                            <th>Cena Netto</th>
                            <th>Podatek VAT</th>
                            <th>Ilość Dostępnych Sztuk</th>
                            <th>Status Dostępności</th>
                            <th>Kategoria</th>
                            <th>Gabaryt</th>
                            <th>Zdjęcie</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        $query = "SELECT * FROM produkty ORDER BY id ASC";
        $result = mysqli_query($this->link, $query);
    
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['tytul'] . '</td>
                    <td>' . $row['opis'] . '</td>
                    <td>' . $row['data_utworzenia'] . '</td>
                    <td>' . $row['data_modyfikacji'] . '</td>
                    <td>' . $row['data_wygasniecia'] . '</td>
                    <td>' . $row['cena_netto'] . '</td>
                    <td>' . $row['podatek_vat'] . '</td>
                    <td>' . $row['ilosc_dost_sztuk'] . '</td>
                    <td>' . $row['status_dost'] . '</td>
                    <td>' . $row['kategoria'] . '</td>
                    <td>' . $row['gabaryt_prod'] . '</td>
                    <td><img src="data:image/png;base64,' . base64_encode($row['zdjecie']) . '" width="100"/></td>
                    <td>
                        <a href="admin.php?action=edit_product&id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edytuj</a>
                        <a href="admin.php?action=delete_product&id=' . $row['id'] . '" class="btn btn-danger btn-sm">Usuń</a>
                    </td>
                  </tr>';
        }
    
        echo '</tbody></table></div>';
    }

    public function DodajProdukt() {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate file upload
            if (empty($_FILES['prod_zdj_add']['tmp_name'])) {
                echo '<div class="alert alert-danger">Proszę wybrać zdjęcie produktu.</div>';
                return;
            }
    
            try {
                // Get file content
                $zdjecie = file_get_contents($_FILES['prod_zdj_add']['tmp_name']);
                if ($zdjecie === false) {
                    throw new Exception('Błąd odczytu pliku zdjęcia');
                }
    
                // Prepare statement
                $query = "INSERT INTO produkty (
                    tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, 
                    cena_netto, podatek_vat, ilosc_dost_sztuk, status_dost, 
                    kategoria, gabaryt_prod, zdjecie
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
                $stmt = mysqli_prepare($this->link, $query);
                if (!$stmt) {
                    throw new Exception('Błąd przygotowania zapytania: ' . mysqli_error($this->link));
                }
    
                // Bind parameters
                $bound = mysqli_stmt_bind_param(
                    $stmt,
                    'sssssssssssb',
                    $_POST['prod_tytul_add'],
                    $_POST['prod_opis_add'],
                    $_POST['prod_data_utw_add'],
                    $_POST['prod_data_mod_add'],
                    $_POST['prod_data_wyg_add'],
                    $_POST['prod_cena_add'],
                    $_POST['prod_podatek_add'],
                    $_POST['prod_ilosc_add'],
                    $_POST['prod_status_dost_add'],
                    $_POST['prod_kat_add'],
                    $_POST['prod_gabaryt_add'],
                    $zdjecie
                );
    
                if (!$bound) {
                    throw new Exception('Błąd wiązania parametrów: ' . mysqli_stmt_error($stmt));
                }
    
                // Handle binary data
                mysqli_stmt_send_long_data($stmt, 11, $zdjecie);
    
                // Execute statement
                if (mysqli_stmt_execute($stmt)) {
                    header('Refresh: 0; URL=admin.php?action=products');
                    exit;
                } else {
                    throw new Exception('Błąd wykonania zapytania: ' . mysqli_stmt_error($stmt));
                }
            } catch (Exception $e) {
                echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
            } finally {
                if (isset($stmt)) {
                    mysqli_stmt_close($stmt);
                }
            }
        }
    
        echo '
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>DODAJ NOWY PRODUKT</h3>
                </div>
                <div class="card-body">
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="admin.php?action=add_product">
                        <div class="form-group">
                            <label for="prod_tytul_add">Tytuł:</label>
                            <input type="text" id="prod_tytul_add" name="prod_tytul_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_opis_add">Opis:</label>
                            <textarea id="prod_opis_add" name="prod_opis_add" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="prod_data_utw_add">Data utworzenia:</label>
                            <input type="date" id="prod_data_utw_add" name="prod_data_utw_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_data_mod_add">Data modyfikacji:</label>
                            <input type="date" id="prod_data_mod_add" name="prod_data_mod_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_data_wyg_add">Data wygaśnięcia:</label>
                            <input type="date" id="prod_data_wyg_add" name="prod_data_wyg_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_cena_add">Cena netto:</label>
                            <input type="text" id="prod_cena_add" name="prod_cena_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_podatek_add">Podatek VAT:</label>
                            <input type="text" id="prod_podatek_add" name="prod_podatek_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_ilosc_add">Ilość dostępnych sztuk:</label>
                            <input type="text" id="prod_ilosc_add" name="prod_ilosc_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_status_dost_add">Status dostępności:</label>
                            <input type="text" id="prod_status_dost_add" name="prod_status_dost_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_kat_add">Kategoria:</label>
                            <input type="text" id="prod_kat_add" name="prod_kat_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_gabaryt_add">Gabaryt:</label>
                            <input type="text" id="prod_gabaryt_add" name="prod_gabaryt_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_zdj_add">Zdjęcie:</label>
                            <input type="file" id="prod_zdj_add" name="prod_zdj_add" class="form-control" required>
                        </div>
                        <button type="submit" name="prod_submit_add" class="btn btn-primary">Dodaj Produkt</button>
                    </form>
                </div>
            </div>
        </div>';
    }

    public function EdytujProdukt($id) {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Sprawdź czy przekazano nowe zdjęcie
                $hasNewImage = !empty($_FILES['prod_zdj_edit']['tmp_name']);
                $zdjecie = null;
                
                // Przygotuj podstawowe parametry
                $params = [
                    $_POST['prod_tytul_edit'],
                    $_POST['prod_opis_edit'],
                    $_POST['prod_data_utw_edit'],
                    $_POST['prod_data_mod_edit'],
                    $_POST['prod_data_wyg_edit'],
                    $_POST['prod_cena_edit'],
                    $_POST['prod_podatek_edit'],
                    $_POST['prod_ilosc_edit'],
                    $_POST['prod_status_dost_edit'],
                    $_POST['prod_kat_edit'],
                    $_POST['prod_gabaryt_edit']
                ];
    
                // Buduj dynamiczne zapytanie SQL
                $query = "UPDATE produkty SET 
                    tytul = ?, 
                    opis = ?, 
                    data_utworzenia = ?, 
                    data_modyfikacji = ?, 
                    data_wygasniecia = ?, 
                    cena_netto = ?, 
                    podatek_vat = ?, 
                    ilosc_dost_sztuk = ?, 
                    status_dost = ?, 
                    kategoria = ?, 
                    gabaryt_prod = ?";
    
                // Dodaj zdjęcie jeśli istnieje
                if ($hasNewImage) {
                    $zdjecie = file_get_contents($_FILES['prod_zdj_edit']['tmp_name']);
                    $query .= ", zdjecie = ?";
                    $params[] = $zdjecie;
                }
    
                $query .= " WHERE id = ?";
                $params[] = $id;
    
                // Przygotuj typy parametrów
                $types = str_repeat('s', 11); // 11 stringów
                if ($hasNewImage) $types .= 'b'; // blob
                $types .= 'i'; // integer ID
    
                // Stwórz i wykonaj prepared statement
                $stmt = mysqli_prepare($this->link, $query);
                if (!$stmt) {
                    throw new Exception('Błąd przygotowania zapytania: ' . mysqli_error($this->link));
                }
    
                // Powiąż parametry przez referencje
                $boundParams = array_merge([$stmt, $types], $params);
                foreach ($boundParams as $key => $value) {
                    $boundParams[$key] = &$boundParams[$key];
                }
                
                call_user_func_array('mysqli_stmt_bind_param', $boundParams);
    
                // Obsłuż duże pliki jeśli istnieją
                if ($hasNewImage) {
                    mysqli_stmt_send_long_data($stmt, 11, $zdjecie);
                }
    
                if (mysqli_stmt_execute($stmt)) {
                    header('Refresh: 0; URL=admin.php?action=products');
                    exit;
                } else {
                    throw new Exception('Błąd aktualizacji: ' . mysqli_stmt_error($stmt));
                }
            } catch (Exception $e) {
                echo '<div class="alert alert-danger">' . $e->getMessage() . '</div>';
            } finally {
                if (isset($stmt)) {
                    mysqli_stmt_close($stmt);
                }
            }
        }
    
        // Pobierz istniejące dane produktu
        $query = "SELECT * FROM produkty WHERE id = ?";
        $stmt = mysqli_prepare($this->link, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    
        if (!$row) {
            echo '<div class="alert alert-danger">Produkt nie istnieje</div>';
            return;
        }
    
        // Wyświetl formularz (zachowaj oryginalną strukturę pól)
        echo '
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>EDYTUJ PRODUKT</h3>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="admin.php?action=edit_product&id=' . $id . '">
                        <div class="form-group">
                            <label for="prod_tytul_edit">Tytuł:</label>
                            <input type="text" id="prod_tytul_edit" name="prod_tytul_edit" class="form-control" value="' . htmlspecialchars($row['tytul']) . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_opis_edit">Opis:</label>
                            <textarea id="prod_opis_edit" name="prod_opis_edit" class="form-control" required>' . htmlspecialchars($row['opis']) . '</textarea>
                        </div>
                        <div class="form-group">
                            <label for="prod_data_utw_edit">Data utworzenia:</label>
                            <input type="date" id="prod_data_utw_edit" name="prod_data_utw_edit" class="form-control" value="' . $row['data_utworzenia'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_data_mod_edit">Data modyfikacji:</label>
                            <input type="date" id="prod_data_mod_edit" name="prod_data_mod_edit" class="form-control" value="' . $row['data_modyfikacji'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_data_wyg_edit">Data wygaśnięcia:</label>
                            <input type="date" id="prod_data_wyg_edit" name="prod_data_wyg_edit" class="form-control" value="' . $row['data_wygasniecia'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_cena_edit">Cena netto:</label>
                            <input type="text" id="prod_cena_edit" name="prod_cena_edit" class="form-control" value="' . htmlspecialchars($row['cena_netto']) . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_podatek_edit">Podatek VAT:</label>
                            <input type="text" id="prod_podatek_edit" name="prod_podatek_edit" class="form-control" value="' . htmlspecialchars($row['podatek_vat']) . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_ilosc_edit">Ilość dostępnych sztuk:</label>
                            <input type="text" id="prod_ilosc_edit" name="prod_ilosc_edit" class="form-control" value="' . htmlspecialchars($row['ilosc_dost_sztuk']) . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_status_dost_edit">Status dostępności:</label>
                            <input type="text" id="prod_status_dost_edit" name="prod_status_dost_edit" class="form-control" value="' . htmlspecialchars($row['status_dost']) . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_kat_edit">Kategoria:</label>
                            <input type="text" id="prod_kat_edit" name="prod_kat_edit" class="form-control" value="' . htmlspecialchars($row['kategoria']) . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_gabaryt_edit">Gabaryt:</label>
                            <input type="text" id="prod_gabaryt_edit" name="prod_gabaryt_edit" class="form-control" value="' . htmlspecialchars($row['gabaryt_prod']) . '" required>
                        </div>
                        <div class="form-group">
                            <label for="prod_zdj_edit">Zdjęcie (pozostaw puste aby zachować obecne):</label>
                            <input type="file" id="prod_zdj_edit" name="prod_zdj_edit" class="form-control">
                        </div>
                        <button type="submit" name="prod_submit_edit" class="btn btn-primary">Zapisz zmiany</button>
                    </form>
                </div>
            </div>
        </div>';
    }

    public function UsunProdukt($id) {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }

        $query = "DELETE FROM produkty WHERE id=$id LIMIT 1";
        mysqli_query($this->link, $query);
        header('Location: admin.php?action=products');
        exit;
    }

    public function ListaKategorii() {
        if (!isset($_SESSION['auth'])) {
            return;
        }
    
        echo '<div class="container mt-5">
                <a href="admin.php?action=add_category" class="btn btn-success mb-3">Dodaj Nową Kategorię</a>
                <br><br>
                <h3>Lista Kategorii</h3>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nazwa</th>
                            <th>Matka</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        $query = "SELECT * FROM kategorie ORDER BY id ASC";
        $result = mysqli_query($this->link, $query);
    
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . $row['nazwa'] . '</td>
                    <td>' . $row['matka'] . '</td>
                    <td>
                        <a href="admin.php?action=edit_category&id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edytuj</a>
                        <a href="admin.php?action=delete_category&id=' . $row['id'] . '" class="btn btn-danger btn-sm">Usuń</a>
                    </td>
                  </tr>';
        }
    
        echo '</tbody></table></div>';
    }

    public function DodajKategorie() {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $matka = mysqli_real_escape_string($this->link, $_POST['kat_matka_add']);
            $nazwa = mysqli_real_escape_string($this->link, $_POST['kat_nazwa_add']);
    
            $query = "INSERT INTO kategorie (matka, nazwa) VALUES ('$matka', '$nazwa')";
    
            if (mysqli_query($this->link, $query)) {
                header('Location: admin.php?action=categories');
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Błąd podczas dodawania kategorii: ' . mysqli_error($this->link) . '</div>';
            }
        }
    
        echo '
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>DODAJ NOWĄ KATEGORIĘ</h3>
                </div>
                <div class="card-body">
                    <form method="post" name="CreateForm" enctype="multipart/form-data" action="admin.php?action=add_category">
                        <div class="form-group">
                            <label for="kat_matka_add">Matka:</label>
                            <input type="text" id="kat_matka_add" name="kat_matka_add" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="kat_nazwa_add">Nazwa:</label>
                            <input type="text" id="kat_nazwa_add" name="kat_nazwa_add" class="form-control" required>
                        </div>
                        <button type="submit" name="kat_submit_add" class="btn btn-primary">Dodaj Kategorię</button>
                    </form>
                </div>
            </div>
        </div>';
    }

    public function EdytujKategorie($id) {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $matka = mysqli_real_escape_string($this->link, $_POST['kat_matka_update']);
            $nazwa = mysqli_real_escape_string($this->link, $_POST['kat_nazwa_update']);
    
            $query = "UPDATE kategorie SET matka='$matka', nazwa='$nazwa' WHERE id=$id LIMIT 1";
    
            if (mysqli_query($this->link, $query)) {
                header('Location: admin.php?action=categories');
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Błąd podczas aktualizacji kategorii: ' . mysqli_error($this->link) . '</div>';
            }
        }
    
        $query = "SELECT * FROM kategorie WHERE id=$id LIMIT 1";
        $result = mysqli_query($this->link, $query);
    
        if (!$result) {
            echo '<div class="alert alert-danger" role="alert">Błąd podczas pobierania danych kategorii: ' . mysqli_error($this->link) . '</div>';
            return;
        }
    
        $row = mysqli_fetch_assoc($result);
    
        if (!$row) {
            echo '<div class="alert alert-danger" role="alert">Kategoria o podanym ID nie istnieje!</div>';
            return;
        }
    
        echo '
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>EDYTUJ KATEGORIĘ</h3>
                </div>
                <div class="card-body">
                    <form method="post" name="EditForm" enctype="multipart/form-data" action="admin.php?action=edit_category&id=' . $id . '">
                        <div class="form-group">
                            <label for="kat_matka_update">Matka:</label>
                            <input type="text" id="kat_matka_update" name="kat_matka_update" class="form-control" value="' . $row['matka'] . '" required>
                        </div>
                        <div class="form-group">
                            <label for="kat_nazwa_update">Nazwa:</label>
                            <input type="text" id="kat_nazwa_update" name="kat_nazwa_update" class="form-control" value="' . $row['nazwa'] . '" required>
                        </div>
                        <button type="submit" name="kat_submit_update" class="btn btn-primary">Zapisz</button>
                    </form>
                </div>
            </div>
        </div>';
    }

    public function UsunKategorie($id) {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }

        $query = "DELETE FROM kategorie WHERE id=$id LIMIT 1";
        mysqli_query($this->link, $query);
        header('Location: admin.php?action=categories');
        exit;
    }

    public function PokazKategorie() {
        if (!isset($_SESSION['auth'])) {
            $this->FormularzLogowania();
            return;
        }
    
        echo '<div class="container mt-5">
                <h3>Drzewo Kategorii</h3>
                <div class="card">
                    <div class="card-body">';
    
        $matki_query = "SELECT * FROM kategorie WHERE matka=0";
        $matki_result = mysqli_query($this->link, $matki_query);
        $this->PokazKategorieHelper($matki_result, 0);
    
        echo '</div></div></div>';
    }

    private function PokazKategorieHelper($result, $level) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . 'ID: ' . $row['id'] . ', Nazwa: ' . $row['nazwa'] . ', Matka: ' . $row['matka'] . '<br>';
            $id = $row['id'];
            $dzieci_query = "SELECT * FROM kategorie WHERE matka=$id";
            $dzieci_result = mysqli_query($this->link, $dzieci_query);
            $this->PokazKategorieHelper($dzieci_result, $level + 1);
        }
    }
}

// Start the HTML output with Bootstrap
echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>';

$admin = new Admin($link);

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'edit':
            $admin->EdytujPodstrone($_GET['id']);
            break;
        case 'delete':
            $admin->UsunPodstrone($_GET['id']);
            break;
        case 'add':
            $admin->DodajNowaPodstrone();
            break;
        case 'add_product':
            $admin->DodajProdukt();
            break;
        case 'edit_product':
            $admin->EdytujProdukt($_GET['id']);
            break;
        case 'delete_product':
            $admin->UsunProdukt($_GET['id']);
            break;
        case 'add_category':
            $admin->DodajKategorie();
            break;
        case 'edit_category':
            $admin->EdytujKategorie($_GET['id']);
            break;
        case 'delete_category':
            $admin->UsunKategorie($_GET['id']);
            break;
        case 'categories':
            $admin->ListaPodstron();
            $admin->ListaProduktow();
            $admin->ListaKategorii();
            $admin->PokazKategorie();
            break;
        default:
            $admin->ListaPodstron();
            $admin->ListaProduktow();
            $admin->ListaKategorii();
            $admin->PokazKategorie();
            break;
    }
} else {
    $admin->ListaPodstron();
    $admin->ListaProduktow();
    $admin->ListaKategorii();
    $admin->PokazKategorie();
}

// Close the HTML
echo '
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';