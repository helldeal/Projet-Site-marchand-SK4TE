<?php
class BrandEntity extends CI_Model{
    private int $id;
    private string $name;

    public function getId():Int{
        return $this->id;
    }

    public function getName():String{
        return $this->name;
    }

    public function setId(Int $id){
        $this->id=$id;
    }

    public function setName(String $name){
        $this->name=$name;
    }
}