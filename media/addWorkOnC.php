<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");
     
      //get users
    checkTable($conn, "USER");

    $crewID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
      $crewID = $_GET['crewID'];
    }

    $query = "SELECT * FROM media" ;

    $result = mysqli_query($conn,$query);
    if(!$result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }
 

    if(isset($_REQUEST['add'])){
        $mediaID = $_POST['mediaID'];
        $crewID = convertQuotes($_POST['crewID'], "SYMBOLS");
        $role = convertQuotes($_POST['role'], "SYMBOLS");

        if(!empty($crewID)){
            checkTable($conn, 'WORKS_ON');

            $query = "INSERT INTO WORKS_ON VALUES
                ('$mediaID','$crewID', '$role')
            ";
            
            mysqli_query($conn, $query);
            header("Location: ../media/crew.php?crewID=$crewID");
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
    
    <title>addWorks_on</title>
    <div class='row-of-buttons'>
      <button class='btn'><a href="../media/crew.php?crewID=<?php echo $crewID ?>">Go Back</a></button>
    </div> 
    <div class= "media-body">
</head>
    <body>
    <?php

if ($result->num_rows > 0) {
    // output data of each row
    echo '<div class= "center">
    <table class="center" border="1" cellspacing="2" cellpadding="2"> 
      <tr> 
          <td> <font face="Arial" color = red >Media</font> </td> 
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)) {
    $mediaID = $row['ID'];
    $title = convertQuotes($row['title'], "QUOTES");

    $contain = "SELECT * FROM works_on
    WHERE crewID = '$crewID' AND mediaID = '$mediaID'  ";
    $c_result = mysqli_query($conn,$contain);
        if(!$c_result){
          echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
          exit;
        }

     
      
      echo '<tr> 
      <td>'. $title ;
      echo "<div class='search-buttons'>";
      echo "<form action='' method='POST'>";
      echo "<input hidden name='mediaID' value='$mediaID'>";
      echo "<input hidden name='crewID' value='$crewID'>";
      if (mysqli_num_rows($c_result)==0)
      {
        echo '<input name="role" type="text" class="input" id="role" autocomplete="off" placeholder="role">';
        echo '<input name="add" type="submit" class="btn btn-input" value="Add">';
      }else{
        echo '★Media';
      }
      echo "</td>"." </tr>"."<br>"."</form>";
    }
    }
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</table>";
?>    
    </div>
    </body>
</html>
