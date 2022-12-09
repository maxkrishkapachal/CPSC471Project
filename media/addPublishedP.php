<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");
     
      //get users
    checkTable($conn, "USER");

    $pubID = NULL;

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
      $pubID = $_GET['name'];
    }

    $query = "SELECT * FROM media" ;
    $result = mysqli_query($conn,$query);
    if(!$result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }
 

    if(isset($_REQUEST['add'])){
        $pubID = convertQuotes($_POST['pubID'], "SYMBOLS");
        $mediaID = $_POST['mediaID'];

        if(!empty($mediaID)){
            checkTable($conn, 'PUBLISHED');

            $query = "INSERT INTO PUBLISHED VALUES
                ('$mediaID', '$pubID')
            ";
            
            mysqli_query($conn, $query);
            header("Location: addPublishedP.php?name=$pubID");
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
    
    <title>addPublished</title>
    <div class='row-of-buttons'>
      <button class='btn'><a href="../media/publisher.php?name=<?php echo $pubID ?>">Go Back</a></button>
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
    $title = $row['title'];
    $mediaID = $row['ID'];

    $contain = "SELECT * FROM PUBLISHED
    WHERE publisher = '$pubID' AND mediaID = '$mediaID'  ";
    $c_result = mysqli_query($conn,$contain);
        if(!$c_result){
          echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
          exit;
        }


      echo "<form action='' method='POST'>";
      echo "<input hidden name='mediaID' value='$mediaID'>";
      echo "<input hidden name='pubID' value='$pubID'>";
      echo '<tr> 
      <td>'. convertQuotes($title, "QUOTES");
      echo "<div class='search-buttons'>";
      if (mysqli_num_rows($c_result)==0){
        echo '<input name="add" type="submit" class="btn btn-input" value="Add">';
      }else{
        echo '★Media';
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
