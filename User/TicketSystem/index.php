<?php
include ('../../style.php');
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

include ('../../db.php');
$pdo = pdo_connect_mysql();
// Output message variable
$msg = '';
// Check if POST data exists (user submitted the form)
if (isset($_POST['title'], $_POST['msg'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['title']) || empty($_POST['msg'])) {
        $msg = 'Please complete the form!';
    } else {
        // Insert new record into the tickets table
        $stmt = $pdo->prepare('INSERT INTO tickets (title, msg, email, username) VALUES (?, ?, ?, ?)');
        $stmt->execute([ $_POST['title'], $_POST['msg'], $_SESSION['mail'], $_SESSION['name'] ]);

        header('Location: thankyou');
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Joke Ticket System</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v6.0.0/css/all.css"
    />
    <link rel="icon" href="\images\JokeSystems.png" />
  </head>
  <body>
    <nav class="navtop">
      <div>
        <img src="\images\JokeSystemsLogo.png" alt="Logo" />
        <h1>Joke Systems</h1>
        <?=IconListUser()?>
      </div>
    </nav>
    <div class="content create">
      <h2>Create Ticket</h2>
      <form action="index.php" method="post">
        <label for="title">Title</label>
        <input
          type="text"
          name="title"
          placeholder="Title"
          id="title"
          required
        />
        <label for="msg">Message</label>
        <textarea
          name="msg"
          placeholder="Enter your message here..."
          id="msg"
          required
        ></textarea>

        Add choose file

        <input type="submit" value="Create" />
      </form>
      <?php if ($msg): ?>
      <p><?=$msg?></p>
      <?php endif; ?>
    </div>
  </body>
</html>
