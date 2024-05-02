<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Check if the user is an admin
$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type']=='admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpleStay Hotels</title>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Responsive navbar -->
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

    <div class="container mt-5">
        <!-- Page content -->
        <?php if (!$isAdmin) { ?>
        <!-- Content for normal users -->
        <h1>Welcome to SimpleStay Hotels</h1>
        <p>This is the index page for normal users.</p>
        <?php } else { ?>
        <!-- Content for admin users -->
        <h1>Welcome, Admin</h1>
        <p>This is the index page for admins.</p>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>


