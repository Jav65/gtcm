<?php
ob_get_contents();
ob_end_clean();
session_start();
ob_start();
//include('security.php');
include "connection.php";
include "popup.html";
include "function/myFunc.php";
// if(!isset($_SESSION['role']))
// {
//     header('location:login.html');
// }
// else if($_SESSION['role'] != 'Superadmin'){
//     header("Location: accessDenied.php");    
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style_AddData01.css">
    <?php include "head.html"; ?>
    <!-- Template Main CSS Tabel -->
    <link href="assetsOperatorTabel/css/main.css" rel="stylesheet">
</head>

<body>
    <?php 
    include "headerNavigation.php"; 
    menu();
    ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) && empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0) {
        $text = 'Your file is too big!';
        echo "<script> text = '$text'; showPopup(true,text);</script>";
    } else {
        if (isset($_SESSION['email'])) {
            $email = $_SESSION['email'];
            $sqlIDName = "SELECT * FROM tb_master_pic where email='$email'";
            $resultIDName = $conn->query($sqlIDName);
            if ($resultIDName->num_rows > 0) {
                while ($row = $resultIDName->fetch_assoc()) {
                    $id_pic = $row['id'];
                    $_SESSION['id_pic'] = $id_pic;
                }
                if (isset($_POST['submit'])) {
                    $id_kegiatan = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
                    $kegiatanEvidence = "SELECT * FROM tb_kegiatanEvidence where id_kegiatan='$id_kegiatan'";
                    # note that it is not ==, but '=' (assign value to result and check the value of result)
                    if ($result = $conn->query($kegiatanEvidence)) {
                        // Return the number of rows in result set
                        $kegiatanEvidenceCount = mysqli_num_rows($result) + 1;
                    }
                    $id_evidence = $id_kegiatan . "_EV-" . $kegiatanEvidenceCount;
                    $created_by = $_SESSION['id_pic'];

                    $file = $_FILES['file'];

                    $fileName = $_FILES['file']['name'];
                    $fileTmpName = $_FILES['file']['tmp_name'];
                    $fileSize = $_FILES['file']['size'];
                    $fileError = $_FILES['file']['error'];
                    $fileType = $_FILES['file']['type'];

                    $fileExt = explode('.', $fileName);
                    $fileActualExt = strtolower(end($fileExt));

                    $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'mp4', 'mpeg', 'mp3');

                    if (in_array($fileActualExt, $allowed)) {
                        if ($fileError === 0) {
                            if ($fileSize < 1000000000) {
                                $newFileName = uniqid('', true) . "." . $fileActualExt;
                                $fileDestination = 'upload/' . $newFileName; ///
                                move_uploaded_file($fileTmpName, $fileDestination);

                                $sql = "INSERT INTO tb_kegiatanevidence(id_kegiatan, id, file_name,file_directory, file_type, created_by) 
                                    VALUES('$id_kegiatan', '$id_evidence', '$newFileName','$fileDestination', '$fileType', '$created_by')";
                                $query_run = mysqli_query($conn, $sql);

                                if ($query_run) {
                                    $rows_affected = mysqli_affected_rows($conn);
                                    if ($rows_affected > 0) {
                                        echo "<p class='text-black'>Insert successful</p>";
                                        header("Location:addEvidence.php?id_kegiatan=$id_kegiatan");
                                    } else {
                                        echo "<p class='text-black'>Insert failed</p>";
                                    }
                                } else {
                                    echo "<p class='text-black'>Error executing query: " . mysqli_error($conn) . "</p>";
                                }

                            } else {
                                echo "<p class='text-black'>Your file is too big!</p>";
                            }
                        } else {
                            echo "<p class='text-black'>There was an error uploading your file!</p>";
                        }
                    } else {
                        echo "<p class='text-black'>You cannot upload files of this type!</p>";
                    }
                }
            }
            echo "<p>Invalid email</p>";
        }
        else{
            echo "<p>Invalid email</p>";
        }

    }
    ?>

    <?php
    if (isset($_POST['id_kegiatan'])) {
        $id_kegiatan = $_POST['id_kegiatan'];
    } else {
        $id_kegiatan = "";
    }
    $linkEvidence = "window.location.href='addEvidence.php?id_kegiatan=$id_kegiatan'";

    echo "<button type='button' class='btn btn-dark' onclick=\"$linkEvidence\">Back</button>";
    ?>

</body>

</html>