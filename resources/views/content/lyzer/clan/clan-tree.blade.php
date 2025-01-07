@extends('layouts/layoutMaster')

@section('title', 'Clan Tree')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite([
        //datatables
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
        // Buttons and Pickers
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
        // Additional Features
        'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite([
        // datatables
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/flatpickr/flatpickr.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
    ])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite([
        // datatables
        'resources/assets/js/tables-datatables-customer.js',
    ])
@endsection

@section('content')

    {{-- Datatables --}}
    <!-- Optional: jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- DataTables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.js"></script>
    <!-- Optional: Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    {{-- ECharts --}}
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>


    <h1>Family Chart</h1>

    @php
        $displayedMembers = collect(); // Collection to track displayed members
    @endphp

    @foreach ($family as $member)
        @if (!$displayedMembers->contains($member->id_tree))
            {{-- Check if the member has children to classify as Parent --}}
            @if ($member->children->isNotEmpty())
                @php
                    $displayedMembers->push($member->id_tree); // Mark parent as displayed
                @endphp
                <div>
                    <div class="col-xxl-4 col-lg-6">
                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between">
                                <div class="card-title mb-0">
                                    {{-- <h5 class="mb-1">Orders by Countries</h5> --}}
                                    <strong>Parent - {{ $member->name }} ({{ $member->gender }})</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($member->spouse)
                        <span> - Spouse: {{ $member->spouse->name }}</span>
                    @endif
                </div>
                <ul>
                    {{-- Display children under the parent --}}
                    @foreach ($member->children as $child)
                        @if (!$displayedMembers->contains($child->id_tree))
                            @php
                                $displayedMembers->push($child->id_tree); // Mark child as displayed
                            @endphp
                            <li>
                                <strong>Child - {{ $child->name }} ({{ $child->gender }})</strong>
                                @if ($child->spouse)
                                    <span> - Spouse: {{ $child->spouse->name }}</span>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        @endif
    @endforeach





    {{-- <form method="POST" action="{{ route('family.store') }}">
        @csrf
        <input type="text" name="name" placeholder="Name" required>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <input type="number" name="parent_id" placeholder="Parent ID">
        <input type="number" name="spouse_id" placeholder="Spouse ID">
        <button type="submit">Add Member</button>
    </form> --}}

@endsection
