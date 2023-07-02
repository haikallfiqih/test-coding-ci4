<?php 
namespace App\Models;  
use CodeIgniter\Model;
  
class TaskModel extends Model{
    protected $table = 'tasks';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'task_name',
        'user_id',
        'task_status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}