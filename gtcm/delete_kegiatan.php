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
		// if (isset($_GET['id_indikator'])) {
		// 	$_SESSION['id_indikator'] = $_GET['id_indikator'];
		// }
		// $id_indikator = $_SESSION['id_indikator'];

		?>
		<?php
		// sql to delete a record
		$id = mysqli_real_escape_string($conn, $_GET["id_kegiatan"]);
		$sql = "UPDATE tb_kegiatan SET 
                flag_active     = 0
                WHERE id='$id'";

		if ($conn->query($sql) === TRUE) {
			echo "<p> Record deleted successfully</p>";
			$subId = explode("_",$id);
			$id_indikator = $subId[0] . "_" . $subId[1] . "_" . $subId[2];
			
			$selesai = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id_indikator='$id_indikator' AND status='Selesai'";
			# note that it is not ==, but '=' (assign value to result and check the value of result)
			if ($result = $conn->query($selesai)) {
				// Return the number of rows in result set
				$selesaiCount = mysqli_num_rows($result);
			}

			$all = "SELECT * FROM tb_kegiatan WHERE flag_active=1 AND id_indikator='$id_indikator'";
			# note that it is not ==, but '=' (assign value to result and check the value of result)
			if ($result = $conn->query($all)) {
				// Return the number of rows in result set
				$allCount = mysqli_num_rows($result);
			}
			if ($allCount == 0) {
				$status_capaian = 0;
			} else {
				$status_capaian = $selesaiCount * 100.0 / $allCount;
			}

			$sql = "UPDATE tb_indikator SET 
                        status_capaian = '$status_capaian'
                        WHERE id = '$id_indikator'";

			if ($conn->query($sql) === TRUE) {
				if ($_SESSION['role'] == "Superadmin") {
					header('location:kegiatanTabelSuperadmin.php');
				} else if ($_SESSION['role'] == "Operator CMMAI") {
					header('location:kegiatanTabelOperatorCMMAI.php');
				} else if ($_SESSION['role'] == "Operator Ministry") {
					header('location:kegiatanTabelOperatorMinistry.php');
				}
			}


		} else {
			echo "Error deleting record: " . $conn->error;
		}

		?>
		<div id="main">
			<?php menu();?>

			<div id="right">
				<div class="container-fluid">

				</div>
				<?php include "headerNavigation.php"; ?>
				<button onclick="window.location.href='kegiatanTabelSuperadmin.php'">Back</button>
			</div>
		</div>
		<?php $conn->close(); ?>
	</div>
</body>

</html>