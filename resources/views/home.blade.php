<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>

<body>
    <!-- Sidebar -->
    <div class="w3-sidebar w3-light-grey w3-bar-block" style="width:15%">
        <img class="w3-bar-item"src="{{ url('/img/logo.jpeg') }}" alt="">
        @if (Auth::user()->type == 'admin')
            {{-- <a href="/" class="w3-bar-item w3-button tablinks" onclick="openCity(event, 'London')" id="defaultOpen">Home</a>
            <a href="#" class="w3-bar-item w3-button tablinks" onclick="openCity(event, 'Paris')">Manage Candidate</a>
            <a href="#" class="w3-bar-item w3-button tablinks" onclick="openCity(event, 'Tokyo')">Manage Criteria</a>
            <a href="#" class="w3-bar-item w3-button">Generate Report</a> --}}

            <button class="tablinks w3-bar-item w3-button" onclick="openCity(event, 'Home')"
                id="defaultOpen">Home</button>
            <button class="tablinks w3-bar-item w3-button" onclick="openCity(event, 'ManageCandidate')">Manage
                Candidate</button>
            <button class="tablinks w3-bar-item w3-button" onclick="openCity(event, 'ManageCriteria')">Manage
                Criteria</button>
            <button class="tablinks w3-bar-item w3-button" onclick="openCity(event, 'Malay')">Generate Report</button>


            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="w3-bar-item w3-button">Logout</button>
            </form>
        @else
            <a href="/" class="w3-bar-item w3-button">Home</a>
            <a href="#" class="w3-bar-item w3-button">Rate Candidate</a>
            <a href="#" class="w3-bar-item w3-button">View Result</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="w3-bar-item w3-button">Logout</button>
            </form>
        @endif
    </div>

    {{-- Top Navigation Bar --}}

    <div class="topnav">

        <!-- Centered link -->
        <div class="topnav-centered">
            <a href="" class="active">Petakom Voting System</a>
        </div>

        <!-- Right-aligned links -->
        <div class="topnav-right">
            <a>{{ Auth::user()->name }} <br> {{ Auth::user()->type }}</a>
            <a href="#profile"><img class="avatar" src="{{ url('/img/logo.jpeg') }}" alt="Avatar"></a>

        </div>

    </div>

    <div id="Home" class="tabcontent">
        <div class="dashboard-content">
            <h1>Welcome Back, {{ Auth::user()->name }}</h1>
            <hr class="solid">

            <div class="container px-4 text-center">
                <div class="row gx-2">
                    <div class="col">
                        <div class="totalCandidate">
                            <div class="tutorial">
                                <p id="totalCandidate">{{ DB::table('manage_candidates')->count() }}<br>Total Candidate</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 50px; width: 50px; margin-bottom: 30px;" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                        </div>
                    </div>
                    <div class="col">
                        <div class="totalCandidate">
                            <div class="tutorial">
                                <p id="totalCandidate">{{ DB::table('manage_criterias')->count() }}<br>Total Candidate</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 50px; width: 50px; margin-bottom: 30px;" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Manage Candidate --}}
    <div id="ManageCandidate" class="tabcontent">
        <h3>Candidate List</h3>
        <table class="table table-striped" id="tableManageCandidate">
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $candidate)
                    <tr>
                        <td>{{ $candidate->full_name }}</td>
                        <td style="text-align: center">
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                data-bs-target="#modal-edit-{{ $candidate->id }}">Edit</button>
                            &nbsp;&nbsp;
                            <a href="manage-candidate/{{ $candidate->id }}/delete"
                                onclick="return confirm('Are You Sure?')">
                                <button class="btn btn-danger" type="button">Delete</button>
                            </a>
                        </td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="modal-edit-{{ $candidate->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="/manage-candidate/{{ $candidate->id }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Candidate</h1>
                                    </div>
                                    <div class="modal-body">
                                        <center>
                                            <div class="container">
                                                <div class="picture-container">
                                                    <div class="picture">
                                                        <img src="https://lh3.googleusercontent.com/LfmMVU71g-HKXTCP_QWlDOemmWg4Dn1rJjxeEsZKMNaQprgunDTtEuzmcwUBgupKQVTuP0vczT9bH32ywaF7h68mF-osUSBAeM6MxyhvJhG6HKZMTYjgEv3WkWCfLB7czfODidNQPdja99HMb4qhCY1uFS8X0OQOVGeuhdHy8ln7eyr-6MnkCcy64wl6S_S6ep9j7aJIIopZ9wxk7Iqm-gFjmBtg6KJVkBD0IA6BnS-XlIVpbqL5LYi62elCrbDgiaD6Oe8uluucbYeL1i9kgr4c1b_NBSNe6zFwj7vrju4Zdbax-GPHmiuirf2h86eKdRl7A5h8PXGrCDNIYMID-J7_KuHKqaM-I7W5yI00QDpG9x5q5xOQMgCy1bbu3St1paqt9KHrvNS_SCx-QJgBTOIWW6T0DHVlvV_9YF5UZpN7aV5a79xvN1Gdrc7spvSs82v6gta8AJHCgzNSWQw5QUR8EN_-cTPF6S-vifLa2KtRdRAV7q-CQvhMrbBCaEYY73bQcPZFd9XE7HIbHXwXYA=s200-no"
                                                            class="picture-src" id="wizardPicturePreview"
                                                            title="">
                                                        <input type="file" id="wizard-picture" class="">
                                                    </div>
                                                    <h6 class="">Choose Picture</h6>

                                                </div>
                                            </div>
                                            <script>
                                                $(document).ready(function() {
                                                    // Prepare the preview for profile picture
                                                    $("#wizard-picture").change(function() {
                                                        readURL(this);
                                                    });
                                                });

                                                function readURL(input) {
                                                    if (input.files && input.files[0]) {
                                                        var reader = new FileReader();

                                                        reader.onload = function(e) {
                                                            $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
                                                        }
                                                        reader.readAsDataURL(input.files[0]);
                                                    }
                                                }
                                            </script>
                                        </center>
                                        <br>

                                        <div class="container text-center">
                                            <div class="row">
                                                <div class="col-sm-5 col-md-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Criteria
                                                            Name</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex: Nafiz Mansor" aria-label="full_name"
                                                            aria-describedby="basic-addon1" name="full_name"
                                                            value="{{ $candidate->full_name }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Volunteering
                                                            Point</span>
                                                        <input type="number" min="0" max="5"
                                                            class="form-control" placeholder="Ex: 3.5 rating"
                                                            aria-label="volunteering_point"
                                                            aria-describedby="basic-addon1" name="volunteering_point"
                                                            value="{{ $candidate->volunteering_point }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-5 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Matric
                                                            ID</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex: CA29990" aria-label="matric_id"
                                                            aria-describedby="basic-addon1" name="matric_id"
                                                            value="{{ $candidate->matric_id }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Leadership
                                                            Point</span>
                                                        <input type="number" min="0" max="5"
                                                            class="form-control" placeholder="Ex: 3.5 rating"
                                                            aria-label="leadership_point"
                                                            aria-describedby="basic-addon1" name="leadership_point"
                                                            value="{{ $candidate->leadership_point }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-5 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Course</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex: Bachelor of Science Computer"
                                                            aria-label="course" aria-describedby="basic-addon1"
                                                            name="course" value="{{ $candidate->course }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Community
                                                            Service Point</span>
                                                        <input type="number" min="0" max="5"
                                                            class="form-control" placeholder="Ex: 3.5 rating"
                                                            aria-label="community_service_point"
                                                            aria-describedby="basic-addon1"
                                                            name="community_service_point"
                                                            value="{{ $candidate->community_service_point }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-5 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Year</span>
                                                        <input type="number" class="form-control"
                                                            placeholder="Ex: 2000" aria-label="year"
                                                            aria-describedby="basic-addon1" name="year"
                                                            value="{{ $candidate->year }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Academic
                                                            Point</span>
                                                        <input type="number" min="0" max="5"
                                                            class="form-control" placeholder="Ex: 3.5 rating"
                                                            aria-label="academic_point"
                                                            aria-describedby="basic-addon1" name="academic_point"
                                                            value="{{ $candidate->academic_point }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-5 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">Semester</span>
                                                        <input type="number" min="0" max="2"
                                                            class="form-control" placeholder="Ex: 2"
                                                            aria-label="semester" aria-describedby="basic-addon1"
                                                            name="semester" value="{{ $candidate->semester }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">Manifesto</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex: Type the manifesto"
                                                            aria-label="manifesto" aria-describedby="basic-addon1"
                                                            name="manifesto" value="{{ $candidate->manifesto }}"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6 col-md-5 col-lg-6">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"
                                                            id="basic-addon1">Position</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex: Type the position" aria-label="position"
                                                            aria-describedby="basic-addon1" name="position"
                                                            value="{{ $candidate->position }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text" id="basic-addon1">Link to
                                                            video</span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Ex: youtube.com" aria-label="video_link"
                                                            aria-describedby="basic-addon1" name="video_link"
                                                            value="{{ $candidate->video_link }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>

        </table>
        <center>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#modal-add-candidate">
                Add
            </button>
        </center>

        <!-- Modal Add -->
        <div class="modal fade" id="modal-add-candidate" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form action="/manage-candidate" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Candidate</h1>
                        </div>
                        <div class="modal-body">
                            <center>
                                <div class="container">
                                    <div class="picture-container">
                                        <div class="picture">
                                            <img src="https://lh3.googleusercontent.com/LfmMVU71g-HKXTCP_QWlDOemmWg4Dn1rJjxeEsZKMNaQprgunDTtEuzmcwUBgupKQVTuP0vczT9bH32ywaF7h68mF-osUSBAeM6MxyhvJhG6HKZMTYjgEv3WkWCfLB7czfODidNQPdja99HMb4qhCY1uFS8X0OQOVGeuhdHy8ln7eyr-6MnkCcy64wl6S_S6ep9j7aJIIopZ9wxk7Iqm-gFjmBtg6KJVkBD0IA6BnS-XlIVpbqL5LYi62elCrbDgiaD6Oe8uluucbYeL1i9kgr4c1b_NBSNe6zFwj7vrju4Zdbax-GPHmiuirf2h86eKdRl7A5h8PXGrCDNIYMID-J7_KuHKqaM-I7W5yI00QDpG9x5q5xOQMgCy1bbu3St1paqt9KHrvNS_SCx-QJgBTOIWW6T0DHVlvV_9YF5UZpN7aV5a79xvN1Gdrc7spvSs82v6gta8AJHCgzNSWQw5QUR8EN_-cTPF6S-vifLa2KtRdRAV7q-CQvhMrbBCaEYY73bQcPZFd9XE7HIbHXwXYA=s200-no"
                                                class="picture-src" id="wizardPicturePreview" title="">
                                            <input type="file" id="wizard-picture" class="">
                                        </div>
                                        <h6 class="">Choose Picture</h6>

                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        // Prepare the preview for profile picture
                                        $("#wizard-picture").change(function() {
                                            readURL(this);
                                        });
                                    });

                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
                                            }
                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                            </center>
                            <br>

                            <div class="container text-center">
                                <div class="row">
                                    <div class="col-sm-5 col-md-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Criteria Name</span>
                                            <input type="text" class="form-control" placeholder="Ex: Nafiz Mansor"
                                                aria-label="full_name" aria-describedby="basic-addon1"
                                                name="full_name" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Volunteering Point</span>
                                            <input type="number" min="0" max="5" class="form-control"
                                                placeholder="Ex: 3.5 rating" aria-label="volunteering_point"
                                                aria-describedby="basic-addon1" name="volunteering_point" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-5 col-lg-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Matric ID</span>
                                            <input type="text" class="form-control" placeholder="Ex: CA29990"
                                                aria-label="matric_id" aria-describedby="basic-addon1"
                                                name="matric_id" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Leadership Point</span>
                                            <input type="number" min="0" max="5" class="form-control"
                                                placeholder="Ex: 3.5 rating" aria-label="leadership_point"
                                                aria-describedby="basic-addon1" name="leadership_point" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-5 col-lg-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Course</span>
                                            <input type="text" class="form-control"
                                                placeholder="Ex: Bachelor of Science Computer" aria-label="course"
                                                aria-describedby="basic-addon1" name="course" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Community Service
                                                Point</span>
                                            <input type="number" min="0" max="5" class="form-control"
                                                placeholder="Ex: 3.5 rating" aria-label="community_service_point"
                                                aria-describedby="basic-addon1" name="community_service_point"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-5 col-lg-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Year</span>
                                            <input type="number" class="form-control" placeholder="Ex: 2000"
                                                aria-label="year" aria-describedby="basic-addon1" name="year"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Academic Point</span>
                                            <input type="number" min="0" max="5" class="form-control"
                                                placeholder="Ex: 3.5 rating" aria-label="academic_point"
                                                aria-describedby="basic-addon1" name="academic_point" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-5 col-lg-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Semester</span>
                                            <input type="number" min="0" max="2" class="form-control"
                                                placeholder="Ex: 2" aria-label="semester"
                                                aria-describedby="basic-addon1" name="semester" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Manifesto</span>
                                            <input type="text" class="form-control"
                                                placeholder="Ex: Type the manifesto" aria-label="manifesto"
                                                aria-describedby="basic-addon1" name="manifesto" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-5 col-lg-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Position</span>
                                            <input type="text" class="form-control"
                                                placeholder="Ex: Type the position" aria-label="position"
                                                aria-describedby="basic-addon1" name="position" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-5 offset-md-2 col-lg-6 offset-lg-0">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Link to video</span>
                                            <input type="text" class="form-control" placeholder="Ex: youtube.com"
                                                aria-label="video_link" aria-describedby="basic-addon1"
                                                name="video_link" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Manage Criteria --}}
    <div id="ManageCriteria" class="tabcontent">
        <h3>Criteria List</h3>
        <table class="table table-striped" id="tableManageCriteria">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Criteria Name</th>
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($criterias as $criteria)
                    <tr>
                        <td>{{ $criteria->id }}</td>
                        <td>{{ $criteria->name }}</td>
                        <td style="text-align: center">
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                data-bs-target="#modal-edit-{{ $criteria->id }}">Edit</button>
                            &nbsp;&nbsp;
                            <a href="manage-criteria/{{ $criteria->id }}/delete"
                                onclick="return confirm('Are You Sure?')">
                                <button class="btn btn-danger" type="button">Delete</button>
                            </a>
                        </td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="modal-edit-{{ $criteria->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="/manage-criteria/{{ $criteria->id }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Criteria</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Criteria Name</span>
                                            <input type="text" class="form-control" placeholder="Ex: Nafiz Mansor"
                                                aria-label="name" aria-describedby="basic-addon1" name="name"
                                                value="{{ $criteria->name }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>

        </table>
        <center>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#modal-add-criteria">
                Add
            </button>
        </center>

        <!-- Modal Add -->
        <div class="modal fade" id="modal-add-criteria" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="/manage-criteria" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Criteria</h1>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Criteria Name</span>
                                <input type="text" class="form-control" placeholder="Ex: Nafiz Mansor"
                                    aria-label="name" aria-describedby="basic-addon1" name="name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="Malay" class="tabcontent">
        <h3>Malay</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div>

    <script>
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
    </script>

</body>

</html>
