<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin Test',
                'email' => 'admin@admin.com',
                'password' => password_hash('adminpassword', PASSWORD_DEFAULT),
            ],
        ];

        $userModel = new UserModel();
        $userModel->insertBatch($users);
    }
}
