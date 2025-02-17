<?php

namespace App\Http\Controllers\shield;

use App\Http\Controllers\Controller;
use App\Models\shield\shield_insight;
use Illuminate\Http\Request;

class ShieldInsight extends Controller
{
    public function index()
    {
        $pageConfigs = ['myLayout' => 'horizontal'];

        return view('content.lyzer.shield.project-insight', ['pageConfigs' => $pageConfigs]);
    }
}
