<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registreren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/login/login.css">
</head>

<body>
    <div id="navbar"></div>

    <div class="container my-5">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <h1 class="my-5">Registreren</h1>
                <form id="signupForm" action="signupcheck.php" method="POST">

                    <label for="voornaam" class="form-label">Voornaam</label>
                    <input type="text" class="form-control" id="voornaam" name="voornaam" required>

                    <label for="tussenvoegsel" class="form-label">Tussenvoegsel (optioneel)</label>
                    <input type="text" class="form-control" id="tussenvoegsel" name="tussenvoegsel">

                    <label for="achternaam" class="form-label">Achternaam</label>
                    <input type="text" class="form-control" id="achternaam" name="achternaam" required>

                    <label for="gebruikersnaam" class="form-label">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" required>

                    <label for="wachtwoord" class="form-label">Wachtwoord</label>
                    <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
                    
                    <button class="btn knoppen w-30 my-3" type="submit">Registreren</button>
                </form>

                <!-- Weergave van foutmelding -->
                <?php if (!empty($foutmelding)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $foutmelding; ?>
                    </div>
                <?php endif; ?>

                <hr>
                <p>Heb je al een account? <a href="/login/login.php">Inloggen</a></p>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <div id="footer"></div>

    <script src="/FitForFun/login/script.js"></script>
    <script src="/footer/footer.js"></script>
    <script src="/navbar/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
