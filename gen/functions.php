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
            header("Location: ../acc/login.php");
            die;
        }
    }

    function filterSearch($search){
        # so, we'll check if there is :"$" 
        # if there is, we'll grab the letters before it
        # and we'll cycle through them and if it's the first one,
        # we'll say "WHERE" and for all subsequent ones, we'll say "OR"
        # and depending on the letter, we'll print a different thing, so
        # we'll use a switch
        preg_match('/:"(.*?)"/', $search, $matches);
        return $matches;
    }

    function createID($type, $username){
        return "$username-$type-" .date("Ymd") . "-" . date("His");
    }

    function getDateTime(){
        return date("Y") . "-" . date("m") . "-" . date("d") . " " . date("H") . ":" . date("i") . ":" . date("s");
    }

    function convertQuotes($text, $convertTo){
        # <@ is a single quote now and @> is a double
        if($convertTo == "QUOTES"){
            $text = str_replace("<@", "'", $text);
            $text = str_replace("@>", '"', $text);
        }
        else if($convertTo == "SYMBOLS"){
            $text = str_replace("'", "<@", $text);
            $text = str_replace('"', '@>', $text);
        }
        return $text;
    }

    function checkTable($conn, $table){
        $check = mysqli_query($conn, "
            SELECT *
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = 'CPSC471'
            AND TABLE_NAME = '$table';");
        if($check && mysqli_num_rows($check) == 0){
            $query = NULL;
            switch($table){
                case "USER":
                    $query = "CREATE TABLE CPSC471.USER (
                        `username` VARCHAR(50) NOT NULL,
                        `email_address` VARCHAR(50) NOT NULL,
                        `password` TEXT NOT NULL,
                        `name` TEXT NULL DEFAULT NULL,
                        `bio` TEXT NULL DEFAULT NULL,
                        `user_type` TEXT NULL DEFAULT `MEMBER`,
                        PRIMARY KEY (`username`(50), `email_address`(50))
                    ) Engine = InnoDB;";
                    break;
                case "MEDIA":
                    $query = "CREATE TABLE CPSC471.MEDIA (
                        `ID` VARCHAR(50) NOT NULL,
                        `release_date` VARCHAR(20) NULL,
                        `title` TEXT NOT NULL,
                        `description` TEXT NULL,
                        `ranking` INT NULL,
                        `media_type` VARCHAR(12) NOT NULL,
                        PRIMARY KEY (`ID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "MEDIA_GENRE":
                    $query = "CREATE TABLE CPSC471.MEDIA_GENRE (
                        `ID` VARCHAR(50) NOT NULL,
                        `genre` TEXT NOT NULL,
                        PRIMARY KEY (`ID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "BOOK":
                    $query = "CREATE TABLE CPSC471.BOOK (
                        `ID` VARCHAR(50) NOT NULL,
                        `chapters` TEXT NOT NULL,
                        PRIMARY KEY (`ID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "MOVIE":
                    $query = "CREATE TABLE CPSC471.MOVIE (
                        `ID` VARCHAR(50) NOT NULL,
                        `duration` TEXT NOT NULL,
                        PRIMARY KEY (`ID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "VIDEO_GAME":
                    $query = "CREATE TABLE CPSC471.VIDEO_GAME (
                        `ID` VARCHAR(50) NOT NULL,
                        `platform` TEXT NOT NULL,
                        PRIMARY KEY (`ID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "LIST":
                    $query = "CREATE TABLE CPSC471.LIST (
                        `listID` VARCHAR(50) NOT NULL,
                        `name` TEXT NOT NULL,
                        `description` TEXT NULL,
                        `username` VARCHAR(50) NOT NULL,
                        PRIMARY KEY (`ID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "ELEMENT":
                    $query = "CREATE TABLE CPSC471.ELEMENT (
                        `elementID` VARCHAR(50) NOT NULL,
                        `listID` VARCHAR(50) NOT NULL,
                        `mediaID` VARCHAR(50) NOT NULL
                    ) Engine = InnoDB;";
                    break;
                case "LOGS":
                    $query = "CREATE TABLE CPSC471.LOGS (
                        `logID` VARCHAR(50) NOT NULL,
                        `date` VARCHAR(20) NOT NULL,
                        `remarks` TEXT NULL,
                        `rating` INT NULL, 
                        `mediaID` VARCHAR(50) NOT NULL,
                        `username` VARCHAR(50) NOT NULL,
                        `medianame` VARCHAR(70) NOT NULL,
                        PRIMARY KEY (`logID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "COMMENT":
                    $query = "CREATE TABLE CPSC471.COMMENT (
                        `content` VARCHAR(100) NOT NULL,
                        `commentID` VARCHAR(50) NOT NULL,
                        `mediaID` VARCHAR(50) NOT NULL,
                        `username` VARCHAR(50) NOT NULL,
                        `date` VARCHAR(20) NOT NULL,
                        PRIMARY KEY (`commentID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "PUBLISHER":
                    $query = "CREATE TABLE CPSC471.PUBLISHER (
                        `name` VARCHAR(50) NOT NULL,
                        `description` VARCHAR(100) NULL,
                        PRIMARY KEY (`name`(50))
                    ) Engine = InnoDB;";
                    break;
                case "CREW":
                    $query = "CREATE TABLE CPSC471.CREW (
                        `crewID` VARCHAR(50) NOT NULL,
                        `name` TEXT NOT NULL,
                        `description` VARCHAR(50) NULL,
                        PRIMARY KEY (`crewID`(50))
                    ) Engine = InnoDB;";
                    break;
                case "CAN_INTERACT":
                    $query = "CREATE TABLE CPSC471.CAN_INTERACT (
                        `memberID_1` VARCHAR(50) NOT NULL,
                        `memberID_2` VARCHAR(50) NOT NULL
                    ) Engine = InnoDB;";
                    break;
                case "PUBLISHED":
                    $query = "CREATE TABLE CPSC471.PUBLISHED (
                        `mediaID` VARCHAR(50) NOT NULL,
                        `publisher` VARCHAR(50) NOT NULL
                    ) Engine = InnoDB;";
                    break;
                case "WORKS_ON":
                    $query = "CREATE TABLE CPSC471.WORKS_ON (
                        `mediaID` VARCHAR(50) NOT NULL,
                        `crewID` VARCHAR(50) NOT NULL,
                        `role` VARCHAR(50) NULL
                    ) Engine = InnoDB;";
                    break;
                case "EMPLOYS":
                    $query = "CREATE TABLE CPSC471.EMPLOYS (
                        `publisher` VARCHAR(50) NOT NULL,
                        `crewID` VARCHAR(50) NOT NULL
                    ) Engine = InnoDB;";
                    break;
                case "STATISTIC":
                    $query = "CREATE TABLE CPSC471.STATISTIC (
                        `media_id` VARCHAR(50) NOT NULL,
                        `rate` VARCHAR(10) NULL,
                        PRIMARY KEY (`media_id`(50))
                    ) Engine = InnoDB;";
                    break;
                case "MEDIA_TAG":
                    $query = "CREATE TABLE CPSC471.MEDIA_TAG (
                        `mediaid` VARCHAR(50) NOT NULL,
                        `tag` VARCHAR(50) NOT NULL   
                    ) Engine = InnoDB;";
                    break;
                default:
                    echo "Something is wrong with the tables you checked";
                    $query = "";
            }
            mysqli_query($conn, $query);
        }
        else return;
    }

    function checkAdminCode($code) {
        if($code == "GhostlyBluePenguin") return true;
        else return false;
    }
?>