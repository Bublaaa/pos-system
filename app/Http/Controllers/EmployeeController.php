<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('../layouts/contents/dashboard');
    }
    public function report()
    {
        return view('../layouts/contents/attandanceReport');
    }
    public function salary()
    {
        return view('../layouts/contents/salary');
    }
    public function attendance()
    {
        return view('../layouts/contents/employeeAttendance');
    }
}