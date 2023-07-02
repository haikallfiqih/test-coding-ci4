<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        $data['pageTitle'] = 'Home';
        return view('dashboard/home', $data);
    }
}
