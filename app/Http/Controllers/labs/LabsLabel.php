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
        // $lastId = labs_label::max('id_label') ?? 0; // If no data, start from 0
        // dd($lastId);
        return view('content.digitize.labs.labs-label');
    }
    public function label_data(Request $request)
    {
      $query = labs_label::select('*')
          ->whereIn('id_label', function ($sub) {
              $sub->selectRaw('MAX(id_label)')
                  ->from('labs_label')
                  ->groupBy('PO');
          });

      // ✅ Apply filters
      if ($request->has('all')) {
          // no filter applied (show all)
      } elseif ($request->filter === '1m') {
          $query->where('created_at', '>=', now()->subMonth());
      } elseif ($request->filter === '3m') {
          $query->where('created_at', '>=', now()->subMonths(3));
      } elseif ($request->filter === 'year') {
          $query->whereYear('created_at', now()->year);
      } else {
          // default: 1 month
          $query->where('created_at', '>=', now()->subMonth());
      }

      $label = $query->get();

        return DataTables::of($label)
            ->editColumn('created_at', function ($label) {
                return $label->created_at->format('Y-m-d H:i');
            })
            ->addColumn('action', function ($label) {
                // Define the action URLs for View, Edit, and Delete
                $showUrl = route('labs-label-view', $label->created_at->format('Y-m-d H:i'));
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
        // Get the starting ID from the form input (SN)
        $currentId = $request->SN ?? (labs_label::max('id_label') + 1);

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

        // Initialize line counter
        $lineNumber = 1;

        // Loop through each set of inputs
        foreach ($request['type'] as $index => $type) {
            // Get the quantity for the current index
            $quantity = $request['qty'][$index];

            // Check if the customer is "Schneider Indonesia"
              if ($request['customer'] === "Schneider Indonesia") {
                // Format PO with line number (padded with leading zeros)
                $formattedPO = $request['PO'] . " Line " . str_pad($lineNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Keep PO as is for other customers
                $formattedPO = $request['PO'];
            }

            // Create multiple entries based on the quantity
            for ($i = 0; $i < $quantity; $i++) {
                labs_label::create([
                    'id_label' => $currentId, // Assign the ID
                    'brand' => $request['brand'],
                    'customer' => $request['customer'],
                    'PO' => $formattedPO,
                    'type' => $type,
                    'scale' => $request['scale'][$index],
                    'input' => $request['input'][$index],
                    'qty' => 1, // Set qty to 1 for each individual entry
                ]);
                // Always increment ID for the next entry
                $currentId += 1;
            }
            // Move to the next line number after processing the current batch (only for Schneider Indonesia)
              if ($request['customer'] === "Schneider Indonesia") {
                $lineNumber += 1;
            }
        }

        return redirect('/labs/label')->with('success', 'Form submitted successfully!');
    }
    public function label_view($created_at)
    {
        // Convert string to Carbon instance
        $created_at = Carbon::parse($created_at)->format('Y-m-d H:i');

        // Fetch all records with the given timestamp
        $labs_label = labs_label::whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') = ?", [$created_at])->get();

        return view('content.digitize.labs.labs-label-view', compact('labs_label'));
    }
}
