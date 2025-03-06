<?php
include('config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}

// Verwerk het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $VoorNaam = $_POST['VoorNaam'] ?? null;
    $Tussenvoegsel = $_POST['Tussenvoegsel'] ?? null;
    $Achternaam = $_POST['Achternaam'] ?? null;
    $Nummer = $_POST['Nummer'] ?? null;
    $Medewerkersoort = $_POST['Medewerkersoort'] ?? null;
    $IsActief = isset($_POST['IsActief']) ? 1 : 0; 

    if ($VoorNaam && $Achternaam && $Nummer && $Medewerkersoort) {
        $sql = "INSERT INTO MedewerkersOverzicht (VoorNaam, Tussenvoegsel, Achternaam, Nummer, Medewerkersoort, IsActief, DatumAangemaakt, DatumGewijzigd) 
                VALUES (:VoorNaam, :Tussenvoegsel, :Achternaam, :Nummer, :Medewerkersoort, :IsActief, SYSDATE(6), SYSDATE(6))";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':VoorNaam' => $VoorNaam,
            ':Tussenvoegsel' => $Tussenvoegsel,
            ':Achternaam' => $Achternaam,
            ':Nummer' => $Nummer,
            ':Medewerkersoort' => $Medewerkersoort,
            ':IsActief' => $IsActief
        ]);

        // Redirect naar index.php na toevoegen
        header("Location: index.php");
        exit;
    } else {
        $error = "Vul alle verplichte velden in!";
    }
}

?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medewerker Toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8 text-primary"><h3>Nieuwe Medewerker Toevoegen</h3></div>
            <div class="col-2"></div>
        </div>
        <div class="row my-2">
            <div class="col-2"></div>
            <div class="col-8">
                <form method="POST" action="create.php">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Voornaam *</label>
                        <input type="text" class="form-control" name="VoorNaam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tussenvoegsel</label>
                        <input type="text" class="form-control" name="Tussenvoegsel">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Achternaam *</label>
                        <input type="text" class="form-control" name="Achternaam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nummer *</label>
                        <input type="number" class="form-control" name="Nummer" required min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Medewerkersoort *</label>
                        <select class="form-control" name="Medewerkersoort" required>
                            <option value="Manager">Manager</option>
                            <option value="Beheerder">Beheerder</option>
                            <option value="DiskMedewerker">DiskMedewerker</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="IsActief" checked>
                        <label class="form-check-label">Actief</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Toevoegen</button>
                    <a href="medewerkers.php" class="btn btn-secondary">Annuleren</a>
                </form>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
