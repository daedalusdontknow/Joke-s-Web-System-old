<?php
include ('../db.php');
include ('../style.php');
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: /');
	exit;
}

if(!($_SESSION['role'] >= -1)){
	header('Location: /');
	exit;
}

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT email, role, created FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($email, $role, $created);
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
		<title>Joke Profile Page</title>
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
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?=$email?></td>
					</tr>
          <tr>
            <td>Role:</td>
            <td><?=$roleinfo?></td>
          </tr>
					<tr>
						<td>Registered since:</td>
						<td><?=$created?></td>
					</tr>
				</table>
			</div>

			<div>
				<p>Your activity details are below:</p>
				<table>
					<tr>
						<td>Something:</td>
						<td>Something</td>
					</tr>
					<tr>
						<td>Something:</td>
						<td>Something</td>
					</tr>
          <tr>
            <td>Something:</td>
            <td>Something</td>
          </tr>
					<tr>
						<td>Something:</td>
						<td>Something</td>
					</tr>
				</table>
			</div>

			<div>
				<p>Your Functions are below:</p>
				<table>
					<tr>
						<a href="ResetPassword.php" class="Button">Reset Password</a>
						<a> </a>
						<a href="ResetPassword.php" class="Button">Forgot Password</a>
						<a> </a>
						<a href="delete.php" class="ButtonRed">Delete account</a>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
