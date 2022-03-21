<?php
include ('../../style.php');

function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    include ('../../db.php');
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}

// Template header, feel free to customize this
function template_header($title) {
echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css">
    <link rel="icon" href="\images\JokeSystems.png">
	</head>
	<body>
    <nav class="navtop">
    	<div>
        <img src="\images\JokeSystemsLogo.png" alt="Logo">
        <h1>Joke Systems</h1>

    	</div>
    </nav>
EOT;
}
// Template footer
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
?>
