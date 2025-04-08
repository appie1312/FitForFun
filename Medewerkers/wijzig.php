<?php
include('config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id = $_GET['id'] ?? null;
if (!$id) {
    die("Geen medewerker-ID opgegeven.");
}


$stmt = $pdo->prepare("SELECT * FROM Medewerker WHERE Id = :id");
$stmt->execute([':id' => $id]);
$medewerker = $stmt->fetch();

if (!$medewerker) {
    die("Medewerker niet gevonden.");
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $VoorNaam = $_POST['VoorNaam'] ?? '';
    $Tussenvoegsel = $_POST['Tussenvoegsel'] ?? '';
    $Achternaam = $_POST['Achternaam'] ?? '';
    $Nummer = $_POST['Nummer'] ?? '';
    $Medewerkersoort = $_POST['Medewerkersoort'] ?? '';
    $IsActief = isset($_POST['IsActief']) ? 1 : 0;


    $check = $pdo->prepare("SELECT Id FROM Medewerker WHERE Nummer = :nummer AND Id != :id");
    $check->execute([
        ':nummer' => $Nummer,
        ':id' => $id
    ]);
    $existing = $check->fetch();

    if ($existing) {
        $error = "Nummer bestaat al bij een andere medewerker. Kies een ander nummer.";
    } else {

        $sql = "UPDATE Medewerker SET 
                    VoorNaam = :VoorNaam,
                    Tussenvoegsel = :Tussenvoegsel,
                    Achternaam = :Achternaam,
                    Nummer = :Nummer,
                    Medewerkersoort = :Medewerkersoort,
                    IsActief = :IsActief
                WHERE Id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':VoorNaam' => $VoorNaam,
            ':Tussenvoegsel' => $Tussenvoegsel,
            ':Achternaam' => $Achternaam,
            ':Nummer' => $Nummer,
            ':Medewerkersoort' => $Medewerkersoort,
            ':IsActief' => $IsActief,
            ':id' => $id
        ]);

        header("Location: medewerkers.php");
        exit;
    }


    $medewerker['VoorNaam'] = $VoorNaam;
    $medewerker['Tussenvoegsel'] = $Tussenvoegsel;
    $medewerker['Achternaam'] = $Achternaam;
    $medewerker['Nummer'] = $Nummer;
    $medewerker['Medewerkersoort'] = $Medewerkersoort;
    $medewerker['IsActief'] = $IsActief;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wijzig Medewerker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="text-primary">Wijzig Medewerker</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Voornaam</label>
            <input type="text" class="form-control" name="VoorNaam" value="<?= htmlspecialchars($medewerker['VoorNaam'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tussenvoegsel</label>
            <input type="text" class="form-control" name="Tussenvoegsel" value="<?= htmlspecialchars($medewerker['Tussenvoegsel'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Achternaam</label>
            <input type="text" class="form-control" name="Achternaam" value="<?= htmlspecialchars($medewerker['Achternaam'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nummer</label>
            <input type="number" class="form-control" name="Nummer" value="<?= htmlspecialchars($medewerker['Nummer'] ?? '') ?>" required min="1">
        </div>
        <div class="mb-3">
            <label class="form-label">Medewerkersoort</label>
            <select class="form-control" name="Medewerkersoort" required>
                <option value="Manager" <?= ($medewerker['Medewerkersoort'] ?? '') === 'Manager' ? 'selected' : '' ?>>Manager</option>
                <option value="Beheerder" <?= ($medewerker['Medewerkersoort'] ?? '') === 'Beheerder' ? 'selected' : '' ?>>Beheerder</option>
                <option value="DiskMedewerker" <?= ($medewerker['Medewerkersoort'] ?? '') === 'DiskMedewerker' ? 'selected' : '' ?>>DiskMedewerker</option>
            </select>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="IsActief" <?= ($medewerker['IsActief'] ?? 0) ? 'checked' : '' ?>>
            <label class="form-check-label">Actief</label>
        </div>
        <button type="submit" class="btn btn-success">Opslaan</button>
        <a href="medewerkers.php" class="btn btn-secondary">Annuleren</a>
    </form>
</div>
</body>
</html>
