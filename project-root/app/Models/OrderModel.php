<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $allowedFields = ['user_id', 'total_amount', 'is_deleted'];

    public function getOrdersWithStatus($userId, $includeDeleted = true)
    {
        $builder    = $this->db->table('orders');
        $builder->join('shipment', 'shipment.order_id = orders.order_id');
        $builder->where('orders.user_id', $userId);

        if (!$includeDeleted) {
            $builder->where('orders.is_deleted', 0); // Pastikan hanya pesanan yang tidak dihapus yang ditampilkan
        }

        return $builder->get()->getResultArray();
    }

}
