<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'question', 'answer', 'category_id'];

    public function getAllQuestions($questionperpage,$page,$search = null, $category_id = null)
    {
        $offset=($page-1)* $questionperpage;
        $sql = "SELECT * FROM questions";
        $conditions = [];
        $params = [];
        if ($search) {
            $conditions[] = "title LIKE ?";
            $params[] = '%' . $search . '%'; 
        }
        if ($category_id) {
            $conditions[] = "category_id = ?";
            $params[] = $category_id;
        }
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }
        $sql .= " LIMIT $questionperpage OFFSET $offset";

        $query = $this->db->query($sql, $params);
        return $query->getResultArray();
    }

    public function InsertQuestion($data)
    {
        $sql = "INSERT INTO " . $this->table . " (title, question, answer, category_id) VALUES (?, ?, ?, ?)";
        return $this->db->query($sql, [
            $data['title'],
            $data['question'],
            $data['answer'],
            $data['category_id']
        ]);
    }
    
    public function updateQuestion($id, $data)
    {
        $sql = "UPDATE " . $this->table . " SET title = ?, question = ?, answer = ?, category_id = ? WHERE id = ?";
    
        return $this->db->query($sql, [
            $data['title'],
            $data['question'],
            $data['answer'],
            $data['category_id'],
            $id
        ]);
    }
    
    public function deleteQuestion($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function findById($id){
        $sql="Select  * from $this->table where id = ?";
        return $this->db->query($sql, [$id])->getRowArray();

    }

    public function getTotalQuestion($search=null,$category_id=null){
        if($search){
           $sql="Select count(*) as total  from $this->table where title like % $search% ";
        }
        elseif($category_id){
            $sql="Select count(*) as total from $this->table where category_id ==  $category_id ";

        }
        $sql="Select count(*) as total from $this->table";

        $query=$this->db->query($sql)->getRow();
        return  $query->total;




    }

    
}
