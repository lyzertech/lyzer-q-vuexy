<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\school\school_attendance;
use Illuminate\Http\Request;

class SchoolAttendance extends Controller
{
    public function index()
    {
        // $family = clan_tree::with(['children', 'spouse'])->get();
        // dd($family);
        return view('content.school.student.list'
            // , compact('family')
        );
    }
}
