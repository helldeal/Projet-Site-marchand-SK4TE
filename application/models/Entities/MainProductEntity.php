<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductEntity.php";

//Produits sans réduction
class MainProductEntity extends ProductEntity{

    public function __construct(int $id, string $name, int $brand, int $category, float $price, string $pictures, string $description){
        $this->id =$id;
        $this->name =$name;
        $this->brand =$brand;
        $this->category =$category;
        $this->price =$price;
        $this->pictures =$pictures;
        $this->description =$description;
    }

    //TEMPLATE-METHOD : Valeur promotion
    public function promotion():?Int{
        return null;
    }

    
}