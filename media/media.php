<?php
    session_start();
    include("../gen/connect.php");
    include("../gen/functions.php");

    $user_data = getUserData($conn);

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $id = $_GET['id'];
    }  
    
    $_SESSION['id'] = $id;


    //get media
    $query = "SELECT * FROM media WHERE id = '$id'";
    $result = mysqli_query($conn,$query);
    if(!$result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
      }
    $row = mysqli_fetch_assoc($result);

      // get publisher
    $p_query = "SELECT * FROM published WHERE mediaID = '$id'";
    $p_result = mysqli_query($conn,$p_query);
    if(!$p_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
      }


    // get crew
    $cr_query = "SELECT * FROM works_on WHERE mediaID = '$id'";
    $cr_result = mysqli_query($conn,$cr_query);
    if(!$cr_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
      }
    

      //get statistics
    $s_query = "SELECT * FROM statistic WHERE media_id = '$id'";
    $s_result = mysqli_query($conn,$s_query);
    if(!$s_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
      }

    //get comment
    $co_query = "SELECT * FROM comment WHERE mediaid = '$id'";
    $co_result = mysqli_query($conn,$co_query);
    if(!$co_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
      }
require "header.php";
?>


<!--
    Media page
	1Title display
	1Description display
	1Release date display
	1Media type display
	Overall rating display
	1Publishers display
  1crew display
	1Comments 
	1 Create log button
	1 Add to list button
	Delete button (admin only)
	1?Back button 
	1Main page button
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
  
        <title>MEDIA</title>
        <br>&nbsp;&nbsp;<button class='btn'><a href="#" onclick="history.go(-1)">Go Back</a></button>
        
    	<div class="media-title">
        <?php echo '<br>'."&nbsp;&nbsp;".$row['title']; ?>
      </div>
</head>

<body>
<div class= "media-body">
    <div class = "center">  
    <br><br>
    <?php 
      if ($user_data['user_type']=='ADMIN'){
      echo "<button class='btn'><a href='../page/deleteMedia.php'>Delete media</a></button>";
      echo "&nbsp;&nbsp;&nbsp;";
      echo "<button class='btn'><a href='../page/editMedia.php'>Edit Media</a></button>";
    }    
    ?>
    
    </div>
    <h3 style="margin: 20px 60px 20px 100px">
      <div class= "lcolumn">
      <?php
      echo"<br>"."Release date: ".$row['release_date']."<br>"."<br>";
      echo"<br>"."Description: ".$row['description']."<br>"."<br>";
      echo"<br>"."Media type: ".$row['media_type']."<br>"."<br>";

      $t = $row['media_type'];

      if ($t == 'Video Game') {
         echo"<br>"."Platform: ".$row['platform']."<br>"."<br>"; 
      }
      else if ($t == 'Book') {
        echo"<br>"."Chapters: ".$row['chapters']."<br>"."<br>"; 
      }
      else if ($t == 'Movie') {
        echo"<br>"."Duration: ".$row['duration']."<br>"."<br>"; 
      }

      ?>  
  </div>

  <div class = 'rcolumn'>
  <?php
  if (mysqli_num_rows($p_result) == 0){
        echo "Publisher of this media: Haven't have any crew stored in media shelf";
    }else{
  while ( $p_row = mysqli_fetch_assoc($p_result))
    {
      echo "<br>"."Publisher Name: ".''.$p_row['publisher'].''."<br>";
      echo "<button class='btn'>.<a href='publisher.php?name=".$p_row['publisher']."'>GO TO SEE→</a></button>";
      echo "<br>"."<br>";
    }}

  if (mysqli_num_rows($cr_result) == 0){
    echo "Crew of this media: Haven't have any crew stored in media shelf";
  }else{
  while ( $cr_row = mysqli_fetch_assoc($cr_result))
    { 
      $cre_query = "SELECT * FROM crew WHERE crewID = '".$cr_row['crewID']."'";
      $cre_result = mysqli_query($conn,$cre_query);
      if(!$cr_result){
            echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
            exit;
      }
      $cre_row = mysqli_fetch_assoc($cre_result);

      echo "<br>"."Crew name: ".''.$cre_row['name'].'';
      echo "<br>"."Role: ".''.$cre_row['role'].''."<br>";
      echo "<button class='btn'><a href='crew.php?crewID=".$cr_row['crewID']."'>GO TO SEE→</a></button>";
      echo "<br>"."<br>";
    }}

  if (mysqli_num_rows($s_result) == 0){
      echo "There are no statistics for this media.";
  }else{  
  while ( $s_row = mysqli_fetch_assoc($s_result))
    { 
      echo "Overall rating:";
      for ($i = 0; $i<$s_row['rate']; $i++){
        echo "★";
      }
      echo "<br>"."<br>";
  }}?>
  </div>

  <div class='mpc-buttons'>
    <button class='btn'><a href='../list/addList.php'>Add List</a></button>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <button class='btn'><a href='../log/addLog.php'>Add Log</a></button>
    </div>

<br><br>



  <button class='btn'><a href='../comment/addComment.php'>Create comment</a></button>
  <div class = 'comment-body'>
  <?php 
  while ( $co_row = mysqli_fetch_assoc($co_result))
      {
      echo "<br>";
      echo '--------------------------------------------------------';
      echo "<br>"."Date:".''.$co_row['date'].''."";
      //USER PROFILE HAVEN'T CREATED, NEED TO CHANGE IF IT'S DONE
      echo "<br>"."Post by ".'<a href="userprofile.php">'.''.$co_row['username'].''."<br>".'</a>';
      echo "<br>"."Comment: ".'<br>'.$co_row['content'].''."<br>";
      echo "<br>"."<br>";
      if ($co_row['username'] == $user_data['username']){
      echo "<a href='../comment/editComment.php'>EDIT</a>" . '     ';
      }
      if ($co_row['username'] == $user_data['username'] || $user_data['user_type'] == 'ADMIN'){
      echo "<a href='../comment/deleteComment.php'>DELETE</a>";
    }}


  ?>
  </div>
</div>
</body>

</html>
