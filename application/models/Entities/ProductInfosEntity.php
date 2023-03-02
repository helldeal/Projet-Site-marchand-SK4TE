<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosClothesEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosShoesEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosColorEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosMillimetersEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosInchesEntity.php";

abstract class ProductInfos extends CI_Model{
    protected int $id;
    protected int $product;
    protected string $color;
    protected string $colorCode;

    function getId():Int{
        return $this->id;
    }

    function getProduct():Int{
        return $this->product;
    }

    abstract function getSize();

    abstract function getQuantity():?Int;

    abstract function setQuantity(Int $qty):void;

    function getColor():String{
        return $this->color;
    }

    function getColorCode():String{
        return $this->colorCode;
    }

}