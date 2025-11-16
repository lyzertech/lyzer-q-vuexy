<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\school\school_student;
use Illuminate\Http\Request;

class SchoolStudent extends Controller
{
    public function index()
    {
        // $family = clan_tree::with(['children', 'spouse'])->get();
        // dd($family);
        return view('content.school.student.list'
            // , compact('family')
        );
    }

    public function getByClass($class)
    {
        return school_student::where('class', $class)->get();
    }
}
