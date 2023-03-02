<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosEntity.php";
class ProductInfosShoes extends ProductInfos{
    private int $size;
    protected int $quantity;


    public function __construct(int $id, int $product, int $size, int $quantity, string $color, string $colorCode) {
        $this->id =$id;
        $this->product =$product;
        $this->size =$size;
        $this->quantity =$quantity;
        $this->color =$color;
        $this->colorCode =$colorCode;
    }

    function getSize():Int{
        return $this->size;
    }

    function getQuantity():Int{
        return $this->quantity;
    }

    function setQuantity(Int $qty):void{
        $this->quantity=$qty;
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