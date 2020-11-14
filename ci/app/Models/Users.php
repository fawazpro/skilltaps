<?php
namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['f_name', 'user_id', 'l_name', 'email', 'phone', 'sex', 'address', 'password', 'paid', 'ref_id', 'level', 'd_lines', 'upgrade_wallet', 'pending_wallet', 'p_wallet', 'c_wallet'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}