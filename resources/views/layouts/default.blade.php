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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/voter.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
        integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>

<body>
    {{-- Side Navigator Bar --}}
    <div class="wraper">
        <div class="sidebar">
            <img class="w3-bar-item"src="{{ url('/img/logo.jpeg') }}" alt="">

            @if (Auth::user()->type == 'admin')
                <a href="/dashboard" class="tablinks w3-bar-item w3-button"> Home</a>
                <a href="/admin/viewCandidate" class="tablinks w3-bar-item w3-button">Manage Candidate</a>
                <a href="/admin/viewCriteria" class="tablinks w3-bar-item w3-button">Manage Criteria</a>
                <a href="/admin/report" class="tablinks w3-bar-item w3-button"> Report</a>
            @else
                <a href="/dashboard" class="tablinks w3-bar-item w3-button"> Home</a>
                <a href="/voter/rateCandidate" class="tablinks w3-bar-item w3-button">Rate Candidate</a>
                <a href="/voter/viewResult" class="tablinks w3-bar-item w3-button">View Result</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="w3-bar-item w3-button">Logout</button>
            </form>
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

        {{-- Content --}}
        <section>
            <div class="main">
                @yield('contents')
            </div>
        </section>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>

    </div>
</body>

</html>
