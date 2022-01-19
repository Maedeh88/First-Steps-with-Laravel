<html>
<?php error_reporting(E_ERROR | E_PARSE); ?>

<?php //error_reporting(E_ERROR, E_PARSE) ?>
<head>
    <title>
        Login Registration
    </title>
    <style>
        body {
            background-color: #1A1A1AD6;
        }

        input {
            width: 40%;
            height: 8%;
            border: 1px;
            border-radius: 05px;
            color: #0000bf;
            background-color: #1e425d;
            padding: 8px 15px 8px 15px;
            margin: 10px 0px 10px 0px;
            box-shadow: rgba(255, 255, 255, 0.55) 2px 2px 3px 2px;
        }
    </style>
</head>
<body>
<div style="text-align: center; margin-top: 4%">
    <form action="<?php $_PHP_SELF ?>" method="post">
        <input type="text" name="fname" placeholder="Enter First Name" required/><br/>
        <input type="text" name="lname" placeholder="Enter Last Name" required/><br/>
        <input type="number" name="age" placeholder="Enter Age" required/><br/>
        <input type="email" name="email" placeholder="Enter your email address" required/><br/>
        <input type="text" name="username" placeholder="Enter a username" required/><br/>
        <input type="password" name="password" placeholder="Enter your password" required><br/>

        <input type="submit" name="register" value="Register"
        <div style="background-color: #7d7d7d"/>

    </form>
</div>
</body>
</html>

<?php

$serverame = "localhost";
$username = "root";
$password = "";
$database = "USERS";

$connection = new mysqli($serverame, $username, $password, $database);
if (isset($_POST["register"])) {
    // check the registration request
    if ($_POST["username"] != NULL) {
        $check = "SELECT * FROM personal_information
                WHERE username = '$_POST[username]' ";
//    }
        if (mysqli_num_rows($connection->query($check)) > 0) {
            echo "This username has already signed up";
        } else {
            $register_query = "INSERT INTO personal_information(firstname, lastname, email, age, username, password)
        VALUES ('$_POST[fname]', '$_POST[lname]','$_POST[email]', '$_POST[age]', '$_POST[username]', '$_POST[password]')";
            if ($connection->query($register_query) == TRUE) {
                echo "your data has been recorded";
            } else {
                echo "ERROR";
            }
        }
    }

    $connection->close();
    exit();

}
?>

