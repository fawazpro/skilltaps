<?php
namespace App\Models;

use CodeIgniter\Model;

class Orders extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'order_id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'orders', 'status','type','notif'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}