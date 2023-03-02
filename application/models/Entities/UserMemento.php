<?php

class UserMemento extends CI_Model{
    private UserEntity $previous;

    public function __construct($user)
    {
        $this->previous = $user;
    }
  

    public function getPrevious():UserEntity{
        return $this->previous;
    }
}