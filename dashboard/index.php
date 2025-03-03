<?php

include('config/config.php');

$dsn = "mysql:host=$dbHost; dbname=$dbName; charset=UTF8";

$pdo = new PDO($dsn, $dbUser, $dbPass);

$sql = "SELECT AVE.Id
               ,AVE.Naam
               ,AVE.Datum
               ,AVE.Tijd
               ,AVE.MinAantalPersonen
               ,AVE.MaxAantalPersonen
               ,AVE.Beschikbaarheid
               ,AVE.Isactief
               ,AVE.Opmerking
               ,AVE.Datumaangemaakt
               ,AVE.Datumgewijzigd
        FROM Les AS AVE
        ORDER BY AVE.Datum DESC";

$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!doctype html>
<html lang="nl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Overzicht Geplande Lessen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="dashboard.css">
  </head>
  <body>
    <div class="container mt-3">  
<h1>Management dashboard</h1>
      <div class="row">
        <div class="col-1"></div>
        <div class="col-10 text-primary"><h3>Overzicht ingeplande lessen</h3></div>
        <div class="col-1"></div>
      </div>

      <div class="row my-1">
        <div class="col-1"></div>
        <div class="col-10">
          Invoegen nieuwe les: <a href="create.php"><i class="bi bi-plus-square-fill text-danger"></i></a>
        </div>
        <div class="col-1"></div>
      </div>

      <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
          <table class="table table-hover">
            <thead>
                <th>Naam Les</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Min. Personen</th>
                <th>Max. Personen</th>
                <th>Beschikbaarheid</th>
                <th>Opmerking</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <tbody>
              <?php foreach($result as $les) : ?>
                      <tr>
                        <td><?= $les->Naam ?></td>
                        <td><?= $les->Datum ?></td>
                        <td><?= $les->Tijd ?></td>
                        <td><?= $les->MinAantalPersonen ?></td>
                        <td><?= $les->MaxAantalPersonen ?></td>
                        <td><?= $les->Beschikbaarheid ?></td>
                        <td><?= $les->Opmerking ?></td>
                        <td class="text-center ">
                          <a href="update.php?Id=<?= $les->Id; ?>" class="text-primary">
                            <i class="bi bi-pencil-square"></i> 
                          </a>                            </td>
                        <td class="text-center">
                          <a href="delete.php?Id=<?= $les->Id; ?>" class="text-danger">
                            <i class="bi bi-x-square-fill"></i>
                          </a>                          
                        </td>
                      </tr> 
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="col-1"></div>
      </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
