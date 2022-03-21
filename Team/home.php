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
if (!($_SESSION["role"] >= 1)) {
    header("Location: /");
    exit();
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
    case 1:
        $roleinfo = "Supporter";
        break;
    case 2:
        $roleinfo = "Moderator";
        break;
    case 9:
        $roleinfo = "Developer";
        break;
    case 10:
        $roleinfo = "Administrator";
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
        <?=IconListTeam()?>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Welcome back, <?= $_SESSION["name"] ?>!</p>

        <div>
      				<p><i class="fa-solid fa-ticket"></i> Ticketing System</p>
      				<table>
      					<tr>
      						<td>Active Tickets:</td>
      						<td>Function does not exist yet</td>
      					</tr>
      					<tr>
      						<td></td>
      						<td><a href="Ticketing_System\index.php">Tickets</a></td>
      					</tr>
                <tr>
                  <td>Working as:</td>
                  <td><?= $roleinfo ?></td>
                </tr>
      				</table>
      			</div>

      			<div>
      				<p><i class="fa-brands fa-rocketchat"></i> Forum</p>
      				<table>
      					<tr>
      						<td>Something:</td>
      						<td>Function does not exist yet</td>
      					</tr>
      					<tr>
      						<td>Something:</td>
      						<td>Function does not exist yet</td>
      					</tr>
      					<tr>
      						<td>Something:</td>
      						<td>Function does not exist yet</td>
      					</tr>
      				</table>
      			</div>

		</div>
	</body>
</html>
