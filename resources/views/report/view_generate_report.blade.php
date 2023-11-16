@extends('layouts.default')

@section('contents')
    <div class="manage-candidate" style="padding-bottom: 10%">
        <table id="table">
            <thead>
                <tr>
                    <th colspan="2" style="background-color: gray;">Final Result</th>
                    <th colspan="{{ count($criterias) }}" style="background-color: gray;">Criteria</th>
                    <th colspan="2" style="background-color: gray;"></th>
                </tr>
                <tr>
                    <th>Voter Name</th>
                    <th>Candidate Name</th>
                    @foreach ($criterias as $criteria)
                        <th style="width: 15%">{{ $criteria->name }}</th>
                    @endforeach
                    <th>Total</th>
                    <th>Rank</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $groupedResults = [];

                    // Group and calculate total for each unique voter-candidate pair
                    foreach ($voterRate as $voter) {
                        $key = $voter->voter_name . '-' . $voter->candidate_name;
                        if (!isset($groupedResults[$key])) {
                            $groupedResults[$key] = [
                                'voter_name' => $voter->voter_name,
                                'candidate_name' => $voter->candidate_name,
                                'total' => 0,
                                'criteria_ratings' => [],
                            ];
                        }
                        $groupedResults[$key]['criteria_ratings'][$voter->criteria_id] = $voter->rate;
                    }

                    // Calculate total and rank for each unique voter-candidate pair
                    foreach ($groupedResults as &$result) {
                        $result['total'] = array_sum($result['criteria_ratings']);
                    }

                    // Sort the results array based on total in descending order
                    usort($groupedResults, function ($a, $b) {
                        return $b['total'] - $a['total'];
                    });

                    $rank = 1; // Initialize the rank to 1

                    // Assign rank to each unique voter-candidate pair
                    foreach ($groupedResults as &$result) {
                        $result['rank'] = $rank++;
                    }
                @endphp

                @foreach ($groupedResults as $result)
                    <tr>
                        <td>{{ $result['voter_name'] }}</td>
                        <td>{{ $result['candidate_name'] }}</td>

                        @foreach ($criterias as $criteria)
                            @php
                                $ratedValue = isset($result['criteria_ratings'][$criteria->id]) ? $result['criteria_ratings'][$criteria->id] : 0;
                            @endphp

                            <td>{{ $ratedValue }}</td>
                        @endforeach

                        <td>{{ $result['total'] }}</td>
                        <td>{{ $result['rank'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    @foreach ($criterias as $criteria)
                        <th style="width: 15%">{{ $criteria->name }}</th>
                    @endforeach
                    <th>Total</th>
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
                            @php
                                $totalScore = 0;
                            @endphp

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

                @php
                    $totalScore += $ratedValue;
                @endphp

                <td>{{ $hasRated ? $ratedValue : '0' }}</td>
            @endforeach

            <td>{{ $totalScore }}</td>
        </tr>
    @endforeach
@endif
</tbody>
</table>


<center style="padding-right: 150px">
<!-- Button trigger modal -->
<a href="/admin/report/generate/result">
<button type="button" class="btn btn-danger">
    GENERATE REPORT
</button>
</a>
</center>

</div>
@endsection
