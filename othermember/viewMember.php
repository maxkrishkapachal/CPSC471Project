<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");
     
      //get users
    checkTable($conn, "USER");

    $user_data = getUserData($conn);

    $username = $user_data['username'];
    $query = "SELECT * FROM user WHERE username <> '$username'" ;
    $result = mysqli_query($conn,$query);

    if(!$result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }


    # return/go back
    if(isset($_REQUEST['back-button'])){
        header('Location: ../acc/home.php'); 
        die;
    }

    if(isset($_REQUEST['friend'])){
        $member_ID_1 = $username;
        $member_ID_2 = convertQuotes($_POST['userID'], "SYMBOLS");

        if(!empty($member_ID_2)){
            checkTable($conn, 'CAN_INTERACT');

            $query = "INSERT INTO CAN_INTERACT VALUES
                ('$member_ID_1', '$member_ID_2')
            ";
            
            mysqli_query($conn, $query);
            header("Location: ../othermember/viewMember.php");
            die;
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
            header("Location: ../othermember/viewMember.php");
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    
    <title>viewMember</title>
    <div class='row-of-buttons'>
      <button class='btn'><a href="../acc/search.php">Go Back</a></button>
    </div> 
    <style>

    table.center {
    width:70%; 
    margin-left:15%; 
    margin-right:15%;
    }
    a:link {
    color: white;
    background-color: transparent;
    text-decoration: none;
    }
    a:visited {
    color: white;
    background-color: transparent;
    text-decoration: none;
    }

    a:hover {
    color: red;
    background-color: transparent;
    text-decoration: underline;
    }

   </style>
    <div class= "media-body">
</head>
    <body>
    <?php

if ($result->num_rows > 0) {
    // output data of each row
    echo '<div class= "center">
    <table class="center" border="1" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial" color = red >username</font> </td> 
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)) {
    $otheruserID = $row['username'];

    $contain = "SELECT * FROM CAN_INTERACT
    WHERE (memberID_1 = '$username' AND memberID_2 = '$otheruserID' 
    ) or 
    ( memberID_1 = '$otheruserID' AND memberID_2 = '$username')";
        $c_result = mysqli_query($conn,$contain);

        if(!$c_result){
          echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
          exit;
        }

  

      echo "<form action='' method='POST'>";
      echo '<input hidden name="userID" value='.$otheruserID.'>';
      echo '<tr> 
      <td>'. $otheruserID ;
      echo "<div class='search-buttons'>";
      if (mysqli_num_rows($c_result)==0){
        echo '<input name="friend" type="submit" class="btn" value="Add friends">';
      }else{
        echo '<input name="block" type="submit" class="btn" value="Block user">';
      }
      echo "&nbsp;&nbsp;&nbsp;&nbsp;";
      if ($user_data['user_type'] == 'ADMIN'){
      echo '<input name="ban" type="submit" class="btn" value="Remove user">';
      }
      echo "</td>"." </tr>"."<br>"."</form>";
    }
    }
    echo "</div>";
    echo "</div>";
    echo "</table>";
?>    
    </div>
    </body>
</html>
