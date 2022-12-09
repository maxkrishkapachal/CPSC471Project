<?php
    session_start();

    include("../gen/connect.php");
    include("../gen/functions.php");

    $user_data = getUserData($conn);

    $crewID = NULL;
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $crewID = $_GET['crewID'];
    }

      // get crew
    $query = "SELECT * FROM crew WHERE crewID = '$crewID'";
    $result = mysqli_query($conn,$query);

    if(!$result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    //get publisher
    $p_query = "SELECT * FROM employs WHERE crewID = '$crewID'";
    $p_result = mysqli_query($conn,$p_query);
    
    if(!$p_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
    }

    // get media
    $w_query = "SELECT * FROM works_on WHERE crewID = '$crewID'";
    $w_result = mysqli_query($conn,$w_query);
    
    if(!$w_result){
        echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
        exit;
    }
?> 
   <!--
    Crew page
	1Name display
	1Description display
	1Role display
	Publisher display
	1Crew display
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
      <title>Crew</title>
      <br>&nbsp;&nbsp;<button class='btn'><a href="../acc/search.php">Go Back</a></button>
      <div class='welcome-label-div'>
            <label class='welcome-label'>
                <?php 
                    echo convertQuotes($row['name'], "QUOTES");
                ?>
            </label>
        </div>
  </head>

  <body>
      <div class= "media-body">
          <div class = "center">  
              <?php 
                  if ($user_data['user_type']=='ADMIN'){
                      ?>
                          <div class='search-buttons'>
                              <button class='btn'><a href='../crew/deleteCrew.php?crewID=<?php echo $crewID ?>'>Delete crew</a></button>
                              <button class='btn'><a href='../crew/editCrew.php?crewID=<?php echo $crewID ?>'>Edit crew</a></button>
                          </div>
                      <?php
                  }    
              ?>  
          </div>
          <h3>
              <div class="media-box">
                  <?php
                      echo"<br>"."Description: ".$row['description']."<br>"."<br>"; 
                      if (mysqli_num_rows($w_result) == 0){
                          echo "Haven't worked on any media stored in media shelf";
                      } else {
                          while ( $w_row = mysqli_fetch_assoc($w_result))
                          {
                              $med_query = "SELECT * FROM media WHERE ID = '".$w_row['mediaID']."'";
                              $med_result = mysqli_query($conn,$med_query);
                              if(!$med_result){
                                  echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
                                  exit;
                              }
                              $med_row = mysqli_fetch_assoc($med_result);
                              echo "<br>"."Worked on: ".''.convertQuotes($med_row['title'], "QUOTES").''."<br>";
                              echo "<br>"."Role: ".''.$w_row['role'].''."<br>";
                              echo "<button class='btn'><a href='media.php?id=".$w_row['mediaID']."'>GO TO SEE→</a></button>";
                              echo "<br>"."<br>";
                          }
                      }

                      echo "<br><br><button class='btn'><a href='addWorkOnC.php?crewID=".$crewID."'>Add Media</a></button><br>";


                      if (mysqli_num_rows($p_result) == 0){
                          echo "Employer: Haven't have any employer stored in media shelf";
                      } else {
                          while ( $p_row = mysqli_fetch_assoc($p_result))
                          {
                              echo "<br><br>"."Employer: ".''.convertQuotes($p_row['publisher'], "QUOTES").''."<br>";
                              echo "<button class='btn'><a href='publisher.php?name=".$p_row['publisher']."'>GO TO SEE→</a></button>";
                              echo "<br>"."<br>";
                          }
                      }

                      echo "<br><br><button class='btn'><a href='../crew/addEmploysC.php?crewID=".$crewID."'>Add Publisher</a></button><br>";

                  ?>

                  <br><br>
                  <div class='mpc-buttons'>
                      <button class='btn'><a href='../list/addToList.php?element=<?php echo $crewID ?>'>Add To List</a></button>
                  </div>
              </div>
          </h3>      
      </div>
  </body>
</html>