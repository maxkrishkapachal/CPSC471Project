<?php
    session_start();

    include("functions.php");
    include("connect.php");

    $user_data = getUserData($conn);

    if($user_data['user_type'] == 'MEMBER'){
        header('Location: ../acc/home.php');
        die;
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<a href="../acc/logout.php">Logout</a>
	<h1>You shouldn't be seeing this page</h1>

	<br>
	Hello, <?php echo $user_data['username']; ?>
</body>
</html>
