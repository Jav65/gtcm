<?php session_start();
if (!isset($_SESSION['role'])) {
    header('location:login.html');
} else if ($_SESSION['role'] != 'Superadmin' && $_SESSION['role'] != 'Operator CMMAI' && $_SESSION['role'] != 'Operator Ministry' && $_SESSION['role'] != 'Observer CMMAI' && $_SESSION['role'] != 'Observer Ministry') {
    header("Location: accessDenied.php");
}

include "connection.php";
include "function/myFunc.php";
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sqlIDName = "SELECT * FROM tb_master_pic where email='$email'";
    $resultIDName = $conn->query($sqlIDName);
    if ($resultIDName->num_rows > 0) {
        while ($row = $resultIDName->fetch_assoc()) {
            $id_pic = $row['id'];
            $_SESSION['id_pic'] = $id_pic;
        }
    }
}
if (isset($_SESSION['id_pic'])) {
    $id_pic = $_SESSION['id_pic'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style_AddData01.css">
    <?php include "head.html"; ?>

    <link href="assetsOperatorTabel/css/main2.css" rel="stylesheet">
    <!-- <title>History</title>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords"> -->

    <!-- Favicons -->
    <!-- <link
        href="https://www.freepnglogos.com/uploads/logo-garuda-png/garuda-buku-pembangunan-desa-kementrian-desa-pdtt-2.png"
        rel="icon">
    <link
        href="https://www.freepnglogos.com/uploads/logo-garuda-png/garuda-buku-pembangunan-desa-kementrian-desa-pdtt-2.png"
        rel="apple-touch-icon"> -->

    <!-- Google Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"> -->

    <!-- Vendor CSS Files -->
    <!-- <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet"> -->

    <!-- Template Main CSS File -->

    <link rel="stylesheet" href="./styleKegiatan01.css" />

    <meta property="twitter:card" content="summary_large_image" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        data-tag="font" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&amp;display=swap"
        data-tag="font" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">


    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="chat.css">

    <link href="recentActivity.css" rel="stylesheet">
</head>

<body>
    <div style="max-width: 1980px; margin: auto">
        <style>
            <?php include "styleKegiatan03.css"; ?>
        </style>
        <div>
            <?php
            include "headerNavigation.php";
            ?>

            <script>
                role = "<?php echo $_SESSION['role']; ?>";
                if (role == "Superadmin") { document.getElementById("anchorDashboard").href = "superadminMainCMMAI.php"; }
                else if (role == "Operator CMMAI") { document.getElementById("anchorDashboard").href = "operatorMainCMMAI.php"; }
                else if (role == "Operator Ministry") { document.getElementById("anchorDashboard").href = "operator_ministryMain.php"; }
                else if (role == "Observer CMMAI") { document.getElementById("anchorDashboard").href = "dashboardMainCMMAI.php"; }
                else if (role == "Observer Ministry") { document.getElementById("anchorDashboard").href = "dashboardMainMinistry.php"; }
            </script>

            <?php
            // if (isset($_SESSION['program'])) {
            //     $program = $_SESSION['program'];
            // }
            // if (isset($_SESSION['id_program'])) {
            //     $id_program = $_SESSION['id_program'];
            // }
            // if (isset($_SESSION['id_cluster'])) {
            //     $id_cluster = $_SESSION['id_cluster'];
            // }
            
            // if (isset($_GET['id_indikator'])) {
            //     $_SESSION['id_indikator'] = $_GET['id_indikator'];
            //     $id_indikator = $_SESSION['id_indikator'];
            // }
            
            ?>
        </div>

        <div>

        </div>

        <div id="main">
            <?php menu(); ?>

            <div id="right" class="text-black">
                <!-- <div class="wrapper"> -->
                <!-- <div class="content"> -->
                <?php
                if (isset($_POST['id_kegiatan'])) {
                    $id_kegiatan = $_POST['id_kegiatan'];
                } else if (isset($_GET['id_kegiatan'])) {
                    $id_kegiatan = $_GET['id_kegiatan'];
                } else {
                    $id_kegiatan = "";
                    echo "<p>ID tidak valid</p>";
                }


                $idArray = explode("_", $id_kegiatan);
                if (isset($idArray[1])) {
                    $id_indikator = $idArray[0] . "_" . $idArray[1] . "_" . $idArray[2];
                    $id_program = $idArray[0] . "_" . $idArray[1];
                    $id_cluster = $idArray[0];

                    // $sql = "SELECT YEAR(date_end) AS year, MONTH(date_end) AS month, DAY(date_end) AS day, 
                    //             kegiatan, lokasi, status, problem,  comment, evidence FROM tb_kegiatan WHERE id_kegiatan='$id_kegiatan'";
                    $kegiatanInfo = parentFromId($id_kegiatan, "tb_kegiatan");

                    $kegiatan = $kegiatanInfo['kegiatan'];
                    $lokasi = $kegiatanInfo['lokasi'];

                    $dateStarted = dateToText($kegiatanInfo['tanggal_mulai']);
                    $dateEnd = dateToText($kegiatanInfo['tanggal_berakhir']);

                    $status = $kegiatanInfo['status'];

                    $indikatorInfo = parentFromId($id_indikator, "tb_indikator");
                    $indikator = $indikatorInfo['indikator'];

                    $sqlColProgram = "SELECT colName1, type1 FROM tb_colname_program WHERE id='$id_cluster'";
                    $resultColProgram = $conn->query($sqlColProgram);
                    if ($resultColProgram->num_rows > 0) {
                        $arrayColTb = $resultColProgram->fetch_assoc();
                    }

                    $arrayColName = str_replace("'", "", $arrayColTb['colName1']);
                    $arrayColName = explode(", ", $arrayColName);

                    $id_clusterEdited = strtolower(str_replace("-", "_", $id_cluster));
                    $sqlProgram = "SELECT * FROM tb_program_$id_clusterEdited WHERE id='$id_program'";
                    $resultProgram = $conn->query($sqlProgram);
                    if ($resultProgram->num_rows > 0) {
                        while ($rowProgram = $resultProgram->fetch_assoc()) {
                            $colNameProgram = $arrayColName[2];
                            $program = $rowProgram[$colNameProgram];
                            $pic = $rowProgram['instansi_terkait'];
                        }
                    }

                    $clusterInfo = parentFromId($id_cluster, "tb_cluster");
                    $cluster = $clusterInfo['cluster'];

                    ?>
                    <div class="box" style="width:100%">
                        <div class="d-flex justify-content-between">
                            <strong>
                                <h3>Details</h3>
                            </strong>
                            <button onclick="backKegiatan()">Back</button>
                        </div>
                        <form id="backKegiatan" action=""></form>
                        <script>
                            function backKegiatan() {
                                role = "<?php echo $_SESSION['role']; ?>";
                                if (role == "Superadmin") { document.getElementById("backKegiatan").action = "kegiatanTabelSuperadmin.php"; document.getElementById("backKegiatan").submit(); }
                                else if (role == "Operator CMMAI") { document.getElementById("backKegiatan").action = "kegiatanTabelOperatorCMMAI.php"; document.getElementById("backKegiatan").submit(); }
                                else if (role == "Operator Ministry") { document.getElementById("backKegiatan").action = "kegiatanTabelOperatorMinistry.php"; document.getElementById("backKegiatan").submit(); }
                                else if (role == "Observer CMMAI") { document.getElementById("backKegiatan").action = "kegiatanObserverCMMAI.php"; document.getElementById("backKegiatan").submit(); }
                                else if (role == "Observer Ministry") { document.getElementById("backKegiatan").action = "kegiatanTabelObserverMinistry.php"; document.getElementById("backKegiatan").submit(); }

                            }
                        </script>
                        <hr>
                        <div class="activity-row w-100 d-flex justify-content-between">
                            <div>Tanggal Mulai:
                                <?php echo $dateStarted; ?>
                            </div>
                            <div>Tanggal Berakhir:
                                <?php echo $dateEnd; ?>
                            </div>
                        </div>
                        <br>
                        <h4><b>Cluster:</b>
                            <?php echo $cluster; ?>
                        </h4>
                        <h4><b>Program:</b>
                            <?php echo $program; ?>
                        </h4>
                        <h4><b>Indikator:</b>
                            <?php echo $indikator; ?>
                        </h4>
                        <h4 style="margin-bottom: 5px;"><b>Kegiatan:</b>
                            <?php echo $kegiatan; ?>
                        </h4>
                        <div>
                            <h4>Status:
                                <?php echo $status; ?>
                            </h4>
                        </div>
                        <div>
                            <h4>Lokasi:
                                <?php echo $lokasi; ?>
                            </h4>
                        </div>

                        <div>
                            <h4>Problem & Evidence</h4>
                            <?php
                            if ($_SESSION['role'] == "Superadmin" || $_SESSION['role'] == "Operator CMMAI" || $_SESSION['role'] == "Operator Ministry") {
                                $linkProbEvi = "window.location.href='add_problem_evidence_page.php?id_kegiatan=$id_kegiatan'";
                                echo "<button type='button' class='btn btn-success' onclick=\"$linkProbEvi\">Add Problem & Evidence</button>";
                            }

                            $kegiatanInfo = parentFromId($id_kegiatan, "tb_kegiatan");

                            $sqlProblem = "SELECT * FROM tb_kegiatanproblem WHERE id_kegiatan='$id_kegiatan'";
                            $resultProblem = $conn->query($sqlProblem);
                            if ($resultProblem->num_rows > 0) {
                                echo "<h5>List Problem</h5>";
                                echo "<ol>";
                                while ($rowProblem = $resultProblem->fetch_assoc()) {
                                    $problem = $rowProblem['problem'];
                                    echo "<li>$problem</li>";
                                }
                                echo "</ol>";
                            } else {
                                echo "<h5>Problem: 0 data</h5>";
                            }

                            ?>

                            <?php
                            $sql = "SELECT * FROM tb_kegiatanevidence WHERE id_kegiatan='$id_kegiatan' AND flag_active=1
                                    ORDER BY created_at ASC";
                            $result = mysqli_query($conn, $sql);

                            if ($result->num_rows > 0) {
                                echo "<h5>Evidence</h5>";
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
                                            echo "<p style='font-size: 40px;'>" . $type . "<br></p>";
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
                                        $indexFile++;
                                    }

                                }
                            } else {
                                echo "<h5>Evidence: 0 data</h5>";
                            }




                            //echo "<img src='{$data['file_directory']}' width='40%' height='40%'>";
                        
                            //$file = 'upload/Progress 25 Maret.pdf'; // Replace with your file path
                        

                            ?>
                        </div>
                        <br>
                        <div class="mx-3 mb-3" style="background-color:white">
                            Comment:
                            <div class="containers">
                                <!--<div class="row">
                                    <div class="col-lg-3">
                                        <div class="btn-panel btn-panel-conversation">
                                            <a href="" class="btn  col-lg-6 send-message-btn " role="button"><i
                                                    class="fa fa-search"></i> Search</a>
                                        </div>
                                    </div>

                                </div>-->
                                <div class="row">
                                    <div class="message-wrap col-lg-8" style="width:90%; justify-content: center; ">
                                        <?php
                                        $sqlComment = "SELECT * FROM tb_commentkegiatan WHERE id_kegiatan='$id_kegiatan' ORDER BY created_at ASC";
                                        $resultComment = $conn->query($sqlComment);
                                        if ($resultComment->num_rows > 0) {
                                            echo '<div class="msg-wrap">';
                                            // output data of each row
                                            while ($row = $resultComment->fetch_assoc()) {
                                                $id_kegiatan = $row['id_kegiatan'];
                                                $id_comment = $row['id'];
                                                $comment = $row['comment'];
                                                $name = $row['created_by'];
                                                $id_user = $row['id_user'];

                                                $created_at = $row['created_at'];
                                                $created_at = explode(" ", $created_at);
                                                $dateCreated = dateToText($created_at[0]);
                                                $dateCreated = $dateCreated . " " . $created_at[1];

                                                $nameRole = "SELECT * FROM tb_master_pic WHERE id = '$id_user'";
                                                $resultPIC = $conn->query($nameRole);
                                                if ($resultPIC->num_rows > 0) {
                                                    // output data of each row
                                                    while ($rowPIC = $resultPIC->fetch_assoc()) {
                                                        $id_pic = $rowPIC['id'];
                                                        $id_kementrian = $rowPIC['id_kementrian'];
                                                        $nama_pic = $rowPIC['nama_pic'];
                                                        $roleName = $rowPIC['role'];

                                                        if ($roleName == 'Observer CMMAI' || $roleName == 'Operator CMMAI') {
                                                            $roleName = str_replace("CMMAI", "Kemenko Marves", $roleName);
                                                        } else if ($roleName == 'Observer Ministry' || $roleName == 'Operator Ministry') {
                                                            $roleName = str_replace("Ministry", $id_kementrian, $roleName);
                                                        } else if ($roleName == 'Superadmin') {
                                                            $roleName = $roleName . " Kemenko Marves";
                                                        }

                                                    }
                                                } else {
                                                    echo "0 results";
                                                }

                                                echo '<div class="media msg">';

                                                echo '<div class="media-body">';
                                                echo '<small class="pull-right time"><i class="fa fa-clock-o"></i>' . $dateCreated . '</small>';

                                                echo '<h5 class="media-heading">' . $name . '(' . $roleName . ')' . '</h5>';
                                                echo '<small class="col-lg-10">' . $comment . '</small>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            echo "</div>";
                                        } else {
                                            //echo "0 data";
                                        }

                                        ?>


                                        <form id="addComment" action="addComment.php" method="post">
                                            <div class="send-wrap ">
                                                <textarea class="form-control send-message" rows="3"
                                                    placeholder="Write a reply..." name="comment" required></textarea>
                                            </div>
                                            <input type="hidden" value="<?php echo $id_kegiatan; ?>" name="id_kegiatan"
                                                id="id_kegiatanForm">
                                            <div class="btn-panel">
                                                <input type="submit"
                                                    class=" col-lg-4 text-right btn   send-message-btn pull-right"
                                                    value="Send Message">
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <?php
                }
                ?>
                <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
        <?php $conn->close(); ?>
    </div>
</body>

</html>