<?php
    DEFINE("DB_SERVER", "localhost");
    DEFINE("DB_USERNAME", "root");
    DEFINE("DB_PASSWORD", "");
    DEFINE("DB_NAME", "practice_students_db");

    function openConn(){
        $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            if($con === false)
                die("ERROR: Could not connect" . mysqli_connect_error());

            return($con);
    }
    function closeConn($con){
        mysqli_close($con);

    }
?>