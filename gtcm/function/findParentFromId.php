<?php
function parentFromId($id, $tableName)
{
    include('connection.php');
    $sql = "SELECT * FROM $tableName WHERE id='$id' ORDER BY updated_at ASC";
    //echo $sql . "*<br>";
    $result  = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    }

}
//xparentFromId('CL-1', 'tb_cluster');
?>