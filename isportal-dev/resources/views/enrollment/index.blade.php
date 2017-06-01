@extends('layouts.app')

@section('content')
    <script src="{{ URL::asset("js/enrollment.js") }}"></script>
    <div class="clearfix">
        <div class="col-xs-10 col-xs-offset-1">
            @if(count(Auth::user()->activities) > 0 )
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Self Proposed Activities</h3>
                </div>
                <div class="panel-body">
                    <p> You have proposed {{count(Auth::user()->activities) }} activities out of 3.</p>
                    <hr>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Activity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Auth::user()->activities as $activity)
                                <tr
                                    @if($activity->state == "pending")
                                        class="warning"
                                    @elseif( $activity->state =="rejected")
                                        class="danger"
                                    @else
                                        class="success"
                                    @endif
                                >
                                    <td>{{$activity->title}}</td>
                                    <td>{{$activity->state}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div class="panel panel-primary">
                <div class = "panel-heading">
                    <h3 class="panel-title text-center"> Enrollments </h3>
                </div>
                <div class = "panel-body">
                    @if(count($enrollments) > 1)
                        <p> You have enrolled in {{ count($enrollments) }} activities out of 3 possible enrollments</p>
                    @else
                        <p> You have enrolled in {{ count($enrollments) }} activity out of 3 possible enrollments</p>
                    @endif
                    <hr>
                    <table  class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Activity</th>
                        </tr>
                        </thead>
                        <tbody id="table-body">
                        @foreach($enrollments as $e)
                            <tr data-id="{{$e->id}}" data-priority="{{ $e->priority }}" data-title="{{ $e->activity->title }}"
                            @if($e->state == 'pending')
                                class = "warning"
                            @elseif($e->state == 'rejected')
                                class = "danger"
                            @else
                                class = "success"
                            @endif
                            >
                                <td>{{ $e->priority  }}</td>
                                <td>{{ $e->state  }}</td>
                                <td>
                                    {{ $e->activity->title  }}
                                    <button type="button" class="btn btn-danger btn-sm pull-right deleteBtn">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="clearfix">
                        <div class=" col-md-4 col-md-offset-4" >
                            @if(count($enrollments) >0)
                                <button id="editBtn" class="btn btn-primary text-center">Edit Priorities</button>
                            @endif
                            <button id="cancelBtn" class="btn btn-default" style="display: none">Cancel</button>
                            <button id="saveChangesBtn" class="btn btn-default" style="display: none">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
