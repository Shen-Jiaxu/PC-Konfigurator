<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mustermann IT-Systeme</title>
    <link href="bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>

<main>
  <div class="container py-4">
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <span class="navbar-brand h1">Mustermann GmbH</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="index.html">Startseite</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">IT-Schulungen</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Online-Shop</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Service
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">Hardware-Support</a></li>
                <li><a class="dropdown-item" href="#">Software-Support</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Impressum</a></li>
                <li><a class="dropdown-item" href="#">Datenschutz</a></li>
              </ul>
            </li>
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Suche" aria-label="Search">
            <button class="btn btn-outline-dark" type="submit">
              <img src="bootstrap5.3/icons/search.svg">
            </button>
          </form>
        </div>
      </div>
    </nav>

<?php
session_start(); // Sitzung starten, um alle gewählten Komponenten zu speichern

// Optional: Wenn Gehäuse über POST kam, speichern
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["gehüuse"])) {
    $_SESSION["gehäuse"] = $_POST["gehäuse"];
}

$filter = $_GET['hersteller'] ?? 'Intel'; // Standardfilter: Wenn kein Hersteller übergeben wurde, wird "Intel" vorausgewählt

$conn = new mysqli("localhost", "root", "", "mustermann"); // Verbindung zur Datenbank herstellen
$conn->set_charset("utf8");

$stmt = $conn->prepare("SELECT * FROM cpus WHERE hersteller = ?"); //SQL-Abfrage: Alle CPUs vom gewählten Hersteller laden
$stmt->bind_param("s", $filter);
$stmt->execute();
$result = $stmt->get_result();

$cpus = []; // Array für die CPU-Daten initialisieren
while ($row = $result->fetch_assoc()) {
    $cpus[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>         
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Schritt 3: CPU wählen</title>
  <!--Bootstrap für Design & Layout -->
  <link href="bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>Schritt 3 von 5: CPU wählen</h2>

  <!--Hersteller-Filter (per GET → Form wird bei Änderung automatisch neu geladen) -->
  <form method="get" class="mb-3"> 
    <label class="form-check-label me-2">Hersteller:</label>
    <!-- Radio-Buttons: setzen "hersteller"-Wert (Intel oder AMD) -->
    <input type="radio" name="hersteller" value="Intel" <?= $filter === 'Intel' ? 'checked' : '' ?> onchange="this.form.submit()"> Intel
    <input type="radio" name="hersteller" value="AMD" <?= $filter === 'AMD' ? 'checked' : '' ?> onchange="this.form.submit()"> AMD
  </form>

  <!--CPU-Auswahltabelle → per POST an ram.php senden -->
  <form method="post" action="ram.php"> 
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Modell</th>
          <th>max. RAM</th>
          <th>Preis</th>
          <th>Auswahl</th>
        </tr>
      </thead>
      <tbody>
        <!--Für jede CPU aus der Datenbank eine Zeile erzeugen -->
        <?php foreach ($cpus as $cpu): ?>
          <tr>
            <td><?= htmlspecialchars($cpu['modell']) ?></td>    
            <td><?= htmlspecialchars($cpu['max_ram']) ?></td>
            <td><?= number_format($cpu['preis'], 2, ',', '.') ?> €</td>
            <!--Auswahl-Button: sendet CPU-ID per POST an ram.php -->
            <td><button type="submit" name="cpu_id" value="<?= $cpu['id'] ?>" class="btn btn-outline-primary">Auswählen</button></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </form>

  <!-- 🔙 Navigation zurück zu vorherigem Schritt -->
  <a href="gehäuse.php" class="btn btn-secondary">Zurück zu Schritt 2</a>
</div>

<script src="bootstrap5.3/js/bootstrap.bundle.min.js"></script>

<footer class="pt-3 mt-4 text-muted border-top">
      &copy; 2021 Mustermann GmbH - eine Demoseite Übungen (Modul Web-Technologien)
    </footer>
</body>
</html>

