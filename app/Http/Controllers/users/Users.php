<?php

namespace App\Http\Controllers\users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class Users extends Controller
{
    public function index()
    {
        return view('content.digitize.users');
    }
    public function users_data()
    {
        $users = User::all();

        // dd($users);

        return DataTables::of($users)
            ->editColumn('created_at', function ($users) {
                return $users->created_at->format('Y-m-d H:i');
            })
            ->addColumn('action', function ($users) {
                // Define the action URLs for View, Edit, and Delete
                $showUrl = route('users-view', $users->created_at);
                $deleteUrl = route('users-destroy', $users->id);

                // Return the action buttons HTML
                return '
                <div class="d-inline-block">
                    <a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="ti ti-dots-vertical ti-md"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end m-0">
                        <li><a href="' . $showUrl . '" class="dropdown-item">Details</a></li>
                        <div class="dropdown-divider"></div>
                        <li>
                        <a href="' . $deleteUrl . '" class="dropdown-item text-danger delete-record">Delete</a>
                        </li>
                    </ul>
                </div>
                <a href="' . $showUrl . '" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit">
                    <i class="ti ti-eye ti-md"></i>
                </a>
            ';
            })
            ->rawColumns(['action']) // Allow raw HTML in the action column
            ->make(true);
    }
}
