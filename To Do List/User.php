<?php
class User
{
    private $id;
    private $username;
    private $password;

    public function getID()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setID($id)
    {
        $this->id = $id;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function toArray()
    {
        return [
            'id' => $this->getID(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword(),
        ];
    }

    public static function fromArray($data)
    {
        $user = new User();
        $user->setID($data['id']);
        $user->setUsername($data['username']);
        $user->setPassword($data['password']);
        return $user;
    }
}
