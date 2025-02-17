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
        $id = mysqli_real_escape_string($conn, $_GET["id"]);
        $sql = "UPDATE tb_statuskegiatan SET 
				flag_active     = 0
				WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            if ($_SESSION['role'] == "Superadmin") {
                header('location:statusTabel.php');
            } 
        }

        $conn->close();
        ?>
        <?php include "headerNavigation.php"; ?>

        <?php menu();?>

        <div id="right" class="text-black">
            <div class="container-fluid">

            </div>
        </div>
    </div>
    
</body>

</html>