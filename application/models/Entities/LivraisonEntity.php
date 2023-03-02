<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Interfaces'.DIRECTORY_SEPARATOR."LivraisonInterface.php";

abstract class LivraisonEntity extends CI_Model implements LivraisonInterface{

    protected int $id;
    protected int $taxe;
    protected float $fdp;
    protected string $adresse;
    /**
    * @return int
    */
    public function __construct(int $id, int $taxe, float $fdp, string $adresse){
        $this->id =$id;
        $this->taxe =$taxe;
        $this->fdp =$fdp;
        $this->adresse =$adresse;
    }
    

    public function getId(): int
    {
        return $this->id;
    }
    public function getTaxe(): int
    {
        return $this->taxe;
    }
    public function getFdp(): float
    {
        return $this->fdp;
    }
    public function getAdresse(): string
    {
        return urldecode($this->adresse);
    }

/*---------------------------------------------- SETTERS

    /**
    * @param int $id
    */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setTaxe(int $taxe): void
    {
        $this->taxe = $taxe;
    }
    public function setFdp(float $fdp): void
    {
        $this->fdp = $fdp;
    }
    public function setAdresse(int $adresse): void
    {
        $this->adresse = $adresse;
    }

    //STRATEGY : calculLivraisoneffectue un calcul différent en fonction de la sous classe (destination de la livraison)
    abstract function calculLivraison($prix):float;

}
?>
