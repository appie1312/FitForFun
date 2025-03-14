<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Stuur de gebruiker naar de loginpagina
    header("Location: /login/login.php");
    exit();
}

// Controleer of het configuratiebestand bestaat
if (!file_exists('config.php')) {
    die("Fout: Configuratiebestand niet gevonden. Zorg ervoor dat config/config.php bestaat.");
}

// Configuratiebestand inladen
include('config.php');

try {
    // Verbinding maken met de database
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=UTF8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

// SQL-query om gegevens op te halen
$sql = "SELECT VoorNaam, Tussenvoegsel, Achternaam, Nummer, Medewerkersoort FROM MedewerkersOverzicht ORDER BY Nummer DESC";

try {
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Fout bij ophalen van gegevens: " . $e->getMessage());
}

?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MedewerkersOverzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Medewerkers.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container mt-3">  
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8 text-primary"><h3>MedewerkersOverzicht</h3></div>
            <div class="col-2"></div>
        </div>
        <div class="row my-2">
            <div class="col-2"></div>
            <div class="col-8">
                Invoegen nieuwe medewerker: 
                <a href="create.php"><i class="bi bi-plus-square-fill text-danger"></i></a>
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Voornaam</th>
                            <th>Tussenvoegsel</th>
                            <th>Achternaam</th>
                            <th>Nummer</th>
                            <th>Medewerkersoort</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($result)): ?>
                            <?php foreach($result as $Medewerker) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($Medewerker->VoorNaam ?? '') ?></td>
                                    <td><?= htmlspecialchars($Medewerker->Tussenvoegsel ?? '') ?></td>
                                    <td><?= htmlspecialchars($Medewerker->Achternaam) ?></td>
                                    <td><?= htmlspecialchars($Medewerker->Nummer) ?></td>
                                    <td><?= htmlspecialchars($Medewerker->Medewerkersoort) ?></td>
                                </tr> 
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Geen medewerkers gevonden.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
