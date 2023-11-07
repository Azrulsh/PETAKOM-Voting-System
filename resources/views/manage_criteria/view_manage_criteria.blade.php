@extends('layouts.default')

@section('contents')
    <div class="manage-criteria">
        <h2>List of Criteria</h2>
        <table id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Criteria Name</th>
                    <th style="text-align: center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($criteria as $criteria)
                    <tr>
                        <td>{{ $criteria->id }}</td>
                        <td>{{ $criteria->name }}</td>
                        <td style="text-align: center">
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                data-bs-target="#modal-edit-{{ $criteria->id }}">Edit</button>
                            &nbsp;&nbsp;
                            <a href="manage-criteria/{{ $criteria->id }}/delete" onclick="return confirm('Are You Sure?')">
                                <button class="btn btn-danger" type="button">Delete</button>
                            </a>
                        </td>
                    </tr>
                    <!-- Modal Edit -->
                    <div class="modal fade" id="modal-edit-{{ $criteria->id }}" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="/manage-criteria/{{ $criteria->id }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Criteria</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Criteria Name</span>
                                            <input type="text" class="form-control" placeholder="Ex: Nafiz Mansor"
                                                aria-label="name" aria-describedby="basic-addon1" name="name"
                                                value="{{ $criteria->name }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <center style="padding-right: 150px">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-add-criteria">
            Add
        </button>
    </center>

    <!-- Modal Add -->
    <div class="modal fade" id="modal-add-criteria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/manage-criteria" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Criteria</h1>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Criteria Name</span>
                            <input type="text" class="form-control" placeholder="Ex: Nafiz Mansor" aria-label="name"
                                aria-describedby="basic-addon1" name="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
