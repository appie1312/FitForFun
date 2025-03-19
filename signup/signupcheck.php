<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voornaam = trim($_POST["voornaam"]);
    $tussenvoegsel = trim($_POST["tussenvoegsel"]);
    $achternaam = trim($_POST["achternaam"]);
    $gebruikersnaam = trim($_POST["gebruikersnaam"]);
    $wachtwoord = $_POST["wachtwoord"];
    $tweedewachtwoord = $_POST["tweedewachtwoord"];

    if (empty($voornaam) || empty($achternaam) || empty($gebruikersnaam) || empty($wachtwoord)) {
        die("Vul alle verplichte velden in.");
    }

    // Voorbeeld waarbij hardcoded waarden zijn toegevoegd voor de NULL- en NOW-velden
    $isIngelogd = 0;  // Gebruiker is niet ingelogd bij registratie
    $ingelogd = 0;
    $uitgelogd = 1;
    $isActief = 1;
    $datumaangemaakt = date("Y-m-d H:i:s");  // Actuele datum en tijd
    $datumgewijzigd = $datumaangemaakt;

    // Bereid de SQL-query voor
    $stmt = $conn->prepare("INSERT INTO Gebruiker 
        (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Ingelogd, Uitgelogd, Isactief, Datumaangemaakt, Datumgewijzigd) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind de juiste parameters (6 in totaal)
    $stmt->bind_param("sssssssssss", $voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $wachtwoord, 
                      $isIngelogd, $ingelogd, $uitgelogd, $isActief, $datumaangemaakt, $datumgewijzigd);

    // Voer de query uit
    if ($stmt->execute()) {
        echo "<script>alert('Registratie succesvol! Je kunt nu inloggen.'); window.location.href='/login/login.php';</script>";
    } else {
        echo "Fout bij registratie: " . $stmt->error;
    }

    // Sluit de statement en de verbinding
    $stmt->close();
}

$conn->close();
?>
