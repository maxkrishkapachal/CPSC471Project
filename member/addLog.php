<?php 
    session_start();

    include("../connect.php");
    include('../functions.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $media = $_POST['media_name'];
        $remarks = $_POST['remarks'];
        $rating = $_POST['rating'];
        $date = new DateTime();
        //$id = createID('LOG');
    
        
    }    
?> 


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <link rel="stylesheet" href="../main.css" media="screen">
  <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        
      <div class="form-wrap">
        <div class="tabs-content">
          <div class="active">
            <form class="add-log-form" action="" method="post">
              <input name="media_name" type="text" class="input" id="media_name" autocomplete="off" placeholder="Title">
              <input name="remarks" type="text" class="input" id="log_remarks" autocomplete="off" placeholder="What did you think?">
              <input name="rating" type="number" class="input" id="log_rating" autocomplete="off" placeholder="?/10">
    
              <input name="add" type="submit" class="button" value="Save Log">
            </form>
          </div>
        </div>
      </div>
    </body>
</html>