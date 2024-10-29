<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name'];

    
    public function FindCategories()
    {
        $sql = "SELECT * FROM " . $this->table;
        $query = $this->db->query($sql);
        return $query->getResultArray();
    }
}
