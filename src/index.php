<?php

require_once '../repository/DBManager.php';

session_start();

$dbManager = new DBManager();

$room = $dbManager->getAllRoom();  // Modification ici pour récupérer les chambres
$room = array_slice($room, 0, 3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>SimpleStay Hotel</title>  <!-- Modification ici pour le titre -->
    <link href="../css/styles.css" rel="stylesheet"/>
</head>
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg" style="background-color: #E3B04B; color: black;">
    <div class="container px-5">
        <a class="navbar-brand" href="index.php"> <img src="../images/symbol2.png" alt="Logo SimpleStay Hotel" height="30" style="vertical-align: top;">SimpleStay Hotels</a> <!-- Modification ici pour le titre -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="room_list.php">Les Chambres</a></li> <!-- Modification ici pour le lien -->
                <?php
                if (isset($_SESSION['username']) && isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
                    echo '<li class="nav-item"><a class="nav-link" href="mesreservations.php">Mes Réservations</a></li>';
                    // Add Rooms and Personnel sections for admin
                    if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                        echo '<li class="nav-item"><a class="nav-link" href="add_room.php">Ajouter une Chambre</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="personnel_list.php">Personnel</a></li>';
                    }
                    echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                } else {
                    echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                }
                ?>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content-->
<div class="container px-4 px-lg-5">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="../images/index.jpg"
                                   style="max-width: 100%; max-height: 100%" alt="Index Image"/></div>
        <div class="col-lg-5">
            <h1 class="font-weight-light">Room Booking</h1>  <!-- Modification ici pour le titre -->
            <p>Notre plateforme de réservation de chambres vous offre une expérience utilisateur simple et pratique.
                Réservez votre chambre en quelques clics et planifiez votre séjour sans effort.</p>
            <a class="btn btn-primary" href="room_list.php" style="background-color: #215294">Réserver Maintenant</a>  <!-- Modification ici pour le lien -->
        </div>
    </div>
    <!-- Call to Action-->
    <div class="card text-white bg-secondary my-5 py-1 text-center">
        <div class="card-body"><p class="text-white m-0">Explorez notre plateforme conviviale pour trouver les
                meilleurs chambres et planifier votre séjour.</p></div>
    </div>
    <!-- Content Row-->
    <div class="row gx-4 gx-lg-5">
        <?php
        foreach ($room as $room) {  // Modification ici pour les chambres
            ?>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $room->getName() ?></h2>
                        <p class="card-text">
                            <?php echo $room->getDescription() ?>  <!-- Modification ici pour la description -->
                        </p>
                        <p>Prix par nuit: <?php echo $room->getPricePerNight() ?> EUR</p>  <!-- Modification ici pour le prix -->
                    </div>
                    <div class="card-footer"><a class="btn btn-sm" style="background-color: #215294; color: white"
                                                href="reservation.php?room_id=<?php echo $room->getId() ?>">Réserver</a>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="../js/scripts.js"></script>
</body>
</html>

