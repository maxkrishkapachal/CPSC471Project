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
                        'ID' INT NOT NULL,
                        'release_date' DATE NULL,
                        'title' TEXT NOT NULL,
                        'ranking' INT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "MEDIA_GENRE":
                    $query = "CREATE TABLE MEDIA_GENRE (
                        'ID' INT NOT NULL,
                        'genre' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "BOOK":
                    $query = "CREATE TABLE BOOK (
                        'ID' INT NOT NULL,
                        'chapters' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "MOVIE":
                    $query = "CREATE TABLE MOVIE (
                        'ID' INT NOT NULL,
                        'duration' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "VIDEO_GAME":
                    $query = "CREATE TABLE VIDEO_GAME (
                        'ID' INT NOT NULL,
                        'platform' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "PERSONAL_LIST":
                    $query = "CREATE TABLE PERSONAL_LIST (
                        'ID' INT NOT NULL,
                        'name' TEXT NOT NULL,
                        PRIMARY KEY ('ID')
                    )";
                    break;
                case "LIST_ENTRIES":
                    $query = "CREATE TABLE LIST_ENTRIES (
                        'listID' INT NOT NULL,
                        'mediaID' INT NOT NULL
                    )";
                    break;
                case "LOGS":
                    $query = "CREATE TABLE LOGS (
                        'logID' INT NOT NULL,
                        'date' TEXT NOT NULL,
                        'remarks' TEXT NULL,
                        'rating' INT NULL, 
                        'mediaID' INT NOT NULL,
                        'username' TEXT NOT NULL,
                        PRIMARY KEY ('logID')
                    )";
                    break;
                case "COMMENT":
                    $query = "CREATE TABLE COMMENT (
                        'commentID' TEXT NOT NULL,
                        'userID' TEXT NOT NULL,
                        'date' DATE NOT NULL,
                        PRIMARY KEY ('commentID')
                    )";
                    break;
                case "PUBLISHER":
                    $query = "CREATE TABLE PUBLISHER (
                        'name' TEXT NOT NULL,
                        PRIMARY KEY ('name')
                    )";
                    break;
                case "CREW":
                    $query = "CREATE TABLE CREW (
                        'crewID' TEXT NOT NULL,
                        'nams' TEXT NOT NULL,
                        'role' TEXT NOT NULL,
                        PRIMARY KEY ('crewID')
                    )";
                    break;
                case "CAN_INTERACT":
                    $query = "CREATE TABLE CAN_INTERACT (
                        'memberID_1' TEXT NOT NULL,
                        'memberID_2' TEXT NOT NULL
                    )";
                    break;
                case "PUBLISHED":
                    $query = "CREATE TABLE PUBLISHED (
                        'mediaID' TEXT NOT NULL,
                        'publisher' TEXT NOT NULL
                    )";
                    break;
                case "WORKS_ON":
                    $query = "CREATE TABLE WORKS_ON (
                        'mediaID' TEXT NOT NULL,
                        'crewID' TEXT NOT NULL
                    )";
                    break;
                case "EMPLOYS":
                    $query = "CREATE TABLE EMPLOYS (
                        'publisher' TEXT NOT NULL,
                        'crewID' TEXT NOT NULL
                    )";
                    break;
                default:
                    $query = "";
            }
            mysqli_query($conn, $query);
        }
    }
?>