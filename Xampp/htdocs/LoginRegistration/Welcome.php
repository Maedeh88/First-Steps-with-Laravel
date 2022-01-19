<html>
<head>
    <style>
        body {
            background-color: #7d7d7d;
        }
    </style>
</head>
<body>
<div style="text-align: center; background-color: #8bc9e3; width: 50%; position: absolute;left: 25%; top: 25%">
    <?php
    session_start();

    $fname = $_SESSION['firstname'];
    $lname = $_SESSION['lastname'];
    $age = $_SESSION['age'];
    $email = $_SESSION['email'];

    echo "Welcome " . $fname . " " . $lname . " <br />";
    echo "You are " . $age . " years old. <br/>";
    echo "your email address is " . $email;
    session_destroy();

    ?>
</div>
</body>
</html>






