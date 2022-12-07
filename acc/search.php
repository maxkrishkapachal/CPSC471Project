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

    if(isset($_REQUEST['selected-search-result']) && isset($_REQUEST['view-button'])){
        $selected_values = explode(" ", $_REQUEST['selected-search-result'], 2);
        switch($selected_values[0]){
            case "M":
                $_SESSION['id'] = $selected_values[1];
                header("Location: ../media/media.php");
                die;
            case "P":
                $_SESSION['name'] = $selected_values[1];
                header("Location: ../media/publisher.php");
                die;
            case "C":
                $_SESSION['crewID'] = $selected_values[1];
                header("Location: ../media/crew.php");
                die;
            case "U":
                header("Location: ../othermember/viewMember.php");
                die;
        }
    } 

    if(isset($_REQUEST['add-media-button'])){
        header("Location: ../media/addMedia.php");
        die;
    }

    if(isset($_REQUEST['add-pub-button'])){
        header("Location: ../publisher/addPub.php");
        die;
    }

    if(isset($_REQUEST['add-crew-button'])){
        header("Location: ../crew/addCrew.php");
        die;
    }

    if(isset($_REQUEST['add-tag-button'])){
        
    }
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
                <div>
                    <input type="checkbox" name="tag" id="tag" checked>
                    <label for="tag" class='search-box'>Tag</label>
                </div>
            </div>
            <div class="mpc-buttons">
                <input name='add-media-button' type='submit' value='Add Media' class='btn'>
                <input name='add-pub-button' type='submit' value='Add Publisher' class='btn'>
                <input name='add-crew-button' type='submit' value='Add Crew' class='btn'>
                <input name='view-button' type='submit' value='View' class='btn'>
            </div>
            <div class="scroll scroll-search">
                <div class="scr">
                    <?php  
                        $search = NULL;
                        if(isset($_REQUEST['search-button'])){
                            $search = convertQuotes($_POST['search-bar'], "QUOTES");
                            $current_user = $user_data['username'];
                            
                            if(isset($_POST['media']) && !empty($search)){
                                checkTable($conn, 'MEDIA');

                                $media_query = "
                                    SELECT *
                                    FROM MEDIA
                                    WHERE title LIKE '%$search%'
                                    OR description LIKE '%$search%'
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

                                while($row = mysqli_fetch_assoc($media_results)){
                                    # need to print out media name, rating, remarks, date
                                    $title = convertQuotes($row['title'], "QUOTES");
                                    $rating = $row['ranking'];
                                    $date = $row['release_date'];
                                    $description = convertQuotes($row['description'], "QUOTES");
                                    $mediaID = $row['ID'];
                                                                        
                                    ?>
                                        <div class='instance'>
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
                                            <input class="btn" name='selected-search-result' id='searchPage' type="radio" value='M <?php echo $mediaID ?>'>
                                        </div>
                                    <?php
                                }
                            }

                            if(isset($_POST['publisher'])  && !empty($search)){
                                checkTable($conn, 'PUBLISHER');

                                $pub_query = "
                                    SELECT *
                                    FROM PUBLISHER
                                    WHERE name LIKE '%$search%'
                                    OR description LIKE '%$search%'
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
                                            <input class="btn" name='selected-search-result' id='searchPage' type="radio" value='P <?php echo $row['name'] ?>'>
                                        </div>
                                    <?php
                                }                                
                            }

                            if(isset($_POST['crew'])  && !empty($search)){
                                checkTable($conn, 'CREW'); 
                                
                                $crew_query = "
                                    SELECT *
                                    FROM CREW
                                    WHERE name LIKE '%$search%'
                                    OR description LIKE '%$search%'
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
                                            <div class="search-header-in in-crew-desc">
                                                Description
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
                                    $desc = convertQuotes($row['description'], "QUOTES");

                                    ?>
                                        <div class='instance'>
                                            <input hidden value='<?php echo $crewID ?>'>
                                            <div class='instance-block in-crew-name'>
                                                <?php echo $name ?>
                                            </div>
                                            <div class='instance-block in-crew-desc'>
                                                <?php echo $desc ?>
                                            </div>
                                            <input class="btn" name='selected-search-result' id='searchPage' type="radio" value='C <?php echo $crewID ?>'>
                                        </div>
                                    <?php
                                }
                            }

                            if(isset($_POST['user'])  && !empty($search)){
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
                                            <input class="btn" name='selected-search-result' id='searchPage' type="radio" value='U <?php echo $username ?>'>
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