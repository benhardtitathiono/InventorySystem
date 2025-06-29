<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        // Logic to retrieve and display employee data
        return view('employee.index');
    }
}
