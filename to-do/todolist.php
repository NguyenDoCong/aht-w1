<?php
class ToDoList
{
    private $tasks = [];
    public function getData()
    {
        $tmp = [];
        $data = file_get_contents('task.json');
        $readFromJSON = json_decode($data, true);
        if (!empty($readFromJSON)) {
            foreach ($readFromJSON as $item) {
                $task = new Task();
                $task->fromArray($item);
                $tmp[] = $task;
            }
        }
        $this->tasks = $tmp;
        // echo "<pre>";
        // print_r($this->tasks);
        // echo "</pre>";
    }

    public function getList($id)
    {
        $this->getData();
        $tmp = [];
        foreach ($this->tasks as $item) {
            if ($item->getUserID() == $id) {
                // echo $item->getUserID() . $id;
                $tmp[] = $item;
            }
        }
        return $tmp;
    }

    public function getFullList()
    {
        return $this->tasks;
    }

    public function findMaxID()
    {
        $maxID = 0;
        foreach ($this->tasks as $item) {
            if ($item->getID() > $maxID) {
                $maxID = $item->getID();
            }
        }

        return $maxID;
    }

    function add($task)
    {
        // $this->getData($id);
        array_push($this->tasks, $task);
        $this->saveDataJSON($this->tasks);
    }

    function edit(&$tasks, $id, $value)
    {
        $tasks[$id - 1] = $value;
        $this->saveDataJSON($tasks);
    }

    function remove(&$tasks, $id)
    {
        array_splice($tasks, $id - 1, 1);
        $this->saveDataJSON($tasks);
    }

    function saveDataJSON($tasks)
    {
        $data = array_map(function ($task) {
            return $task->toArray();
        }, $tasks);
        file_put_contents('task.json', json_encode($data, JSON_PRETTY_PRINT));
    }
}
