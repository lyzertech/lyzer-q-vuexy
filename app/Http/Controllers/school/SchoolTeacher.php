<?php

namespace App\Http\Controllers\school;

use App\Http\Controllers\Controller;
use App\Models\school\school_teacher;
use Illuminate\Http\Request;

class SchoolTeacher extends Controller
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
        if ($class === 'All') {
            return school_teacher::all();
        }

        return school_teacher::where('class', $class)->get();

    }
}
