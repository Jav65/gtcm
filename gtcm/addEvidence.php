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

                        if (!isset($_GET['id_kegiatan'])) {
                            $id_kegiatan = "";
                        }
                        ?>
                        document.getElementById("id_kegiatan").value = "<?php echo $id_kegiatan; ?>"
                        document.getElementById("returnProbEviPage").action = "<?php echo $linkKegiatan; ?>";
                        document.getElementById("returnProbEviPage").submit();
                    }
                </script>

                <h3>Add Evidence</h3>

                <div>
                    <?php
                    if (isset($_GET['id_kegiatan'])) {
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

                            ?>


                            <div>Evidence: (Upload jpg/png/pdf/mp3/mp4) (Max size: 42 MB)
                                <form action="upload.php" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="file" required>
                                    <input type="hidden" name="id_kegiatan" value="<?php echo $id_kegiatan; ?>">
                                    <button type="submit" name="submit"
                                        style="background-color: green; color: white;">UPLOAD</button>
                                </form>

                                <?php
                                $sql = "SELECT * FROM tb_kegiatanevidence WHERE id_kegiatan='$id_kegiatan' AND flag_active=1
                                    ORDER BY created_at ASC";
                                $result = mysqli_query($conn, $sql);

                                $directoryFileUpload = array(
                                    "image" => array("dir" => array(), "id_evi" => array()),
                                    "video" => array("dir" => array(), "id_evi" => array()),
                                    "audio" => array("dir" => array(), "id_evi" => array()),
                                    "pdf" => array("dir" => array(), "id_evi" => array())
                                );
                                while ($data = mysqli_fetch_assoc($result)) {
                                    $id_evidence = $data['id'];
                                    $created_by = $data['created_by'];
                                    $file = $data['file_directory']; // Replace with your file path
                        
                                    $sqlName = "SELECT * FROM tb_master_pic WHERE id='$created_by'";
                                    $resultName2 = $conn->query($sqlName);

                                    if ($resultName2->num_rows > 0) {
                                        while ($rowName = $resultName2->fetch_assoc()) {
                                            $nameRole = $rowName['nama_pic'] . "(" . $rowName['role'] . ")";

                                            $fileType = mime_content_type($file);

                                            switch ($fileType) {
                                                case 'application/pdf':
                                                    //echo '<embed src="'.$file.'" type="'.$fileType.'" width: "400"/>';
                                                    array_push($directoryFileUpload['pdf']["dir"], $file);
                                                    array_push($directoryFileUpload['pdf']["id_evi"], $id_evidence);
                                                    break;
                                                case 'image/jpeg':
                                                case 'image/png':
                                                case 'image/gif':
                                                    array_push($directoryFileUpload['image']["dir"], $file);
                                                    array_push($directoryFileUpload['image']["id_evi"], $id_evidence);
                                                    break;
                                                case 'video/mp4':
                                                    array_push($directoryFileUpload['video']["dir"], $file);
                                                    array_push($directoryFileUpload['video']["id_evi"], $id_evidence);
                                                    break;
                                                case 'audio/mpeg':
                                                    array_push($directoryFileUpload['audio']["dir"], $file);
                                                    array_push($directoryFileUpload['audio']["id_evi"], $id_evidence);
                                                    break;
                                                default:
                                                    echo 'File type not supported.';
                                            }


                                        }
                                    }
                                }
                                foreach ($directoryFileUpload as $type => $list) {
                                    $indexFile = 0;
                                    foreach ($list['dir'] as $val2) {
                                        if ($indexFile == 0) {
                                            echo "<h4 style='font-size: 40px;'>" . $type . "<br></h4>";
                                        }
                                        echo "<p style='margin-top:25px;'>" . $nameRole . "</p>";

                                        $fileType = mime_content_type($val2);
                                        switch ($fileType) {
                                            case 'application/pdf':
                                                echo '<embed src="' . $val2 . '" type="' . $fileType . '" width= "80%" height="500px" class="displayFile"/>';
                                                //echo '<iframe src="' . $val2 . '" type"' . $fileType . '" width="80%" height="500px">';
                                                break;
                                            case 'image/jpeg':
                                            case 'image/png':
                                            case 'image/gif':
                                                echo '<img src="' . $val2 . '" width="50%" class="displayFile"/>';
                                                break;
                                            case 'video/mp4':
                                                echo '<video width="50%" class="displayFile" controls><source src="' . $val2 . '" type="' . $fileType . '"></video>';
                                                break;
                                            case 'audio/mpeg':
                                                echo '<audio controls><source src="' . $val2 . '" type="' . $fileType . '"></audio>';
                                                break;
                                            default:
                                                echo 'File type not supported.';
                                        }

                                        $id_evidence = $list['id_evi'][$indexFile];
                                        $sqlEvidence = "SELECT * FROM tb_kegiatanevidence WHERE id='$id_evidence'";
                                        $resultEvidence = $conn->query($sqlEvidence);
                                        if ($resultEvidence->num_rows > 0) {
                                            $evidenceInfo = $resultEvidence->fetch_assoc();
                                        }
                                        $file_name = $evidenceInfo['file_name'];
                                        echo "<button onclick=\"window.location.href='download.php?file=$file_name'\"><i class='fa fa-download'></i>Download</button>";
                                        //echo "<button onclick=\"window.location.href='download.php?id_evidence=$id_evidence'\"><i class='fa fa-download'></i>Download</button>";
                                        echo "<button onclick=\"window.location.href='delete_evidence.php?id_evidence=$id_evidence'\"><i class='fa fa-remove' style='color:red;'></i>Remove</button><br>";
                                        $indexFile++;
                                    }

                                }




                                //echo "<img src='{$data['file_directory']}' width='40%' height='40%'>";
                        
                                //$file = 'upload/Progress 25 Maret.pdf'; // Replace with your file path
                        

                                ?>
                            </div>
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