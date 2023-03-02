<?php
class ColorEntity extends CI_Model{
    private string $name;
    private string $code;

    public function __construct(string $name, string $code){
        $this->name=$name;
        $this->code=$code;
    }

    public function getCode():string{
        return $this->code;
    }

    public function getName():String{
        return $this->name;
    }

    public function setCode(string $code){
        $this->code=$code;
    }

    public function setName(String $name){
        $this->name=$name;
    }
}
