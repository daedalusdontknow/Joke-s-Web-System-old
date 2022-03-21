<?php
include ('../../style.php');
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();
// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 15;
// Prepare the SQL statement and get records from our contacts table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM accounts ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of contacts, this is so we can determine whether there should be a next and previous button
$num_contacts = $pdo->query('SELECT COUNT(*) FROM accounts')->fetchColumn();
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
    <div class="content read">
      <h2>Contacts</h2>

      <thead>
        <tr>
          <td><a href="">Normal</a></td>
          <td> | </td>
          <td><a href="">Newest user</a></td>
          <td> | </td>
          <td><a href="">Most activity</a></td>
          <td> | </td>
          <td><a href="">Most reports</a></td>
          <td></td>
        </tr>
      </thead>

      <table>

        <thead>
          <tr>
            <td>#</td>
            <td>Name</td>
            <td>Email</td>
            <td>Role</td>
            <td>Created</td>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contacts as $contact): ?>
          <tr>
            <td><?=$contact['id']?></td>
            <td><?=$contact['username']?></td>
            <td><?=$contact['email']?></td>
            <td><?=$contact['role']?></td>
            <td><?=$contact['created']?></td>
            <td class="actions">
              <a href="update.php?id=<?=$contact['id']?>" class="edit"
                ><i class="fas fa-pen fa-xs"></i
              ></a>
              <a href="delete.php?id=<?=$contact['id']?>" class="trash"
                ><i class="fas fa-trash fa-xs"></i
              ></a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="pagination">
        <?php if ($page >
        1): ?>
        <a href="Index.php?page=<?=$page-1?>"
          ><i class="fas fa-angle-double-left fa-sm"></i
        ></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_contacts): ?>
        <a href="Index.php?page=<?=$page+1?>"
          ><i class="fas fa-angle-double-right fa-sm"></i
        ></a>
        <?php endif; ?>
      </div>
    </div>
  </body>
</html>
