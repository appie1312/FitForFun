<?php
//verplichte include
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = trim($_POST["voornaam"]);
    $tussenvoegsel = trim($_POST["tussenvoegsel"]);
    $achternaam = trim($_POST["achternaam"]);
    $gebruikersnaam = trim($_POST["gebruikersnaam"]);
    $wachtwoord = $_POST["wachtwoord"];

    if (empty($voornaam) || empty($achternaam) || empty($gebruikersnaam) || empty($wachtwoord)) {
        die("Vul alle verplichte velden in.");
    }

    $isIngelogd = 0;
    $ingelogd = 0;
    $uitgelogd = 1;
    $isActief = 1;
    $datumaangemaakt = date("Y-m-d H:i:s");
    $datumgewijzigd = $datumaangemaakt;

    $stmt = $conn->prepare("INSERT INTO Gebruiker 
        (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Ingelogd, Uitgelogd, Isactief, Datumaangemaakt, Datumgewijzigd) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssssssss", $voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $wachtwoord, 
                      $isIngelogd, $ingelogd, $uitgelogd, $isActief, $datumaangemaakt, $datumgewijzigd);

    if ($stmt->execute()) {
        echo "<script>alert('Registratie succesvol! Je kunt nu inloggen.'); window.location.href='/login/login.php';</script>";
    } else {
        echo "Fout bij registratie: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>