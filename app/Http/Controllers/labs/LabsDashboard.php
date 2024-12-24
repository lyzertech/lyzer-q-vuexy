<?php

namespace App\Http\Controllers\labs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LabsDashboard extends Controller
{
  public function index()
  {
    return view('content.digitize.labs-dashboard');
  }
}
