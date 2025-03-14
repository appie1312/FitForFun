
<?php session_start(); ?>
<link rel="stylesheet" href="navbar.css">

<nav class="z-1 navbar navbar-expand-lg">
    <div class="container-fluid position-fixed top-0">
        <a href="/home/index.html">
            <img src="/navbar/figma.png" alt="Icon" class="me-2 mt-2" width="40" height="40">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/home/index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/lessen/Lessen.php">Lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/Medewerkers/medewerkers.php">Medewerkers</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/navbar/pngegg.png" alt="Icon" class="me-2" width="30" height="30">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/navbar/logout.php">Loguit</a>
                    </li>
                <?php else: ?>
                            <li><a class="dropdown-item" href="/login/login.php">Inloggen</a></li>
                            <li><a class="dropdown-item" href="/signup/signup.php">Registreren</a></li>
                        
                <?php endif; ?>
                </ul>
                  </li>
            </ul>
        </div>
    </div>
</nav>
