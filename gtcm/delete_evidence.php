<?php
session_start();
ob_start();
//include('security.php');

if (!isset($_SESSION['role'])) {
	header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin') {
	header("Location: accessDenied.php");
}
include "connection.php";
include "function/myFunc.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>User Page</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div style="max-width: 1980px; margin: auto">
		<?php 
		include "headerNavigation.php"; 
		menu();
		?>
		
		<div class="container-fluid">
			<?php
			// sql to delete a record
			$id = mysqli_real_escape_string($conn, $_GET["id_evidence"]);

			$sql = "UPDATE tb_kegiatanevidence SET 
                flag_active     = 0
                WHERE id='$id'";

			$idArray = explode("_", $id);
			$id_kegiatan = $idArray[0] . "_" . $idArray[1] . "_" . $idArray[2] . "_" . $idArray[3];
			if ($conn->query($sql) === TRUE) {
				echo "<p> Record removed successfully</p>";
				$linkKegiatan = "Location: kegiatanDetail.php?id_kegiatan=$id_kegiatan";
				header($linkKegiatan);
			} else {
				echo "Error removing record: " . $conn->error;
			}

			$conn->close();
			?>
		</div>
	</div>
</body>

</html>