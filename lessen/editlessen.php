<?php
session_start();
date_default_timezone_set('Europe/Amsterdam');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "FitForFun";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Verbinding mislukt: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die($e->getMessage());
}


if(isset($_GET['les_id'])) {
    $les_id = $_GET['les_id'];
    try {
        $result = $conn->query("SELECT * FROM Lessen WHERE les_id = $les_id");
        if (!$result) {
            throw new Exception("Fout bij ophalen van les: " . $conn->error);
        }
        $les = $result->fetch_object();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}


if(isset($_POST['update'])) {
    $les_id = $_POST['les_id'];
    $naam = $_POST['naam'];
    $tijd = $_POST['tijd'];
    $prijs = $_POST['prijs'];
    $datum = $_POST['datum'];
    $tijdduur = $_POST['tijdduur'];

    try {
        $sql = "UPDATE Lessen 
                SET naam='$naam', tijd='$tijd', prijs='$prijs', datum='$datum', tijdduur='$tijdduur', DatumGewijzigd=NOW()
                WHERE les_id='$les_id'";

        if (!$conn->query($sql)) {
            throw new Exception("Fout bij updaten: " . $conn->error);
        }
        header("Location: Lessen.php");
        exit;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Les bewerken</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>Les bewerken</h2>

<form method="post">
    <input type="hidden" name="les_id" value="<?= $les->les_id ?>">

    Naam:
    <input type="text" name="naam" value="<?= $les->naam ?>" class="form-control mb-2">

    Tijd:
    <input type="time" name="tijd" value="<?= $les->tijd ?>" class="form-control mb-2">

    Prijs:
    <input type="text" name="prijs" value="<?= $les->prijs ?>" class="form-control mb-2">

    Datum:
    <input type="date" name="datum" value="<?= $les->datum ?>" class="form-control mb-2">

    Tijdduur:
    <input type="time" name="tijdduur" value="<?= $les->tijdduur ?>" class="form-control mb-2">

    <button type="submit" name="update" class="btn btn-success">Opslaan</button>
    <a href="Lessen.php" class="btn btn-secondary">Annuleren</a>
</form>

</body>
</html>
