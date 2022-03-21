<?php
include ('../db.php');
include ('../style.php');
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION["loggedin"])) {
    header("Location: /");
    exit();
}
if(!($_SESSION['role'] >= -1)){
	header('Location: /');
	exit;
}

$con = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASS,
    $DATABASE_NAME
);
if (mysqli_connect_errno()) {
    exit("Failed to connect to MySQL: " . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare(
    "SELECT email, role FROM accounts WHERE id = ?"
);
// In this case we can use the account ID to get the account info.
$stmt->bind_param("i", $_SESSION["id"]);
$stmt->execute();
$stmt->bind_result($email, $role);
$stmt->fetch();
$stmt->close();

switch ($role) {
    case -1:
        $roleinfo = "Muted";
        break;
    case 0:
        $roleinfo = "User";
        break;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Joke Home Page</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
		<link rel="icon" href="\images\JokeSystems.png">
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
        <img src="\images\JokeSystemsLogo.png" alt="Logo">
        <h1>Joke Systems</h1>
        <?=IconListUser()?>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?= $_SESSION["name"] ?>!</p>

      <div>
				<p>Usefull Links</p>
				<table>
					<tr>
						<td>Where is the Forum?</td>
						<td><i class="fa-brands fa-rocketchat"></i> Forum</td>
					</tr>
					<tr>
						<td>How to Report a Member</td>
						<td><i class="fa-solid fa-hammer"></i> Report</td>
					</tr>
					<tr>
						<td>Do you need Help?</td>
						<td><i class="fa-solid fa-ticket"></i> <a href="TicketSystem">Ticket System</a></td>
					</tr>
				</table>
			</div>

      <div>
        <p>Feedback for us</p>
        <table>
          <tr>
            <td>Let us Know how satisfied you are</td>
            <td><i class="fa-solid fa-star"></i> <a href="Review">Review</a></i></td>
          </tr>
          <tr>
            <td>You found a bug?</td>
            <td><i class="fa-solid fa-bug"></i> <a href="Bugs">Report bug</a></td>
          </tr>
        </table>
      </div>
		</div>
	</body>
</html>
