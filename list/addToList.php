<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

    $user_data = getUserData($conn);
    $itemID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $itemID = $_GET['element'];
    }

    if(isset($_REQUEST['back-button'])){
        $itemID = $_POST['itemID'];
        returnAddy($itemID);
    }

    if(isset($_REQUEST['add-to-list-button']) && isset($_REQUEST['list-instance'])){
        # for list elements, we need username, mediaID, listID, and we need to generate
        # an elementID
        $itemID = $_POST['itemID'];
        $listID = $_POST['list-instance'];
        $username = $user_data['username'];
        $elementID = createID("ELE", $username);

        checkTable($conn, 'ELEMENT');

        $element_query = "
            INSERT
            INTO ELEMENT
            VALUES ('$elementID', '$listID', '$itemID')
        ";

        mysqli_query($conn, $element_query);

        returnAddy($itemID);
    }

    function returnAddy($itemID){
        $element_type = explode("-", $itemID);
        $return_add = "Location: ../media/publisher.php?name=$itemID";

        if($element_type[1] == "MED"){
            $return_add = "Location: ../media/media.php?id=$itemID";
        }

        else if($element_type[1] == "CRE"){
            $return_add = "Location: ../media/crew.php?crewID=$itemID";
        }

        header($return_add); 
        die;
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <form method='post'>
            <div class='account'>
                <div class='row-of-buttons'>
                    <input class='btn btn-input' type='submit' name='back-button' value='Cancel'>
                </div>
                <div class='welcome-label-div'>
                    <label class='welcome-label'>Choose A List</label>
                </div>
            </div>
            <div class='main-page-container'>   
                <div class='log ll-box'> 
                    <div class='mpc-buttons'>
                        <input class='btn btn-input' type='submit' name='add-to-list-button' value='Add To List'>
                    </div>
                    <div class='scroll scroll-elem'>
                        <div class='scr'>
                            <?php  
                                checkTable($conn, 'LIST');

                                $username = $user_data['username'];
                                
                                $lists = "
                                    SELECT *
                                    FROM LIST
                                    WHERE username = '$username'
                                ";

                                $lists_result = mysqli_query($conn, $lists);

                                while($row = mysqli_fetch_assoc($lists_result)){
                                    # need to print out media name, rating, remarks, date
                                    $name = convertQuotes($row['name'], "QUOTES");
                                    $desc = convertQuotes($row['description'], "QUOTES");
                                    $listID = $row['listID'];

                                    ?>
                                        <div class='instance'>
                                            <input hidden name='itemID' value='<?php echo $itemID ?>'>
                                            <input class='instance-block' name='list-instance' type='radio' value='<?php echo $listID ?>'>
                                            <div class='instance-block in-name' name='name'>
                                                <?php echo $name?>
                                            </div>
                                            <div class='instance-block in-desc' name='desc'>
                                                <?php echo $desc ?>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>