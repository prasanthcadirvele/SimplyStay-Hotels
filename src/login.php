<?php

require_once '../repository/DBManager.php';
require_once '../config/DatabaseConfiguration.php';

use config\DatabaseConfiguration; // Import the DatabaseConfiguration class

session_start();

// Step 1: Check if user is already logged in
if(isset($_SESSION['username']) && $_SESSION['user_logged_in']) {
	header('Location: home.php');
	exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Initialize DatabaseConfiguration and retrieve connection credentials
	$databaseConfig = new DatabaseConfiguration();
	$servername = $databaseConfig->getHost();
	$username_db = $databaseConfig->getUsername();
	$password_db = $databaseConfig->getPassword();
	$dbname = $databaseConfig->getDbname();

	// Create a new DBManager instance with connection credentials
	$dbManager = new DBManager($servername, $username_db, $password_db, $dbname);

	if($dbManager->verifyUser($username, $password)){
		$_SESSION['username'] = $username;
		$_SESSION['user_logged_in'] = true;
		header('Location: index.php');
		exit();
	}else{
		$_SESSION['login_error'] = 'Echec d\'authentification';
		header('Location: login.php');
		exit();
	}
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initia	l-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="../css/style.css">
  	<link rel="stylesheet" href="../css/styles.css">

	</head>
	<body>
	<!-- Responsive navbar-->
	<nav class="navbar navbar-expand-lg" style="background-color: #E3B04B; color: black;">
		<div class="container px-5">
			<a class="navbar-brand" href="index.php"> <img src="../images/symbol2.png" alt="Logo SimpleStay Hotel" height="30" style="vertical-align: top;"> SimpleStay Hotels</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-auto mb-2 mb-lg-0">
					<li class="nav-item"><a class="nav-link" href="room_list.php">Book Rooms</a></li>
					<?php
					if(isset($_SESSION['username']) && isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']){
						echo '<li class="nav-item"><a class="nav-link" href="mesreservations.php">Mes Réservations</a></li>';
						echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
					}else{
						echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
					}
					?>
					<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(../images/symbol.png); background-size: contain; background-position: center center; background-repeat: no-repeat">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Connection</h3>
			      		</div>
			      	</div>
							<form action="login.php" method="post" class="signin-form">
								<div class="form-group mb-3">
									<label class="label" for="name">Username</label>
									<input type="text" class="form-control" placeholder="Username" name="username" required>
								</div>
								<div class="form-group mb-3">
									<label class="label" for="password">Password</label>
									<input type="password" class="form-control" placeholder="Mot de passe" name="password" required>
								</div>
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
		            </div>
		          </form>
		          <p class="text-center">Don't have an account ? <a href="signup.php">Create Account</a></p>
							<?php
							if (isset($_SESSION['login_error'])) {
								echo '<p class="text-danger">'.$_SESSION["login_error"].'</p>';
								unset($_SESSION['login_error']);
							}
							?>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="../js/jquery.min.js"></script>
  <script src="../js/popper.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/main.js"></script>

	</body>
</html>

<?php
}
?>