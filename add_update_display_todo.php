<?php
function addTodo($mysqli, $bezeichnung, $faelligkeit) {
    //Status wird automatisch auf 0 gesetzt
    $status = 0;
    //VALUES(?,?,?) -> dadurch werden SQL-Injector Angriffe verhindert
    $stmt = $mysqli->prepare("INSERT INTO todo (bezeichnung, faelligkeit, status) VALUES (?, ?, ?)");
    //Variablen werden mit bind_param gebunden 
    //"ssi" - string, string, integer
    $stmt->bind_param("ssi", $bezeichnung, $faelligkeit, $status);
    $stmt->execute();
    $stmt->close(); 
}

function updateTodoStatus($mysqli, $id, $newStatus) {
    $stmt = $mysqli->prepare("UPDATE todo SET status = ? WHERE id = ?");
    $stmt->bind_param("is", $newStatus, $id);
    $stmt->execute();
    $stmt->close(); 
}

// Anzeigen der To-Dos
function displayTodos($mysqli) {
    //ORDER BY faelligkeit, damit wird in der Tabelle die Einträge nach Datum sortiert
    $stmt = $mysqli->prepare("SELECT * FROM todo ORDER BY faelligkeit ASC");
    $stmt->execute();
    $result = $stmt->get_result();
    $heute = date("Y-m-d");

    if ($result->num_rows == 0) {
        echo "Keine To-Dos gefunden.";
    }

    if ($result) {
        echo "<table>";
        echo "<tr><th>Bezeichnung</th><th>Fälligkeit</th><th>Status</th><th>Erledigt?</th></tr>";

        while ($row = $result->fetch_assoc()) {
            $faelligkeit = $row['faelligkeit']; 
            //CompletedClass wird damit definiert - relevant für Formatierung udn ButtonTodos.js
            $completedClass = $row['status'] == 1 ? 'completedTodo' : '';

            echo "<tr class='$completedClass'>";
            // Überprüfen, ob das Fälligkeitsdatum in der Vergangenheit liegt
            if (strtotime($faelligkeit) < strtotime($heute) && $row['status'] == 0) {
                // Überfälliges Datum und Status 0
                echo "<td class='ueberfaellig'>" . htmlspecialchars($row['bezeichnung']) . "</td>";  
                echo "<td class='ueberfaellig'>" . date("d.m.Y", strtotime($faelligkeit)) . "</td>";
                echo "<td class='ueberfaellig'>" . ($row['status'] == 0 ? 'Offen' : 'Erledigt') . "</td>";
            } else {
                // Nicht überfälliges Datum oder Status nicht 0
                echo "<td>" . htmlspecialchars($row['bezeichnung']) . "</td>";
                echo "<td>" . date("d.m.Y", strtotime($faelligkeit)) . "</td>";
                echo "<td>" . ($row['status'] == 0 ? 'Offen' : 'Erledigt') . "</td>";
            } 
            echo "<td>";
            echo "<form method='POST'>";
            //mit dieser Zeile kann der Status wieder auf offen geändert werden
            echo "<input type='hidden' name='status' value='0'>";
            // onchange='...' Formular wird sofort abgesendet
            echo "<input type='checkbox' name='status' " . ($row['status'] == 1 ? 'checked' : '') . " onchange='this.form.submit();'>";
            //Notwendig, damit der Server weißt welcher Eintrag geändert werden soll
            echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
            echo "</form>";
            echo "</td>";
           echo "</tr>";
        }

        echo "</table>";

        $todoCount = $result->num_rows;
        echo "<small>";
        echo "Anzahl der To-Dos: " . $todoCount .  "<br>";
        echo "</small>";
    } else {
        echo "Fehler beim Laden der To-Dos: " . $mysqli->error;
    } 
}

?>
