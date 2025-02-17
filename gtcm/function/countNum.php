<?php
    function countNum($sql){
        include('connection.php');
        # note that it is not ==, but '=' (assign value to result and check the value of result)
        if ($result = $conn->query($sql)) {
        // Return the number of rows in result set
            $sqlCount = mysqli_num_rows($result);
        }
        return $sqlCount;
    }
?>