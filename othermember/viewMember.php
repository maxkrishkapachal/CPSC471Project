<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

    $username = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $username = $_GET['otheruser'];
    }

    $user_data = getUserData($conn);

    $user_query = "
      SELECT *
      FROM USER
      WHERE username = '$username'
    ";

    $user_result = mysqli_query($conn, $user_query);
    $other_user = mysqli_fetch_assoc($user_result);

    $bio = $other_user['bio'];

    
    # view list
    if(isset($_REQUEST['list-instance']) && isset($_REQUEST['view-list-button'])){
        header("Location: ../list/viewList.php?listinst=".$_REQUEST['list-instance']);
        die;
    }

    if(isset($_REQUEST['home-button'])){
      header("Location: ../acc/home.php");
      die;
    }

    # add friend
    if(isset($_REQUEST['add-friend-button'])){
      $member_ID_1 = $username;
      $member_ID_2 = convertQuotes($_POST['userID'], "SYMBOLS");

      if(!empty($member_ID_2)){
          checkTable($conn, 'CAN_INTERACT');

          $query = "INSERT INTO CAN_INTERACT VALUES
              ('$member_ID_1', '$member_ID_2')
          ";
          
          mysqli_query($conn, $query);
          header("Location: ../othermember/viewMember.php?otheruser=".$username);
          die;
      }

          if(isset($_REQUEST['block'])){
    $member_ID_1 = $username;
    $member_ID_2 = convertQuotes($_POST['userID'], "SYMBOLS");

        if(!empty($member_ID_2)){
            checkTable($conn, 'CAN_INTERACT');

            $query = "DELETE 
            FROM CAN_INTERACT
            WHERE (memberID_1 = '$member_ID_1' AND memberID_2 = '$member_ID_2' 
            ) or 
            ( memberID_1 = '$member_ID_2' AND memberID_2 = '$member_ID_1')
            ";
            
            mysqli_query($conn, $query);
            header("Location: ../othermember/viewMember.php?otheruser=".$username);
            die;
        }
    }    

    if(isset($_REQUEST['ban'])){
        $ban_user = convertQuotes($_POST['userID'], "SYMBOLS");
    
            if(!empty($ban_user)){
                checkTable($conn, 'USER');
    
                
                $query = "SELECT *
                FROM USER
                WHERE username = '$ban_user'
            ";
                
                mysqli_query($conn, $query);
                $_SESSION['banuser'] = $ban_user;
                header("Location: ../othermember/deleteMember.php?otheruser=".$username);
                die;
            }
    }    
  }

  if(isset($_REQUEST['block'])){
    $member_ID_1 = $username;
    $member_ID_2 = convertQuotes($_POST['userID'], "SYMBOLS");

        if(!empty($member_ID_2)){
            checkTable($conn, 'CAN_INTERACT');

            $query = "DELETE 
            FROM CAN_INTERACT
            WHERE (memberID_1 = '$member_ID_1' AND memberID_2 = '$member_ID_2' 
            ) or 
            ( memberID_1 = '$member_ID_2' AND memberID_2 = '$member_ID_1')
            ";
            
            mysqli_query($conn, $query);
            header("Location: ../othermember/viewMember.php?otheruser=".$username);
            die;
        }
    }    

    if(isset($_REQUEST['ban'])){
        $ban_user = convertQuotes($_POST['userID'], "SYMBOLS");
    
            if(!empty($ban_user)){
                checkTable($conn, 'USER');
    
                
                $query = "SELECT *
                FROM USER
                WHERE username = '$ban_user'
            ";
                
                mysqli_query($conn, $query);
                $_SESSION['banuser'] = $ban_user;
                header("Location: ../othermember/deleteMember.php");
                die;
            }
    }    

    # block

    # report

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        
        <!-- This page needs:
            - PERSONAL ACCOUNT -
            * edit account 
            * logout
            - MEDIA, CREW, PUBLISHER -
            * search bar for the media, publishers, and crew
            * add new media button, publishers, and crew
            * select media, publisher, or crew
            - LOGS -
            * search logs
            * add log
            * select log
            * edit log
            * delete log
            - COMMENTS -
            * view comments
            - LIST - 
            * add list button
            * search bar for the lists
            * lists
            * select list option
            * delete list option once selected
            * edit list option once selected 
        -->
        <form method='post'>
            <div class='account'>
                <div class='row-of-buttons'>
                    <input class='btn btn-input' type='submit' name='home-button' value='Home'>
                    <input class='btn btn-input' type='submit' name='block-button' value='Block'>
                    <?php
                      if($user_data['user_type'] == "ADMIN"){
                        ?>
                          <input class='btn btn-input' type='submit' name='ban-button' value='Ban'>
                        <?php
                      }
                    ?>
                </div>
                <div class='welcome-label-div'>
                    <label class='welcome-label'>
                        <?php 
                            $name = $other_user['name'];
                            if(!empty($name)) echo $name;
                            else echo $other_user['username'];
                        ?>
                    </label>
                </div>
                <div class='desc-label-div'>
                    <label class='description-label'>
                        <?php
                            echo $bio;
                        ?>
                    </label>
                </div>
            </div>
            <div class='main-page-container'>   
                <div class='log ll-box'> 
                    <div class='scroll scroll-home'>
                        <div class='scr'>
                            <?php  
                                checkTable($conn, 'LOGS');
                                checkTable($conn, "MEDIA");

                                $logs = "
                                    SELECT *
                                    FROM LOGS AS L, MEDIA AS M
                                    WHERE L.username = '$username'
                                    AND L.mediaID = M.ID
                                ";

                                $logs_result = mysqli_query($conn, $logs);

                                while($row = mysqli_fetch_assoc($logs_result)){
                                    # need to print out media name, rating, remarks, date
                                    $medianame = convertQuotes($row['title'], "QUOTES");
                                    $rating = $row['rating'];
                                    $remarks = convertQuotes($row['remarks'], "QUOTES");
                                    $date = $row['date'];
                                    $logID = $row['logID'];
                                    
                                    ?>
                                        <div class='instance'>
                                            <div class='instance-block in-name' name='name'>
                                                <?php echo $medianame ?>
                                            </div>
                                            <div class='instance-block in-rating' name='rating'>
                                                <?php echo $rating ?>
                                            </div>
                                            <div class='instance-block in-remarks' name='remarks'>
                                                <?php echo $remarks ?>
                                            </div>
                                            <div class='instance-block in-date' name='date'>
                                                <?php echo $date ?>
                                            </div>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class='list ll-box'>
                    <div class='scroll scroll-home'>
                        <div class='scr'>
                            <?php  
                                checkTable($conn, 'LIST');

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