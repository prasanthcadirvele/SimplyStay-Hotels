<?php

require_once '../repository/DBManagerDirecteur.php';

session_start();

$dbManagerDirecteur = new DBManagerDirecteur();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $dbManagerDirecteur->deleteUser($user_id);
    header('Location: users.php');
}

if (!isset($_SESSION['username']) || !$_SESSION['user_logged_in']) {
    header('Location: login.php');
    exit();
}

if(!$_SESSION['user_type']=='admin'){
    header('Location: login.php');
    exit();
}

$dbManagerDirecteur = new DBManagerDirecteur();
$users = $dbManagerDirecteur->getAllUsers();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Hotel Management - Liste des utilisateurs</title>
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
						echo '<li class="nav-item"><a class="nav-link" href="my_reservation.php">Reservations en cours</li>';
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

    <div class="container">
        <div class="mt-4 row justify-content-center">
            <div class="col-md-8">
                <h2>Liste des utilisateurs</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <?php if($_SESSION['user_type']=='admin'){ ?>
                                <th>First Name</th>
                            <?php } ?>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Age</th>
                            <th>Numéro Tel</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($users != null) {
                            foreach ($users as $user) : ?>
                                <tr>
                                    <td><?php echo $user->getFirstname(); ?></td>
                                    <td><?php echo $user->getLastname(); ?></td>
                                    <td><?php echo $user->getEmail(); ?></td>
                                    <td><?php echo $user->getAge(); ?></td>
                                    <td><?php echo $user->getNumTel(); ?></td>
                                    <td><?php echo $user->getUsername(); ?></td>
                                    <td>
                                        <form id="deleteForm" action="users.php" method="post">
                                            <!-- Hidden input for reservation_id -->
                                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->getId() ?>">
                                            <!-- Delete icon -->
                                            <span class="delete-icon" onclick="document.getElementById('deleteForm').submit();">&#10060;</span>
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
</body>

</html>

