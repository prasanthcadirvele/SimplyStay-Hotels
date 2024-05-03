<?php

require_once '../repository/DBManagerDirecteur.php';

session_start();

$dbManagerDirecteur = new DBManagerDirecteur();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $dbManagerDirecteur->archiveReservation($reservation_id);
    header('Location: archived_reservation.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Hotel Management - Réservations Archivées</title>
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg" style="background-color: #E3B04B; color: black;">
        <div class="container px-5">
            <a class="navbar-brand" href="index.php"> <img src="../images/symbol2.png" alt="Logo SimpleStay Hotel" height="30" style="vertical-align: top;"> SimpleStay Hotels</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php
                    if(isset($_SESSION['username']) && isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']){
                        echo '<li class="nav-item"><a class="nav-link" href="room_list.php">Liste des Chambres</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="my_reservation.php">Mes Réservations</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="archived_reservation.php">Réservations Archivées</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                        if($_SESSION['user_type']=='admin'){
                            echo '<li class="nav-item"><a class="nav-link" href="users.php">Liste des Utilisateurs</a></li>';
                        }
                    }else{
                        header('location: login.php');
                        exit(0);
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="mt-4 row justify-content-center">
            <div class="col-md-8">
                <h2>Réservations Archivées</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <?php if($_SESSION['user_type']=='admin'){ ?>
                                <th>Client Name</th>
                            <?php } ?>
                            <th>Nom de la Chambre</th>
                            <th>Prix par Nuit</th>
                            <th>Réservation Debut</th>
                            <th>Réservation Fin</th>
                            <th>Prix Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Fetch archived reservations from the database
                    $archivedReservations = []; // Assuming you have a method to fetch archived reservations
                    // Replace the line above with your actual method call to fetch archived reservations

                    if ($archivedReservations != null) {
                        foreach ($archivedReservations as $reservation) {
                            $start_date = new DateTime($reservation['start_date']);
                            $end_date = new DateTime($reservation['end_date']);

                            // Calculate the difference between the dates
                            $interval = $start_date->diff($end_date);

                            // Get the difference in days
                            $number_of_days = $interval->days;
                            ?>
                            <tr>
                                <?php if ($_SESSION['user_type'] == 'admin') { ?>
                                    <td><?php echo $reservation['user_firstname'] ?> <?php echo $reservation['user_lastname'] ?></td>
                                <?php } ?>
                                <td><?php echo $reservation['room_type']; ?></td>
                                <td><?php echo $reservation['price_per_night']; ?></td>
                                <td><?php echo $reservation['start_date']; ?></td>
                                <td><?php echo $reservation['end_date']; ?></td>
                                <td><?php echo $number_of_days * $reservation['price_per_night']; ?></td>
                                <td>
                                    <!-- No need for forms, since we are not performing any actions on archived reservations -->
                                    <!-- You can add any additional action buttons if needed -->
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                // Display a message if there are no archived reservations
                                echo "<tr><td colspan='7'>Aucune réservation archivée trouvée.</td></tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>
</html>
