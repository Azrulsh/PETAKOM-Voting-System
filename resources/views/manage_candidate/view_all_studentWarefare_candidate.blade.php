@extends('layouts.default')

@section('contents')
    <center style="padding-top: 2%; padding-right: 8%">
        <h2>Candidate</h2>
    </center>
    <section class="content-candidate">
        @foreach ($candidates as $item)
            @if ($item->position == 'Student Warefare')
                @php
                    $hasRated = false;
                    foreach ($voterRate as $rate) {
                        if ($rate->voter_name == Auth::user()->name && $rate->candidate_name == $item->full_name) {
                            $hasRated = true;
                            break;
                        }
                    }
                @endphp

                @if (!$hasRated)
                    <div class="card-candidate" id="card-{{ $item->id }}">
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
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-rate-{{ $item->id }}-candidate">
                                Rate
                            </button>
                        </center>
                    </div>
                @endif

                <!-- Modal Add -->
                <div class="modal fade" id="modal-rate-{{ $item->id }}-candidate" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <form action="/voter/rateCandidate/student-warefare" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Candidate Name:
                                        {{ $item->full_name }}
                                    </h1>
                                </div>
                                <div class="modal-body">
                                    <center>
                                        <h3>Please Rate Based On Criteria</h3>
                                    </center>
                                    <br>

                                    <table id="table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="col-1">No.</th>
                                                <th class="col-3">Criteria Name</th>
                                                <th>Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($criterias as $criteria)
                                                <tr>
                                                    <td>{{ $criteria->id }}</td>
                                                    <td>{{ $criteria->name }}</td>
                                                    <td>
                                                        <div class="row-4 rating">
                                                            <input type="text" hidden value="{{ $item->full_name }}"
                                                                name="candidate_name">
                                                            <input type="text" hidden value="{{ Auth::user()->name }}"
                                                                name="voter_name">
                                                            <input type="text" hidden value="{{ $criteria->name }}"
                                                                name="criteria_name[{{ $criteria->id }}]">
                                                            <label>
                                                                <input type="radio" name="rate[{{ $criteria->id }}]"
                                                                    value="1" />
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rate[{{ $criteria->id }}]"
                                                                    value="2" />
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rate[{{ $criteria->id }}]"
                                                                    value="3" />
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rate[{{ $criteria->id }}]"
                                                                    value="4" />
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="rate[{{ $criteria->id }}]"
                                                                    value="5" />
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                                <span class="icon">★</span>
                                                            </label>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                            <script>
                                                $(':radio').change(function() {
                                                    console.log('New star rating: ' + this.value);
                                                });
                                            </script>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
    </section>
@endsection
