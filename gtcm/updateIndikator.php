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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style_AddData01.css">
    <?php include "head.html"; ?>
    <!-- Template Main CSS Tabel -->
    <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
</head>

<body>
    <div style="max-width: 1980px; margin: auto">
        <div>
            <?php
            include "connection.php";
            include "function/myFunc.php";
            ?>
            <?php
            // $program = $_SESSION['program'];
            // $id_program = $_SESSION['id_program'];
            // $id_cluster = $_SESSION['id_cluster'];
            ?>
            <?php
            if (isset($_POST["submit"])) {
                $id = mysqli_real_escape_string($conn, $_POST["id_indikator"]);
                $indikator = mysqli_real_escape_string($conn, $_POST["indikator"]);
                $baseline = mysqli_real_escape_string($conn, $_POST["baseline"]);
                $target = mysqli_real_escape_string($conn, $_POST["target"]);
                $capaian = mysqli_real_escape_string($conn, $_POST["capaian"]);

                $updated_by = mysqli_real_escape_string($conn, $_SESSION['name']);

                $sql = "UPDATE tb_indikator SET 
                        indikator     = '$indikator',
                        baseline         = '$baseline',
                        target = '$target', 
                        capaian      = '$capaian',
                        updated_by = '$updated_by'
                        WHERE id='$id'";

                if ($conn->query($sql) === TRUE) {

                    if ($_SESSION['role'] == "Superadmin") {
                        header('location:indikatorTabelSuperadmin.php');
                    } else if ($_SESSION['role'] == "Operator CMMAI") {
                        header('location:indikatorTabelOperatorCMMAI.php');
                    } else if ($_SESSION['role'] == "Operator Ministry") {
                        header('location:indikatorTabelOperatorMinistry.php');
                    }
                } else {
                    echo "Error updating record: " . $conn->error;
                }
            } else {
                $id = $_GET["id_indikator"];
                $sql = "SELECT * FROM tb_indikator WHERE id='$id'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    if ($row = $result->fetch_assoc()) {
                        $id_program = $row["id_program"];
                        $_SESSION['id_program'] = $id_program;
                        $indikator = $row["indikator"];
                        $baseline = $row["baseline"];
                        $target = $row["target"];
                        $capaian = $row["capaian"];
                    }
                }
            }
            ?>


        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu();?>

            <div id="right" class="text-black">
            <button type="button" class="btn btn-dark" onclick="backIndikatorPage()">Back</button>
                <form id="backIndikatorPage" method="get" action="">
                    <!-- <input id="myIdIndikatorPage" type="hidden" name="id_indikator" value=""> -->
                </form>
                <script>
                    function backIndikatorPage() {
                        role = "<?php echo $_SESSION['role']; ?>";
                        if (role == "Superadmin") { document.getElementById("backIndikatorPage").action = "indikatorTabelSuperadmin.php"; }
                        else if (role == "Operator CMMAI") { document.getElementById("backIndikatorPage").action = "indikatorTabelOperatorCMMAI.php"; }
                        else if (role == "Operator Ministry") { document.getElementById("backIndikatorPage").action = "indikatorTabelOperatorMinistry.php"; }

                        // document.getElementById("myIdIndikatorPage").value = "<?php //echo $_SESSION['id_indikator']; ?>";

                        document.getElementById("backIndikatorPage").submit();
                    }
                </script>
                <h2>Update Indikator</h2>
                <div>
                    <h4 style="display: inline-block; ">Cluster:
                        <?php
                        $id_cluster = explode("_", $id_program)[0];
                        $clusterInfo = parentFromId($id_cluster, "tb_cluster");
                        echo $clusterInfo['cluster'];
                        ?>
                    </h4>
                    <br>
                    <h4 style="display: inline-block; ">Program:
                        <?php
                        $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                        $sqlProgram = "SELECT * FROM tb_program_$id_clusterEdited WHERE id='$id_program'";
                        $resultProgram = $conn->query($sqlProgram);
                        if ($resultProgram->num_rows > 0) {
                            $rowProgram = $resultProgram->fetch_assoc();
                            $indexProgram = 0;
                            foreach ($rowProgram as $key => $keyValue) {
                                if ($indexProgram == 2) {
                                    $program = $rowProgram[$key];
                                }
                                $indexProgram++;
                            }

                        }
                        echo $program;
                        ?>
                    </h4>
                    <br>
                </div>

                <div class="container">
                    <form action="./updateIndikator.php" method="post">
                        <div class="row2">
                            <label for="id_indikator">ID Indikator:</label>
                            <input type="text" class="form-control" id="id_indikator" value="<?php echo $id; ?>"
                                name="id_indikator" readonly>
                        </div>

                        <div class="row2">
                            <label for="indikator">INDIKATOR</label>
                            <!--<input type="text" id="program" name="program" placeholder="Add Program">-->
                            <textarea id="indikator" name="indikator" rows="4" cols="50" placeholder="Add Indikator"
                                required><?php echo $indikator; ?></textarea>
                        </div>

                        <div class="row2">
                            <label for="baseline">Baseline</label>
                            <input type="text" id="baseline" name="baseline" value="<?php echo $baseline; ?>">
                        </div>

                        <div class="row2">
                            <label for="target">Target</label>
                            <input type="text" id="target" name="target" value="<?php echo $target; ?>">
                        </div>

                        <div class="row2">
                            <label for="capaian">Capaian</label>
                            <input type="text" id="capaian" name="capaian" value="<?php echo $capaian; ?>">
                        </div>

                        

                        <div class="row2">
                            <input type="submit" name="submit" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php $conn->close(); ?>
</body>

</html>