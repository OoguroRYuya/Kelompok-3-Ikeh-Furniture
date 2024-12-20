<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
    protected $allowedFields = ['user_id', 'furniture_id', 'quantity'];

    public function getCartItems($userId)
{
    return $this->select('cart.*, furniture.name, furniture.price, furniture.image, furniture.stock')
                ->join('furniture', 'furniture.furniture_id = cart.furniture_id')
                ->where('cart.user_id', $userId)
                ->findAll();    
}


}
