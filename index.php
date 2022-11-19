<?php
    session_start();
    include("connect.php");

    $user_data = NULL;

    if(isset($_SESSION['username'])) {
		$user = $_SESSION['username'];
		$query = "
            SELECT *
            FROM USER
            WHERE username = '$user'";

		$result = mysqli_query($conn,$query);
		if($result && mysqli_num_rows($result) > 0) {
			$user_data = mysqli_fetch_assoc($result);
		}
	}
    if($user_data == NULL){
        header("Location: login.php");
        die;
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<a href="logout.php">Logout</a>
	<h1>This is the index page</h1>

	<br>
	Hello, <?php echo $user_data['username']; ?>
</body>
</html>
