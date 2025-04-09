<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Toevoegen</title>
    <link href="lessen.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>
<div class="form-container">
    <h3 class="text-center mb-3">Les Toevoegen</h3>
    <form action="addlessen.php" method="POST">
        <div class="mb-3">
            <label for="naam" class="form-label">Naam</label>
            <input type="text" id="naam" name="naam" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="prijs" class="form-label">Prijs (€)</label>
            <input type="number" id="prijs" name="prijs" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="datum" class="form-label">Datum</label>
            <input type="date" id="datum" name="datum" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tijd" class="form-label">Tijd</label>
            <input type="time" id="tijd" name="tijd" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="duur" class="form-label">Duur (minuten)</label>
            <input type="number" id="duur" name="duur" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="min_personen" class="form-label">Min. Personen</label>
            <input type="number" id="min_personen" name="min_personen" class="form-control" min="3" max="9" required>
        </div>

        <div class="mb-3">
            <label for="max_personen" class="form-label">Max. Personen</label>
            <input type="number" id="max_personen" name="max_personen" class="form-control" min="3" max="9" required>
        </div>

        <div class="mb-3">
            <label for="beschikbaarheid" class="form-label">Beschikbaarheid</label>
            <select id="beschikbaarheid" name="beschikbaarheid" class="form-control" required>
                <option value="Beschikbaar">Beschikbaar</option>
                <option value="Vol">Vol</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="opmerking" class="form-label">Opmerking</label>
            <textarea id="opmerking" name="opmerking" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-register">Les Toevoegen</button>
    </form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $duur = $_POST['duur'];
    $min_personen = $_POST['min_personen'];
    $max_personen = $_POST['max_personen'];
    $beschikbaarheid = $_POST['beschikbaarheid'];
    $opmerking = $_POST['opmerking'];
    $is_actief = 1; 
    $datum_aangemaakt = date('Y-m-d H:i:s');
    $datum_gewijzigd = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO Lessen (naam, prijs, datum, tijd, MinAantalPersonen, MaxAantalPersonen, Beschikbaarheid, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssiiissss", $naam, $prijs, $datum, $tijd, $min_personen, $max_personen, $beschikbaarheid, $is_actief, $opmerking, $datum_aangemaakt, $datum_gewijzigd);

    if ($stmt->execute()) {
        header("Location: lessen.php");
        exit();
    } else {
        echo "Fout bij toevoegen: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
