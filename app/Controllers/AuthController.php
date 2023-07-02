<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class AuthController extends Controller
{
    public function signin()
    {
        helper(['form']);
        echo view('pages/auth/signin');
    }

    public function signup()
    {
        helper(['form']);
        $data = [];
        echo view('pages/auth/signup', $data);
    }

    public function loginAuth()
    {
        $request = \Config\Services::request();
        $session = session();
        $userModel = new UserModel();
        $email = $request->getVar('email');
        $password = $request->getVar('password');

        $data = $userModel->where('email', $email)->first();

        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $ses_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');

            } else {
                $session->setFlashdata('msg', 'Password is incorrect.');
                return redirect()->to('/signin');
            }
        } else {
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/signin');
        }
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'name'          => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|min_length[4]|max_length[50]|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[4]|max_length[50]',
        ];

        if ($this->validate($rules)) {
            $request = \Config\Services::request();
            $userModel = new UserModel();
            $data = [
                'name'     => $request->getVar('name'),
                'email'    => $request->getVar('email'),
                'password' => password_hash($request->getVar('password'), PASSWORD_DEFAULT)
            ];
            $userModel->save($data);
            return redirect()->to('/signin');
        } else {
            $data['validation'] = $this->validator;
            echo view('signup', $data);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy(); // Destroy the session data
        return redirect()->to('/'); // Redirect to the login page or any other desired page
    }
}
