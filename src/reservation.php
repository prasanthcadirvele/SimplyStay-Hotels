<?php

require_once '../repository/DBManagerClient.php';


session_start();


$dbManagerClient = new DBManagerClient();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reservation_debut = $_POST['reservation_debut'];
    $fin_reservation = $_POST['fin_reservation'];
    $nombre_de_personnes = $_POST['nombre_de_personnes'];
    $room_id = $_POST['room_id'];

    $username = $_SESSION['username'];
    $userId = $_SESSION['user_id'];

    $reservation = $dbManagerClient->makeReservation($room_id, $userId, $reservation_debut, $fin_reservation, $nombre_de_personnes);

    if ($reservation) {
        header('Location: my_reservation.php');
        exit();
    } else {
        $_SESSION['reservation_error'] = "La réservation n'est malheureusement pas possible, car toutes les chambres sont occupées.";
        header('Location: reservation.php?room_id=' . $room_id);
    }
} else {

    if (isset($_GET['room_id'])) {
        $room = $dbManagerClient->getRoomByRoomId($_GET['room_id']);

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <title>Hotel Management - Réservation</title>
            <link href="../css/style.css" rel="stylesheet" />
            <link href="../css/styles.css" rel="stylesheet" />
            <link href="../css/contact.css" rel="stylesheet" />
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
		</div></nav>

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>Réservation</h3>
                        <div class="card">

                            <form class="form-card" action="reservation.php" method="post">
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Début de réservation<span class="text-danger"> *</span></label>
                                        <input type="datetime-local" id="reservation_debut" name="reservation_debut" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Fin de réservation<span class="text-danger"> *</span></label>
                                        <input type="datetime-local" id="fin_reservation" name="fin_reservation" value="<?php echo date('Y-m-d\TH:i'); ?>" onchange="calculateDifference()" required>
                                    </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Nombre d'invités <span class="text-danger"> *</span></label>
                                        <input type="number" id="nombre_de_nuits" name="nombre_de_personnes" placeholder="Nombre de personnes" required>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <input type="hidden" name="room_id" value="<?php echo $_GET['room_id']; ?>">
                                    <div class="form-group col-sm-2">
                                        <input  id="hiddenVal" type="hidden" value="<?php echo $room['price_per_night']; ?>">
                                        <script>
                                            // Define the value to multiply by using PHP
                                            var valueToMultiply = parseFloat(document.getElementById('hiddenVal').value);

                                            function calculateDifference() {
                                                var startDate = new Date(document.getElementById('reservation_debut').value);
                                                var endDate = new Date(document.getElementById('fin_reservation').value);

                                                // Calculate the difference in milliseconds
                                                var differenceInMilliseconds = Math.abs(endDate - startDate);

                                                // Convert milliseconds to days
                                                var differenceInDays = Math.ceil(differenceInMilliseconds / (1000 * 60 * 60 * 24));

                                                // Calculate the result
                                                var result = differenceInDays * valueToMultiply;

                                                console.log(result)

                                                // Display the result
                                                document.getElementById('result').innerHTML = result;
                                            }
                                        </script>

                                        <h6>Prix Total : <span id="result"></span>€</h6>
                                        <button type="submit" class="btn-block" style="background-color: #E3B04B; color: white">Réserver</button>
                                    </div>
                                </div>
                                <?php
                                if (isset($_SESSION['reservation_error'])) {
                                    echo '<p class="text-danger">' . $_SESSION['reservation_error'] . '</p>';
                                    unset($_SESSION['reservation_error']);
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    } else {
        //header('Location: room_list.php');
    }
}
?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>

        </body>

        </html>
