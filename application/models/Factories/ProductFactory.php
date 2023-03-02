<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."PromotionProductEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."MainProductEntity.php";

//FACTORY : Cette factory prends en entrée un tableau de produits. Si il y a une promotion, alors la factory fabrieque un object de type PromotionProductEntity
class ProductFactory extends CI_Model{

    public function factory(array $infos){
        if (!isset($infos["promo"])){
            return new MainProductEntity($infos["id"], $infos["name"],$infos["brand"],$infos["category"],$infos["price"],$infos["pictures"],$infos["description"]);
        } else {
            return new PromotionProductEntity($infos["id"], $infos["name"],$infos["brand"],$infos["category"],$infos["price"],$infos["pictures"],$infos["description"], $infos["promo"]);
        }
    }
}