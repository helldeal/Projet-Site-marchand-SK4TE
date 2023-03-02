<?php
class PromotionEntity extends CI_Model{
    private int $id;
    private int $promo;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPromo(): int
    {
        return $this->promo;
    }
    
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPromo(int $promo): void
    {
        $this->promo = $promo;
    }
}  