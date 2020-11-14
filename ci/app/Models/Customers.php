<?php
namespace App\Models;

use CodeIgniter\Model;

class Customers extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'user_id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['fname', 'user_id', 'lname', 'email', 'phone', 'sex', 'address', 'password', 'paid','bank','acc_name','acc_num','ref_id', 'c_wallet','p_wallet','clearance','tranx'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}