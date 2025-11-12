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

//CPU-ID vom vorherigen Schritt übernehmen, wenn übergeben
if (isset($_POST['cpu_id'])) {
    $_SESSION['cpu_id'] = (int)$_POST['cpu_id'];
}

//Wenn keine CPU gewählt → zurück
if (!isset($_SESSION['cpu_id'])) {
    header("Location: cpu.php");
    exit;
}

// RAM speichern und weiterleiten, wenn Formular abgeschickt
$error = "";
$ram = (int)($_POST["ram"] ?? 0);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["ram"])) {
    // Grundvalidierung
    if ($ram >= 4 && $ram % 4 === 0) {
        $_SESSION["ram"] = $ram;
        header("Location: erweiterung.php");
        exit;
    } else {
        $error = "Ungültiger RAM-Wert.";
    }
}

// CPU-Daten holen
$cpu_id = $_SESSION['cpu_id'];
$conn = new mysqli("localhost", "root", "", "mustermann");
$conn->set_charset("utf8");

$stmt = $conn->prepare("SELECT * FROM cpus WHERE id = ?");
$stmt->bind_param("i", $cpu_id);
$stmt->execute();
$result = $stmt->get_result();
$cpu = $result->fetch_assoc();

$stmt->close();
$conn->close();

// Max RAM extrahieren (z. B. "192 GB" → 192)
$max_ram = (int) filter_var($cpu['max_ram'], FILTER_SANITIZE_NUMBER_INT);
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Schritt 4: RAM wählen</title>
  <link href="bootstrap5.3/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .preis-box { font-size: 1.25rem; font-weight: bold; }
  </style>
</head>
<body>

<div class="container mt-5">
  <h2>Schritt 4 von 5: Arbeitsspeicher wählen</h2>
  <p>Ihre gewählte CPU: <strong><?= htmlspecialchars($cpu['modell']) ?></strong><br> 
     Maximale RAM-Größe: <strong><?= $max_ram ?> GB</strong></p>

  <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div> 
  <?php endif; ?>

  <!--RAM-Auswahlformular -->
  <form method="post"> // Formular für die RAM-Auswahl
    <div class="mb-3">
      <label for="ram" class="form-label">Arbeitsspeicher (in GB)</label>
      <input type="number"
             class="form-control"
             id="ram"
             name="ram"
             min="4"
             max="<?= $max_ram ?>"
             step="4"
             value="<?= $ram ?: ($_SESSION['ram'] ?? 8) ?>"
             required>
      <div class="form-text">Bitte wählen Sie eine durch 4 teilbare Größe zwischen 4 und <?= $max_ram ?> GB.</div>
    </div>

    <div class="preis-box mb-4"> 
      Preis: <span id="preis">0,00</span> Euro
    </div>

    <button type="submit" class="btn btn-primary">Weiter zu Schritt 5</button>
    <a href="cpu.php" class="btn btn-secondary">Zurück zu Schritt 3</a>
  </form>
</div>

<script> // Preisberechnung aktualisieren

function updatePreis() {
  let ram = parseInt(document.getElementById("ram").value) || 0;
  let preis = (ram * 0.80).toFixed(2);
  document.getElementById("preis").textContent = preis.replace(".", ",");
}
document.getElementById("ram").addEventListener("input", updatePreis);
window.addEventListener("DOMContentLoaded", updatePreis);

</script>

<script src="bootstrap5.3/js/bootstrap.bundle.min.js"></script>
<footer class="pt-3 mt-4 text-muted border-top">
      &copy; 2021 Mustermann GmbH - eine Demoseite Übungen (Modul Web-Technologien)
    </footer>

</body>
</html>
