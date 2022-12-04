<?php
    session_start();
    include("../gen/connect.php");
    include("../gen/functions.php");

    $user_data = getUserData($conn);


    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $name = $_GET['name'];
    }  
    
    $_SESSION['name'] = $name;

    require "header.php";



      // get publisher
    $query = "SELECT * FROM publisher WHERE name = '$name'";
    $result = mysqli_query($conn,$query);
    if(!$result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
      }
    $row = mysqli_fetch_assoc($result);

    //get media
    $p_query = "SELECT * FROM published WHERE publisher = '$name'";
    $p_result = mysqli_query($conn,$p_query);
    if(!$p_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
      }

    // get crew
    $e_query = "SELECT * FROM employs WHERE publisher = '$name'";
    $e_result = mysqli_query($conn,$e_query);
    if(!$e_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
    }
?> 
   <!--
    Publisher page
	1Name display
	1Description display
	Media display
	Crew display
	?Comments 
	1Add to list button
	1Delete button (admin only)
	1Main page button
    -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <title>Publisher</title>
    <br>&nbsp;&nbsp;<button class='btn'><a href="#" onclick="history.go(-1)">Go Back</a></button>
    <div class="media-title">
        <?php echo '<br>'."&nbsp;&nbsp;".$row['name']; ?>
    </div>
</head>

<body>
<div class= "media-body">
    <div class = "center">  
    <?php 
      if ($user_data['user_type']=='ADMIN'){
      echo "<button class='btn'><a href='../page/deletePub.php'>Delete Publisher</a></button>";
      echo "&nbsp;&nbsp;&nbsp;";
      echo "<button class='btn'><a href='../page/editPub.php'>Edit Publisher</a></button>";}    
    ?>
    
    
    </div>
    <h3 style="margin: 20px 60px 20px 100px">
    <?php
      echo"<br>"."Description: ".$row['description']."<br>"."<br>"; 
    if (mysqli_num_rows($p_result) == 0)
    {
        echo "Published Media: Haven't published any media stored in media shelf";
    }else{

        while ( $p_row = mysqli_fetch_assoc($p_result))
        {
        $med_query = "SELECT * FROM media WHERE ID = '".$p_row['mediaID']."'";
        $med_result = mysqli_query($conn,$med_query);
        if(!$med_result){
              echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
              exit;
        }
        $med_row = mysqli_fetch_assoc($med_result);
        echo "<br>"."Published Media: ".''.$med_row['title'].''."<br>";
        echo "<button class='btn'>.<a href='media.php?id=".$med_row['id']."'>GO TO SEE→</a></button>";
        echo "<br>"."<br>";

        }
    }

    if (mysqli_num_rows($e_result) == 0){
        echo "Employee: Haven't have any crew stored in media shelf";
    }else{

        while ( $e_row = mysqli_fetch_assoc($e_result))
        {
        $cre_query = "SELECT * FROM crew WHERE crewID = '".$e_row['crewID']."'";
        $cre_result = mysqli_query($conn,$cre_query);
        if(!$e_result){
              echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
              exit;
        }

        $cre_row = mysqli_fetch_assoc($cre_result);
        echo "<br>"."Employee: ".''.$cre_row['name'].''."<br>";
        echo "<button class='btn'><a href='crew.php?crewID=".$cre_row['crewID']."'>GO TO SEE→</a></button>";
        echo "<br>"."<br>";

        }}
    ?>


<br><br>
    <div class='mpc-buttons'>
    <button class='btn'><a href='../list/addList.php'>Add List</a></button>
    </div>
</div>
</body>
</html>
