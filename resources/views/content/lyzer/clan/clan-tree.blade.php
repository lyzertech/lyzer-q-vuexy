@extends('layouts/layoutMaster')

@section('title', 'Clan Tree')

@section('vendor-script')
    @vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')

    <h6 class="pb-1 mb-6 text-muted">Masonry</h6>
    <div class="row g-6 mb-6 justify-content-center align-items-center">
        <div class="col-lg-2">
            <div class="card text-center">
                <div class="card-body">
                    <p class="card-title">Ratima</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card text-center">
                <div class="card-body">
                    <p class="card-title">Siti Jumaroh</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-6 mb-6 justify-content-center align-items-center">
        <div class="col-lg-4">
            <div class="row g-6 justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <p class="card-title">Ade Maman Suherman</p>
                            {{-- <p class="card-text">This card has a regular title and short paragraph of text below it.</p> --}}
                            {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <p class="card-title">Irma Rosdian</p>
                            {{-- <p class="card-text">This card has a regular title and short paragraph of text below it.</p> --}}
                            {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card text-center">
                <div class="card-body">
                    <p class="card-title">Zakiyah Ais Safira</p>
                    {{-- <p class="card-text">This card has a regular title and short paragraph of text below it.</p> --}}
                    {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card text-center">
                <div class="card-body">
                    <p class="card-title">Muhammad Al Fajar</p>
                    {{-- <p class="card-text">This card has a regular title and short paragraph of text below it.</p> --}}
                    {{-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> --}}
                </div>
            </div>
        </div>
    </div>

@endsection
