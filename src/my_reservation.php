<?php

require_once '../repository/DBManagerClient.php';
require_once '../repository/DBManagerDirecteur.php';

session_start();

$dbManagerClient = new DBManagerClient();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $dbManagerClient->deleteReservation($reservation_id);
    header('Location: my_reservation.php');
}

if (!isset($_SESSION['username']) || !$_SESSION['user_logged_in']) {
    header('Location: login.php');
    exit();
}

if($_SESSION['user_type']=='admin'){
    $dbManagerDirecteur = new DBManagerDirecteur();
    $reservations = $dbManagerDirecteur->getReservations();
    $navContent = "Reservations en cours";
}else{
    $reservations = $dbManagerClient->getReservationsByUser($_SESSION['user_id']);
    $navContent = "Mes Reservations";
}

// Retrieve reservations for the current user



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Hotel Management - Mes Réservations</title>
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
						echo '<li class="nav-item"><a class="nav-link" href="my_reservation.php">'.$navContent.'</li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                        if($_SESSION['user_type']=='admin'){
                            echo '<li class="nav-item"><a class="nav-link" href="archived_reservation.php">Réservation Archivées</a></li>';
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
		</div></nav>

    <div class="container">
        <div class="mt-4 row justify-content-center">
            <div class="col-md-8">
                <h2><?php echo $navContent ?></h2>
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
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($reservations != null) {
                            foreach ($reservations as $reservation) : ?>
                            <?php
                                $start_date = new DateTime($reservation->getReservationDebut());
                                $end_date = new DateTime($reservation->getReservationFin());

                                // Calculate the difference between the dates
                                $interval = $start_date->diff($end_date);

                                // Get the difference in days
                                $number_of_days = $interval->days;

                                ?>

                                <tr>
                                    <?php if($_SESSION['user_type']=='admin'){ ?>
                                        <td><?php echo $reservation->getUser()->getFirstname()?> <?php echo $reservation->getUser()->getLastname()?></td>
                                    <?php } ?>
                                    <td><?php echo $reservation->getRoom()->getType(); ?></td>
                                    <td><?php echo $reservation->getRoom()->getPricePerNight(); ?></td>
                                    <td><?php echo $reservation->getReservationDebut(); ?></td>
                                    <td><?php echo $reservation->getReservationFin(); ?></td>
                                    <td><?php echo $number_of_days * $reservation->getRoom()->getPricePerNight(); ?></td>
                                    <td>
                                        <form id="deleteForm" action="my_reservation.php" method="post">
                                            <!-- Hidden input for reservation_id -->
                                            <input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation->getId() ?>">
                                            <!-- Delete icon -->
                                            <span class="delete-icon" onclick="document.getElementById('deleteForm').submit();">&#10060;</span>
                                        </form>
                                        <form id="archiveForm" action="my_reservation.php" method="post">
                                            <!-- Hidden input for reservation_id -->
                                            <input type="hidden" name="reservation_id" id="reservation_id" value="<?php echo $reservation->getId() ?>">
                                            <!-- Archive button -->
                                            <button type="submit" class="archive-button" onclick="archiveReservation(<?php echo $reservation->getId(); ?>);">Archive</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php endforeach;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
    function archiveReservation(reservationId) {
        // Send an AJAX request to the server to archive the reservation
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'archived_reservation.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Success - reload the page to reflect changes
                    window.location.reload();
                } else {
                    // Error handling
                    console.error('Error archiving reservation:', xhr.responseText);
                }
            }
        };
        xhr.send('reservation_id=' + reservationId);
    }
    </script>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="../js/scripts.js"></script>
</body>

</html>

