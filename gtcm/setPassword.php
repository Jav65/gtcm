<?php
include "connection.php";

if(isset($_POST['password'])){
// Get the password from the form
$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password using the bcrypt algorithm
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Connect to the MySQL database
//$mysqli = new mysqli("localhost", "username", "password", "database");

// Insert the hashed password into the users table
$insertStmt = $conn->prepare("UPDATE tb_master_pic SET password = ? WHERE email = ?");
$insertStmt->bind_param("ss", $hashedPassword, $email);
$insertStmt->execute();


$sql = "UPDATE tb_master_pic SET setPW=1 WHERE email='$email'";
if ($conn->query($sql) === TRUE) {
    header("Location: setPasswordSucceed.html");
}



}
else if(isset($_POST['email'])){
    $email = $_POST['email'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>

	<link rel="stylesheet" href="assets/css/login_style.css">

	<!-- remote -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<div style="max-width: 1980px; margin: auto; overflow-x: auto;">
		<div class="bg"></div>
		<div class="bg bg2"></div>
		<div class="bg bg3"></div>
		<div class="content">

			<header>
				<h2>Set Password Akun GTCM</h2>
			</header>
			<form class="card" action="setPassword.php" method="post">
				<input class="inputField" placeholder="Email" name="email" required type="email" id="email">
				<input class="inputField" placeholder="Password" name="password" required type="password" id="pwd">
				<button class="button1" type="submit">Login</button>
			</form>
			<footer>
				<p>&copy;2023</p>
			</footer>
		</div>
	</div>
</body>

</html>
<?php
// Close the database connection
$conn->close();

?>
