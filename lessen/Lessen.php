<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="lessen.css">
  </head>
  
  <body>
    <div id="navbar"></div>
    <?php

    $servername = "localhost";  
    $username = "root";         
    $password = "";            
    $dbname = "FitForFun";      
    
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    
    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }
    
   
    $sql = "SELECT * FROM Les";
    $result = $conn->query($sql);
    
    
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Naam</th><th>Datum</th><th>Tijd</th><th>Min Aantal Personen</th><th>Max Aantal Personen</th><th>Beschikbaarheid</th><th>Is Actief</th><th>Opmerking</th><th>Datumaangemaakt</th><th>Datumgewijzigd</th></tr>";
        
      
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Naam"] . "</td>
                    <td>" . $row["datum"] . "</td>
                    <td>" . $row["tijd"] . "</td>
                    <td>" . $row["MinAantalPersonen"] . "</td>
                    <td>" . $row["MaxAantalPersonen"] . "</td>
                    <td>" . $row["Beschikbaarheid"] . "</td>
                    <td>" . ($row["Isactief"] ? 'Ja' : 'Nee') . "</td>
                    <td>" . $row["Opmerking"] . "</td>
                    <td>" . $row["Datumaangemaakt"] . "</td>
                    <td>" . $row["Datumgewijzigd"] . "</td>
                  </tr>";
        }
        
      
        echo "</table>";
    } else {
        echo "Geen resultaten gevonden.";
    }
    
  
    $conn->close();
    ?>
    <div id="footer"></div>
    <script src="/footer/footer.js"></script>
    <script src="/navbar/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>