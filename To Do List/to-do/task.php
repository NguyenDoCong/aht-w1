<?php
class Task
{
    private $id;
    private $title;
    private $status;
    private $content;
    private $userID;

    public function getID()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getUserID()
    {
        return $this->userID;
    }

    public function setID($id)
    {
        $this->id = $id;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function setUserID($userID)
    {
        $this->userID = $userID;
    }

    public function toArray()
    {
        return [
            'id' => $this->getID(),
            'title' => $this->getTitle(),
            'status' => $this->getStatus(),
            'content' => $this->getContent(),
            'userID' => $this->getUserID(),
        ];
    }

    public function fromArray($data)
    {
         // $task = new Task();
        $this->setID($data['id']);
        $this->setTitle($data['title']);
        $this->setStatus($data['status']);
        $this->setContent($data['content']);
        $this->setUserID($data['userID']);
        // return $task;
    }
}
