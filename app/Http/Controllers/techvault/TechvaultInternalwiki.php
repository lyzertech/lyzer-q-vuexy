<?php

namespace App\Http\Controllers\techvault;

use App\Http\Controllers\Controller;
use App\Models\techvault\techvault_internalwiki;
use Illuminate\Http\Request;

class TechvaultInternalwiki extends Controller
{

    public function index()
    {
        // Pass the filtered data to the view
        return view('content.digitize.techvault.techvault-intenalwiki'
        // , [
        //   'allData' => $allData,
        //   'selectedDevices' => $selectedDevices,
        //   'pageConfigs' => $pageConfigs
        // ]
      );
    }
}
