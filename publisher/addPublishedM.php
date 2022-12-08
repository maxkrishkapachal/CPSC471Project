<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");
     
      //get users
    checkTable($conn, "USER");

    $mediaID = $_SESSION['element'];

    $query = "SELECT * FROM publisher" ;
    $result = mysqli_query($conn,$query);
    if(!$result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }
 

    if(isset($_REQUEST['add'])){
        $name = convertQuotes($_POST['pname'], "SYMBOLS");

        if(!empty($name)){
          echo "$name";
            checkTable($conn, 'PUBLISHED');

            $query = "INSERT INTO PUBLISHED VALUES
                ('$mediaID', '$name')
            ";
            
            mysqli_query($conn, $query);
            header("Location: addPublishedM.php");
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
      <button class='btn'><a href="../media/media.php">Go Back</a></button>
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
          <td> <font face="Arial" color = red >publisher</font> </td> 
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)) {
    $pname = $row['name'];

    $contain = "SELECT * FROM PUBLISHED
    WHERE publisher = '$pname' AND mediaID = '$mediaID'  ";
    $c_result = mysqli_query($conn,$contain);
        if(!$c_result){
          echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
          exit;
        }


      echo "<form action='' method='POST'>";
      echo "<input hidden name='pname' value='$pname'>";
      echo '<tr> 
      <td>'. $pname ;
      echo "<div class='search-buttons'>";
      if (mysqli_num_rows($c_result)==0){
        echo '<input name="add" type="submit" class="btn" value="Add">';
      }else{
        echo '★Publisher';
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
