<?php
include('loginconfig.php');
$username = $_POST['gebruikersnaam'];
$password = $_POST['password'];
$username = stripcslashes($username);
$password = stripcslashes($password);
$username = mysqli_real_escape_string($con , $username);
$password = mysqli_real_escape_string($con , $password);
$sql = "select * from Gebruiker where Gebruikersnaam = '$username' and Wachtwoord = '$password'" ;
$result = mysqli_query($con , $sql);
$row = mysqli_fetch_array($result , MYSQLI_ASSOC);
$count = mysqli_num_rows($result);
if($count == 1){
echo "<script>
window.location.assign('suc.html');
</script>";
}
else{
header("Location: failed.html");
exit;
}
?>