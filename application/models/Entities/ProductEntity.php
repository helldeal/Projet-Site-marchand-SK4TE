<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR."PromotionInterface.php";

//ProductEntity est la classe-mère de MainProductEntity et de PromotionProductEntity
abstract class ProductEntity extends CI_Model implements PromotionInterface{

    protected int $id;
    protected string $name;
    protected string $brand;
    protected ?string $category;
    protected float $price;
    protected string $pictures;
    protected ?string $description;
    /**
    * @return int
    */


    public function getId(): int
    {
        return $this->id;
    }
    /**
    * @return string
    */
    public function getName(): string
    {
        return $this->name;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
    * @return float
    */
    public function getPrice(): float
    {
        return round($this->price, 2);
    }
    /**
    * @return int
    */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

/*---------------------------------------------- SETTERS

    /**
    * @param int $id
    */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    /**
    * @param string $name
    */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setBrand(string $brand): void
    {
        $this->brand = $brand;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }
    /**
    * @param float $price
    */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    /**
    * @param int $quantity
    */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    //Retourne le nombre de photos du produit
    public function getPicturesSize(): int
    {
        $pics=explode(', ', $this->pictures);
        return sizeof($pics);
    }

    //Retourne une photo en fonction de l'index en paramètre
    public function getPicture(int $index): string
    {
        $pics=explode(', ', $this->pictures);
        return $pics[$index];
    }

    //Supprime une photo
    public function deletePicture(string $picture): void{
        $pics=$this->getPictures();
        unset($pics[array_search($picture, $pics)]);
        $this->setPictures(implode(', ', $pics));
    }

    //Renvoi toutes les photos sous la forme d'un tableau de string
    public function getPictures(): Array
    {
        $pics=explode(', ', $this->pictures);
        return $pics;
    }

    //Renvoi le string des photos
    public function getPicturesString(): String
    {
        return $this->pictures;
    }

    //Défini le string des photos
    public function setPictures(string $picture): void
    {
        $this->pictures=$picture;
    }

    //Remplace une photo a un index donné en paramètre
    public function setPictureAtIndex(string $picture, int $index): void{
        $pics=array_replace($this->getPictures(), array($index => $picture));
        $this->setPictures(implode(', ', $pics));
    }

    //Ajoute une photo a un index donné en paramètre
    public function addPictureAtIndex(string $picture, int $index){
        $a=array_slice($this->getPictures(), 0, $index);
        $b=array($picture);
        $c=array_slice($this->getPictures(), $index);
        $ab=array_merge($a,$b);
        $pics=array_merge($ab, $c);
        $this->setPictures(implode(', ', $pics));
    }

    //TEMPLATE-METHOD : Fonction qui renvoi la valeur de la promotion
    abstract function promotion():?Int;

    public function getNewPrice():float{
        if ($this->promotion()==null) {
            return $this->price;
        }
        $promo=$this->promotion();
        return round((1-($promo)/100)*$this->price, 2);
    }
}
?>
