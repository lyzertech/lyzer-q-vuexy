@extends('layouts/layoutMaster')

@section('title', 'DataTables - Tables')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

<!-- Page Scripts -->
@section('page-script')
    {{-- @vite(['resources/assets/js/tables-datatables-basic.js']) --}}
@endsection

@section('content')

    <div class="row g-6">
        <!-- TechVault -->
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Tech Vault</h5>
                        <p class="card-subtitle mb-4">is the central internal knowledge base for all technical
                            information used
                            by the
                            Labs
                            and
                            Technical
                            Support teams.
                            It ensures everyone has quick access to consistent, verified, and updated data.</p>
                    </div>
                </div>
            </div>
        </div>
        <!--/ TechVault -->

        {{-- <hr class="my-6"> --}}

        <!-- Product Specifications -->
        <div class="col-md-5">
            <div class="card h-50">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Product Specifications</h5>
                        <p class="card-subtitle">is the central internal knowledge base for all technical
                            information used by
                            the
                            Labs
                            and
                            Technical
                            Support teams.
                            It ensures everyone has quick access to consistent, verified, and updated data.</p>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="dt-row-grouping table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Date</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--/ Product Specifications -->

        <!-- Product Specifications -->
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="mb-1">Product Specifications</h5>
                        <p class="card-subtitle">is the central internal knowledge base for all technical
                            information used by
                            the
                            Labs
                            and
                            Technical
                            Support teams.
                            It ensures everyone has quick access to consistent, verified, and updated data.</p>
                    </div>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="dt-row-grouping table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Date</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!--/ Product Specifications -->

        <hr class="my-12">
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // --- MANUAL DATA ---
            var manualData = [{
                    "id": 1,
                    "avatar": "10.png",
                    "full_name": "Korrie O'Crevy",
                    "post": "Nuclear Power Engineer",
                    "email": "kocrevy0@thetimes.co.uk",
                    "city": "Krasnosilka",
                    "start_date": "09/23/2021",
                    "salary": "$23896.35",
                    "age": "61",
                    "experience": "1 Year",
                    "status": 2
                },
                {
                    "id": 2,
                    "avatar": "1.png",
                    "full_name": "Bailie Coulman",
                    "post": "VP Quality Control",
                    "email": "bcoulman1@yolasite.com",
                    "city": "Hinigaran",
                    "start_date": "05/20/2021",
                    "salary": "$13633.69",
                    "age": "63",
                    "experience": "3 Years",
                    "status": 2
                },
                {
                    "id": 3,
                    "avatar": "9.png",
                    "full_name": "Stella Ganderton",
                    "post": "Operator",
                    "email": "sganderton2@tuttocitta.it",
                    "city": "Golcowa",
                    "start_date": "03/24/2021",
                    "salary": "$13076.28",
                    "age": "66",
                    "experience": "6 Years",
                    "status": 5
                },
                {
                    "id": 4,
                    "avatar": "10.png",
                    "full_name": "Dorolice Crossman",
                    "post": "Cost Accountant",
                    "email": "dcrossman3@google.co.jp",
                    "city": "Paquera",
                    "start_date": "12/03/2021",
                    "salary": "$12336.17",
                    "age": "22",
                    "experience": "2 Years",
                    "status": 2
                },
                {
                    "id": 5,
                    "avatar": "",
                    "full_name": "Harmonia Nisius",
                    "post": "Senior Cost Accountant",
                    "email": "hnisius4@gnu.org",
                    "city": "Lucan",
                    "start_date": "08/25/2021",
                    "salary": "$10909.52",
                    "age": "33",
                    "experience": "3 Years",
                    "status": 2
                },
                {
                    "id": 6,
                    "avatar": "",
                    "full_name": "Genevra Honeywood",
                    "post": "Geologist",
                    "email": "ghoneywood5@narod.ru",
                    "city": "Maofan",
                    "start_date": "06/01/2021",
                    "salary": "$17803.80",
                    "age": "61",
                    "experience": "1 Year",
                    "status": 1
                },
                {
                    "id": 7,
                    "avatar": "",
                    "full_name": "Eileen Diehn",
                    "post": "Environmental Specialist",
                    "email": "ediehn6@163.com",
                    "city": "Lampuyang",
                    "start_date": "10/15/2021",
                    "salary": "$18991.67",
                    "age": "59",
                    "experience": "9 Years",
                    "status": 3
                },
                {
                    "id": 8,
                    "avatar": "9.png",
                    "full_name": "Richardo Aldren",
                    "post": "Senior Sales Associate",
                    "email": "raldren7@mtv.com",
                    "city": "Skoghall",
                    "start_date": "11/05/2021",
                    "salary": "$19230.13",
                    "age": "55",
                    "experience": "5 Years",
                    "status": 3
                },
                {
                    "id": 9,
                    "avatar": "2.png",
                    "full_name": "Allyson Moakler",
                    "post": "Safety Technician",
                    "email": "amoakler8@shareasale.com",
                    "city": "Mogilany",
                    "start_date": "12/29/2021",
                    "salary": "$11677.32",
                    "age": "39",
                    "experience": "9 Years",
                    "status": 5
                },
                {
                    "id": 10,
                    "avatar": "9.png",
                    "full_name": "Merline Penhalewick",
                    "post": "Junior Executive",
                    "email": "mpenhalewick9@php.net",
                    "city": "Kanuma",
                    "start_date": "04/19/2021",
                    "salary": "$15939.52",
                    "age": "23",
                    "experience": "3 Years",
                    "status": 2
                },
                {
                    "id": 11,
                    "avatar": "",
                    "full_name": "De Falloon",
                    "post": "Sales Representative",
                    "email": "dfalloona@ifeng.com",
                    "city": "Colima",
                    "start_date": "06/12/2021",
                    "salary": "$19252.12",
                    "age": "30",
                    "experience": "0 Year",
                    "status": 4
                },
                {
                    "id": 12,
                    "avatar": "",
                    "full_name": "Cyrus Gornal",
                    "post": "Senior Sales Associate",
                    "email": "cgornalb@fda.gov",
                    "city": "Boro Utara",
                    "start_date": "12/09/2021",
                    "salary": "$16745.47",
                    "age": "22",
                    "experience": "2 Years",
                    "status": 4
                },
                {
                    "id": 13,
                    "avatar": "",
                    "full_name": "Tallou Balf",
                    "post": "Staff Accountant",
                    "email": "tbalfc@sina.com.cn",
                    "city": "Siliana",
                    "start_date": "01/21/2021",
                    "salary": "$15488.53",
                    "age": "36",
                    "experience": "6 Years",
                    "status": 4
                },
                {
                    "id": 14,
                    "avatar": "",
                    "full_name": "Othilia Extill",
                    "post": "Associate Professor",
                    "email": "oextilld@theatlantic.com",
                    "city": "Brzyska",
                    "start_date": "02/01/2021",
                    "salary": "$18442.34",
                    "age": "43",
                    "experience": "3 Years",
                    "status": 2
                },
                {
                    "id": 15,
                    "avatar": "",
                    "full_name": "Wilmar Bourton",
                    "post": "Administrative Assistant",
                    "email": "wbourtone@sakura.ne.jp",
                    "city": "Bích Động",
                    "start_date": "04/25/2021",
                    "salary": "$13304.45",
                    "age": "19",
                    "experience": "9 Years",
                    "status": 5
                },
                {
                    "id": 16,
                    "avatar": "4.png",
                    "full_name": "Robinson Brazenor",
                    "post": "General Manager",
                    "email": "rbrazenorf@symantec.com",
                    "city": "Gendiwu",
                    "start_date": "12/23/2021",
                    "salary": "$11953.08",
                    "age": "66",
                    "experience": "6 Years",
                    "status": 5
                },
                {
                    "id": 17,
                    "avatar": "",
                    "full_name": "Nadia Bettenson",
                    "post": "Environmental Tech",
                    "email": "nbettensong@joomla.org",
                    "city": "Chabařovice",
                    "start_date": "07/11/2021",
                    "salary": "$20484.44",
                    "age": "64",
                    "experience": "4 Years",
                    "status": 1
                },
                {
                    "id": 18,
                    "avatar": "",
                    "full_name": "Titus Hayne",
                    "post": "Web Designer",
                    "email": "thayneh@kickstarter.com",
                    "city": "Yangon",
                    "start_date": "05/25/2021",
                    "salary": "$16871.48",
                    "age": "59",
                    "experience": "9 Years",
                    "status": 1
                },
                {
                    "id": 19,
                    "avatar": "5.png",
                    "full_name": "Roxie Huck",
                    "post": "Administrative Assistant",
                    "email": "rhucki@ed.gov",
                    "city": "Polýkastro",
                    "start_date": "04/04/2021",
                    "salary": "$19653.56",
                    "age": "41",
                    "experience": "1 Year",
                    "status": 4
                },
                {
                    "id": 20,
                    "avatar": "7.png",
                    "full_name": "Latashia Lewtey",
                    "post": "Actuary",
                    "email": "llewteyj@sun.com",
                    "city": "Hougong",
                    "start_date": "08/03/2021",
                    "salary": "$18303.87",
                    "age": "35",
                    "experience": "5 Years",
                    "status": 1
                },
                {
                    "id": 21,
                    "avatar": "",
                    "full_name": "Natalina Tyne",
                    "post": "Software Engineer",
                    "email": "ntynek@merriam-webster.com",
                    "city": "Yanguan",
                    "start_date": "03/16/2021",
                    "salary": "$15256.40",
                    "age": "30",
                    "experience": "0 Year",
                    "status": 2
                },
                {
                    "id": 22,
                    "avatar": "",
                    "full_name": "Faun Josefsen",
                    "post": "Analog Circuit Design manager",
                    "email": "fjosefsenl@samsung.com",
                    "city": "Wengyang",
                    "start_date": "07/08/2021",
                    "salary": "$11209.16",
                    "age": "40",
                    "experience": "0 Year",
                    "status": 3
                },
                {
                    "id": 23,
                    "avatar": "9.png",
                    "full_name": "Rosmunda Steed",
                    "post": "Assistant Media Planner",
                    "email": "rsteedm@xing.com",
                    "city": "Manzanares",
                    "start_date": "12/23/2021",
                    "salary": "$13778.34",
                    "age": "21",
                    "experience": "1 Year",
                    "status": 5
                },
                {
                    "id": 24,
                    "avatar": "",
                    "full_name": "Scott Jiran",
                    "post": "Graphic Designer",
                    "email": "sjirann@simplemachines.org",
                    "city": "Pinglin",
                    "start_date": "05/26/2021",
                    "salary": "$23081.71",
                    "age": "23",
                    "experience": "3 Years",
                    "status": 1
                },
                {
                    "id": 25,
                    "avatar": "",
                    "full_name": "Carmita Medling",
                    "post": "Accountant",
                    "email": "cmedlingo@hp.com",
                    "city": "Bourges",
                    "start_date": "07/31/2021",
                    "salary": "$13602.24",
                    "age": "47",
                    "experience": "7 Years",
                    "status": 3
                },
                {
                    "id": 26,
                    "avatar": "2.png",
                    "full_name": "Morgen Benes",
                    "post": "Senior Sales Associate",
                    "email": "mbenesp@ted.com",
                    "city": "Cà Mau",
                    "start_date": "04/10/2021",
                    "salary": "$16969.63",
                    "age": "42",
                    "experience": "2 Years",
                    "status": 4
                },
                {
                    "id": 27,
                    "avatar": "",
                    "full_name": "Onfroi Doughton",
                    "post": "Civil Engineer",
                    "email": "odoughtonq@aboutads.info",
                    "city": "Utrecht (stad)",
                    "start_date": "09/29/2021",
                    "salary": "$23796.62",
                    "age": "28",
                    "experience": "8 Years",
                    "status": 3
                },
                {
                    "id": 28,
                    "avatar": "",
                    "full_name": "Kliment McGinney",
                    "post": "Chief Design Engineer",
                    "email": "kmcginneyr@paginegialle.it",
                    "city": "Xiaocheng",
                    "start_date": "07/09/2021",
                    "salary": "$24027.81",
                    "age": "28",
                    "experience": "8 Years",
                    "status": 4
                },
                {
                    "id": 29,
                    "avatar": "",
                    "full_name": "Devin Bridgland",
                    "post": "Tax Accountant",
                    "email": "dbridglands@odnoklassniki.ru",
                    "city": "Baoli",
                    "start_date": "07/17/2021",
                    "salary": "$13508.15",
                    "age": "48",
                    "experience": "8 Years",
                    "status": 3
                },
                {
                    "id": 30,
                    "avatar": "6.png",
                    "full_name": "Gilbert McFade",
                    "post": "Biostatistician",
                    "email": "gmcfadet@irs.gov",
                    "city": "Deje",
                    "start_date": "08/28/2021",
                    "salary": "$21632.30",
                    "age": "20",
                    "experience": "0 Year",
                    "status": 2
                }
            ];

            var groupColumn = 2;

            var table = $('.dt-row-grouping').DataTable({
                data: manualData,
                columns: [{
                        data: null
                    },
                    {
                        data: "full_name"
                    },
                    {
                        data: "post"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "city"
                    },
                    {
                        data: "start_date"
                    },
                    {
                        data: "salary"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: null
                    }
                ],
                columnDefs: [{
                        className: "control",
                        orderable: false,
                        targets: 0,
                        render: function() {
                            return "";
                        }
                    },
                    {
                        visible: false,
                        targets: groupColumn
                    },
                    {
                        targets: -2,
                        render: function(data) {
                            var status = {
                                1: {
                                    title: "Current",
                                    class: "bg-label-primary"
                                },
                                2: {
                                    title: "Professional",
                                    class: "bg-label-success"
                                },
                                3: {
                                    title: "Rejected",
                                    class: "bg-label-danger"
                                },
                                4: {
                                    title: "Resigned",
                                    class: "bg-label-warning"
                                },
                                5: {
                                    title: "Applied",
                                    class: "bg-label-info"
                                }
                            };
                            return '<span class="badge ' + status[data].class + '">' + status[data]
                                .title + '</span>';
                        }
                    },
                    {
                        targets: -1,
                        orderable: false,
                        render: function() {
                            return `
                        <a class="btn btn-sm btn-text-secondary btn-icon">
                            <i class="ti ti-pencil"></i>
                        </a>`;
                        }
                    }
                ],
                order: [
                    [groupColumn, "asc"]
                ],
                drawCallback: function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: "current"
                    }).nodes();
                    var last = null;

                    api.column(groupColumn, {
                        page: "current"
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows)
                                .eq(i)
                                .before(
                                    `<tr class="group"><td colspan="9" class="fw-bold bg-light">${group}</td></tr>`
                                );
                            last = group;
                        }
                    });
                }
            });

        });
    </script>

@endsection
