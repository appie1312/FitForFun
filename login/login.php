<?php session_start(); ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/login/login.css">
</head>

<body>
    <div id="navbar"></div>
    <div class="container my-5 ">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <h1 class="my-5">INLOGGEN</h1>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                <?php endif; ?>

                <form name="f1" action="authentication.php" method="POST">
                    <label for="gebruikersnaam" class="form-label">Gebruikersnaam</label>
                    <input type="text" class="form-control" id="gebruikersnaam" placeholder="John Doe" name="gebruikersnaam" required>

                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" id="password" class="form-control" name="password" aria-describedby="passwordHelpBlock" required>

                    <button class="btn btn-primary w-30 my-3 " type="submit">Inloggen</button>
                </form>

                <hr>
                <p class="space">Heeft u geen account? <a href="/signup/signup.php">Aanmelden</a></p>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
                    <div class="spacer"></div>
    <div id="footer"></div>
    <script src="/FitForFun/login/script.js"></script>
    <script src="/footer/footer.js"></script>
    <script src="/navbar/navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
<!-- zorg ervoor dat sessie automtisch stopt na inactiviteit