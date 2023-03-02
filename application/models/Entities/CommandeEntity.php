<?php
class CommandeEntity extends CI_Model{
    private int $id;
    private string $login;
    private int $refprod;
    private int $quantity;
    private float $price;
    private string $time;

    public function getId(): int
    {
        return $this->id;
    }
    /**
    * @return int
    */
    public function getRefprod(): int
    {
        return $this->refprod;
    }
    /**
    * @return string
    */
    public function getLogin(): string
    {
        return $this->login;
    }
    /**
    * @return float
    */
    public function getPrice(): float
    {
        return $this->price;
    }
    /**
    * @return int
    */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    /**
    * @param int $id
    */
    public function getTime():string
    {
        return $this->time;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    /**
    * @param int $refprod
    */
    public function setRefprod(int $refprod): void
    {
        $this->refprod = $refprod;
    }
     /**
    * @param string $refprod
    */
    public function setLogin(string $login): void
    {
        $this->login = $login;
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
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function setTime(string $time): void
    {
        $this->time = $time;
    }

}