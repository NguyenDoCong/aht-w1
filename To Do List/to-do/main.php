<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="status">Status:</label><br>
        <input type="text" id="status" name="status"><br>
        <label for="content">Content:</label><br>
        <input type="text" id="content" name="content"><br>
        <input type="submit" id="add" name="add" value="Thêm"><br><br>
    </form>
    <?php
    include('../User.php');
    include('todolist.php');
    include('task.php');
    session_start();
    $user = $_SESSION["user"];
    // echo "<pre>";
    // print_r($user);
    // echo $user->getID();
    // echo "</pre>";

    $tasks = [];

    $newList = new ToDoList();

    $newList->getData();

    function displayTasks($tasks)
    {
        if (!empty($tasks)):
            foreach ($tasks as $task) :
    ?>
                <form method="post">
                    <?php
                    // echo "<pre>";
                    // print_r($task);
                    // echo "</pre>";
                    ?>
                    <label>Task <?php echo $task->getID(); ?></label>
                    <button type="submit" name="remove" value="<?php echo $task->getID(); ?>">Xóa</button><br>
                    <label for="title">Title</label><br>
                    <input type="text" id="new-title" name="new-title" value="<?php echo $task->getTitle(); ?>"><br>
                    <label for="status">Status</label><br>
                    <input type="text" id="new-status" name="new-status" value="<?php echo $task->getStatus(); ?>"><br>
                    <label for="content">Content</label><br>
                    <input type="text" id="new-content" name="new-content" value="<?php echo $task->getContent(); ?>"><br>

                    <button type="submit" name="edit" value="<?php echo $task->getID(); ?>">Sửa</button>
                </form>
                <br>
    <?php endforeach;
        endif;
    }

    $tasks = $newList->getList($user->getID());

    // displayTasks($tasks);


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['add'])) :
            $task = new Task();
            $task->setID(count($tasks));
            $task->setTitle($_POST["title"]);
            $task->setStatus($_POST["status"]);
            $task->setContent($_POST["content"]);
            $task->setUserID($user->getID());
            $newList->add($task, $user->getID());
            $tasks = $newList->getList($user->getID());

        elseif (isset($_POST['edit'])) :
            foreach ($tasks as $task) {
                if ($task->getID() == $_POST["edit"]) {
                    $task->setTitle($_POST["new-title"]);
                    $task->setStatus($_POST["new-status"]);
                    $task->setContent($_POST["new-content"]);
                }
            }
            $newList->saveDataJSON($tasks);
        elseif (isset($_POST['remove'])):
            foreach ($tasks as $task) {
                if ($task->getID() == $_POST["remove"]) {
                    unset($tasks[$_POST["remove"]]);
                }
                $newList->saveDataJSON($tasks);
            }
        endif;
    }
    displayTasks($tasks);
    // echo "<pre>";
    // print_r($tasks);
    // echo "</pre>";
    ?>
    <a href="../index.php">
        <button>Trở lại trang đăng nhập</button>
    </a>
</body>

</html>