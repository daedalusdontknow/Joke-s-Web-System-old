<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: /');
	exit;
}
if(!($_SESSION['role'] >= 1)){
	header('Location: /');
	exit;
}

include 'functions.php';
// Connect to MySQL using the below function
$pdo = pdo_connect_mysql();
// Check if the ID param in the URL exists
if (!isset($_GET['id'])) {
    exit('No ID specified!');
}
// MySQL query that selects the ticket by the ID column, using the ID GET request variable
$stmt = $pdo->prepare('SELECT * FROM tickets WHERE id = ?');
$stmt->execute([ $_GET['id'] ]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);
// Check if ticket exists
if (!$ticket) {
    exit('Invalid ticket ID!');
}
// Update status
if (isset($_GET['status']) && in_array($_GET['status'], array('open', 'closed', 'resolved', 'deleted'))) {

		if($_GET['status'] == 'deleted'){

			$stmt = $pdo->prepare('DELETE FROM tickets WHERE id = ?');
	    $stmt->execute([$_GET['id']]);
			$stmt = $pdo->prepare('DELETE FROM tickets_comments WHERE ticket_id = ?');
			$stmt->execute([$_GET['id']]);
			header('Location: index.php');

		} else {

    $stmt = $pdo->prepare('UPDATE tickets SET status = ? WHERE id = ?');
    $stmt->execute([ $_GET['status'], $_GET['id'] ]);
    header('Location: view.php?id=' . $_GET['id']);
    exit;

	}
}
// Check if the comment form has been submitted
if (isset($_POST['msg']) && !empty($_POST['msg'])) {
    // Insert the new comment into the "tickets_comments" table
    $stmt = $pdo->prepare('INSERT INTO tickets_comments (ticket_id, msg, username) VALUES (?, ?, ?)');
    $stmt->execute([ $_GET['id'], $_POST['msg'], $_SESSION['name'] ]);
    header('Location: view.php?id=' . $_GET['id']);
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM tickets_comments WHERE ticket_id = ? ORDER BY created DESC');
$stmt->execute([ $_GET['id'] ]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

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
        <h1>Joke Ticket System</h1>
				<?=IconListTeam()?>
    	</div>
    </nav>

<div class="content view">

	<h2>
		<a href="index.php"><i class="fa-solid fa-arrow-left"></i></a>
		<?=htmlspecialchars($ticket['title'], ENT_QUOTES)?> - <?=htmlspecialchars($ticket['username'], ENT_QUOTES)?>
		<span class="<?=$ticket['status']?>">(<?=$ticket['status']?>)</span>
	</h2>

    <div class="ticket">
        <p class="created"><?=date('F dS, G:ia', strtotime($ticket['created']))?></p>
        <p class="msg"><?=nl2br(htmlspecialchars($ticket['msg'], ENT_QUOTES))?></p>
    </div>

    <div class="btns">
        <a href="view.php?id=<?=$_GET['id']?>&status=closed" class="btn">Close</a>
        <a href="view.php?id=<?=$_GET['id']?>&status=resolved" class="btn">Resolve</a>
				<a href="view.php?id=<?=$_GET['id']?>&status=deleted" class="btn red">Delete</a>
    </div>

    <div class="comments">
        <?php foreach($comments as $comment): ?>
        <div class="comment">
            <div>
                <i class="fas fa-comment fa-2x"></i>
            </div>
            <p>
                <span><?=htmlspecialchars($comment['username'], ENT_QUOTES)?> - <?=date('F dS, G:ia', strtotime($comment['created']))?></span>
                <?=nl2br(htmlspecialchars($comment['msg'], ENT_QUOTES))?>
            </p>
        </div>
        <?php endforeach; ?>
        <form action="" method="post">
            <textarea name="msg" placeholder="Enter your comment..."></textarea>
            <input type="submit" value="Post Comment">
        </form>
    </div>

</div>
    </body>
</html>
