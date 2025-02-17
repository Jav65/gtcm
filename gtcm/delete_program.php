<?php
session_start();
//include('security.php');

if (!isset($_SESSION['role'])) {
	header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI') {
	header("Location: accessDenied.php");
}
include "connection.php";
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
		// sql to delete a record
		$id = $_GET["id_program"];
		$id_cluster = explode("_", $id)[0];
		$id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
		$sql = "UPDATE tb_program_$id_clusterEdited SET 
				flag_active     = 0
				WHERE id='$id'";
		if ($conn->query($sql) === TRUE) {
			$sqlIndikatorUpdate = "UPDATE tb_indikator SET flag_active=0 WHERE id LIKE '%" . $id . "%'";
			$conn->query($sqlIndikatorUpdate);

			$sqlKegiatanUpdate = "UPDATE tb_kegiatan SET 
									flag_active     = 0
									WHERE id LIKE '%" . $id . "%'";
			$conn->query($sqlKegiatanUpdate);
		} 

		if ($_SESSION['role'] == "Superadmin") {
			header('location:programTabelSuperadmin.php');
		} else if ($_SESSION['role'] == "Operator CMMAI") {
			header('location:programTabelOperatorCMMAI.php');
		}

		$conn->close();
		?>
		<?php include "headerNavigation.php"; ?>

		<div id="main">
			<?php menu();?>

			<div id="right" class="text-black">
			<button type="button" class="btn btn-dark" onclick="backProgramPage()">Back</button>
                <form id="backProgramPage" method="get" action="">
                    <!-- <input id="myIdProgramPage" type="hidden" name="id_program" value=""> -->
                </form>
                <script>
                    function backProgramPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("backProgramPage").action = "programTabelSuperadmin.php"; }
                        else if (role == "Operator CMMAI") { document.getElementById("backProgramPage").action = "programTabelOperatorCMMAI.php"; }

                        // document.getElementById("myIdProgramPage").value = "<?php //echo $_SESSION['id_program']; ?>";

                        document.getElementById("backProgramPage").submit();
                    }
                </script>
				<div class="container-fluid">

				</div>
			</div>
		</div>
	</div>
</body>

</html>