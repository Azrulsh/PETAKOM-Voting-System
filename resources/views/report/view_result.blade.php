@extends('layouts.default')

@section('contents')
    <div class="manage-candidate">
        <h2>ELECTION FINAL RESULT!!</h2>
        <br>
        <h2>CONGRATULATION ON THE CANDIDATE</h2>
        <table id="table">
            <thead>
                <tr>
                    <th></th>
                    <th>POSITION</th>
                    <th>CANDIDATE NAME</th>
                    <th>CANDIDATE MATRIC</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 1;
                @endphp
                <tr>
                    <td>{{$index++}}</td>
                    <td>Student Affair</td>
                    <td>{{ $candidateNameSW }}</td>
                    <td>{{ $candidateIdSW }}</td>
                </tr>
                <tr>
                    <td>{{$index++}}</td>
                    <td>Welfare Exco</td>
                    <td>{{ $candidateNameWE }}</td>
                    <td>{{ $candidateIdWE }}</td>
                </tr>
                <tr>
                    <td>{{$index++}}</td>
                    <td>Sports Exco</td>
                    <td>{{ $candidateNameSE }}</td>
                    <td>{{ $candidateIdSE }}</td>
                </tr>
                <tr>
                    <td>{{$index++}}</td>
                    <td>Secretary</td>
                    <td>{{ $candidateNameS }}</td>
                    <td>{{ $candidateIdS }}</td>
                </tr>
            </tbody>
        </table>
    @endsection
