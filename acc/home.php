<?php
    session_start();

    include("../gen/functions.php");
    include("../gen/connect.php");

    $user_data = getUserData($conn);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../gen/main.css" media="screen">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <!-- This page needs:
            - PERSONAL ACCOUNT -
            * edit account 
            * logout
            - MEDIA, CREW, PUBLISHER -
            * search bar for the media, publishers, and crew
            * add new media button, publishers, and crew
            * select media, publisher, or crew
            - LOGS -
            * search logs
            * add log
            * select log
            * edit log
            * delete log
            - COMMENTS -
            * view comments
            - LIST - 
            * add list button
            * search bar for the lists
            * lists
            * select list option
            * delete list option once selected
            * edit list option once selected 
        -->
        <div class='account'>
            <div class='account-buttons'>
                <button class='btn'>Edit Account</button>
                <button class='btn'><a href='logout.php'>Logout</a></button>
            </div>
            <div class='welcome-label-div'>
                <label class='welcome-label'>
                    Welcome, <?php echo $user_data['username'] ?>
                </label>
            </div>
        </div>
        <div class='main-page-container'>   
            <div class='log ll-box'> 
                <div class='mpc-buttons'>
                    <button class='btn'><a href='../log/addLog.php'>Add Log</a></button>
                    <button class='btn'><a href=''>Edit Log</a></button>
                    <button class='btn'><a href=''>Delete Log</a></button>
                </div>
                <form class='log mpc-el search-form' id="form" role="search">
                    <input class='log mpc-el' type="search" id="query" name="log-search"  placeholder="Search Logs...">
                    <button class='log mpc-el btn'>Search</button>
                </form> 
                <div class='scroll'>
                    <div class='scr'>
                        <?php  
                            checkTable($conn, 'LOGS');

                            $username = $user_data['username'];
                            
                            $logs = "
                                SELECT *
                                FROM LOGS
                                WHERE username = '$username'
                            ";

                            $logs_result = mysqli_query($conn, $logs);

                            while($row = mysqli_fetch_assoc($logs_result)){
                                # need to print out media name, rating, remarks, date
                                $medianame = convertQuotes($row['medianame'], "QUOTES");
                                $rating = $row['rating'];
                                $remarks = convertQuotes($row['remarks'], "QUOTES");
                                $date = $row['date'];
                                
                                ?>
                                    <div class='instance'>
                                        <input class='instance-block' name='log-instance' type='radio'>
                                        <div class='instance-block in-name' name='name'>
                                            <?php echo $medianame ?>
                                        </div>
                                        <div class='instance-block in-rating' name='rating'>
                                            <?php echo $rating ?>
                                        </div>
                                        <div class='instance-block in-remarks' name='remarks'>
                                            <?php echo $remarks ?>
                                        </div>
                                        <div class='instance-block in-date' name='date'>
                                            <?php echo $date ?>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class='list ll-box'>
                <div class='mpc-buttons'>
                    <button class='list mpc-el btn'><a href='../list/addList.php'>Add List</a></button>
                    <button class='list mpc-el btn'><a href=''>Edit List</a></button>
                    <button class='list mpc-el btn'><a href=''>Add To List</a></button>
                    <button class='list mpc-el btn'><a href=''>Delete Lists</a></button>
                </div>
                <form class='list mpc-el search-form' id="form" role="search">
                    <input class='list mpc-el' type="search" id="query" name="list-search"  placeholder="Search Lists...">
                    <button class='list mpc-el btn'>Search</button>
                </form>
                <div class='scroll'>
                    <div class='scr'>
                    <?php  
                            checkTable($conn, 'LIST');

                            $username = $user_data['username'];
                            
                            $lists = "
                                SELECT *
                                FROM LIST
                                WHERE username = '$username'
                            ";

                            $lists_result = mysqli_query($conn, $lists);

                            while($row = mysqli_fetch_assoc($lists_result)){
                                # need to print out media name, rating, remarks, date
                                $name = convertQuotes($row['name'], "QUOTES");
                                $desc = convertQuotes($row['description'], "QUOTES");

                                ?>
                                    <div class='instance'>
                                        <input class='instance-block' name='list-instance' type='radio'>
                                        <div class='instance-block in-name' name='name'>
                                            <?php echo $name?>
                                        </div>
                                        <div class='instance-block in-desc' name='desc'>
                                            <?php echo $desc ?>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>