@extends('layouts.default')

@section('contents')
    <center style="padding-top: 2%; padding-right: 8%">
        <h2>Candidate</h2>
    </center>
    <section class="content-candidate">
        @foreach ($candidates as $item)
            @if ($item->position == 'Welfare Exco')
                <div class="card-candidate">
                    <center style="padding-top: 5%;">
                        <img src="{{ url('/img/default-candidate-icon.png') }}" alt="default-image" width="200"
                            height="200">
                    </center>
                    <br>
                    <div class="detail-candidate" style="padding-left: 5%; padding-right: 5%;">
                        <h3 style="padding-top: 2%;">Candidate Name: <b>{{ $item->full_name }}</b></h3>
                        <br>
                        <h3>Manifesto: <b>{{ $item->manifesto }}</b></h3>
                        <br>
                        <h3 style="padding-bottom: 2%;">Video Link: <a
                                href="{{ $item->video_link }}"><b>{{ $item->video_link }}</b></a></h3>
                    </div>
                    <center style="padding-top: 2%; padding-bottom: 2%">
                        <a href="">
                            <button class="btn btn-danger">Rate</button>
                        </a>
                    </center>
                </div>
            @endif
        @endforeach
    </section>
@endsection
