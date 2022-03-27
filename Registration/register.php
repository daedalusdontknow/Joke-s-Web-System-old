<?php
//Gets data From db class
include ('../db.php');

//mysql connection, will be changed to PDO
$con = mysqli_connect(
    $DATABASE_HOST,
    $DATABASE_USER,
    $DATABASE_PASS,
    $DATABASE_NAME
);
if (mysqli_connect_errno()) {
    //If there is an error with the connection, stop and display the error.
    exit("Failed to connect to MySQL: " . mysqli_connect_error());
}
//check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST["username"], $_POST["password"], $_POST["email"])) {
    //Could not get the data that should have been sent.
    function_alert("Please complete the registration form");
}
//Checks if registration values are not empty.
if (
    empty($_POST["username"]) ||
    empty($_POST["password"]) ||
    empty($_POST["email"])
) {
    //One or more values are empty.
    function_alert("Please complete the registration form");
}
//check if the account with that username exists.
if (
    $stmt = $con->prepare(
        "SELECT id, password FROM accounts WHERE username = ?"
    )
) {
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        function_alert("Email is not valid!");
    }
    if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["username"]) == 0) {
        function_alert("Username is not valid!");
    }
    if (strlen($_POST["password"]) > 20 || strlen($_POST["password"]) < 5) {
        function_alert("Password must be between 5 and 20 characters long!");
    }
    $stmt->bind_param("s", $_POST["username"]);
    $stmt->execute();
    $stmt->store_result();
    //Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        //Username already exists
        function_alert("Username exists, please choose another!");
    } else {
        //Username doesnt exists, insert new account
        if (
            $stmt = $con->prepare(
                "INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)"
            )
        ) {
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $stmt->bind_param(
                "sss",
                $_POST["username"],
                $password,
                $_POST["email"]
            ); //rolle hinzufügen
            $stmt->execute();
            Regissucc("You have successfully registered, you can now login!");
        } else {
            //Something went wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            function_alert("Could not prepare statement!");
        }
    }
    $stmt->close();
} else {
    //Something went wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    function_alert("Could not prepare statement!");
}
$con->close();

function function_alert($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
    header("Refresh: 0; /Registration");
    exit();
}

function Regissucc($msg)
{
    echo "<script type='text/javascript'>alert('$msg');</script>";
    header("Refresh: 0; /");
    exit();
}
?>
