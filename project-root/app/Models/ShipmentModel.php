<?php

namespace App\Models;

use CodeIgniter\Model;

class ShipmentModel extends Model
{
    protected $table = 'shipment';
    protected $primaryKey = 'order_id';
    protected $allowedFields = ['order_id', 'delivery_status'];

    // Untuk mendapatkan shipment berdasarkan order_id
    public function getShipmentByOrderId($orderId)
    {
        return $this->where('order_id', $orderId)->first();
    }

    // Mengupdate status shipment
    public function updateShipmentStatus($orderId, $status)
    {
        return $this->update($orderId, ['delivery_status' => $status]);
    }
}
