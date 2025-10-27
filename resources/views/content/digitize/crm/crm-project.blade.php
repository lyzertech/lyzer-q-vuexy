@extends('layouts/layoutMaster')

@section('title', 'Project')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss', 'resources/assets/vendor/libs/jkanban/jkanban.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/quill/typography.scss', 'resources/assets/vendor/libs/quill/katex.scss', 'resources/assets/vendor/libs/quill/editor.scss'])
    {{-- @vite('resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss') --}}
@endsection

@section('page-style')
    @vite('resources/assets/vendor/scss/pages/app-kanban.scss')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/jkanban/jkanban.js', 'resources/assets/vendor/libs/quill/katex.js', 'resources/assets/vendor/libs/quill/quill.js'])
    {{-- @vite('resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') --}}
@endsection

@section('page-script')
    {{-- @vite('resources/assets/js/app-kanban.js') --}}
    @vite('resources/assets/js/extended-ui-perfect-scrollbar.js')
@endsection

@section('content')
    <div class="app-kanban">

        <!-- Kanban Wrapper -->
        {{-- <div class="kanban-wrapper"></div> --}}
        <div class="kanban-wrapper">
            <div class="kanban-container">
                <div class="kanban-board" data-id="board-Pipeline" data-order="1"
                    style="width: 250px; margin: 0 12px;">
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
                            <div class="col-8">
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
                                              <option value="Customer">A</option>
                                              <option value="Customer">B</option>
                                              <option value="Customer">V</option>
                                              <option value="Customer">D</option>
                                              <option value="Customer">R</option>
                                              <option value="Customer">T</option>
                                              <option value="Customer">Y</option>
                                              <option value="Customer">N</option>
                                              <option value="Customer">Q</option>
                                              <option value="Customer">S</option>
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
                                  <div class="col-6">
                                      <div class="mb-3">
                                          <label class="form-label" for="projectName">Items</label>
                                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                      </div>
                                  </div>
                                  <div class="col-6">
                                      <div class="mb-3">
                                          <label class="form-label" for="projectName">Competitor</label>
                                          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="projectName">Comment</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="14 Oct 25 - Kirim Quotation"></textarea>
                                </div>
                              </div>
                            </div>
                            {{-- <div class="col-1">
                              <div class="divider divider-vertical">
                              </div>
                            </div> --}}
                            {{-- <div class="col-4">
                              <div class="col-xxl-12 order-2">
                                <div class="card overflow-hidden h-100" style="height: 300px;">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title m-0 me-2 pt-1 mb-2 d-flex align-items-center"><i
                                                class="ti ti-list-details me-3"></i> Activity Timeline</h5>
                                    </div>
                                    <div class="card-body" id="vertical-example">
                                        <ul class="timeline mb-0">
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-primary"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">12 Invoices have been paid</h6>
                                                        <small class="text-muted">12 min ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        Invoices have been paid to the company
                                                    </p>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <div class="badge bg-lighter rounded-3">
                                                            <img src="{{ asset('assets/img/icons/misc/pdf.png') }}" alt="img"
                                                                width="15" class="me-2">
                                                            <span class="h6 mb-0 text-body">invoices.pdf</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-success"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Client Meeting</h6>
                                                        <small class="text-muted">45 min ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        Project meeting with john @10:15am
                                                    </p>
                                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                                        <div class="d-flex flex-wrap align-items-center">
                                                            <div class="avatar avatar-sm me-2">
                                                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"
                                                                    class="rounded-circle" />
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                                                                <small>CEO of {{ config('variables.creatorName') }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Create a new project for client</h6>
                                                        <small class="text-muted">2 Day Ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        6 team members in a project
                                                    </p>
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-0">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <ul
                                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Vinnie Mostowy"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Julee Rossignol"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li class="avatar">
                                                                        <span class="avatar-initial rounded-circle pull-up text-heading"
                                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                            title="3 more">+3</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Create a new project for client</h6>
                                                        <small class="text-muted">2 Day Ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        6 team members in a project
                                                    </p>
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-0">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <ul
                                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Vinnie Mostowy"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Julee Rossignol"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li class="avatar">
                                                                        <span class="avatar-initial rounded-circle pull-up text-heading"
                                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                            title="3 more">+3</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Create a new project for client</h6>
                                                        <small class="text-muted">2 Day Ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        6 team members in a project
                                                    </p>
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-0">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <ul
                                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Vinnie Mostowy"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Julee Rossignol"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li class="avatar">
                                                                        <span class="avatar-initial rounded-circle pull-up text-heading"
                                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                            title="3 more">+3</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                              </div>
                            </div> --}}
                            <div class="col-md-4 col-sm-12">
                                <div class="card overflow-hidden mb-6" style="height: 500px;">
                                    <h5 class="card-header mb-2">Activity Timeline</h5>
                                    <div class="card-body" id="vertical-example">
                                        <ul class="timeline mt-2">
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-primary"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">12 Invoices have been paid</h6>
                                                        <small class="text-muted">12 min ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        Invoices have been paid to the company
                                                    </p>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <div class="badge bg-lighter rounded-3">
                                                            <img src="{{ asset('assets/img/icons/misc/pdf.png') }}" alt="img"
                                                                width="15" class="me-2">
                                                            <span class="h6 mb-0 text-body">invoices.pdf</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-success"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Client Meeting</h6>
                                                        <small class="text-muted">45 min ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        Project meeting with john @10:15am
                                                    </p>
                                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                                        <div class="d-flex flex-wrap align-items-center">
                                                            <div class="avatar avatar-sm me-2">
                                                                <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"
                                                                    class="rounded-circle" />
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                                                                <small>CEO of {{ config('variables.creatorName') }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Create a new project for client</h6>
                                                        <small class="text-muted">2 Day Ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        6 team members in a project
                                                    </p>
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-0">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <ul
                                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Vinnie Mostowy"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Julee Rossignol"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li class="avatar">
                                                                        <span class="avatar-initial rounded-circle pull-up text-heading"
                                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                            title="3 more">+3</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Create a new project for client</h6>
                                                        <small class="text-muted">2 Day Ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        6 team members in a project
                                                    </p>
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-0">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <ul
                                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Vinnie Mostowy"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Julee Rossignol"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li class="avatar">
                                                                        <span class="avatar-initial rounded-circle pull-up text-heading"
                                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                            title="3 more">+3</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Create a new project for client</h6>
                                                        <small class="text-muted">2 Day Ago</small>
                                                    </div>
                                                    <p class="mb-2">
                                                        6 team members in a project
                                                    </p>
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap p-0">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <ul
                                                                    class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Vinnie Mostowy"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/12.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                                        data-bs-placement="top" title="Julee Rossignol"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle"
                                                                            src="{{ asset('assets/img/avatars/6.png') }}" alt="Avatar" />
                                                                    </li>
                                                                    <li class="avatar">
                                                                        <span class="avatar-initial rounded-circle pull-up text-heading"
                                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                                            title="3 more">+3</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
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
