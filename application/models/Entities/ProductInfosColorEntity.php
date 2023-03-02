<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosEntity.php";
class ProductInfosColor extends ProductInfos{

    public function __construct(int $id, int $product, string $color, string $colorCode) {
        $this->id =$id;
        $this->product =$product;
        $this->color =$color;
        $this->colorCode =$colorCode;
    }

    function getSize():?String{
        return null;
    }

    function getQuantity():?Int{
        return null;
    }

    function setQuantity(Int $qty):void{
        $this->quantity=null;
    }

    public function getInfos():array{
        return array(
            "product"=>$this->product,
            "size"=>$this->size,
            "color"=>$this->color,
            "quantity"=>$this->quantity,
            "colorCode"=>$this->colorCode,
        );
    }
}