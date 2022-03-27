<?php
include ('../../style.php');
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check that the contact ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Make sure the user confirms beore deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM accounts WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the contact!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: Index.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Joke Contact System</title>
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
        <?=IconListTeam()?>
      </div>
    </nav>
    <div class="content delete">
      <h2>Delete Contact #<?=$contact['id']?></h2>
      <?php if ($msg): ?>
      <p><?=$msg?></p>
      <?php else: ?>
      <p>Are you sure you want to delete contact #<?=$contact['id']?>?</p>
      <div class="yesno">
        <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$contact['id']?>&confirm=no">No</a>
      </div>
      <?php endif; ?>
    </div>
  </body>
</html>
