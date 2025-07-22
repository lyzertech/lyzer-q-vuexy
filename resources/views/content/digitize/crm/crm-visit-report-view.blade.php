@extends('layouts/layoutMaster')

@section('title', 'CRM Visit Report View')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/plyr/plyr.scss')
@endsection

@section('page-style')
    @vite('resources/assets/vendor/scss/pages/app-academy-details.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/plyr/plyr.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/app-academy-course-details.js')
@endsection

@section('content')

    @php
        use Illuminate\Support\Facades\Auth;
    @endphp

    <div class="row g-6">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap mb-6 gap-2">
                        <div class="me-1">
                            <h5 class="mb-0">{{ $crm_visit_report->customer_name }}</h5>
                            <p class="mb-0">Mr./Mrs <span class="fw-medium text-heading">
                                    {{ $crm_visit_report->contact_person }} </span></p>
                        </div>
                        <div class="d-flex align-items-center">
                            @php
                                $badgeClasses = [
                                    'Planned' => 'bg-label-info',
                                    'In Progress' => 'bg-label-info',
                                    'Submitted' => 'bg-label-primary',
                                    'Reviewed' => 'bg-label-warning',
                                    'Checked' => 'bg-label-danger',
                                    'Acknowledge' => 'bg-label-danger',
                                    'Cancelled' => 'bg-label-danger',
                                    'Completed' => 'bg-label-success',
                                ];

                                $status = $crm_visit_report->status ?? 'Unknown';
                                $badgeClass = $badgeClasses[$status] ?? 'bg-label-secondary';
                            @endphp

                            <span class="badge {{ $badgeClass }}">{{ $status }}</span>

                            <i class='ti ti-share ti-lg mx-4'></i>
                            <i class='ti ti-bookmarks ti-lg'></i>
                        </div>
                    </div>
                    <div class="card academy-content shadow-none border">
                        <div class="card-body pt-4">
                            <h5>Detail Visit</h5>
                            <h5>{{ $crm_visit_report->purpose }}</h5>
                            <div class="d-flex flex-wrap row-gap-2">
                                <div class="me-12">
                                    <p class="text-nowrap mb-2"><i class='ti ti-users me-2 align-top'></i>Sales:
                                        {{ $crm_visit_report->sales }}
                                    </p>
                                    <p class="text-nowrap mb-2"><i class='ti ti-world me-2 align-bottom'></i>Location:
                                        {{ $crm_visit_report->location }}</p>
                                </div>
                                <div>
                                    <p class="text-nowrap mb-2"><i class='ti ti-calendar me-2 align-top'></i>Date:
                                        {{ $crm_visit_report->visit_date }}
                                    </p>
                                    <p class="text-nowrap mb-0"><i class='ti ti-clock me-2 align-top'></i>Time:
                                        {{ $crm_visit_report->visit_time }}
                                    </p>
                                </div>
                                <hr class="my-6">
                            </div>
                            @if (Auth::check())
                                @if (Auth::user()->role_id == 2 ||
                                        Auth::user()->name != $crm_visit_report->sales ||
                                        in_array($crm_visit_report->status, [
                                            'Submitted',
                                            'Reviewed',
                                            'Checked',
                                            'Acknowledge',
                                            'Cancelled',
                                            'Completed',
                                        ]))
                                    <!-- Content for role 2 -->
                                    <div class="">
                                        <hr class="my-6">
                                        <h6>Notes</h6>
                                        {{-- <p class="mb-6">
                                            {{ $crm_visit_report->notes }}
                                        </p> --}}
                                        <p class="mb-6">
                                            @foreach (explode("\n", $crm_visit_report->notes) as $line)
                                                <span class="note-line">- {{ e($line) }}</span><br>
                                            @endforeach
                                        </p>
                                        <h6>Customer Feedback</h6>
                                        {{-- <p class="mb-6">
                                            {{ $crm_visit_report->customer_feedback }}
                                        </p> --}}
                                        <p class="mb-6">
                                            @foreach (explode("\n", $crm_visit_report->customer_feedback) as $line)
                                                <span class="note-line">- {{ e($line) }}</span><br>
                                            @endforeach
                                        </p>
                                        <h6>Follow Up Date</h6>
                                        <p class="mb-6">
                                            {{ $crm_visit_report->follow_up_date }}
                                            @if (in_array($crm_visit_report->follow_up_date_status, ['0']) &&
                                                    !empty($crm_visit_report->follow_up_date) &&
                                                    Auth::user()->name == 'David')
                                                <form method="post"
                                                    action="{{ route('crm-visit-report-followup', $crm_visit_report->id_visit_report) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf <!-- CSRF protection -->
                                                    <button type="submit" class="btn btn-success">Mark as Followed
                                                        Up</button>
                                                </form>
                                            @else
                                            @endif
                                        </p>
                                        @php
                                            // Define badge classes for prospek statuses
                                            $prospekBadgeClasses = [
                                                '1' => 'bg-label-success', // Yes
                                                '0' => 'bg-label-warning', // No
                                                'Unknown' => 'bg-label-secondary', // Default for undefined statuses
                                            ];

                                            // Get the prospek value and map to the badge class
                                            $prospek = $crm_visit_report->prospek ?? 'Unknown';
                                            $prospekBadgeClass =
                                                $prospekBadgeClasses[$prospek] ?? $prospekBadgeClasses['Unknown'];
                                        @endphp
                                        <h6>Prospek</h6>
                                        <span
                                            class="badge {{ $prospekBadgeClass }}">{{ $prospek == '1' ? 'Yes' : ($prospek == '0' ? 'No' : 'Unknown') }}</span>
                                        <h6>Next Step</h6>
                                        {{-- <p class="mb-6">
                                            {{ $crm_visit_report->next_steps }}
                                        </p> --}}
                                        <p class="mb-6">
                                            @foreach (explode("\n", $crm_visit_report->next_steps) as $line)
                                                <span class="note-line">- {{ e($line) }}</span><br>
                                            @endforeach
                                        </p>

                                        <div class="modal-footer border-0">
                                            @if (in_array(Auth::user()->name, ['David', 'Alfian Jasrin']))
                                                <form method="post"
                                                    action="{{ route('crm-visit-report-delete', $crm_visit_report->id_visit_report) }}"
                                                    enctype="multipart/form-data"
                                                    onsubmit="return confirm('Are you sure you want to Delete this visit report?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger mx-2">
                                                        <i class="fas fa-trash-alt"></i>&nbsp; Delete
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-label-secondary"
                                                    onclick="window.location.href = '../';">
                                                    Back
                                                </button>
                                            @elseif (Auth::user()->name === 'Julia' && $status === 'Planned')
                                                <button type="button" class="btn btn-label-secondary mx-2"
                                                    onclick="window.location.href = '../';">
                                                    Back
                                                </button>
                                                <form method="post"
                                                    action="{{ route('crm-visit-report-cancel', $crm_visit_report->id_visit_report) }}"
                                                    enctype="multipart/form-data"
                                                    onsubmit="return confirm('Are you sure you want to cancel this visit report?');">
                                                    @csrf <!-- CSRF protection -->
                                                    <button type="submit" class="btn btn-danger">Cancelled</button>
                                                </form>
                                            @else
                                                <button type="button" class="btn btn-label-secondary mx-2"
                                                    onclick="window.location.href = '../';">
                                                    Back
                                                </button>
                                            @endif
                                        </div>

                                    </div>
                                @elseif (Auth::user()->role_id == 4 && Auth::user()->name == $crm_visit_report->sales)
                                    <!-- Content for role 4 -->
                                    <form method="post"
                                        action="{{ route('crm-visit-report-edit', $crm_visit_report->id_visit_report) }}"
                                        enctype="multipart/form-data">
                                        @csrf <!-- CSRF protection -->
                                        <hr class="my-6">
                                        <h6>Notes</h6>
                                        <p class="mb-6">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="notes" name="notes">{{ $crm_visit_report->notes }}</textarea>
                                        </p>
                                        <h6>Customer Feedback</h6>
                                        <p class="mb-6">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="customer_feedback"
                                                name="customer_feedback">{{ $crm_visit_report->customer_feedback }}</textarea>
                                        </p>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h6>Follow Up Date</h6>
                                                <div class="mb-4">
                                                    <input class="form-control" type="date" id="follow_up_date"
                                                        name="follow_up_date"
                                                        value="{{ $crm_visit_report->follow_up_date }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <h6>Prospek</h6>
                                                <select id="prospek" class="form-select" name="prospek">
                                                    <option>Choose Status</option>
                                                    <option value="1"
                                                        {{ $crm_visit_report->prospek == '1' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="0"
                                                        {{ $crm_visit_report->prospek == '0' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="2"
                                                        {{ $crm_visit_report->prospek == '2' ? 'selected' : '' }}>Cancelled
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <h6>Next Step</h6>
                                        <p class="mb-6">
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="next_steps" name="next_steps">{{ $crm_visit_report->next_steps }}</textarea>
                                        </p>

                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-label-secondary mx-2"
                                                onclick="window.location.href = '../';">
                                                Back
                                            </button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>

                                    <form method="post"
                                        action="{{ route('crm-visit-report-submit', $crm_visit_report->id_visit_report) }}"
                                        enctype="multipart/form-data"
                                        onsubmit="return confirm('⚠️ WARNING: Make sure you have updated the visit report before submitting. \n\nAre you sure you want to SUBMIT this visit report?');">
                                        @csrf <!-- CSRF protection -->
                                        <div class="modal-footer border-0">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </form>
                                @else
                                    <!-- Content for other roles -->
                                    <p>Your role is {{ Auth::user()->role }}. You don't have access to this content.</p>
                                @endif
                            @else
                                <!-- Content for unauthenticated users -->
                                <p>Please log in to view your role.</p>
                            @endif

                            <hr class="my-6">
                            <h5>Acknowledge</h5>
                            {{-- Ack Manager --}}
                            <form method="post"
                                action="{{ route('crm-visit-report-ackmanager', $crm_visit_report->id_visit_report) }}"
                                enctype="multipart/form-data">
                                @csrf <!-- CSRF protection -->
                                <div class="row mb-4">
                                    <div class="col-4">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar me-4"><img
                                                        src="{{ asset('assets/img/avatars/Vicha.png') }}" alt="Avatar"
                                                        class="rounded-circle"></div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1">Vicha</h6>
                                                <small>Manager</small>
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::check())
                                        @if (Auth::user()->name == 'Vicha' && empty($crm_visit_report->ack_manager))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    <textarea class="form-control" id="ack_manager" rows="3" id="ack_manager" name="ack_manager">{{ $crm_visit_report->ack_manager }}</textarea>
                                                </p>
                                            </div>

                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        @elseif (!empty($crm_visit_report->ack_manager))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    {{ $crm_visit_report->ack_manager }}
                                                </p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </form>
                            {{-- Ack Director --}}
                            <form method="post"
                                action="{{ route('crm-visit-report-ackdirector', $crm_visit_report->id_visit_report) }}"
                                enctype="multipart/form-data">
                                @csrf <!-- CSRF protection -->
                                <div class="row mb-4">
                                    <div class="col-4">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar me-4"><img
                                                        src="{{ asset('assets/img/avatars/11.png') }}" alt="Avatar"
                                                        class="rounded-circle"></div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1">David</h6>
                                                <small>Director</small>
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::check())
                                        @if (empty($crm_visit_report->ack_manager))
                                        @elseif (Auth::user()->name == 'David' && empty($crm_visit_report->ack_director))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    <textarea class="form-control" id="ack_director" rows="3" id="ack_director" name="ack_director">{{ $crm_visit_report->ack_director }}</textarea>
                                                </p>
                                            </div>

                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        @elseif (!empty($crm_visit_report->ack_director))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    {{ $crm_visit_report->ack_director }}
                                                </p>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </form>
                            {{-- Ack President Director --}}
                            {{-- <form method="post"
                                action="{{ route('crm-visit-report-ackpresdir', $crm_visit_report->id_visit_report) }}"
                                enctype="multipart/form-data">
                                @csrf <!-- CSRF protection -->
                                <div class="row mb-4">
                                    <div class="col-4">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar me-4"><img
                                                        src="{{ asset('assets/img/avatars/11.png') }}" alt="Avatar"
                                                        class="rounded-circle"></div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1">Alfian Jasrin</h6>
                                                <small>President Director</small>
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::check())
                                        @if (empty($crm_visit_report->ack_director))
                                        @elseif (Auth::user()->name == 'Alfian Jasrin' && empty($crm_visit_report->ack_presdir))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    <textarea class="form-control" id="ack_presdir" rows="3" id="ack_presdir" name="ack_presdir">{{ $crm_visit_report->ack_presdir }}</textarea>
                                                </p>
                                            </div>

                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        @elseif (!empty($crm_visit_report->ack_presdir))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    {{ $crm_visit_report->ack_presdir }}
                                                </p>
                                            </div>
                                        @elseif (empty($crm_visit_report->ack_director))
                                        @endif
                                    @endif
                                </div>
                            </form> --}}

                            <hr class="my-6">
                            <h5>Final Response</h5>
                            {{-- Final Response --}}
                            <form method="post"
                                action="{{ route('crm-visit-report-response', $crm_visit_report->id_visit_report) }}"
                                enctype="multipart/form-data">
                                @csrf <!-- CSRF protection -->
                                <div class="row mb-4">
                                    <div class="col-4">
                                        <div class="d-flex justify-content-start align-items-center user-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar me-4">
                                                    <img src="{{ asset('assets/img/avatars/' . $crm_visit_report->sales . '.png') }}"
                                                        alt="Avatar" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-1">{{ $crm_visit_report->sales }}</h6>
                                                <small>Sales</small>
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::check())
                                        {{-- @if (empty($crm_visit_report->ack_presdir)) --}}
                                        @if (empty($crm_visit_report->ack_director))
                                        @elseif (Auth::user()->name == $crm_visit_report->sales && empty($crm_visit_report->response))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    <textarea class="form-control" id="response" rows="3" id="response" name="response">{{ $crm_visit_report->response }}</textarea>
                                                </p>
                                            </div>

                                            <div class="modal-footer border-0">
                                                <button type="submit" class="btn btn-success">Completed</button>
                                            </div>
                                        @elseif (!empty($crm_visit_report->response))
                                            <div class="col-8">
                                                <p class="mb-6">
                                                    {{ $crm_visit_report->response }}
                                                </p>
                                            </div>
                                            {{-- @elseif (empty($crm_visit_report->ack_presdir)) --}}
                                        @endif
                                    @endif
                                </div>
                            </form>

                            {{-- @if (Auth::check())
                                @if (in_array(Auth::user()->role_id, [1, 2, 4]) && $crm_visit_report->status == 'Approved')
                                    <div class="col">
                                        <div class="">
                                            <div class="me-4">
                                                <img src="{{ asset('img/approved.png') }}" alt="Avatar"
                                                    class="rounded-circle" style="width: 75%; height: 75%;">
                                            </div>
                                        </div>
                                    </div>
                                @elseif (in_array(Auth::user()->role_id, [1, 2, 4]) && $crm_visit_report->status !== 'Approved')
                                @endif
                            @endif --}}

                            {{-- @if (Auth::check())
                                @if (Auth::user()->role_id == 2 && $crm_visit_report->status !== 'Approved')
                                    <div class="col">
                                        <div class="modal-footer border-0">
                                            <form method="post"
                                                action="{{ route('crm-visit-report-approve', $crm_visit_report->id_visit_report) }}"
                                                enctype="multipart/form-data">
                                                @csrf <!-- CSRF protection -->
                                                <button type="submit" class="btn btn-primary">Approve</button>
                                            </form>
                                        </div>
                                    </div>
                                @elseif (Auth::user()->role_id == 2 && $crm_visit_report->status == 'Approved')
                                @endif
                            @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4">
            <div class="accordion stick-top accordion-custom-button" id="courseContent">
                <div class="accordion-item active mb-0">
                    <div class="accordion-header" id="headingOne">
                        <button type="button" class="accordion-button " data-bs-toggle="collapse"
                            data-bs-target="#chapterOne" aria-expanded="true" aria-controls="chapterOne">
                            <span class="d-flex flex-column">
                                <span class="h5 mb-0">Course Content</span>
                                <span class="text-body fw-normal">2 / 5 | 4.4 min</span>
                            </span>
                        </button>
                    </div>
                    <div id="chapterOne" class="accordion-collapse collapse show" data-bs-parent="#courseContent">
                        <div class="accordion-body py-4">
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defaultCheck1" checked="" />
                                <label for="defaultCheck1" class="form-check-label ms-4">
                                    <span class="mb-0 h6">1. Welcome to this course</span>
                                    <small class="text-body d-block">2.4 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defaultCheck2" checked="" />
                                <label for="defaultCheck2" class="form-check-label ms-4">
                                    <span class="mb-0 h6">2. Watch before you start</span>
                                    <small class="text-body d-block">4.8 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                <label for="defaultCheck3" class="form-check-label ms-4">
                                    <span class="mb-0 h6">3. Basic design theory</span>
                                    <small class="text-body d-block">5.9 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                <label for="defaultCheck4" class="form-check-label ms-4">
                                    <span class="mb-0 h6">4. Basic fundamentals</span>
                                    <small class="text-body d-block">3.6 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                <label for="defaultCheck5" class="form-check-label ms-4">
                                    <span class="mb-0 h6">5. What is ui/ux</span>
                                    <small class="text-body d-block">10.6 min</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" id="headingTwo">
                        <button type="button" class=" accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#chapterTwo" aria-expanded="false" aria-controls="chapterTwo">
                            <span class="d-flex flex-column">
                                <span class="h5 mb-0">Web Design for Web Developers</span>
                                <span class="text-body fw-normal">1 / 4 | 4.4 min</span>
                            </span>
                        </button>
                    </div>
                    <div id="chapterTwo" class="accordion-collapse collapse" data-bs-parent="#courseContent">
                        <div class="accordion-body py-4">
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck1" checked="" />
                                <label for="defCheck1" class="form-check-label ms-4">
                                    <span class="mb-0 h6">1. How to use Pages in Figma</span>
                                    <small class="text-body d-block">8:31 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck2" />
                                <label for="defCheck2" class="form-check-label ms-4">
                                    <span class="mb-0 h6">2. What is Lo Fi Wireframe</span>
                                    <small class="text-body d-block">2 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck3" />
                                <label for="defCheck3" class="form-check-label ms-4">
                                    <span class="mb-0 h6">3. How to use color in Figma</span>
                                    <small class="text-body d-block">5.9 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                <input class="form-check-input" type="checkbox" id="defCheck4" />
                                <label for="defCheck4" class="form-check-label ms-4">
                                    <span class="mb-0 h6">4. Frames vs Groups in Figma</span>
                                    <small class="text-body d-block">3.6 min</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" id="headingThree">
                        <button type="button" class=" accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#chapterThree" aria-expanded="false" aria-controls="chapterThree">
                            <span class="d-flex flex-column">
                                <span class="h5 mb-0">Build Beautiful Websites!</span>
                                <span class="text-body fw-normal">0 / 6 | 4.4 min</span>
                            </span>
                        </button>
                    </div>
                    <div id="chapterThree" class="accordion-collapse collapse" data-bs-parent="#courseContent">
                        <div class="accordion-body py-4">
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck-01" />
                                <label for="defCheck-01" class="form-check-label ms-4">
                                    <span class="mb-0 h6">1. Section & Div Block</span>
                                    <small class="text-body d-block">8:31 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck-02" />
                                <label for="defCheck-02" class="form-check-label ms-4">
                                    <span class="mb-0 h6">2. Read-Only Version of Chat App</span>
                                    <small class="text-body d-block">8 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck-03" />
                                <label for="defCheck-03" class="form-check-label ms-4">
                                    <span class="mb-0 h6">3. Webflow Autosave</span>
                                    <small class="text-body d-block">2.9 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck-04" />
                                <label for="defCheck-04" class="form-check-label ms-4">
                                    <span class="mb-0 h6">4. Canvas Settings</span>
                                    <small class="text-body d-block">7.6 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck-05" />
                                <label for="defCheck-05" class="form-check-label ms-4">
                                    <span class="mb-0 h6">5. HTML Tags</span>
                                    <small class="text-body d-block">10 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                <input class="form-check-input" type="checkbox" id="defCheck-06" />
                                <label for="defCheck-06" class="form-check-label ms-4">
                                    <span class="mb-0 h6">6. Footer (Chat App)</span>
                                    <small class="text-body d-block">9.10 min</small>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header" id="headingFour">
                        <button type="button" class=" accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#chapterFour" aria-expanded="false" aria-controls="chapterFour">
                            <span class="d-flex flex-column">
                                <span class="h5 mb-0">Final Project</span>
                                <span class="text-body fw-normal">2 / 3 | 4.4 min</span>
                            </span>
                        </button>
                    </div>
                    <div id="chapterFour" class="accordion-collapse collapse" data-bs-parent="#courseContent">
                        <div class="accordion-body py-4">
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck-101" checked="" />
                                <label for="defCheck-101" class="form-check-label ms-4">
                                    <span class="mb-0 h6">1. Responsive Blog Site</span>
                                    <small class="text-body d-block">10:0 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-4">
                                <input class="form-check-input" type="checkbox" id="defCheck-102" checked="" />
                                <label for="defCheck-102" class="form-check-label ms-4">
                                    <span class="mb-0 h6">2. Responsive Portfolio</span>
                                    <small class="text-body d-block">13:00 min</small>
                                </label>
                            </div>
                            <div class="form-check d-flex align-items-center gap-1 mb-0">
                                <input class="form-check-input" type="checkbox" id="defCheck-103" />
                                <label for="defCheck-103" class="form-check-label ms-4">
                                    <span class="mb-0 h6">3. Responsive eCommerce Website</span>
                                    <small class="text-body d-block">15 min</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

@endsection
