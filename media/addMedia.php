<?php 
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $user_data = getUserData($conn);

    if(isset($_REQUEST['add'])){
        $id = createID('MED', $user_data['username']);
        $title = convertQuotes($_POST['title'], "SYMBOLS");
        $rd = convertQuotes($_POST['release_date'], "SYMBOLS");
        $desc = convertQuotes($_POST['description'], "SYMBOLS");
        $mtype = convertQuotes($_POST['media_type'], "SYMBOLS");
        $misc = convertQuotes($_POST['misc'], "SYMBOLS");

        if(!empty($title)){
            checkTable($conn, 'MEDIA');
            $title_check = "
              SELECT ID
              FROM MEDIA
              WHERE title = '$title'; 
            ";

            $title_result = mysqli_query($conn, $title_check);

            if($title_result && mysqli_num_rows($title_result) == 0){
                $query = "
                    INSERT 
                    INTO MEDIA
                    (ID, release_date, title, description, media_type) VALUES
                    ('$id', '$rd', '$title', '$desc','$mtype')
                ";
                
                mysqli_query($conn, $query);
                
                switch($mtype){
                    case "Book":
                        checkTable($conn, "BOOK");
                        $query = "
                            INSERT
                            INTO BOOK VALUES
                            ('$id', '$misc')
                        ";
                        mysqli_query($conn, $query);
                        break;
                    case "Movie":
                        checkTable($conn, "MOVIE");
                        $query = "
                            INSERT
                            INTO MOVIE VALUES
                            ('$id', '$misc')
                        ";
                        mysqli_query($conn, $query);
                        break;
                    case "Video Game":
                        checkTable($conn, "VIDEO_GAME");
                        $query = "
                            INSERT
                            INTO VIDEO_GAME VALUES
                            ('$id', '$misc')
                        ";
                        mysqli_query($conn, $query);
                        break;
                    default:
                }

                header("Location: ../acc/search.php");
                die;
            }
        }
    }    
    if(isset($_REQUEST['cancel'])){
        header('Location: ../acc/search.php'); 
        die;
    }
?> 


<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        
        <div class="form-wrap">
            <div class="tabs-content">
            <div class="active">
                <form class="add-media-form" action="" method="post">
                <input name="title" type="text" class="input" id="title" autocomplete="off" placeholder="Title*">
                <input name="release_date" type="text" class="input" id="release_date" autocomplete="off" placeholder="Release Date">
                <input name="description" type="text" class="input" id="description" autocomplete="off" placeholder="Description">
                
                <fieldset>Media type
                <div>
                <input type="radio" id="Book" name="media_type" value="Book" />
                <label for="Book">Book</label>    
                </div>
                <div>
                <input type="radio" id="Movie" name="media_type" value="Movie" />
                <label for="Movie">Movie</label>
                </div>
                <div>
                <input type="radio" id="Video Game" name="media_type" value="Video Game" />
                <label for="Video game">Video Game</label>
                </div>
                </fieldset>
                <br>

                <input name="misc" type="text" class="input" autocomplete="off" placeholder="Duration/Chapters/Platform">
                
                <input name="add" type="submit" class="button" value="Add Media">
                <input name="cancel" type="submit" class="button" value="Cancel">
                </form>
            </div>
            </div>
        </div>
    </body>
</html>
