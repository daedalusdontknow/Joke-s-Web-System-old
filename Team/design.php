<?php
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
          <a href="home.php"><i class="fa-solid fa-house"></i></a>
          <a href="profile.php"><i class="fas fa-user-circle"></i></a>
          <a href="Adress_book\index.html"><i class="fa-solid fa-address-book"></i></a>
          <a href="logout.php"><i class="fas fa-sign-out-alt"></i></a>
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
