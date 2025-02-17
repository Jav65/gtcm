del
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
        $id = mysqli_real_escape_string($conn, $_GET["id_pic"]);
        $sql = "UPDATE tb_master_pic SET 
				flag_active     = 0
				WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            if ($_SESSION['role'] == "Superadmin") {
                header('location:manageUserSuperadmin.php');
            }
        }

        $conn->close();
        ?>
        <?php include "headerNavigation.php"; ?>

        <?php menu();?>

        <div id="right" class="text-black">
            <button type="button" class="btn btn-dark" onclick="backMainPage()">Back</button>
            <form id="backMainPage" method="get" action="">
                <!-- <input id="myIdProgramPage" type="hidden" name="id_program" value=""> -->
            </form>
            <script>
                function backMainPage() {
                    role = "<?php echo $_SESSION['role']; ?>";
                    if (role == "Superadmin") { document.getElementById("backMainPage").action = "superadminMainCMMAI.php"; }

                    // document.getElementById("myIdProgramPage").value = "<?php //echo $_SESSION['id_program']; ?>";

                    document.getElementById("backMainPage").submit();
                }
            </script>
            <div class="container-fluid">

            </div>
        </div>
    </div>

</body>

</html>