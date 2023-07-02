<?php

namespace App\Controllers;
use Myth\Auth\Authentication\LocalAuthenticator;


class TaskController extends BaseController
{
    private $db;
    public function __construct(){
        require_once APPPATH.'ThirdParty/ssp.php';
        $this->db = db_connect();
    }

    public function index()
    {
        $data['pageTitle'] = 'Task';
        return view('dashboard/task', $data);
    }

    public function store()
    {
        $validation =  \Config\Services::validation();
        $this->validate([
            'task_name' => [
                'label' => 'Task Name',
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} is required',
                    'min_length' => '{field} must be at least 5 characters long'
                ]
            ]
        ]);

        if ($validation->run() == FALSE) {
            $response = [
                'error' => [
                    'task_name' => $validation->getError('task_name')
                ]
            ];
        } else {
            $taskModel = new \App\Models\TaskModel();

             $id = $_SESSION['id'];

            $taskModel->save([
                'task_name' => $this->request->getPost('task_name'),
                'user_id' => $id
            ]);
            $response = [
                'success' => 'Task added successfully'
            ];
        }
        return $this->response->setJSON($response);
    }

 
    public function getAllTask()
    {
        $dbDetails = array(
            "host"=>$this->db->hostname,
            "user"=>$this->db->username,
            "pass"=>$this->db->password,
            "db"=>$this->db->database,
        );

        $table = "tasks";
        $primaryKey = "id";

        $columns = array(
            array(
                "db" => "id",
                "dt" => 0,
            ),
            array(
                "db" => "task_name",
                "dt" => 1,
            ),
            array(
                "db" => "task_status",
                "dt" => 2,
                "formatter" => function($d, $row) {
                    $checkbox = $d == 1 ? "<input type='checkbox' checked disabled>" : "<input type='checkbox' disabled>";
                    return $checkbox;
                }
            ),
            array(
                "db" => "id",
                "dt" => 3,
                "formatter" => function($d, $row) {
                    return "<div class='btn-group'>
                                <button class='btn btn-sm btn-primary' data-id='".$row['id']."' id='updateTaskBtn'>Update</button>
                                <button class='btn btn-sm btn-danger' data-id='".$row['id']."' id='deleteTaskBtn'>Delete</button>
                            </div>";
                }
            ),
        );
        echo json_encode(
            \SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function getTaskInfo()
    {
        $taskModel = new \App\Models\TaskModel();
        $task_id = $this->request->getPost('task_id');
        $info = $taskModel->find($task_id);
        if ($info) {
            $this->response->setHeader('Content-Type', 'application/json');
            echo json_encode(['code' => 1, 'msg' => '', 'results' => $info]);
        } else {
            $this->response->setHeader('Content-Type', 'application/json');
            echo json_encode(['code' => 0, 'msg' => 'No results found', 'results' => null]);
        }
    }

    public function update()
{
    $taskModel = new \App\Models\TaskModel();
    $validation = \Config\Services::validation();
    $tid = $this->request->getVar('tid');

    $this->validate([
        'task_name' => [
            'rules' => 'required|min_length[5]',
            'errors' => [
                'required' => '{field} is required',
                'min_length' => 'Task name must be at least 5 characters long'
            ]
        ]
    ]);

    if ($validation->run() == FALSE) {
        $errors = $validation->getErrors();
        echo json_encode(['code' => 0, 'error' => $errors]);
    } else {
        $data = [
            'task_name' => $this->request->getVar('task_name'),
            'task_status' => $this->request->getVar('task_status'),
        ];
        $query = $taskModel->update($tid, $data);

            if ($query) {
                echo json_encode(['code' => 1, 'msg' => 'Task info has been updated successfully']);
            } else {
                echo json_encode(['code' => 0, 'msg' => 'Something went wrong']);
            }
        }
    }

    public function delete(){
        $taskModel = new \App\Models\TaskModel();
        $task_id = $this->request->getPost('task_id');
        $query = $taskModel->delete($task_id);

        if($query){
            echo json_encode(['code'=>1,'msg'=>'Task deleted Successfully']);
        }else{
            echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
        }
    }


};
