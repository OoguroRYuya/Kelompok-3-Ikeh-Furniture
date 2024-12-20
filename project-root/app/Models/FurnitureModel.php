<?php

namespace App\Models;

use CodeIgniter\Model;

class FurnitureModel extends Model
{
    protected $table = 'furniture';
    protected $primaryKey = 'furniture_id';
    protected $allowedFields = ['name', 'description', 'price', 'image', 'stock'];
}
