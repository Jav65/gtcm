<?php
session_start();
ob_start();
//include('security.php');

if (!isset($_SESSION['role'])) {
	header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI' && $_SESSION['role'] != 'Operator Ministry') {
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

	<link rel="stylesheet" href="style_AddData01.css">
	<?php include "head.html"; ?>
	<!-- Template Main CSS Tabel -->
	<link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
</head>

<body>
	<div style="max-width: 1980px; margin: auto">
		<?php
		// $program = $_SESSION['program'];
		// $id_program = $_SESSION['id_program'];
		// $id_cluster = $_SESSION['id_cluster'];
		?>
		<?php
		// sql to delete a record
		$id = $_GET["id_indikator"];
		$sql = "UPDATE tb_indikator SET 
				flag_active     = 0
				WHERE id='$id'";

		if ($conn->query($sql) === TRUE) {
			echo "<p> Record removed successfully</p>";
			$sqlKegiatan = "SELECT * FROM tb_kegiatan WHERE id_indikator='$id'";
			$resultKegiatan = $conn->query($sqlKegiatan);

			if ($resultKegiatan->num_rows > 0) {
				$sqlKegiatanUpdate = "UPDATE tb_kegiatan SET 
									flag_active     = 0
									WHERE id_indikator='$id'";

				if ($conn->query($sqlKegiatanUpdate) === TRUE) {
					if ($_SESSION['role'] == "Superadmin") {
						header('location:indikatorTabelSuperadmin.php');
					} else if ($_SESSION['role'] == "Operator CMMAI") {
						header('location:indikatorTabelOperatorCMMAI.php');
					} else if ($_SESSION['role'] == "Operator Ministry") {
						header('location:indikatorTabelOperatorMinistry.php');
					}
				}
			} else {
				if ($_SESSION['role'] == "Superadmin") {
					header('location:indikatorTabelSuperadmin.php');
				} else if ($_SESSION['role'] == "Operator CMMAI") {
					header('location:indikatorTabelOperatorCMMAI.php');
				} else if ($_SESSION['role'] == "Operator Ministry") {
					header('location:indikatorTabelOperatorMinistry.php');
				}

			}
		} else {
			echo "Error removing record: " . $conn->error;
		}

		$conn->close();
		?>
		<?php include "headerNavigation.php"; ?>
		<div id="main">
			<?php menu(); ?>

			<div id="right">
				<div class="container-fluid">

				</div>
			</div>
		</div>
	</div>
</body>

</html>