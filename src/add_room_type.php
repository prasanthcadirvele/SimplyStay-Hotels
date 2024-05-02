<?php

require_once '../repository/DBManagerDirecteur.php';

session_start();

$dbManagerDirecteur = new DBManagerDirecteur();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dbManagerDirecteur->insertRoomType($_POST['room_type']);
    header('Location: room_list.php');
}



if (!isset($_SESSION['username']) || !$_SESSION['user_logged_in']) {
    header('Location: login.php');
    exit();
}

if(!$_SESSION['user_type']=='admin'){
    header('Location: login.php');
    exit();
}


$room_types = $dbManagerDirecteur->getRoomTypes();

?>

<!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <title>Hotel Management - Ajouter une Chambre</title>
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
                        <h3>Add a room Type</h3>
                        <div class="card">

                            <form class="form-card" action="add_room_type.php" method="post">
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Room Type<span class="text-danger"> *</span></label>
                                        <input type="text" id="room_type" name="room_type" required>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-3">
                                        <button type="submit" class="btn-block" style="background-color: #E3B04B; color: white">Add Room Type</button>
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

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>

        </body>

        </html>
