<?php
namespace App\Models;

use CodeIgniter\Model;

class Customers extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'user_id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['fname', 'user_id', 'lname', 'email', 'phone', 'sex', 'address', 'password', 'paid', 'ref_id', 'wallet', 'ref1', 'ref2', 'ref3', 'ref4', 'ref5'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}