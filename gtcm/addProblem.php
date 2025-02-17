<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style_AddData01.css">
    <?php include "head.html"; ?>
    <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
</head>

<body>
    <div style="max-width: 1980px; margin: auto">
        <div>
            <?php
            if (!isset($_SESSION['role'])) {
                header('location:login.html');
            } else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI' && $_SESSION['role'] != 'Operator Ministry') {
                header("Location: accessDenied.php");
            }
            include "connection.php";
            include "function/myFunc.php";
            ?>
        </div>
        <div>
            <?php

            if (isset($_GET['id_kegiatan'])) {
                $id_kegiatan = mysqli_real_escape_string($conn, $_GET['id_kegiatan']);
            } else if ($_POST['id_kegiatan']) {
                $id_kegiatan = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
            }

            // $colName = array();
            // if (isset($_POST['numCol'])) {
            //     echo "*";
            //     $numCol = $_POST['numCol'];
            //     for ($indexCol = 0; $indexCol < $numCol; $indexCol++) {
            //         $key = "column" . $indexCol;
            
            //         array_push($colName, $_POST[$key]);
            //     }
            //     $numCol = $_POST['numCol'] + 1;
            // } else {
            //     $numCol = 1;
            // }
            // array_push($colName, "");
            ?>
        </div>

        <?php include "headerNavigation.php"; ?>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
                <button type="button" class="btn btn-dark" onclick="returnProbEvi()">Back</button>
                <form action='' method='get' id='returnProbEviPage'>
                    <input type='hidden' id='id_kegiatan' name='id_kegiatan' value=''>
                </form>
                <script>
                    function returnProbEvi() {
                        <?php

                        $linkKegiatan = "add_problem_evidence_page.php";
                        if (!isset($_GET['id_kegiatan']) && !isset($_POST['id_kegiatan'])) {
                            $id_kegiatan = "";
                        }
                        ?>
                        document.getElementById("id_kegiatan").value = "<?php echo $id_kegiatan; ?>"
                        document.getElementById("returnProbEviPage").action = "<?php echo $linkKegiatan; ?>";
                        document.getElementById("returnProbEviPage").submit();
                    }
                </script>

                <h3>Add Problem</h3>

                <div>
                    <?php
                    if (isset($_POST['submit'])) {
                        $id_kegiatan = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
                        $problem = mysqli_real_escape_string($conn, $_POST['problem']);

                        $sqlCountProblem = "SELECT * FROM tb_kegiatanproblem WHERE id_kegiatan='$id_kegiatan'";
                        $problemCount = countNum($sqlCountProblem) + 1;

                        $id = $id_kegiatan . "_MAS-" . $problemCount;
                        $created_by = mysqli_real_escape_string($conn, $_SESSION['name']);

                        $sqlAddProblem = "INSERT INTO tb_kegiatanproblem (id, id_kegiatan, problem, created_by) VALUES ('$id', '$id_kegiatan', '$problem', '$created_by')";
                        if ($conn->multi_query($sqlAddProblem) === TRUE) {

                            $kegiatanInfo = parentFromId($id_kegiatan, "tb_kegiatan");
                            $countProblem = $kegiatanInfo['problem'] + 1;
                            $sqlUpdateKegiatan = "UPDATE tb_kegiatan SET problem = $countProblem WHERE id='$id_kegiatan'";
                            if ($conn->multi_query($sqlUpdateKegiatan) === TRUE) {

                            }
                        }

                    } else if (isset($_GET['id_kegiatan'])) {
                        $id_kegiatan = mysqli_real_escape_string($conn, $_GET['id_kegiatan']);
                    } else {
                        echo "<p>ID tidak valid;";
                    }
                    ?>
                </div>

                <div class="container">
                    <?php
                    if (isset($id_kegiatan)) {
                        $kegiatanInfo = parentFromId($id_kegiatan, "tb_kegiatan");

                        if (isset($kegiatanInfo['kegiatan'])) {
                            $kegiatan = $kegiatanInfo['kegiatan'];
                            echo "<h4>$kegiatan</h4>";

                            $sqlProblem = "SELECT * FROM tb_kegiatanproblem WHERE id_kegiatan='$id_kegiatan' AND flag_active=1";
                            $resultProblem = $conn->query($sqlProblem);
                            if ($resultProblem->num_rows > 0) {
                                echo "<h5>List Problem</h5>";
                                echo "<ol>";
                                while ($rowProblem = $resultProblem->fetch_assoc()) {
                                    $id_problem = $rowProblem['id'];
                                    $problem = $rowProblem['problem'];
                                    echo "<li>$problem <button onclick=\"deleteProblem('$id_problem')\">Hapus</button></li>";
                                }
                                echo "</ol>";

                                echo "<form id='deleteProblem' action='delete_problem.php' method='post'>";
                                echo "  <input type='hidden' id='id_problem' name='id_problem' value=''>";
                                echo "</form>";
                                echo "<script>";
                                echo "function deleteProblem(id_problem){
                                    document.getElementById('id_problem').value = id_problem;
                                    document.getElementById('deleteProblem').submit();
                                }";
                                echo "</script>";
                            }
                            ?>


                            <form id="addKegiatanProblem" action="./addProblem.php" method="post">
                                <input type="hidden" id="id_kegiatan" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                                <div class="row2">
                                    <label for="problem">Problem</label>
                                    <input type="text" id="problem" name="problem" placeholder="problem" required>
                                </div>

                                <input type="submit" name="submit">
                            </form>
                            <?php
                        } else {
                            echo "<p>Id tidak valid</p>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php $conn->close(); ?>
    </div>
</body>

</html>