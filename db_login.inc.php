<!DOCTYPE html>
<html>
<head>
</head>
<body>

<?php
/** Erstellt eine Datenbankverbindung mit zentralen 3 
 * Konfigurationsdaten des DB-Servers.
 * @param $database die Datenbank
 * @return mysqli-Objekt der Datenbankverbindung
 */
function login($database) {
    $server = "localhost";
    $user = "root";
    $password = "";
    $mysqli = new mysqli($server, $user, $password, $database);
    
    // Überprüfen, ob die Verbindung erfolgreich hergestellt wurde
    if ($mysqli->connect_errno) {
        die("Keine DB-Verbindung: ({$mysqli->connect_errno}) " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8");
    return $mysqli; // Die Zeilennummer am Ende entfernen
}
?>

</body>
</html>