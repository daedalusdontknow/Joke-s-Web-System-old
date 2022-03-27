<?php
//start session
session_start();

//Gets data From db class
include 'db.php';

//mysql connection, will be changed to PDO
$con = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASS,
    $DATABASE_NAME
);
if (mysqli_connect_errno()) {
    //If there is an error with the connection, stop the script and display the error.
    exit("Failed to connect to MySQL: " . mysqli_connect_error());
}
//Check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST["username"], $_POST["password"])) {
    // Could not get the data that should have been sent.
    function_alert("Please fill both the username and password fields!");
}
//Prepare SQL, preparing SQL statement will prevent SQL injection.
if (
    $stmt = $con->prepare(
        "SELECT id, password, role, email FROM accounts WHERE username = ?"
    )
) {
    //Bind parameters (s = string, i = int, b = blob, etc)
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    //Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $role, $email);
        $stmt->fetch();
        //Account exists, now we verify the password.
        if (password_verify($_POST["password"], $password)) {
            //Verification succeded User has logged-in!
            //Create sessions, act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION["loggedin"] = true;
            $_SESSION["name"] = $_POST["username"];
            $_SESSION["id"] = $id;
            $_SESSION["role"] = $role;
            $_SESSION["mail"] = $email;
            if ($role > 1) {
                header("Location: Team\home.php");
            } else {
                header("Location: User\home.php");
            }
        } else {
            //Incorrect password
            function_alert("Incorrect username and/or password!");
        }
    } else {
        //Incorrect username
        function_alert("Incorrect username and/or password!");
    }
    //closing database connection
    $stmt->close();
}

//Javascript for popup window
function function_alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
    header("Refresh: 0; Index.html");
    exit();
}
?>
