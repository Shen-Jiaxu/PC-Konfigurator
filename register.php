<?php
$conn = new mysqli("localhost", "root", "", "mustermann");// Verbindung zur Datenbank herstellen
$conn->set_charset("utf8");

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") { // Formular wurde abgeschickt
    // Benutzerdaten aus dem Formular lesen
    $anrede    = trim($_POST["anrede"]);
    $vorname   = trim($_POST["vorname"]);
    $nachname  = trim($_POST["nachname"]);
    $email     = trim($_POST["email"]);
    $firma     = trim($_POST["firma"]);
    $strasse   = trim($_POST["strasse"]);
    $plz       = trim($_POST["plz"]);
    $passwort1 = $_POST["passwort"];
    $passwort2 = $_POST["passwort2"];

    // Validierungen
    if (!$anrede || !$vorname || !$nachname || !$email || !$strasse || !$plz || !$passwort1 || !$passwort2) {
        $errors[] = "Bitte füllen Sie alle Pflichtfelder aus.";
    }

    if (!preg_match("/^\d{5}$/", $plz)) {
        $errors[] = "Die PLZ muss eine 5-stellige Zahl sein.";
    }

    if (strlen($passwort1) < 6) {
        $errors[] = "Das Passwort muss mindestens 6 Zeichen lang sein.";
    }

    if ($passwort1 !== $passwort2) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    // Prüfen, ob E-Mail schon existiert
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Diese E-Mail-Adresse ist bereits registriert.";
    }

    $stmt->close();

    // Wenn alles gültig → speichern
    if (empty($errors)) {
        $hash = password_hash($passwort1, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (anrede, vorname, nachname, email, firma, strasse, plz, passwort) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $anrede, $vorname, $nachname, $email, $firma, $strasse, $plz, $hash);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Fehler beim Speichern in die Datenbank.";
        }

        $stmt->close();
    }

    $conn->close();

    //  Ausgabe per JavaScript
    if ($success) {
        echo "<script>alert('Registrierung erfolgreich!'); window.location.href='onlineshop.html';</script>";
        exit;
    } elseif (!empty($errors)) {
        $message = "Fehler bei der Registrierung:\\n" . implode("\\n", array_map('addslashes', $errors));
        echo "<script>alert('$message'); window.location.href='onlineshop.html';</script>";
        exit;
    }
}
?>
