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
            <button class="tablinks w3-bar-item w3-button" onclick="openCity(event, 'Paris')">Manage Candidate</button>
            <button class="tablinks w3-bar-item w3-button" onclick="openCity(event, 'Tokyo')">Manage Criteria</button>
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

    {{-- Content --}}

    <div id="Home" class="tabcontent">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p>
    </div>

    <div id="Paris" class="tabcontent">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p>
    </div>

    <div id="Tokyo" class="tabcontent">
        <h3>Tokyo</h3>
        <p>Tokyo is the capital of Japan.</p>
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
