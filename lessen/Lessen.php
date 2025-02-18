<?php
session_start();
date_default_timezone_set('Europe/Amsterdam');

// Databaseverbinding
$servername = "localhost";  
$username = "root";         
$password = "";            
$dbname = "FitForFun";      

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer databaseverbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Kalenderinstellingen
$currentYear = date('Y');
$currentMonth = date('m');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
$firstDayOfMonth = date('N', strtotime("$currentYear-$currentMonth-01"));

$timeSlots = ["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];

// Reservering opslaan
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date'], $_POST['time'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Controleer of het tijdslot al bezet is
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE date = ? AND time = ?");
    $stmt->bind_param("ss", $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Tijdslot opslaan in de database
        $stmt = $conn->prepare("INSERT INTO reservations (date, time) VALUES (?, ?)");
        $stmt->bind_param("ss", $date, $time);
        if ($stmt->execute()) {
            $message = "Reservering succesvol voor $date om $time!";
        } else {
            $message = "Er is iets misgegaan. Probeer opnieuw.";
        }
    } else {
        $message = "Dit tijdslot is al gereserveerd!";
    }
}

// Ophalen van gereserveerde tijdsloten
$reservations = [];
$result = $conn->query("SELECT date, time FROM reservations");
while ($row = $result->fetch_assoc()) {
    $reservations[$row['date']][] = $row['time'];
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
    <style>
        table { width: 100%; border-collapse: collapse; }
        td, th { border: 1px solid #ddd; padding: 10px; text-align: center; cursor: pointer; }
        .reserved { background-color: red; color: white; }
        .available { background-color: green; color: white; }
        .modal { display: none; position: fixed; left: 50%; top: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border: 1px solid black; }
    </style>
</head>
<body class="container mt-4">

    <div id="navbar"></div>

    <h1 class="text-center">Agenda - <?php echo date('F Y'); ?></h1>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

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

    <div id="modal" class="modal">
        <h2 id="selected-date"></h2>
        <form method="POST">
            <input type="hidden" name="date" id="date-input">
            <?php foreach ($timeSlots as $slot): ?>
                <button type="submit" name="time" value="<?php echo $slot; ?>" 
                    class="btn <?php echo isset($reservations[$date]) && in_array($slot, $reservations[$date]) ? 'btn-danger' : 'btn-success'; ?> m-1"
                    <?php echo isset($reservations[$date]) && in_array($slot, $reservations[$date]) ? 'disabled' : ''; ?>>
                    <?php echo $slot; ?>
                </button>
            <?php endforeach; ?>
        </form>
        <button class="btn btn-secondary mt-2" onclick="closeModal()">Sluiten</button>
    </div>

    <div id="footer"></div>

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

    <script src="/footer/footer.js"></script>
    <script src="/navbar/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

