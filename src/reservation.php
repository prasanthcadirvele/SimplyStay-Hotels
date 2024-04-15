<?php

require_once '../repository/DBManager.php';

session_start();
error_reporting(0);

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$dbManager = new DBManager();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reservation_debut = $_POST['reservation_debut'];
    $fin_reservation = $_POST['fin_reservation'];
    $nombre_de_nuits = $_POST['nombre_de_nuits'];
    $hotel_id = $_POST['hotel_id'];
    $room_id = $_POST['room_id'];

    $username = $_SESSION['username'];

    $reservation = $dbManager->checkAndMakeReservation($reservation_debut, $fin_reservation, $nombre_de_nuits, $username, $hotel_id, $room_id);

    if ($reservation) {
        header('Location: mesreservations.php');
        exit();
    } else {
        $_SESSION['reservation_error'] = "La réservation n'est malheureusement pas possible, car toutes les chambres sont occupées.";
        header('Location: reservation.php?hotel_id=' . $hotel_id);
    }
} else {

    if (isset($_GET['hotel_id'])) {

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
                    <a class="navbar-brand" href="index.php">Hotel Booking</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item"><a class="nav-link" href="hotel_list.php">Liste des Hôtels</a></li>
                            <?php
                            if (isset($_SESSION['username']) && isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
                                echo '<li class="nav-item"><a class="nav-link" href="mesreservations.php">Mes Réservations</a></li>';
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
                                        <input type="datetime-local" id="fin_reservation" name="fin_reservation" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                                    </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Nombre de Nuits<span class="text-danger"> *</span></label>
                                        <input type="number" id="nombre_de_nuits" name="nombre_de_nuits" placeholder="Nombre de nuits" required>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Chambre<span class="text-danger"> *</span></label>
                                        <select class="form-control" id="room_select" name="room_id" required>
                                            <?php
                                            $hotelId = $_GET['hotel_id'];
                                            $rooms = $dbManager->getAllRoomsByHotel($hotelId);
                                            foreach ($rooms as $room) {
                                                echo '<option value="' . $room->getRoomId() . '">' . $room->getRoomNumber() . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <input type="hidden" name="hotel_id" value="<?php echo $_GET['hotel_id']; ?>">
                                    <div class="form-group col-sm-2"> <button type="submit" class="btn-block" style="background-color: #215294; color: white">Réserver</button> </div>
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
        header('Location: hotel_list.php');
    }
}
?>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>

        </body>

        </html>
