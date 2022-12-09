<?php
    session_start();

    include("../gen/connect.php");
    include('../gen/functions.php');

    $crewID = $_SESSION['crewID'];
    $user_data = getUserData($conn);

    checkTable($conn, 'CREW');

    $get_crew = "
        SELECT *
        FROM CREW
        WHERE crewID = '$crewID'
    ";

    $crew_result = mysqli_query($conn, $get_crew);

    if($crew_result && mysqli_num_rows($crew_result) == 1){
        $crew = mysqli_fetch_assoc($crew_result);
    }

    $name = convertQuotes($crew['name'], "QUOTES");
    
    if(isset($_REQUEST['delete'])){
        $crew_delete = "
            DELETE 
            FROM CREW
            WHERE crewID = '$crewID'
        ";
            
        mysqli_query($conn, $crew_delete);

        $crew_delete = "
            DELETE 
            FROM ELEMENT
            WHERE mediaID = '$crewID'
        ";
            
        mysqli_query($conn, $crew_delete);

        $crew_delete = "
            DELETE 
            FROM EMPLOYS
            WHERE crewID = '$crewID'
        ";
            
        mysqli_query($conn, $crew_delete);

        $crew_delete = "
            DELETE 
            FROM WORKS_ON
            WHERE crewID = '$crewID'
        ";
            
        mysqli_query($conn, $crew_delete);

        header("Location: ../acc/search.php");
        die;
    }

    if(isset($_REQUEST['cancel'])){
        $_SESSION['crewID'] = $crewID;
        header("Location: ../media/crew.php");
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
                    <form class="delete-log-form" action="" method="post">
                        <div class='media-title-div'>
                            <label class='media-title'>Are you sure you want to delete <?php echo $name ?>?</label>
                        </div>
                        
                        <input name="delete" type="submit" class="button" value="Delete">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

