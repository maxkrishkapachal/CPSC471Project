<?php
    # okay the idea on this one is that it's the main search page where you can find
    # the media.
    # so we're coming off the home page
    # we'll have a search bar at the top
    # search button
    # back to home button
    # a scrollable field for the results
    # maybe some little codes to narrow your search
    # m:"search" for media, b:"search" for book, g:"search" for video games, f:"search" for film
    # p:"search" for publisher, c:"search" for crew, u:"search" for user, t:"search" for tag
    # and maybe you can combine them so you can search for only movies and books with this
    # bf:"search" or this fb:"search"
    # then each search result will have the name of the media, the type of file, the tags,
    # and when you click on it, it'll take you to their page
    session_start();
    
    include("../gen/connect.php");
    include("../gen/functions.php");

    $user_data = getUserData($conn);

    if(isset($_REQUEST['home-button'])){
        header('Location: home.php'); 
        die;
    }

    $checkLimit = 0;

    for($viewCheck = 0; $viewCheck < $checkLimit; $viewCheck++){
        $mediapage = 'media-page-button-'.$viewCheck;
        $mediapageID = 'media-page-ID-'.$viewCheck;
        if(isset($_REQUEST[$mediapage])){
            echo "<label>TESTING $mediapage $mediapageID</label>";
            $_SESSION['id'] = $_REQUEST[$mediapageID];
            header('Location: ../media/media.php');
            die;
        }
    }

    

    // for($check = 0; $check < $i; $check++){
    //     if(isset($_REQUEST['media-page-button-'.$check])){
    //         $_SESSION['id'] = $_REQUEST['media-page-button-'.$check];
    //         header('Location: ../media/media.php');
    //         die;
    //     }
    // }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form class="search-form" action="" method="post">
            <div class="row-of-buttons rev-search-buttons">
                <!-- back button, search bar, search button -->
                <input class="btn" type="submit" name="search-button" value="Search">
                <input class="search-bar" type="text" name="search-bar" placeholder="What are you looking for...?">
                <input class="btn" type="submit" name="home-button" value="Home">
            </div>
            <div class="search-buttons">
                <div>
                    <input type="checkbox" name="media" id="media" checked>
                    <label for="media" class='search-box'>Media</label>
                </div>
                <div>
                    <input type="checkbox" name="publisher" id="publisher" checked>
                    <label for="publisher" class='search-box'>Publisher</label>
                </div>
                <div>
                    <input type="checkbox" name="crew" id="crew" checked>
                    <label for="crew" class='search-box'>Crew</label>
                </div>
                <div>
                    <input type="checkbox" name="user" id="user" checked>
                    <label for="user" class='search-box'>User</label>
                </div>
            </div>
            <div class="scroll scroll-search">
                <div class="scr">
                    <?php  
                        $search = NULL;
                        if(isset($_REQUEST['search-button'])){
                            $current_user = $user_data['username'];
                            
                            if(isset($_POST['media'])){
                                checkTable($conn, 'MEDIA');

                                $media_query = "
                                    SELECT *
                                    FROM MEDIA
                                    WHERE title LIKE '%$search%'
                                ";

                                $media_results = mysqli_query($conn, $media_query);

                                if($media_results && mysqli_num_rows($media_results) > 0){
                                    ?>

                                    <div class="search-header">
                                        <label class="search-header-label">MEDIA</label>
                                        <div class="search-header-cats">
                                            <div class="search-header-in in-media-title">
                                                Title      
                                            </div>
                                            <div class="search-header-in in-media-rating">
                                                Rating
                                            </div>
                                            <div class="search-header-in in-media-desc">
                                                Description
                                            </div>
                                            <div class="search-header-in in-media-date">
                                                Release Date
                                            </div>
                                            <div class="search-header-in in-button-hidden">
                                                View
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                }

                                $mediaResultCount = 0;

                                while($row = mysqli_fetch_assoc($media_results)){
                                    # need to print out media name, rating, remarks, date
                                    $title = convertQuotes($row['title'], "QUOTES");
                                    $rating = $row['ranking'];
                                    $date = $row['release_date'];
                                    $description = convertQuotes($row['description'], "QUOTES");
                                    $mediaID = $row['ID'];
                                                                        
                                    ?>
                                        <div class='instance'>
                                            <input hidden name="media-page-ID-<?php echo $i ?>" value='<?php echo $mediaID ?>'>
                                            <div class='instance-block in-media-title'>
                                                <?php echo $title ?>
                                            </div>
                                            <div class='instance-block in-media-rating'>
                                                <?php echo $rating ?>
                                            </div>
                                            <div class='instance-block in-media-desc'>
                                                <?php echo $description ?>
                                            </div>
                                            <div class='instance-block in-media-date'>
                                                <?php echo $date ?>
                                            </div>
                                            <input class="btn" name="media-page-button-<?php echo $i ?>" type="submit" value="View">
                                        </div>
                                    <?php
                                    
                                    $mediaResultCount++;
                                }
                                $checkLimit = $mediaResultCount;
                            }

                            if(isset($_POST['publisher'])){
                                checkTable($conn, 'PUBLISHER');

                                $pub_query = "
                                    SELECT *
                                    FROM PUBLISHER
                                    WHERE name LIKE '%$search%'
                                ";

                                $pub_results = mysqli_query($conn, $pub_query);

                                if($pub_results && mysqli_num_rows($pub_results) > 0){
                                    ?>

                                    <div class="search-header">
                                        <label class="search-header-label">PUBLISHERS</label>
                                        <div class="search-header-cats">
                                            <div class="search-header-in in-publisher">
                                                Name
                                            </div>
                                            <div class="search-header-in in-button-hidden">
                                                View
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                }

                                while($row = mysqli_fetch_assoc($pub_results)){
                                    $publisher = convertQuotes($row['name'], "QUOTES");

                                    ?>
                                        <div class='instance'>
                                            <div class='instance-block in-publisher'>
                                                <?php echo $publisher ?>
                                            </div>
                                            <input class="btn" name="publisher-page-button" type="submit" value="View">
                                        </div>
                                    <?php
                                }                                
                            }

                            if(isset($_POST['crew'])){
                                checkTable($conn, 'CREW'); 
                                
                                $crew_query = "
                                    SELECT *
                                    FROM CREW
                                    WHERE name LIKE '%$search%'
                                ";

                                $crew_results = mysqli_query($conn, $crew_query);

                                if($crew_results && mysqli_num_rows($crew_results) > 0){
                                    ?>

                                    <div class="search-header">
                                        <label class="search-header-label">CREW MEMBERS</label>
                                        <div class="search-header-cats">
                                            <div class="search-header-in in-crew-name">
                                                Name
                                            </div>
                                            <div class="search-header-in in-crew-role">
                                                Role
                                            </div>
                                            <div class="search-header-in in-button-hidden">
                                                View
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                }
                                
                                while($row = mysqli_fetch_assoc($crew_results)){
                                    $crewID = $row['crewID'];
                                    $name = convertQuotes($row['name'], "QUOTES");
                                    $role = convertQuotes($row['role'], "QUOTES");

                                    ?>
                                        <div class='instance'>
                                            <input hidden value='<?php echo $crewID ?>'>
                                            <div class='instance-block in-crew-name'>
                                                <?php echo $name ?>
                                            </div>
                                            <div class='instance-block in-crew-role'>
                                                <?php echo $role ?>
                                            </div>
                                            <input class="btn" name="crew-page-button" type="submit" value="View">
                                        </div>
                                    <?php
                                }
                            }

                            if(isset($_POST['user'])){
                                checkTable($conn, 'USER');

                                $user_query = "
                                    SELECT *
                                    FROM USER
                                    WHERE (
                                        username LIKE '%$search%'
                                        OR name LIKE '%$search%'
                                    )
                                    AND username <> '$current_user'
                                ";

                                $user_results = mysqli_query($conn, $user_query);

                                if($user_results && mysqli_num_rows($user_results) > 0){
                                    ?>

                                    <div class="search-header">
                                        <label class="search-header-label">USERS</label>
                                        <div class="search-header-cats">
                                            <div class="search-header-in in-username">
                                                Username
                                            </div>
                                            <div class="search-header-in in-user-name">
                                                Name
                                            </div>
                                            <div class="search-header-in in-user-bio">
                                                Bio
                                            </div>
                                            <div class="search-header-in in-user-type">
                                                Type
                                            </div>
                                            <div class="search-header-in in-button-hidden">
                                                View
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                }

                                while($row = mysqli_fetch_assoc($user_results)){
                                    $username = $row['username'];
                                    $name = convertQuotes($row['name'], "QUOTES");
                                    $bio = convertQuotes($row['bio'], "QUOTES");
                                    $user_type = $row['user_type'];

                                    ?>
                                        <div class='instance'>
                                            <div class='instance-block in-username'>
                                                <?php echo $username ?>
                                            </div>
                                            <div class='instance-block in-user-name'>
                                                <?php echo $name ?>
                                            </div>
                                            <div class='instance-block in-user-bio'>
                                                <?php echo $bio ?>
                                            </div>
                                            <div class='instance-block in-user-type'>
                                                <?php echo $user_type ?>
                                            </div>
                                            <input class="btn" name="user-page-button" type="submit" value="View">
                                        </div>
                                    <?php
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </form>
    </body>
</html>