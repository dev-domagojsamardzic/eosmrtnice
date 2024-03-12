<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Display all companies
     */
    public function index(): View
    {
        return view('admin.companies.index');
    }
}
