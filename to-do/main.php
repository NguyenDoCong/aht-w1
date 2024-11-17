<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>
<?php
include('../User.php');
include('todolist.php');
include('task.php');
session_start();
$user = $_SESSION["user"];
?>

<body>
    <div class="function">
        <p>Username: <?php echo $user->getUserName(); ?></p>
        <div class="add">
            <p><strong>Thêm task</strong></p>
            <form action="" method="post">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title"><br>
                <label>Status:</label><br>
                <input type="radio" id="done" name="status" value="done">
                <label for="done">Done</label><br>
                <input type="radio" id="not-done" name="status" value="not-done">
                <label for="not-done">Not Done</label><br>
                <label>Priority:</label><br>
                <input type="radio" id="high" name="priority" value="high">
                <label for="high">High</label><br>
                <input type="radio" id="medium" name="priority" value="medium">
                <label for="medium">Medium</label><br>
                <input type="radio" id="low" name="priority" value="low">
                <label for="low">Low</label><br>
                <label for="content">Content:</label><br>
                <input type="text" id="content" name="content"><br>
                <input type="submit" id="add" name="add" value="Thêm"><br><br>
            </form>
        </div>
        <div class="search">
            <p><strong>Tìm task</strong></p>
            <form action="" method="get">
                <label for="keyword">Từ khóa:</label><br>
                <input type="text" id="keyword" name="keyword"><br>
                <input type="submit" name="search" value="Tìm kiếm"><br><br>
                <label for="priority">Lọc:</label><br>
                <select name="priority" id="priority">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>
                <input type="submit" name="filter" value="Lọc"><br><br>
                <input type="submit" name="display" value="Hiển thị"><br><br>
            </form>
        </div>

        <a href="../index.php">
            <button>Trở lại trang đăng nhập</button>
        </a>
    </div>
    <?php
    // echo "<pre>";
    // print_r($user);
    // echo "</pre>";

    $tasks = [];

    $newList = new ToDoList();

    $newList->getData();

    function displayTask($task)
    {
    ?>
        <form method="post">
            <?php
            // echo "<pre>";
            // print_r($task);
            // echo "</pre>";
            $classname = "";
            if ($task->getStatus() == "done") :
                $classname = "done";
            endif;
            ?>
            <label class="<?php echo $classname ?>">Task <?php echo $task->getID(); ?></label>
            <button type="submit" name="remove" value="<?php echo $task->getID(); ?>">Xóa</button><br>
            <label for="title">Title</label><br>
            <input type="text" id="title" name="new-title" value="<?php echo $task->getTitle(); ?>"><br>
            <label>Status: <?php echo $task->getStatus(); ?></label><br>
            <input type="radio" id="done" name="new-status" value="done">
            <label for="done">Done</label><br>
            <input type="radio" id="not-done" name="new-status" value="not-done">
            <label for="not-done">Not Done</label><br>
            <label>Priority: <?php echo $task->getPriority(); ?></label><br>
            <input type="radio" id="high" name="new-priority" value="high">
            <label for="high">High</label><br>
            <input type="radio" id="medium" name="new-priority" value="medium">
            <label for="medium">Medium</label><br>
            <input type="radio" id="low" name="new-priority" value="low">
            <label for="low">Low</label><br>
            <label for="content">Content:</label><br>
            <input type="text" id="content" name="new-content" value="<?php echo $task->getContent(); ?>"><br>

            <button type="submit" name="edit" value="<?php echo $task->getID(); ?>">Sửa</button>
        </form> <br>
    <?php
    }

    function displayTasks($tasks)
    {
    ?>
        <p><strong>Danh sách task</strong></p>
        <div class="result">
            <?php
            if (!empty($tasks)):
                foreach ($tasks as $task) :
                    displayTask($task);
                endforeach;
            endif;
            ?>
            <div class="result">
            <?php
        }

        function findKey($haystack, $needle)
        {
            $key = -1;
            foreach ($haystack as $index => $item) {
                if ($item->getID() == $needle) {
                    $key = $index;
                }
            }
            return $key;
        }

        function searchtask($tasks, $keyword)
        {
            $tmp = [];
            foreach ($tasks as $item => $task) :
                if (str_contains(strtolower($task->getTitle()), $keyword) || str_contains(strtolower($task->getContent()), $keyword)):
                    $tmp[] = $task;
                endif;

            endforeach;
            return $tmp;
        }

        function filterTasks($tasks, $keyword)
        {
            $tmp = [];
            foreach ($tasks as $item => $task) :
                if (strtolower($task->getPriority()) == $keyword):
                    $tmp[] = $task;
                endif;

            endforeach;
            return $tmp;
        }

        $tasks = $newList->getList($user->getID());

        // displayTasks($tasks);
        $fullList = $newList->getFullList();

        $displayedTask = $tasks;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['add'])) :
                $task = new Task();
                $task->setID($newList->findMaxID() + 1);
                $task->setTitle($_POST["title"]);
                if (isset($_POST["status"])) {
                    $task->setStatus($_POST["status"]);
                }
                if (isset($_POST["priority"])) {
                    $task->setPriority($_POST["priority"]);
                }
                $task->setContent($_POST["content"]);
                $task->setUserID($user->getID());
                $newList->add($task, $user->getID());
                $tasks = $newList->getList($user->getID());

            elseif (isset($_POST['edit'])) :
                foreach ($fullList as $task) {
                    if ($task->getID() == $_POST["edit"]) {
                        $task->setTitle($_POST["new-title"]);
                        if (isset($_POST["new-status"])) {
                            $task->setStatus($_POST["new-status"]);
                        }
                        if (isset($_POST["new-priority"])) {
                            $task->setPriority($_POST["new-priority"]);
                        }
                        $task->setContent($_POST["new-content"]);
                    }
                }
                $newList->saveDataJSON($fullList);
                $tasks = $newList->getList($user->getID());
            elseif (isset($_POST['remove'])):
                foreach ($fullList as $task) {
                    if ($task->getID() == $_POST["remove"]) {
                        // echo findKey($fullList, [$_POST["remove"]]);
                        unset($fullList[findKey($fullList, $_POST["remove"])]);
                    }
                }
                $newList->saveDataJSON($fullList);
                $tasks = $newList->getList($user->getID());
            endif;
            $displayedTask = $tasks;
        }
        // echo "<pre>";
        // print_r($tasks);
        // echo "</pre>";
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET["keyword"])) :
                $keyword = strtolower($_GET["keyword"]);
                $displayedTask = searchtask($tasks, $keyword);
            endif;
            if (isset($_GET["filter"])) :
                $keyword = strtolower($_GET["priority"]);
                $displayedTask = filterTasks($tasks, $keyword);
            endif;
            if (isset($_GET["display"])) :
                $displayedTask = $tasks;
            endif;
        }
            ?>
            <?php
            displayTasks($displayedTask);
            ?>
</body>

</html>