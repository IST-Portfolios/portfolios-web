@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Candidate Management</h3>
            </div>
            <div class="panel-body">
                <div class="clearfix">
                    <div class="col-md-4">
                        <h4 class="panel-title text-center">Rejected</h4>
                        <hr>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Activity</th>
                            </tr>
                            </thead>
                            <tbody id="mylist">
                            @foreach($rejected as $e)
                                <tr class="danger" style="cursor:pointer;" data-toggle="modal" data-target="#candidature"
                                    data-id="{{ $e->id }}"
                                    data-candidate="{{$e->entity->name}}"
                                    data-title = "{{  $e->activity->title }}"
                                    data-motivation ="{{ $e->motivation }}"
                                >
                                    <td> {{$e->entity->name}}</td>
                                    <td> {{ $e->activity->title}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h4 class="panel-title text-center">Pending</h4>
                        <hr>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Activity</th>
                            </tr>
                            </thead>
                            <tbody class="mylist">
                            @foreach($pending as $e)
                                <tr class="warning" style="cursor:pointer;" data-toggle="modal" data-target="#candidature"
                                    data-id="{{ $e->id }}"
                                    data-candidate="{{$e->entity->name}}"
                                    data-title = "{{  $e->activity->title  }}"
                                    data-motivation ="{{ $e->motivation }}"
                                >
                                    <td>  {{$e->entity->name}}</td>
                                    <td> {{ $e->activity->title }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                    <div class="col-md-4">
                        <h4 class="panel-title text-center">Accepted</h4>
                        <hr>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Candidate</th>
                                <th>Activity</th>
                            </tr>
                            </thead>
                            <tbody class="mylist">
                            @foreach($accepted as $e)
                                <tr class="success" style="cursor:pointer;" data-toggle="modal" data-target="#candidature"
                                    data-id="{{ $e->id }}"
                                    data-candidate="{{$e->entity->name}}"
                                    data-title = "{{ $e->activity->title }}"
                                    data-motivation ="{{ $e->motivation }}"
                                >
                                    <td> {{$e->entity->name}}  </td>
                                    <td> {{$e->activity->title}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="candidature" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="activityTitle"></h4>
                    <h4 class="modal-title" id="candidateName"></h4>
                </div>
                <div class="modal-body">
                    <h4>Motivation:</h4>
                    <p id="motivation"></p>
                    <hr>
                    <div class="clearfix">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 text-center">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger btn-sm" id="rejectBtn">Reject</button>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-success btn-sm" id="acceptBtn">Accept</button>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ URL::asset("js/candidate.js") }}" ></script>
@endsection






