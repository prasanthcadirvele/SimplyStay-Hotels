<?php
// Include the necessary files
require_once '../repository/DBManagerClient.php';
require_once '../config/DatabaseConfiguration.php';

session_start();

// Define your database connection details here

$dbManagerClient = new DBManagerClient();

// Fetch all rooms
$rooms = $dbManagerClient->getAllRooms();

if($_SESSION['user_type']=='admin'){
    $navContent = "Reservations en cours";
}else{
    $navContent = "Mes Reservations";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room List</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
<!-- Navigation -->

<nav class="navbar navbar-expand-lg" style="background-color: #E3B04B; color: black;">
		<div class="container px-5">
			<a class="navbar-brand" href="index.php"> <img src="../images/symbol2.png" alt="Logo SimpleStay Hotel" height="30" style="vertical-align: top;"> SimpleStay Hotels</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">

					<?php
					if(isset($_SESSION['username']) && isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']){
                        echo '<li class="nav-item"><a class="nav-link" href="room_list.php">Liste des Chambres</a></li>';
						echo '<li class="nav-item"><a class="nav-link" href="my_reservation.php">'.$navContent.'</a></li>';
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

<style>
    /*  Helper Styles */
    body {
        background: #f1f1f1;
    }

    a {
        text-decoration: none;
    }

    /* Card Styles */

    .card-sl {
        border-radius: 8px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .card-image img {
        max-height: 100%;
        max-width: 100%;
        border-radius: 8px 8px 0px 0;
    }

    .card-action {
        position: relative;
        float: right;
        margin-top: -25px;
        margin-right: 20px;
        z-index: 2;
        color: #E26D5C;
        background: #fff;
        border-radius: 100%;
        padding: 15px;
        font-size: 15px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 1px 2px 0 rgba(0, 0, 0, 0.19);
    }

    .card-action:hover {
        color: #fff;
        background: #E26D5C;
        -webkit-animation: pulse 1.5s infinite;
    }

    .card-heading {
        font-size: 18px;
        font-weight: bold;
        background: #fff;
        padding: 10px 15px;
    }

    .card-text {
        padding: 10px 15px;
        background: #fff;
        font-size: 14px;
        color: #636262;
    }

    .card-button {
        display: flex;
        justify-content: center;
        padding: 10px 0;
        width: 100%;
        background-color: #E3B04B;
        color: #fff;
        border-radius: 0 0 8px 8px;
    }

    .card-button:hover {
        text-decoration: none;
        background-color: #000000;
        color: #fff;

    }


    @-webkit-keyframes pulse {
        0% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        70% {
            -moz-transform: scale(1);
            -ms-transform: scale(1);
            -webkit-transform: scale(1);
            transform: scale(1);
            box-shadow: 0 0 0 50px rgba(90, 153, 212, 0);
        }

        100% {
            -moz-transform: scale(0.9);
            -ms-transform: scale(0.9);
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
            box-shadow: 0 0 0 0 rgba(90, 153, 212, 0);
        }
    }
</style>

  <div class="container" style="margin-top:50px;">

      <?php
      if($_SESSION['user_type']=='admin'){
          ?>

      <div class="row">
            <div class="col-md-2">
                <div class="card-sl">
                    <a href="add_room.php" class="card-button"> Ajouter une chambre </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-sl">
                    <a href="add_room_type.php" class="card-button"> Ajouter un type de chambre </a>
                </div>
            </div>
      </div>

      <?php } ?>

        <div class="row" style = "margin-top: 20px;">
            <?php if(isset($rooms)): ?>
                <?php foreach ($rooms as $room): ?>
                    <div class="col-md-3">
                        <div class="card-sl">
                            <div class="card-image">
                                <img
                                    src=<?php echo $room['thumbnail_image'] ?> />
                            </div>

                            <div class="card-heading">
                                <?php echo $room['room_type'] ?>
                            </div>
                            <div class="card-text">
                                <?php echo $room['room_description'] ?>
                            </div>
                            <div class="card-text">
                                € <?php echo $room['price_per_night'] ?>
                            </div>
                            <a href="reservation.php?room_id=<?php echo $room['id'] ?>" class="card-button"> Réserver </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

<!-- Bootstrap core JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

