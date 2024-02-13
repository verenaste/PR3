<!DOCTYPE html>
<html>
<head>
    <title>ToDo App</title>
    <link rel="stylesheet" type="text/css" href="todo_design.css">
</head>
<body>

    <?php include 'todo_form.html'; ?>

    <!-- Button zum Umschalten der Sichtbarkeit erledigter To-Dos -->
    <br><br>
    <button id="CompletedTodosButton">Offene To-Dos anzeigen</button>
    <?php
    // Einbinden der Datenbank-Zugangsdaten
    require_once("db_login.inc.php");
    // Einbinden der php Datei
    require_once("add_update_display_todo.php");

    // Erstellen einer neuen Datenbankverbindung
    $mysqli = login("todo");

    // Aktualisieren des Status eines To-Dos 
    // wird nur ausgeführt, wenn Status und ID übermittelt wurde
    if (isset($_POST['status']) && isset($_POST['id'])) {
        updateTodoStatus($mysqli, $_POST['id'], $_POST['status'] ? 1 : 0);
    }

    // Hinzufügen eines neuen To-Dos
    if (!empty($_POST['bezeichnung']) && !empty($_POST['faelligkeit'])) {
        addTodo($mysqli, $_POST['bezeichnung'], $_POST['faelligkeit']);
    }

    echo "<br>";

    displayTodos($mysqli);

    ?>
<!Einbinden der js Datei für den Button>
<script src="ButtonTodos.js"></script>
</body>
</html>
