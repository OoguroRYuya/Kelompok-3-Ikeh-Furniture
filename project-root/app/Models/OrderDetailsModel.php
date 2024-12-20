<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderDetailsModel extends Model
{
    protected $table = 'order_details';
    protected $primaryKey = 'order_details_id';
    protected $allowedFields = ['order_id', 'furniture_id', 'quantity', 'price'];

    public function getOrderDetailsByOrderId($orderId)
    {
        return $this->where('order_id', $orderId)->findAll();
    }
}
