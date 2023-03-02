<?php
class CategoryEntity extends CI_Model{
    private int $id;
    private string $name;

    public function getId():int{
        return $this->id;
    }

    public function getName():String{
        return $this->name;
    }

    public function setId(int $id){
        $this->id=$id;
    }

    public function setName(String $name){
        $this->name=$name;
    }
}