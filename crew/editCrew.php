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
    $desc = convertQuotes($crew['description'], "QUOTES");


    if(isset($_REQUEST['save'])){
        $name = convertQuotes($_POST['name'], "SYMBOLS");
        $desc = convertQuotes($_POST['desc'], "SYMBOLS");

        if(!empty($name)){
            $crew_edit = "
                UPDATE CREW
                SET name = '$name', description = '$desc'
                WHERE crewID = '$crewID'
            ";
                
            mysqli_query($conn, $crew_edit);
            
            returnAddy($crewID);
        }
    }

    if(isset($_REQUEST['cancel'])){
        returnAddy($crewID);
    }

    function returnAddy($crewID){
        $_SESSION['crew'] = $crewID;
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
                    <form class="edit-crew-form" action="" method="post">
                        <input name="name" type="text" class="input" autocomplete="off" placeholder="Name*" value="<?php echo $name ?>">
                        <input name="desc" type="text" class="input" autocomplete="off" placeholder="Desc" value="<?php echo $desc ?>">
              
                        <input name="save" type="submit" class="button" value="Save Crew">
                        <input name="cancel" type="submit" class="button" value="Cancel">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>