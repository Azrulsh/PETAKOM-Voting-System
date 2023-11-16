@extends('layouts.default')

@section('contents')
    <div class="manage-candidate">
        <h2>Candidate Info</h2>
        <table id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Position</th>
                    @foreach ($criterias as $criteria)
                        <th style="width: 15%">{{ $criteria->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @if (DB::table('manage_candidates')->count() == 0)
                    <tr>
                        <td colspan="{{ 3 + count($criterias) }}">You need to create a Candidate first.</td>
                    </tr>
                @else
                    @foreach ($candidates as $candidate)
                        <tr>
                            <td>{{ $candidate->id }}</td>
                            <td>{{ $candidate->full_name }}</td>
                            <td>{{ $candidate->position }}</td>

                            @foreach ($criterias as $criteria)
                                @php
                                    $hasRated = false;
                                    $ratedValue = 0;
                                @endphp

                                @foreach ($totalStudentWarefare as $rate)
                                    @if ($rate->candidate_name == $candidate->full_name && $criteria->name == $rate->name)
                                        @php
                                            $hasRated = true;
                                            $ratedValue = $rate->rate;
                                        @endphp
                                    @break
                                @endif
                            @endforeach

                            @foreach ($totalWelfareExco as $rate)
                                @if ($rate->candidate_name == $candidate->full_name && $criteria->name == $rate->name)
                                    @php
                                        $hasRated = true;
                                        $ratedValue = $rate->rate;
                                    @endphp
                                @break
                            @endif
                        @endforeach

                        @foreach ($totalSportsExco as $rate)
                            @if ($rate->candidate_name == $candidate->full_name && $criteria->name == $rate->name)
                                @php
                                    $hasRated = true;
                                    $ratedValue = $rate->rate;
                                @endphp
                            @break
                        @endif
                    @endforeach

                    @foreach ($totalSecretary as $rate)
                        @if ($rate->candidate_name == $candidate->full_name && $criteria->name == $rate->name)
                            @php
                                $hasRated = true;
                                $ratedValue = $rate->rate;
                            @endphp
                        @break
                    @endif
                @endforeach

                <td>{{ $hasRated ? $ratedValue : '0' }}</td>
            @endforeach
        </tr>
    @endforeach
@endif
</tbody>
</table>

<center style="padding-right: 150px">
<!-- Button trigger modal -->
<a href="/admin/report/generate">
<button type="button" class="btn btn-danger">
    NEXT
</button>
</a>
</center>

</div>
@endsection
