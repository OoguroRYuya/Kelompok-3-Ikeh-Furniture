<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payment';
    protected $allowedFields = ['order_id', 'amount', 'payment_method'];
}
