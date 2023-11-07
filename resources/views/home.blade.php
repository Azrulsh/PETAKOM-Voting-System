@extends('layouts.default')

@section('contents')
    <div class="home">
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
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 50px; width: 50px; margin-bottom: 30px;"
                                viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                            </svg>
                        </div>
                    </div>
                    <div class="col">
                        <div class="totalCandidate">
                            <div class="tutorial">
                                <p id="totalCandidate">{{ DB::table('manage_criterias')->count() }}<br>Total Candidate</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" style="height: 50px; width: 50px; margin-bottom: 30px;"
                                viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path
                                    d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
