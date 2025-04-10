<?php
session_start();
date_default_timezone_set('Europe/Amsterdam');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "FitForFun";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$errors = [];

// Check of form verzonden is
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Gegevens ophalen
    $naam = trim($_POST['naam'] ?? '');
    $prijs = trim($_POST['prijs'] ?? '');
    $datum = trim($_POST['datum'] ?? '');
    $tijd = trim($_POST['tijd'] ?? '');
    $duur = trim($_POST['duur'] ?? '');
    $min_personen = trim($_POST['min_personen'] ?? '');
    $max_personen = trim($_POST['max_personen'] ?? '');
    $beschikbaarheid = trim($_POST['beschikbaarheid'] ?? '');
    $opmerking = trim($_POST['opmerking'] ?? '');

    // Validatie
    if (empty($naam)) $errors[] = "Naam is verplicht.";
    if (empty($prijs)) $errors[] = "Prijs is verplicht.";
    if (empty($datum)) $errors[] = "Datum is verplicht.";
    if (empty($tijd)) $errors[] = "Tijd is verplicht.";
    if (empty($duur)) $errors[] = "Duur is verplicht.";
    if (empty($min_personen)) $errors[] = "Minimaal aantal personen is verplicht.";
    if (empty($max_personen)) $errors[] = "Maximaal aantal personen is verplicht.";
    if (empty($beschikbaarheid)) $errors[] = "Beschikbaarheid is verplicht.";

    // Als geen errors → insert
    if (empty($errors)) {
        $is_actief = 1;
        $datum_aangemaakt = date('Y-m-d H:i:s');
        $datum_gewijzigd = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO Lessen (naam, prijs, datum, tijd, MinAantalPersonen, MaxAantalPersonen, Beschikbaarheid, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssiiissss", $naam, $prijs, $datum, $tijd, $min_personen, $max_personen, $beschikbaarheid, $is_actief, $opmerking, $datum_aangemaakt, $datum_gewijzigd);

        if ($stmt->execute()) {
            header("Location: lessen.php");
            exit;
        } else {
            $errors[] = "Fout bij toevoegen: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Toevoegen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

<h3>Les Toevoegen</h3>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <div class="mb-3">
        <label>Naam</label>
        <input type="text" name="naam" class="form-control" value="<?= htmlspecialchars($_POST['naam'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label>Prijs (€)</label>
        <input type="number" step="0.01" name="prijs" class="form-control" value="<?= htmlspecialchars($_POST['prijs'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label>Datum</label>
        <input type="date" name="datum" class="form-control" value="<?= htmlspecialchars($_POST['datum'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label>Tijd</label>
        <input type="time" name="tijd" class="form-control" value="<?= htmlspecialchars($_POST['tijd'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label>Duur (minuten)</label>
        <input type="number" name="duur" class="form-control" value="<?= htmlspecialchars($_POST['duur'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label>Min. Personen</label>
        <input type="number" name="min_personen" class="form-control" min="3" max="9" value="<?= htmlspecialchars($_POST['min_personen'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label>Max. Personen</label>
        <input type="number" name="max_personen" class="form-control" min="3" max="9" value="<?= htmlspecialchars($_POST['max_personen'] ?? '') ?>">
    </div>

    <div class="mb-3">
        <label>Beschikbaarheid</label>
        <select name="beschikbaarheid" class="form-control">
            <option value="">-- Kies een optie --</option>
            <option value="Beschikbaar" <?= (($_POST['beschikbaarheid'] ?? '') == 'Beschikbaar') ? 'selected' : '' ?>>Beschikbaar</option>
            <option value="Vol" <?= (($_POST['beschikbaarheid'] ?? '') == 'Vol') ? 'selected' : '' ?>>Vol</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Opmerking</label>
        <textarea name="opmerking" class="form-control"><?= htmlspecialchars($_POST['opmerking'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-danger">Les Toevoegen</button>
</form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
