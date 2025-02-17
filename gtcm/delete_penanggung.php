<?php
session_start();
ob_start();
//include('security.php');

if (!isset($_SESSION['role'])) {
    header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI'  && $_SESSION['role'] != 'Operator Ministry') {
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
        // sql to delete a record
        if (isset($_POST["id_penanggung"]) && isset($_POST["divName"])) {
            $id = mysqli_real_escape_string($conn, $_POST["id_penanggung"]);
            $divName = mysqli_real_escape_string($conn, $_POST["divName"]);
            $sql = "UPDATE tb_master_penanggung_jawab SET 
				flag_active     = 0
				WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                $link = "";
                if ($divName == "program") {
                    $id_cluster = explode("_", $id)[0];
                    $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                    $id_program = explode("_", $id)[0] . "_" . explode("_", $id)[1];

                    $sqlSelectPenanggungJawab = "SELECT * FROM tb_master_penanggung_jawab WHERE id_div='$id_program' AND flag_active=1";
                    $penanggungJawabNum = countNum($sqlSelectPenanggungJawab);

                    $sqlUpdatePenanggung = "UPDATE tb_program_$id_clusterEdited SET penanggung_jawab_info = '$penanggungJawabNum' WHERE id='$id_program'";
                    if ($conn->query($sqlUpdatePenanggung) === TRUE) {
                        $link = "location: addPenanggungJawabProgram.php?id_div=$id_program";    
                    }

                } else if ($divName == "indikator") {
                    $id_indikator = explode("_", $id)[0] . "_" . explode("_", $id)[1] . "_" . explode("_", $id)[2];
                    $sqlSelectPenanggungJawab = "SELECT * FROM tb_master_penanggung_jawab WHERE id_div='$id_indikator' AND flag_active=1";
                    $penanggungJawabNum = countNum($sqlSelectPenanggungJawab);

                    $sqlUpdatePenanggung = "UPDATE tb_indikator SET penanggung_jawab_info = '$penanggungJawabNum' WHERE id='$id_indikator'";
                    if ($conn->query($sqlUpdatePenanggung) === TRUE) {
                        $link = "location: addPenanggungJawabIndikator.php?id_div=$id_indikator";    
                    }
                } else if($divName == "kegiatan"){
                    $id_kegiatan = explode("_", $id)[0] . "_" . explode("_", $id)[1] . "_" . explode("_", $id)[2] . "_" . explode("_", $id)[3];
                    $sqlSelectPenanggungJawab = "SELECT * FROM tb_master_penanggung_jawab WHERE id_div='$id_kegiatan' AND flag_active=1";
                    $penanggungJawabNum = countNum($sqlSelectPenanggungJawab);

                    $sqlUpdatePenanggung = "UPDATE tb_kegiatan SET penanggung_jawab_info = '$penanggungJawabNum' WHERE id='$id_kegiatan'";
                    if ($conn->query($sqlUpdatePenanggung) === TRUE) {
                        $link = "location: addPenanggungJawabKegiatan.php?id_div=$id_kegiatan";    
                    }
                }
                
                    header($link);
                
            }
        }



        $conn->close();
        ?>
        <?php include "headerNavigation.php"; 
        menu();?>

        

        <div id="right" class="text-black">
            <button type="button" class="btn btn-dark" onclick="backMainPage()">Back</button>
            <form id="backMainPage" method="get" action="">
                <!-- <input id="myIdProgramPage" type="hidden" name="id_program" value=""> -->
            </form>
            <script>
                function backMainPage() {
                    role = "<?php echo $_SESSION['role']; ?>";
                    if (role == "Superadmin") { document.getElementById("backMainPage").action = "superadminMainCMMAI.php"; }
                    else if (role == "Operator CMMAI") { document.getElementById("backMainPage").action = "operatorMainCMMAI.php"; }
                    else if (role == "Operator Ministry") { document.getElementById("backMainPage").action = "operator_ministryMain.php"; }

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