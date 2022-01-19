<html>
<?php error_reporting(E_ERROR | E_PARSE); ?>

<head>
    <title>
        Login Registration
    </title>
    <style>
        body {
            background-color: #1a1a1a;
        }

        input {
            width: 40%;
            height: 7%;
            border: 1px;
            border-radius: 05px;
            color: #07072AFF;
            background-color: #8bc9e3;
            padding: 8px 15px 8px 15px;
            margin: 10px 0px 10px 0px;
            box-shadow: rgba(255, 255, 255, 0.55) 2px 2px 3px 2px;
        }
    </style>
</head>
<body>
<div style="text-align: center; margin-top: 2%">
    <form action="<?php $_PHP_SELF ?>" method="POST">
        <input type="text" name="username" placeholder="Enter a username" required><br/>
        <input type="password" name="password" placeholder="Enter your password" required><br/>

        <input type="submit" name="login" value="Login">
        <div style="background-color: #7d7d7d; width: 40% "></div>
    </form>
    <form action="Register.php" method="POST">
        <input type="submit" name="register" value="You don't have an account?"
        <div style="background-color: rgba(127,151,171,0.67); width: 30%"><br/>
    </form>
</div>
</body>
</html>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "USERS";

$connection = new mysqli ($servername, $username, $password, $database);
if (isset($_POST["login"])) {
    $login_query = "SELECT * FROM personal_information
                WHERE username = '$_POST[username]'";
    if ($connection->query($login_query) == TRUE) {
        if (mysqli_num_rows($connection->query($login_query)) > 0) {
            $row = mysqli_fetch_row($connection->query($login_query));
            $password = $row[4];
            if ($password == $_POST["password"]) {
                $first_name = $row[1];
                $last_name = $row[2];
                $email = $row[3];
                $age = $row[5];

                session_start();
                $_SESSION['firstname'] = $first_name;
                $_SESSION['lastname'] = $last_name;
                $_SESSION['age'] = $age;
                $_SESSION['email'] = $email;

                header('location: Welcome.php');
            } else {
                echo "your password is incorrect!";
            }
        } else {
            echo "There is no account with this username";
        }
    }
}
if (isset($_POST["register"])) {
    header("Location: /Register.php");
}
$connection->close();
?>

