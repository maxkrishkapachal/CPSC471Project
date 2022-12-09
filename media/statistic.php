<?php
    session_start();
    include("../gen/connect.php");
    include("../gen/functions.php");

    $user_data = getUserData($conn);


    # we'll look for the top five rated medias

?> 


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" href="../gen/main.css" media="screen">
    
        <title>statistic</title>
        <br>&nbsp;&nbsp;<button class='btn'><a href="../acc/search.php">Go Back</a></button>        
    </head>
    <body>
        <div class='welcome-label-div'>
            <label class='welcome-label'>
                <?php 
                echo "TOP MEDIA";
                ?>
            </label>
        </div>
        <div class= "media-body">
            <?php
                                
                $top_rated_query = "
                    SELECT ID, title, AVG(ranking) AS ranking  
                    FROM MEDIA
                    WHERE ranking IS NOT NULL
                    GROUP BY ID
                    ORDER BY ranking DESC
                ";

                $result = mysqli_query($conn, $top_rated_query);

                if ($result && mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $rank = 1;
                    echo '<div class= "center">
                    <table class="center" border="1" cellspacing="2" cellpadding="2"> 
                    <tr> 
                        <td> <font face="Arial">Rank</font> </td> 
                        <td> <font face="Arial">Title</font> </td> 
                        <td> <font face="Arial">Rating</font> </td> 
                    </tr>';
                    
                    while(($row = mysqli_fetch_assoc($result)) && $rank < 6) {
                        echo '<tr> 
                        <td>'.$rank.'</td> 
                        <td>'. "<a href='media.php?id=".$row['ID']."'</a>".convertQuotes($row['title'], "QUOTES").'</td> 
                        <td>'. $row["ranking"]. '</td> 
                        </tr>'."<br>";
                        $rank ++;
                    }
                }
                echo "</div>";
                echo "</table>";
            ?>    
        </div>
        <div class='welcome-label-div'>
            <label class='welcome-label'>
                <?php 
                echo "TOP BOOKS";
                ?>
            </label>
        </div>
        <div class= "media-body">
            <?php
                $top_rated_query = "
                    SELECT ID, title, AVG(ranking) AS ranking  
                    FROM MEDIA
                    WHERE ranking IS NOT NULL
                    AND media_type = 'Book'
                    GROUP BY ID
                    ORDER BY ranking DESC
                ";

                $result = mysqli_query($conn, $top_rated_query);

                if ($result && mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $rank = 1;
                    echo '<div class= "center">
                    <table class="center" border="1" cellspacing="2" cellpadding="2"> 
                    <tr> 
                        <td> <font face="Arial">Rank</font> </td> 
                        <td> <font face="Arial">Title</font> </td> 
                        <td> <font face="Arial">Rating</font> </td> 
                    </tr>';
                    
                    while(($row = mysqli_fetch_assoc($result)) && $rank < 6) {
                        echo '<tr> 
                        <td>'.$rank.'</td> 
                        <td>'. "<a href='media.php?id=".$row['ID']."'</a>".convertQuotes($row['title'], "QUOTES").'</td> 
                        <td>'. $row["ranking"]. '</td> 
                        </tr>'."<br>";
                        $rank ++;
                    }
                }
                echo "</div>";
                echo "</table>";
            ?>    
        </div>
        <div class='welcome-label-div'>
            <label class='welcome-label'>
                <?php 
                echo "TOP MOVIES";
                ?>
            </label>
        </div>
        <div class= "media-body">
            <?php
                $top_rated_query = "
                    SELECT ID, title, AVG(ranking) AS ranking  
                    FROM MEDIA
                    WHERE ranking IS NOT NULL
                    AND media_type = 'Movie'
                    GROUP BY ID
                    ORDER BY ranking DESC
                ";

                $result = mysqli_query($conn, $top_rated_query);

                if ($result && mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $rank = 1;
                    echo '<div class= "center">
                    <table class="center" border="1" cellspacing="2" cellpadding="2"> 
                    <tr> 
                        <td> <font face="Arial">Rank</font> </td> 
                        <td> <font face="Arial">Title</font> </td> 
                        <td> <font face="Arial">Rating</font> </td> 
                    </tr>';
                    
                    while(($row = mysqli_fetch_assoc($result)) && $rank < 6) {
                        echo '<tr> 
                        <td>'.$rank.'</td> 
                        <td>'. "<a href='media.php?id=".$row['ID']."'</a>".convertQuotes($row['title'], "QUOTES").'</td> 
                        <td>'. $row["ranking"]. '</td> 
                        </tr>'."<br>";
                        $rank ++;
                    }
                }
                echo "</div>";
                echo "</table>";
            ?>    
        </div>
        <div class='welcome-label-div'>
            <label class='welcome-label'>
                <?php 
                echo "TOP VIDEO GAMES";
                ?>
            </label>
        </div>
        <div class= "media-body">
            <?php
                $top_rated_query = "
                    SELECT ID, title, AVG(ranking) AS ranking  
                    FROM MEDIA
                    WHERE ranking IS NOT NULL
                    AND media_type = 'Video Game'
                    GROUP BY ID
                    ORDER BY ranking DESC
                ";

                $result = mysqli_query($conn, $top_rated_query);

                if ($result && mysqli_num_rows($result) > 0) {
                    // output data of each row
                    $rank = 1;
                    echo '<div class= "center">
                    <table class="center" border="1" cellspacing="2" cellpadding="2"> 
                    <tr> 
                        <td> <font face="Arial">Rank</font> </td> 
                        <td> <font face="Arial">Title</font> </td> 
                        <td> <font face="Arial">Rating</font> </td> 
                    </tr>';
                    
                    while(($row = mysqli_fetch_assoc($result)) && $rank < 6) {
                        echo '<tr> 
                        <td>'.$rank.'</td> 
                        <td>'. "<a href='media.php?id=".$row['ID']."'</a>".convertQuotes($row['title'], "QUOTES").'</td> 
                        <td>'. $row["ranking"]. '</td> 
                        </tr>'."<br>";
                        $rank ++;
                    }
                }
                echo "</div>";
                echo "</table>";
            ?>    
        </div>
    </body>
</html>