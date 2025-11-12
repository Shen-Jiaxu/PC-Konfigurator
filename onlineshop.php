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

    <div class="p-4 mb-4 mt-4 bg-white rounded-3 border border-light">
      <div class="container-fluid py-5">

        <h1 class="display-5 fw-bold">Willkommen bei Mustermann IT-Systeme</h1>
        <p class="fs-4">Schritt 1 von 5: Melden Sie sich an oder registrieren Sie sich:</p>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="authTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="login-tab-pane" aria-selected="true">Login</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register-tab-pane" type="button" role="tab" aria-controls="register-tab-pane" aria-selected="false">Registrieren</button>
          </li>
        </ul>

        <!-- Tabs Inhalte -->
        <div class="tab-content mt-4" id="authTabsContent">

          <!-- Login Tab -->
          <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab">
            <form action="login.php" method="POST">
              <div class="mb-3">
                <label for="loginEmail" class="form-label">E-Mail-Adresse</label>
                <input type="email" class="form-control" id="loginEmail" name="email" required>
              </div>
              <div class="mb-3">
                <label for="loginPassword" class="form-label">Passwort</label>
                <input type="password" class="form-control" id="loginPassword" name="passwort" required>
              </div>
              <button type="submit" class="btn btn-success">Einloggen</button>
            </form>
          </div>

          <!-- Registrierung Tab -->
          <div class="tab-pane fade" id="register-tab-pane" role="tabpanel" aria-labelledby="register-tab">
            <form action="register.php" method="POST">
              <div class="row">
                <div class="col-md-2 mb-3">
                  <label class="form-label">Anrede*</label>
                  <select class="form-select" name="anrede" required>
                    <option value="">Bitte wählen</option>
                    <option>Herr</option>
                    <option>Frau</option>
                    <option>Divers</option>
                  </select>
                </div>
                <div class="col-md-5 mb-3">
                  <label class="form-label">Vorname*</label>
                  <input type="text" class="form-control" name="vorname" required>
                </div>
                <div class="col-md-5 mb-3">
                  <label class="form-label">Nachname*</label>
                  <input type="text" class="form-control" name="nachname" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">E-Mail*</label>
                <input type="email" class="form-control" name="email" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Firmenname (optional)</label>
                <input type="text" class="form-control" name="firma">
              </div>

              <div class="row">
                <div class="col-md-8 mb-3">
                  <label class="form-label">Straße und Hausnummer*</label>
                  <input type="text" class="form-control" name="strasse" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label class="form-label">PLZ*</label>
                  <input type="text" class="form-control" name="plz" pattern="\d{5}" required>
                  <div class="form-text text-danger">Nur Lieferung nach Deutschland – 5-stellige PLZ erforderlich!</div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Passwort*</label>
                  <input type="password" class="form-control" name="passwort" minlength="6" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Passwort wiederholen*</label>
                  <input type="password" class="form-control" name="passwort2" minlength="6" required>
                </div>
              </div>

              <button type="submit" class="btn btn-primary">Registrieren</button>
            </form>
          </div>
        </div>

      </div>
    </div>

    <footer class="pt-3 mt-4 text-muted border-top">
      &copy; 2021 Mustermann GmbH - eine Demoseite Übungen (Modul Web-Technologien)
    </footer>

  </div>
</main>

<script src="bootstrap5.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
