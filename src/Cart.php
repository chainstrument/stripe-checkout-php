<?php 

namespace App;

class Cart
{

    public function __construct()
    {

    }
    
    public function getId()
    {
        return uniqid();
    }

    public function getProduct()
    {
        return [
            ['name' => 'bon pour un telechargement', 'price' => '2999']
        ];
    }



}