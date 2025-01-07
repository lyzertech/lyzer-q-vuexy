<?php

namespace App\Http\Controllers\labs;

use App\Http\Controllers\Controller;
use App\Models\labs\labs_label;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LabsLabel extends Controller
{
    public function index()
    {
        return view('content.digitize.labs.labs-label');
    }
    public function label_data()
    {
        $label = labs_label::all();

        // dd($label);

        return DataTables::of($label)
            ->editColumn('created_at', function ($label) {
                return $label->created_at->format('Y-m-d H:i');
            })
            ->addColumn('action', function ($label) {
                // Define the action URLs for View, Edit, and Delete
                $showUrl = route('labs-label-view', $label->created_at);
                $deleteUrl = route('labs-label-destroy', $label->id_label);

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
    public function create(Request $request)
    {
        // dd($request->all());
        // Validate the input data
        $request->validate([
            'brand' => 'required',
            'customer' => 'required',
            'PO' => 'required',
            'type.*' => 'required',  // Using the * syntax to validate each array entry
            'scale.*' => 'required',
            'input.*' => 'required',
            'qty.*' => 'required',
        ]);

        // Loop through each set of inputs
        foreach ($request['type'] as $index => $type) {
            // Get the quantity for the current index
            $quantity = $request['qty'][$index];

            // Create multiple entries based on the quantity
            for ($i = 0; $i < $quantity; $i++) {
                labs_label::create([
                    'brand' => $request['brand'],
                    'customer' => $request['customer'],
                    'PO' => $request['PO'],
                    'type' => $type,
                    'scale' => $request['scale'][$index],
                    'input' => $request['input'][$index],
                    'qty' => 1, // Set qty to 1 for each individual entry
                ]);
            }
        }

        return redirect('/labs/label')->with('success', 'Form submitted successfully!');
    }
    public function label_view($created_at)
    {
        // Fetch all records with the given PO
        $labs_label = labs_label::where('created_at', $created_at)->get();

        // dd($labs_label);

        // Pass the records to the view
        return view('content.digitize.labs.labs-label-view', compact('labs_label'));
    }
}
