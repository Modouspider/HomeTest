<?php
namespace App\Entity;

use Exception;

class Product
{
    const FOOD_PRODUCT = 'food';
    private $name;
    private $type;
    private $price;
    public function __construct($name, $type, $price)
    {
        $this->name = $name;
        $this->type = $type;
        $this->price = $price;
    }
    public function computeTVA()
    {
       if (self::FOOD_PRODUCT == $this->type) {
          return $this->price * 1;
       }
       return $this->price * 2;
    }

    public function sendException() {
        throw new \Exception('Erreur');
    }
}