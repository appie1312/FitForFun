<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "FitForFun";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


if (isset($_GET['les_id'])) {
    
    $les_Id = (int) $_GET['les_id']; 

    if ($les_Id <= 0) {
        echo "Ongeldig les ID.";
        exit;
    }

  
    $sql = "DELETE FROM Lessen WHERE les_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Fout bij voorbereiden van de query: " . $conn->error;
        exit;
    }

  
    $stmt->bind_param("i", $les_Id);


    if ($stmt->execute()) {

        header("Location: lessen.php");
        exit;
    } else {
        echo "Fout bij het verwijderen van de les: " . $stmt->error;
    }

  
    $stmt->close();
} else {
    echo "Geen les ID opgegeven.";
}


$conn->close();
?>
