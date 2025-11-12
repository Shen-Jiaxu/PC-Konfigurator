<?php
session_start(); // Sitzung starten, um Loginstatus später zu speichern

$login_error = ""; // Variable zur Speicherung möglicher Fehlermeldungen

// Wenn das Formular abgeschickt wurde (Methode POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);          // E-Mail aus Formular lesen
    $passwort = $_POST["passwort"];          // Passwort aus Formular lesen

    // Verbindung zur Datenbank herstellen
    $conn = new mysqli("localhost", "root", "", "mustermann");

    if ($conn->connect_error) {
        // Verbindung schlägt fehl → sofortiges Ende mit Fehlermeldung
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    // Vorbereitetes SQL-Statement gegen SQL-Injection
    $stmt = $conn->prepare("SELECT id, passwort FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result(); // Ergebnisse zwischenspeichern

    // Wenn genau ein Benutzer mit dieser E-Mail gefunden wurde
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $db_passwort); // Ergebnis-Felder abrufen
        $stmt->fetch();

        // Passwort mit Hash vergleichen
        if (password_verify($passwort, $db_passwort)) {
            $_SESSION["user_id"] = $id; // Benutzer-ID merken
            header("Location: gehaeuse.php"); // wenn stimmt Weiter zu Schritt 2
            exit;
        } else {
            $login_error = "Falsches Passwort."; // Passwort stimmt nicht
        }
    } else {
        $login_error = "Nutzer nicht gefunden."; // E-Mail nicht in DB
    }

    $stmt->close();
    $conn->close(); // Verbindung schließen
}
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <title>Login - Mustermann</title>
  <link href="bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!--Bei Login-Fehler wird ein JavaScript-Alert angezeigt -->
<?php if (!empty($login_error)): ?>
  <script>
    alert("<?= htmlspecialchars($login_error) ?>");
    window.location.href = "onlineshop.php"; // Zurück zur Loginseite
  </script>
<?php endif; ?>

</body>
</html>
