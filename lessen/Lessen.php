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

$timeSlots = ["09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00"];

$message = "";

$lessons = [];
$lessonResult = $conn->query("SELECT * FROM lessons");
while ($lessonRow = $lessonResult->fetch_assoc()) {
    $lessons[] = $lessonRow;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lesson'], $_POST['date'], $_POST['time'])) {
    $lesson = $_POST['lesson'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $stmt = $conn->prepare("SELECT * FROM reservations WHERE date = ? AND time = ? AND lesson_id = ?");
    $stmt->bind_param("ssi", $date, $time, $lesson);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO reservations (date, time, lesson_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $date, $time, $lesson);
        if ($stmt->execute()) {
            $message = "Reservering succesvol voor $date om $time voor de les!";
        } else {
            $message = "Er is iets misgegaan. Probeer opnieuw.";
        }
    } else {
        $message = "Dit tijdslot is al gereserveerd voor deze les!";
    }
}

$reservations = [];
$reservationResult = $conn->query("SELECT date, time, lesson_id FROM reservations");
while ($row = $reservationResult->fetch_assoc()) {
    $reservations[$row['lesson_id']][$row['date']][] = $row['time'];
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
<body class="container mt-4">

    <div id="navbar"></div>

    <h1 class="text-center">Agenda - <?php echo date('F Y'); ?></h1>

    <?php if (!empty($message)): ?>
        <div id="reservation-message" class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" id="lesson-form"> 
        <div class="mb-3">
            <label for="lesson" class="form-label">Kies een les</label>
            <select class="form-select" id="lesson" name="lesson" onchange="loadCalendar()" required>
                <option value="">Selecteer een les</option>
                <?php foreach ($lessons as $lesson): ?>
                    <option value="<?php echo $lesson['id']; ?>"><?php echo $lesson['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <div id="calendar-container" style="display:none;">
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

    <div id="modal" class="modal" style="display:none;">
        <h2 id="selected-date"></h2>
        <form method="POST">
            <input type="hidden" name="lesson" id="lesson-input">
            <input type="hidden" name="date" id="date-input">
            <div id="time-slots">
            </div>
            <button class="btn btn-secondary mt-2" onclick="closeModal()">Sluiten</button>
        </form>
    </div>

   

    <script>
        function loadCalendar() {
            var lesson = document.getElementById('lesson').value;
            if (lesson) {
                document.getElementById('lesson-form').style.display = 'none';
                document.getElementById('calendar-container').style.display = 'block';
                document.getElementById('lesson-input').value = lesson;
            }
        }

        function showTimes(date) {
            document.getElementById('selected-date').innerText = 'Tijdslots voor ' + date;
            document.getElementById('date-input').value = date;

            var lesson = document.getElementById('lesson').value;
            var timeSlotsContainer = document.getElementById('time-slots');
            timeSlotsContainer.innerHTML = ''; 

            var timeSlots = <?php echo json_encode($timeSlots); ?>;
            timeSlots.forEach(function(slot) {
                var isReserved = <?php echo json_encode($reservations); ?>[lesson] && <?php echo json_encode($reservations); ?>[lesson][date] && <?php echo json_encode($reservations); ?>[lesson][date].includes(slot);
                var button = document.createElement('button');
                button.classList.add('btn', isReserved ? 'btn-danger' : 'btn-success', 'm-1');
                button.disabled = isReserved;
                button.innerText = slot;
                button.type = 'submit';
                button.name = 'time';
                button.value = slot;

                timeSlotsContainer.appendChild(button);
            });

            document.getElementById('modal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        <?php if (!empty($message)): ?>
            setTimeout(function() {
                document.getElementById('reservation-message').style.display = 'none';
            }, 5000); 
        <?php endif; ?>
    </script>

<div id="footer"></div>

    <script src="/footer/footer.js"></script>
    <script src="/navbar/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

