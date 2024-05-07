<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{

    public function __construct()
    {
        //$this->authorizeResource(Service::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.services.index');
    }
}
