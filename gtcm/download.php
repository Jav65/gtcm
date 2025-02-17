<?php
// include "connection.php";
// include "function/myFunc.php";
// if(isset($_GET['id_evidence'])){
//     $id_evidence = $_GET['id_evidence'];
//     echo $id_evidence . "<br>";
//     $sqlEvidence = "SELECT * FROM tb_kegiatanevidence WHERE id='$id_evidence'";
//     $resultEvidence = $conn->query($sqlEvidence);
//     if($resultEvidence->num_rows > 0){
//         $evidenceInfo = $resultEvidence->fetch_assoc();
//     }
    
//     $filename = basename($evidenceInfo['file_name']);
//     $filepath = 'upload/' . $filename;
//     if (!empty($filename) && file_exists($filepath)) {
//         header("Cache-Control: public");
//         header("Content-Description: File Transfer");
//         header("Content-Disposition: attachment; filename=$filename");
//         header("Content-Type: application/zip");
//         header("Content-Transfer-Encoding: binary");
//         readfile($filepath);
//         exit;
//     } else {
//         echo "This file does not exist.";
//     }
// }


if(!empty($_GET['file'])){
    $filename = basename($_GET['file']);
    $filepath = 'upload/'.$filename;
    if(!empty($filename)&&file_exists($filepath)){
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        readfile($filepath);
        exit;
    }
    else{
        echo "This file does not exist.";
    }
}
?>