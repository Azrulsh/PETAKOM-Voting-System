<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/img/logo-favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
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

    <script>
        function hideDiv(elem) {
            if (elem.value == "admin")
                document.getElementById('hideDiv').style.display = "none";
            else
                document.getElementById('hideDiv').style.display = 'block';
        }
    </script>
</head>

<body>
    <x-guest-layout>
        <div class="wrapper">
            <center>
                <img class="logo" src="{{ url('/img/logo.jpeg') }}" alt="">
            </center>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="user_id" value="{{ __('Matric ID') }}" />
                    <x-input id="user_id" class="block mt-1 w-full" type="text" name="user_id" :value="old('user_id')"
                        required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    {{-- @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif --}}
                </div>

                <div class="mt-4">
                    <x-label for="typeOfUser" value="{{ __('Type of User') }}" />
                    <select name="type" id="typeOfUser" onchange="hideDiv(this)" :value="old('type')" required autofocus autocomplete="type">
                        <option value="voter">Voter</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="block mt-2">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <center>
                    <div id="hideDiv" class="voter">
                        <div class="block mt-2">
                            Don't have an account?
                        </div>
                        <div class="block mt-2">
                            <a href="/signup" style="color: var(--Blue-1, #2F80ED);">Sign Up (Voter Only)</a>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-danger" style="background-color: red;">Login</button>
                </center>
            </form>
        </div>

    </x-guest-layout>
</body>

</html>
