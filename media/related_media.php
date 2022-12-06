<?php
    session_start();
    include("../gen/connect.php");
    include("../gen/functions.php");

    $user_data = getUserData($conn);
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $mediaID = $_GET['id'];
    }  


    require "header.php";

    // get tag
    $query = "SELECT * FROM media_tag WHERE mediaID = '$mediaID' ";
    $result = mysqli_query($conn,$query);
    if(!$result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }

    $m_query = "SELECT * FROM media WHERE ID = '$mediaID' ";
    $m_result = mysqli_query($conn,$m_query);
    if(!$m_result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }
    $m_row = mysqli_fetch_assoc($m_result);
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
    <br>&nbsp;&nbsp;<button class='btn'><a href="#" onclick="history.go(-1)">Go Back</a></button>        
    <div class="media-title">
        <?php echo '<br>'."&nbsp;&nbsp;"."Media related to ". $m_row['title'].'<br>'; ?>
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
          <td> <font face="Arial">common tag</font> </td> 
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)) {
        $related_query = "SELECT * FROM media_tag WHERE tag = '".$row['tag']."'"."AND mediaID <> '$mediaID' ";
        $related_result = mysqli_query($conn,$related_query);
        if(!$related_result){
              echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
              exit;
        }

        while ($related_row = mysqli_fetch_assoc($related_result)){
            $rm_query = "SELECT * FROM media WHERE ID = '".$related_row['mediaID']."'"."AND ID <> '$mediaID' ";
            $rm_result = mysqli_query($conn,$rm_query);
            if(!$rm_result){
                  echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
                  exit;
            }
            $rm_row = mysqli_fetch_assoc($rm_result);

            echo '<tr> 
            <td>'. "<a href='media.php?id=".$rm_row['id']."'</a>".$rm_row['title'].'</td> 
            <td>'. $related_row['tag']. '</td> 
            </tr>'."<br>";
        
        }


    }}
    echo "</div>";
    echo "</table>";
?>    
    </div>
</body>
</html>