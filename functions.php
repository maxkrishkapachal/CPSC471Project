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

    function checkTable($conn, $table){
        $check = mysqli_query($conn, "SELECT 1 FROM '$table'");
        if($check == FALSE){
            $query = NULL;
            switch($table){
                case "USER":
                    $query = "CREATE TABLE USER (
                        'username' TEXT NOT NULL,
                        'email_address' TEXT NOT NULL,
                        'password' TEXT NOT NULL,
                        'name' TEXT NULL DEFAULT NULL,
                        'bio' TEXT NULL DEFAULT NULL,
                        'user_type' TEXT NULL DEFAULT 'MEMBER',
                        PRIMARY KEY ('username', 'email_address')
                    )";
                    break;
                case "MEDIA":
                    $query = "CREATE TABLE MEDIA (
                        'ID' TEXT NOT NULL,
                        'release_date' DATE NULL,
                        'title' TEXT NOT NULL,
                        'ranking' INT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "MEDIA_GENRE":
                    $query = "CREATE TABLE MEDIA_GENRE (
                        'ID' TEXT NOT NULL,
                        'genre' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "BOOK":
                    $query = "CREATE TABLE BOOK (
                        'ID' TEXT NOT NULL,
                        'chapters' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "MOVIE":
                    $query = "CREATE TABLE MOVIE (
                        'ID' TEXT NOT NULL,
                        'duration' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "VIDEO_GAME":
                    $query = "CREATE TABLE VIDEO_GAME (
                        'ID' TEXT NOT NULL,
                        'platform' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                default:
                    $query = "";
            }
            mysqli_query($conn, $query);
        }
    }
?>