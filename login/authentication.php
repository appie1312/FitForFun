<?php
session_start();
include('loginconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['gebruikersnaam']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "SELECT * FROM Gebruiker WHERE Gebruikersnaam = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row && $password == $row['Wachtwoord']) {
        $_SESSION['gebruikersnaam'] = $username;
        $_SESSION['logged_in'] = true;

        $updateSql = "UPDATE Gebruiker SET IsIngelogd = 1, Ingelogd = NOW() WHERE Gebruikersnaam = ?";
        $updateStmt = mysqli_prepare($con, $updateSql);
        mysqli_stmt_bind_param($updateStmt, "s", $username);
        mysqli_stmt_execute($updateStmt);

        header("Location: /home/index.html");
        exit;
    } else {
        $_SESSION['error'] = "Onjuiste gebruikersnaam of wachtwoord.";
        header("Location: login.php");
        exit;
    }
}

mysqli_close($con);
?>
