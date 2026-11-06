@extends('layouts.default')

@section('contents')
    <center style="padding-top: 2%; padding-right: 8%">
        <h2>Position</h2>
    </center>
    <section class="content-rate">
        <div class="card-rate">  
            <center style="padding-top: 5%; padding-bottom: 2%;">
                <img src="{{ url('/img/student-affairs-icon.png') }}"
                    alt="default-image"
                    width="200"
                    height="200">

                <br>

                <h2><b>Student Affair</b></h2>

                <br>

                <a href="{{ route('voter.ratings.index', ['position' => 'student-affair']) }}"
                class="btn btn-danger">
                    Next
                </a>
            </center>
        </div>
        <div class="card-rate">      
            <center style="padding-top: 5%; padding-bottom: 2%;">
                <img src="{{ url('/img/welfare-exco-logo.png') }}"
                    alt="default-image"
                    width="200"
                    height="200">

                <br>

                <h2><b>Welfare Exco</b></h2>

                <br>

                <a href="{{ route('voter.ratings.index', ['position' => 'welfare-exco']) }}"
                class="btn btn-danger">
                    Next
                </a>
            </center>
        </div>
        <div class="card-rate">    
            <center style="padding-top: 5%; padding-bottom: 2%;">
                <img src="{{ url('/img/sports-exco-logo.png') }}"
                    alt="default-image"
                    width="200"
                    height="200">

                <br>

                <h2><b>Sports Exco</b></h2>

                <br>

                <a href="{{ route('voter.ratings.index', ['position' => 'sports-exco']) }}"
                class="btn btn-danger">
                    Next
                </a>
            </center>
        </div>
        <div class="card-rate">          
            <center style="padding-top: 5%; padding-bottom: 2%;">
                <img src="{{ url('/img/secretary-logo.png') }}"
                    alt="default-image"
                    width="200"
                    height="200">

                <br>

                <h2><b>Secretary</b></h2>

                <br>

                <a href="{{ route('voter.ratings.index', ['position' => 'secretary']) }}"
                class="btn btn-danger">
                    Next
                </a>
            </center>
        </div>
    </section>
@endsection
