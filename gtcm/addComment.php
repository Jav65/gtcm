<?php
session_start();
ob_start();
include "connection.php";
$email = $_SESSION['email'];
$sqlUser = "SELECT * FROM tb_master_pic WHERE email='$email'";
$resultUser = $conn->query($sqlUser);

if ($resultUser->num_rows > 0) {
    // output data of each row
    while ($rowUser = $resultUser->fetch_assoc()) {
        $id_pic = $rowUser['id'];
        $name = $rowUser['nama_pic'];
        $comment = mysqli_real_escape_string($conn, $_POST['comment']);
        $id_kegiatan = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);

        $kegiatanComment = "SELECT * FROM tb_commentkegiatan where id_kegiatan='$id_kegiatan'";
        if ($result = $conn->query($kegiatanComment)) {
            // Return the number of rows in result set
            $kegiatanCommentCount = mysqli_num_rows($result) + 1;
        }

        $id_comment = $id_kegiatan . "_CO-" . $kegiatanCommentCount;

        $sql = "INSERT INTO tb_commentkegiatan (id_kegiatan, id, comment, id_user, created_by)
                VALUES ('$id_kegiatan', '$id_comment', '$comment', '$id_pic', '$name')";

        if ($conn->multi_query($sql) === TRUE) {
            echo "New records created successfully";
            $linkKegiatan = "Location: kegiatanDetail.php?id_kegiatan=$id_kegiatan";
            header($linkKegiatan);
        }
        else{echo "not successful";}

        echo $id_pic . "<br>";
        echo $name . "<br>";
        echo $comment . "<br>";
        echo $id_kegiatan . "<br>";
        echo $id_comment . "<br>";
    }
} else {
    echo "Not successful";
}
$conn->close();
?>