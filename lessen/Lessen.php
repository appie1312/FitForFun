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
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
$firstDayOfMonth = date('N', strtotime("$currentYear-$currentMonth-01"));

$lessons = [];
$lessonResult = $conn->query("SELECT * FROM Lessen");

if ($lessonResult) {
    while ($lessonRow = $lessonResult->fetch_assoc()) {
        $lessons[] = $lessonRow;
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
</head>
<body>
    <div id="navbar"></div>
    <div class="container mt-5">
        <h1 class="text-center">Agenda - <?php echo date('F Y'); ?></h1>

        <?php if (!empty($message)): ?>
            <div id="reservation-message" class="alert alert-info"> <?php echo $message; ?> </div>
        <?php endif; ?>

        <div class="row">
            <?php foreach ($lessons as $les): ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $les['les_naam']; ?></h5>
                            <p class="card-text"><?php echo $les['beschrijving']; ?></p>
                            <form method="POST">
                                <input type="hidden" name="lesson" value="<?php echo $les['les_id']; ?>">
                                <button type="submit" class="btn btn-primary">Reserveren</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (isset($_POST['lesson'])): ?>
            <div id="calendar-container">
                <table class="table table-bordered">
                    <tr>
                        <?php for ($i = 1; $i <= 7; $i++): ?>
                            <th><?php echo date('D', strtotime("Sunday +{$i} days")); ?></th>
                        <?php endfor; ?>
                    </tr>
                    <tr>
                        <?php 
                        for ($i = 1; $i < $firstDayOfMonth; $i++) {
                            echo "<td></td>";
                        }
                        for ($day = 1; $day <= $daysInMonth; $day++) {
                            $date = "$currentYear-$currentMonth-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                            echo "<td onclick='showTimes(\"$date\")'>$day</td>";
                            if (($day + $firstDayOfMonth - 1) % 7 == 0) {
                                echo "</tr><tr>";
                            }
                        }
                        ?>
                    </tr>
                </table>
            </div>
        <?php endif; ?>

        <div id="modal" class="modal" style="display:none;">
            <h2 id="selected-date"></h2>
            <form method="POST">
                <input type="hidden" name="lesson" id="lesson-input">
                <input type="hidden" name="date" id="date-input">
                <div id="time-slots"></div>
                <button class="btn btn-secondary mt-2" onclick="closeModal()">Sluiten</button>
            </form>
        </div>
    </div>

    <script>
        function showTimes(date) {
            document.getElementById('selected-date').innerText = 'Tijdslots voor ' + date;
            document.getElementById('date-input').value = date;
            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }
    </script>
    
    <div id="footer"></div>
    <script src="/footer/footer.js"></script>
    <script src="/navbar/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
