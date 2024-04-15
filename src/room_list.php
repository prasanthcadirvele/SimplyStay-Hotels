<?php

require_once '../repository/DBManager.php';

session_start();

$dbManager = new DBManager();

if (isset($_GET['room_id'])) {
    $room_id = $_GET['room_id'];
    if($room_id == -1){
        header('Location: room_list.php');
        exit(0);
    }
    $rooms = $dbManager->getRoomByRoomId($room_id);
} else {
    $rooms = $dbManager->getAllRoom();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Hotel Management - Liste des Chambres</title>
    <link href="../css/style.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg" style="background-color: #E3B04B; color: black;">
        <div class="container px-5">
            <a class="navbar-brand" href="index.php">Hotel Booking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <?php
                    if (isset($_SESSION['username']) && isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
                        echo '<li class="nav-item"><a class="nav-link" href="mesreservations.php">Mes Réservations</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                        
                        // Check if the user is an admin
                        if(isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'){
                            echo '<li class="nav-item"><a class="nav-link" href="#">Ajouter</a></li>';
                        }
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row gx-4 gx-lg-5 m-5">
            <form method="get" class="form-inline" style="justify-content: end">
                <div class="justify-content-between" style="display: flex">
                    <div class="col-md-4 mb-3" style="padding: 0">
                        <select class="form-control" style="height: fit-content" id="hotel_select" name="hotel_id">
                            <option value="-1">Charger Tous</option>
                            <?php
                            $room = $dbManager->getAllRoom();
                            foreach ($rooms as $room) {
                                echo '<option value="' . $room->getHotel()->getHotelId() . '">' . $room->getHotel()->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3" style="margin: auto; padding-right: 0">
                        <button type="submit" class="btn" style="display: inline-grid;background-color: #215294; color: white">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row gx-4 gx-lg-5 m-5">
            <?php
            foreach ($rooms as $room) {
            ?>
                <div class="col-md-4 mb-5">
                    <div class="card h-100">
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $room->getHotel()->getName() . ' - Chambre ' . $room->getRoomNumber() ?></h2>
                            <p class="card-text">
                                <?php echo 'Type: ' . $room->getRoomType() . '<br>' . 'Prix par Nuit: ' . $room->getPricePerNight() . ' €' ?>
                            </p>
                        </div>
                        <div class="card-footer"><a class="btn btn-sm" style="background-color: #215294; color: white" href="reservation.php?room_id=<?php echo $room->getRoomId() ?>">Réserver</a></div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>
