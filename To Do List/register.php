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
        <input type="submit" value="Đăng ký"><br><br>
    </form>
    <?php
    include('User.php');

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

    function adduser($user)
    {
        global $users;
        array_push($users, $user);
        saveToFile($users);
    }

    function saveToFile($users)
    {
        // echo "<pre>";
        // print_r($users);
        // echo "</pre>";
        $data = array_map(function ($user) {
            return $user->toArray();
        }, $users);
        file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT));
    }

    ?>
    <div>

    </div>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = new User();
        $user->setID(count($users));
        $user->setUsername($_POST["username"]);
        $user->setPassword($_POST["password"]);
        $check_name = false;
        $check_password = false;
        if (empty($user->getUsername())): ?>
            <p>Không được để trống tên</p>
        <?php
        else:
            $check_name = true;
        endif;

        if (empty($user->getPassword())) : ?>
            <p>Không được để trống password</p>
        <?php
        else:
            $check_password = true;
        endif;

        if ($check_name && $check_password) :
            adduser($user);
        ?>
            <p>Đăng ký thành công</p>
            <a href="./index.php">
                <button>Trở lại trang đăng nhập</button>
            </a>
    <?php
        endif;
    }

    ?>

</body>

</html>