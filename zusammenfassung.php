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
session_start();

// Verbindung zur Datenbank
$conn = new mysqli("localhost", "root", "", "mustermann");
$conn->set_charset("utf8");

// Werte aus der Session laden
$user_id  = $_SESSION['user_id'] ?? 0;
$cpu_id   = $_SESSION['cpu_id'] ?? null;
$ram      = $_SESSION['ram'] ?? 0;
$gehäuse  = $_SESSION['gehäuse'] ?? 'Nicht gewählt';

$zubehoer_ids    = $_POST['zubehoer'] ?? [];
$ausstattung_ids = $_POST['ausstattung'] ?? [];

// CPU-Daten abrufen
$stmt = $conn->prepare("SELECT modell, preis FROM cpus WHERE id = ?");
$stmt->bind_param("i", $cpu_id);
$stmt->execute();
$stmt->bind_result($cpu_modell, $cpu_preis);
$stmt->fetch();
$stmt->close();

$ram_preis = $ram * 0.80;

// Zubehör abrufen
$zubehoer = [];
$zubehoer_summe = 0;
if (!empty($zubehoer_ids)) {
    $ids = implode(",", array_map('intval', $zubehoer_ids));
    $result = $conn->query("SELECT name, modell, preis FROM zubehoer WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $zubehoer[] = $row;
        $zubehoer_summe += $row['preis'];
    }
}

// Ausstattung abrufen
$ausstattung = [];
$ausstattung_summe = 0;
if (!empty($ausstattung_ids)) {
    $ids = implode(",", array_map('intval', $ausstattung_ids));
    $result = $conn->query("SELECT name, modell, preis FROM ausstattung WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $ausstattung[] = $row;
        $ausstattung_summe += $row['preis'];
    }
}

// Gesamtpreis berechnen
$gesamtpreis = $cpu_preis + $ram_preis + $zubehoer_summe + $ausstattung_summe;

// Kundendaten abrufen
$stmt = $conn->prepare("SELECT anrede, vorname, nachname, email, firma, strasse, plz FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($anrede, $vorname, $nachname, $email, $firma, $strasse, $plz);
$stmt->fetch();
$stmt->close();

// Bestellung speichern
$stmt = $conn->prepare("INSERT INTO bestellungen (user_id, gehäuse, cpu_id, ram, zubehoer, ausstattung) VALUES (?, ?, ?, ?, ?, ?)");
$zubehoer_json = json_encode($zubehoer_ids);
$ausstattung_json = json_encode($ausstattung_ids);
$stmt->bind_param("ississ", $user_id, $gehäuse, $cpu_id, $ram, $zubehoer_json, $ausstattung_json);
$stmt->execute();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Zusammenfassung</title>
  <link href="bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>Zusammenfassung Ihrer Bestellung</h2>

  <!-- ✅ Kundendaten / Lieferadresse -->
  <h5>Kundendaten & Lieferadresse</h5>
  <p>
    <?= htmlspecialchars($anrede) ?> <?= htmlspecialchars($vorname) ?> <?= htmlspecialchars($nachname) ?><br>
    <?php if (!empty($firma)) echo "Firma: " . htmlspecialchars($firma) . "<br>"; ?>
    <?= htmlspecialchars($strasse) ?><br>
    <?= htmlspecialchars($plz) ?> Deutschland<br>
    E-Mail: <?= htmlspecialchars($email) ?>
  </p>

  <hr>

  <!-- Gehäuse -->
  <h5><strong>Gehäuse</strong></h5>
  <p><?= htmlspecialchars($gehäuse) ?></p>

  <!-- CPU -->
  <h5><strong>CPU</strong></h5>
  <p><?= htmlspecialchars($cpu_modell) ?> – <?= number_format($cpu_preis, 2, ',', '.') ?> €</p>

  <!-- RAM -->
  <h5><strong>RAM</strong></h5>
  <p><?= $ram ?> GB – <?= number_format($ram_preis, 2, ',', '.') ?> €</p>

  <!-- Zubehör -->
  <h5><strong>Zubehör</strong></h5>
  <ul>
    <?php foreach ($zubehoer as $z): ?>
      <li><?= htmlspecialchars($z['name']) ?> (<?= $z['modell'] ?>) – <?= number_format($z['preis'], 2, ',', '.') ?> €</li>
    <?php endforeach; ?>
  </ul>

  <!-- Ausstattung -->
  <h5><strong>Ausstattung</strong></h5>
  <ul>
    <?php foreach ($ausstattung as $a): ?>
      <li><?= htmlspecialchars($a['name']) ?> (<?= $a['modell'] ?>) – <?= number_format($a['preis'], 2, ',', '.') ?> €</li>
    <?php endforeach; ?>
  </ul>

  <!-- Gesamt -->
  <h4>Gesamt: <strong><?= number_format($gesamtpreis, 2, ',', '.') ?> €</strong></h4>

  <div class="mt-4 text-center">
    <button class="btn btn-success btn-lg" disabled>Jetzt kostenpflichtig bestellen</button>
  </div>
</div>


<script src="bootstrap5.3/js/bootstrap.bundle.min.js"></script>

<footer class="pt-3 mt-4 text-muted border-top">
      &copy; 2021 Mustermann GmbH - eine Demoseite Übungen (Modul Web-Technologien)
    </footer>
</body>
</html>
