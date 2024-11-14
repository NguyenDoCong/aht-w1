<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <label for="task">Task:</label><br>
        <input type="text" id="task" name="task"><br>
        <input type="submit" id="add" name="add" value="Thêm"><br><br>
    </form>
    <?php

    function getTasks()
    {
        $data = file_get_contents('to-do.json');
        return json_decode($data, true);
    }

    $tasks = getTasks();

    function saveDataJSON($tasks)
    {
        file_put_contents('to-do.json', json_encode($tasks));
    }

    function displayTasks($tasks)
    {
    ?>
        <?php
        $item = 0;
        foreach ($tasks as $task) :
            $item++;
        ?>
            <form method="post">
                <!-- <label id=<?php echo $item ?>>
                    <?php echo $task; ?>
                </label> -->
                <input type="text" id="update" name="update" placeholder="<?php echo $task; ?>"><br>
                <button type="submit" name="edit" value="<?php echo $item; ?>">Sửa</button>
                <button type="submit" name="remove" value="<?php echo $item; ?>">Xóa</button>
            </form>

        <?php endforeach; ?>
    <?php
    }

    function add(&$tasks, $task)
    {
        array_push($tasks, $task);
        saveDataJSON($tasks);
        displayTasks($tasks);
    }

    function edit(&$tasks, $id, $value)
    {
        $tasks[$id - 1] = $value;
        saveDataJSON($tasks);
        displayTasks($tasks);
    }

    function remove(&$tasks, $id)
    {
        array_splice($tasks, $id - 1, 1);
        saveDataJSON($tasks);
        displayTasks($tasks);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['add'])) :
            $task = $_POST["task"];
            add($tasks, $task);
        elseif (isset($_POST['edit'])) :
            $id = $_POST["edit"];
            $update = $_POST["update"];
            edit($tasks, $id, $update);
        elseif (isset($_POST['remove'])):
            $id = $_POST["remove"];
            remove($tasks, $id);
        endif;
    }
    ?>

</body>

</html>