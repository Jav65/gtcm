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
        $id = mysqli_real_escape_string($conn, $_GET["id_instansi"]);
        $sql = "UPDATE tb_master_kementrian SET 
                flag_active     = 0
                WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<p> Record deleted successfully</p>";

            if ($_SESSION['role'] == "Superadmin") {
                header('location:master_instansi.php');
            }

        } else {
            echo "Error deleting record: " . $conn->error;
        }

        ?>
        <div id="main">
            <?php menu(); ?>
            <div id="right">
                <button type="button" class="btn btn-dark" onclick="backMainPage()">Back</button>
                <form id="backMainPage" method="get" action="">
                    <!-- <input id="myIdProgramPage" type="hidden" name="id_program" value=""> -->
                </form>
                <script>
                    function backMainPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("backMainPage").action = "superadminMainCMMAI.php"; }
                        else if (role == "Operator CMMAI") { document.getElementById("backMainPage").action = "programTabelOperatorCMMAI.php"; }
                        else if (role == "Operator Ministry") { document.getElementById("backMainPage").action = "programTabelOperatorMinistry.php"; }

                        // document.getElementById("myIdProgramPage").value = "<?php //echo $_SESSION['id_program']; ?>";

                        document.getElementById("backMainPage").submit();
                    }
                </script>
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