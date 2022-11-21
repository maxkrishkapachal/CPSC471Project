<?php
    session_start();

    include("../functions.php");
    include("../connect.php");

    $user_data = getUserData($conn);

    if(isset($_POST['logout-button'])){
        header('Location: logout.php');
        die;
    }

    if(isset($_POST['add-log-button'])){
        header('Location: addLog.php');
        die;
    }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <link rel="stylesheet" href="../main.css" media="screen">
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
                <input name="edit-account-button" type="submit" class="button" value="Edit Account">
                <input name="logout-button" type="submit" class="button" value="Logout">
            </div>
            <div class='welcome-label-div'>
                <label class='welcome-label'>
                    Welcome, <?php echo $user_data['username'] ?>
                </label>
            </div>
        </div>
        <div class='main-page-container'>   
            <div class='log ll-box'> 
                <form class='mpc-buttons' method='post'>
                    <input name="add-log-button" type="submit" class="button" value="Add Log">
                    <input name="edit-log-button" type="submit" class="button" value="Edit Log">
                    <input name="delete-log-button" type="submit" class="button" value="Delete Log">
                </form>
                <form class='log mpc-el search-form' id="form" role="search">
                    <input class='log mpc-el' type="search" id="query" name="log-search" placeholder="Search Logs...">
                    <input name="log-search-button" type="submit" class="button" value="Search">
                    
                </form> 
                <div class='scroll'>
                    <div class='log-scr'>
                        this is where the logs will go.
                        According to all known laws of aviation, there is no way a bee should be able to fly. Its wings are too small to get its fat little body off the ground. The bee, of course, flies anyway because bees don't care what humans think is impossible. Yellow, black. Yellow, black. Yellow, black. Yellow, black. Ooh, black and yellow! Let's shake it up a little. Barry! Breakfast is ready! Ooming! Hang on a second. Hello? - Barry? - Adam? - Oan you believe this is happening? - I can't. I'll pick you up. Looking sharp. Use the stairs. Your father paid good money for those. Sorry. I'm excited. Here's the graduate. We're very proud of you, son. A perfect report card, all B's. Very proud. Ma! I got a thing going here. - You got lint on your fuzz. - Ow! That's me! - Wave to us! We'll be in row 118,000. - Bye! Barry, I told you, stop flying in the 
                    </div>
                </div>
            </div>
            <div class='list ll-box'>
                <div class='mpc-buttons'>
                    <input name="add-list-button" type="submit" class="button" value="Add List">
                    <input name="edit-list-button" type="submit" class="button" value="Edit List">
                    <input name="add-to-list-button" type="submit" class="button" value="Add To List">
                    <input name="delete-list-button" type="submit" class="button" value="Delete Lists">
                </div>
                <form class='list mpc-el search-form' id="form" role="search">
                    <input class='list mpc-el' type="search" id="query" name="list-search" placeholder="Search Lists...">
                    <input name="list-search-button" type="submit" class="button" value="Search">
                </form>
                <div class='scroll'>
                    <div class='log-scr'>
                        this is where the lists will go.
                        According to all known laws of aviation, there is no way a bee should be able to fly. Its wings are too small to get its fat little body off the ground. The bee, of course, flies anyway because bees don't care what humans think is impossible. Yellow, black. Yellow, black. Yellow, black. Yellow, black. Ooh, black and yellow! Let's shake it up a little. Barry! Breakfast is ready! Ooming! Hang on a second. Hello? - Barry? - Adam? - Oan you believe this is happening? - I can't. I'll pick you up. Looking sharp. Use the stairs. Your father paid good money for those. Sorry. I'm excited. Here's the graduate. We're very proud of you, son. A perfect report card, all B's. Very proud. Ma! I got a thing going here. - You got lint on your fuzz. - Ow! That's me! - Wave to us! We'll be in row 118,000. - Bye! Barry, I told you, stop flying in the 
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>