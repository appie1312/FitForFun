<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: /login/login.php");
    exit();
}

if (!file_exists('config.php')) {
    die("Fout: Configuratiebestand niet gevonden. Zorg ervoor dat config/config.php bestaat.");
}

include('config.php');

try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=UTF8", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}

if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM Medewerker WHERE Nummer = :id");
        $stmt->execute(['id' => $id]);
        $medewerker = $stmt->fetch(PDO::FETCH_OBJ);

        if ($medewerker) {
            if ($medewerker->Medewerkersoort === "Beheerder") {
                $errorMsg = "Je kunt een beheerder niet verwijderen.";
            } else {
                $delStmt = $pdo->prepare("DELETE FROM Medewerker WHERE Nummer = :id");
                if ($delStmt->execute(['id' => $id])) {
                    $successMsg = "Medewerker succesvol verwijderd.";
                } else {
                    $errorMsg = "Fout bij verwijderen.";
                }
            }
        } else {
            $errorMsg = "Medewerker bestaat niet.";
        }
    } catch (PDOException $e) {
        $errorMsg = "Databasefout: " . $e->getMessage();
    }
}


$sql = "SELECT VoorNaam, Tussenvoegsel, Achternaam, Nummer, Medewerkersoort FROM Medewerker ORDER BY Nummer DESC";

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
<div id="navbar"></div>
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

    <?php if (isset($successMsg)): ?>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
            </div>
            <div class="col-2"></div>
        </div>
    <?php elseif (isset($errorMsg)): ?>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="alert alert-danger"><?= htmlspecialchars($errorMsg) ?></div>
            </div>
            <div class="col-2"></div>
        </div>
    <?php endif; ?>

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
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($result)): ?>
                        <?php foreach($result as $Medewerker): ?>
                            <tr>
                                <td><?= htmlspecialchars($Medewerker->VoorNaam ?? '') ?></td>
                                <td><?= htmlspecialchars($Medewerker->Tussenvoegsel ?? '') ?></td>
                                <td><?= htmlspecialchars($Medewerker->Achternaam) ?></td>
                                <td><?= htmlspecialchars($Medewerker->Nummer) ?></td>
                                <td><?= htmlspecialchars($Medewerker->Medewerkersoort) ?></td>
                                <td>
    <a href="wijzig.php?id=<?= htmlspecialchars($Medewerker->Nummer) ?>" 
       onclick="return confirm('Weet je zeker dat je deze medewerker wilt wijzigen?')">
        <i class="bi bi-arrow-clockwise"></i>
    </a>
    |
    <a href="medewerkers.php?delete_id=<?= htmlspecialchars($Medewerker->Nummer) ?>" 
       onclick="return confirm('Weet je zeker dat je deze medewerker wilt verwijderen?')">
        <i class="bi bi-trash-fill"></i>
    </a>
</td>

                            </tr> 
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Geen medewerkers gevonden.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-2"></div>
    </div>

    <div id="footer"></div>
</div>

<script src="/footer/footer.js"></script>
<script src="/navbar/navbar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
