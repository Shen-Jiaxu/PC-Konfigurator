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
session_start(); // Sitzung starten, um Nutzerauswahl zwischen den Schritten zu speichern

// Wenn der Nutzer auf "Auswählen" klickt und das Formular abschickt
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Die gewählte Gehäusebeschreibung im Session-Array speichern
    $_SESSION["gehäuse"] = $_POST["gehäuse"];

    // Weiterleitung zum nächsten Schritt: CPU-Auswahl
    header("Location: cpu.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Schritt 2: Gehäuse wählen</title>
  <link href="bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS für Animation beim Überfahren der Gehäusebilder -->
  <style>
    img.gehaeuse-img {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Zoom-Effekt beim Hover über Tabellenzeile */
    tr:hover img.gehaeuse-img {
      transform: scale(1.1); dc
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2>Schritt 2 von 5: Gehäuse</h2>

  <!-- Auswahlformular mit 3 Gehäusen -->
  <form method="post">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Bild</th>
          <th>Bezeichnung</th>
          <th>Form</th>
          <th>Farbe</th>
          <th>RGB</th>
          <th>Preis</th>
          <th>Auswahl</th>
        </tr>
      </thead>
      <tbody>
        <!-- Option 1: LianLi Midi-Tower -->
        <tr>
          <td><img src="img/lianli.jpg" width="100" class="gehaeuse-img" alt="LianLi"></td>
          <td>LianLi O11D Evo RGB</td>
          <td>Midi-Tower</td>
          <td>Schwarz</td>
          <td>Ja</td>
          <td>59,99 €</td>
          <td>
            <!-- Button überträgt die Gehäusebezeichnung an das Backend -->
            <button name="gehäuse" value="LianLi O11D Evo RGB – 59,99 €" class="btn btn-outline-primary">Auswählen</button>
          </td>
        </tr>

        <!-- Option 2: ASUS ROG Maxi-Tower -->
        <tr>
          <td><img src="img/rog.jpg" width="100" class="gehaeuse-img" alt="ROG Hyperion"></td>
          <td>ASUS ROG Hyperion GR701</td>
          <td>Maxi-Towe</td>
          <td>Schwarz</td>
          <td>Ja</td>
          <td>289,99 €</td>
          <td>
            <button name="gehäuse" value="ASUS ROG Hyperion GR701 – 289,99 €" class="btn btn-outline-primary">Auswählen</button>
          </td>
        </tr>

        <!-- Option 3: Lenovo Desktop -->
        <tr>
          <td><img src="img/desktop.jpg" width="100" class="gehaeuse-img" alt="Lenovo Desktop"></td>
          <td>Lenovo Desktop PC</td>
          <td>Desktop</td>
          <td>Schwarz</td>
          <td>Nein</td>
          <td>49,99 €</td>
          <td>
            <button name="gehäuse" value="Lenovo Desktop PC – 49,99 €" class="btn btn-outline-primary">Auswählen</button>
          </td>
        </tr>
        <tr>
          <td><img src="img/corsair.jpg" width="100" class="gehaeuse-img" alt="Corsair"></td>
          <td>Corsair 6500X</td>
          <td>Midi-Tower</td>
          <td>Weiß</td>
          <td>Nein</td>
          <td>69,99 €</td>
          <td>
            <button name="gehäuse" value="Corsair 6500X – 69,99 €" class="btn btn-outline-primary">Auswählen</button>
          </td>
        </tr>
        <tr>
          <td><img src="img/coolermaster2.jpg" width="100" class="gehaeuse-img" alt="Cooler Master"></td>
          <td>Cooler Master HAF 700 EVO</td>
          <td>Maxi-Tower</td>
          <td>Weiß</td>
          <td>Ja</td>
          <td>99,99 €</td>
          <td>
            <button name="gehäuse" value="Cooler Master HAF 700 EVO – 99,99 €" class="btn btn-outline-primary">Auswählen</button>
          </td>
        </tr>
        <tr>
          <td><img src="img/msi.jpg" width="100" class="gehaeuse-img" alt="MSI"></td>
          <td>MSI MAG PANO M100R</td>
          <td>Midi-Tower</td>
          <td>Weiß</td>
          <td>Ja</td>
          <td>79,99 €</td>
          <td>
            <button name="gehäuse" value="MSI MAG PANO M100R – 79,99 €" class="btn btn-outline-primary">Auswählen</button>
          </td>
        </tr>
      </tbody>
    </table>
  </form>

  <!-- Option zum Abbrechen und Rückkehr zur Startseite -->
  <a href="onlineshop.php" class="btn btn-secondary">Zurück zur Anmeldung</a>
</div>
<footer class="pt-3 mt-4 text-muted border-top">
      &copy; 2021 Mustermann GmbH - eine Demoseite Übungen (Modul Web-Technologien)
    </footer>
<!-- Bootstrap JS für Interaktivität -->
<script src="bootstrap5.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
