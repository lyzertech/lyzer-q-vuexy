<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Account extends Controller
{
  public function index()
  {
    return view('content.digitize.account');
  }
}
