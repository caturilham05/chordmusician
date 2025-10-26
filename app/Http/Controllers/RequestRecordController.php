<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestRecordController extends Controller
{
    public function index()
    {
        return view('requestRecord', [
            'title' => 'Request Record'
        ]);
    }
}
