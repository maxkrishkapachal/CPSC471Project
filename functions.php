<?php 
    function getUserData($conn) {
        if(isset($_SESSION['username'])) {
            $user = $_SESSION['username'];
            $query = "
                SELECT *
                FROM USER
                WHERE username = '$user'";

            $result = mysqli_query($conn, $query);
            if($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                return $user_data;
            }
        }
        else {
            header("Location: login.php");
            die;
        }
    }

    function createID($type){

    }

    function checkTable($table){
        
    }
?>