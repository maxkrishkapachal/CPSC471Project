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

    $query = "SELECT * FROM publisher" ;

    $result = mysqli_query($conn,$query);
    if(!$result){
      echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
      exit;
    }
 

    if(isset($_REQUEST['add'])){
        $pname = $_POST['pname'];
        $crewID = convertQuotes($_POST['crewID'], "SYMBOLS");

        if(!empty($crewID)){
            checkTable($conn, 'EMPLOYS');

            $query = "INSERT INTO EMPLOYS VALUES
                ('$pname', '$crewID')
            ";
            
            mysqli_query($conn, $query);
            header("Location: addEmploysC.php?crewID=$crewID");
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
    
    <title>addEmployP</title>
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
          <td> <font face="Arial" color = red >Publishers</font> </td> 
      </tr>';
      
    while($row = mysqli_fetch_assoc($result)) {
    $pname = $row['name'];
    $name = convertQuotes($pname, "QUOTES");

    $contain = "SELECT * FROM EMPLOYS
    WHERE publisher = '$pname' AND crewID = '$crewID' ";
    $c_result = mysqli_query($conn,$contain);
        if(!$c_result){
          echo "SORRY CAN'T FIND THIS:(" . mysqli_error($conn);
          exit;
        }


      echo "<form action='' method='POST'>";
      echo "<input hidden name='pname' value='$pname'>";
                         
      echo "<input hidden name='crewID' value='$crewID'>";
      echo '<tr> 
      <td>'. $name ;
      echo "<div class='search-buttons'>";
      if (mysqli_num_rows($c_result)==0){
        echo '<input name="add" type="submit" class="btn btn-input" value="Add">';
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
