@extends('layouts/layoutMaster')

@section('title', 'Kanban - Apps')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/jkanban/jkanban.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/quill/typography.scss', 'resources/assets/vendor/libs/quill/katex.scss', 'resources/assets/vendor/libs/quill/editor.scss'])
@endsection

@section('page-style')
    @vite('resources/assets/vendor/scss/pages/app-kanban.scss')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/jkanban/jkanban.js', 'resources/assets/vendor/libs/quill/katex.js', 'resources/assets/vendor/libs/quill/quill.js'])
@endsection

@section('page-script')
    {{-- @vite('resources/assets/js/app-kanban.js') --}}
@endsection

@section('content')
    <div class="app-kanban">

        <!-- Kanban Wrapper -->
        {{-- <div class="kanban-wrapper"></div> --}}
        <div class="kanban-wrapper">
            <div class="kanban-container" style="width: 822px;">
                <div class="kanban-board" data-id="board-Pipeline" data-order="1" style="width: 250px; margin: 0 12px;">
                    <header class="kanban-board-header">
                        <div class="kanban-title-board">Pipeline</div>
                        <div class="dropdown">
                            <i class="dropdown-toggle ti ti-dots-vertical cursor-pointer" data-bs-toggle="dropdown"></i>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item delete-board" href="#"><i
                                        class="ti ti-trash ti-xs me-1"></i>Delete</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-edit ti-xs me-1"></i>Rename</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-archive ti-xs me-1"></i>Archive</a>
                            </div>
                        </div>
                        <button class="kanban-title-button btn">+ Add New Item</button>
                    </header>
                    <main class="kanban-drag">
                        <!-- Kanban Item Template -->
                        <div class="kanban-item" data-bs-toggle="modal" data-bs-target="#exLargeModal">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="badge bg-label-secondary">Leads / Prospects</div>
                            </div>
                            <span class="kanban-text">PLN ADS Cibatu</span>
                            <span class="kanban-text">
                                {{-- • PT. Customer01 Amptron <br> • PT. Customer02 Amptron --}}
                            </span>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex">
                                    <span class="d-flex align-items-center me-2"><i
                                            class="ti ti-paperclip me-1"></i>Q.050_DAV</span>
                                </div>
                                <div class="avatar-group d-flex align-items-center">
                                    <div class="badge bg-label-danger">Tender</div>
                                </div>
                            </div>
                        </div>

                        <div class="kanban-item" data-eid="Pipeline-2" data-comments="8" data-badge-text="Code Review"
                            data-badge="danger" data-attachments="2" data-due-date="10 April" data-assigned="3.png,8.png"
                            data-members="Helena,Iris">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="badge bg-label-info">Qualified / In Discussion</div>
                                <div class="dropdown kanban-tasks-item-dropdown">
                                    <i class="dropdown-toggle ti ti-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Copy task link</a>
                                        <a class="dropdown-item" href="#">Duplicate task</a>
                                        <a class="dropdown-item delete-task" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="kanban-text">PT. Customer Amptron</span>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex">
                                    <span class="d-flex align-items-center me-2"><i
                                            class="ti ti-paperclip me-1"></i>2</span>
                                    <span class="d-flex align-items-center ms-2"><i
                                            class="ti ti-message-2 me-1"></i>8</span>
                                </div>
                                <div class="avatar-group d-flex align-items-center">
                                    <img src="http://127.0.0.1:8000/assets/img/avatars/3.png" alt="Helena"
                                        class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" title="Helena">
                                    <img src="http://127.0.0.1:8000/assets/img/avatars/8.png" alt="Iris"
                                        class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" title="Iris">
                                </div>
                            </div>
                        </div>
                    </main>
                </div>

                <div class="kanban-board" data-id="board-Proposal-&-Negotiation" data-order="2"
                    style="width: 250px; margin: 0 12px;">
                    <header class="kanban-board-header">
                        <div class="kanban-title-board">Proposal & Negotiation</div>
                        <div class="dropdown">
                            <i class="dropdown-toggle ti ti-dots-vertical cursor-pointer" data-bs-toggle="dropdown"></i>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item delete-board" href="#"><i class="ti ti-trash ti-xs"></i>
                                    Delete</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-edit ti-xs"></i> Rename</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-archive ti-xs"></i> Archive</a>
                            </div>
                        </div>
                        <button class="kanban-title-button btn">+ Add New Item</button>
                    </header>
                    <main class="kanban-drag">

                        <!-- Task 1 -->
                        <div class="kanban-item" data-eid="Proposal-&-Negotiation-1" data-comments="17" data-badge="info"
                            data-due-date="8 April" data-attachments="8" data-assigned="11.png,6.png">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="badge bg-label-info">Proposal Sent</div>
                                <div class="dropdown kanban-tasks-item-dropdown">
                                    <i class="dropdown-toggle ti ti-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Copy task link</a>
                                        <a class="dropdown-item" href="#">Duplicate task</a>
                                        <a class="dropdown-item delete-task" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="kanban-text">PT. Customer Amptron</span>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex">
                                    <span class="d-flex align-items-center me-2"><i
                                            class="ti ti-paperclip me-1"></i>8</span>
                                    <span class="d-flex align-items-center ms-2"><i
                                            class="ti ti-message-2 me-1"></i>17</span>
                                </div>
                                <div class="avatar-group">
                                    <img src="{{ asset('assets/img/avatars/11.png') }}" alt="Laurel"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Harley"
                                        class="avatar avatar-xs rounded-circle">
                                </div>
                            </div>
                        </div>

                        <!-- Task 2 -->
                        <div class="kanban-item" data-eid="Proposal-&-Negotiation-2" data-comments="18"
                            data-badge="warning" data-due-date="2 April" data-attachments="10">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="badge bg-label-warning">Negotiation / In Progress</div>
                                <div class="dropdown kanban-tasks-item-dropdown">
                                    <i class="dropdown-toggle ti ti-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Copy task link</a>
                                        <a class="dropdown-item" href="#">Duplicate task</a>
                                        <a class="dropdown-item delete-task" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="kanban-text">PT. Customer Amptron</span>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex">
                                    <span class="d-flex align-items-center me-2"><i
                                            class="ti ti-paperclip me-1"></i>10</span>
                                    <span class="d-flex align-items-center ms-2"><i
                                            class="ti ti-message-2 me-1"></i>18</span>
                                </div>
                                <div class="avatar-group">
                                    <img src="{{ asset('assets/img/avatars/9.png') }}" alt="Dianna"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Jordan"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Vinnie"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/12.png') }}" alt="Lasa"
                                        class="avatar avatar-xs rounded-circle">
                                </div>
                            </div>
                        </div>

                    </main>
                </div>

                <div class="kanban-board" data-id="board-Closed-Won" data-order="3"
                    style="width: 250px; margin: 0 12px;">
                    <header class="kanban-board-header">
                        <div class="kanban-title-board">Closed - Won</div>
                        <div class="dropdown">
                            <i class="dropdown-toggle ti ti-dots-vertical cursor-pointer" data-bs-toggle="dropdown"></i>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item delete-board" href="#"><i class="ti ti-trash ti-xs"></i>
                                    Delete</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-edit ti-xs"></i> Rename</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-archive ti-xs"></i> Archive</a>
                            </div>
                        </div>
                        <button class="kanban-title-button btn">+ Add New Item</button>
                    </header>
                    <main class="kanban-drag">

                        <!-- Task 1 -->
                        <div class="kanban-item" data-eid="Closed-Won-1" data-comments="17" data-badge="info"
                            data-due-date="8 April" data-attachments="8" data-assigned="11.png,6.png">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="badge bg-label-success">Successfully secured deals</div>
                                <div class="dropdown kanban-tasks-item-dropdown">
                                    <i class="dropdown-toggle ti ti-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Copy task link</a>
                                        <a class="dropdown-item" href="#">Duplicate task</a>
                                        <a class="dropdown-item delete-task" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="kanban-text">PT. Customer Amptron</span>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex">
                                    <span class="d-flex align-items-center me-2"><i
                                            class="ti ti-paperclip me-1"></i>8</span>
                                    <span class="d-flex align-items-center ms-2"><i
                                            class="ti ti-message-2 me-1"></i>17</span>
                                </div>
                                <div class="avatar-group">
                                    <img src="{{ asset('assets/img/avatars/11.png') }}" alt="Laurel"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Harley"
                                        class="avatar avatar-xs rounded-circle">
                                </div>
                            </div>
                        </div>

                    </main>
                </div>

                <div class="kanban-board" data-id="board-Closed-Lost/OnHold" data-order="4"
                    style="width: 250px; margin: 0 12px;">
                    <header class="kanban-board-header">
                        <div class="kanban-title-board">Closed - Lost / On Hold</div>
                        <div class="dropdown">
                            <i class="dropdown-toggle ti ti-dots-vertical cursor-pointer" data-bs-toggle="dropdown"></i>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item delete-board" href="#"><i class="ti ti-trash ti-xs"></i>
                                    Delete</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-edit ti-xs"></i> Rename</a>
                                <a class="dropdown-item" href="#"><i class="ti ti-archive ti-xs"></i> Archive</a>
                            </div>
                        </div>
                        <button class="kanban-title-button btn">+ Add New Item</button>
                    </header>
                    <main class="kanban-drag">

                        <!-- Task 1 -->
                        <div class="kanban-item" data-eid="Closed-Lost/OnHold-1" data-comments="17" data-badge="info"
                            data-due-date="8 April" data-attachments="8" data-assigned="11.png,6.png">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="badge bg-label-danger">Lost Deals</div>
                                <div class="dropdown kanban-tasks-item-dropdown">
                                    <i class="dropdown-toggle ti ti-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Copy task link</a>
                                        <a class="dropdown-item" href="#">Duplicate task</a>
                                        <a class="dropdown-item delete-task" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="kanban-text">PT. Customer Amptron</span>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex">
                                    <span class="d-flex align-items-center me-2"><i
                                            class="ti ti-paperclip me-1"></i>8</span>
                                    <span class="d-flex align-items-center ms-2"><i
                                            class="ti ti-message-2 me-1"></i>17</span>
                                </div>
                                <div class="avatar-group">
                                    <img src="{{ asset('assets/img/avatars/11.png') }}" alt="Laurel"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/6.png') }}" alt="Harley"
                                        class="avatar avatar-xs rounded-circle">
                                </div>
                            </div>
                        </div>

                        <!-- Task 2 -->
                        <div class="kanban-item" data-eid="Closed-Lost/OnHold-2" data-comments="18" data-badge="warning"
                            data-due-date="2 April" data-attachments="10">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="badge bg-label-warning">On Hold / Deferred</div>
                                <div class="dropdown kanban-tasks-item-dropdown">
                                    <i class="dropdown-toggle ti ti-dots-vertical" data-bs-toggle="dropdown"></i>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="#">Copy task link</a>
                                        <a class="dropdown-item" href="#">Duplicate task</a>
                                        <a class="dropdown-item delete-task" href="#">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <span class="kanban-text">PT. Customer Amptron</span>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex">
                                    <span class="d-flex align-items-center me-2"><i
                                            class="ti ti-paperclip me-1"></i>10</span>
                                    <span class="d-flex align-items-center ms-2"><i
                                            class="ti ti-message-2 me-1"></i>18</span>
                                </div>
                                <div class="avatar-group">
                                    <img src="{{ asset('assets/img/avatars/9.png') }}" alt="Dianna"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Jordan"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Vinnie"
                                        class="avatar avatar-xs rounded-circle">
                                    <img src="{{ asset('assets/img/avatars/12.png') }}" alt="Lasa"
                                        class="avatar avatar-xs rounded-circle">
                                </div>
                            </div>
                        </div>

                    </main>
                </div>
            </div>
            {{-- <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div> --}}
        </div>

        <!-- Edit Project -->
        <div class="offcanvas offcanvas-end" id="editKanbanOffcanvas">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Edit Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-0">
                <div class="tab-content p-0">
                    <!-- Update item/tasks -->
                    <div class="tab-pane fade show active mt-4" id="tab-update" role="tabpanel">
                        <form>
                            <div class="mb-5">
                                <label class="form-label" for="projectName">Project Name</label>
                                <input type="text" id="projectName" class="form-control"
                                    placeholder="Enter Project Name" />
                            </div>
                            <div class="mb-5">
                                <label class="switch switch-primary">
                                    <input type="checkbox" class="switch-input" checked="">
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>
                                    <span class="switch-label">Tender</span>
                                </label>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="label">Project Status</label>
                                <select class="select2 select2-label form-select" id="label">
                                    <option value="UX">UX</option>
                                    <option data-color="bg-label-warning" value="Images">
                                        Images
                                    </option>
                                    <option data-color="bg-label-info" value="Info">Info</option>
                                    <option data-color="bg-label-danger" value="Code Review">
                                        Code Review
                                    </option>
                                    <option data-color="bg-label-secondary" value="App">
                                        App
                                    </option>
                                    <option data-color="bg-label-primary" value="Charts & Maps">
                                        Charts & Maps
                                    </option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="label">Marketing Status</label>
                                <select class="select2 select2-label form-select" id="label">
                                    <option data-color="bg-label-success" value="UX">UX</option>
                                    <option data-color="bg-label-warning" value="Images">
                                        Images
                                    </option>
                                    <option data-color="bg-label-info" value="Info">Info</option>
                                    <option data-color="bg-label-danger" value="Code Review">
                                        Code Review
                                    </option>
                                    <option data-color="bg-label-secondary" value="App">
                                        App
                                    </option>
                                    <option data-color="bg-label-primary" value="Charts & Maps">
                                        Charts & Maps
                                    </option>
                                </select>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="projectName">Customer</label>
                                <input type="text" id="projectName" class="form-control"
                                    placeholder="Enter Project Name" />
                                <div id="defaultFormControlHelp" class="form-text">for multiple Customer, seperate by
                                    giving ( , )</div>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="projectName">Quotation Reference</label>
                                <input type="text" id="projectName" class="form-control"
                                    placeholder="Enter Project Name" />
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="projectName">Comment</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div>
                                <div class="d-flex flex-wrap">
                                    <button type="button" class="btn btn-primary me-4" data-bs-dismiss="offcanvas">
                                        Update
                                    </button>
                                    <button type="button" class="btn btn-label-danger" data-bs-dismiss="offcanvas">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel4">Edit Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="projectName">Project Name</label>
                                        <input type="text" id="projectName" class="form-control"
                                            placeholder="Enter Project Name" />
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-2">
                                                <label class="switch switch-primary">
                                                    <input type="checkbox" class="switch-input" checked="">
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on">
                                                            <i class="ti ti-check"></i>
                                                        </span>
                                                        <span class="switch-off">
                                                            <i class="ti ti-x"></i>
                                                        </span>
                                                    </span>
                                                    <span class="switch-label">Tender</span>
                                                </label>
                                            </div>
                                            <div class="mb-3">
                                                <label class="switch switch-primary">
                                                    <input type="checkbox" class="switch-input" checked="">
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on">
                                                            <i class="ti ti-check"></i>
                                                        </span>
                                                        <span class="switch-off">
                                                            <i class="ti ti-x"></i>
                                                        </span>
                                                    </span>
                                                    <span class="switch-label">Tender</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-5">
                                                <label class="form-label" for="quotReff">Quotation Reference</label>
                                                <input type="text" id="quotReff" class="form-control"
                                                    placeholder="Enter Quotation Reference" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="projectName">Customer | Sales</label>
                                    <div class="input-group">
                                        <select class="select2 select2-label form-select" id="label">
                                            <option value="Pipeline">Pipeline</option>
                                        </select>
                                        <select class="select2 select2-label form-select" id="label">
                                            <option value="Sales">Sales</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <select class="select2 select2-label form-select" id="label">
                                            <option value="Pipeline">Pipeline</option>
                                        </select>
                                        <select class="select2 select2-label form-select" id="label">
                                            <option value="Sales">Sales</option>
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <select class="select2 select2-label form-select" id="label">
                                            <option value="Pipeline">Pipeline</option>
                                        </select>
                                        <select class="select2 select2-label form-select" id="label">
                                            <option value="Sales">Sales</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="label">Project Status</label>
                                    <select class="select2 select2-label form-select" id="label">
                                        <option value="Pipeline">Pipeline</option>
                                        <option value="Proposal & Negotiation">
                                            Proposal & Negotiation
                                        </option>
                                        <option value="Closed - Won">Closed - Won</option>
                                        <option value="Closed - Lost">
                                            Closed - Lost
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="label">Marketing Status</label>
                                    <select class="select2 select2-label form-select" id="label">
                                        <option value="Leads / Prospects">
                                            Leads / Prospects
                                        </option>
                                        <option value="Qualified / In Discussion">
                                            Qualified / In Discussion
                                        </option>
                                        <option value="Proposal Sent">
                                            Proposal Sent</option>
                                        <option value="Negotiation / In Progress">
                                            Negotiation / In Progress
                                        </option>
                                        <option value="Successfully secured deals">
                                            Successfully secured deals
                                        </option>
                                        <option value="Lost Deals">
                                            Lost Deals
                                        </option>
                                        <option value="On Hold / Deferred">
                                            On Hold / Deferred
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label" for="label">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">IDR</span>
                                        <input type="number" class="form-control" placeholder="Amount"
                                            aria-label="Amount (to the nearest dollar)">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="mb-3">
                                        <label class="form-label" for="projectName">Items</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="projectName">Competitor</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="projectName">Comment</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
