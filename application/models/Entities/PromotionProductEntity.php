<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."PromotionEntity.php";

class PromotionProductEntity extends ProductEntity{
    private PromotionEntity $promotion;

    public function __construct(int $id, string $name, int $brand, int $category, float $price, string $pictures, string $description, PromotionEntity $promotion){
        $this->id =$id;
        $this->name =$name;
        $this->brand =$brand;
        $this->category =$category;
        $this->price =$price;
        $this->pictures =$pictures;
        $this->description =$description;

        $this->promotion=$promotion;
    }

    //TEMPLATE-METHOD : Valeur promotion
    public function promotion():?Int{
        return $this->promotion->getPromo();
    }

    
}