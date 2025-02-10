<?php

namespace App\Http\Controllers\dev;

use App\Http\Controllers\Controller;
use App\Models\dev\dev_zerotest;
use Illuminate\Http\Request;

class DevZerotest extends Controller
{
    public function index()
    {
      $pageConfigs = ['myLayout' => 'horizontal'];

      return view('content.dev.zerotest',['pageConfigs'=> $pageConfigs]);
    }
}
