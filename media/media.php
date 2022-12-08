<?php
  session_start();
  include("../gen/connect.php");
  include("../gen/functions.php");

  $user_data = getUserData($conn);

  // if($_SERVER['REQUEST_METHOD'] == 'GET'){
  //   $id = $_GET['id'];
  // }  
  $id = $_SESSION['id'];
  //$_SESSION['id'] = $id;
  $_SESSION['element'] = $id;

  
  //get media
  checkTable($conn, "MEDIA");

  $query = "SELECT * FROM media WHERE id = '$id'";
  $result = mysqli_query($conn,$query);

  if(!$result){
    echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
    exit;
  }
  $row = mysqli_fetch_assoc($result);

  // get publisher
  checkTable($conn, "PUBLISHED");

  $p_query = "SELECT * FROM published WHERE mediaID = '$id'";
  $p_result = mysqli_query($conn,$p_query);

  if(!$p_result){
    echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
    exit;
  }

  // get crew
  checkTable($conn, "WORKS_ON");
  
  $w_query = "SELECT * FROM works_on WHERE mediaID = '$id'";
  $w_result = mysqli_query($conn,$w_query);

  if(!$w_result){
    echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
    exit;
  }
  
  //get statistics
  checkTable($conn, "LOGS");
    
  $s_query = "SELECT AVG(rating) AS rating FROM LOGS WHERE mediaID = '$id'";
  $s_result = mysqli_query($conn,$s_query);

  if(!$s_result){
    echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
    exit;
  }

  //get comment
  checkTable($conn, "COMMENT");
  
  $co_query = "SELECT * FROM comment WHERE mediaid = '$id'";
  $co_result = mysqli_query($conn,$co_query);

  if(!$co_result){
    echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
    exit;
  }

  checkTable($conn, "MEDIA_TAG");

  $t_query = "SELECT * FROM media_tag WHERE mediaid = '$id'";
  $t_result = mysqli_query($conn, $t_query);
  if(!$t_result){
    echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
    exit;
  }


  if(isset($_REQUEST['add-comment-button'])){
    $_SESSION['mediaID'] = $id;
    header("Location: ../comment/addComment.php");
    die;
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
    <div class='row-of-buttons'>
      <button class='btn'><a href="../acc/search.php">Go Back</a></button>
    </div>  
    
    <div class='welcome-label-div'>
      <label class='welcome-label'>
        <?php 
          echo convertQuotes($row['title'], "QUOTES");
        ?>
      </label>
    </div>
  </head>
  <body>
    <form>
      <div class= "media-body">
        <div class = "center">
          <?php 
            if ($user_data['user_type']=='ADMIN'){
              ?>
                <div class='search-buttons'>
                  <button class='btn'><a href='deleteMedia.php'>Delete media</a></button>
                  <button class='btn'><a href='editMedia.php'>Edit Media</a></button>
                </div>
              <?php
            } 
          ?>
            
        </div>
        <h3>
          <div class="media-box">
            <div class= "lcolumn">
              <?php
                echo"<br>"."Release date: ".$row['release_date']."<br>"."<br>";
                echo"<br>"."Description: ".$row['description']."<br>"."<br>";
                echo"<br>"."Media type: ".$row['media_type']."<br>"."<br>";

                $t = $row['media_type'];

                if ($t == 'Video Game') {
                  //echo"<br>"."Platform: ".$row['platform']."<br>"."<br>"; 
                  checkTable($conn, "VIDEO_GAME");
                }
                else if ($t == 'Book') {
                  echo"<br>"."Chapters: ".$row['chapters']."<br>"."<br>"; 
                }
                else if ($t == 'Movie') {
                  echo"<br>"."Duration: 400 years"/*.$row['duration']*/."<br>"."<br>"; 
                }
              ?>  
            </div>

            <div class = 'rcolumn'>
              <?php
                if (mysqli_num_rows($p_result) == 0){
                  echo "Publisher: Unknown<br>";
                } else {
                  while ( $p_row = mysqli_fetch_assoc($p_result)) 
                  {
                    $name = convertQuotes($p_row['publisher'], "QUOTES");
                    echo "<br>"."Publisher Name: ".''."$name".''."<br>";
                    echo "<button class='btn'>.<a href='publisher.php?name=".$p_row['publisher']."'>GO TO SEE→</a></button>";
                    echo "<br>"."<br>";
                  }
                }
		 echo "<button class='btn'><a href='../publisher/addPublishedM.php'>Add publisher</a></button><br>";
		    
                if (mysqli_num_rows($w_result) == 0){
                  echo "Crew: Unknown<br>";
                } else {
                  while ( $w_row = mysqli_fetch_assoc($w_result))
                  { 
                    checkTable($conn, "CREW");
                    $cre_query = "SELECT * FROM crew WHERE crewID = '".$w_row['crewID']."'";
                    $cre_result = mysqli_query($conn,$cre_query);
                    
                    if(!$w_result){
                      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
                      exit;
                    }
                    $cre_row = mysqli_fetch_assoc($cre_result);

                    echo "<br>"."Crew name: ".''.$cre_row['name'].'';
                    echo "<br>"."Role: ".''.$w_row['role'].''."<br>";
                    echo "<button class='btn'><a href='crew.php?crewID=".$w_row['crewID']."'>GO TO SEE→</a></button>";
                    echo "<br>"."<br>";
                  }
                }

                

                $s_row = mysqli_fetch_assoc($s_result);
                echo "<br>"."Overall rating: ";
                if($s_row['rating'] == NULL){
                  echo "No data";
                }
                else {
                  for ($i = 0; $i<$s_row['rating']; $i++){
                    echo "★";
                  }
                  echo '('.$s_row['rating'].'/10)';
                }
                echo "<br>"."<br>";
        
                if (mysqli_num_rows($t_result)==0){
                  echo "<br>"."Tag: Unknown";
                } else {
                  echo "<br>"."Tag: ";
                  echo '<div id="tcolor">';
                  while ($t_row = mysqli_fetch_assoc($t_result))
                  {  
                    echo "<a href='tags.php?tag=".$t_row['tag']."' >".$t_row['tag']."</a><br>";
                  } 
                  echo "</div>";
                }
                ?>
                  <button name='add-tag-button' class='btn'><a href='../tag/addTag.php'>Add Tag</a></button>
                <?php
                echo "<br><button class='btn'><a href='related_media.php?id=".$id."'>Related media</a></button>";
              ?>
            </div>
            <div class='search-buttons'>
              <button class='btn'><a href='../list/addToList.php'>Add To List</a></button>
              <button class='btn'><a href='../log/addLog.php'>Add Log</a></button>
            </div>

            <br><br>
            <input class='btn' type='submit' name='add-comment-button' value='Create Comment'>
            <!-- <button class='btn'><a href='../comment/addComment.php'>Create comment</a></button> -->
            
            <div class = 'comment-body'>
              <?php 
                if (mysqli_num_rows($co_result) == 0){
                  echo "No comment yet.";
                } else {
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
                      ?>
                        <a href="../comment/editComment.php?comment=<?php echo $co_row['commentID'] ?>">EDIT</a>
                      <?php
                    }
                    if ($co_row['username'] == $user_data['username'] || $user_data['user_type'] == 'ADMIN'){
                      ?>
                        <a href="../comment/deleteComment.php?comment=<?php echo $co_row['commentID'] ?>">DELETE</a>
                      <?php
                    }
                  }
                }
              ?>
            </div>
          </div>
        </h3>
      </div>
    </form>
  </body>
</html>
