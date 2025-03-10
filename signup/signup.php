<?php
include('signupconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = trim($_POST["voornaam"]);
    $tussenvoegsel = trim($_POST["tussenvoegsel"]);
    $achternaam = trim($_POST["achternaam"]);
    $gebruikersnaam = trim($_POST["gebruikersnaam"]);
    $wachtwoord = $_POST["wachtwoord"];

    if (empty($voornaam) || empty($achternaam) || empty($gebruikersnaam) || empty($wachtwoord)) {
        die("Vul alle verplichte velden in.");
    }

    $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Gebruiker 
        (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Ingelogd, Uitgelogd, Isactief, Datumaangemaakt, Datumgewijzigd) 
        VALUES (?, ?, ?, ?, ?, 0, NULL, NULL, 1, NOW(), NOW())");
    $stmt->bind_param("sssssssss", $voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $hashedPassword, $isIngelogd, $ingelogd, $uitgelogd, $isActief);

    if ($stmt->execute()) {
        echo "<script>alert('Registratie succesvol! Je kunt nu inloggen.'); window.location.href='login.html';</script>";
    } else {
        echo "Fout bij registratie: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
