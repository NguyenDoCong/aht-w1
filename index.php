<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="text" id="password" name="password"><br>
        <input type="submit" value="Đăng nhập">
        <a href="./register.php">
            <button type="button" value="">Đăng ký</button>
        </a>
    </form>

    <?php
    include('User.php');
    session_start();

    $users = [];

    function loadFromFile()
    {
        global $users;
        $readFromJSON = json_decode(file_get_contents('users.json'), true);
        foreach ($readFromJSON as $item) {
            $users[] = User::fromArray($item);
        }
    }

    loadFromFile();

    if ($_SERVER["REQUEST_METHOD"] == "POST") :
        global $users;
        $user = new User();
        $user->setUsername($_POST["username"]);
        $user->setPassword($_POST["password"]);
        $error = "";
        foreach ($users as $u) {
            if ($u->getUsername() == $user->getUsername() && $u->getPassword() == $user->getPassword()):
                $_SESSION["user"] = $u;
                header('Location: ./to-do/main.php');
                exit();
            else:
                $error = "Tên hoặc mật khẩu không đúng";
            endif;
        }
    ?>
        <p><?php echo $error ?></p>
    <?php
    endif;
    ?>

</body>

</html>