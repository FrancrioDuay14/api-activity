<?php require("functions.php");?>
<?php
    // Set headers to allow cross-origin requests
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];

    if($method == "GET"){
        $sql = "SELECT * FROM tbl_students";
        if(isset($_GET['id'])){
            $sql = "SELECT * FROM tbl_students WHERE id =" . $_GET['id'];
        }
        $con = openConn(); 
        $result = mysqli_query($con, $sql);
      
        if (mysqli_num_rows($result) > 0) {
        
            while($row = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
                $data = $row;
            }
        } 
        else {
            $data = "0 results";
        }
        mysqli_free_result($result);
        closeConn($con);   
        echo json_encode($data);
    }


    if($method == "POST"){
        $data = urldecode(file_get_contents('php://input'));
        
        $value = json_decode($data, TRUE);

        $sql = "INSERT INTO tbl_students (name, course) VALUES (?,?)";
    
      
        $con = openConn(); 
       
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $name, $course);
            
            $name = $value['txtName'];  
            $course = $value['txtCourse'];  
            mysqli_stmt_execute($stmt);
        }
        else{
            echo json_decode("No Record Found");
        }
        
        mysqli_stmt_close($stmt);
        closeConn($con);  
        $response =
        [
            "message" => "Student  " . $value['txtName'] . " ". $value['txtCourse'] . " was Added",
        ];
        echo json_encode($response);
    }
    
    if($method == "PUT"){
        $response = null;
        $sql = null;

        $data = urldecode(file_get_contents('php://input'));
        
        $value = json_decode($data, TRUE);

        if(isset($_GET['id'])){
            $name = $value['txtName'];  
            $course = $value['txtCourse']; 
            $sql = "UPDATE tbl_students SET name = ' $name', course = ' $course' WHERE id = " . $_GET['id'];
            $response =
            [
                "message" => "Student  " . $value['txtName'] . " ". $value['txtCourse'] . " was Updated",
            ];
            echo json_encode($response);
        }
        else{
            die("Error ID");
        }

        $con = openConn(); 
        
        if (mysqli_query($con, $sql)) {
            $message = "Record Update Successful";
        } 
        else {
            $message = "Error Updating record";
        }
        closeConn($con); 
        echo json_encode($message);      
    }

    // if($method == "DELETE") {
    //     if(isset($_GET['id'])) {
    //         if(isset($data[$_GET['id']])) {
    //             unset($data[$_GET['id']]);
                
    //             $response = [
    //                 "message" => "Delete Success",
    //                 "data" => $data
    //             ];
    //             echo json_encode($response);
    //         }                
    //         else {
    //             echo json_encode('No Record Found!');
    //         }
    //     }
    //     else        
    //         echo json_encode('No Record Found!');
    // }


?>