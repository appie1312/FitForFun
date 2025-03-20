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

$currentYear = date('Y');
$currentMonth = date('m');

$lessen = [];
$lessenResult = $conn->query("SELECT * FROM Lessen");

if ($lessenResult) {
    while ($lessenRow = $lessenResult->fetch_object()) {
        $lessen[] = $lessenRow;
    }
}

$conn->close();
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Lessen.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div id="navbar"></div>
    <div class="container mt-5">
        <h1 class="text-center">Agenda - <?= date('F Y'); ?></h1>

        <div class="container mt-3">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">        
                    <h3>Lessen</h3>
                    </div>
                <div class="col-1"></div>
            </div>

            <div class="row my-2">
            <div class="col-2"></div>
            <div class="col-8">
                Invoegen nieuwe Les: 
                <a href="addlessen.php"><i class="bi bi-plus-square-fill text-danger"></i></a>
                </div>
            <div class="col-2"></div>
        </div>

            <!-- begin tabel -->
            <a href="addlessen.php">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>naam</th>
                                <th>tijd</th>
                                <th>prijs</th>
                                <th>datum</th>
                                <th>tijdduur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($lessen as $les) : ?>
                                <tr>
                                    <td><?= $les->naam ?></td>
                                    <td><?= $les->tijd ?></td>
                                    <td><?= $les->prijs ?></td>
                                    <td><?= $les->datum ?></td>
                                    <td><?= $les->tijdduur ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-1"></div>
            </div>
        </div>

        <script src="/footer/footer.js"></script>
        <script src="/navbar/navbar.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
