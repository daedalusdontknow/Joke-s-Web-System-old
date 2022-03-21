<?php

function IconListTeam() {
  echo <<<EOT
  <a href="/Team/home.php"><i class="fa-solid fa-house"></i></a>
  <a href="/Team/Adress_book\"><i class="fa-solid fa-address-book"></i></a>
  <a href="/Team/profile.php"><i class="fas fa-user-circle"></i></a>
  <a href="/Team/logout.php"><i class="fas fa-sign-out-alt"></i></a>
EOT;
}

function IconListUser() {
  echo <<<EOT
  <a href="/User/home.php"><i class="fa-solid fa-house"></i></a>
  <a href="/User/profile.php"><i class="fas fa-user-circle"></i></a>
  <a href="/User/logout.php"><i class="fas fa-sign-out-alt"></i></a>
EOT;
}

?>
