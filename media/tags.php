<?php
    session_start();
    include("../gen/connect.php");
    include("../gen/functions.php");

    $user_data = getUserData($conn);
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $tag = $_GET['tag'];
    }  


    require "header.php";

    // get tag
    $query = "SELECT * FROM media_tag WHERE tag = '$tag' ";
    $result = mysqli_query($conn,$query);
    if(!$result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="../gen/main.css" media="screen">
  
    <title>related_media</title>
    <style>
    
    </style>
    <br>&nbsp;&nbsp;<button class='btn'><a href="../acc/search.php">Go Back</a></button>        
    <div class='welcome-label-div'>
      <label class='welcome-label'>
        <?php 
          echo "Tag: ".convertQuotes($tag, "QUOTES");
        ?>
      </label>
    </div>
</head>

<body>
    <div class= "media-body">
<?php

if ($result->num_rows > 0) {
    // output data of each row
    echo '<div class= "center">
    <table class="center" border="1" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial">Title</font> </td> 
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)) {
        $m_query = "SELECT * FROM media WHERE ID = '".$row['mediaid']."'";
        $m_result = mysqli_query($conn,$m_query);
            if(!$m_result){
                  echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
                  exit;
            }
            $m_row = mysqli_fetch_assoc($m_result);

            echo '<tr> 
            <td>'. "<a href='media.php?id=".$m_row['ID']."'</a>".$m_row['title'].'</td> 
            </tr>'."<br>";
        
        }


    }
    echo "</div>";
    echo "</table>";
?>    
    </div>
</body>
</html>